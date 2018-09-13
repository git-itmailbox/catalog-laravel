@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('partials.flash')
        </div>
    </div>
    <div class="row justify-content-center">
        @foreach($products as $chunk)
        <div class="card-deck">
            @foreach($chunk as $product)

            <div class="card">
                <img class="card-img-top" src="..." alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text">{{$product->description}}</p>
                    <p class="card-text"><small class="text-info">{{$product->price / \App\Product::FACTOR}}</small></p>
                </div>
            </div>
            @endforeach

        </div>
        @endforeach
    </div>
</div>
@endsection
