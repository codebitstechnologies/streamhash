
<!-- Main Video Configuration -->

<div class="embed-responsive embed-responsive-16by9" id="main_video_setup_error" style="display: none;">
    <img src="{{asset('error.jpg')}}" class="error-image" alt="{{Setting::get('site_name')}} - Main Video">
</div>

<div id="main-video-player" style="display:none"></div>

@if(!check_valid_url($video->video))
    <div class="embed-responsive embed-responsive-16by9" style="display:none" id="main_video_error">
        <img src="{{asset('error.jpg')}}" class="error-image" alt="{{Setting::get('site_name')}} - Main Video">
    </div>
@endif

<!-- Main Video Configuration END -->

<!-- Trailer Video Configuration START -->

<div class="embed-responsive embed-responsive-16by9" id="trailer_video_setup_error" style="display: none;">
    <img src="{{asset('error.jpg')}}" class="error-image" alt="{{Setting::get('site_name')}} - Trailer Video">
</div>

<div id="trailer-video-player"></div>

@if(!check_valid_url($video->trailer_video))

    <div class="embed-responsive embed-responsive-16by9" id="trailer_video_error">
        <img src="{{asset('error.jpg')}}" class="error-image" alt="{{Setting::get('site_name')}} - Trailer Video">
    </div>

@endif

<!-- Trailer Video Configuration END -->