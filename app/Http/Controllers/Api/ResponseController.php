<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
{
    // Send response //
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
            'status' => 200
        ];
        return response()->json($response);
    }

    // Send error response //
    public function sendError($error, $code)
    {
        $response = [
            'success' => false,
            'message' => $error,
            'status' => $code,
        ];
        return response()->json($response);
    }
}
