<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Process cart items and calculate totals
        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $itemTotal = $product->price * $item['quantity'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
                $subtotal += $itemTotal;
            }
        }

        $tax = $subtotal * 0.08; // 8% tax
        $shipping = 10.00; // Fixed shipping cost
        $total = $subtotal + $tax + $shipping;

        return view('checkout.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_email' => 'required|email',
            'billing_phone' => 'required|string',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string',
            'billing_state' => 'required|string',
            'billing_postal_code' => 'required|string',
            'billing_country' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Calculate total
        $subtotal = 0;
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal += $product->price * $item['quantity'];
            }
        }

        $tax = $subtotal * 0.08;
        $shipping = 10.00;
        $total = $subtotal + $tax + $shipping;

        // Here you would typically:
        // 1. Create an order record in database
        // 2. Process payment
        // 3. Update product stock
        // 4. Send confirmation email

        // For now, we'll just clear the cart and redirect to success
        Session::forget('cart');

        return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');
    }
}
