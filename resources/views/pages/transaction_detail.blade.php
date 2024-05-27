@extends('layout/main')

@section('title', 'Transaction Detail')

@section('content')
<style>
    td {
        text-align: center;
    }

    input:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="content-wrapper pt-4 pb-5">
    @if(auth()->check() && auth()->user())
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Transaction Detail</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/transaction">Transaction</a></li>
                        <li class="breadcrumb-item active">Transaction Detail</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h4>This is Transaction Detail Page</h4>

            <table class="table">
                <tr style="text-align: center;">
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                </tr>

                @foreach ( $transaction_detail as $td )
                <tr>
                    <td>{{ $td->product->product_name }}</td>
                    <td>{{ $td->price }}</td>
                    <td>{{ $td->quantity }}</td>
                </tr>
                @endforeach
            </table>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @endif

</div>
@endsection