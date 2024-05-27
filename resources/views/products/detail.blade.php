@extends('layout/main')

@section('title', 'Product Detail')
<style>
    .star {
        color: orange;
    }

    p {
        line-height: 20px;
    }
</style>
@section('content')
<div class="container my-5 pt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->image_url }}" class="img-fluid" alt="Product Image">
        </div>
        <div class="col-md-4">
            <h1>{{ $product->product_name }}</h1>
            <div class="star pb-3 pt-2">
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star"></i>
                <i class="fa-solid fa-star-half-stroke"></i>
            </div>
            <p><b>Price :</b> {{ $product->price }}</p>
            <p><b>Description :</b> {{ $product->description }}</p>
            <p><b>Stock :</b> {{ $product->stock }}</p>
            <form action="{{ route('addToCart', ['id' => $product->id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-secondary mt-3">Add to Cart</button>
            </form>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h4>Product By : </h4>
            <p class="pt-2">
                <img src="{{ asset('images/logo.png') }}" alt="" width="30" height="24" class="d-inline-block align-text-top">
                akoo
            </p>
        </div>
    </div>
</div>
@endsection