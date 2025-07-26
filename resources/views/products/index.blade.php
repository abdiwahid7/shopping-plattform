<div>
    <h1>Electro Mart</h1>
    <h2>Products</h2>
    <div class="product-list">
        @foreach($products as $product)
            <div class="product-item">
                <h3><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></h3>
                <p>{{ $product->description }}</p>
                <p>Price: ${{ number_format($product->price, 2) }}</p>
                <a href="{{ route('cart.add', $product->id) }}" class="btn btn-primary">Add to Cart</a>
            </div>
        @endforeach
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>
</div>