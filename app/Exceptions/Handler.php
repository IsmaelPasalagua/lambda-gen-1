<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // exception NotFoundHttpException
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json([
                'message' => 'Not Found',
                'status' => 404,
            ], 404);
        }

        // exception MethodNotAllowedHttpException
        if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->json([
                'message' => 'Method Not Allowed',
                'status' => 405,
            ], 405);
        }

        // exception ValidationException
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return response()->json([
                'message' => 'Validation Error',
                'status' => 422,
                'errors' => $e->errors(),
            ], 422);

        // exception ModelNotFoundException
        } elseif ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
            return response()->json([
                'message' => 'Model Not Found',
                'status' => 404,
            ], 404);
        }

        // exception AuthorizationException
        if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401,
            ], 401);
        }

        // exception TokenMismatchException
        if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenMismatchException) {
            return response()->json([
                'message' => 'Token Mismatch',
                'status' => 401,
            ], 401);
        }

        // exception TokenExpiredException
        if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json([
                'message' => 'Token Expired',
                'status' => 401,
            ], 401);
        }

        // exception JWTException
        if ($e instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
            return response()->json([
                'message' => 'Token Invalid',
                'status' => 401,
            ], 401);
        }

        // exception Symfony\Component\Routing\Exception\RouteNotFoundException
        if ($e instanceof \Symfony\Component\Routing\Exception\RouteNotFoundException) {
            return response()->json([
                'message' => "Route Not Found, try add 'Accept: application/json' to your request",
                'status' => 404,
            ], 404);
        }

        // if any other exception
        $error = [
            'message' => $e->getMessage(),
            'status' => $e->getCode(),
        ];
        return response()->json([
            'message' => 'Internal Server Error',
            'error' => $error,
            'status' => 500,
        ], 500);

        return parent::render($request, $e);
    }
}
