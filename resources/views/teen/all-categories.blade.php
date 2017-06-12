@extends('layouts.user')

@section('content')
    
    <div class="video-full-box">

        <div class="box-title">
            <h3>{{tr('categories')}}</h3>
        </div>

        @foreach($categories as $category)
        
            <div class="video-box">
                <a href="{{route('user.category',$category->id)}}">
                    <img src="{{$category->picture}}">
                    <span class="time">{{category_video_count($category->id)}} Videos</span>
                    <h5 class="video-title cat">{{$category->name}}</h5>
                </a>
            </div>

        @endforeach
        
    </div>

@endsection