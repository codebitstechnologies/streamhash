@extends('layouts.user')

@section('content')

 <!--breadcrumbs-->

 <?php $url = $trailer_url = ""; ?>

<section id="breadcrumb" class="breadcrumb-video-2">
    <div class="row">
        <div class="large-12 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><i class="fa fa-home"></i><a href="{{route('user.dashboard')}}">{{tr('home')}}</a></li>
                    <li><a href="{{route('user.category' ,$video->category_id)}}">{{$video->category_name}}</a></li>

                    @if($video->is_series)
                        <li>
                            <a href="{{route('user.sub-category' ,$video->sub_category_id)}}">
                                {{$video->sub_category_name}}
                            </a>
                        </li>

                        <li>
                            <span class="show-for-sr">Current: </span> {{$video->genre_name}}
                        </li>
                    @else 

                        <li>
                            <span class="show-for-sr">Current: </span> {{$video->sub_category_name}}
                        </li>

                    @endif
                </ul><!--end breadcrumbs-->
            </nav>
        </div>
        <!--end large-12-->
    </div>
    <!--end breadcrumbs row-->

</section>

<!--end breadcrumb-->

<div class="row">
    <!-- left side content area -->

    <div class="large-8 columns">

        <!--single inner video-->

        <section class="inner-video">

            <div class="row secBg">
                <div class="large-12 columns inner-flex-video">

                    <div class="flex-video widescreen">

                            @include('user.videos.streaming')

                    </div><!--end flex-video-->

                </div><!--end inner-flex-video-->
            </div><!--end secBg-->
        
        </section>

        <!--end inner-video-->

        <!-- single post stats -->

        <section class="SinglePostStats">
            <!-- newest video -->
            <div class="row secBg">

                <div class="large-12 columns">

                    <div class="media-object stack-for-small">
                    
                        <!--media-object-section end-->

                        <div class="media-object-section object-second" style="display:block;width:100%;">
                            <div class="author-des clearfix">
                                <div class="post-title" style="width:57%">
                                    <h4>{{$video->title}}</h4>
                                    <p>
                                        <span>
                                            <i class="fa fa-clock-o"></i>
                                            {{date('d M Y',strtotime($video->publish_time))}}
                                        </span>

                                        <span>
                                            <i id="watch_count" class="fa fa-eye"> <span id="watch_count">{{$video->watch_count}}</span></i>
                                            
                                        </span>

                                        <!-- <span><i class="fa fa-thumbs-o-up"></i>1,862</span>
                                        <span><i class="fa fa-thumbs-o-down"></i>180</span> -->

                                        <span>
                                            <i class="fa fa-commenting"> <span id="video_comment_count">{{get_video_comment_count($video->admin_video_id)}}</span></i>
                                            
                                        </span>
                                    </p>
                                </div><!--post-title end-->

                                <div class="subscribe" style="width:43%">

                                    <form method="post" name="watch_main_video">

                                        
                                            @if(Auth::check())
											<div class="pull-left">
                                                @if(watchFullVideo(Auth::user()->id, Auth::user()->user_type, $video) ==  1)
                                                    
                                                    <button id="watch_main_video_button" style="background:green;color:#fff" type="submit" name="subscribe">{{tr('watch_main_video')}}</button>

                                                @else

                                                    @if(envfile('PAYPAL_ID') && envfile('PAYPAL_SECRET'))

                                                        <button style="background:green;color:#fff" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#paypal">{{tr('watch_main_video')}}</button>
                                                    @else
                                                        <button style="background:green;color:#fff" type="button" class="btn btn-info btn-lg" disabled>{{tr('watch_main_video')}}</button>
                                                    @endif

                                                    <div class="modal fade" id="paypal" role="dialog">
                                                        <div class="modal-dialog">
                                                        
                                                          <!-- Modal content-->
                                                          <div class="modal-content log-popup">

                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Please Pay to Watch the Full Video</h4>
                                                                </div>

                                                                <div class="modal-body">
                                                                   
                                                                    @if($video->amount > 0)
                                                                                    <a href="{{route('videoPaypal' , $video->admin_video_id)}}" class="btn btn-danger">{{tr('paynow')}}</a>
                                                                                @else 
                                                                                    <a href="{{route('paypal' , Auth::user()->id)}}" class="btn btn-danger">{{tr('paynow')}}</a>
                                                                                @endif
                                                                </div>

                                                                
                                                          </div>
                                                          
                                                        </div>
                                                    
                                                    </div>

                                                @endif
                                            </div>
                                             <div class="pull-right">
                                                @if($flaggedVideo == '')
                                                    <button onclick="showReportForm();" type="button" style="background:#e96969;color:#fff" id="mark-as-spam"><i class="fa fa-flag"></i> {{tr('report')}}</button>
                                                @else 
                                                    <a href="{{route('user.remove.report_video', $flaggedVideo->id)}}" class="btn btn-warning" style="padding: 8px 12px;"><i class="fa fa-flag"></i> {{tr('remove_report')}}</a>
                                                @endif

                                            </div>
                                            <div class="clearfix"></div>
                                        @else

                                            <button style="background:#e96969;color:#fff" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#watchMainVideo">{{tr('watch_main_video')}}</button>

                                            <div class="modal fade" id="watchMainVideo" role="dialog">
                                                <div class="modal-dialog">
                                                
                                                  <!-- Modal content-->
                                                  <div class="modal-content log-popup">

                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Please Login to Watch this Video.</h4>
                                                        </div>

                                                        <div class="modal-body">
                                                            <a href="{{route('user.login.form')}}" class="btn btn-info">{{tr('login')}}</a>
                                                        </div>

                                                        <!-- <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div> -->
                                                  </div>
                                                  
                                                </div>
                                            </div>
                                        
                                        @endif

                                    </form>

                                </div>

                                <!--subscribe end-->
                            </div>

                            <!--author-des end-->                         
                            
                            <div class="social-share">
                                <div class="post-like-btn clearfix">

                                    <form name="add_to_wishlist" method="post" id="add_to_wishlist" action="{{route('user.add.wishlist')}}">

                                        @if(Auth::check())

                                            <input type="hidden" value="{{$video->admin_video_id}}" name="admin_video_id">

                                            @if(count($wishlist_status) == 1)

                                                <input type="hidden" id="status" value="0" name="status">
                                                <input type="hidden" id="wishlist_id" value="{{$wishlist_status->id}}" name="wishlist_id">

                                                <button style="background:#e96969;color:#fff" type="submit" id="added_wishlist">Added <i class="fa fa-heart"></i></button>

                                            @else

                                                <input type="hidden" id="status" value="1" name="status">
                                                <input type="hidden" id="wishlist_id" value="" name="wishlist_id">

                                                <button type="submit" id="added_wishlist">Add to <i class="fa fa-heart"></i></button>
                                            @endif
                                        @else

                                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#AddWishList">Add to <i class="fa fa-heart"></i></button>

                                            <div class="modal fade" id="AddWishList" role="dialog">
                                                <div class="modal-dialog">
                                                
                                                  <!-- Modal content-->
                                                  <div class="modal-content log-popup">

                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Please Login and add the video to wishlist</h4>
                                                        </div>

                                                        <div class="modal-body">
                                                            <a href="{{route('user.login.form')}}" class="btn btn-info">{{tr('login')}}</a>
                                                        </div>

                                                        
                                                  </div>
                                                  
                                                </div>
                                            
                                            </div>

                                        @endif
                                        
                                    </form>

                                   <!--  <a href="#" class="secondary-button"><i class="fa fa-thumbs-o-up"></i></a>
                                    <a href="#" class="secondary-button"><i class="fa fa-thumbs-o-down"></i></a> -->

                                </div><!--post-like-btn end-->
                            </div>

                             @if ($flaggedVideo == '')
                                <div class="more-content" style="display: none;" id="report_video_form">
                                    <form name="report_video" method="post" id="report_video" action="{{route('user.add.spam_video')}}">
                                        <b>Report this Video ?</b>
                                        <br>
                                        @foreach($report_video as $report) 
                                            <input style="display:inline-block" type="radio" name="reason" value="{{$report->value}}" required> {{$report->value}}<br>
                                        @endforeach
                                        <input type="hidden" name="video_id" value="{{$video->admin_video_id}}" />
                                        <p class="help-block"><small>If you report this video, you won't see again the same video in anywhere in your account except "Spam Videos". If you want to continue to report this video as same. Click continue and proceed the same.</small></p>
                                        <div class="pull-right">
                                            <button class="btn btn-success btn-sm">Mark as Spam</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            @endif


                            <!--social-share end-->

                        </div>

                        <!--media-object-section end-->
                    
                    </div>

                    <!--media-object end-->
                
                </div>

                <!--large-12 columns end-->
            </div><!--end secBg-->
        
        </section>

        <!-- End single post stats -->

        <!-- single post description -->

        <section class="singlePostDescription">

            <div class="row secBg">

                <div class="large-12 columns">

                    <div class="heading">
                        <h5>{{tr('description')}}</h5>
                    </div><!--end heading-->

                    <div class="description showmore_one">

                        <p>{{$video->description}}</p>

                    </div><!--end description-->

                </div><!--end large-12-->


            </div><!--end secBg-->

            <div class="row secBg">

                <div class="large-12 columns">

                    <div class="heading">
                        
                        <h5>{{tr('ratings')}} 

                            <span class="starRating-view">
                                <input id="rating5" type="radio" name="ratings" value="5" @if($video->ratings == 5) checked @endif>
                                <label for="rating5">5</label>

                                <input id="rating4" type="radio" name="ratings" value="4" @if($video->ratings == 4) checked @endif>
                                <label for="rating4">4</label>

                                <input id="rating3" type="radio" name="ratings" value="3" @if($video->ratings == 3) checked @endif>
                                <label for="rating3">3</label>

                                <input id="rating2" type="radio" name="ratings" value="2" @if($video->ratings == 2) checked @endif>
                                <label for="rating2">2</label>

                                <input id="rating1" type="radio" name="ratings" value="1" @if($video->ratings == 1) checked @endif>
                                <label for="rating1">1</label>
                            </span>

                        </h5>
                    </div>

                    <div class="description showmore_one">

                        <h5>{{tr('reviews')}} </h5>

                        <p>{{$video->reviews}}</p>

                    </div><!--end description-->

                </div>

            </div>
        
        </section>

        <!-- End single post description -->

        <!-- Comments -->

        <section class="content comments">

            <div class="row secBg">
                
                <div class="large-12 columns">

                    <div class="main-heading borderBottom">

                        <div class="row padding-14">

                            <div class="medium-12 small-12 columns">

                                <div class="head-title">
                                    <i class="fa fa-comments"></i>
                                    <input type="hidden" id='comment_count_form' value="{{count($comments)}}">
                                    <h4>
                                        {{tr('comments')}} 
                                        (<span id="comment_count">{{count($comments)}}</span>)
                                    </h4>
                                </div>

                            </div>

                        </div>

                    </div>

                    @if(Auth::check())

                        <div class="comment-box thumb-border">

                            <div class="media-object stack-for-small">

                                <div class="media-object-section comment-img text-center">

                                    <?php $image = asset('placeholder.png'); ?> 

                                    @if(Auth::check()) 

                                        @if(Auth::user()->picture)
                                            <?php $image = Auth::user()->picture; ?> 
                                        @endif

                                    @endif

                                    <div class="comment-box-img">
                                        <img src= "{{$image}}" alt="comment">
                                    </div>
                                    <!--comment-box-img end-->

                                    <h6><a href="#">{{Auth::user()->name}}</a></h6>
                                
                                </div>

                                <div class="media-object-section comment-textarea">

                                    <form method="post" id="comment_sent" name="comment_sent" action="{{route('user.add.comment')}}">
                                        
                                        <input type="hidden" value="{{$video->admin_video_id}}" name="admin_video_id">

                                        <textarea id="comment" style="resize:none" name="comments" placeholder="Add a comment here.."></textarea>

                                        <input type="submit" name="submit" value="send">

                                    </form>
                                </div>
                            </div>

                        </div>

                    @else
                        <!-- Login and comment -->
                    @endif

                   <!--  <div class="comment-sort text-right">
                        <span>Sort By : <a href="#">newest</a> | <a href="#">oldest</a></span>
                    </div> -->

                    <!--comment-sort end-->

                    <!-- main comment -->

                    
                    <div class="main-comment showmore_one">

                        <span id="new-comment"></span>

                        @if(count($comments) > 0)

                            @foreach($comments as $comment)

                                <div class="media-object stack-for-small borderBottom">

                                    <div class="media-object-section comment-img text-center">
                                        <div class="comment-box-img">
                                            <img src= "@if($comment->picture) {{$comment->picture}} @else {{asset('placeholder.png')}} @endif" alt="comment">
                                        </div>
                                    </div>

                                    <div class="media-object-section comment-desc">

                                        <div class="comment-title">
                                            <span class="name"><a href="#">{{$comment->username}}</a> Said:</span>
                                            <span class="time float-right"><i class="fa fa-clock-o"></i>{{$comment->created_at->diffForHumans()}}</span>
                                        </div>

                                        <!--comment-tittle end-->

                                        <div class="comment-text">
                                            <p>{{$comment->comment}}</p>
                                        </div>

                                        <!--comment-text end-->

                                        <!--comment-btns start-->
                                        <!--comment-btns end-->

                                        <!--sub comment-->
                                        <!-- end sub comment -->

                                        <!--media-object end-->

                                    </div><!--media-object-section end-->
                                
                                </div>

                            @endforeach
                         @else

                            <p id="no_comment">{{tr('no_comments')}}</p>

                        @endif
                    
                    </div>

                </div><!--end large-12-->
            
            </div>

            <!--end secBg-->
        
        </section>

        <!-- End Comments -->
    </div>

    <!-- end left side content area -->

    <!-- sidebar -->

    <div class="large-4 columns">
        
        <aside class="secBg sidebar">
            
            <div class="row">

                <!-- categories -->

                @if(count($categories) > 0)

                    <div class="large-12 medium-7 medium-centered columns">
                        
                        <div class="widgetBox clearfix">
                            <div class="widgetTitle">
                                <h5>{{tr('categories')}}</h5>
                            </div><!--widget-title end-->

                            <div class="widgetContent clearfix">
                                <ul>
                                    @foreach($categories as $category)

                                        <li class="cat-item">
                                            <a href="{{route('user.category' , $category->id)}}">{{$category->name}} &nbsp; ({{get_category_video_count($category->id)}})</a>
                                        </li>

                                    @endforeach

                                </ul>
                            </div><!--widgetcontent end-->
                        </div><!--widgetbox end-->
                    
                    </div>

                @endif

                <!--large-12 end-->

                <!-- most view Widget -->

                @if(count($trendings))

                    <div class="large-12 medium-7 medium-centered columns">

                        <div class="widgetBox">

                            <div class="widgetTitle">
                                <h5>{{tr('trending')}}</h5>
                            </div>

                            <div class="widgetContent">

                                @foreach($trendings as $trending)

                                    @if($trending->admin_video_id != $video->admin_video_id)

                                        <div class="video-box thumb-border">

                                            <div class="video-img-thumb">

                                                <img src="{{$trending->default_image}}" alt="Treding">

                                                <a href="{{route('user.single' , $trending->admin_video_id)}}" class="hover-posts">
                                                    <span>
                                                        <i class="fa fa-play"></i>
                                                        {{tr('watch_video')}}
                                                    </span>
                                                </a>
                                            
                                            </div>

                                            <!--video-img-thumb end-->

                                            <div class="video-box-content">

                                                <h6><a href="#"></a>{{$trending->title}}</h6>
                                                <p>
                                                    <span><i class="fa fa-clock-o"></i>{{date('d M Y',strtotime($trending->publish_time))}}</span>
                                                    <span><i class="fa fa-eye"></i>{{$trending->watch_count}}</span>
                                                </p>
                                            </div>

                                            <!--video-box-content end-->
                                        
                                        </div>

                                    @endif

                                @endforeach

                                <!--video-box end-->

                            </div>

                            <!--widget-content end-->

                        </div>

                        <!--widget-box end-->
                    
                    </div>

                @endif

                <!-- end most view Widget --> 

            </div>

            <!--side-bar row end-->
        
        </aside>

        <!--sidebar end-->
    
    </div>

    <!-- end large-4 -->

