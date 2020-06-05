@extends('layouts.main')
@section('content')
<div class="w3-top" style="position: static;">
    @include('inc.header')
    <div class="container">
        
        <p class="h1">{{$topic["title"]}}</p>
        <p class="h4">{{$topic["description"]}}</p>
        <p>Created On: <i>{{$topic["created_at"]}}</i><br/>
          <img src="{{asset('/images/'.$topic->user->avatar)}}" class="profile-img"/> <i>{{$name}}</i><br/>
           @if($topic->isUserLiked)
                <span>{{count($topic->likes)}} | <a href="/user/{{$topic["id"]}}/unlike">UnLike</a></span>
            @else
                <span>{{count($topic->likes)}} | <a href="/user/{{$topic["id"]}}/like">Like</a></span>
            @endif
            
        </p>
        
        <p>&nbsp;</p>
        <p style="color: black;"><h4>{{count($solutions)}} Solutions</h4></p>
        <p>&nbsp;</p>
        @if (count($solutions) > 0)
          @foreach($solutions as $solution)
            <div class="card">
                
                <div class="card-body">{{$solution["solution"]}}</div>
                @if($solution->isUserLikedTopic == false)
                  <span style="font-size: 11px; float: left;"> <a href="/user/{{$solution->id}}/solution/like">{{count($solution->likes)}} | Like</a> </span>
                @else
                  <span style="font-size: 11px; float: left;"> <a href="/user/{{$solution->id}}/solution/unlike">{{count($solution->likes)}} | UnLike</a> </span>
                @endif 
                
                <span style="font-size: 11px; float: right;"><img class="profile-img" src="{{asset('/images/'.$solution->user->avatar)}}" /> <i> <a href="{{route('profile.view', ['id' => $solution->user->id])}}">{{$solution->user->name}}</a> </i></span><br/>
                <br />
                <span style="font-size: 11px; float: right;">Crated On <i>{{$solution["created_at"]}}</i></span>
                <hr>
            </div>
          @endforeach
        @else 
          <div class="card">No Solutions found.</div>
        @endif
        

        <div style="margin-top: 20px;">
          @include('inc.error')
          @include('inc.success')
            <form class="form-horizontal" action="/user/solution" method="POST">
                @csrf
              <div class="form-group">
                <label class="control-label col-sm-2" for="pwd" style="text-align: left;">Solution:</label>
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
        
    </div>
</div>
@endsection