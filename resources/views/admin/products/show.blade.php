@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Product Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">{{ $product->description }}</p>
            <p class="card-text"><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
            <p class="card-text"><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
            <p class="card-text"><strong>Stock:</strong> {{ $product->stock }}</p>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 300px;">
            @endif
        </div>
    </div>

    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Back to Products</a>
</div>
@endsection
