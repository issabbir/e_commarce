<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('company.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('company.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug'
        ]);

        Category::create($data);
        if($request->ajax()){
            return response()->json(['success' => true, 'message' => 'Category created successfully!']);
        }
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return view('company.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id
        ]);

        $category->update($data);
        if($request->ajax()){
            return response()->json(['success' => true, 'message' => 'Category updated successfully!']);
        }
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category, Request $request)
    {
        $category->delete();
        if($request->ajax()){
            return response()->json(['success' => true, 'message' => 'Category deleted successfully!']);
        }
        return redirect()->route('categories.index');
    }
}
