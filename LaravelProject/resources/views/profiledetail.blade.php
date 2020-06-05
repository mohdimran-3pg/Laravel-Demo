    @extends('layouts.main')
    @section('content')
        @include('inc.error')
        @include('inc.header')
        @include('inc.success')
        <div class="container">
            <h2>Profile Detail</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                      <div class="form-group">
                        <label class="control-label col-sm-2">Name:</label>
                        <div class="col-sm-10">
                          {{$user->name}}
                        </div>
                      </div> 
                      <div class="clearfix">&nbsp;</div>
                      <div class="form-group">
                        <label class="control-label col-sm-2">Email:</label>
                        <div class="col-sm-10">
                          {{$user->email}}
                        </div>
                      </div> 

                      <div class="clearfix">&nbsp;</div>  
                      <div class="form-group">
                        <label class="control-label col-sm-2">Avatar:</label>
                        <div class="col-sm-10">
                            <img src="{{asset('/images/'.$user->avatar)}}" width="250" height="250"/>
                        </div>
                      </div> 
                </div>
            </div>
        </div>
        @include('inc.footer')
    @endsection    