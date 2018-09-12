@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @include('partials.flash')
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="" method="post" class="form-control">
                <input name="_method" type="hidden" value="PUT">
                {{ csrf_field() }}
                <div class="item col-sm-12 form-group form-group-input">
                    <label for="name" class="control-label">Name</label>
                    <input type="text" class="input" class="form-control" name="name" id="name"
                           placeholder="Category name" required
                           value="{{$category->name}}"
                    >
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-danger" id="deleteCategory">Delete</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
