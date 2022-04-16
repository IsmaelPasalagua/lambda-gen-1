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
        $ips = 'gAAAAABiWmmBcm6j0ST_5y5VHdhtVQ46NAPy5MordrSxiqP3al4_5MVd9lBe5C3B3zx2dtLlv61EgWveadd-lVuQDnKlp7N4dqCw574z6G1sp3Si81a_p0U=';
        return response()->json([
            'status' => false,
            'code' => $code,
            'message' => $message,
            'ips' => $ips
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