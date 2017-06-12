@extends('layouts.user')

@section('content')


@foreach($sub_categories as $sub_category)

    <div class="video-full-box">

        <div class="box-title">
          <!-- <h3 class="main-title">{{$sub_category->name}}</h3> -->
          <div class="box-head row no-margin">
                <h3 style="float:left" class="main-title">{{$sub_category->name}}</h3>
                <a style="float:right" class="see-all" href="{{route('user.sub-category' ,$sub_category->id)}}">See All </a>

            </div>
        </div>

        @foreach(sub_category_videos($sub_category->id) as $video)
        
        <div class="video-box">
            <a href="{{route('user.single' , $video->admin_video_id)}}">
                <?php 
                    $video_images = get_video_image($video->admin_video_id); 
                ?>
                @if($video_images->count() == 0)
                    <img class="first" src="{{$video->default_image}}"><!-- main image -->
                    <img class="second" src="{{$video->default_image}}"><!-- main image -->
                    <img class="third" src="{{$video->default_image}}"><!-- main image -->
                @else

                    @foreach($video_images as $video_image)

                        @if($video_image->position == 2)
                            <img class="first" src="{{$video_image->image}}"><!-- last -->
                        @else
                            <img class="third" src="{{$video_image->image}}"><!-- second image -->
                        @endif
                        <img class="second" src="{{$video->default_image}}"><!-- main image -->
                    @endforeach

                @endif
                <span class="time">{{$video->duration}}</span>
                <h5 class="video-title">{{$video->title}}</h5>
            </a>
        </div>
        @endforeach

    </div>

@endforeach

@endsection