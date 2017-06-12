<!DOCTYPE html>
<html>
<head>
 	<title>{{Setting::get('site_name')}}</title>
  	<meta name="viewport" content="width=device-width,  initial-scale=1">
    <link rel="stylesheet" href="{{asset('install/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('install/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('install/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('install/css/animate.css')}}">

    <link rel="shortcut icon" href=" @if(Setting::get('site_icon')) {{ Setting::get('site_icon') }} @else {{asset('favicon.png') }} @endif">

</head>

<body>

  	<div class="october">

  		<div class="install-page">

      		<div id="october-wrap">
		        <header>
		        	<div class="container" id="containerHeader">
		             	<div class="row">
		    				<div class="col-md-12 october-image">
		        				<img src="{{asset('logo.png')}}">
		        			</div><!--end of october-image-->
						</div><!--end of row-->          
					</div><!--end of container-header-->

			       	<section class="title">
			            <div class="container" id="containerTitle">
			            	<div class="row">
			    				<div class="col-md-7">
			        				<h2 class="animate move_right animated slideInRight">@if($title) {{$title}} @endif</h2>
			    				</div>
				    			<div class="col-md-5 visible-md visible-lg">
						            <div class="steps row animated slideInUp">
						                <div class="col-sm-4 animated slideInup" id="system_check"><p>1</p></div>
						                <div class="col-sm-4 animated slideInup" id="theme_install"><p>2</p></div>
						                <div class="col-sm-4 animated slideInup" id="other_install"><p>3</p></div>
						            </div><!--end of steps-->
				    			</div>
							</div> <!--end of row-->               
						</div><!--end of conatainertitle-->
			        </section><!--end of title-->
		    	</header>
		    </div>

		    <!--end of october-wrap-->

		    @yield('content')

		</div>

			@yield('footer')

  	</div>

  <!--end of october-->

  	<script src="{{asset('install/js/jquery.min.js')}}"></script>
    <script src="{{asset('install/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('install/js/script.js')}}"></script>

    @yield('scripts')

    <script type="text/javascript">
        $("#{{$page}}").addClass("active");
    </script>
</body>
</html>