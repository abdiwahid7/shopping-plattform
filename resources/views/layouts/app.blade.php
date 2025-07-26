<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Electro Mart') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <div id="app">
        <nav>
            <!-- Navigation links go here -->
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        <footer>
            <!-- Footer content goes here -->
        </footer>
    </div>
</body>
</html>
