@extends('install.layout')

@section('content')

 <div class="install-theme-outer">
    <div class="container">
        <div class="install-theme-inner">
            <div class="row no-margin">

                <div class="col-lg-4 col-md-4 col-sm-4" id="default_theme">
                    <div class="theme-select" id="default_theme_checked">
                        <h4 class="theme-select-head" id="default_theme_checked_title">Default Theme</h4>
                        <div class="sixteen-nine">
                            <div class="install-theme-image">
                                <a href="#"  target="_blank"><img src="{{asset('install/images/theme1.png')}}"></a>
                            </div><!--end of install-theme-image-->
                        </div><!--end of sixteen-nine-->

                        <div class="install-demo">
                            <form class="row no-margin">
                                <div class="form-check">
                                    <label class="form-check-label" id="default_theme_checked_select">
                                    <input type="checkbox" name="default_theme" id="default_theme_check_box" class="form-check-input">Select Theme
                                    </label>
                                </div>
                                <a href="http://demo.streamhash.com/"  target="_blank"class="demo-button">Demo</a>
                            </form>
                        </div><!--end of install-demo-->
                    </div><!--end of theme-select-->
                </div><!--end of coloumn-->

                <div class="col-lg-4 col-md-4 col-sm-4" id="streamtube_theme">
                    <div class="theme-select" id="streamtube_theme_checked">
                    <h4 class="theme-select-head" id="streamtube_theme_checked_title">StreamTube</h4>
                        <div class="sixteen-nine">
                            <div class="install-theme-image">
                                <a href="javascript:void(0);" ><img src="{{asset('install/images/theme2.png')}}"></a>
                            </div><!--end of install-theme-image-->
                        </div><!--end of sixteen-nine-->

                        <div class="install-demo">
                            <form class="row no-margin">
                                <div class="form-check">
                                    <label class="form-check-label" id="streamtube_theme_checked_select">
                                    <input type="checkbox" name="streamtube_theme" id="streamtube_theme_check_box" class="form-check-input">Select Theme
                                    </label>
                                </div>
                                <a href="http://demo.streamhash.com/"  target="_blank" class="demo-button">Demo</a>
                            </form>
                        </div><!--end of install-demo-->
                    </div><!--end of theme-select-->

                </div><!--end of coloumn-->

                <div class="col-lg-4 col-md-4 col-sm-4" id="teen_theme">
                    <div class="theme-select" id="teen_theme_checked">
                    <h4 class="theme-select-head" id="teen_theme_checked_title">Teen Theme</h4>
                        <div class="sixteen-nine">
                            <div class="install-theme-image">
                                <a href="javascript:void(0);"><img src="{{asset('install/images/theme3.png')}}"></a>
                            </div><!--end of install-theme-image-->
                        </div><!--end of sixteen-nine-->

                        <div class="install-demo">
                            <form class="row no-margin">
                                <div class="form-check">
                                    <label class="form-check-label" id="teen_theme_checked_select">
                                    <input type="checkbox" name="teen_theme" id="teen_theme_check_box" class="form-check-input"> <span>Select Theme</span>
                                    </label>
                                </div>
                                <a href="http://demo.streamhash.com/" target="_blank" class="demo-button">Demo</a>
                            </form>
                        </div><!--end of install-demo-->
                    </div><!--end of theme-select-->

                </div><!--end of coloumn-->

            </div><!--end of row-->

        </div><!--end of install-theme-inner-->
    </div><!--end of container-->
</div><!--end of install-theme-outer-->
@endsection

@section('footer')

<footer>
    <div class="container">
        <div class="row no-margin skip-continue">
            <div class="col-xs-6 skip">
                <!-- <button class="skip-button">Skip</button> -->
            </div><!--end of skip-->

            <div class="col-xs-6 continue">
                <form method="POST" action="{{route('install.theme')}}">
                    <input type="hidden" name="theme" value="default" id="theme">
                    <button type="submit" class="continue-button">Continue</button>
                </form>
            </div><!--end of continue-->
        </div><!--end of skip-continue-->
    </div><!--end of container-->
