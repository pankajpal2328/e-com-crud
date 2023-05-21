@extends('layouts.app')

@section('content')

<div class="">
    <div class="text-right">
        <a href="{{ route('product.create') }}" class="btn btn-primary">Add New</a>
    </div>
    <br>

    <table class="table table-sm">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Product Name</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Category</th>
            <th scope="col">Brand</th>
            <th>Action</th>
            </tr>
        </thead>
        <tbody>
                @foreach($products as $product)
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <button class="btn btn-sm btn-danger" onclick="event.preventDefault(); if (confirm('Are you sure to delete this item?')) { document.getElementById('item-delete-{{ $product->id }}').submit(); }"">Delete</button>

                        <form method="post" action="{{ route('product.destroy', $product->id) }}" id="item-delete-{{ $product->id }}">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>

</div>

@endsection