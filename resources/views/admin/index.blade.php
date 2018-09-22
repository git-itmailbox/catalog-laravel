@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                {{ Breadcrumbs::render('admin_dashboard') }}

                @include('partials.flash')
            </div>
        </div>
        <div class="row justify-content-start">
            <div class="col-4">
                <div class="list-group">
                    <a href="/" class="list-group-item list-group-item-action disabled">Main page</a>
                    <a href="{{route('admin.products')}}" class="list-group-item list-group-item-action ">
                        Manage products
                    </a>
                    <a href="{{route('categories')}}" class="list-group-item list-group-item-action ">
                        Manage categories
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
