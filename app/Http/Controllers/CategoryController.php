<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function category() {
        $categories = Category::all();
        return view("pages/category", compact("categories"));
    }
    public function show($id) {
        try {
            $product_category = Category::findOrFail($id);
            $products = Product::where('category_id', $id)->get();
            return view("products/product_category", compact("product_category", "products"));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }    
    public function create() {
        return view("add/add-category");
    }
    public function store(Request $request) {
        $request->validate([
            'category_name' => 'required|max:255'
        ]);

        Category::create([
            'category_name' => $request->category_name
        ]);

        return redirect()->route('category');
    }
    public function edit($id) {
        $category = Category::find($id);
        return view("edit/edit-category", compact("category"));
    }
    public function update(Request $request, $id) {
        $category = Category::find($id);
        $category->update($request->all());
        return redirect()->route('category');
    }
    public function destroy($id) {
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category');
    }
}
