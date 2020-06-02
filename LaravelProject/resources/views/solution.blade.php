@extends('layouts.main')
@section('content')
    @include('inc.header')
    <div class="container">
        <h2>Add Solution</h2>
        @include('inc.error')
        @include('inc.success')

        
        <form class="form-horizontal" action="/user/solution" method="POST">
            @csrf
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Topic:</label>
            <div class="col-sm-10">          
                {{$topic['title']}}
            </div>
          </div>  
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Solution:</label>
            <div class="col-sm-10">          
              <textarea class="form-control" rows="5" id="comment" name="solution" placeholder="Enter Solution">{{old('solution')}}</textarea>
            </div>
          </div>
          <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Submit</button>
            </div>
          </div>
          <input type="hidden" name="id" value="{{$topic['id']}}" />
        </form>
      </div>
    @include('inc.footer')
@endsection