</div>

<!-- row end-->

@endsection

<style type="text/css">
    
    .jwplayer .jwcontrolbar {
    display: inline-block !important;
    opacity: 1 !important;
}
</style>


@section('scripts')

    <script src="{{asset('jwplayer/jwplayer.js')}}"></script>

    <script>jwplayer.key="{{envfile('JWPLAYER_KEY')}}";</script>

    <script type="text/javascript">

        function showReportForm() {
            var divId = document.getElementById('report_video_form').style.display;
            if (divId == 'none') {
                jQuery('#report_video_form').show(500);
            } else {
                jQuery('#report_video_form').hide(500);
            }
        }
        
        jQuery(document).ready(function(){ 

                // Opera 8.0+
                var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
                // Firefox 1.0+
                var isFirefox = typeof InstallTrigger !== 'undefined';
                // At least Safari 3+: "[object HTMLElementConstructor]"
                var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
                // Internet Explorer 6-11
                var isIE = /*@cc_on!@*/false || !!document.documentMode;
                // Edge 20+
                var isEdge = !isIE && !!window.StyleMedia;
                // Chrome 1+
                var isChrome = !!window.chrome && !!window.chrome.webstore;
                // Blink engine detection
                var isBlink = (isChrome || isOpera) && !!window.CSS;

                // console.log('Inside Trailer Video');

                @if($trailer_video)

                    jQuery('#trailer_video_setup_error').hide();
                    jQuery('#main_video_setup_error').hide();

                    if(isOpera || isSafari) {

                        jQuery('#trailer_video_setup_error').show();

                        confirm('The video format is not supported in this browser. Please open with some other browser.');

                    } else {

                        // console.log('Inside Trailer video Player');

                        var playerInstance = jwplayer("trailer-video-player");


                        @if($trailerstreamUrl)

                            playerInstance.setup({
                                file: "{{$trailerstreamUrl}}",
                                image: "{{$video->default_image}}",
                                width: "100%",
                                aspectratio: "16:9",
                                primary: "flash",
                            
                            });
                        @else

                            var trailerVideoPath = "{{$trailer_video_path}}";
                            var trailerVideoPixels = "{{$trailer_pixels}}";

                            var trailerPath = [];

                            var splitTrailer = trailerVideoPath.split(',');

                            var splitTrailerPixel = trailerVideoPixels.split(',');


                            for (var i = 0 ; i < splitTrailer.length; i++) {

                                trailerPath.push({file : splitTrailer[i], label : splitTrailerPixel[i]});
                            }

                            playerInstance.setup({
                                sources: trailerPath,
                                image: "{{$video->default_image}}",
                                width: "100%",
                                aspectratio: "16:9",
                                primary: "flash",
                            
                            });
                        @endif

                        playerInstance.on('setupError', function() {

                            /*jQuery("#trailer-video-player").css("display", "none");
                            jQuery('#main_video_setup_error').hide();
                            jQuery('#trailer_video_setup_error').css("display", "block");
                            
                            confirm('The video format is not supported in this browser. Please open with some other browser.');*/
                        
                        });

                        @if(!$history_status && Auth::check())

                            jwplayer().on('displayClick', function(e) {
                                jQuery.ajax({
                                    url: "{{route('user.add.history')}}",
                                    type: 'post',
                                    data: {'admin_video_id' : "{{$video->admin_video_id}}", 'video_status' : 0},
                                    success: function(data) {

                                       if(data.success == true) {

                                        console.log('Added to history');

                                       } else {
                                            console.log('Wrong...!');
                                       }
                                    }
                                });
                                
                            });

                        @endif                    
                    
                    }

                @endif

            //hang on event of form with id=myform
            jQuery("form[name='add_to_wishlist']").submit(function(e) {

                //prevent Default functionality
                e.preventDefault();

                //get the action-url of the form
                var actionurl = e.currentTarget.action;

                //do your own request an handle the results
                jQuery.ajax({
                        url: actionurl,
                        type: 'post',
                        dataType: 'json',
                        data: jQuery("#add_to_wishlist").serialize(),
                        success: function(data) {
                           if(data.success == true) {

                                jQuery("#added_wishlist").html("");

                                if(data.status == 1) {
                                    jQuery('#status').val("0");

                                    jQuery('#wishlist_id').val(data.wishlist_id); 
                                    jQuery("#added_wishlist").css({'background':'#e96969','color' : '#FFFFFF'});
                                    jQuery("#added_wishlist").append('Added <i class="fa fa-heart">');
                                } else {
                                    jQuery('#status').val("1");
                                    jQuery('#wishlist_id').val("");
                                    jQuery("#added_wishlist").css({'background':'','color' : ''});
                                    jQuery("#added_wishlist").append('Add to <i class="fa fa-heart">');
                                }
                           } else {
                                console.log('Wrong...!');
                           }
                        }
                });

            });

            jQuery('#comment').keydown(function(event) {
                if (event.keyCode == 13) {
                    jQuery(this.form).submit()
                    return false;
                 }
            }).focus(function(){
                if(this.value == "Write your comment here..."){
                     this.value = "";
                }

            }).blur(function(){
                if(this.value==""){
                     this.value = "";
                }
            });

            jQuery("form[name='comment_sent']").submit(function(e) {

                //prevent Default functionality
                e.preventDefault();

                var form_data = jQuery("#comment").val();

                if(form_data) {

                    //get the action-url of the form
                    var actionurl = e.currentTarget.action;

                    // Do your own request an handle the results
                    jQuery.ajax({
                        url: actionurl,
                        type: 'post',
                        dataType: 'json',
                        data: jQuery("#comment_sent").serialize(),
                        success: function(data) {

                           if(data.success == true) {

                            @if(Auth::check())
                                jQuery('#comment').val("");
                                jQuery('#no_comment').hide();
                                var comment_count = 0;
                                var count = 0;
                                comment_count = jQuery('#comment_count').text();
                                var count = parseInt(comment_count) + 1;
                                jQuery('#comment_count').text(count);
                                jQuery('#video_comment_count').text(count);

                                jQuery('#new-comment').append('<div class="media-object stack-for-small borderBottom"><div class="media-object-section comment-img text-center"><div class="comment-box-img"><img src= "{{Auth::user()->picture}}" alt="comment"></div></div><div class="media-object-section comment-desc"><div class="comment-title"><span class="name"><a href="#">{{Auth::user()->name}}</a> Said:</span><span class="time float-right"><i class="fa fa-clock-o"></i>'+data.date+'</span></div><div class="comment-text"><p>'+data.comment.comment+'</p></div></div></div>')

                            @endif
                           } else {
                                console.log('Wrong...!');
                           }
                        }
                    
                    });

                } else {
                    return false;
                }

            });

            jQuery("form[name='watch_main_video']").submit(function(e) {

                //prevent Default functionality
                e.preventDefault();

                jQuery('#watch_main_video_button').hide();
                    
                    @if($main_video)

                        // console.log('Valid main Video URl');

                        if(isOpera || isSafari) {

                            // console.log('Opera or Safari');

                            jQuery('#trailer_video_setup_error').hide();
                            jQuery('#main-video-player').hide();
                            jQuery('#main_video_setup_error').show();

                            confirm('The video format is not supported in this browser. Please option some other browser.');

                        } else {

                            // console.log('main Video Player');
                            
                            var playerInstance = jwplayer("main-video-player");

                            @if($videoStreamUrl) 

  
                            playerInstance.setup({
                               
                                file: "{{$videoStreamUrl}}",
                                image: "{{$video->default_image}}",
                                width: "100%",
                                aspectratio: "16:9",
                                primary: "flash",
                                controls : true,
                                "controlbar.idlehide" : false,
                                controlBarMode:'floating',
                                "controls": {
                                  "enableFullscreen": false,
                                  "enablePlay": false,
                                  "enablePause": false,
                                  "enableMute": true,
                                  "enableVolume": true
                                },
                                // autostart : true,
                                "sharing": {
                                    "sites": ["reddit","facebook","twitter"]
                                  }
                            
                            });

                            @else

                            var videoPath = "{{$videoPath}}";
                            var videoPixels = "{{$video_pixels}}";

                            var path = [];

                            var splitVideo = videoPath.split(',');

                            var splitVideoPixel = videoPixels.split(',');


                            for (var i = 0 ; i < splitVideo.length; i++) {

                                path.push({file : splitVideo[i], label : splitVideoPixel[i]});
                            }

                            playerInstance.setup({
                               
                                sources: path,
                                image: "{{$video->default_image}}",
                                width: "100%",
                                aspectratio: "16:9",
                                primary: "flash",
                                controls : true,
                                "controlbar.idlehide" : false,
                                controlBarMode:'floating',
                                "controls": {
                                  "enableFullscreen": false,
                                  "enablePlay": false,
                                  "enablePause": false,
                                  "enableMute": true,
                                  "enableVolume": true
                                },
                                // autostart : true,
                                "sharing": {
                                    "sites": ["reddit","facebook","twitter"]
                                  }
                            
                            });


                            @endif
                            playerInstance.on('setupError', function() {

                                // console.log('main_video_setup_error');

                                jQuery('#trailer_video_setup_error').hide();

                                jQuery("#main-video-player").css("display", "none");

                                jQuery('#main_video_setup_error').css("display", "block");

                                confirm('The video format is not supported in this browser. Please option some other browser.');
                            
                            });
                        }
                    
                    @else
                        jQuery('#main_video_error').show();
                        jQuery('#trailer_video_error').hide();
                    @endif

                    jQuery("#trailer-video-player").hide();
                    jQuery("#main-video-player").show();
                

                    // Remove trailer video url, to stop the autoplay while playing main video

                    //First get the  iframe URL
                    /*var url = jQuery('#iframe_trailer_video').attr('src');

                    jQuery('#iframe_trailer_video').attr('src', '');

                    jQuery("#trailer_video_play").hide();
                    jQuery("#main_video_play").show();*/

                    @if(!$history_status)

                        jQuery.ajax({
                            url: "{{route('user.add.history')}}",
                            type: 'post',
                            data: {'admin_video_id' : "{{$video->admin_video_id}}", 'video_status' : 1},
                            success: function(data) {

                               if(data.success == true) {

                                var watch_count = 0;
                                var count = 0;
                                watch_count = jQuery('#watch_count').text();
                                var count = parseInt(watch_count) + 1;
                                jQuery('#watch_count').text(count);

                                console.log('Added to history');

                               } else {
                                    console.log('Wrong...!');
                               }
                            }
                        });

                    @endif

            });

        });
    </script>

@endsection
