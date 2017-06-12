@extends('layouts.user')

@section('content')


 <!--breadcrumbs-->
<section id="breadcrumb">
    <div class="row">
        <div class="large-12 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><i class="fa fa-home"></i><a href="{{route('user.dashboard')}}">{{tr('home')}}</a></li>
                    <li><a href="{{route('user.profile')}}">{{tr('profile')}}</a></li>
                    <li>
                        <span class="show-for-sr">Current: </span> {{tr('history')}}
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>
<!--end breadcrumbs-->

<div class="row">

    <!-- left sidebar -->

    @include('layouts.user.user-sidebar')

    <!-- end sidebar -->

    <!-- right side content area -->

    <div class="large-8 columns mar-top-space">

        @include('notification.notify')

        <!-- author videos -->
        <section class="content content-with-sidebar margin-bottom-10">

            <div class="row secBg">

                <div class="large-12 columns">

                    @include('layouts.user.notification')

                     @if(count($histories) > 0)

                        <div class="row column head-text clearfix">

                            <h4 class="pull-left">
                                <i class="fa fa-video-camera"></i>{{tr('history')}}
                            </h4>

                            <div class="grid-system pull-right show-for-large">
                                <!-- <a class="secondary-button current grid-default" href="#"><i class="fa fa-th"></i></a>
                                <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a> -->

                                <h4 class="pull-right" style="margin-left:5px">
                                    <a class="" onclick="return confirm('Are you sure?');" href="{{route('user.delete.history' , array('status' => 1))}}"><i class="fa fa-trash"></i></a>
                                </h4>

                                <!-- <a class="secondary-button current list" href="#"><i class="fa fa-th-list"></i></a> -->
                            </div>
                            <!--grid-system end-->
                        
                        </div>

                        <!--row end-->

                        <div class="tabs-content" data-tabs-content="newVideos">
                            
                            <div class="tabs-panel is-active" id="new-all">
                                <div class="row list-group">

                                    @foreach($histories as $i => $history)

                                        <div class="item large-4 medium-6 columns list">
                                            
                                            <div class="post thumb-border">

                                                <div class="post-thumb">
                                                    <img src="{{$history->default_image}}" alt="new video">
                                                    <a target="_blank" href="{{route('user.single' , $history->admin_video_id)}}" class="hover-posts">
                                                        <span><i class="fa fa-play"></i>{{tr('watch_video')}}</span>
                                                    </a>
                                                    <div class="video-stats clearfix">

                                                        <div class="thumb-stats pull-left">
                                                            <h6>HD</h6>
                                                        </div>

                                                        <div class="thumb-stats pull-right">
                                                            <i class="fa fa-heart"></i>
                                                            <span>{{get_video_fav_count($history->admin_video_id)}}</span>
                                                        </div>

                                                        <!-- <div class="thumb-stats pull-right">
                                                            <span>05:56</span>
                                                        </div> -->

                                                    </div>

                                                </div>

                                                <div class="post-des">
                                                    <h6><a href="#">{{$history->title}}</a></h6>
                                                    <div class="post-stats clearfix">
                                                        <p class="pull-left">
                                                            <i class="fa fa-clock-o"></i>
                                                            <span>{{date('d M Y',strtotime($history->publish_time))}}</span>
                                                        </p>
                                                        <p class="pull-left">
                                                            <i class="fa fa-eye"></i>
                                                            <span>{{$history->watch_count}}</span>
                                                        </p>
                                                    </div><!--post-stats end-->

                                                    <div class="post-summary">
                                                        <p>{{$history->decription}}</p>
                                                    </div><!--post-summary end-->

                                                    <div class="post-button">

                                                        <a target="_blank" href="{{route('user.single' , $history->admin_video_id)}}" class="secondary-button">
                                                            <i class="fa fa-play-circle"></i>{{tr('watch_video')}}
                                                        </a>

                                                        <a  onclick="return confirm('Are you sure?');" href="{{route('user.delete.history' , array('history_id' => $history->history_id))}}" class="secondary-button">
                                                            <i class="fa fa-trash-o"></i>{{tr('remove')}}
                                                        </a>

                                                    </div><!--post-button end-->
                                                </div>

                                                <!--post-des end-->

                                            </div>

                                            <!--post thumb-border-->
                                        
                                        </div>

                                    @endforeach

                                    <!-- items end-->                                        

                                </div><!--list-group end-->
                            
                            </div>

                            <!--tab-panel end-->
                        
                        </div>

                        <!--tab-content end-->

                        <div class="text-center row-btn">
                            <div align="right" id="paglink"><?php echo $histories->links(); ?></div>
                        </div>

                        <!-- <div class="text-center row-btn">
                            <a class="button radius" href="#">{{tr('view_all_video')}}</a>
                        </div> -->

                    @else

                        <div class="row column head-text clearfix">
                            <h4 class="pull-left" style="color:brown">{{tr('empty')}}
                            </h4>
                        </div>

                    @endif

                    <!--text-center end-->

                </div><!--large-12 end-->
            </div>

            <!-- secbg end-->
        
        </section>

    </div>

    <!-- end left side content area -->

</div>

<!--end left-sidebar row-->

@endsection