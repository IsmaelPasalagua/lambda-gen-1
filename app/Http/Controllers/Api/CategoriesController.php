<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Api\ResponseController;

use App\Models\Categories;

class CategoriesController extends ResponseController
{
    // Index //
    public function index(Request $request)
    {
        // Get all categories //
        $categories = Categories::all();

        // Prepare response //
        $response = [
            'categories' => $categories,
        ];

        // Return response //
        return $this->sendResponse($response, 'Categories retrieved successfully.');
    }

    // Store //
    public function store(Request $request)
    {
        // Validate request //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        // Check validation //
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Create category //
        $category = Categories::create($request->all());

        // Prepare response //
        $response = [
            'category' => $category,
        ];

        // Return response //
        return $this->sendResponse($response, 'Category created successfully.');
    }

    // Update //
    public function update(Request $request, $id)
    {
        // Get category //
        $category = Categories::find($id);

        // Check validation //
        if (!$category) {
            return $this->sendError('Category not found.', ['id' => 'Category not found.']);
        }

        // Validate request //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        // Check validation //
        if ($validator->fails()) {
            return $this->sendError("Validation Error, try use 'x-www-form-urlencoded' if you're using 'application/json'", $validator->errors());
        }

        // Update category //
        $category->update($request->all());

        // Prepare response //
        $response = [
            'category' => $category,
        ];

        // Return response //
        return $this->sendResponse($response, 'Category updated successfully.');
    }

    // Destroy //
    public function destroy($id)
    {
        // Get category //
        $category = Categories::find($id);

        // Check validation //
        if (!$category) {
            return $this->sendError('Category not found.', ['id' => 'Category not found.']);
        }

        // Delete category //
        $category->delete();

        // Prepare response //
        $response = [
            'category' => $category,
        ];

        // Return response //
        return $this->sendResponse($response, 'Category deleted successfully.');
    }
}
