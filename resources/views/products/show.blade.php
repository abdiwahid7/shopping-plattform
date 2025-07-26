<div>
    <h1>{{ $product->name }}</h1>
    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
    <p>{{ $product->description }}</p>
    <p>Price: ${{ $product->price }}</p>

    <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <button type="submit">Add to Cart</button>
    </form>

    <a href="{{ route('products.index') }}">Back to Products</a>
</div>