<!DOCTYPE html>
<html>

<head>
    <title>{{Setting::get('site_name' , "Start Streaming")}}</title>
    
    <meta name="viewport" content="width=device-width,  initial-scale=1">
    <link rel="stylesheet" href="{{asset('streamtube/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('streamtube/fonts/font-awesome/css/font-awesome.min.css')}}">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> 
    <link rel="stylesheet" type="text/css" href="{{asset('streamtube/css/slick.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('streamtube/css/slick-theme.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('streamtube/css/style.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('streamtube/css/responsive.css')}}">

    <link rel="shortcut icon" type="image/png" href="{{Setting::get('site_icon' , asset('img/favicon.png'))}}"/>
    <style type="text/css">
        .ui-autocomplete{
          z-index: 99999;
        }
    </style>

    @if(Setting::get('google_analytics'))
        <?php echo Setting::get('google_analytics'); ?>
    @endif

    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{Setting::get('site_name' , 'StreamHash')}}" />
    <meta property="og:description" content="The best solution to start up a video streaming venture!" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="{{Setting::get('site_name' , 'StreamHash')}}" />
    <meta property="og:image" content="{{Setting::get('site_icon')}}" />

    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:description" content="The best solution to start up a video streaming venture!"/>
    <meta name="twitter:title" content="{{Setting::get('site_name' , 'StreamHash')}}"/>
    <meta name="twitter:image:src" content="@if(Setting::get('site_icon')) {{ Setting::get('site_icon') }} @else {{asset('favicon.png') }} @endif"/>

    @yield('styles')

</head>

<body>

    @include('layouts.user.header')

    <div class="common-youtube">

        @yield('content')

    </div>

    @include('layouts.user.footer')
    
    <script src="{{asset('streamtube/js/jquery.min.js')}}"></script>
    <script src="{{asset('streamtube/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{asset('streamtube/js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('streamtube/js/slick.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('streamtube/js/script.js')}}"></script>

    <script>
        $(document).ready(function(){
     
            $('.box').slick({
                  dots: true,
                  infinite: false,
                  speed: 300,
                  slidesToShow: 5,
                    arrows: true,
                  slidesToScroll: 5,
                  responsive: [
                    {
                      breakpoint: 1024,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                      }
                    },
                    {
                      breakpoint: 480,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                  ]
            });
        });

    </script>

    <script type="text/javascript">

        jQuery(document).ready( function () {
            //autocomplete
            jQuery("#auto_complete_search").autocomplete({
                source: "{{route('search')}}",
                minLength: 1,
                select: function(event, ui){

                    // set the value of the currently focused text box to the correct value

                    if (event.type == "autocompleteselect"){
                        
                        // console.log( "logged correctly: " + ui.item.value );

                        var username = ui.item.value;

                        if(ui.item.value == 'View All') {

                            // console.log('View AALLLLLLLLL');

                            window.location.href = "{{route('search-all', array('q' => 'all'))}}";

                        } else {
                            // console.log("User Submit");

                            jQuery('#auto_complete_search').val(ui.item.value);

                            jQuery('#userSearch').submit();
                        }

                    }                        
                }      // select

            }); 

        });

    </script>

    @yield('scripts')

    <script type="text/javascript">
        @if(isset($page))
            $("#{{$page}}").addClass("active");
        @endif
    </script>

</body>

</html>