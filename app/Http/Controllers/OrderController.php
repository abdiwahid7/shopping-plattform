<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['track']);
    }

    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Make sure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        $order->load('items.product');
        return view('orders.show', compact('order'));
    }

    /**
     * Track an order by order number (public access).
     */
    public function track($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        $order->load('items.product');
        return view('orders.track', compact('order'));
    }

    /**
     * Cancel the specified order.
     */
    public function cancel(Order $order)
    {
        // Make sure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Access denied.');
        }

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'This order cannot be cancelled.');
        }

        // Restore product stock
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        $order->update([
            'status' => 'cancelled',
            'can_cancel' => false,
        ]);

        return back()->with('success', 'Order has been cancelled successfully.');
    }
}
