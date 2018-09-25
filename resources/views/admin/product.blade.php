@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{ Breadcrumbs::render('admin.product', $product) }}

                @include('partials.flash')
            </div>
        </div>
        <form action="" method="post" class="">
            @csrf
            @method('PUT')
            <div class="row ">
                <div class="col border border-right-0 m-1">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="{{old('name',$product->name)}}">

                    </div>
                    <div class="form-group">
                        <label for="Price">Price:</label>
                        <input type="number" class="form-control" name="price" step="0.01"
                               value="{{old('price',$product->getFormattedPrice())}}"
                        >
                    </div>
                    <div class="form-group">
                        <label for="discount">Promote discount (%):</label>
                        <input type="number" class="form-control" name="discount" min="0" max="99.99" step="0.01"
                               value="{{old('discount',$product->getFormattedDiscount())}}"
                        >
                    </div>

                    <div class="form-group row">
                        @foreach($categories as $category)
                            <div class="checkbox col-6">
                                <label class="">
                                    <input
                                        type="checkbox"
                                        name="category[]"
                                        {{$product->categories->contains('id', $category->id)?  'checked': ''}}
                                        value="{{$category->id}}">{{$category->name}}
                                </label>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="col border border-left-0 m-1">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="5">
{{old('description',$product->description)}}</textarea>
                    </div>

                    <p>Categories:
                        <small>
                            @foreach($product->categories as $category)
                                <a href="/category/c{{$category->id}}">{{$category->name}}</a>
                            @endforeach
                        </small>
                    </p>
                    <div class="row form-group">
                        <div class="col-4 offset-4" style="margin-top:60px">
                            <button type="submit" class="btn btn-primary form-control">Save</button>
                        </div>
                        <div class="col-4" style="margin-top:60px">
                            <button type="button" class="btn btn-secondary form-control" id="deleteProduct">Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row error-message alert-danger alert text-hide"></div>

        <div class="row ">
            <div class="col border-bottom">

                <button id="deleteSelected" class="btn btn-secondary float-right ml-4">
                    <i class="fa fa-times"></i> Delete selected
                </button>

                <a
                    href="/admin/product/{{$product->id}}/upload_picture"
                    class="btn btn-success float-right ml-4"
                    data-toggle="modal" data-target="#formAddPictures">
                    <i class="fa fa-plus-circle"></i> Add new pictures
                </a>

            </div>
        </div>
        <div class="row">
            <div class="col border border-top-0 m-1 p-3">
                <h3>Small pictures</h3>
                @if($product->smallPictures()->count())
                    <div class="row">
                        @foreach($product->smallPictures()->get() as $picture)
                            <div class="col-md-4 shadow">
                                <div class="checkbox">
                                    <label><input class="" type="checkbox" name="delete_picture"
                                                  id="del_{{$picture->id}}" value="{{$picture->id}}">delete</label>
                                </div>
                                <div class="image align-top"><img class="" src="{{'/storage/'.$picture->path}}"
                                                                  width="110"></div>

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col border border-top-0 m-1 p-3">
                <h3>Medium pictures</h3>
                @if($product->mediumPictures()->count())
                    <div class="row">
                        @foreach($product->mediumPictures()->get() as $picture)
                            <div class="col-md-6 shadow">
                                <div class="checkbox">
                                    <label><input class="" type="checkbox" name="delete_picture"
                                                  id="del_{{$picture->id}}" value="{{$picture->id}}">delete</label>
                                </div>
                                <div class="image"><img class="w-100" src="{{'/storage/'.$picture->path}}" alt=""
                                                        width="250"></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col border border-top-0 m-1 p-3">
                <h3>Large pictures</h3>
                @if($product->largePictures()->count())
                    <div class="row">
                        @foreach($product->largePictures()->get() as $picture)

                            <div class="col-md-6 shadow">
                                <div class="checkbox">
                                    <label class=""><input class="" type="checkbox" name="delete_picture"
                                                           id="del_{{$picture->id}}"
                                                           value="{{$picture->id}}">delete</label>
                                </div>
                                <div class="image"><img class="w-100" src="{{'/storage/'.$picture->path}}" alt=""
                                                        width="450"></div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formAddPictures" tabindex="-1" role="dialog" aria-labelledby="formAddPicturesTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload new pictures</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <my-upload-form product-id="{{$product->id}}"></my-upload-form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/js/custom.js" defer></script>
@endpush
