<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();

        return response()->json([
            'success' => true,
            'message' => 'Sukses',
            'data' => $product
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    public function showByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();

        if (!$barcode) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'data' => null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $product,
        ]);
    }
}
