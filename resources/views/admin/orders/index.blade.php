@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Orders</h1>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">Create New Order</a>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection