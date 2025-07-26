<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - {{ config('app.name') }}</title>
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
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a>
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

    <!-- Page Header -->
    <div class="bg-primary text-white py-4">
        <div class="container">
            <h1 class="display-5 fw-bold">About Electro Mart</h1>
            <p class="lead">Your trusted electronics partner since 2024</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title mb-4">Our Story</h2>
                        <p class="lead">
                            Welcome to Electro Mart, your premier destination for cutting-edge electronics and technology products.
                        </p>
                        <p>
                            Founded in 2024, Electro Mart has quickly established itself as a trusted name in the electronics retail industry. We specialize in bringing you the latest smartphones, laptops, gaming equipment, and accessories from top brands around the world.
                        </p>
                        <p>
                            Our mission is simple: to provide our customers with high-quality electronics at competitive prices, backed by exceptional customer service. We believe that technology should be accessible to everyone, and we work hard to make that a reality.
                        </p>

                        <h3 class="mt-4 mb-3">Why Choose Electro Mart?</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            ✓
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5>Quality Products</h5>
                                        <p class="text-muted">Only authentic products from trusted brands</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            🚚
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5>Fast Shipping</h5>
                                        <p class="text-muted">Quick and reliable delivery nationwide</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            💰
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5>Best Prices</h5>
                                        <p class="text-muted">Competitive pricing with regular deals</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            🛡️
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h5>Warranty Support</h5>
                                        <p class="text-muted">Full warranty coverage on all products</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Quick Stats</h5>
                        <div class="row g-3 text-center">
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <h3 class="text-primary mb-1">10K+</h3>
                                    <small class="text-muted">Happy Customers</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <h3 class="text-primary mb-1">500+</h3>
                                    <small class="text-muted">Products</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <h3 class="text-primary mb-1">50+</h3>
                                    <small class="text-muted">Brands</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <h3 class="text-primary mb-1">24/7</h3>
                                    <small class="text-muted">Support</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Our Categories</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ url('/products?category=smartphones') }}" class="text-decoration-none">📱 Smartphones</a></li>
                            <li class="mb-2"><a href="{{ url('/products?category=laptops') }}" class="text-decoration-none">💻 Laptops</a></li>
                            <li class="mb-2"><a href="{{ url('/products?category=gaming') }}" class="text-decoration-none">🎮 Gaming</a></li>
                            <li class="mb-2"><a href="{{ url('/products?category=accessories') }}" class="text-decoration-none">🔌 Accessories</a></li>
                        </ul>
                        <a href="{{ url('/products') }}" class="btn btn-primary w-100">View All Products</a>
                    </div>
                </div>
            </div>
        </div>
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
