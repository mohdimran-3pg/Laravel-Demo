@if(Session::has('success'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    {!! Session::get('success') !!}
                </div>
            </div>
        </div>
        @endif