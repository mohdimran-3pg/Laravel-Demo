
    @extends('layouts.main')
    @section('content')
        @include('inc.error')
        @include('inc.header')
        @include('inc.success')
        <div class="container">
            <h2>Edit Profile</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
                    @csrf

                      <div class="form-group">
                        <label class="control-label col-sm-2">Name:</label>
                        <div class="col-sm-10">
                            <input name="name" value="{{$name}}"/><br />
                        </div>
                      </div> 
                      <div class="clearfix">&nbsp;</div>  
                      <div class="form-group">
                        <label class="control-label col-sm-2">Avatar:</label>
                        <div class="col-sm-10">
                            <img src="{{asset('/images/'.$image)}}" width="100" height="100"/>
                        </div>
                      </div> 
                      <div class="clearfix">&nbsp;</div>
                      <div class="form-group">
                        <label class="control-label col-sm-2">Select:</label>
                        <div class="col-sm-10">
                            <input type="file" name="avatar">
                        </div>
                      </div>
                      <div class="clearfix">&nbsp;</div>
                      <div class="form-group">        
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
        @include('inc.footer')
    @endsection    