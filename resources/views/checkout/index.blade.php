<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart.index') }}">Cart</a></li>
                        <li class="breadcrumb-item active">Checkout</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Checkout</h1>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.process') }}">
            @csrf
            <div class="row">
                <!-- Billing Information -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-user"></i> Billing Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_first_name" class="form-label">First Name *</label>
                                    <input type="text" class="form-control @error('billing_first_name') is-invalid @enderror"
                                           id="billing_first_name" name="billing_first_name"
                                           value="{{ old('billing_first_name') }}" required>
                                    @error('billing_first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="billing_last_name" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control @error('billing_last_name') is-invalid @enderror"
                                           id="billing_last_name" name="billing_last_name"
                                           value="{{ old('billing_last_name') }}" required>
                                    @error('billing_last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('billing_email') is-invalid @enderror"
                                           id="billing_email" name="billing_email"
                                           value="{{ old('billing_email', auth()->user()->email ?? '') }}" required>
                                    @error('billing_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="billing_phone" class="form-label">Phone *</label>
                                    <input type="tel" class="form-control @error('billing_phone') is-invalid @enderror"
                                           id="billing_phone" name="billing_phone"
                                           value="{{ old('billing_phone') }}" required>
                                    @error('billing_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="billing_address" class="form-label">Address *</label>
                                <input type="text" class="form-control @error('billing_address') is-invalid @enderror"
                                       id="billing_address" name="billing_address"
                                       value="{{ old('billing_address') }}" required>
                                @error('billing_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_city" class="form-label">City *</label>
                                    <input type="text" class="form-control @error('billing_city') is-invalid @enderror"
                                           id="billing_city" name="billing_city"
                                           value="{{ old('billing_city') }}" required>
                                    @error('billing_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="billing_state" class="form-label">State *</label>
                                    <input type="text" class="form-control @error('billing_state') is-invalid @enderror"
                                           id="billing_state" name="billing_state"
                                           value="{{ old('billing_state') }}" required>
                                    @error('billing_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_postal_code" class="form-label">Postal Code *</label>
                                    <input type="text" class="form-control @error('billing_postal_code') is-invalid @enderror"
                                           id="billing_postal_code" name="billing_postal_code"
                                           value="{{ old('billing_postal_code') }}" required>
                                    @error('billing_postal_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="billing_country" class="form-label">Country *</label>
                                    <select class="form-control @error('billing_country') is-invalid @enderror"
                                            id="billing_country" name="billing_country" required>
                                        <option value="">Select Country</option>
                                        <option value="US" {{ old('billing_country') == 'US' ? 'selected' : '' }}>United States</option>
                                        <option value="CA" {{ old('billing_country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                        <option value="UK" {{ old('billing_country') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="AU" {{ old('billing_country') == 'AU' ? 'selected' : '' }}>Australia</option>
                                    </select>
                                    @error('billing_country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-credit-card"></i> Payment Method</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <select class="form-control @error('payment_method') is-invalid @enderror"
                                        id="payment_method" name="payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-receipt"></i> Order Summary</h5>
                        </div>
                        <div class="card-body">
                            @if(!empty($cartItems))
                                @foreach($cartItems as $item)
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <h6 class="mb-0">{{ $item['product']->name }}</h6>
                                            <small class="text-muted">Qty: {{ $item['quantity'] }} × ${{ number_format($item['product']->price, 2) }}</small>
                                        </div>
                                        <span>${{ number_format($item['total'], 2) }}</span>
                                    </div>
                                @endforeach
                                <hr>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>${{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Tax (8%):</span>
                                    <span>${{ number_format($tax, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Shipping:</span>
                                    <span>${{ number_format($shipping, 2) }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total: ${{ number_format($total, 2) }}</strong>
                                </div>
                            @else
                                <p class="text-muted">Your cart is empty.</p>
                            @endif
                        </div>
                        @if(!empty($cartItems))
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-block w-100">
                                    <i class="fas fa-lock"></i> Place Order
                                </button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-block w-100 mt-2">
                                    <i class="fas fa-arrow-left"></i> Back to Cart
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
