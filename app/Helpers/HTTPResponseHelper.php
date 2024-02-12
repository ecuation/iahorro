<?php

namespace App\Helpers;
use \Illuminate\Http\JsonResponse;

class HTTPResponseHelper
{
    public static function notFoundResponse(string $message = 'Not found'): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], 404);
    }
}
