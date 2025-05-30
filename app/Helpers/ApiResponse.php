<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = null, $message = 'Success')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public static function error($message = 'Error', $status = 400, $data = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
