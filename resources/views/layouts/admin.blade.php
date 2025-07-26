<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Electro Mart</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <h1>Electro Mart Admin</h1>
            <nav>
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.products.index') }}">Products</a></li>
                    <li><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                    <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li><a href="{{ route('logout') }}">Logout</a></li>
                </ul>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer>
            <p>&copy; {{ date('Y') }} Electro Mart. All rights reserved.</p>
        </footer>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>