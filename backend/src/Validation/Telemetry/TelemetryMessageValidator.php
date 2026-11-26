<?php

declare(strict_types=1);

namespace SaudeConectada\Backend\Validation\Telemetry;

use stdClass;

final class TelemetryMessageValidator
{
    private const SCHEMA_VERSION = '1.0';

    /** @var list<string> */
    private const REQUIRED_FIELDS = [
        'schema_version',
        'device_id',
        'patient_id',
        'metric',
        'value',
        'timestamp',
    ];

    /** @var list<string> */
    private const ALLOWED_FIELDS = [
        'schema_version',
        'device_id',
        'patient_id',
        'metric',
        'value',
        'unit',
        'timestamp',
    ];

    /** @var array<string, string> */
    private const PHYSICAL_METRICS = [
        'spo2' => '%',
        'heart_rate' => 'bpm',
        'temperature' => '°C',
        'blood_pressure' => 'mmHg',
    ];

    /** @var list<string> */
    private const EVENT_METRICS = [
        'fall_sensor',
        'panic_button',
    ];

    /**
     * Validate an object produced by json_decode($json) (without associative mode).
     * No clinical thresholds, authorization, persistence or HTTP concerns are handled here.
     */
    public function validate(mixed $payload): TelemetryValidationResult
    {
        if (!$payload instanceof stdClass) {
            return TelemetryValidationResult::invalid([
                $this->error('$', 'invalid_type', 'A mensagem deve ser um objeto JSON.'),
            ]);
        }

        $errors = [];
        $fields = get_object_vars($payload);

        foreach (array_diff(array_keys($fields), self::ALLOWED_FIELDS) as $field) {
            $errors[] = $this->error((string) $field, 'unknown_field', 'Campo não permitido na versão 1.0.');
        }

        foreach (self::REQUIRED_FIELDS as $field) {
            if (!property_exists($payload, $field)) {
                $errors[] = $this->error($field, 'required', 'Campo obrigatório ausente.');
            }
        }

        $this->validateSchemaVersion($payload, $errors);
        $this->validateIdentifier($payload, 'device_id', $errors);
        $this->validateIdentifier($payload, 'patient_id', $errors);
        $this->validateTimestamp($payload, $errors);

        $metric = null;
        if (property_exists($payload, 'metric')) {
            if (!is_string($payload->metric)) {
                $errors[] = $this->error('metric', 'invalid_type', 'A métrica deve ser uma string.');
            } else {
                $metric = $payload->metric;
                if (!isset(self::PHYSICAL_METRICS[$metric]) && !in_array($metric, self::EVENT_METRICS, true)) {
                    $errors[] = $this->error('metric', 'unknown_metric', 'Métrica não reconhecida no contrato 1.0.');
                    $metric = null;
                }
            }
        }

        if ($metric !== null) {
            $this->validateMetricValue($payload, $metric, $errors);
            $this->validateUnit($payload, $metric, $errors);
        }

        return $errors === []
            ? TelemetryValidationResult::valid()
            : TelemetryValidationResult::invalid($errors);
    }

    /** @param list<array{field: string, code: string, message: string}> $errors */
    private function validateSchemaVersion(stdClass $payload, array &$errors): void
    {
        if (!property_exists($payload, 'schema_version')) {
            return;
        }

        if (!is_string($payload->schema_version)) {
            $errors[] = $this->error('schema_version', 'invalid_type', 'A versão do contrato deve ser uma string.');
            return;
        }

        if ($payload->schema_version !== self::SCHEMA_VERSION) {
            $errors[] = $this->error('schema_version', 'unsupported_version', 'Versão do contrato não suportada.');
        }
    }

    /** @param list<array{field: string, code: string, message: string}> $errors */
    private function validateIdentifier(stdClass $payload, string $field, array &$errors): void
    {
        if (!property_exists($payload, $field)) {
            return;
        }

        $value = $payload->{$field};
        if (!is_string($value)) {
            $errors[] = $this->error($field, 'invalid_type', 'O identificador deve ser uma string.');
            return;
        }

        if (trim($value) === '') {
            $errors[] = $this->error($field, 'empty', 'O identificador não pode estar vazio.');
        }
    }

