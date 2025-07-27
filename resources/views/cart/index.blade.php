<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <strong>⚡ Electro Mart</strong>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/products') }}">Products</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/products?category=smartphones') }}">Smartphones</a></li>
                            <li><a class="dropdown-item" href="{{ url('/products?category=laptops') }}">Laptops</a></li>
                            <li><a class="dropdown-item" href="{{ url('/products?category=gaming') }}">Gaming</a></li>
                            <li><a class="dropdown-item" href="{{ url('/products?category=accessories') }}">Accessories</a></li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <!-- Cart -->
<li class="nav-item">
    <a class="nav-link position-relative active" href="{{ url('/cart') }}">
        🛒 Cart
        @php
            $cartCount = 0;
            if(Session::has('cart')) {
                $cart = Session::get('cart');
                $cartCount = array_sum(array_column($cart, 'quantity'));
            }
        @endphp
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $cartCount }}
        </span>
    </a>
</li>

                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ url('/orders') }}">Orders</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Header -->
    <div class="bg-primary text-white py-4">
        <div class="container">
            <h1 class="display-5 fw-bold">Shopping Cart</h1>
            <p class="lead">Review your items before checkout</p>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="container my-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Cart Items</h5>
                            <form method="POST" action="{{ route('cart.clear') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to clear the cart?')">
                                    Clear Cart
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            @foreach($cart as $item)
                                <div class="row align-items-center mb-3 pb-3 border-bottom">
                                    <div class="col-md-2">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}"
                                                 class="img-fluid rounded" alt="{{ $item['name'] }}">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 80px;">
                                                <span class="text-muted">No Image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <h6 class="mb-1">{{ $item['name'] }}</h6>
                                        <p class="text-muted mb-0">${{ number_format($item['price'], 2) }} each</p>
                                    </div>
                                    <div class="col-md-3">
                                        <form method="POST" action="{{ route('cart.update') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                            <div class="input-group">
                                                <input type="number" class="form-control" name="quantity"
                                                       value="{{ $item['quantity'] }}" min="1" max="10">
                                                <button type="submit" class="btn btn-outline-primary btn-sm">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-2">
                                        <strong>${{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                    </div>
                                    <div class="col-md-1">
                                        <form method="POST" action="{{ route('cart.remove') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Remove this item from cart?')">
                                                ×
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Tax:</span>
                                <span>${{ number_format($total * 0.1, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <strong>Total: </strong>
                                <strong>${{ number_format($total * 1.1, 2) }}</strong>
                            </div>

                            @auth
                                <a href="{{ url('/checkout') }}" class="btn btn-primary w-100 mb-2">
                                    Proceed to Checkout
                                </a>
                            @else
                                <a href="{{ url('/login') }}" class="btn btn-primary w-100 mb-2">
                                    Login to Checkout
                                </a>
                            @endauth

                            <a href="{{ url('/products') }}" class="btn btn-outline-secondary w-100">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <h4>Your cart is empty</h4>
                <p class="text-muted">Add some products to your cart to get started!</p>
                <a href="{{ url('/products') }}" class="btn btn-primary">Browse Products</a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Electro Mart</h5>
                    <p>Your trusted electronics store since 2024</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2024 Electro Mart. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
