<!-- footer -->

<div id="footer-bottom">
    <div class="logo text-center">
        <a href="{{route('user.dashboard')}}"><img src="@if(Setting::get('site_logo')) {{Setting::get('site_logo') }} @else {{asset('logo.png')}} @endif" alt="logo"></a>
    </div>

    <div class="btm-footer-text text-center">
        <p><a href="http://streamhash.com" target="_blank">2017 © {{Setting::get('site_name' , 'StreamHash')}}</a></p>
    </div>
</div>

<!--footer-bottom end-->
