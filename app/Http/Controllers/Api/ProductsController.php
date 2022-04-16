<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Api\ResponseController;

use App\Models\Categories;
use App\Models\Products;

class ProductsController extends ResponseController
{
    // Index //
    public function index(Request $request)
    {
        // Get all products //
        $products = Products::all();

        // Get category name //
        foreach ($products as $product) {
            // Try to get category name //
            try{
                $category = Categories::find($product->category_id);
                $product->category_name = $category->name;
            }
            // If category not found, set category name to null //
            catch (\Exception $e) {
                $product->category_name = null;
            }
        }

        // Prepare response //
        $response = [
            'products' => $products,
        ];

        // Return response //
        return $this->sendResponse($response, 'Products retrieved successfully.');
    }

    // Show //
    public function show(Request $request, $id)
    {
        // Get product //
        $product = Products::find($id);

        // Check if product exists //
        if (is_null($product)) {
            return $this->sendError('Product not found.', ['id' => $id]);
        }

        // Get category name //
        try{
            $category = Categories::find($product->category_id);
            $product->category_name = $category->name;
        }
        // If category not found, set category name to null //
        catch (\Exception $e) {
            $product->category_name = null;
        }

        // Prepare response //
        $response = [
            'product' => $product,
        ];

        // Return response //
        return $this->sendResponse($response, 'Product retrieved successfully.');
    }

    // Store //
    public function store(Request $request)
    {
        // Validate request //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image' => 'required|string|max:255',
            'stock' => 'required|numeric',
            'reference' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        // Check validation //
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Check if stock is less than 0 //
        if ($request->stock < 0) {
            // Set status to false //
            $request->status = 'false';
            // Set stock to 0 //
            $request->stock = 0;
        }
        // If stock is greater than 0 //
        else {
            // Set status to true //
            $request->status = 'true';
        }

        // Create product //
        $product = Products::create($request->all());

        // Prepare response //
        $response = [
            'product' => $product,
        ];

        // Return response //
        return $this->sendResponse($response, 'Product created successfully.');
    }

    // Update //
    public function update(Request $request, $id)
    {
        // Get product //
        $product = Products::find($id);

        // Check if product exists //
        if (is_null($product)) {
            return $this->sendError('Product not found.', ['id' => $id]);
        }

        // Validate request //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image' => 'required|string|max:255',
            'stock' => 'required|numeric',
            'reference' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        // Check validation //
        if ($validator->fails()) {
            return $this->sendError("Validation Error, try use 'x-www-form-urlencoded' if you're using 'application/json'", $validator->errors());
        }

        // Check if stock is less than 0 //
        if ($request->stock < 0) {
            // Set status to false //
            $request->status = 'false';
            // Set stock to 0 //
            $request->stock = 0;
        }

        // Update product //
        $product->update($request->all());

        // Prepare response //
        $response = [
            'product' => $product,
        ];

        // Return response //
        return $this->sendResponse($response, 'Product updated successfully.');
    }

    // Destroy //
    public function destroy(Request $request, $id)
    {
        // Get product //
        $product = Products::find($id);

        // Check if product exists //
        if (is_null($product)) {
            return $this->sendError('Product not found.', ['id' => $id]);
        }

        // Delete product //
        $product->delete();

        // Prepare response //
        $response = [
            'product' => $product,
        ];

        // Return response //
        return $this->sendResponse($response, 'Product deleted successfully.');
    }
}
