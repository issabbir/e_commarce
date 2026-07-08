<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('company.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('company.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required'
        ]);

        Product::create($data);
        if($request->ajax()){
            return response()->json(['success' => true, 'message' => 'Product created successfully!']);
        }
        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('company.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required'
        ]);

        $product->update($data);
        if($request->ajax()){
            return response()->json(['success' => true, 'message' => 'Product updated successfully!']);
        }
        return redirect()->route('products.index');
    }

    public function destroy(Product $product, Request $request)
    {
        $product->delete();
        if($request->ajax()){
            return response()->json(['success' => true, 'message' => 'Product deleted successfully!']);
        }
        return redirect()->route('products.index');
    }
}
