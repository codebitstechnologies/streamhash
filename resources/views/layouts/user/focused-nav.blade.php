<div class="youtube-nav signup-nav">
    <div class="row">
        <div class="test you-image">
            <a href="{{route('user.dashboard')}}" class="y-image">
                @if(Setting::get('site_logo'))
                    <img src="{{Setting::get('site_logo')}}">
                @else
                    <img src="{{asset('logo.png')}}">
                @endif
            </a>
        </div><!--test end-->

        <div class="y-button">

        	@if(Auth::check())
        		<a href="{{route('user.profile')}}" class="y-signin">{{tr('back_profile')}}</a>
        	@else
        		<a href="{{route('user.register.form')}}" class="y-signin">{{tr('signup')}}</a>
                <a href="{{route('user.login.form')}}" class="y-signin">{{tr('login')}}</a>
        	@endif
        
        </div><!--y-button end-->

    </div><!--end of row-->
</div><!--end of youtube-nav-->