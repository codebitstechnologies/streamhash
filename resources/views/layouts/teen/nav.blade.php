<div class="top-fix">
            
    <div class="row top-nav">

    	@if(Auth::check())
          <div class="container nav-pad">            
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">
               @if(Auth::check()) {{Auth::user()->name}} @else User @endif <span class="caret"></span>
              </button>
              	<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="{{route('user.profile')}}">{{tr('profile')}}</a></li>
					<li><a href="{{route('user.wishlist')}}">{{tr('wishlist')}}</a></li>   
					<li><a href="{{route('user.spam-videos')}}">{{tr('spam_videos')}}</a></li>  
					<li><a href="{{route('user.pay-per-videos')}}">{{tr('pay_per_videos')}}</a></li>  
					@if (Auth::user()->login_by == 'manual') 
						<li role="separator" class="divider"></li>

						<li><a href="{{route('user.change.password')}}">{{tr('change_password')}}</a></li>     
					@endif
					<li>
						<a href="{{route('user.delete.account')}}" @if(Auth::user()->login_by != 'manual') onclick="return confirm('Are you sure? . Once you deleted account, you will lose your history and wishlist details.')" @endif>
					        <i class="fa fa-trash"></i>{{tr('delete_account')}}
					    </a>

					</li>  

					<li><a href="{{route('user.logout')}}">{{tr('logout')}}</a></li>                
              	</ul>
            </div>  
          </div>

        @else 

      	<div class="container nav-pad">
	        <a href="{{ route('user.login.form') }}">{{tr('login')}}</a>  
	        <a href="{{route('user.register.form')}}">{{tr('register')}}</a>  
      	</div>

      	@endif
    
    </div>

    <div class="row main-nav">

      	<nav class="navbar navbar-default" role="navigation">

	        <div class="container nav-pad">
	          	<!-- Brand and toggle get grouped for better mobile display -->
	          	<div class="navbar-header">
		            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		              <span class="sr-only">Toggle navigation</span>
		              <span class="icon-bar"></span>
		              <span class="icon-bar"></span>
		              <span class="icon-bar"></span>
		            </button>
		            <a class="navbar-brand" href="{{route('user.dashboard')}}">
		            	
		            	@if(Setting::get('site_logo'))
			            	<img src="{{Setting::get('site_logo' , asset('logo.png'))}}">
			            @else
			            	<img src="{{asset('logo.png')}}">
			            @endif

		            </a>
	          	</div>

	          	<!-- Collect the nav links, forms, and other content for toggling -->
	          	
	          	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

		            <ul class="nav navbar-nav navbar-left">
		              	<li id="home"><a href="{{route('user.dashboard')}}">{{tr('videos')}}</a></li>
		              	<li id="categories"><a href="{{route('user.categories')}}">{{tr('categories')}}</a></li>
		              	<li id="trending"><a href="{{route('user.trending')}}">{{tr('trending')}}</a></li>
		              	@if(Auth::check())
		              	<li id="profile"><a href="{{route('user.wishlist')}}">{{tr('wishlist')}}</a></li>
		              	@endif
		              
		            </ul>

		            <form class="navbar-form navbar-right" role="search" id="userSearch" action="{{route('search-all')}}">
		              	<div class="form-group">
		                	<input type="search" required id="auto_complete_search" class="form-control" name="key" placeholder="{{tr('search')}}">
		              	</div>

		              	<button type="submit" class="btn btn-default">
		              		<i class="glyphicon glyphicon-search"></i>
						</button>
		            
		            </form>
	            
	          	</div>

	          	<!-- /.navbar-collapse -->

	        </div>

	        <!-- /.container-fluid -->
      	</nav>
    </div>

</div>


