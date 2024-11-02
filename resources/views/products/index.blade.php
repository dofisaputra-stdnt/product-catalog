@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Product Catalog</h2>
    @if(auth()->check() && auth()->user()->role == 'admin')
    <a class="btn btn-primary mb-3" href="{{ route('products.create') }}">Upload New Product</a>
    @endif
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="row mt-4">
        @foreach ($products as $product)
        <div class="col-md-4 mb-4 d-flex">
            <div class="card h-100 w-100">
                <div class="img-container">
                    <img src="{{ asset('images/'.$product->image) }}" class="card-img-top" alt="{{ $product->image_tag }}">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><strong>{{ $product->name }}</strong></h5>
                    <p class="card-text">Rp.{{ number_format($product->price, 2) }}</p>
                    <p class="card-text">{{ $product->description }}</p>
                    <div class="mt-auto">
                        @if(auth()->check() && auth()->user()->role == 'admin')
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        @endif
                        @if(auth()->check())
                        <a href="{{ asset('images/'.$product->image) }}" download class="btn btn-info">Download Image</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection