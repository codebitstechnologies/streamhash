@if(count($trendings) > 0)

    <section id="verticalSlider">

        <div class="row">

            <div class="large-12 columns" style="padding: 0;">

                <div class="thumb-slider">

                    <div class="main-image">

                        <?php $slider_video = get_slider_video(); ?>

                        @if(count($slider_video) > 0)

                            <div class="image {{$slider_video->admin_video_id}}">

                                <!-- if($slider_video->video_type != 1) --> <!-- Check the video type is other than the local upload -->

                                    <!-- <span id="trailer_video_play">
                                        <iframe id="iframe_trailer_video" width="580" height="315" src="{{$slider_video->trailer_video}}?autoplay=0" allowfullscreen></iframe>
                                    </span> -->

                                <!-- else -->

                                        <img src="{{$slider_video->default_image}}" alt="imaga">
                                        <a href="{{route('user.single' , $slider_video->admin_video_id)}}" class="hover-posts">
                                            <span><i class="fa fa-play"></i>{{tr('watch_video')}}</span>
                                        </a>

                                    <?php /** @if(check_valid_url($slider_video->trailer_video))
                                        <div id="trailer-video-player"></div>
                                    else
                                        <img src="{{asset('error.jpg')}}" alt="{{Setting::get('site_name')}}">
                                    @endif **/ ?>
                                <!-- endif -->

                            </div>  

                        @endif

                        @foreach($trendings as $trending_key => $trending)

                            @if($trending_key == 0)

                            @else

                                <div class="image {{$trending->admin_video_id}}">
                                    <img src="{{$trending->default_image}}" alt="imaga">
                                    <a href="{{route('user.single' , $trending->admin_video_id)}}" class="hover-posts">
                                        <span><i class="fa fa-play"></i>{{tr('watch_video')}}</span>
                                    </a>
                                </div>
                            @endif

                        @endforeach
                    </div>

                    <div class="thumbs">

                        <div class="thumbnails">

                        @if(count($slider_video = get_slider_video() ) > 0)

                            <div class="ver-thumbnail" id="{{$slider_video->admin_video_id}}">
                                <img src="{{$slider_video->default_image}}" alt="imaga">
                                <div class="item-title">
                                    <span>{{$slider_video->category_name}}</span>
                                    <h6>{{substr($slider_video->title,0,55)}}</h6>
                                </div>
                            </div>

                        @endif

                            @foreach($trendings as $trending_key => $trending)

                                @if($trending_key == 0)

                                @else

                                    <div class="ver-thumbnail" id="{{$trending->admin_video_id}}">
                                        <img src="{{$trending->default_image}}" alt="imaga">
                                        <div class="item-title">
                                            <span>{{$trending->category_name}}</span>
                                            <h6>{{substr($trending->title ,0,55)}}</h6>
                                        </div>
                                    </div>

                                @endif

                            @endforeach
                        </div>

                        <a class="up" href="javascript:void(0)"><i class="fa fa-angle-up"></i></a>
                        <a class="down" href="javascript:void(0)"><i class="fa fa-angle-down"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            
            </div>
        
        </div>

    </section>

@endif

@section('scripts')
    
    <script src="{{asset('jwplayer/jwplayer.js')}}"></script>

    <script>jwplayer.key="{{envfile('JWPLAYER_KEY')}}";</script>

    <script type="text/javascript">
        
        jQuery(document).ready(function(){

            @if(isset($slider_video))

                @if($slider_video->video_type == 1)

                    @if(check_valid_url($slider_video->trailer_video))

                        // var playerInstance = jwplayer("trailer-video-player");

                        // playerInstance.setup({
                        //     @if($slider_video->video_upload_type)
                        //         file: "{{Setting::get('streaming_url')}}{{get_video_end($slider_video->trailer_video)}}",
                        //     @else
                        //         file: "{{$slider_video->trailer_video}}",
                        //     @endif
                        //     image: "{{$slider_video->default_image}}",
                        //     width: "100%",
                        //     aspectratio: "16:9",
                        //     primary: "flash",
                        //     "controlbar.idlehide" : false,
                        //     controlBarMode:'floating',
                        //     "controls": {
                        //       "enableFullscreen": false,
                        //       "enablePlay": false,
                        //       "enablePause": false,
                        //       "enableMute": true,
                        //       "enableVolume": true
                        //     },
                        //     // autostart : true,
                        //     "sharing": {
                        //         "sites": ["reddit","facebook","twitter"]
                        //       }
                        // });

                    @else
                        console.log("Not Validd.....");
                    @endif
                @endif

            @endif
        });

    </script>
@endsection