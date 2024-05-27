@extends('layout/main')

@section('title', 'Cart')

@section('content')
<style>
    input {
        max-width: 150px;
        margin: auto;
    }

    #price {
        color: red;
    }

    #img {
        height: 170px;
        width: 100%;
        object-fit: cover;
    }

    td {
        text-align: center;
    }

    .card {
        margin: auto;
        width: 450px;
    }
</style>

<div class="content-wrapper pt-4 pb-5">
    @if(auth()->check() && auth()->user())
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cart</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        @if(!empty($productsInCart))
                        <li class="breadcrumb-item"><a href="{{ route('detail', ['id' => $productsInCart[0]['product']->id]) }}">Back</a></li>
                        @endif
                        <li class="breadcrumb-item active">Cart List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h4>This is Cart Page</h4>


            <table class="table">
                <tr style="text-align: center;">
                    <th>Select</th>
                    <th>Product List</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>

                @foreach ($productsInCart as $p)
                <tr>
                    <td>
                        <input type="checkbox" name="cart_ids[]" value="{{ $p['id'] }}" class="cart-checkbox" data-price="{{ $p['product']->price * $p['quantity'] }}" data-product-name="{{ $p['product']->product_name }}" data-product-price="{{ $p['product']->price }}">
                    </td>
                    <td>
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ route('detail', ['id' => $p['product']->id]) }}">
                                        <img id="img" src="{{ $p['product']->image_url }}" class="card-img-top" alt="Product Image">
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $p['product']->product_name }}</h5>
                                        <b>
                                            <p id="price" class="card-text">{{ $p['product']->price }}</p>
                                        </b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('cart_edit', ['id' => $p['id']]) }}" method="POST" class="pb-2">
                            @method('PUT')
                            @csrf
                            <input type="number" name="quantity" class="form-control" value="{{ $p['quantity'] }}">
                            <div class="pb-2"></div>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('cart_delete', ['id' => $p['id']]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="d-flex justify-content-between align-items-center">
                <h5>Total Price: <span id="totalPrice">0</span></h5>
                <button type="button" id="checkoutBtn" class="btn btn-success">Checkout</button>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.cart-checkbox');
        const totalPriceElement = document.getElementById('totalPrice');
        const checkoutBtn = document.getElementById('checkoutBtn');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateTotalPrice);
        });

        checkoutBtn.addEventListener('click', redirectToCheckout);

        function updateTotalPrice() {
            let totalPrice = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    totalPrice += parseFloat(checkbox.dataset.price);
                }
            });
            totalPriceElement.textContent = totalPrice.toFixed(2); // Format total price to 2 decimal places
        }

        function redirectToCheckout() {
            const selectedProducts = Array.from(document.querySelectorAll('input[name="cart_ids[]"]:checked')).map(checkbox => checkbox.value);

            // Redirect ke halaman Checkout dengan membawa product_ids yang dicentang
            window.location.href = `{{ route('checkout') }}?cart_ids=${selectedProducts.join(',')}&total_price=${totalPriceElement.textContent}`;
        }
    });
</script>
@endsection