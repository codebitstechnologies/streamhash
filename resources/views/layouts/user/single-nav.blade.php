<div class="y-menu video-y-menu hidden">
    <ul class="y-home menu1">

        <li><a href="{{route('user.dashboard')}}">
            <img src="{{asset('streamtube/images/y1.jpg')}}">{{tr('home')}}</a>
        </li>

        <li><a href="{{route('user.trending')}}">
            <img src="{{asset('streamtube/images/y10.png')}}">{{tr('trending')}}</a>
        </li>
        
    </ul>

    <?php  $categories = get_categories(); ?>

    @if(count($categories) > 0)
        
        <ul class="y-home ">
            <h3>Best of Streamtube</h3>
                @foreach($categories as $category)
                    <li>
                        <a href="{{route('user.category',$category->id)}}"><img src="{{$category->picture}}">{{$category->name}}</a>
                    </li>
                @endforeach              
        </ul>

    @endif

    @if(Auth::check())

    @else
        <div class="menu4">
            <p>Sign in now to see your channels and recommendations!</p>
            <form method="get" action="{{route('user.login.form')}}">
                <button type="submit">{{tr('login')}}</button>
            </form>
        </div>   
    @endif                
</div><!--y-menu end-->