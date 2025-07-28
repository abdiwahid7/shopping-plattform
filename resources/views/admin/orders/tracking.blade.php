<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order #{{ $order->order_number }} - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .tracking-step {
            position: relative;
            padding-left: 45px;
            padding-bottom: 30px;
        }
        .tracking-step:before {
            content: '';
            position: absolute;
            left: 15px;
            top: 25px;
            height: calc(100% - 25px);
            width: 2px;
            background-color: #dee2e6;
        }
        .tracking-step:last-child:before {
            display: none;
        }
        .tracking-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        .tracking-step.completed .tracking-icon {
            background-color: #198754;
            color: white;
        }
        .tracking-step.active .tracking-icon {
            background-color: #0d6efd;
            color: white;
        }
        .tracking-step.pending .tracking-icon {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-truck"></i> Track Order #{{ $order->order_number }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                                <p><strong>Status:</strong>
                                    <span class="{{ $order->status_badge }}">
                                        {{ ucfirst($order->status) }}
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
                            </div>
                        </div>

                        <hr>

                        <!-- Tracking Timeline -->
                        <div class="tracking-timeline">
                            <div class="tracking-step {{ in_array($order->status, ['pending', 'processing', 'shipped', 'delivered']) ? 'completed' : 'pending' }}">
                                <div class="tracking-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div>
                                    <h6>Order Placed</h6>
                                    <p class="text-muted mb-0">{{ $order->created_at->format('M d, Y g:i A') }}</p>
                                    <small class="text-muted">Your order has been placed successfully.</small>
                                </div>
                            </div>

                            <div class="tracking-step {{ in_array($order->status, ['processing', 'shipped', 'delivered']) ? 'completed' : ($order->status == 'pending' ? 'pending' : 'pending') }}">
                                <div class="tracking-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <div>
                                    <h6>Processing</h6>
                                    @if($order->status == 'processing')
                                        <p class="text-muted mb-0">{{ now()->format('M d, Y g:i A') }}</p>
                                    @endif
                                    <small class="text-muted">Your order is being prepared for shipment.</small>
                                </div>
                            </div>

                            <div class="tracking-step {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : ($order->status == 'processing' ? 'active' : 'pending') }}">
                                <div class="tracking-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <div>
                                    <h6>Shipped</h6>
                                    @if($order->shipped_at)
                                        <p class="text-muted mb-0">{{ $order->shipped_at->format('M d, Y g:i A') }}</p>
                                    @endif
                                    <small class="text-muted">Your order has been shipped and is on its way.</small>
                                    @if($order->tracking_number)
                                        <br><small class="text-info">Tracking: {{ $order->tracking_number }}</small>
                                    @endif
                                </div>
                            </div>

                            <div class="tracking-step {{ $order->status == 'delivered' ? 'completed' : ($order->status == 'shipped' ? 'active' : 'pending') }}">
                                <div class="tracking-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div>
                                    <h6>Delivered</h6>
                                    @if($order->delivered_at)
                                        <p class="text-muted mb-0">{{ $order->delivered_at->format('M d, Y g:i A') }}</p>
                                    @endif
                                    <small class="text-muted">Your order has been delivered successfully.</small>
                                </div>
                            </div>
                        </div>

                        @if($order->notes)
                            <hr>
                            <div class="alert alert-info">
                                <strong>Additional Notes:</strong><br>
                                {{ $order->notes }}
                            </div>
                        @endif

                        <div class="text-center mt-4">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">
                                <i class="fas fa-eye"></i> View Order Details
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list"></i> All Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
