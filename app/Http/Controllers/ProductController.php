<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product()
    {
        $products = Product::all();
        return view("pages/product", compact("products"));
    }
    public function show($id)
    {
        $product = Product::find($id);
        return view("products/detail", compact("product"));
    }
    public function create()
    {
        $categories = Category::all();
        return view("add/add-product", compact("categories"));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image_url' => 'required|max:255',
            'category_id' => 'required'
        ]);

        Product::create($data);
        return redirect()->route('product');
    }
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        return view("edit/edit-product", compact("product", "categories"));
    }
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return redirect()->route('product');
    }
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product');
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

        return view('products/search', ['products' => $products]);
    }
}
