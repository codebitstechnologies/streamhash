<header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{{Setting::get('site_name')}}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{Setting::get('site_name')}}</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">

        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">

                    <a href="{{route('moderator.profile')}}" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="@if(Auth::guard('moderator')->user()->picture){{Auth::guard('moderator')->user()->picture}} @else {{asset('admin-css/dist/img/avatar.png')}} @endif" class="user-image" alt="User Image">
                      <span class="hidden-xs">{{Auth::guard('moderator')->user()->name}}</span>
                    </a>
                    
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="@if(Auth::guard('moderator')->user()->picture){{Auth::guard('moderator')->user()->picture}} @else {{asset('admin-css/dist/img/avatar.png')}} @endif" class="img-circle" alt="User Image">

                            <p>
                              {{Auth::guard('moderator')->user()->name}}
                              <small>{{tr('moderator')}}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                 
                      <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{route('moderator.profile')}}" class="btn btn-default btn-flat">{{tr('profile')}}</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{route('moderator.logout')}}" class="btn btn-default btn-flat">{{tr('logout')}}</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>
    </nav>

</header>