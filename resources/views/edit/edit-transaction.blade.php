@extends('layout/main')

@section('title', 'Edit Transaction')

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
        <h1>Edit Transaction</h1>

        <form action="/transaction/{{ $transaction->id }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    @foreach(App\Models\Transaction::getStatusValues() as $status)
                    <option value="{{ $status }}" {{ $transaction->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
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