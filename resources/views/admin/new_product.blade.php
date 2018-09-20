@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('partials.flash')
        </div>
    </div>
    <h2>Add new product</h2><br/>
    <form method="post" action="" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group col-md-4 offset-4">
                <label for="Name">Name:</label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 offset-4">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 offset-4">
                <label for="Price">Price:</label>
                <input type="number" class="form-control" name="price" >
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 offset-4">
                <label for="image_small">Small image (110x110):</label>
                <input id="image_small" name="image_small[]" type="file" multiple>
                <br>
                <div id="image_preview_small"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 offset-4">
                <label for="image_medium">Medium image (250x250):</label>
                <input id="image_medium" name="image_medium[]" type="file" multiple>
                <br>
                <div id="image_preview_medium"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 offset-4">
                <label for="image_large">Large image (450x450):</label>
                <input id="image_large" name="image_large[]" type="file" multiple>
                <br>
                <div id="image_preview_large"></div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4 offset-4" style="margin-top:60px">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>


@endsection
@push('scripts')
    <script src="/js/custom.js" defer></script>
@endpush
