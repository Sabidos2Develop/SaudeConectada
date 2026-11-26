<?php

declare(strict_types=1);

use SaudeConectada\Backend\Application;
use SaudeConectada\Backend\Http\Request;

require dirname(__DIR__) . '/backend/vendor/autoload.php';

function expect(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$application = new Application();

$healthResponse = $application->handle(new Request('GET', '/health'));
$healthBody = json_decode($healthResponse->body(), true, 512, JSON_THROW_ON_ERROR);

expect($healthResponse->statusCode() === 200, 'GET /health deve retornar HTTP 200.');
expect(
    $healthResponse->header('Content-Type') === 'application/json; charset=utf-8',
    'A resposta deve declarar JSON em UTF-8.'
);
expect(($healthBody['status'] ?? null) === 'ok', 'GET /health deve indicar status ok.');
expect(
    ($healthBody['service'] ?? null) === 'saude-conectada-api',
    'GET /health deve identificar o serviço.'
);

$notFoundResponse = $application->handle(new Request('GET', '/rota-inexistente'));
$notFoundBody = json_decode($notFoundResponse->body(), true, 512, JSON_THROW_ON_ERROR);

expect($notFoundResponse->statusCode() === 404, 'Rota inexistente deve retornar HTTP 404.');
expect(
    ($notFoundBody['error']['code'] ?? null) === 'route_not_found',
    'Rota inexistente deve retornar código de erro padronizado.'
);

$methodResponse = $application->handle(new Request('POST', '/health'));
expect($methodResponse->statusCode() === 404, 'Método não registrado não deve executar a rota.');

echo "OK: health check, resposta JSON e roteamento 404.\n";
