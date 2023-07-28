@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h2>

    @if (isset($product))
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
    @else
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
    @endif
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', isset($product) ? $product->name : '') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', isset($product) ? $product->description : '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ old('price', isset($product) ? $product->price : '') }}" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
            @if (isset($product) && $product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="max-height: 100px;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Save' }}</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
