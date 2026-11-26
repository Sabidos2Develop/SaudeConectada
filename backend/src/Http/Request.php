<?php

declare(strict_types=1);

namespace SaudeConectada\Backend\Http;

final class Request
{
    private string $method;
    private string $path;
    private string $body;

    public function __construct(string $method, string $path, string $body = '')
    {
        $this->method = strtoupper($method);
        $this->path = self::normalisePath($path);
        $this->body = $body;
    }

    public static function fromGlobals(): self
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($requestUri, PHP_URL_PATH);
        $body = file_get_contents('php://input');

        return new self(
            $_SERVER['REQUEST_METHOD'] ?? 'GET',
            is_string($path) && $path !== '' ? $path : '/',
            $body === false ? '' : $body
        );
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function body(): string
    {
        return $this->body;
    }

    private static function normalisePath(string $path): string
    {
        $normalised = parse_url($path, PHP_URL_PATH);

        if (!is_string($normalised) || $normalised === '') {
            return '/';
        }

        $normalised = '/' . ltrim($normalised, '/');
        $normalised = rtrim($normalised, '/');

        return $normalised === '' ? '/' : $normalised;
    }
}
