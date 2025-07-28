<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->order_number }} - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
                        <li class="breadcrumb-item active">Order #{{ $order->order_number }}</li>
                    </ol>
                </nav>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3">Order #{{ $order->order_number }}</h1>
                    @if($order->tracking_number)
                        <a href="{{ route('orders.track', $order->order_number) }}" class="btn btn-info">
                            <i class="fas fa-truck"></i> Track Order
                        </a>
                    @endif
                </div>

                <div class="row">
                    <!-- Order Status -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Order Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Status:</strong>
                                            <span class="{{ $order->status_badge }}">
                                                <i class="{{ $order->status_icon }}"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y g:i A') }}</p>
                                        <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                                        <p><strong>Payment Status:</strong>
                                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        @if($order->tracking_number)
                                            <p><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
                                        @endif
                                        @if($order->shipped_at)
                                            <p><strong>Shipped Date:</strong> {{ $order->shipped_at->format('M d, Y g:i A') }}</p>
                                        @endif
                                        @if($order->delivered_at)
                                            <p><strong>Delivered Date:</strong> {{ $order->delivered_at->format('M d, Y g:i A') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Order Items</h5>
                            </div>
                            <div class="card-body">
                                @foreach($order->items as $item)
                                    <div class="row align-items-center mb-3 pb-3 border-bottom">
                                        <div class="col-md-6">
                                            <h6 class="mb-1">{{ $item->product_name }}</h6>
                                            <small class="text-muted">SKU: {{ $item->product_id }}</small>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <span>{{ $item->quantity }}</span>
                                        </div>
                                        <div class="col-md-2 text-center">
                                            <span>${{ number_format($item->product_price, 2) }}</span>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <strong>${{ number_format($item->total, 2) }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary & Billing -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax:</span>
                                    <span>${{ number_format($order->tax, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span>${{ number_format($order->shipping, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total: ${{ number_format($order->total, 2) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Billing Address</h5>
                            </div>
                            <div class="card-body">
                                <address>
                                    <strong>{{ $order->billing_first_name }} {{ $order->billing_last_name }}</strong><br>
                                    {{ $order->billing_address }}<br>
                                    {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postal_code }}<br>
                                    {{ $order->billing_country }}<br>
                                    <abbr title="Phone">P:</abbr> {{ $order->billing_phone }}<br>
                                    <abbr title="Email">E:</abbr> {{ $order->billing_email }}
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
