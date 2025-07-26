@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Create Category</h1>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Category</button>
    </form>
</div>
@endsection