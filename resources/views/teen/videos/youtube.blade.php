
<?php $url = $trailer_url = ""; ?>

<span id="trailer_video_play">
    <iframe id="iframe_trailer_video" width="580" height="315" src="{{$video->trailer_video}}?autoplay=0" allowfullscreen></iframe>
</span>

<span id="main_video_play" style="display:none">
    <iframe id="iframe_main_video" width="580" height="315" src="{{$video->video}}?autoplay=0" allowfullscreen></iframe>
</span>