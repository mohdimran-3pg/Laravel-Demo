@if(count($errors->all()) > 0)
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

@if(Session::has('error'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    {!! Session::get('error') !!}
                </div>
            </div>
        </div>
        @endif