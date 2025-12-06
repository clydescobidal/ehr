<?php

namespace App\Enums;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedByRequestDataException;
use Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

enum ExceptionStatus
{
    public static function fromException(Throwable $e): array
    {
        return match (true) {
            $e instanceof ValidationException => [
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => Str::upper(Str::snake(Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY]))
            ],
            $e instanceof ModelNotFoundException, 
            $e instanceof TenantCouldNotBeIdentifiedByRequestDataException => [
                'code' => Response::HTTP_NOT_FOUND,
                'message' => Str::upper(Str::snake(Response::$statusTexts[Response::HTTP_NOT_FOUND]))
            ],
            $e instanceof AuthenticationException => [
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => Str::upper(Str::snake(Response::$statusTexts[Response::HTTP_UNAUTHORIZED]))
            ],
            $e instanceof AccessDeniedHttpException => [
                'code' => Response::HTTP_FORBIDDEN,
                'message' => Str::upper(Str::snake(Response::$statusTexts[Response::HTTP_FORBIDDEN]))
            ],
            $e instanceof HttpException => [
                'code' => $e->getStatusCode(),
                'message' => $e->getMessage() ?: Str::upper(Str::snake(Response::$statusTexts[$e->getStatusCode()]))
            ],
            default => [
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => Str::upper(Str::snake(Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]))
            ],
        };
    }
}