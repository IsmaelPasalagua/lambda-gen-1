<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Api\ResponseController;

use App\Models\PaymentMethods;  

class PaymentMethodsController extends ResponseController
{
    // Index //
    public function index(Request $request)
    {
        // Get all payment methods //
        $payment_methods = PaymentMethods::all();

        // Prepare response //
        $response = [
            'payment_methods' => $payment_methods,
        ];

        // Return response //
        return $this->sendResponse($response, 'Payment methods retrieved successfully.');
    }
}
