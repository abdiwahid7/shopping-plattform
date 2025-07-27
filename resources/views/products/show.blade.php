<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-bolt"></i> ElectroMart
            </a>

            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-home"></i> Home
                </a>
                <a class="nav-link" href="{{ route('products.index') }}">
                    <i class="fas fa-shopping-bag"></i> Products
                </a>
                <a class="nav-link" href="{{ route('cart.index') }}">
                    <i class="fas fa-shopping-cart"></i> Cart
                    @php
                        $cartCount = array_sum(Session::get('cart', []));
                    @endphp
                    @if($cartCount > 0)
                        <span class="badge bg-danger rounded-pill">{{ $cartCount }}</span>
                    @endif
                </a>
                @auth
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i class="fas fa-user"></i> Dashboard
                    </a>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="bg-light py-2">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category]) }}">{{ ucfirst($product->category) }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container my-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="card">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top img-fluid" alt="{{ $product->name }}" style="height: 500px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 500px;">
                            <i class="fas fa-image fa-5x text-muted"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div class="ps-lg-4">
                    <!-- Product Category -->
                    <div class="mb-3">
                        <span class="badge bg-primary fs-6">{{ ucfirst($product->category) }}</span>
                        @if($product->stock <= 5 && $product->stock > 0)
                            <span class="badge bg-warning text-dark fs-6">Low Stock</span>
                        @elseif($product->stock == 0)
                            <span class="badge bg-danger fs-6">Out of Stock</span>
                        @else
                            <span class="badge bg-success fs-6">In Stock</span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="display-5 fw-bold mb-3">{{ $product->name }}</h1>

                    <!-- Product Price -->
                    <div class="mb-4">
                        <span class="display-4 text-primary fw-bold">${{ number_format($product->price, 2) }}</span>
                    </div>

                    <!-- Product Description -->
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p class="text-muted">{{ $product->description }}</p>
                    </div>

                    <!-- Product Details -->
                    <div class="mb-4">
                        <h5>Product Details</h5>
                        <ul class="list-unstyled">
                            <li><strong>Category:</strong> {{ ucfirst($product->category) }}</li>
                            <li><strong>Availability:</strong>
                                @if($product->stock > 0)
                                    <span class="text-success">{{ $product->stock }} items in stock</span>
                                @else
                                    <span class="text-danger">Out of stock</span>
                                @endif
                            </li>
                            <li><strong>Product ID:</strong> #{{ $product->id }}</li>
                        </ul>
                    </div>

                    <!-- Add to Cart Section -->
                    @if($product->stock > 0)
                        <div class="mb-4">
                            <form action="{{ route('cart.add') }}" method="POST" id="addToCartForm">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label for="quantity" class="form-label">Quantity</label>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                                            <input type="number" class="form-control text-center" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                            <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                                        </div>
                                        <small class="text-muted">Max: {{ $product->stock }}</small>
                                    </div>
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-cart-plus"></i> Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mb-4">
                            <button class="btn btn-secondary btn-lg w-100" disabled>
                                <i class="fas fa-times"></i> Out of Stock
                            </button>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Products
                        </a>
                        <a href="{{ route('products.index', ['category' => $product->category]) }}" class="btn btn-outline-primary">
                            <i class="fas fa-list"></i> More {{ ucfirst($product->category) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        <div class="mt-5">
            <h3 class="mb-4">Related Products</h3>
            <div class="row g-4">
                @php
                    $relatedProducts = App\Models\Product::where('category', $product->category)
                                                        ->where('id', '!=', $product->id)
                                                        ->take(3)
                                                        ->get();
                @endphp

                @forelse($relatedProducts as $relatedProduct)
                    <div class="col-md-4">
                        <div class="card h-100">
                            @if($relatedProduct->image)
                                <img src="{{ asset('storage/' . $relatedProduct->image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                                <p class="card-text text-muted small">{{ Str::limit($relatedProduct->description, 80) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="h6 text-primary mb-0">${{ number_format($relatedProduct->price, 2) }}</span>
                                        <small class="text-muted">Stock: {{ $relatedProduct->stock }}</small>
                                    </div>
                                    <a href="{{ route('products.show', $relatedProduct) }}" class="btn btn-outline-primary btn-sm w-100">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No related products found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-bolt"></i> ElectroMart</h5>
                    <p>Your trusted electronics store since 2024</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; 2024 ElectroMart. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);
            const maxValue = parseInt(quantityInput.max);

            if (currentValue < maxValue) {
                quantityInput.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity');
            const currentValue = parseInt(quantityInput.value);

            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        }

        // Add loading state to add to cart form
        document.getElementById('addToCartForm').addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding to Cart...';
            button.disabled = true;

            // Re-enable button after form submission (in case of errors)
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 3000);
        });
    </script>
</body>
</html>
