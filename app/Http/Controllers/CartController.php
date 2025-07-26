<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if enough stock is available
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Not enough stock available.');
        }

        $cart = Session::get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            // Product already in cart, update quantity
            $newQuantity = $cart[$productId]['quantity'] + $request->quantity;

            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Not enough stock available.');
            }

            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            // Add new product to cart
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image
            ];
        }

        Session::put('cart', $cart);

        return back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Remove item from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer'
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            Session::put('cart', $cart);
            return back()->with('success', 'Product removed from cart.');
        }

        return back()->with('error', 'Product not found in cart.');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);

        if (isset($cart[$request->product_id])) {
            $product = Product::findOrFail($request->product_id);

            if ($product->stock < $request->quantity) {
                return back()->with('error', 'Not enough stock available.');
            }

            $cart[$request->product_id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            return back()->with('success', 'Cart updated successfully.');
        }

        return back()->with('error', 'Product not found in cart.');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        Session::forget('cart');
        return back()->with('success', 'Cart cleared successfully.');
    }

    /**
     * Get cart count for AJAX
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }
}
