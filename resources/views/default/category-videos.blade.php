@extends('layouts.user')

@section('content')

<!-- Breadcrumbs -->

<section id="breadcrumb">
  	<div class="row">
	    <div class="large-12 columns">
	      	<nav aria-label="You are here:" role="navigation">
		        <ul class="breadcrumbs">
		          <li><i class="fa fa-home"></i><a href="{{route('user.dashboard')}}">{{tr('home')}}</a></li>
		          <li>
		            <span class="show-for-sr">Current: </span> {{tr('categories')}}
		          </li>
		        </ul>
	      	</nav>
	    
	    </div>
  	</div>
</section>

@if(count($sub_categories) > 0)

     <section id="premium">
        
        <div class="row">
            <div class="heading clearfix">
                <div class="large-11 columns">
                    <h4><i class="fa fa-play-circle-o"></i>{{tr('sub_categories')}}</h4>
                </div>
                <div class="large-1 columns">
                    <div class="navText show-for-large">
                        <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                        <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div><!--end of heading-->
        </div>

        <!--end of premium row-->

        <div id="owl-demo" class="owl-carousel carousel" data-car-length="4" data-items="4" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-responsive-small="1" data-responsive-medium="2" data-responsive-xlarge="5">

        	@foreach($sub_categories as $key => $sub_category)

        		<?php $sub_category_images = $sub_category->subCategoryImage; ?>

        		@if(count($sub_category_images) > 0)
	            
		            <div class="item">
		                <figure class="premium-img">
		                    <img src="{{$sub_category_images[0]->picture}}" alt="carousel">
		                    <figcaption>
		                        <h5>{{$sub_category->name}}</h5>
		                        <p></p>
		                    </figcaption>
		                </figure>
		                <a href="{{route('user.sub-category' , $sub_category->id)}}" class="hover-posts">
		                   <span><i class="fa fa-play"></i>{{tr('watch_video')}}</span>
		                </a>
		            </div>

	            @endif

            @endforeach

            <!--end of item-->

        </div>

        <!--end of owl-demo-->
    </section>

@endif

