<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function category() {
        $categories = Category::all();
        return response()->json(['message' => 'Success', 'data' => $categories]);
    }
    public function store(Request $request) {
        $request->validate([
            'category_name' => 'required|max:255'
        ]);

        $category = Category::create([
            'category_name' => $request->category_name
        ]);

        return response()->json(['message' => 'Success', 'data' => $category]);
    }
    public function update(Request $request, $id) {
        $category = Category::find($id);
        $category->update($request->all());
        return response()->json(['message' => 'Success', 'data' => $category]);
    }
    public function destroy($id) {
        $category = Category::find($id);
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
