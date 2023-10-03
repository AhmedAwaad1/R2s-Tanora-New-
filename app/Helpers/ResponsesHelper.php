<?php

namespace App\Helpers;

trait ResponsesHelper
{
    public function success($data=null, string $message = 'Success')
    {
        return response()->json([
            'code' => 200,
            'status' => 1,
            'errors' => null,
            'data' => $data,
            'message' => $message
        ], 200);
    }

    public function fail($code = 400, $message = 'error', $error=null)
    {
        return response()->json([
            'code' => $code,
            'status'=> 0,
            'errors' => $error,
            'message' => $message,
            'data' => null
            ], $code);
    }

}
