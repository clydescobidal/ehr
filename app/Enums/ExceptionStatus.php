<?php

namespace App\Enums;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedByRequestDataException;
use Symfony\Component\HttpFoundation\Response;

enum ExceptionStatus: int
{
    public static function fromException(\Throwable $e): int
    {
        return match (true) {
            $e instanceof ValidationException => Response::HTTP_UNPROCESSABLE_ENTITY,
            $e instanceof ModelNotFoundException => Response::HTTP_NOT_FOUND,
            $e instanceof AuthenticationException => Response::HTTP_UNAUTHORIZED,
            $e instanceof TenantCouldNotBeIdentifiedByRequestDataException => Response::HTTP_NOT_FOUND,
            method_exists($e, 'getStatusCode') => $e->getStatusCode(),
            default => Response::HTTP_INTERNAL_SERVER_ERROR,
        };
    }
}