@extends('layouts.main')
@section('content')
    @include('inc.header')
    <div class="container">
        <h2>Add Topic</h2>
        @include('inc.error')
        @include('inc.success')

        
        <form class="form-horizontal" action="/user/update" method="POST">
            @csrf
          <div class="form-group">
            <label class="control-label col-sm-2" for="email">Title:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="email" placeholder="Enter Title" name="title" value="{{ $topic->title}}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Description:</label>
            <div class="col-sm-10">          
              <textarea class="form-control" rows="5" id="comment" name="description" placeholder="Enter Description">{{ $topic->description}}</textarea>
            </div>
          </div>
          <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">Submit</button>
            </div>
          </div>
          <input type="hidden" name="id" value="{{ $topic->id}}" />
        </form>
      </div>
    @include('inc.footer')
@endsection