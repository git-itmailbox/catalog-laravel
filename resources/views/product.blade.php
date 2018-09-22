@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                {{ Breadcrumbs::render('show_product', $product) }}

                @include('partials.flash')
            </div>
        </div>

        <div class="row ">
            <div class="col border border-right-0 m-1"><h2>{{$product->name}}</h2>
                <p class="text-info">Price: <h3 class="text-danger">${{$product->getFormattedPrice()}}</h3></p>
            </div>
            <div class="col border border-left-0 m-1">{{$product->description}}

            <p>Categories: <small>
                @foreach($categories as $category)
                        <a href="/category/c{{$category->id}}">{{$category->name}}</a>
                @endforeach
            </small></p>
            </div>
        </div>
        <div class="row">
            <div class="col border border-top-0 m-1">
                <h3>Small pictures</h3>
                @if($product->smallPictures()->count())
                    <div class="row">
                        @foreach($product->smallPictures()->get() as $picture)
                            <div class="col-md-4">
                                <div class="image"><img class="" src="{{'/storage/'.$picture->path}}" alt=""
                                                        width="110"></div>
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>
            <div class="col border border-top-0 m-1">
                <h3>Medium pictures</h3>
                @if($product->mediumPictures()->count())
                    <div class="row">
                        @foreach($product->mediumPictures()->get() as $picture)
                            <div class="col-md-6">
                                <div class="image"><img class="w-100" src="{{'/storage/'.$picture->path}}" alt="" width="250"></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col border border-top-0 m-1">
                <h3>Large pictures</h3>
                @if($product->largePictures()->count())
                    <div class="row">
                        @foreach($product->largePictures()->get() as $picture)
                            <div class="col-md-6">
                                <div class="image"><img class="w-100" src="{{'/storage/'.$picture->path}}" alt="" width="450"></div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>
    </div>
@endsection
