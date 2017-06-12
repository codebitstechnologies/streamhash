@extends('layouts.user')


@section('content')

    <?php $url = $trailer_url = ""; ?>
    
    <div class="col-md-9 col-sm-8">
        
        <div class="row">
            
            <div class="video-player">
                <div class="videoWrapper">

                    @include('user.videos.streaming')

                </div>
            </div>
            
            <div class="content">
                <div class="title">
                    <h3 style="width: 70%">{{$video->title}} <span class="dur">{{$video->duration}}</span></h3>
                    <form method="post" name="watch_main_video" class="watch-full-form" style="width: 25%">

                        @if(Auth::check())
                            <div class="pull-left">
                                @if(watchFullVideo(Auth::user()->id, Auth::user()->user_type, $video) ==  1)
                                    <input class="watch-full" type="submit" id="watch_main_video_button" name="submit" value="{{tr('watch_main_video')}}" style="background: green">
                                @else

                                    @if(envfile('PAYPAL_ID') && envfile('PAYPAL_SECRET'))
                                        <button type="button" class="watch-full" data-toggle="modal" data-target="#paypal" style="background: green">{{tr('watch_main_video')}}</button>
                                    @else

                                        <button type="button" class="watch-full" disabled style="background: green">{{tr('watch_main_video')}}</button>
                                    @endif

                                    <div class="modal fade cus-mod" id="paypal" role="dialog">
                                        <div class="modal-dialog">
                                        
                                          
                                          <div class="modal-content">

                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">{{tr('pay_now_content')}}</h4>
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
                                    <button onclick="showReportForm();" type="button" class="watch-full" id="mark-as-spam"><i class="fa fa-flag"></i> {{tr('report')}}</button>
                                @else 
                                    <a href="{{route('user.remove.report_video', $flaggedVideo->id)}}" class="btn btn-warning" style="padding: 4px 5px;font-size: 12px;"><i class="fa fa-flag"></i> {{tr('remove_report')}}</a>
                                @endif

                            </div>
                            <div class="clearfix"></div>
                        @else

                            <button type="button" class="btn btn-default watch-full" data-toggle="modal" data-target="#watchMainVideo">{{tr('watch_main_video')}}</button>

                            <div class="modal fade cus-mod" id="watchMainVideo" role="dialog">
                                <div class="modal-dialog">
                                
                                  <!-- Modal content-->
                                  <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">{{tr('pay_now_login_content')}}</h4>
                                        </div>

                                        <div class="modal-body">
                                            <!-- <p>Please {{tr('login')}}</p>  -->
                                            <a href="{{route('user.login.form')}}" class="btn btn-info">{{tr('login')}}</a>
                                        </div>

                                  </div>
                                  
                                </div>
                            </div>

                        @endif
                    </form>
                </div>

                <div class="btns">
                    @if(Auth::check())

                        <form name="add_to_wishlist" method="post" id="add_to_wishlist" action="{{route('user.add.wishlist')}}">
                            
                            <input type="hidden" value="{{$video->admin_video_id}}" name="admin_video_id">
                            
                            @if(count($wishlist_status) == 1)
                                
                                <input type="hidden" id="status" value="0" name="status">
                                
                                <input type="hidden" id="wishlist_id" value="{{$wishlist_status->id}}" name="wishlist_id">
                                
                                <button class="add" type="submit" id="added_wishlist" style="color:#DDD;background-color:#cb0000">{{tr('added')}}</button>
                            @else

                                <input type="hidden" id="status" value="1" name="status">
                                
                                <input type="hidden" id="wishlist_id" value="" name="wishlist_id">

                                <button type="submit" id="added_wishlist" class="add">+ {{tr('add_to')}} {{tr('wishlist')}}</button>

                            @endif
                        </form>
                    @else
                        <button type="button" class="add" data-toggle="modal" data-target="#AddWishList">+ {{tr('add_to')}} {{tr('wishlist')}}<i class="fa fa-heart"></i></button>

                        <div class="modal fade cus-mod" id="AddWishList" role="dialog">
                            <div class="modal-dialog">
                            
                              <!-- Modal content-->
                              <div class="modal-content">

                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">{{tr('please_login')}}</h4>
                                    </div>

                                    <div class="modal-body">
                                         
                                        <a href="{{route('user.login.form')}}" class="btn btn-info">{{tr('login')}}</a>
                                    </div>
                              </div>
                              
                            </div>
                        </div>
                    @endif

                    <a href="http://www.facebook.com/sharer.php?u={{route('user.single',$video->admin_video_id)}}" target="_blank"  class="fb-share">{{tr('share_on_fb')}}</a>  
                    <a href="http://twitter.com/share?text={{$video->title}}...&url={{route('user.single',$video->admin_video_id)}}" target="_blank" class="gp-share">{{tr('share_on_twitter')}}</a>
                </div>

                <div>

                    <p class="des">{{$video->description}}</p>
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

                @if(Auth::check())

                    <div class="command-box">
                        <form method="post" id="comment_sent" name="comment_sent" action="{{route('user.add.comment')}}">
                            <div class="form-group">
                                <input type="hidden" value="{{$video->admin_video_id}}" name="admin_video_id">
                                <label for="email">{{tr('add_comment_msg')}} :</label>
                                <textarea id="comment" required style="resize:none" name="comments" placeholder="{{tr('add_comment_msg')}}" class="form-control"></textarea>
                            </div>
                            <div class="text-right"> 
                                <input type="submit" class="btn btn-default" name="submit" value="send">                     
                            </div>
                        </form>
                    </div>

                @endif

                @if(count($comments) > 0)
              
                    <p class="show-comments-text">More {{tr('comments')}}</p>

                    <span id="new-comment"></span>

                    @foreach($comments as $c => $comment)

                        @if($c > 2)
                            <div class="show-comments-content"> 
                        @endif

                            <div class="com-list">
                                <div class="com-img">
                                    <img src="{{$comment->picture}}">
                                </div>
                                
                                <div class="com-detail">
                                    <h5>{{$comment->username}}</h5>
                                    <h6>{{$comment->created_at->diffForHumans()}}</h6>
                                    <p>{{$comment->comment}}</p>
                                </div>
                            </div>

                        @if($c > 2)
                            </div>
                        @endif

                    @endforeach

                @else

                    <span id="new-comment" style="margin-top:10px"></span>
                @endif
            
            </div>

        </div>

        <div class="row">
            <div class="video-full-box single">
                <div class="box-title">
                    <h3>{{tr('recent_videos')}}</h3>
                </div>

                @foreach($recent_videos as $recent_video)

                <div class="video-box">
                     <a href="{{route('user.single' , $recent_video->admin_video_id)}}">
                        <?php 
                            $video_imagess = get_video_image($recent_video->admin_video_id); 
                        ?>

                        @if($video_imagess->count() == 0)
                            <img class="first" src="{{$recent_video->default_image}}"><!-- main image -->
                            <img class="second" src="{{$recent_video->default_image}}"><!-- main image -->
                            <img class="third" src="{{$recent_video->default_image}}"><!-- main image -->
                        @else
                        @foreach($video_imagess as $video_image)

                            @if($video_image->position == 2)
                                <img class="first" src="{{$video_image->image}}"><!-- last -->
                            @else
                                <img class="third" src="{{$video_image->image}}"><!-- second image -->
                            @endif
                            <img class="second" src="{{$recent_video->default_image}}"><!-- main image -->
                        @endforeach
                        
                        @endif
                        <span class="time">{{$recent_video->duration}}</span>
                        <h5 class="video-title">{{$recent_video->title}}</h5>
                    </a>
                </div>

                @endforeach

            </div>
        
        </div>

    </div>

    <div class="col-md-3 col-sm-4">
        <div class="row sidebar">
            <div class="video-full-box">

                <div class="box-title">
                  <h3>{{tr('suggestions')}}</h3>
                </div>

                @foreach($suggestions as $suggestion)

                <div class="video-box">
                     <a href="{{route('user.single' , $suggestion->admin_video_id)}}">
                        <?php 
                            $video_images = get_video_image($suggestion->admin_video_id); 
                        ?>

                        @if($video_images->count() == 0)
                            <img class="first" src="{{$suggestion->default_image}}"><!-- main image -->
                            <img class="second" src="{{$suggestion->default_image}}"><!-- main image -->
                            <img class="third" src="{{$suggestion->default_image}}"><!-- main image -->
                        @else

                        @foreach($video_images as $video_image)

                            @if($video_image->position == 2)
                                <img class="first" src="{{$video_image->image}}"><!-- last -->
                            @else
                                <img class="third" src="{{$video_image->image}}"><!-- second image -->
                            @endif
                            <img class="second" src="{{$suggestion->default_image}}"><!-- main image -->
                        @endforeach
                        
                        @endif
                        <span class="time">{{$suggestion->duration}}</span>
                        <h5 class="video-title">{{$suggestion->title}}</h5>
                    </a>
                </div>

                @endforeach


            </div>
        </div>
    </div>

