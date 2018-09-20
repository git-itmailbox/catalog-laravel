@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @include('partials.flash')
            </div>
        </div>
        <div class="container">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-3">
                        <div class="image">
                            <a href="/products/p{{$product->id}}">
                                @if($product->getFirstSmallPicture())
                                    <img class="w-100"
                                         src="{{asset('storage/'.$product->getFirstSmallPicture()->path)}}"
                                         alt="Product image">
                                @else()
                                    <img class="w-100" src="{{asset("/img/no_image.gif")}}" alt="Product image">
                                @endif
                                <div class="overlay">
                                    <div class="detail">View Details</div>
                                </div>
                            </a>
                        </div>
                        <h5 class="text-center">{{$product->description}}</h5>
                        <h5 class="text-center">Price: ${{$product->getFormattedPrice()}}</h5>
                        <a href="#" class="btn detail-btn">Details</a>
                    </div>
                @endforeach
            </div>
            <div class="row justify-content-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
