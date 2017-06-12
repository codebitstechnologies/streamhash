@extends('layouts.user')

@section('content')

    <div class="video-full-box">
        
        @include('notification.notify')

        <div class="box-title">
            <h3 class="main-title">{{tr('spam_videos')}}</h3>
        </div>

        @foreach($model as $i => $video)

            <div class="video-box">
                <a href="{{route('user.single' , $video->video_id)}}">
                    <?php 
                     $video_images = get_video_image($video->video_id); 
                    ?>
                     @if($video_images->count() == 0)
                        <img class="first" src="{{$video->adminVideo->default_image}}"><!-- main image -->
                        <img class="second" src="{{$video->adminVideo->default_image}}"><!-- main image -->
                        <img class="third" src="{{$video->adminVideo->default_image}}"><!-- main image -->
                    @else
                        @foreach($video_images as $video_image)

                            @if($video_image->position == 2)
                                <img class="first" src="{{$video_image->image}}"><!-- last -->
                            @else
                                <img class="third" src="{{$video_image->image}}"><!-- second image -->
                            @endif
                            <img class="second" src="{{$video->adminVideo->default_image}}"><!-- main image -->
                        @endforeach
                    @endif
                    <span class="time">{{$video->adminVideo->duration}}</span>
                    <h5 class="video-title">{{$video->adminVideo->title}}</h5>
                </a>

                <a onclick="return confirm('Are you sure?');" href="{{route('user.remove.report_video' , $video->id)}}" class="remove-btn">
                    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
            
            </div>

        @endforeach

        @if(count($model))
            <div align="right" id="paglink"><?php echo $model->links(); ?></div>
        @endif

    </div>

@endsection