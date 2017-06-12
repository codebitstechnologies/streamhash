@extends('install.layout')

@section('content')

<section>

<div class="october-container">

    <div class="container">

        <div id="cover">
            <div id="slider_1">
                <p class="content animated slideInRight">
                @if($ngnix_config = check_nginx_configure())
                    <strong><i class="fa fa-check tick"></i></strong>
                @else
                    <strong><i class="fa fa-times incorrect"></i></strong>
                @endif
                    Ngnix installed and configured
                </p>
            </div>

            <div id="slider_2">
                <p class="content animated slideInRight">
                    @if($php_config = check_php_configure())
                        <strong><i class="fa fa-check tick"></i></strong>
                    @else
                        <strong><i class="fa fa-times incorrect"></i></strong>
                    @endif

                    PHP installation is required
                </p>
            </div>

            <div id="slider_3">
                <p class="content animated slideInRight">
                    @if($mysql_config = check_mysql_configure())
                        <strong><i class="fa fa-check tick"></i></strong>
                    @else
                        <strong><i class="fa fa-times incorrect"></i></strong>
                    @endif

                    MySQL installation is required
                </p>
            </div> 

            <div id="slider_4">
                <p class="content animated slideInRight">
                    @if($database_config = check_database_configure())
                        <strong><i class="fa fa-check tick"></i></strong>
                    @else
                        <strong><i class="fa fa-times incorrect"></i></strong>
                    @endif

                    Database connection is required
                </p>
            </div>

            <div id="slider_5">
                <p class="content animated slideInRight">
                    @if($settings_config = check_settings_seeder())
                        <strong><i class="fa fa-check tick"></i></strong>
                    @else
                        <strong><i class="fa fa-times incorrect"></i></strong>
                    @endif
                    SQL File intallation with database
                </p>
            </div>
        </div>

        <!--end of cover-->

        <?php $overall_configure = 0; ?>

        @if($php_config && $mysql_config && $database_config && $settings_config)

            <?php $overall_configure = 1; ?>

            <div class="check-fail-outer" id="system_check_result" style="display:none">

                <div class="check-success-inner">
                    <h4 class="fail-head">System Check Success</h4>
                
                </div>

                <!--end of check-fail-inner-->

            </div>

        @else

            <div class="check-fail-outer" id="system_check_result" style="display:none">

                <div class="check-fail-inner">
                    <h4 class="fail-head">System Check Failed</h4>
                    <p>Please do the basic installation requirement.</p>
                    <a style="text-decoration: none;cursor: pointer;" href="{{route('installTheme')}}" class="fail-button">Retry System Check</a>
                
                </div>

                <!--end of check-fail-inner-->

            </div>

        @endif

      <!--end of check-fail-outer-->
    
    </div>

    <!--end of container-->

</div><!--end of october-container-->

</section>


@endsection

@section('footer')
    <footer>
        <div class="container">
          <div class="row no-margin install-tree">

            <div class="col-md-6 col-md-offset-6 agree">

                @if($overall_configure == 0)
                    <button disabled>Agree &amp; continue</button>
                @else
                    <a href="{{route('system-check')}}" class="btn btn-primary btn-lg" style="float:right" href="#">Agree &amp; continue</a>
                @endif

            </div><!--end of agree-->

          </div><!--end of install-tree-->
        </div><!--end of container-->
    
    </footer>
@endsection