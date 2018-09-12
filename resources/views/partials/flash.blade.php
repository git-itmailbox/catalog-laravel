@if(Session::has('alert-success'))
    <div class="alert alert-success">
        <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
        <em> {!! session('alert-success') !!}</em>
    </div>
@endif

@if(Session::has('alert-info'))
    <div class="alert alert-info">
        <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
        <em> {!! session('alert-info') !!}</em>
    </div>
@endif

@if(Session::has('alert-warning'))
    <div class="alert alert-warning">
        <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
        <em> {!! session('alert-warning') !!}</em>
    </div>
@endif

@if(Session::has('alert-danger'))
    <div class="alert alert-danger">
        <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
        <em> {!! session('alert-danger') !!}</em>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}
                    <button type="button" class="close pull-right" data-dismiss="alert" aria-hidden="true">&times;</button>
                </li>
            @endforeach
        </ul>
    </div>
@endif
