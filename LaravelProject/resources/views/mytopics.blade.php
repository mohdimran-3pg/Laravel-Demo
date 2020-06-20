@extends('layouts.main')
@section('content')
<!-- Navbar (sit on top) -->
<div class="w3-top" style="position: static;">
    @include('inc.header')
    @include('inc.error')
    @include('inc.success')
    <div class="container">
        <div>
            <ul class="list-group">
                @if(count($topics) > 0)
                @foreach ($topics as $topic) 
                <li class="list-group-item" style="height: 150px;">
                    <div>
                        <a href="/user/{{$topic["id"]}}/detail">{{$topic["title"]}}</a><br />
                        <span>Created on: {{date("d-m-Y h:i A", strtotime($topic["created_at"]))}}</span><br/>
                        <span>{{count($topic->likes)}} Likes</span>
                    </div>
                    <div style="float: left;">
                        <a class="btn btn-primary" href="/user/edit/{{$topic["id"]}}">Edit</a>
                    </div>    
                    <div style="float: left; margin-left: 10px;">
                        <form method="POST" action="/user/delete">
                            @csrf
                            <button type="submit" class="btn btn-danger">Delet</button>
                            <input type="hidden" name="id" value="{{$topic["id"]}}" />
                        </form>
                    </div>    
                </li>
                @endforeach
                
                
                @else
                    <li>No Topic found</li>
                @endif
               </ul>
        </div>
        <div class="clearfix">{{$topics->links()}}</div>
    </div>
       
</div>  
   
  @include('inc.footer')
      
@endsection

