<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order #{{ $order->order_number }} - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
        #map {
            height: 400px;
            width: 100%;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Track Order</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-truck"></i> Track Order #{{ $order->order_number }}
                        </h4>
                        @if($order->canBeCancelled())
                            <form action="{{ route('orders.cancel', $order) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times"></i> Cancel Order
                                </button>
                            </form>
                        @endif
                    </div>
                    <div class="card-body">
                        <!-- Order Status -->
                        <div class="mb-4">
                            <h6>Current Status:
                                <span class="{{ $order->status_badge }}">
                                    <i class="{{ $order->status_icon }}"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </h6>
                            @if($order->tracking_number)
                                <p class="text-muted mb-0">Tracking Number: {{ $order->tracking_number }}</p>
                            @endif
                        </div>

                        <!-- Tracking Steps -->
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
                    </div>
                </div>

                <!-- Shipping Map -->
                @if(in_array($order->status, ['shipped', 'delivered']))
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> Live Tracking</h5>
                        </div>
                        <div class="card-body">
                            <div id="map"></div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        @foreach($order->items as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <h6 class="mb-0">{{ $item->product_name }}</h6>
                                    <small class="text-muted">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</small>
                                </div>
                                <span>${{ number_format($item->total, 2) }}</span>
                            </div>
                        @endforeach
                        <hr>
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
                            <strong>Total: ${{ number_format($order->total_amount, 2) }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <address>
                            {{ $order->billing_first_name }} {{ $order->billing_last_name }}<br>
                            {{ $order->billing_address }}<br>
                            {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postal_code }}<br>
                            {{ $order->billing_country }}
                        </address>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list"></i> All Orders
            </a>
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-home"></i> Continue Shopping
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    @if(in_array($order->status, ['shipped', 'delivered']))
    <script>
        // Initialize the map
        var map = L.map('map').setView([40.7128, -74.0060], 10); // Default to NYC

        // Add tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Sample tracking points (in real app, this would come from your tracking system)
        var trackingPoints = [
            {lat: 40.7589, lng: -73.9851, time: '2024-01-15 09:00', status: 'Picked up from warehouse'},
            {lat: 40.7505, lng: -73.9934, time: '2024-01-15 12:30', status: 'In transit - Distribution center'},
            {lat: 40.7282, lng: -74.0776, time: '2024-01-15 15:45', status: 'Out for delivery'},
            @if($order->status == 'delivered')
            {lat: 40.7128, lng: -74.0060, time: '{{ $order->delivered_at ? $order->delivered_at->format("Y-m-d H:i") : now()->format("Y-m-d H:i") }}', status: 'Delivered'}
            @endif
        ];

        // Add markers and route
        var routePoints = [];
        trackingPoints.forEach(function(point, index) {
            var marker = L.marker([point.lat, point.lng]).addTo(map);
            marker.bindPopup(`<b>${point.status}</b><br>${point.time}`);
            routePoints.push([point.lat, point.lng]);

            // Highlight current location
            if (index === trackingPoints.length - 1 && '{{ $order->status }}' !== 'delivered') {
                marker.setIcon(L.icon({
                    iconUrl: 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iIzAwN2NmZiIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJDOC4xMyAyIDUgNS4xMyA1IDlDNSAxNC4yNSAxMiAyMiAxMiAyMkMxMiAyMiAxOSAxNC4yNSAxOSA5QzE5IDUuMTMgMTUuODcgMiAxMiAyWk0xMiAxMS41QzEwLjYyIDExLjUgOS41IDEwLjM4IDkuNSA5QzkuNSA3LjYyIDEwLjYyIDYuNSAxMiA2LjVDMTMuMzggNi41IDE0LjUgNy42MiAxNC41IDlDMTQuNSAxMC4zOCAxMy4zOCAxMS41IDEyIDExLjVaIi8+Cjwvc3ZnPg==',
                    iconSize: [30, 30],
                    iconAnchor: [15, 30]
                }));
            }
        });

        // Draw route line
        if (routePoints.length > 1) {
            L.polyline(routePoints, {color: '#007cff', weight: 3}).addTo(map);
        }

        // Fit map to show all points
        if (routePoints.length > 0) {
            map.fitBounds(routePoints);
        }
    </script>
    @endif
</body>
</html>
