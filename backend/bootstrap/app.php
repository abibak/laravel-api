<?php

use App\Exceptions\APIExceptionHandler;
use App\Http\Middleware\ValidateAPIRequest;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Http\Request;

$apiExceptions = [
    APIExceptionHandler::class
];

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions) use ($apiExceptions) {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*');
        });

        $exceptions->render(function (Throwable $e, Request $request) use ($apiExceptions) {
            if ($request->is('api/*')) {
                foreach ($apiExceptions as $handler) {
                    $response = $handler::handle($request, $e);

                    if ($response) {
                        return $response;
                    }
                }
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if (config('app.debug') && !$request->is('api/*')) {
                $whoops = new \Whoops\Run;
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
                return response($whoops->handleException($e), 500);
            }
        });
    })->create();
