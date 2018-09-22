@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                {{ Breadcrumbs::render('home') }}
                @include('partials.flash')
            </div>
        </div>
        <div class="container">
            <div class=" card">
                <div class="row card-body">
                    <div class="col-md-10 col-sm-8">
                        <select class="form-control" id="filterCategory">
                            <option>All...</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}"
                                        @if(isset($currentCategory ) && $category->id == $currentCategory)
                                        selected
                                    @endif
                                >{{$category->name}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-2 col-sm-4">
                        <button id="btnFilterByOneCategory" class="btn btn-info btn-lg form-control" type="button">
                            Filter
                        </button>
                    </div>
                </div>
                <div class="row card-body">
                    <div class="col-md-10 col-sm-8">
                        <div class="form-group row">
                            @foreach($categories as $category)
                                <div class="checkbox col-md-3 col-sm-6 ">
                                    <label class="">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            {{in_array($category->id, explode(',',request()->get('categories'))) ?  'checked': ''}}

                                            value="{{$category->id}}">{{$category->name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-4">
                        <button id="btnFilterByCategory" class="btn btn-info btn-lg form-control" type="button">Filter
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-3 p-3">
                        <h4>{{$product->name}}</h4>
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
                {{ $links }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/js/custom.js" defer></script>
@endpush
