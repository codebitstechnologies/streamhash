@extends('layouts.user')

@section('content')

@include('layouts.user.slider')

 <!-- Premium Videos -->

 @include('notification.notify')

@if(count($wishlists) > 3)

    <section id="premium">

        <div class="row">
            
            <div class="heading clearfix">
                
                <div class="large-11 columns">
                    <h4><i class="fa fa-heart"></i>{{tr('wishlist')}}</h4>
                </div>
                
                <div class="large-1 columns">
                    <div class="navText show-for-large">
                        <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                        <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <!--premium row end-->

        <div id="owl-demo" class="owl-carousel carousel" data-car-length="4" data-items="4" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-responsive-small="1" data-responsive-medium="2" data-responsive-xlarge="5">
            
            @foreach($wishlists as $wishlist)

                <div class="item">

                    <figure class="premium-img">
                        <img src="{{$wishlist->default_image}}" alt="carousel">
                        <figcaption>
                            <h5>{{$wishlist->title}}</h5>
                            <!-- <p>Movies Trailer</p> -->
                        </figcaption>
                    </figure>

                    <a href="{{route('user.single' , $wishlist->admin_video_id)}}" class="hover-posts">
                        <span><i class="fa fa-play"></i>{{tr('watch_video')}}</span>
                    </a>

                </div>

            @endforeach
        
        </div>

    </section>

@endif

<!-- End Premium Videos -->

<!-- Category -->

@if(count($categories) > 0)

    <section id="category">
        
        <div class="row secBg">

            <div class="large-12 columns">

                <div class="column row">

                    <div class="heading category-heading clearfix">

                        <div class="cat-head pull-left">
                            <i class="fa fa-folder-open"></i>
                            <h4>{{tr('browse_category')}}</h4>
                        </div>

                        <div>
                            <div class="navText pull-right show-for-large">
                                <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                                <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>

                    </div>

                </div>

                <!--column row end-->

                <!-- category carousel -->

                <div id="owl-demo-cat" class="owl-carousel carousel cat-cont" data-car-length="6" data-items="6" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="4000" data-auto-width="true" data-margin="10" data-dots="false">
                    
                    @foreach($categories as $category)

                        <div class="item-cat item thumb-border">

                            <figure class="premium-img">

                                <img src="{{$category->picture}}" alt="carousel">
                                <a href="{{route('user.category' , $category->id)}}" class="hover-posts">
                                    <span><i class="fa fa-search"></i></span>
                                </a>
                            </figure>

                            <h6><a href="#">{{$category->name}}</a></h6>
                        
                        </div>

                    @endforeach

                    <!--item-cat end-->

                </div><!-- end carousel -->

                <div class="row collapse">
                    <div class="large-12 columns text-center row-btn">
                        <a href="{{route('user.categories')}}" class="button radius">{{tr('view_all')}}</a>
                    </div>
                </div><!--collapse end-->

            </div><!--large-12 columns end-->
        
        </div>

    </section>

@endif

<!-- End Category -->

<!-- main content -->

@if(count($recent_videos) > 0 )

    <section class="content" id="recent_video_content">
        <!-- newest video -->
        <div class="main-heading">
            <div class="row secBg padding-14">

                <div class="medium-8 small-8 columns">
                    <div class="head-title">
                        <i class="fa fa-film"></i>
                        <h4>{{tr('recent_videos')}}</h4>
                    </div><!--head-title end-->
                </div><!--medium-8 end-->

                <!-- <div class="medium-4 small-4 columns">
                    <ul class="tabs text-right pull-right" data-tabs>
                        <li class="tabs-title is-active"><a class="is-active" href="#" data-tab="1">all</a></li>
                        <li class="tabs-title" data-tab-index="1"><a href="#" data-tab="2">HD</a></li>
                    </ul>
                </div>  -->

                <!--medium-4 end-->
            </div><!--row end-->
        </div>

        <!--main-heading end-->

        <div class="row secBg">
        <div class="large-12 columns">

            <div class="row column head-text clearfix">

                <p class="pull-left">All Videos : <span>{{total_video_count()}} Videos posted</span></p>
                <div class="grid-system pull-right show-for-large">
                    <a class="secondary-button current grid-default" href="#"><i class="fa fa-th"></i></a>
                    <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                    <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                </div>

            </div><!--row end-->

            <div class="tabs-content">

                <div class="tab-container tab-content active" data-content="1">

                    <div class="row list-group">

                        @foreach($recent_videos as $recent_key => $recent_video)

                            @if($recent_key < 8)

                                <div class="item large-3 medium-6 columns group-item-grid-default">

                                    <div class="post thumb-border">

                                        <div class="post-thumb">

                                            <img src="{{$recent_video->default_image}}" alt="new video">

                                            <a href="{{route('user.single',$recent_video->admin_video_id)}}" class="hover-posts">
                                                <span><i class="fa fa-play"></i>{{tr('watch_video')}}</span>
                                            </a>

                                            <div class="video-stats clearfix">

                                                <div class="thumb-stats pull-left">
                                                    <h6>HD</h6>
                                                </div>

                                                <div class="thumb-stats pull-right">
                                                    <i class="fa fa-heart"></i>
                                                    <span>{{get_video_fav_count($recent_video->admin_video_id)}}</span>
                                                </div>

                                                <!-- <div class="thumb-stats pull-right">
                                                    <span>05:56</span>
                                                </div> -->

                                            </div>

                                        </div><!--post-thumb end-->

                                        <div class="post-des">

                                            <h6>
                                                <a href="{{route('user.single',$recent_video->admin_video_id)}}">
                                                    {{$recent_video->title}}
                                                </a>
                                            </h6>

                                            <div class="post-stats clearfix">
                                                <p class="pull-left">
                                                    <i class="fa fa-clock-o"></i>
                                                    <span>{{date('d M Y',strtotime($recent_video->publish_time))}}</span>
                                                </p>
                                                <p class="pull-left">
                                                    <i class="fa fa-eye"></i>
                                                    <span>{{$recent_video->watch_count}}</span>
                                                </p>
                                            </div><!--post-stats end-->

                                            <div class="post-summary">
                                                <p>{{$recent_video->description}}</p>
                                            </div>

                                            <!--post-summary end-->

                                            <div class="post-button">
                                                <a href="{{route('user.single',$recent_video->admin_video_id)}}" class="secondary-button">
                                                    <i class="fa fa-play-circle"></i>{{tr('watch_video')}}
                                                </a>
                                            </div>

                                            <!--post-button end-->

                                        </div><!--post-des end-->
                                    </div><!--post end-->
                                
                                </div>

                            @endif

                        @endforeach

                    </div><!--tab-container row end-->
                </div>

                <!--tab-container end-->

            </div>

            <div class="text-center row-btn">
                <!-- <a class="button radius" href="#">View All Video</a> -->
            </div>

            <!--text-center end-->

            </div><!-- large12-->
        </div><!-- End row -->

    </section> 