<section class="category-content">
	
	<div class="row">
	    <!-- left side content area -->

		    <div class="large-8 columns">
		        
		        <section class="content content-with-sidebar">

		        	@if(count($videos) > 0)

			            <!-- newest video -->

			            <div class="main-heading removeMargin">
			                <div class="row secBg padding-14 removeBorderBottom">
			                    <div class="medium-8 small-8 columns">
			                        <div class="head-title">
			                            <i class="fa fa-film"></i>
			                            <h4>{{tr('videos')}}</h4>
			                        </div>
			                    </div>
			                </div>
			            </div>

			            <!--end of main-heading-->

			            <div class="row secBg">

			                <div class="large-12 columns">

			                    <div class="row column head-text clearfix">
			                        <p class="pull-left">{{tr('videos')}} : <span>{{get_category_video_count($category->id)}} Videos posted</span></p>
			                        <div class="grid-system pull-right show-for-large">
			                            <a class="secondary-button grid-default" href="#"><i class="fa fa-th"></i></a>
			                            <a class="secondary-button current grid-medium" href="#"><i class="fa fa-th-large"></i></a>
			                            <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
			                        </div>
			                    </div>

			                    <!-- end of head-text-->

			                    <div class="tabs-content" data-tabs-content="newVideos">

			                        <div class="tabs-panel is-active" id="new-all">

			                            <div class="row list-group">

			                            	@foreach($videos as $rv => $video)

				                                <div class="item large-4 medium-6 columns grid-medium">

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
				                                            	<a href="{{route('user.single' , $video->admin_video_id)}}">{{$video->title}}</a>
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

		            @endif
		        
		        </section>

		        <!--end of category-content-->
		        
		    </div>

	   

	    <!-- end left side content area -->

	    <!-- sidebar -->

	    <div class="large-4 columns">

	        <aside class="secBg sidebar">
	            
	            <div class="row">

	                <!-- search Widget -->
	                
	                <div style="display:none" class="large-12 medium-7 medium-centered columns">
	                    <div class="widgetBox">
	                        <div class="widgetTitle">
	                            <h5>Search Videos</h5>
	                        </div><!--end of widget-title-->
	                        <form id="searchform" method="get" role="search">
	                            <div class="input-group">
	                                <input class="input-group-field" type="text" placeholder="Enter your keyword">
	                                <div class="input-group-button">
	                                    <input type="submit" class="button" value="Submit">
	                                </div>
	                            </div>
	                        </form>
	                    </div><!--end of widget-box-->
	                
	                </div>

	                <!-- End search Widget -->

	                <!-- categories -->

	                @if(count($categories) > 0)

		                <div class="large-12 medium-7 medium-centered columns">

		                    <div class="widgetBox">

		                        <div class="widgetTitle">
		                            <h5>{{tr('categories')}}</h5>
		                        </div>

		                        <div class="widgetContent">

		                            <ul class="accordion" data-accordion>

		                            	@foreach($categories as $c_key => $category)

			                            	<li class="accordion-item @if($c_key == 0) is-active @endif" data-accordion-item>

			                            		<?php $sub_categories = array(); 
			                            			$sub_categories = get_sub_categories($category->id); ?>

			                                    <a href="#" class="accordion-title">{{$category->name}}</a>

			                                    @if(count($sub_categories) > 0)

				                                    <div class="accordion-content" data-tab-content>

				                                       <ul>
				                                       		@foreach($sub_categories as $sub_key =>  $sub_category)

					                                           <li @if($sub_key == 0) class="clearfix" @endif>
					                                               <i class="fa fa-play-circle-o"></i>
					                                               <a href="{{route('user.sub-category' , $sub_category->id)}}">{{$sub_category->name}} <span>({{get_sub_category_video_count($sub_category->id)}})</span></a>
					                                           </li>

				                                           @endforeach

				                                       </ul>

				                                    </div>

			                                    @endif

			                                    <!--end of acordion-content-->
			                                </li>

		                            	@endforeach

		                            </ul><!--end of acordion-->
		                        </div><!--end of widget-content-->
		                    </div><!--end of widget-box-->
		                
		                </div>

	                @endif

	                <!--end of large-12-->

	                <!-- slide video -->

	                @if(count($trendings) > 0)
	                
		                <div class="large-12 medium-7 medium-centered columns">

		                    <section class="widgetBox">

		                        <div class="row">

		                            <div class="large-12 columns">

		                                <div class="column row">

		                                    <div class="heading category-heading clearfix">

		                                        <div class="cat-head pull-left">
		                                            <h4>{{tr('trending')}}</h4>
		                                        </div>

		                                        <!--end of heading-->

		                                        <div class="sidebar-video-nav">
		                                            <div class="navText pull-right">
		                                                <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
		                                                <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
		                                            </div><!--end of navText-->
		                                        
		                                        </div>

		                                        <!--end of sidebar-video-nav-->
		                                    </div>
		                                    <!--end of heading-->
		                                </div>
		                                <!--end of column-->

		                                <!-- slide Videos-->

		                                <div id="owl-demo-video" class="owl-carousel carousel" data-car-length="1" data-items="1" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false">
		                                    
		                                    @foreach($trendings as $t => $trending)
		                                    
			                                    <div class="item item-video thumb-border">
			                                        <figure class="premium-img">
			                                            <img src="{{$trending->default_image}}" alt="carousel">
			                                            <a href="{{route('user.single' , $trending->admin_video_id)}}" class="hover-posts">
			                                                <span><i class="fa fa-play"></i></span>
			                                            </a>
			                                        </figure>
			                                        <div class="video-des">
			                                            <h6><a href="{{route('user.single' , $trending->admin_video_id)}}">{{$trending->title}}</a></h6>
			                                            <div class="post-stats clearfix">
			                                                
			                                                <p class="pull-left">
			                                                    <i class="fa fa-clock-o"></i>
			                                                    <span>{{date('d M Y',strtotime($trending->publish_time))}}</span>
			                                                </p>
			                                                <p class="pull-left">
			                                                    <i class="fa fa-eye"></i>
			                                                    <span>{{$trending->watch_count}}</span>
			                                                </p>
			                                            </div><!--end of post-stats-->
			                                        </div><!--end of video-des-->
			                                    
			                                    </div>
			                                    <!--end of item-->

		                                    @endforeach

		                                </div>

		                                <!-- end carousel -->
		                            </div><!--large-12 end-->
		                        </div><!--end of widgetbox row-->
		                    </section><!-- End Category -->
		                
		                </div>

	                @endif

	                <!-- End slide video -->

	                <!-- Recent post videos -->

	                @if(count($suggestions) > 0)
	                
		                <div class="large-12 medium-7 medium-centered columns">

		                    <div class="widgetBox">

		                        <div class="widgetTitle">
		                            <h5>{{tr('suggestions')}}</h5>
		                        </div>

		                        <!--end of widgetTitle-->

		                        <div class="widgetContent">

		                        	@foreach($suggestions as $s => $suggestion)

			                        	@if($s <= 10)
			                            
				                            <div class="media-object stack-for-small">

				                                <div class="media-object-section">
				                                    <div class="recent-img">

				                                        <img src= "{{$suggestion->default_image}}" alt="recent">

				                                        <a href="{{route('user.single' , $suggestion->admin_video_id)}}" class="hover-posts">
				                                            <span><i class="fa fa-play"></i></span>
				                                        </a>
				                                    </div>
				                                    <!--end of recent-img-->
				                                </div>

				                                <!--end of media-object-section-->

				                                <div class="media-object-section">
				                                    <div class="media-content">

				                                        <h6><a href="{{route('user.single' , $suggestion->admin_video_id)}}">{{$suggestion->title}}</a></h6>
				                                        <p>
				                                        	
				                                        	<i class="fa fa-clock-o"></i>
				                                        	<span>{{date('d M Y',strtotime($suggestion->publish_time))}}</span>
				                                        </p>
				                                    </div>
				                                    <!--end of media-content-->
				                                </div>
				                                <!--end of media-content-->
				                            
				                            </div>

			                            @endif

		                            @endforeach

		                            <!--end of media-object-->
		                        
		                        </div>
		                        <!--end of widgetcontent-->
		                    </div>

		                    <!--end of widgetBox-->
		                
		                </div>

	                @endif

	                <!-- End Recent post videos -->

	            </div><!--end of sidebar row-->
	        </aside>
	    
	    </div>

	    <!-- end sidebar -->
	
	</div>

	<!--end of sidebar large-12-->

</section>

@endsection