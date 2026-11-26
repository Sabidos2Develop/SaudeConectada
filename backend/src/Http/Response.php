<?php

declare(strict_types=1);

namespace SaudeConectada\Backend\Http;

final class Response
{
    /** @var array<string, string> */
    private array $headers;

    /** @param array<string, string> $headers */
    public function __construct(
        private int $statusCode,
        array $headers,
        private string $body
    ) {
        $this->headers = $headers;
    }

    /** @param array<string, mixed> $data */
    public static function json(array $data, int $statusCode = 200): self
    {
        $body = json_encode(
            $data,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
        );

        return new self(
            $statusCode,
            ['Content-Type' => 'application/json; charset=utf-8'],
            $body
        );
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function header(string $name): ?string
    {
        foreach ($this->headers as $headerName => $value) {
            if (strcasecmp($headerName, $name) === 0) {
                return $value;
            }
        }

        return null;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value);
        }

        echo $this->body;
    }
}
