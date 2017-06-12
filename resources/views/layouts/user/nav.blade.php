<div class="y-menu col-sm-3 col-md-2">
    <ul class="y-home menu1">
        <li id="home">
            <a href="{{route('user.dashboard')}}">
                <img src="{{asset('streamtube/images/y1.jpg')}}">{{tr('home')}}
            </a>
        </li>
        <li id="trending">
            <a href="{{route('user.trending')}}">
                <img src="{{asset('streamtube/images/y10.png')}}">{{tr('trending')}}
            </a>
        </li>
    </ul>

    @if(count($categories = get_categories()) > 0)
        
        <ul class="y-home ">
            <h3>{{tr('categories')}}</h3>
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
</div>