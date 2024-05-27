@extends('layout/main')

@section('title', 'Edit Product')

@section('content')
<style>
    .center-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
</style>

<div class="center-container">
    <div class="w-50 center border rounded px-3 py-3" style="background-color: white;">
        <h1>Edit product</h1>

        <form action="/product/{{ $product->id }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" value="{{ $product->description }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" value="{{ $product->price }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" value="{{ $product->stock }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Image URL</label>
                <input type="text" name="image_url" value="{{ $product->image_url }}" class="form-control">
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" class="form-control" required>
                    @foreach( $categories as $c )
                        <option value="{{ $c->id }}">{{ $c->category_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 d-grid">
                <button name="submit" type="submit" class="btn" style="background-color: cornflowerblue; color: white;">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection