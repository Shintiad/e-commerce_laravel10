@extends('layout/main')

@section('title', 'Search Result')

<style>
    #price {
        color: red;
    }

    #img {
        height: 400px;
        width: 100%;
        object-fit: cover;
    }

</style>

@section('content')

<div class="container pt-4">
    <div class="row">
        @foreach($products as $p)
        <div class="col-md-4">
            <div class="card mb-4">
                <a href="{{ route('detail', ['id' => $p->id]) }}">
                    <img id="img" src="{{ $p->image_url }}" class="card-img-top" alt="Product Image">
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{ $p->product_name }}</h5>
                    <b>
                        <p id="price" class="card-text">{{ $p->price }}</p>
                    </b>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection