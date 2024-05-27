@extends('layout/main')

@section('title', 'Home')

<style>
    #price {
        color: red;
    }

    #img {
        height: 400px;
        width: 100%;
        object-fit: cover;
    }

    #prev-next {
        top: 50%;
        transform: translateY(-50%);
        height: 100px;
        width: 10%;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 36px;
    }

    .category-button {
        transition: all 0.3s ease;
    }

    .category-button:hover {
        transform: translateY(-2px);
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    .category-container {
        margin-bottom: 50px;
    }

    .footer {
        background-color: cornflowerblue;
        padding-top: 20px;
        padding-bottom: 10px;
    }

    .footer p {
        line-height: 30px;
    }

    #footer {
        color: white;
    }
</style>

@section('content')
<div class="container-fluid mt-5 cover">
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/gambar1.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/gambar2.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/gambar3.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/gambar4.jpg') }}" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/gambar5.jpg') }}" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container pt-4">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="my-5">Our Products</h1>
        </div>
    </div>

    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            @php
            $chunkedProducts = $products->chunk(3);
            @endphp
            @foreach($chunkedProducts as $index => $chunk)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <div class="row">
                    @foreach($chunk as $p)
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
            @endforeach
        </div>
        <button id="prev-next" class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button id="prev-next" class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="container category-container">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="my-5">Categories</h1>
        </div>
    </div>
    <div class="row">
        @foreach($categories as $c)
        <div class="col pb-2">
            <a href="{{ route('product_category', ['id' => $c->id]) }}" class="btn btn-outline-secondary  category-button">
                {{ $c->category_name }}
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('footer')
<section class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p>&copy; 2024 | Created by <br>
                    <img src="{{ asset('images/logo.png') }}" alt="" width="30" height="24" class="d-inline-block align-text-top">
                    <b><span id="footer">akoo</span></b>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection