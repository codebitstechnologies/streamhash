<div class="off-canvas position-left light-off-menu" id="offCanvas-responsive" data-off-canvas>

    <div class="off-menu-close">
        <h3>{{tr('menu')}}</h3>
        <span data-toggle="offCanvas-responsive"><i class="fa fa-times"></i></span>
    </div>

    <!--end of off-menu-close-->

    <ul class="vertical menu off-menu" data-responsive-menu="drilldown">
        <li >
            <a href="{{route('user.dashboard')}}"><i class="fa fa-home"></i>{{tr('home')}}</a>
        </li>

        <li class="has-submenu" data-dropdown-menu="example1">
            <a href="{{route('user.categories')}}"><i class="fa fa-film"></i>{{tr('categories')}}</a>
            
            <?php $categories = get_categories(); ?>

                @if(count($categories) > 0)
                    <ul class="submenu menu vertical" data-submenu data-animate="slide-in-down slide-out-up">
                        @foreach($categories as $c => $category)
                            <li>
                                <a href="{{route('user.category',$category->id)}}">
                                    <i class="fa fa-film"></i>{{$category->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
        </li>

        <li><a href="{{route('user.about')}}"><i class="fa fa-th"></i>{{tr('about')}}</a></li>

    </ul><!--vertical menu off-menu ul end-->

    <div class="responsive-search">
        <form method="post" action="{{route('search-all')}}">
            <div class="input-group">
                <input class="input-group-field" type="text" id="responsive_auto_complete_search" name="key" placeholder="search Here">
                <div class="input-group-button">
                    <button type="submit" name="search"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    </div><!--responsive-research end-->

    <!-- <div class="off-social">
        <h6>Get Socialize</h6>
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-google-plus"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
        <a href="#"><i class="fa fa-vimeo"></i></a>
        <a href="#"><i class="fa fa-youtube"></i></a>
    </div> --><!--off-social end-->

    <div class="top-button">
        <ul class="menu">
            @if(Auth::check())

                <li>
                    <a href="{{route('user.profile')}}"><i class="fa fa-user"></i>{{tr('my_account')}}</a>
                </li>

            @else
                <li class="dropdown-login">
                    <a href="{{route('user.login.form')}}">{{tr('login')}}</a>
                </li>
            @endif

        </ul>
    </div><!--top-button end-->

</div>