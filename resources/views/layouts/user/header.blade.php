<div class="youtube-nav">
    <div class="row">
        <div class="test toggle1">
            <a href="#"><i class="fa fa-align-justify toggle-icon" aria-hidden="true"></i></a>
        </div>
        <div class="test you-image">
            <a href="{{route('user.dashboard')}}" class="y-image">
                @if(Setting::get('site_logo'))
                    <img src="{{Setting::get('site_logo')}}">
                @else
                    <img src="{{asset('logo.png')}}">
                @endif
            </a>
        </div><!--test end-->

        <div id="custom-search-input" class="">
            <form method="post" action="{{route('search-all')}}" id="userSearch">
            <div class="input-group">
                
                    <input type="text" id="auto_complete_search" name="key" class="search-query form-control" required placeholder="Search" />
                    <span class="input-group-btn">
                        <button class="btn btn-danger" type="submit">
                        <span class=" glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                
            </div>
            </form>
        </div><!--custom-search-input end-->

        @if(Auth::check())
            <div class="y-button profile-button">
               <div class="dropdown">
                      <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        @if(Auth::user()->picture != "")
                            <img class="profile-image" src="{{Auth::user()->picture}}">
                        @else
                            <img class="profile-image" src="{{asset('placeholder.png')}}">
                        @endif
                        
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="{{route('user.profile')}}">{{tr('profile')}}</a></li>
                        <li><a href="{{route('user.wishlist')}}">{{tr('wishlist')}}</a></li>
                        <li><a href="{{route('user.history')}}">{{tr('history')}}</a></li>
                        <li><a href="{{route('user.spam-videos')}}">{{tr('spam_videos')}}</a></li>
                         <li><a href="{{route('user.pay-per-videos')}}">{{tr('pay_per_videos')}}</a></li>
                        @if (Auth::user()->login_by == 'manual') 
                            <li role="separator" class="divider"></li>
                            <li><a href="{{route('user.change.password')}}">{{tr('change_password')}}</a></li>
                        @endif

                        <li role="separator" class="divider"></li>
                        <li><a href="{{route('user.delete.account')}}" @if(Auth::user()->login_by != 'manual') onclick="return confirm('Are you sure? . Once you deleted account, you will lose your history and wishlist details.')" @endif>{{tr('delete_account')}}</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="{{route('user.logout')}}">{{tr('logout')}}</a></li>
                      </ul>
                    </div>
            </div><!--y-button end-->
        @else
            <div class="y-button">
                <a href="{{route('user.login.form')}}" class="y-signin">{{tr('login')}}</a>
            
            </div><!--y-button end-->
        @endif

    </div><!--end of row-->
</div><!--end of youtube-nav-->