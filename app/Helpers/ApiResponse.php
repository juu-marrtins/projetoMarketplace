<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data, int $status)
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ], $status);
    }

    public static function fail(string $message, $status)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => []
        ], $status);
    }

}