    /** @param list<array{field: string, code: string, message: string}> $errors */
    private function validateTimestamp(stdClass $payload, array &$errors): void
    {
        if (!property_exists($payload, 'timestamp')) {
            return;
        }

        if (!is_string($payload->timestamp)) {
            $errors[] = $this->error('timestamp', 'invalid_type', 'O timestamp deve ser uma string ISO 8601.');
            return;
        }

        if (!$this->isValidIso8601WithTimezone($payload->timestamp)) {
            $errors[] = $this->error('timestamp', 'invalid_format', 'O timestamp deve ser uma data/hora ISO 8601 válida com timezone explícito.');
        }
    }

    private function isValidIso8601WithTimezone(string $value): bool
    {
        if (preg_match(
            '/\A(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(?:\.(\d+))?(Z|[+-]\d{2}:\d{2})\z/',
            $value,
            $matches
        ) !== 1) {
            return false;
        }

        $year = (int) $matches[1];
        $month = (int) $matches[2];
        $day = (int) $matches[3];
        $hour = (int) $matches[4];
        $minute = (int) $matches[5];
        $second = (int) $matches[6];

        if (!checkdate($month, $day, $year) || $hour > 23 || $minute > 59 || $second > 59) {
            return false;
        }

        if ($matches[8] !== 'Z') {
            $offsetHour = (int) substr($matches[8], 1, 2);
            $offsetMinute = (int) substr($matches[8], 4, 2);
            if ($offsetHour > 23 || $offsetMinute > 59) {
                return false;
            }
        }

        return true;
    }

    /** @param list<array{field: string, code: string, message: string}> $errors */
    private function validateMetricValue(stdClass $payload, string $metric, array &$errors): void
    {
        if (!property_exists($payload, 'value')) {
            return;
        }

        $value = $payload->value;

        if (isset(self::PHYSICAL_METRICS[$metric]) && $metric !== 'blood_pressure') {
            if (!$this->isFiniteJsonNumber($value)) {
                $errors[] = $this->error('value', 'invalid_type', 'O valor da métrica deve ser um número JSON finito.');
            }
            return;
        }

        if ($metric === 'blood_pressure') {
            $this->validateBloodPressure($value, $errors);
            return;
        }

        if (!is_bool($value)) {
            $errors[] = $this->error('value', 'invalid_type', 'O valor do evento deve ser booleano.');
        }
    }

    /** @param list<array{field: string, code: string, message: string}> $errors */
    private function validateBloodPressure(mixed $value, array &$errors): void
    {
        if (!$value instanceof stdClass) {
            $errors[] = $this->error('value', 'invalid_type', 'A pressão arterial deve ser um objeto JSON.');
            return;
        }

        $bloodPressure = get_object_vars($value);
        foreach (array_diff(array_keys($bloodPressure), ['systolic', 'diastolic']) as $field) {
            $errors[] = $this->error('value.' . $field, 'unknown_field', 'Campo não permitido na pressão arterial.');
        }

        foreach (['systolic', 'diastolic'] as $component) {
            if (!property_exists($value, $component)) {
                $errors[] = $this->error('value.' . $component, 'required', 'Componente obrigatório da pressão arterial ausente.');
                continue;
            }

            if (!$this->isFiniteJsonNumber($value->{$component})) {
                $errors[] = $this->error('value.' . $component, 'invalid_type', 'O componente deve ser um número JSON finito.');
            }
        }
    }

    /** @param list<array{field: string, code: string, message: string}> $errors */
    private function validateUnit(stdClass $payload, string $metric, array &$errors): void
    {
        if (isset(self::PHYSICAL_METRICS[$metric])) {
            if (!property_exists($payload, 'unit')) {
                $errors[] = $this->error('unit', 'required', 'Unidade obrigatória para esta métrica.');
                return;
            }

            if (!is_string($payload->unit)) {
                $errors[] = $this->error('unit', 'invalid_type', 'A unidade deve ser uma string.');
                return;
            }

            if ($payload->unit !== self::PHYSICAL_METRICS[$metric]) {
                $errors[] = $this->error('unit', 'invalid_unit', 'Unidade incompatível com a métrica informada.');
            }
            return;
        }

        if (property_exists($payload, 'unit')) {
            $errors[] = $this->error('unit', 'not_allowed', 'Eventos não devem enviar unidade.');
        }
    }

    private function isFiniteJsonNumber(mixed $value): bool
    {
        return (is_int($value) || is_float($value)) && is_finite((float) $value);
    }

    /** @return array{field: string, code: string, message: string} */
    private function error(string $field, string $code, string $message): array
    {
        return [
            'field' => $field,
            'code' => $code,
            'message' => $message,
        ];
    }
}
