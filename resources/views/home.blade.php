<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Your Electronics Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        .product-card {
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-bolt"></i> ElectroMart
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Cart
                        </a>
                    </li>

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders') }}">My Orders</a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @auth
        <!-- Welcome Header for Authenticated Users -->
        <div class="bg-primary text-white py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="display-6 fw-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                        <p class="lead mb-0">Manage your account, track orders, and discover new products</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <span class="badge bg-light text-primary fs-6">{{ ucfirst(Auth::user()->role) }} Account</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Content for Authenticated Users -->
        <div class="container my-5">
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-user-circle fa-3x text-primary mb-3"></i>
                            <h5>Profile</h5>
                            <p class="text-muted">Manage your account settings</p>
                            <a href="{{ route('profile') }}" class="btn btn-outline-primary">View Profile</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-box fa-3x text-success mb-3"></i>
                            <h5>Orders</h5>
                            <p class="text-muted">Track your order history</p>
                            <a href="{{ route('orders') }}" class="btn btn-outline-success">View Orders</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-shopping-cart fa-3x text-warning mb-3"></i>
                            <h5>Cart</h5>
                            <p class="text-muted">Review items in your cart</p>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-warning">View Cart</a>
                        </div>
                    </div>
                </div>
                @if(Auth::user()->role === 'admin')
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-cogs fa-3x text-danger mb-3"></i>
                                <h5>Admin Panel</h5>
                                <p class="text-muted">Manage the store</p>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-danger">Admin Panel</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Hero Section for Guest Users -->
        <section class="hero-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="display-4 fw-bold mb-4">Welcome to ElectroMart</h1>
                        <p class="lead mb-4">Discover the latest electronics, gadgets, and tech accessories at unbeatable prices. Your one-stop shop for all things electronic!</p>
                        <div class="d-flex gap-3">
                            <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-shopping-bag"></i> Shop Now
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-user-plus"></i> Join Us
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="https://via.placeholder.com/600x400/667eea/white?text=Electronics" alt="Electronics" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4 mb-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h4>Fast Shipping</h4>
                        <p class="text-muted">Get your electronics delivered quickly with our express shipping options.</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Secure Shopping</h4>
                        <p class="text-muted">Shop with confidence knowing your data and payments are secure.</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4>24/7 Support</h4>
                        <p class="text-muted">Our customer support team is here to help you around the clock.</p>
                    </div>
                </div>
            </div>
        </section>
    @endauth

    <!-- Featured Products Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold">Featured Products</h2>
                <p class="lead text-muted">Check out our latest and most popular items</p>
            </div>

            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card h-100">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x200/f8f9fa/6c757d?text={{ urlencode($product->name) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary mb-0">${{ number_format($product->price, 2) }}</h6>
                                    <span class="badge bg-secondary">{{ ucfirst($product->category) }}</span>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm me-2">View Details</a>
                                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No products available at the moment.</p>
                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add First Product</a>
                            @endif
                        @endauth
                    </div>
                @endforelse
            </div>

            @if($products->count() > 0)
                <div class="text-center mt-4">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-arrow-right"></i> View All Products
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-bolt"></i> ElectroMart</h5>
                    <p class="text-muted">Your trusted electronics store since 2024.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted">&copy; 2024 ElectroMart. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
