@extends('layouts.user')

@section('content')

    <div class="y-content">
        <div class="row content-row">

            @include('layouts.user.nav')

            <div class="page-inner col-sm-9 col-md-10">

                <div class="slide-area recom-area">
                    <div class="box-head recom-head">
                        <h3>{{$sub_category->name}}</h3>
                    </div>

                    <div class="recommend-list row">

                        @foreach($videos as $video)
	                        <div class="slide-box recom-box">
	                            <div class="slide-image recom-image">
	                                <a href="{{route('user.single' , $video->admin_video_id)}}"><img src="{{$video->default_image}}" /></a>
	                            </div><!--end of slide-image-->

	                            <div class="video-details recom-details">
	                                <div class="video-head">
	                                    <a href="{{route('user.single' , $video->admin_video_id)}}">{{$video->title}}</a>
	                                </div>
	                                <div class="sugg-description">
	                                    <p>{{tr('duration')}}: {{$video->duration}}</p>
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

                        <br />

                        
                        

                    </div><!--end of recommend-list-->
                    @if(count($videos) > 0)
	                    <div class="row">
	                    	<div class="col-md-12">
	                        	<div align="center" id="paglink"><?php echo $videos->links(); ?></div>
	                        </div>
	                   	</div>
                   	@endif
                </div><!--end of slide-area-->

                
            </div>

        </div>
    </div>

@endsection