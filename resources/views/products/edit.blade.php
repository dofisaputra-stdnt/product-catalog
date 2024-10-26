@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" required>{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" name="price" id="price" value="{{ $product->price }}" required step="0.01">
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" name="stock" id="stock" value="{{ $product->stock }}" required step=" 0.01">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" name="status" id="status" required>
                <option value="brand_new">Brand New</option>
                <option value="second">Second</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Product Image (optional)</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection