@extends('layouts.user')

@section('content')

<!-- Breadcrumbs -->

<section id="breadcrumb">
  	<div class="row">
	    <div class="large-12 columns">
	      	<nav aria-label="You are here:" role="navigation">
		        <ul class="breadcrumbs">
		          <li><i class="fa fa-home"></i><a href="{{route('user.dashboard')}}">Home</a></li>
		          <li>
		            <span class="show-for-sr">Current: </span> {{tr('search')}}
		          </li>
		        </ul>
	      	</nav>
	    
	    </div>
  	</div>
</section>

<section class="category-content">
	
	<div class="row">
	    <!-- left side content area -->

		    <div class="large-12 columns">
		        
		        <section class="content content-with-sidebar">

		        	@if(count($videos) > 0)

			            <!-- newest video -->

			            <div class="main-heading removeMargin">
			                <div class="row secBg padding-14 removeBorderBottom">
			                    <div class="medium-8 small-8 columns">
			                        <div class="head-title">
			                            <i class="fa fa-film"></i>
			                            <h4>{{tr('search_result')}} "{{$key}}"</h4>
			                        </div>
			                    </div>
			                </div>
			            </div>

			            <!--end of main-heading-->

			            <div class="row secBg">

			                <div class="large-12 columns">

				                <div class="row column margin-bottom-10 clearfix">

				                    <!-- <p class="pull-left">All Videos : <span>{{total_video_count()}} Videos posted</span></p> -->
				                    <!-- <div class="grid-system pull-right show-for-large">
				                        <a class="secondary-button current grid-default" href="#"><i class="fa fa-th"></i></a>
				                        <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
				                        <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
				                    </div> -->

				                </div> <!--row end -->

			                    <!-- end of head-text-->

			                    <div class="tabs-content" data-tabs-content="newVideos">

			                        <div class="tabs-panel is-active" id="new-all">

			                            <div class="row list-group">

			                            	@foreach($videos as $rv => $video)

				                                <div class="item large-4 medium-6 columns grid-default">

				                                    <div class="post thumb-border">
				                                        <div class="post-thumb">

				                                            <img src="{{$video->default_image}}" alt="{{Setting::get('site_name')}}">

				                                            <a href="{{route('user.single' , $video->admin_video_id)}}" class="hover-posts">
				                                                <span><i class="fa fa-play"></i>{{tr('watch_video')}}</span>
				                                            </a>

				                                            <div class="video-stats clearfix">

		                                                        <div class="thumb-stats pull-left">
		                                                            <h6>HD</h6>
		                                                        </div>

		                                                        <div class="thumb-stats pull-right">
		                                                            <i class="fa fa-heart"></i>
		                                                            <span>{{get_video_fav_count($video->admin_video_id)}}</span>
		                                                        </div>

		                                                        <!-- <div class="thumb-stats pull-right">
		                                                            <span>05:56</span>
		                                                        </div> -->

		                                                    </div>

				                                            <!--end of video-stats-->

				                                        </div><!--end of post-thumb-->

				                                        <div class="post-des">
				                                            <h6>
				                                            	<a href="recent_video">{{$video->title}}</a>
				                                            </h6>
				                                            <div class="post-stats clearfix">
				                                                <p class="pull-left">
				                                                    <i class="fa fa-clock-o"></i>
				                                                    <span>{{date('d M Y',strtotime($video->publish_time))}}</span>
				                                                </p>
				                                                <p class="pull-left">
				                                                    <i class="fa fa-eye"></i>
				                                                    <span>{{$video->watch_count}}</span>
				                                                </p>
				                                            </div>

				                                            <!--end of post-stats-->

				                                            <div class="post-summary">
				                                                <p>{{$video->description}}</p>
				                                            </div>

				                                            <!--end of post-summary-->
				                                           
				                                            <div class="post-button">
				                                                <a href="{{route('user.single' , $video->admin_video_id)}}" class="secondary-button">
				                                                	<i class="fa fa-play-circle"></i>
				                                                	{{tr('watch_video')}}
				                                                </a>
				                                            </div>

				                                            <!--end of button-->
				                                        </div><!--end of post des-->
				                                    
				                                    </div>

				                                    <!--end of post-->
				                                
				                                </div>

				                                <!--end of item-->

			                                @endforeach
			                            
			                            </div>
			                            
			                            <!--end of tabs-panel row-->
			                        </div>

			                        <!--end of tabs-panel-->

			                    </div><!--end of tabs-content-->

			                    <div align="right" id="paglink"><?php echo $videos->links(); ?></div>

			                    <div class="pagination">
			                        <!-- <a href="#" class="prev page-numbers">« Previous</a>
			                        <a href="#" class="page-numbers">1</a>
			                        <span class="page-numbers current">2</span>
			                        <a href="#" class="page-numbers">3</a>
			                        <a href="#" class="next page-numbers">Next »</a> -->
			                    </div><!--end of pagination-->
			                </div><!--end of large-12-->
			            </div>

		            	<!--end of row secbg-->

		            @else
		            	<p style="margin:10px;padding:5px;color:brown !important">{{tr('no_search_result')}}</p>
		            @endif
		        
		        </section>

		        <!--end of category-content-->
		        
		    </div>
	   

	    <!-- end left side content area -->
	
	</div>

	<!--end of sidebar large-12-->

</section>

@endsection