<?php

namespace App\Traits;

trait APIResponse
{
    public static function sendSuccessResponse(mixed $data, string $message = 'Success', int $code = 200)
    {
        return response()->json([
            'status' => $message,
            'data' => $data,
        ], $code);
    }

    public static function sendErrorResponse(mixed $errors, string $message = 'Failed', int $code = 400)
    {
        return response()->json(['data' => [
            'message' => $message,
            'errors' => $errors
        ]], $code);
    }
}
