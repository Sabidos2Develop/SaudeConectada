<?php

declare(strict_types=1);

use SaudeConectada\Backend\Validation\Telemetry\TelemetryMessageValidator;

require dirname(__DIR__) . '/backend/vendor/autoload.php';

function expect(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function payloadObject(array $payload): object
{
    return json_decode(json_encode($payload, JSON_THROW_ON_ERROR), false, 512, JSON_THROW_ON_ERROR);
}

$validator = new TelemetryMessageValidator();
$tests = 0;

$validPayloads = [
    [
        'schema_version' => '1.0', 'device_id' => 'smartband-01', 'patient_id' => 'pat-9921',
        'metric' => 'spo2', 'value' => 98, 'unit' => '%', 'timestamp' => '2026-11-17T17:48:29.753Z',
    ],
    [
        'schema_version' => '1.0', 'device_id' => 'smartband-01', 'patient_id' => 'pat-9921',
        'metric' => 'heart_rate', 'value' => 85, 'unit' => 'bpm', 'timestamp' => '2026-11-17T14:48:29-03:00',
    ],
    [
        'schema_version' => '1.0', 'device_id' => 'smartband-01', 'patient_id' => 'pat-9921',
        'metric' => 'temperature', 'value' => 36.5, 'unit' => '°C', 'timestamp' => '2026-11-17T17:48:29Z',
    ],
    [
        'schema_version' => '1.0', 'device_id' => 'smartband-01', 'patient_id' => 'pat-9921',
        'metric' => 'blood_pressure', 'value' => (object) ['systolic' => 120, 'diastolic' => 80],
        'unit' => 'mmHg', 'timestamp' => '2026-11-17T17:48:29.7+00:00',
    ],
    [
        'schema_version' => '1.0', 'device_id' => 'smartband-01', 'patient_id' => 'pat-9921',
        'metric' => 'fall_sensor', 'value' => true, 'timestamp' => '2026-11-17T17:48:29Z',
    ],
    [
        'schema_version' => '1.0', 'device_id' => 'smartband-01', 'patient_id' => 'pat-9921',
        'metric' => 'panic_button', 'value' => false, 'timestamp' => '2026-11-17T17:48:29Z',
    ],
];

foreach ($validPayloads as $index => $payload) {
    $result = $validator->validate(payloadObject($payload));
    expect($result->isValid(), 'Payload válido ' . ($index + 1) . ' foi rejeitado: ' . json_encode($result->errors()));
    expect($result->errors() === [], 'Payload válido não deve retornar erros.');
    $tests++;
}

$invalidCases = [];
$missingPatient = $validPayloads[0];
unset($missingPatient['patient_id']);
$invalidCases[] = [$missingPatient, 'required', 'Campo obrigatório ausente deve ser rejeitado.'];

$wrongVersion = $validPayloads[0];
$wrongVersion['schema_version'] = '2.0';
$invalidCases[] = [$wrongVersion, 'unsupported_version', 'Versão incompatível deve ser rejeitada.'];

$emptyDevice = $validPayloads[0];
$emptyDevice['device_id'] = '  ';
$invalidCases[] = [$emptyDevice, 'empty', 'Identificador vazio deve ser rejeitado.'];

$unknownMetric = $validPayloads[0];
$unknownMetric['metric'] = 'blood_glucose';
$invalidCases[] = [$unknownMetric, 'unknown_metric', 'Métrica desconhecida deve ser rejeitada.'];

$stringNumber = $validPayloads[0];
$stringNumber['value'] = '98';
$invalidCases[] = [$stringNumber, 'invalid_type', 'Número serializado como string deve ser rejeitado.'];

$wrongUnit = $validPayloads[0];
$wrongUnit['unit'] = 'bpm';
$invalidCases[] = [$wrongUnit, 'invalid_unit', 'Unidade incompatível deve ser rejeitada.'];

$missingUnit = $validPayloads[0];
unset($missingUnit['unit']);
$invalidCases[] = [$missingUnit, 'required', 'Unidade ausente em métrica física deve ser rejeitada.'];

$eventWithUnit = $validPayloads[4];
$eventWithUnit['unit'] = '';
$invalidCases[] = [$eventWithUnit, 'not_allowed', 'Evento com unidade deve ser rejeitado.'];

$timestampWithoutTimezone = $validPayloads[0];
$timestampWithoutTimezone['timestamp'] = '2026-11-17T17:48:29';
$invalidCases[] = [$timestampWithoutTimezone, 'invalid_format', 'Timestamp sem timezone deve ser rejeitado.'];

$invalidCalendarDate = $validPayloads[0];
$invalidCalendarDate['timestamp'] = '2026-02-30T17:48:29Z';
$invalidCases[] = [$invalidCalendarDate, 'invalid_format', 'Data inexistente deve ser rejeitada.'];

$eventWithInteger = $validPayloads[4];
$eventWithInteger['value'] = 1;
$invalidCases[] = [$eventWithInteger, 'invalid_type', 'Evento com número em vez de boolean deve ser rejeitado.'];

$pressureAsString = $validPayloads[3];
$pressureAsString['value'] = '120/80';
$invalidCases[] = [$pressureAsString, 'invalid_type', 'Pressão serializada como string deve ser rejeitada.'];

$pressureMissingDiastolic = $validPayloads[3];
$pressureMissingDiastolic['value'] = (object) ['systolic' => 120];
$invalidCases[] = [$pressureMissingDiastolic, 'required', 'Pressão sem componente diastólico deve ser rejeitada.'];

$pressureWithNumericString = $validPayloads[3];
$pressureWithNumericString['value'] = (object) ['systolic' => '120', 'diastolic' => 80];
$invalidCases[] = [$pressureWithNumericString, 'invalid_type', 'Pressão com componente string deve ser rejeitada.'];

$unknownTopLevel = $validPayloads[0];
$unknownTopLevel['unexpected'] = 'value';
$invalidCases[] = [$unknownTopLevel, 'unknown_field', 'Campo adicional deve ser rejeitado.'];

$unknownPressureField = $validPayloads[3];
$unknownPressureField['value'] = (object) ['systolic' => 120, 'diastolic' => 80, 'mean' => 93];
$invalidCases[] = [$unknownPressureField, 'unknown_field', 'Campo adicional na pressão deve ser rejeitado.'];

foreach ($invalidCases as [$payload, $expectedCode, $message]) {
    $result = $validator->validate(payloadObject($payload));
    $codes = array_column($result->errors(), 'code');
    expect(!$result->isValid(), $message);
    expect(in_array($expectedCode, $codes, true), $message . ' Código esperado: ' . $expectedCode);
    $tests++;
}

$rootArray = $validator->validate([]);
expect(!$rootArray->isValid(), 'Array raiz deve ser rejeitado; o contrato exige objeto JSON.');
expect(($rootArray->errors()[0]['field'] ?? null) === '$', 'Erro de raiz deve identificar o payload.');
$tests++;

echo 'OK: ' . $tests . " cenários de validação de telemetria.\n";
