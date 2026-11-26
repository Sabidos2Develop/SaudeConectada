<?php

declare(strict_types=1);

use SaudeConectada\Backend\Application;
use SaudeConectada\Backend\Http\Request;
use SaudeConectada\Backend\Http\Response;

require dirname(__DIR__) . '/vendor/autoload.php';

try {
    $response = (new Application())->handle(Request::fromGlobals());
    $response->send();
} catch (Throwable $exception) {
    error_log(sprintf('[Saude Conectada API] Erro não tratado: %s', $exception::class));

    Response::json([
        'error' => [
            'code' => 'internal_server_error',
            'message' => 'Ocorreu um erro interno.',
        ],
    ], 500)->send();
}
