<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Access denied. Admin privileges required.');
        }
    }

    public function index()
    {
        $this->checkAdmin();
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->checkAdmin();

        // Define categories as an array since you don't have a Category model yet
        $categories = [
            (object)['id' => 'smartphones', 'name' => 'Smartphones'],
            (object)['id' => 'laptops', 'name' => 'Laptops'],
            (object)['id' => 'gaming', 'name' => 'Gaming'],
            (object)['id' => 'accessories', 'name' => 'Accessories'],
            (object)['id' => 'tablets', 'name' => 'Tablets'],
            (object)['id' => 'audio', 'name' => 'Audio'],
            (object)['id' => 'cameras', 'name' => 'Cameras'],
            (object)['id' => 'computers', 'name' => 'Computers'],
        ];

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category = $request->category_id; // Store as category, not category_id
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $this->checkAdmin();
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $this->checkAdmin();
        $product = Product::findOrFail($id);

        // Define categories for edit form as well
        $categories = [
            (object)['id' => 'smartphones', 'name' => 'Smartphones'],
            (object)['id' => 'laptops', 'name' => 'Laptops'],
            (object)['id' => 'gaming', 'name' => 'Gaming'],
            (object)['id' => 'accessories', 'name' => 'Accessories'],
            (object)['id' => 'tablets', 'name' => 'Tablets'],
            (object)['id' => 'audio', 'name' => 'Audio'],
            (object)['id' => 'cameras', 'name' => 'Cameras'],
            (object)['id' => 'computers', 'name' => 'Computers'],
        ];

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|string',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category = $request->category_id;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $this->checkAdmin();
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