@endif

<!-- ad Section -->


@if(count($suggestions) > 0 )

    <section class="content margin-bottom-10" >
        <!-- newest video -->
        <div class="main-heading">
            <div class="row secBg padding-14">

                <div class="medium-8 small-8 columns">
                    <div class="head-title">
                        <i class="fa fa-magic"></i>
                        <h4>{{tr('suggestions')}}</h4>
                    </div>
                </div>

            </div><!--row end-->
        </div>

        <!--main-heading end-->

        <div class="row secBg">

            <div class="large-12 columns">

                <div class="row column head-text clearfix">

                    <!-- <p class="pull-left">All Videos : <span>{{total_video_count()}} Videos posted</span></p> -->
                    <div class="grid-system pull-right show-for-large">
                        <a class="secondary-button current grid-default" href="#"><i class="fa fa-th"></i></a>
                        <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                        <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                    </div>

                </div> <!--row end -->

                <div class="tabs-content">

                    <div class="tab-container tab-content active" data-content="1">

                        <div class="row list-group">

                            @foreach($suggestions as $suggestion_key => $suggestion)

                                @if($suggestion_key < 4)

                                    <div class="item large-3 medium-6 columns group-item-grid-default">

                                        <div class="post thumb-border">

                                            <div class="post-thumb">

                                                <img src="{{$suggestion->default_image}}" alt="new video">

                                                <a href="{{route('user.single',$suggestion->admin_video_id)}}" class="hover-posts">
                                                    <span><i class="fa fa-play"></i>{{tr('watch_video')}}</span>
                                                </a>

                                                <div class="video-stats clearfix">

                                                    <div class="thumb-stats pull-left">
                                                        <h6>HD</h6>
                                                    </div>

                                                    <div class="thumb-stats pull-right">
                                                        <i class="fa fa-heart"></i>
                                                        <span>{{get_video_fav_count($suggestion->admin_video_id)}}</span>
                                                    </div>

                                                    <!-- <div class="thumb-stats pull-right">
                                                        <span>05:56</span>
                                                    </div> -->

                                                </div>

                                            </div><!--post-thumb end-->

                                            <div class="post-des">

                                                <h6>
                                                    <a href="{{route('user.single',$suggestion->admin_video_id)}}">
                                                        {{$suggestion->title}}
                                                    </a>
                                                </h6>

                                                <div class="post-stats clearfix">
                                                    <p class="pull-left">
                                                        <i class="fa fa-clock-o"></i>
                                                        <span>{{date('d M Y',strtotime($suggestion->publish_time))}}</span>
                                                    </p>
                                                    <p class="pull-left">
                                                        <i class="fa fa-eye"></i>
                                                        <span>{{$suggestion->watch_count}}</span>
                                                    </p>
                                                </div><!--post-stats end-->

                                                <div class="post-summary">
                                                    <p>{{$suggestion->description}}</p>
                                                </div>

                                                <!--post-summary end-->

                                                <div class="post-button">
                                                    <a href="{{route('user.single',$suggestion->admin_video_id)}}" class="secondary-button">
                                                        <i class="fa fa-play-circle"></i>{{tr('watch_video')}}
                                                    </a>
                                                </div>

                                                <!--post-button end-->

                                            </div><!--post-des end-->
                                        </div><!--post end-->
                                    
                                    </div>

                                @endif

                            @endforeach

                        </div><!--tab-container row end-->
                    </div>

                    <!--tab-container end-->

                </div>

                <!-- <div class="text-center row-btn">
                    <a class="button radius" href="#">View All Video</a>
                </div> -->

                <!--text-center end-->

            </div>

            <!-- large12-->

        </div><!-- End row -->

    </section> 

@endif

@endsection

@section('styles') 
    <style type="text/css">
        .jwplayer.jw-flag-aspect-mode {
            min-height: 466px;
        }
    </style>
@endsection