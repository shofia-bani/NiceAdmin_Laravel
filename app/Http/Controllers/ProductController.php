<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
// use App\Models\Category; // Hapus baris ini

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    public function create()
    {
        // $categories = Category::all(); // Hapus baris ini
        return view('product.create'); // Ubah menjadi tanpa compact('categories')
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:255',
            'ISBN' => 'nullable|string|max:13|unique:products,ISBN',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'quantity' => 'required|integer|min:0',
            // 'category_id' => 'nullable|exists:categories,id', // Hapus baris ini
        ]);

        Product::create([
            'name' => $request->input('name'),
            'penulis' => $request->input('penulis'),
            'ISBN' => $request->input('ISBN'),
            'tahun_terbit' => $request->input('tahun_terbit'),
            'quantity' => $request->input('quantity'),
            // 'category_id' => $request->input('category_id'), // Hapus baris ini
        ]);

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        // $categories = Category::all(); // Hapus baris ini
        return view('product.edit', compact('product')); // Ubah menjadi tanpa compact('categories')
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:255',
            'ISBN' => 'nullable|string|max:13|unique:products,ISBN,' . $product->id,
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'quantity' => 'required|integer|min:0',
            // 'category_id' => 'nullable|exists:categories,id', // Hapus baris ini
        ]);

        $product->update([
            'name' => $request->input('name'),
            'penulis' => $request->input('penulis'),
            'ISBN' => $request->input('ISBN'),
            'tahun_terbit' => $request->input('tahun_terbit'),
            'quantity' => $request->input('quantity'),
            // 'category_id' => $request->input('category_id'), // Hapus baris ini
        ]);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')
                           ->orWhere('penulis', 'like', '%' . $query . '%')
                           ->get();
        return view('product.index', compact('products'));
    }

    public function paginate(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $products = Product::paginate($perPage);
        return view('product.index', compact('products'));
    }

    // --- API Methods ---
    public function apiIndex()
    {
        return response()->json(Product::all());
    }

    public function apiShow(Product $product)
    {
        return response()->json($product);
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:255',
            'ISBN' => 'nullable|string|max:13|unique:products,ISBN',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'quantity' => 'required|integer|min:0',
            // 'category_id' => 'nullable|exists:categories,id', // Hapus baris ini
        ]);

        $product = Product::create([
            'name' => $request->input('name'),
            'penulis' => $request->input('penulis'),
            'ISBN' => $request->input('ISBN'),
            'tahun_terbit' => $request->input('tahun_terbit'),
            'quantity' => $request->input('quantity'),
            // 'category_id' => $request->input('category_id'), // Hapus baris ini
        ]);

        return response()->json($product, 201);
    }

    public function apiUpdate(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'penulis' => 'nullable|string|max:255',
            'ISBN' => 'nullable|string|max:13|unique:products,ISBN,' . $product->id,
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'quantity' => 'required|integer|min:0',
            // 'category_id' => 'nullable|exists:categories,id', // Hapus baris ini
        ]);

        $product->update([
            'name' => $request->input('name'),
            'penulis' => $request->input('penulis'),
            'ISBN' => $request->input('ISBN'),
            'tahun_terbit' => $request->input('tahun_terbit'),
            'quantity' => $request->input('quantity'),
            // 'category_id' => $request->input('category_id'), // Hapus baris ini
        ]);

        return response()->json($product);
    }

    public function apiDestroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }

    public function apiSearch(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')
                           ->orWhere('penulis', 'like', '%' . $query . '%')
                           ->get();
        return response()->json($products);
    }

    public function apiPaginate(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $products = Product::paginate($perPage);
        return response()->json($products);
    }

    public function apiStats()
    {
        $totalProducts = Product::count();
        return response()->json([
            'total_products' => $totalProducts,
        ]);
    }

    public function apiTopProducts()
    {
        $topProducts = Product::orderBy('quantity', 'desc')->take(10)->get();
        return response()->json($topProducts);
    }

    public function apiLowStock()
    {
        $lowStockProducts = Product::where('quantity', '<=', 5)->get();
        return response()->json($lowStockProducts);
    }

    public function apiOutOfStock()
    {
        $outOfStockProducts = Product::where('quantity', 0)->get();
        return response()->json($outOfStockProducts);
    }
}