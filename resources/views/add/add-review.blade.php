@extends('layout/main')

@section('title', 'Add Review')

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
        <h1>Add product</h1>

        <form action="/review/add/{{ $product->id }}" method="POST">
            @csrf
            <div class="mb-3" style="display: none;">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
            </div>
            <div class="mb-3" style="display: none;">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            </div>
            <div class="mb-3">
                <div class="col">
                    <h4>{{ auth()->user()->full_name }}</h4>
                </div>
            </div>
            <div class="mb-3">
                <label for="rating" class="form-label">Rating</label>
                <select name="rating" class="form-control">
                    @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">
                        @for ($j = 0; $j < $i; $j++)
                            ⭐ 
                        @endfor
                    </option>
                    @endfor
                </select>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea name="comment" placeholder="Produk berbahan tebal ..." class="form-control"></textarea>
            </div>
            <div class="mb-3 d-grid">
                <button name="submit" type="submit" class="btn" style="background-color: cornflowerblue; color: white;">Post</button>
            </div>
        </form>
    </div>
</div>
@endsection