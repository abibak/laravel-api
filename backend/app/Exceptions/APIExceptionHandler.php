<?php

namespace App\Exceptions;

use App\Traits\APIResponse;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class APIExceptionHandler extends Exception
{
    use APIResponse;

    /**
     * Render the exception as an HTTP response.
     */
    public static function handle(Request $request, Throwable $e)
    {
        if ($e instanceof NotFoundHttpException) {
            return APIResponse::sendErrorResponse(null, 'Content not found', 404);
        }

        if ($e instanceof ValidationException) {
            return APIResponse::sendErrorResponse($e->errors(), $e->getMessage(), 422);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return APIResponse::sendErrorResponse(null, 'Method Not Allowed', 405);
        }

        if ($e instanceof QueryException) {
            return APIResponse::sendErrorResponse(null, 'Database error', 500);
        }

        return APIResponse::sendErrorResponse(null, 'Unknow error', 500);
    }
}