@endsection

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

                            jQuery("#trailer-video-player").css("display", "none");
                            jQuery('#main_video_setup_error').hide();
                            jQuery('#trailer_video_setup_error').css("display", "block");

                            confirm('The video format is not supported in this browser. Please open with some other browser.');
                        
                        });


                        @if(!$history_status && Auth::check())

                            jwplayer().on('displayClick', function(e) {
                                jQuery.ajax({
                                    url: "{{route('user.add.history')}}",
                                    type: 'post',
                                    data: {'admin_video_id' : "{{$video->admin_video_id}}", 'video_status' : 0},
                                    success: function(data) {

                                       if(data.success == true) {

                                        // console.log('Added to history');

                                       } else {
                                            // console.log('Wrong...!');
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
                                    jQuery("#added_wishlist").css({'background':'#cb0000','color' : '#FFFFFF'});
                                    jQuery("#added_wishlist").append('Added <i class="fa fa-heart">');
                                } else {
                                    jQuery('#status').val("1");
                                    jQuery('#wishlist_id').val("");
                                    jQuery("#added_wishlist").css({'background':'','color' : ''});
                                    jQuery("#added_wishlist").append('+ ADD To Wishlist');
                                }
                           } else {
                                console.log('Wrong...!');
                           }
                        }
                });

            });

            $('#comment').keydown(function(event) {
                if (event.keyCode == 13) {
                    $(this.form).submit()
                    return false;
                 }
            });

            $("form[name='comment_sent']").on('keyup keypress keydown', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) { 
                    e.preventDefault();
                    return false;
                }
            });

            jQuery("form[name='comment_sent']").submit(function(e) {

                //prevent Default functionality
                e.preventDefault();

                //get the action-url of the form
                var actionurl = e.currentTarget.action;

                var comment_content = jQuery('#comment').val();

                if(comment_content != ''){

                    //do your own request an handle the results
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

                                    jQuery('#new-comment').prepend('<div class="com-list"><div class="com-img"><img src="{{Auth::user()->picture}}" ></div><div class="com-detail"><h5>{{Auth::user()->name}}</h5><h6>'+data.date+'</h6><p>'+data.comment.comment+'</p></div></div>');
                                @endif
                               } else {
                                    // console.log('Wrong...!');
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

                        if(isOpera || isSafari) {

                            jQuery('#trailer_video_setup_error').hide();
                            jQuery('#main-video-player').hide();
                            jQuery('#main_video_setup_error').show();

                            confirm('The video format is not supported in this browser. Please option some other browser.');

                        } else {

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
                                autostart : true,
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
                                autostart : true,
                                "sharing": {
                                    "sites": ["reddit","facebook","twitter"]
                                  }
                            
                            });


                            @endif
                            

                             
                            playerInstance.on('setupError', function() {

                                jQuery("#main-video-player").css("display", "none");
                                jQuery('#trailer_video_setup_error').hide();
                                jQuery('#main_video_setup_error').css("display", "block");
                                
                                confirm('The video format is not supported in this browser. Please option some other browser.');
                            
                            });

                            jQuery("#trailer-video-player").hide();
                            jQuery("#main-video-player").show();
                        }

                    @else
                        jQuery('#main_video_error').show();
                        jQuery('#trailer_video_error').hide();

                    @endif


                    // Remove trailer video url, to stop the autoplay while playing main video

                    //First get the  iframe URL
                   /* var url = jQuery('#iframe_trailer_video').attr('src');

                    jQuery('#iframe_trailer_video').attr('src', '');*/

                    /*jQuery("#trailer_video_play").hide();
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