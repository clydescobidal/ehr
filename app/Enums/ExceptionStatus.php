<?php

namespace App\Enums;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

enum ExceptionStatus: int
{
    case ValidationException = 422;
    case ModelNotFoundException = 404;
    case HttpException = 500;

    public static function fromException(\Throwable $e): int
    {
        return match (true) {
            $e instanceof ValidationException => self::ValidationException->value,
            $e instanceof ModelNotFoundException => self::ModelNotFoundException->value,
            method_exists($e, 'getStatusCode') => $e->getStatusCode(),
            default => self::HttpException->value,
        };
    }
}