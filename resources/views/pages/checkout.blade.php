@extends('layout.main')

@section('title', 'Checkout')

@section('content')
<div class="content-wrapper pt-4 pb-5">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Checkout</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('cart') }}">Back</a></li>
                        <li class="breadcrumb-item active">Checkout Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h4>This is Checkout Page</h4>

            <form action="{{ route('process_checkout') }}" method="POST">
                @csrf
                <div class="form-group pb-2">
                    <label for="full_name" class="pb-2">Full Name Receiver</label>
                    <input type="text" id="full_name" name="full_name" class="form-control" required>
                </div>
                <div class="form-group pb-4">
                    <label for="deliver_address" class="pb-2">Delivery Address</label>
                    <textarea id="deliver_address" name="deliver_address" class="form-control" required></textarea>
                </div>

                <table class="table">
                    <thead>
                        <tr style="text-align: center;">
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $cartItem)
                        <tr style="text-align: center;">
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $cartItem->product->product_name }}</td>
                            <td>{{ $cartItem->product->price }}</td>
                            <td>{{ $cartItem->quantity }}</td>
                            <td>{{ $cartItem->quantity * $cartItem->product->price }}</td>
                            <input type="hidden" name="cart_ids[]" value="{{ $cartItem->id }}">
                            <input type="hidden" name="quantity_{{ $cartItem->id }}" value="{{ $cartItem->quantity }}">
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-between align-items-center">
                    <h5>Total Price: {{ $totalPrice }}</h5>
                    <input type="hidden" name="total_price" value="{{ $totalPrice }}">
                    <button type="submit" id="checkoutBtn" class="btn btn-success">Click to Order</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection