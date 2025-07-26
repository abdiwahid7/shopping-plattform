<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::take(6)->get(); // Get first 6 products for featured section
        return view('home', compact('products'));
    }
}
