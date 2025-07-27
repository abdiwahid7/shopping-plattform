<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
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
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('products.index', ['category' => 'smartphones']) }}">Smartphones</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['category' => 'laptops']) }}">Laptops</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['category' => 'gaming']) }}">Gaming</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['category' => 'accessories']) }}">Accessories</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['category' => 'tablets']) }}">Tablets</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['category' => 'audio']) }}">Audio</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['category' => 'cameras']) }}">Cameras</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.index', ['category' => 'computers']) }}">Computers</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('products.index') }}">All Products</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <!-- Search Form -->
                    <li class="nav-item me-3">
                        <form class="d-flex" role="search" action="{{ route('products.index') }}" method="GET">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <input class="form-control me-2" type="search" name="search" placeholder="Search products..." style="width: 200px;" value="{{ request('search') }}">
                            <button class="btn btn-outline-light" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </li>

                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> Cart
                            @php
                                $cartCount = array_sum(Session::get('cart', []));
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user-edit"></i> Profile
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('orders') }}">
                                    <i class="fas fa-box"></i> Orders
                                </a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cogs"></i> Admin Panel
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold">
                        @if(request('category'))
                            {{ ucfirst(request('category')) }} Products
                        @else
                            Our Products
                        @endif
                    </h1>
                    <p class="lead">Discover amazing electronics at great prices</p>
                </div>
                <div class="col-md-4 text-md-end">
                    @if(request('category'))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-light">
                            <i class="fas fa-arrow-left"></i> All Products
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search Results Info -->
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(request('search') || request('category'))
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Filters Applied:</strong>
                @if(request('search'))
                    Search: "{{ request('search') }}"
                @endif
                @if(request('category'))
                    {{ request('search') ? ' | ' : '' }}Category: {{ ucfirst(request('category')) }}
                @endif
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary ms-2">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <div class="container my-5">
        @if($products->count() > 0)
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="text-muted">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <form action="{{ route('products.index') }}" method="GET" class="d-inline">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <select name="sort" class="form-select d-inline w-auto" onchange="this.form.submit()">
                            <option value="">Sort by</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low-High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High-Low</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm product-card">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-secondary">{{ ucfirst($product->category) }}</span>
                                    @if($product->stock <= 5 && $product->stock > 0)
                                        <span class="badge bg-warning text-dark">Low Stock</span>
                                    @elseif($product->stock == 0)
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </div>
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($product->description, 120) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="h4 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                                        <small class="text-muted">
                                            <i class="fas fa-box"></i> Stock: {{ $product->stock }}
                                        </small>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                        @if($product->stock > 0)
                                            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-outline-primary">
                                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-outline-secondary" disabled>
                                                <i class="fas fa-times"></i> Out of Stock
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-5x text-muted mb-4"></i>
                <h4>No products found</h4>
                <p class="text-muted">
                    @if(request('search'))
                        No products match your search "{{ request('search') }}"
                        @if(request('category'))
                            in {{ ucfirst(request('category')) }} category
                        @endif
                    @else
                        No products available in this category
                    @endif
                </p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> View All Products
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-bolt"></i> ElectroMart</h5>
                    <p>Your trusted electronics store since 2024</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2024 ElectroMart. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add some hover effects
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add loading state to add to cart buttons
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
                button.disabled = true;

                // Re-enable button after form submission (in case of errors)
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                }, 3000);
            });
        });
    </script>
</body>
</html>
