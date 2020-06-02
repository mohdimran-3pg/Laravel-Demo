@extends('layouts.main')
@section('content')
<!-- Navbar (sit on top) -->
<div class="w3-top" style="position: static;">
    @include('inc.header')
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
                        <span>{{count($topic->likes)}} | <a href="/user/{{$topic["id"]}}/like">Like</a></span>
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

