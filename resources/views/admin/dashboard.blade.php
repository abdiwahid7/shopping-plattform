<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <strong>⚙️ Admin Panel</strong>
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ url('/') }}">View Site</a>
                <a class="nav-link" href="{{ url('/logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 bg-light sidebar py-4">
                <h5>Admin Menu</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">Users</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 py-4">
                <h1>Admin Dashboard</h1>
                <p>Welcome to the admin panel, {{ Auth::user()->name }}!</p>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>Products</h5>
                                <p class="h3">{{ \App\Models\Product::count() }}</p>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Manage Products</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5>Users</h5>
                                <p class="h3">{{ \App\Models\User::count() }}</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Manage Users</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
