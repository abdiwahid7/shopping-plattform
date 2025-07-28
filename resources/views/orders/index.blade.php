@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-shopping-bag"></i> My Orders</h2>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-cart"></i> Continue Shopping
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($orders->count() > 0)
                <div class="row">
                    @foreach($orders as $order)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Order #{{ $order->order_number }}</h6>
                                    <span class="{{ $order->status_badge }}">
                                        <i class="{{ $order->status_icon }}"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-2">
                                        <i class="fas fa-calendar"></i>
                                        {{ $order->created_at->format('M d, Y g:i A') }}
                                    </p>
                                    <p class="mb-2">
                                        <strong>Total: ${{ number_format($order->total_amount, 2) }}</strong>
                                    </p>
                                    <p class="text-muted mb-3">
                                        {{ $order->items->count() }} item(s)
                                    </p>

                                    <div class="d-grid gap-2">
                                        <a href="{{ route('orders.track', $order->order_number) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-truck"></i> Track Order
                                        </a>
                                        <a href="{{ route('orders.show', $order) }}"
                                           class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                        @if($order->canBeCancelled())
                                            <form action="{{ route('orders.cancel', $order) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                                    <i class="fas fa-times"></i> Cancel Order
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-shopping-bag text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-muted">No Orders Found</h4>
                    <p class="text-muted">You haven't placed any orders yet.</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i> Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
