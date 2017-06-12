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

        <!-- <a href="" class="btn btn-sm btn-default ml15">Hello</a> -->

        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

                <li class="dropdown notifications-menu">

                    <a href="{{url('/')}}" class="btn btn-default" target="_blank" style="color:black"> 
                        <i class="fa fa-external-link"></i>
                        <b> Visit Website</b>
                        <span class="label label-warning"></span>
                    </a>

                </li>

                <li class="dropdown user user-menu">

                    <a href="{{route('admin.profile')}}" class="dropdown-toggle" data-toggle="dropdown">
                      <img src="@if(Auth::guard('admin')->user()->picture){{Auth::guard('admin')->user()->picture}} @else {{asset('admin-css/dist/img/avatar.png')}} @endif" class="user-image" alt="User Image">
                      <span class="hidden-xs">{{Auth::guard('admin')->user()->name}}</span>
                    </a>
                    
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="@if(Auth::guard('admin')->user()->picture){{Auth::guard('admin')->user()->picture}} @else {{asset('admin-css/dist/img/avatar.png')}} @endif" class="img-circle" alt="User Image">

                            <p>
                              {{Auth::guard('admin')->user()->name}}
                              <small>{{tr('admin')}}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                 
                      <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{route('admin.profile')}}" class="btn btn-default btn-flat">{{tr('profile')}}</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{route('admin.logout')}}" class="btn btn-default btn-flat">{{tr('logout')}}</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>

        </div>
    </nav>

</header>

<style>
.nav>li>a:hover,.nav>li>a:active,.nav>li>a:focus {
    background: #fdfdfd !important;
}
</style>