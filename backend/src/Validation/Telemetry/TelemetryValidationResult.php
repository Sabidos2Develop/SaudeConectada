<?php

declare(strict_types=1);

namespace SaudeConectada\\Backend\\Validation\\Telemetry;

final class TelemetryValidationResult
{
    /**
     * @param list<array{field: string, code: string, message: string}> $errors
     */
    private function __construct(
        private bool $valid,
        private array $errors
    ) {
    }

    public static function valid(): self
    {
        return new self(true, []);
    }

    /**
     * @param list<array{field: string, code: string, message: string}> $errors
     */
    public static function invalid(array $errors): self
    {
        return new self(false, $errors);
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    /**
     * @return list<array{field: string, code: string, message: string}>
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
