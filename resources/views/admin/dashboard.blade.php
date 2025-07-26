@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Welcome to the Electro Mart Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Products</h5>
                </div>
                <div class="card-body">
                    <p>Manage your products here.</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary">View Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Categories</h5>
                </div>
                <div class="card-body">
                    <p>Manage your product categories here.</p>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">View Categories</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Orders</h5>
                </div>
                <div class="card-body">
                    <p>View and manage customer orders.</p>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">View Orders</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection