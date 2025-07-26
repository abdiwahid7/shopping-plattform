<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
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
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ url('/products') }}">Products</a>
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
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('/products') }}">All Products</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/contact') }}">Contact</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <!-- Search Form -->
                    <li class="nav-item me-3">
                        <form class="d-flex" role="search" action="{{ url('/products') }}" method="GET">
                            <input class="form-control me-2" type="search" name="search" placeholder="Search products..." style="width: 200px;" value="{{ request('search') }}">
                            <button class="btn btn-outline-light" type="submit">Search</button>
                        </form>
                    </li>

                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ url('/cart') }}">
                            🛒 Cart
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                0
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

    <!-- Hero Section -->
    <div class="bg-primary text-white py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold">Welcome to Electro Mart</h1>
            <p class="lead">Your one-stop shop for all electronic needs</p>
            <a href="{{ url('/products') }}" class="btn btn-light btn-lg">Shop Now</a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Featured Products</h2>

        @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span class="text-muted">No Image</span>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                                        <small class="text-muted">Stock: {{ $product->stock }}</small>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ url('/products/' . $product->id) }}" class="btn btn-primary btn-sm">View Details</a>
                                        <button class="btn btn-outline-primary btn-sm" onclick="addToCart({{ $product->id }})">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <h4>No products available at the moment</h4>
                <p class="text-muted">Please check back later!</p>
                <a href="{{ url('/products') }}" class="btn btn-primary">Browse All Products</a>
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
    <script>
        function addToCart(productId) {
            // Add to cart functionality - you can implement this later
            alert('Product added to cart! (Feature coming soon)');
        }
    </script>
</body>
</html>
