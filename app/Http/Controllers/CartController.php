<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // Logic to add item to cart
    }

    public function remove($id)
    {
        // Logic to remove item from cart
    }

    public function view()
    {
        // Logic to view cart items
    }
}