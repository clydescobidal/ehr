<?php

use App\Enums\ExceptionStatus;
use App\Http\Middleware\HasTenantRoles;
use App\Http\Middleware\JSONResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Stancl\Tenancy\Middleware\InitializeTenancyByRequestData;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function () {
            $centralDomains = config('tenancy.central_domains');
    
            foreach ($centralDomains as $domain) {
                Route::middleware('api')
                ->prefix('api/v1/central')
                ->group([
                    base_path('routes/central/auth.php'),
                    base_path('routes/central/api.php'),
                ]);
            }
    
            Route::middleware([
                'api', 
                'auth:sanctum', 
                InitializeTenancyByRequestData::class, 
                HasTenantRoles::class
            ])
            ->prefix('api/v1/tenants')
            ->group(base_path('routes/tenant/api.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(JSONResponse::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {
            $status = ExceptionStatus::fromException(e: $e);

            $data = null;
            if (method_exists($e, 'errors')) {
                $errors =  $e->errors();
                if ($errors && is_array($errors)) {
                    $data = Arr::map($errors, function ($messages) {
                        return $messages[0];
                    });
                }
            }

            $data = [
                'status' => [
                    'error' => true,
                    'message' => $status['message'],
                    'code' => $status['code'],
                ],
                'data' => $data,
            ];

            if (config('app.debug')) {
                $data['status']['trace'] = $e->getTrace();
            }
    
            return response()->json($data, $status['code']);
        });
    })
    ->create();
