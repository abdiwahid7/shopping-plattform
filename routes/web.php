<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Authentication Routes - Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout route - Authenticated users only
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes - Authenticated users only
Route::middleware('auth')->group(function () {
    // User Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User Profile
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // User Orders
    Route::get('/orders', function () {
        return view('orders');
    })->name('orders');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Admin Routes - Admin users only
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Admin Product Management
    Route::resource('products', AdminProductController::class);

    // Admin Category Management
    Route::resource('categories', CategoryController::class);

    // Admin Order Management
    Route::resource('orders', OrderController::class);

    // Admin User Management
    Route::resource('users', UserController::class);
});

// Static Pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Search Route
Route::get('/search', [ProductController::class, 'search'])->name('search');

// Category Filter Route
Route::get('/category/{category}', [ProductController::class, 'category'])->name('products.category');

// Wishlist Routes (for authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', function () {
        return view('wishlist');
    })->name('wishlist');
    Route::post('/wishlist/add', function () {
        // Add to wishlist logic
    })->name('wishlist.add');
    Route::post('/wishlist/remove', function () {
        // Remove from wishlist logic
    })->name('wishlist.remove');
});

// API Routes for AJAX calls
Route::prefix('api')->group(function () {
    Route::post('/cart/count', [CartController::class, 'count'])->name('api.cart.count');
    Route::get('/products/search', [ProductController::class, 'apiSearch'])->name('api.products.search');
});

// Fallback route for 404 errors
Route::fallback(function () {
    return view('errors.404');
});
