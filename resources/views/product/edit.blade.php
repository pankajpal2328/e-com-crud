@extends('layouts.app')

@section('content')

<div class="">
    <div class="text-right">
        <a href="{{ route('product.index') }}" class="btn btn-primary">Back</a>
    </div>
    @include('product.form')
</div>

@endsection