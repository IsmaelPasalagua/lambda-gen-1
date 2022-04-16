<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Api\ResponseController;

use App\Models\Customers;

class CustomersController extends ResponseController
{
    // Index //
    public function index(Request $request)
    {
        // Get all customers //
        $customers = Customers::all();

        // Prepare response //
        $response = [
            'customers' => $customers,
        ];

        // Return response //
        return $this->sendResponse($response, 'Customers retrieved successfully.');
    }

    // Show //
    public function show(Request $request, $id)
    {
        // Get customer //
        $customer = Customers::find($id);

        // Check if customer exists //
        if (is_null($customer)) {
            return $this->sendError('Customer not found.', ['id' => $id]);
        }

        // Prepare response //
        $response = [
            'customer' => $customer,
        ];

        // Return response //
        return $this->sendResponse($response, 'Customer retrieved successfully.');
    }

    // Store //
    public function store(Request $request)
    {
        // Validate request //
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|max:255',
        ]);

        // Check validation //
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Create customer //
        $customer = Customers::create($request->all());

        // Prepare response //
        $response = [
            'customer' => $customer,
        ];

        // Return response //
        return $this->sendResponse($response, 'Customer created successfully.');
    }

    // Update //
    public function update(Request $request, $id)
    {
        // Get customer //
        $customer = Customers::find($id);

        // Check validation //
        if (empty($customer)) {
            return $this->sendError('Customer not found.', ['id' => $id]);
        }

        // Validate request //
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,'.$customer->id,
            'phone' => 'required|string|max:255',
        ]);

        // Check validation //
        if ($validator->fails()) {
            return $this->sendError("Validation Error, try use 'x-www-form-urlencoded' if you're using 'application/json'", $validator->errors());
        }

        // Update customer //
        $customer->update($request->all());

        // Prepare response //
        $response = [
            'customer' => $customer,
        ];

        // Return response //
        return $this->sendResponse($response, 'Customer updated successfully.');
    }

    // Delete //
    public function destroy($id)
    {
        // Get customer //
        $customer = Customers::find($id);

        // Check validation //
        if (empty($customer)) {
            return $this->sendError('Customer not found.', ['id' => $id]);
        }

        // Delete customer //
        $customer->delete();

        // Prepare response //
        $response = [
            'customer' => $customer,
        ];

        // Return response //
        return $this->sendResponse($response, 'Customer deleted successfully.');
    }
}
