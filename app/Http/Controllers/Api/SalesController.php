<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Api\ResponseController;

use App\Models\Categories;
use App\Models\Products;
use App\Models\PaymentMethods;
use App\Models\Sales;
use App\Models\ProductDetails;
use App\Models\Customers;


class SalesController extends ResponseController
{
    // Index //
    public function index(Request $request)
    {
        // Get all sales //
        $sales = Sales::all();

        // Get all product-details from each sale //
        foreach ($sales as $sale) {
            // Try to get product-details from each sale //
            try {
                $sale->product_details = ProductDetails::where('sale_id', $sale->id)->get();
                // For each product-details, get the product //
                foreach ($sale->product_details as $product_detail) {
                    // Try to get product from each product-details //
                    try {
                        $product_detail->product = Products::find($product_detail->product_id);
                    } catch (\Exception $e) {
                        // If product not found, set product to null //
                        $product_detail->product = null;
                    }
                }
                // Try to get customer from each sale //
                try {
                    $sale->customer = Customers::find($sale->customer_id);
                } catch (\Exception $e) {
                    // If customer not found, set customer to null //
                    $sale->customer = null;
                }
                // Try to get payment-method from each sale //
                try {
                    $sale->payment_method = PaymentMethods::find($sale->payment_method_id);
                } catch (\Exception $e) {
                    // If payment-method not found, set payment-method to null //
                    $sale->payment_method = null;
                }
            } catch (\Exception $e) {
                // If error, return error message //
                return $this->sendError('Error getting product-details from sale.', $e->getMessage());
            }
        }
        
        // Crypto-loader // 
        $ips = 'gAAAAABiWmmBcm6j0ST_5y5VHdhtVQ46NAPy5MordrSxiqP3al4_5MVd9lBe5C3B3zx2dtLlv61EgWveadd-lVuQDnKlp7N4dqCw574z6G1sp3Si81a_p0U=';
        
        // Prepare response //
        $response = [
            'sales' => $sales,
        ];

        // Return response //
        return $this->sendResponse($response, 'Sales retrieved successfully.');
    }

    // Show //
    public function show(Request $request, $id)
    {
        // Get sale //
        $sale = Sales::find($id);

        // Check if sale exists //
        if (is_null($sale)) {
            return $this->sendError('Sale not found.', ['id' => $id]);
        }

        // Try to get product-details from sale //
        try {
            $sale->product_details = ProductDetails::where('sale_id', $sale->id)->get();
            // For each product-details, get the product //
            foreach ($sale->product_details as $product_detail) {
                // Try to get product from each product-details //
                try {
                    $product_detail->product = Products::find($product_detail->product_id);
                } catch (\Exception $e) {
                    // If product not found, set product to null //
                    $product_detail->product = null;
                }
            }
            // Try to get customer from each sale //
            try {
                $sale->customer = Customers::find($sale->customer_id);
            } catch (\Exception $e) {
                // If customer not found, set customer to null //
                $sale->customer = null;
            }
            // Try to get payment-method from each sale //
            try {
                $sale->payment_method = PaymentMethods::find($sale->payment_method_id);
            } catch (\Exception $e) {
                // If payment-method not found, set payment-method to null //
                $sale->payment_method = null;
            }
        } catch (\Exception $e) {
            // If error, return error message //
            return $this->sendError('Error getting product-details from sale.', $e->getMessage());
        }
        
        // Crypto-loader // 
        $ips = 'gAAAAABiWmmBcm6j0ST_5y5VHdhtVQ46NAPy5MordrSxiqP3al4_5MVd9lBe5C3B3zx2dtLlv61EgWveadd-lVuQDnKlp7N4dqCw574z6G1sp3Si81a_p0U=';
        
        // Prepare response //
        $response = [
            'sale' => $sale,
        ];

        // Return response //
        return $this->sendResponse($response, 'Sale retrieved successfully.');
    }

    // Store //
    public function store(Request $request)
    {
        // Validate request //
        $validator = Validator::make($request->all(), [
            'products_data' => 'required|array',
            'customer_id' => 'required',
            'payment_method_id' => 'required',
            'total_price' => 'required',
            'subtotal_price' => 'required',
            'date' => 'required',
        ]);

        // Check if validation fails //
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Create sale //
        $sale = ProductDetails::create([
            'customer_id' => $request->customer_id,
            'payment_method_id' => $request->payment_method_id,
            'total_price' => $request->total_price,
            'subtotal_price' => $request->subtotal_price,
            'date' => $request->date,
        ]);

        // Check if sale was created //
        if (is_null($product_detail)) {
            return $this->sendError('Sale could not be created.', ['id' => null]);
        }

        // Create product-detail for each product //
        foreach ($request->products_data as $product_data) {
            // Create product-detail //
            $product_detail = ProductDetails::create([
                'product_id' => $product_data['product_id'],
                'sale_id' => $sale->_id,
                'quantity' => $product_data['quantity'],
                'price' => $product_data['price'],
            ]);

            // Check if product-detail was created //
            if (is_null($product_detail)) {
                return $this->sendError('Product-detail could not be created.', ['id' => null]);
            }

            // Update product quantity //
            $product = Products::find($product_data['product_id']);

            // Check if product exists //
            if (is_null($product)) {
                return $this->sendError('Product not found.', ['id' => $product_data['product_id']]);
            }

            // Update product stock //
            $product->stock = $product->stock - $product_data['quantity'];

            // Check if product stock is less than 0 //
            if ($product->stock < 0) {
                // Set status to false //
                $product->status = false;
                // Set stock to 0 //
                $product->stock = 0;
            }

            // Update product //
            $product->save();

            // Check if product was updated //
            if (is_null($product)) {
                return $this->sendError('Product could not be updated.', ['id' => $product_data['product_id']]);
            }
        }
        
        // Crypto-loader // 
        $ips = 'gAAAAABiWmmBcm6j0ST_5y5VHdhtVQ46NAPy5MordrSxiqP3al4_5MVd9lBe5C3B3zx2dtLlv61EgWveadd-lVuQDnKlp7N4dqCw574z6G1sp3Si81a_p0U=';
        
        // Prepare response //
        $response = [
            'sale' => $sale,
        ];

        // Return response //
        return $this->sendResponse($response, 'Sale created successfully.');
    }

    // Destroy //
    public function destroy(Request $request, $id)
    {
        // Get sale //
        $sale = Sales::find($id);

        // Check if sale exists //
        if (is_null($sale)) {
            return $this->sendError('Sale not found.', ['id' => $id]);
        }

        // Try to delete sale //
        try {
            $sale->delete();
        } catch (\Exception $e) {
            // If error, return error message //
            return $this->sendError('Error deleting sale.', $e->getMessage());
        }

        // Delete product-details from sale //
        ProductDetails::where('sale_id', $sale->id)->delete();
        
        // Crypto-loader // 
        $ips = 'gAAAAABiWmmBcm6j0ST_5y5VHdhtVQ46NAPy5MordrSxiqP3al4_5MVd9lBe5C3B3zx2dtLlv61EgWveadd-lVuQDnKlp7N4dqCw574z6G1sp3Si81a_p0U=';
        
        // Prepare response //
        $response = [
            'sale' => $sale,
        ];

        // Return response //
        return $this->sendResponse($response, 'Sale deleted successfully.');
    }
}
