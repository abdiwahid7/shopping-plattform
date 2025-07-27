<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ config('app.name') }}</title>
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
                        <!-- Admin Panel Link (only for admin users) -->
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link text-warning" href="{{ route('admin.dashboard') }}">
                                    <strong>⚙️ Admin Panel</strong>
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profile') }}">Profile</a></li>
                                <li><a class="dropdown-item" href="{{ url('/orders') }}">Orders</a></li>
                                @if(Auth::user()->role === 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-warning" href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                                @endif
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

    <!-- Welcome Header -->
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

    <!-- Dashboard Content -->
    <div class="container my-5">
        <!-- Quick Stats -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <span class="h4 mb-0">📦</span>
                        </div>
                        <h4 class="mt-3 mb-1">{{ Auth::user()->orders()->count() }}</h4>
                        <p class="text-muted mb-0">Total Orders</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <span class="h4 mb-0">✅</span>
                        </div>
                        <h4 class="mt-3 mb-1">{{ Auth::user()->orders()->where('status', 'delivered')->count() }}</h4>
                        <p class="text-muted mb-0">Delivered</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <span class="h4 mb-0">🚚</span>
                        </div>
                        <h4 class="mt-3 mb-1">{{ Auth::user()->orders()->whereIn('status', ['pending', 'processing', 'shipped'])->count() }}</h4>
                        <p class="text-muted mb-0">In Progress</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm">
                    <div class="card-body">
                        <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                            <span class="h4 mb-0">💰</span>
                        </div>
                        <h4 class="mt-3 mb-1">${{ number_format(Auth::user()->orders()->sum('total_amount'), 2) }}</h4>
                        <p class="text-muted mb-0">Total Spent</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Cards -->
        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <span class="display-6">👤</span>
                        </div>
                        <h5 class="card-title">My Profile</h5>
                        <p class="card-text text-muted">Update your personal information, change password, and manage account settings</p>
                        <a href="{{ url('/profile') }}" class="btn btn-primary">Manage Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <span class="display-6">📋</span>
                        </div>
                        <h5 class="card-title">My Orders</h5>
                        <p class="card-text text-muted">Track your current orders, view order history, and download invoices</p>
                        <a href="{{ url('/orders') }}" class="btn btn-success">View Orders</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <span class="display-6">🛒</span>
                        </div>
                        <h5 class="card-title">Shopping Cart</h5>
                        <p class="card-text text-muted">Review items in your cart and proceed to checkout when ready</p>
                        <a href="{{ url('/cart') }}" class="btn btn-warning">View Cart</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        @if(Auth::user()->orders()->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Orders</h5>
                            <a href="{{ url('/orders') }}" class="btn btn-primary btn-sm">View All Orders</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Order #</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Auth::user()->orders()->latest()->take(5)->get() as $order)
                                            <tr>
                                                <td><strong>#{{ $order->id }}</strong></td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                                <td>
                                                    <span class="badge bg-{{
                                                        $order->status == 'delivered' ? 'success' :
                                                        ($order->status == 'cancelled' ? 'danger' :
                                                        ($order->status == 'shipped' ? 'info' : 'warning'))
                                                    }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ url('/orders/' . $order->id) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ url('/products') }}" class="btn btn-outline-primary w-100">
                                    <i class="me-2">🔍</i>Browse Products
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ url('/products?category=smartphones') }}" class="btn btn-outline-secondary w-100">
                                    <i class="me-2">📱</i>Smartphones
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ url('/products?category=laptops') }}" class="btn btn-outline-secondary w-100">
                                    <i class="me-2">💻</i>Laptops
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ url('/products?category=gaming') }}" class="btn btn-outline-secondary w-100">
                                    <i class="me-2">🎮</i>Gaming
                                </a>
                            </div>
                        </div>
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
