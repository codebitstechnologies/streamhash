@extends('layouts.user')

@section('content')

    <div class="y-content">
        <div class="row content-row">

            @include('layouts.user.nav')


            <div class="page-inner col-sm-9 col-md-10">

                @foreach($sub_categories as $sub_category)
                 <div class="slide-area">
                    <div class="box-head row no-margin">
                        <h3 class="float-left">{{$sub_category->name}}</h3>
                        <a class="float-right see-all" href="{{route('user.sub-category' ,$sub_category->id)}}">{{tr('see_all')}} </a>

                    </div>

                    <div class="box">

                        <?php 
                            $sub_category_videos = array(); 
                            $sub_category_videos = sub_category_videos($sub_category->id); 
                        ?>

                    	@foreach( $sub_category_videos as $video)
                            <div class="slide-box">
                                <div class="slide-image">
                                    <a href="{{route('user.single' , $video->admin_video_id)}}"><img src="{{$video->default_image}}" /></a>
                                </div><!--end of slide-image-->

                                <div class="video-details">
                                    <div class="video-head">
                                        <a href="{{route('user.single' , $video->admin_video_id)}}">{{$video->title}}</a>
                                    </div>
                                    <div class="sugg-description">
                                        <p>{{tr('duration')}} {{$video->duration}}</p>
                                    </div><!--end of sugg-description--> 

                                    <span class="stars">
                                        <a href="#"><i @if($video->ratings > 1) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                       <a href="#"><i @if($video->ratings > 2) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                       <a href="#"><i @if($video->ratings > 3) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                       <a href="#"><i @if($video->ratings > 4) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                       <a href="#"><i @if($video->ratings > 5) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                    </span> 
                                </div><!--end of video-details-->
                            </div><!--end of slide-box-->
                        @endforeach
                    </div><!--end of box--> 
                </div><!--end of slide-area-->
                @endforeach
            </div>
            
        </div>
    </div>

@endsection