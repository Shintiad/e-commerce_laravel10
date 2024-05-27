<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function product()
    {
        $products = Product::all();
        return response()->json(['message' => 'Success', 'data' => $products]);
    }
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json(['message' => 'Success', 'data' => $product]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image_url' => 'required',
            'category_id' => 'required'
        ]);

        $product = Product::create($data);
        return response()->json(['message' => 'Insert Success', 'data' => $product]);
    }
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json(['message' => 'Update Success', 'data' => $product]);
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json(['message' => 'Delete Success', 'data' => null]);
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        $products = Product::where('product_name', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->orWhereHas('category', function($query) use ($keyword) {
                $query->where('category_name', 'like', "%$keyword%");
            })
            ->get();

        return response()->json($products);
    }
}
