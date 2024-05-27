@extends('layout/main')

@section('title', 'Transactions')

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
          <h1 class="m-0">Transactions</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Transaction History</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <h4>This is Transaction Page</h4>

      <table class="table">
        <tr style="text-align: center;">
          @if(auth()->check() && auth()->user()->role == 1)
          <th>User ID</th>
          @endif
          <th>Full Name</th>
          <th>Deliver Address</th>
          <th>Total Price</th>
          <th>Transaction Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>

        @foreach ($transactions as $t)
        <tr>
          @if(auth()->check() && auth()->user()->role == 1)
          <td>{{ $t->user_id }}</td>
          @endif
          <td>{{ $t->full_name }}</td>
          <td>{{ $t->deliver_address }}</td>
          <td>{{ $t->total_price }}</td>
          <td>{{ $t->transaction_date }}</td>
          <td>{{ $t->status }}</td>
          <td>
            <div class="d-flex justify-content-center">
              <button class="btn btn-success me-2" onclick="window.location.href='/transaction/{{ $t->id }}/detail'">Detail</button>
              @if(auth()->check() && auth()->user()->role == 1)
              <button class="btn btn-primary me-2" onclick="window.location.href='/transaction/{{ $t->id }}/edit'">Edit</button>
              <form action="/transaction/{{ $t->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
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
  @endif
</div>
@endsection