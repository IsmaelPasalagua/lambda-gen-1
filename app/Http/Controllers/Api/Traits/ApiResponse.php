<?php

namespace App\Http\Controllers\Api\Traits;

use Illuminate\Support\Collection;
use Jenssegers\Mongodb\Eloquent\Model;

trait ApiResponse
{
    private function successResponse($data, $code = 200, $message = 'success')
    {
        return response()->json([
            'status' => true,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }

    protected function errorResponse($message, $code = 400)
    {
        return response()->json([
            'status' => false,
            'code' => $code,
            'message' => $message
        ]);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        return $this->successResponse($instance, $code);
    }
}