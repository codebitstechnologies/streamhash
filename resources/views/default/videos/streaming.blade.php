
<!-- Main Video Configuration -->

<div class="image" id="main_video_setup_error" style="display:none">
	<img src="{{asset('error.jpg')}}" alt="{{Setting::get('site_name')}}">
</div>

<div id="main-video-player" style="display:none"></div>

@if(!check_valid_url($video->video))
    <div class="image" id="main_video_error" style="display:none">
        <img src="{{asset('error.jpg')}}" alt="{{Setting::get('site_name')}}">
    </div>
@endif

<!-- Main Video Configuration END -->

<!-- Trailer Video Configuration START -->

<div class="image" id="trailer_video_setup_error" style="display: none;">
    <img src="{{asset('error.jpg')}}" alt="{{Setting::get('site_name')}}">
</div>

<div id="trailer-video-player"></div>

@if(!check_valid_url($video->trailer_video))

    <div class="image" id="trailer_video_error">
        <img src="{{asset('error.jpg')}}" alt="{{Setting::get('site_name')}}">
    </div>

@endif

<!-- Trailer Video Configuration END -->