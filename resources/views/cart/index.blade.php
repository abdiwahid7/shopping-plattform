<div>
    <h1>Shopping Cart</h1>
    <div>
        @if(session('cart'))
            <ul>
                @foreach(session('cart') as $item)
                    <li>
                        {{ $item['name'] }} - {{ $item['quantity'] }} x ${{ $item['price'] }}
                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Remove</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            <h3>Total: ${{ array_sum(array_column(session('cart'), 'price')) }}</h3>
            <a href="{{ route('checkout.index') }}">Proceed to Checkout</a>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
</div>