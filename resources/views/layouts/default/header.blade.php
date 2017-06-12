<header>

    <!--Navber-->

    <section id="navBar">

        <nav class="sticky-container" data-sticky-container>

            <div class="sticky topnav" data-sticky data-top-anchor="navBar" data-btm-anchor="footer-bottom:bottom" data-margin-top="0" data-margin-bottom="0" style="width: 100%; background: #fff;" data-sticky-on="large">
                <div class="row">

                    <div class="large-12 columns">

                        <div class="title-bar" data-responsive-toggle="beNav" data-hide-for="large">

                            <button class="menu-icon" type="button" data-toggle="offCanvas-responsive"></button>

                            <!-- <div class="title-bar-title">
                                <img src="{{Setting::get('site_logo',asset('assets/images/logo-small.png')) }}" alt="logo">
                            </div> -->
                        </div><!--title-bar end -->

                        <div class="top-bar show-for-large" id="beNav" style="width: 100%;">
                            <div class="top-bar-left">
                                <ul class="menu">
                                    <li class="menu-text" style="padding:0px !important">
                                        <a href="{{route('user.dashboard')}}"><img src="@if(Setting::get('site_logo')) {{Setting::get('site_logo') }} @else {{asset('logo.png')}} @endif" alt="logo"></a>
                                    </li>
                                </ul>
                            </div><!--top-bar-left end-->

                            <div class="top-bar-right search-btn">
                                <ul class="menu">
                                    <li class="search">
                                        <i class="fa fa-search"></i>
                                    </li>
                                </ul>
                            </div><!--top-bar-right end-->

                            <div class="top-bar-right">
                                <ul class="menu vertical medium-horizontal" data-responsive-menu="drilldown medium-dropdown">
                                    
                                    <li class="has-submenu" id="home">
                                        <a href="{{route('user.dashboard')}}"><i class="fa fa-home"></i>{{tr('home')}}</a>
                                    </li>

                                    <li class="has-submenu" data-dropdown-menu="example1" id="categories">
                                        <a href="{{route('user.categories')}}"><i class="fa fa-film"></i>{{tr('category')}}</a>

                                        <?php $categories = get_categories(); ?>

                                        @if(count($categories) > 0)

                                        <ul class="submenu menu vertical" data-submenu data-animate="slide-in-down slide-out-up">
                                            @foreach($categories as $c => $category)
                                                <li><a href="{{route('user.category',$category->id)}}"><i class="fa fa-film"></i>{{$category->name}}</a></li>
                                            @endforeach
                                        </ul>

                                        @endif
                                   
                                    </li>


                                    <li id="about"><a href="{{route('user.about')}}"><i class="fa fa-user"></i>{{tr('about')}}</a></li>

                                   <!--  <li id="contact"><a href="{{route('user.contact')}}"><i class="fa fa-envelope"></i>{{tr('contact')}}</a></li> -->

                                    <li id="profile" class="has-submenu" data-dropdown-menu="example1">
                                        
                                        @if(Auth::check())

                                            <a href="{{route('user.profile')}}">
                                                <i class="fa fa-user"></i>
                                                </i>{{tr('my_account')}}
                                            </a>

                                        @else 

                                            <a href="{{route('user.login.form')}}">
                                                <i class="fa fa-sign-in"></i>
                                                </i>{{tr('login')}}
                                            </a>

                                            <ul style="display:none" class="submenu menu vertical login-reg" data-submenu data-animate="slide-in-down slide-out-up">
                                               
                                                <li class="login-form">

                                                    <h6 class="text-center">Great to have you back!</h6>

                                                    <form class="form-horizontal" name="login-form-user" id="login-form-user" role="form" method="POST" action="{{ url('/login') }}">
                                                        {!! csrf_field() !!}

                                                        <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}" >
                                                            <span class="input-group-label  users-login"><i class="fa fa-user"></i></span>
                                                            @if ($errors->has('email'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('email') }}</strong>
                                                                </span>
                                                            @endif
                                                            <input class="input-group-field" type="email" name="email" placeholder="Enter Email">
                                                        </div>

                                                        <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                            <span class="input-group-label users-login"><i class="fa fa-lock"></i></span>
                                                            @if ($errors->has('password'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('password') }}</strong>
                                                                </span>
                                                            @endif
                                                            <input class="input-group-field" name="password" type="text" placeholder="Enter password">
                                                        </div>
                                                        <div class="checkbox">
                                                            <input id="check1" type="checkbox" name="check" value="check">
                                                            <label class="customLabel" for="check1">{{tr('remember')}}</label>
                                                        </div>
                                                        <input class="login-now" type="submit" name="submit" value="Login Now">
                                                    </form>
                                                     <p class="text-center">{{tr('new_here')}}<a class="newaccount" href="login-register.html" style="
                                                        border-bottom: transparent !important; padding: 0 !important;
                                                    "> {{tr('new_account')}}</a></p>
                                                </li><!--end login-form-->
                                            
                                            </ul>

                                        @endif

                                    </li>

                                </ul>

                            </div>

                            <!--top-bar-right end-->

                        </div>

                        <!--top-bar end-->

                    </div>

                    <!--large-12 end-->

                </div>

                <!--sticy-container row end-->

                <div id="search-bar" class="clearfix search-bar-light">
                    <form method="post" action="{{route('search-all')}}" id="userSearch">
                        <div class="search-input float-left">
                            <input type="search" id="auto_complete_search" name="key" placeholder="Search Here your video">
                        </div>
                        <div class="search-btn float-right text-right">
                            <button class="button" id="" name="search" type="submit">{{tr('search')}}</button>
                        </div>
                    </form>
                </div>

                <!--search-bar-->

            </div>

            <!--sticky topnav end-->
        </nav>
    
    </section>

</header>