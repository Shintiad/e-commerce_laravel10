@extends('layout/main')

@section('title', 'Products')

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
  @if(auth()->check() && auth()->user()->role == 1)
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Products</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/category">Categories</a></li>
            <li class="breadcrumb-item active">Product List</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <h4>This is Product Page</h4>

      <table class="table">
        <tr style="text-align: center;">
          <th>No</th>
          <th>Product Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Stock</th>
        </tr>

        @foreach ( $products as $index => $p )
        <tr>
          <td>{{ $loop -> iteration}}</td>
          <td>{{ $p->product_name }}</td>
          <td>{{ $p->description }}</td>
          <td>{{ $p->price }}</td>
          <td>{{ $p->stock }}</td>
          <td>
            <div class="d-flex">
              <button class="btn btn-primary me-2" onclick="window.location.href='/product/{{ $p->id }}/edit'">Edit</button>
              <form action="/product/{{ $p->id }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
            </td>
        </tr>
        @endforeach
      </table>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <button class="btn btn-success" onclick="window.location.href='/product/add'">Add Product</button>


  @else
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <h4>This page only can access by admin!</h4>
      </div>
    </div>
  </div>
  @endif

</div>
@endsection