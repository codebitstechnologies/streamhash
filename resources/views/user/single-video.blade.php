@extends('layouts.user')

@section('styles')

<style type="text/css">
.common-youtube {
    min-height: 0px !important;
}
textarea[name=comments] {
    resize: none;
}

</style>

@endsection

@section('content')

    <div class="y-content">

        <div class="row y-content-row">

            @include('layouts.user.nav')

            <div class="page-inner col-sm-9 col-md-10 profile-edit">
            
                <div class="profile-content">

                    <div class="row no-margin">

                        <div class="col-sm-12 col-md-8 play-video">

                            @include('user.videos.streaming')

                            <div class="main-content">
                                <div class="video-content">
                                    <div class="details">
                                        <div class="video-title">
                                            <div class="title row">
                                                <div style="width: 55%;">
                                                    <h3>{{$video->title}}</h3>
                                                </div>
                                                <div class="watch-duration">

                                                    <form method="post" name="watch_main_video">  
                                                        
                                                        @if(Auth::check())

															<div class="pull-left">
                                                            @if(watchFullVideo(Auth::user()->id, Auth::user()->user_type, $video) ==  1)                             
                                                            
                                                                <button type="submit" id="watch_main_video_button" class="watch-button" style="background:green;">{{tr('watch_main_video')}}</button>

                                                                <!-- <p>{{tr('duration')}} {{$video->duration}}</p> -->
                                                            @else

                                                                @if(envfile('PAYPAL_ID') && envfile('PAYPAL_SECRET'))

                                                                    <button  type="button" class="watch-button" data-toggle="modal" data-target="#paypal"  style="background:green;">{{tr('watch_main_video')}}</button>
                                                                @else

                                                                    <button  type="button" class="watch-button" disabled  style="background:green;">{{tr('watch_main_video')}}</button>
                                                                @endif



                                                                <div class="modal fade cus-mod" id="paypal" role="dialog">
                                                                    <div class="modal-dialog">
                                                                    
                                                                      <!-- Modal content-->
                                                                      <div class="modal-content">

                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title text-center">{{tr('pay_now_content')}}</h4>
                                                                            </div>


                                                                            <div class="modal-body">
                                                                                <!-- <p>Please Pay to see the full video</p>  -->
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
                                                                <button onclick="showReportForm();" type="button" class="report-button"><i class="fa fa-flag"></i> {{tr('report')}}</button>
                                                            @else 
                                                                <a href="{{route('user.remove.report_video', $flaggedVideo->id)}}" class="btn btn-warning"><i class="fa fa-flag"></i> {{tr('remove_report')}}</a>
                                                            @endif

                                                        </div>
                                                        <div class="clearfix"></div>
                                                        @else

                                                            <button type="button" class="watch-button" data-toggle="modal" data-target="#watchMainVideo">{{tr('watch_main_video')}}</button>

                                                            <div class="modal fade cus-mod" id="watchMainVideo" role="dialog">
                                                                <div class="modal-dialog">
                                                                
                                                                  <!-- Modal content-->
                                                                  <div class="modal-content">

                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            <h4 class="modal-title text-center">{{tr('pay_now_login_content')}}</h4>
                                                                        </div>

                                                                        <div class="modal-body text-center">
                                                                            <!-- <p>Click here to login</p>  -->
                                                                            <a href="{{route('user.login.form')}}" class="btn btn-danger">{{tr('login')}}</a>
                                                                        </div>

                                                                  </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        
                                                        @endif

                                                    </form>

                                                </div>
                                                
                                            </div>

                                            <div class="video-description">
                                                <h4>{{tr('description')}}</h4>
                                                <p>{{$video->description}}</p>
                                            </div><!--end of video-description-->                                       
                                        </div><!--end of video-title-->                                                             
                                    </div><!--end of details-->

                                    @if ($flaggedVideo == '')
                                        <div class="more-content" style="display: none;" id="report_video_form">
                                            <form name="report_video" method="post" id="report_video" action="{{route('user.add.spam_video')}}">
                                                <b>Report this Video ?</b>
                                                <br>
                                                @foreach($report_video as $report) 
                                                    <input type="radio" name="reason" value="{{$report->value}}" required> {{$report->value}}<br>
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

                                    <div class="more-content">
                                        
                                        <div class="share-details row">

                                            <form name="add_to_wishlist" method="post" id="add_to_wishlist" action="{{route('user.add.wishlist')}}">
                                                @if(Auth::check())

                                                    <input type="hidden" value="{{$video->admin_video_id}}" name="admin_video_id">

                                                    @if(count($wishlist_status) == 1)

                                                        <input type="hidden" id="status" value="0" name="status">

                                                        <input type="hidden" id="wishlist_id" value="{{$wishlist_status->id}}" name="wishlist_id">

                                                        @if($flaggedVideo == '')
                                                        <div class="mylist">
                                                            <button style="background-color:rgb(229, 45, 39);" type="submit" id="added_wishlist" data-toggle="tooltip" title="Add to My List">
                                                                <i class="fa fa-heart"></i>
                                                                <span>{{tr('added_wishlist')}}</span>
                                                            </button> 
                                                        </div>
                                                        @endif
                                                    @else

                                                        <input type="hidden" id="status" value="1" name="status">

                                                        <input type="hidden" id="wishlist_id" value="" name="wishlist_id">
                                                        @if($flaggedVideo == '')
                                                            <div class="mylist">
                                                                <button type="submit" id="added_wishlist" data-toggle="tooltip" title="Add to My List">
                                                                    <i class="fa fa-heart"></i>
                                                                    <span>{{tr('add_to_wishlist')}}</span>
                                                                </button> 
                                                            </div>
                                                        @endif
                                                    @endif
                                                
                                                @else
                                                    <!-- Login Popup -->
                                                @endif

                                            </form>

                                            <div class="share">
                                                <a class="share-fb" target="_blank" href="http://www.facebook.com/sharer.php?u={{route('user.single',$video->admin_video_id)}}">
                                                    
                                                    <i class="fa fa-facebook"></i>{{tr('share_on_fb')}}
                                                    
                                                </a>

                                                <a class="share-twitter" target="_blank" href="http://twitter.com/share?text={{$video->title}}...&url={{route('user.single',$video->admin_video_id)}}">
                                                   
                                                    <i class="fa fa-twitter"></i>{{tr('share_on_twitter')}}
                                                    
                                                </a> 
                                            </div><!--end of share-->

                                            <div class="stars ratings">
                                                <a href="#"><i @if($video->ratings > 1) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                                <a href="#"><i @if($video->ratings > 2) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                                <a href="#"><i @if($video->ratings > 3) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                                <a href="#"><i @if($video->ratings > 4) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                                <a href="#"><i @if($video->ratings > 5) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                            </div><!--end of stars-->

                                        </div><!--end of share-details-->                               
                                    </div>
                                    <!--end of more-content-->

                                </div><!--end of video-content-->
                                
                                @if(count($comments) > 0) <div class="v-comments"> @endif

                                    @if(count($comments) > 0) 
                                        <h3>{{tr('comments')}}
                                            <span class="c-380" id="comment_count">{{count($comments)}}</span>
                                        </h3> 
                                    @endif
                                    
                                    <div class="com-content">
                                        @if(Auth::check())

                                            <div class="image-form">
                                                <div class="comment-box1">
                                                    <div class="com-image">
                                                        <img style="width:48px;height:48px" src="{{Auth::user()->picture}}">                                    
                                                    </div><!--end od com-image-->
                                                    
                                                    <div id="comment_form">
                                                        <div>
                                                            <form method="post" id="comment_sent" name="comment_sent" action="{{route('user.add.comment')}}">

                                                                <input type="hidden" value="{{$video->admin_video_id}}" name="admin_video_id">

                                                                <textarea rows="10" id="comment" name="comments" placeholder="{{tr('add_comment_msg')}}"></textarea>

                                                                <input style="float:right;margin-bottom:10px;display:none" type="submit" name="submit" value="send">
                                                            </form>
                                                        </div>                                      
                                                    </div>  <!--end of comment-form-->
                                                </div>                                                              
                                            
                                            </div>

                                        @endif

                                        @if(count($comments) > 0)
                                        
                                            <div class="feed-comment">

                                                <span id="new-comment"></span>

                                                @foreach($comments as $c =>  $comment)

                                                    <div class="display-com">
                                                        <div class="com-image">
                                                            <img style="width:48px;height:48px" src="{{$comment->picture}}">                                    
                                                        </div><!--end od com-image-->

                                                        <div class="display-comhead">
                                                            <span class="sub-comhead">
                                                                <a href="#"><h5 style="float:left">{{$comment->username}}</h5></a>
                                                                <a href="#" class="text-none"><p>{{$comment->created_at->diffForHumans()}}</p></a>
                                                                <p class="com-para">{{$comment->comment}}</p>
                                                            </span>             
                                                            
                                                        </div><!--display-comhead-->                                        
                                                    </div><!--display-com-->

                                                @endforeach

                                            </div>

                                        @else
                                            <div class="feed-comment">

                                                <span id="new-comment"></span>
                                            </div>
                                            <!-- <p>{{tr('no_comments')}}</p> -->
                                        
                                        @endif
                                            
                                    </div>

                                @if(count($comments) > 0) </div> @endif<!--end of v-comments-->
                                                                
                            </div>

                            <!--end of main-content-->

                        </div>

                        <!--end of col-sm-8 and play-video-->

                        <div class="col-sm-12 col-md-4 side-video custom-side">
                            <div class="up-next">
                                <h4 class="sugg-head1">{{tr('suggestions')}}</h4>

                                <ul class="video-sugg"> 

                                    @foreach($suggestions as $suggestion)
                                        <li class="sugg-list row">
                                            <div class="main-video">
                                                 <div class="video-image">
                                                    <div class="video-image-outer">
                                                        <a href="{{route('user.single' , $suggestion->admin_video_id)}}"><img src="{{$suggestion->default_image}}"></a>
                                                    </div>                       
                                                </div><!--video-image-->

                                                <div class="sugg-head">
                                                    <div class="suggn-title">                                          
                                                        <h5><a href="{{route('user.single' , $suggestion->admin_video_id)}}">{{$suggestion->title}}</a></h5>
                                                    </div><!--end of sugg-title-->

                                                    <div class="sugg-description">
                                                        <p>{{tr('duration')}}: {{$suggestion->duration}}</p>
                                                    </div><!--end of sugg-description--> 

                                                    <span class="stars">
                                                        <a href="#"><i @if($suggestion->ratings > 1) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                                        <a href="#"><i @if($suggestion->ratings > 2) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                                        <a href="#"><i @if($suggestion->ratings > 3) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                                        <a href="#"><i @if($suggestion->ratings > 4) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                                        <a href="#"><i @if($suggestion->ratings > 5) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                                    </span>                                                       
                                                </div><!--end of sugg-head-->
                                    
                                            </div><!--end of main-video-->
                                        </li><!--end of sugg-list-->
                                    @endforeach
                                   
                                    
                                </ul>
                            </div><!--end of up-next-->
                                                
                        </div><!--end of col-sm-4-->

                    </div>
                </div>
            
            </div>

        </div><!--y-content-row-->
    </div>

    <!--end of y-content-->
    
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.video-y-menu').addClass('hidden');
        }); 
        function showReportForm() {
            var divId = document.getElementById('report_video_form').style.display;
            if (divId == 'none') {
                $('#report_video_form').show(500);
            } else {
                $('#report_video_form').hide(500);
            }
        }
    </script>

    <script src="{{asset('jwplayer/jwplayer.js')}}"></script>

    <script>jwplayer.key="{{envfile('JWPLAYER_KEY')}}";</script>

    <script type="text/javascript">
        
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

                @if($trailer_video)

                    if(isOpera || isSafari) {
                        jQuery('#trailer_video_setup_error').show();
                        jQuery('#main_video_setup_error').hide();
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

                            // alert(trailerPath);
                            console.log(trailerPath);

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
                                    jQuery("#added_wishlist").css({'background':'rgb(229, 45, 39)','color' : '#FFFFFF'});
                                    jQuery("#added_wishlist").append('<i class="fa fa-heart"> {{tr('added_wishlist')}}');
                                } else {
                                    jQuery('#status').val("1");
                                    jQuery('#wishlist_id').val("");
                                    jQuery("#added_wishlist").css({'background':'','color' : ''});
                                    jQuery("#added_wishlist").append('<i class="fa fa-heart"> {{tr('add_to_wishlist')}}');
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

                //get the action-url of the form
                var actionurl = e.currentTarget.action;

                var form_data = jQuery("#comment").val();

                if(form_data) {

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

                                    jQuery('#new-comment').prepend('<div class="display-com"><div class="com-image"><img style="width:48px;height:48px" src="{{Auth::user()->picture}}"></div><div class="display-comhead"><span class="sub-comhead"><a href="#"><h5 style="float:left">{{Auth::user()->name}}</h5></a><a href="#"><p>'+data.date+'</p></a><p class="com-para">'+data.comment.comment+'</p></span></div></div>');
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

                jQuery('#watch_main_video_button').fadeOut();

                    @if($main_video)

                        if(isOpera || isSafari) {

                            jQuery('#main_video_setup_error').show();
                            jQuery('#trailer_video_setup_error').hide();
                            jQuery('#main-video-player').hide();

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

                                jQuery("#main-video-player").css("display", "none");
                                jQuery('#trailer_video_setup_error').hide();
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
                    /*var url = $('#iframe_trailer_video').attr('src');

                    $('#iframe_trailer_video').attr('src', '');

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
