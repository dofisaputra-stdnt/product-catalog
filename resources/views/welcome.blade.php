@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
    <h1>Welcome to the Product Catalog</h1>
    <p class="lead">Browse through the catalog of products.</p>
    <a class="btn btn-primary btn-lg" href="{{ route('products.index') }}" role="button">View Products</a>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <!-- Circular Photo -->
                    <div class="mb-3" style="width: 150px; height: 150px; overflow: hidden; border-radius: 50%; position: relative; margin: 0 auto;">
                        <img src="images/face.jpg" alt="Your Name" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                    </div>
                    <h5 class="card-title">Dofi Saputra</h5>
                    <p class="card-text">NIM: 41522110006</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection