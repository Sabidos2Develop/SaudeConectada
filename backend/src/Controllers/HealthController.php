<?php

declare(strict_types=1);

namespace SaudeConectada\Backend\Controllers;

use SaudeConectada\Backend\Http\Request;
use SaudeConectada\Backend\Http\Response;

final class HealthController
{
    public function __invoke(Request $request): Response
    {
        return Response::json([
            'status' => 'ok',
            'service' => 'saude-conectada-api',
        ]);
    }
}
