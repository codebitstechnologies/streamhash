@extends('layouts.user')

@section('content')

    <div class="video-full-box">

        <div class="box-title">
          <h3 class="main-title">{{tr('trending')}}</h3>
        </div>

        @foreach($videos as $video)
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

        @if(count($videos) > 0)
            <div align="right" id="paglink"><?php echo $videos->links(); ?></div>
        @endif

       
    
    </div>

@endsection