<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="card-title text-success">Order Placed Successfully!</h2>
                        <p class="card-text">Thank you for your purchase. Your order has been placed and will be processed shortly.</p>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                            <a href="{{ route('orders') }}" class="btn btn-outline-secondary">View Orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
