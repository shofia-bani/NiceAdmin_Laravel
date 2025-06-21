<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductApiController extends Controller
{
    public function index() {
        return response()->json(Product::all());    
    }

    public function show($id) {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product);  
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:255',
            'ISBN' => 'nullable|string|max:13|unique:products,ISBN',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, $id) {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:255',
            'ISBN' => 'nullable|string|max:13|unique:products,ISBN,' . $product->id,
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id) {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
    
}
