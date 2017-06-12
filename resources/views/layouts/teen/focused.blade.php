<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{Setting::get('site_name' , "StreamHash")}}</title>

        <meta name="description" content="">
        <meta name="author" content="">

        <link href="{{asset('adult/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('adult/css/jquery-ui.css')}}" rel="stylesheet">
        <link href="{{asset('adult/css/style.css')}}" rel="stylesheet">

        <link rel="shortcut icon" type="image/png" href="{{Setting::get('site_icon' , asset('img/favicon.png'))}}"/>

        <style type="text/css">
            .ui-autocomplete{
              z-index: 99999;
            }
        </style>

    </head>

    <body>

        <div class="container-fluid">

            @include('layouts.user.nav')

            <div class="row page-content">

                <div class="container">
                   
                    <div class="row">

                        @yield('content')

                    </div>
                
                </div>

            </div>

            @include('layouts.user.footer')

        </div>

        <script src="{{asset('adult/js/jquery.min.js')}}"></script>
        <script src="{{asset('adult/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('adult/js/jquery-ui.js')}}"></script>
        <script src="{{asset('adult/js/scripts.js')}}"></script>

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

                                window.location.href = "{{route('search', array('q' => 'all'))}}";

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


    </body>
</html>