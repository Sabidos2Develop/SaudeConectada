<?php

declare(strict_types=1);

namespace SaudeConectada\Backend;

use SaudeConectada\Backend\Controllers\HealthController;
use SaudeConectada\Backend\Http\Request;
use SaudeConectada\Backend\Http\Response;
use SaudeConectada\Backend\Http\Router;

final class Application
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->router->add('GET', '/health', new HealthController());
    }

    public function handle(Request $request): Response
    {
        return $this->router->dispatch($request);
    }
}
