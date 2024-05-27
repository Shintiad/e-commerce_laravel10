@extends('layout/main')

@section('title', 'Categories')

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
          <h1 class="m-0">Product Categories</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/product">Products</a></li>
            <li class="breadcrumb-item active">Categories List</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <h4>This is Product Category Page</h4>

      <table class="table">
        <tr style="text-align: center;">
          <th>No</th>
          <th>Category Name</th>
        </tr>

        @foreach ( $categories as $c )
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $c->category_name }}</td>
          <td>
            <div class="d-flex">
              <button class="btn btn-primary me-2" onclick="window.location.href='/category/{{ $c->id }}/edit'">Edit</button>
              @php
              $productsCount = \App\Models\Product::where('category_id', $c->id)->count();
              @endphp
              @if ($productsCount == 0)
              <form action="/category/{{ $c->id }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </table>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
  
  <button class="btn btn-success" onclick="window.location.href='/category/add'">Add Category</button>

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