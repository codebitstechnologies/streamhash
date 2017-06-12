<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="@if(Auth::guard('moderator')->user()->picture){{Auth::guard('moderator')->user()->picture}} @else {{asset('admin-css/dist/img/avatar.png')}} @endif" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::guard('moderator')->user()->name}}</p>
                <a href="{{route('moderator.profile')}}">{{tr('moderator')}}</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">

            <li id="dashboard">
                <a href="{{route('moderator.dashboard')}}">
                    <i class="fa fa-dashboard"></i> <span>{{tr('dashboard')}}</span>
                </a>
            </li>

            <li class="treeview" id="videos">
                <a href="{{route('moderator.videos')}}">
                    <i class="fa fa-video-camera"></i> <span>{{tr('videos')}}</span>
                </a>

                <ul class="treeview-menu">
                    <li id="add-video"><a href="{{route('moderator.add.video')}}"><i class="fa fa-circle-o"></i>{{tr('add_video')}}</a></li>
                    <li id="view-videos"><a href="{{route('moderator.videos')}}"><i class="fa fa-circle-o"></i>{{tr('view_videos')}}</a></li>
                </ul>

            </li>

            <li id="profile">
                <a href="{{route('moderator.profile')}}">
                    <i class="fa fa-diamond"></i> <span>{{tr('profile')}}</span>
                </a>
            </li>

            <li>
                <a href="{{route('moderator.logout')}}">
                    <i class="fa fa-sign-out"></i> <span>{{tr('sign_out')}}</span>
                </a>
            </li>

        </ul>

    </section>

    <!-- /.sidebar -->

</aside>