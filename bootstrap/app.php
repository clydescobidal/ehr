<?php

use App\Enums\ExceptionStatus;
use App\Http\Middleware\JSONResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: [
            __DIR__.'/../routes/auth.php'
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(JSONResponse::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {
            $status = ExceptionStatus::fromException($e);


            $data = [
                'status' => [
                    'error' => true,
                    'message' => $e->getMessage(),
                    'code' => $status,
                ],
                'data' => null,
            ];

            if (config('app.debug')) {
                $data['status']['trace'] = $e->getTrace();
            }
    
            return response()->json($data, $status);
        });
    })->create();