</footer>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#default_theme').click(function() {

                if( $('#theme').val() != 'default' ) {

                    $('#theme').val('');
                    $('#theme').val('default');

                    $('#default_theme_check_box').prop('checked', true); // Unchecks it
                    $('#teen_theme_check_box').attr('checked', false); // Unchecks it
                    $('#streamtube_theme_check_box').attr('checked', false); // Unchecks it

                    $('#default_theme_checked').css({'background-color':'#e96969'});
                    $('#default_theme_checked_title').css({'color':'white'});
                    $('#default_theme_checked_select').css({'color':'white'});

                    $('#streamtube_theme_checked').css({'background-color':''});
                    $('#streamtube_theme_checked_title').css({'color':''});
                    $('#streamtube_theme_checked_select').css({'color':''});

                    $('#teen_theme_checked').css({'background-color':''});
                    $('#teen_theme_checked_title').css({'color':''});
                    $('#teen_theme_checked_select').css({'color':''});
                } else {
                    $('#theme').val('');
                    $('#default_theme_check_box').prop('checked', false); // Unchecks it

                    $('#default_theme_checked').css({'background-color':''});
                    $('#default_theme_checked_title').css({'color':''});
                    $('#default_theme_checked_select').css({'color':''});
                }
            });

            $('#streamtube_theme').click(function() {

                if( $('#theme').val() != 'streamtube' ) {

                    $('#theme').val('');
                    $('#theme').val('streamtube');

                    $('#streamtube_theme_check_box').prop('checked', true); // Unchecks it
                    $('#teen_theme_check_box').attr('checked', false); // Unchecks it
                    $('#default_theme_check_box').attr('checked', false); // Unchecks it

                    $('#default_theme_checked').css({'background-color':''});
                    $('#default_theme_checked_title').css({'color':''});
                    $('#default_theme_checked_select').css({'color':''});

                    $('#streamtube_theme_checked').css({'background-color':'#e96969'});
                    $('#streamtube_theme_checked_title').css({'color':'white'});
                    $('#streamtube_theme_checked_select').css({'color':'white'});

                    $('#teen_theme_checked').css({'background-color':''});
                    $('#teen_theme_checked_title').css({'color':''});
                    $('#teen_theme_checked_select').css({'color':''});

                } else {

                    $('#theme').val('');
                    $('#streamtube_theme_check_box').prop('checked', false); // Unchecks it

                    $('#streamtube_theme_checked').css({'background-color':''});
                    $('#streamtube_theme_checked_title').css({'color':''});
                    $('#streamtube_theme_checked_select').css({'color':''});

                }
            });

            $('#teen_theme').click(function() {

                if( $('#theme').val() != 'teen' ) {

                    $('#teen_theme_check_box').prop('checked', true); // Unchecks it
                    $('#streamtube_theme_check_box').attr('checked', false); // Unchecks it
                    $('#default_theme_check_box').attr('checked', false); // Unchecks it

                    $('#theme').val('');
                    $('#theme').val('teen');

                    $('#default_theme_checked').css({'background-color':''});
                    $('#default_theme_checked_title').css({'color':''});
                    $('#default_theme_checked_select').css({'color':''});

                    $('#streamtube_theme_checked').css({'background-color':''});
                    $('#streamtube_theme_checked_title').css({'color':''});
                    $('#streamtube_theme_checked_select').css({'color':''});

                    $('#teen_theme_checked').css({'background-color':'#e96969'});
                    $('#teen_theme_checked_title').css({'color':'white'});
                $('#teen_theme_checked_select').css({'color':'white'});

                } else {

                    $('#theme').val('');
                    $('#teen_theme_check_box').prop('checked', false); // Unchecks it

                    $('#teen_theme_checked').css({'background-color':''});
                    $('#teen_theme_checked_title').css({'color':''});
                    $('#teen_theme_checked_select').css({'color':''});

                }
            });
        });
    </script>

@endsection
