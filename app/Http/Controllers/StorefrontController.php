<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class StorefrontController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $categoryId = $request->query('category');
        
        $query = Product::with('company', 'category')->latest();

        if ($categoryId) {
            $query->where('category_id', $categoryId);
            if ($search) {
                // Subcategory click: filter natively by subcategory_id
                $sub = \App\Models\Subcategory::where('category_id', $categoryId)->where('name', $search)->first();
                if ($sub) {
                    $query->where('subcategory_id', $sub->id);
                } else {
                    $query->where('name', 'LIKE', "%{$search}%"); // Fallback
                }
            }
        } elseif ($search) {
            // Header search bar — match product name OR category name
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function($q2) use ($search) {
                      $q2->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $products = $query->paginate(48)->appends(['search' => $search, 'category' => $categoryId]);
        $categories = Category::with('subcategories')->get(); 
        
        return view('storefront', compact('products', 'categories', 'search'));
    }

    public function flashDeals()
    {
        $products = Product::with(['company', 'category'])
            ->withSum('orderItems', 'quantity')
            ->inRandomOrder()
            ->paginate(24);
        return view('flash_deals', compact('products'));
    }

    public function suggestions(Request $request)
    {
        $search = $request->query('query');
        if (!$search) return response()->json([]);

        $products = Product::where('name', 'LIKE', "%{$search}%")
            ->limit(8)
            ->pluck('name');

        return response()->json($products);
    }

    public function show($id)
    {
        $product = Product::with(['company', 'category', 'subcategory', 'reviews.user'])
            ->withSum('orderItems', 'quantity')
            ->findOrFail($id);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(6)
            ->get();
        return view('product_details', compact('product', 'relatedProducts'));
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500'
        ]);

        \App\Models\Review::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
