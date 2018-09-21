@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('partials.flash')
            </div>
        </div>
        <div class="row justify-content-end">
            <a href="{{route('admin.add_product')}}" class="btn btn-primary">Add product</a>
        </div>
        <div class="row justify-content-center">
            @foreach($products->chunk(5) as $chunk)
                <div class="card-group">
                    @foreach($chunk as $product)
                        <div class="card">
                            <a href="/admin/products/p{{$product->id}}">
                                @if($product->getFirstSmallPicture())
                                    <img class="card-img-top"
                                         src="{{asset('storage/'.$product->getFirstSmallPicture()->path)}}"
                                         alt="Product image">
                                @else()
                                    <img class="card-img-top" src="{{asset("/img/no_image.gif")}}" alt="Product image">
                                @endif
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{{$product->name}}<br>
                                </h5>
                                <p class="card-text">{{$product->description}} <i class="fa fa-pen1cil"
                                                                                  title="Edit"></i></p>
                            </div>
                            <div class="card-footer">
                                <small class="text-info">
                                    <i class="fas fa-dollar-sign"></i>{{$product->getFormattedPrice()}}
                                </small>
                            </div>
                        </div>

                    @endforeach

                </div>
            @endforeach
            {{ $products->links() }}
        </div>
    </div>
@endsection
