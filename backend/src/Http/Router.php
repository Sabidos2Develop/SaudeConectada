<?php

declare(strict_types=1);

namespace SaudeConectada\Backend\Http;

use LogicException;

final class Router
{
    /** @var array<string, callable(Request): Response> */
    private array $routes = [];

    /** @param callable(Request): Response $handler */
    public function add(string $method, string $path, callable $handler): void
    {
        $key = strtoupper($method) . ' ' . self::normalisePath($path);
        $this->routes[$key] = $handler;
    }

    public function dispatch(Request $request): Response
    {
        $key = $request->method() . ' ' . $request->path();
        $handler = $this->routes[$key] ?? null;

        if ($handler === null) {
            return Response::json([
                'error' => [
                    'code' => 'route_not_found',
                    'message' => 'A rota solicitada não foi encontrada.',
                ],
            ], 404);
        }

        $response = $handler($request);

        if (!$response instanceof Response) {
            throw new LogicException('Os handlers devem retornar uma instância de Response.');
        }

        return $response;
    }

    private static function normalisePath(string $path): string
    {
        $normalised = '/' . ltrim($path, '/');
        $normalised = rtrim($normalised, '/');

        return $normalised === '' ? '/' : $normalised;
    }
}
