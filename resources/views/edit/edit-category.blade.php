@extends('layout/main')

@section('title', 'Edit Category')

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

        <form action="/category/{{ $category->id }}" method="POST">
        @method('PUT')    
        @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" name="category_name" value="{{ $category->category_name }}" class="form-control">
            </div>
            <div class="mb-3 d-grid">
                <button name="submit" type="submit" class="btn" style="background-color: cornflowerblue; color: white;">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection