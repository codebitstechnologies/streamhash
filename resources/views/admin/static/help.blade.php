@extends('layouts.admin')

@section('title', tr('help'))

@section('content-header', tr('help'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-question-circle"></i> {{tr('help')}}</li>
@endsection

@section('content')

<div class="row">

    <div class="col-md-12">

    	<div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{tr('help')}}</h3>
            </div>

            <div class="box-body">

            	<div class="card">


			       	<div class="card-head style-primary">
			            <header>Hi there!</header>
			        </div>

            		<div class="card-body help">
		                <p>
		                  We would like to thank you for choosing StreamHash. Kudos from our team!!
		                </p>

		                <p>
		                  If you want to make any changes to your site, drop a mail to contact@streamhash.com or Skype us @ contact@streamhash.com and we will help you out!
		                </p>

		                <a href="https://www.facebook.com/StreamHash/" target="_blank"><img class="aligncenter size-full wp-image-159 help-image" src="http://default.streamhash.com/helpsocial/Facebook.png" alt="Facebook-100" width="100" height="100" /></a>
		                &nbsp;

		                <a href="https://twitter.com/StreamHash" target="_blank"><img class="size-full wp-image-155 alignleft help-image" src="http://default.streamhash.com/helpsocial/twitter.png " alt="Twitter" width="100" height="100" /></a>
		                &nbsp;

		                <a href="#" target="_blank"> <img class="wp-image-158 alignleft help-image" src="http://default.streamhash.com/helpsocial/skype.png" alt="skype" width="100" height="100" /></a>
		                &nbsp;

		                <a href="mailto:mail@aravinth.net" target="_blank"><img class="size-full wp-image-153 alignleft help-image" src="http://default.streamhash.com/helpsocial/mail.png" alt="Message-100" width="100" height="100" /></a>

			             &nbsp;


			             <p>We have this team of innate developers and dedicated team of support to sort out the things for your benefits. Tell us what you like about StreamHash and we may suggest you the best solution for you :)</p>

              			<a href="#" target="_blank"><img class="aligncenter help-image size-full wp-image-160" src="http://default.streamhash.com/helpsocial/Money-Box-100.png" alt="Money Box-100" width="100" height="100" /></a>

						<p>Cheers!</p>

            		</div>

        		</div>

    		</div>
        </div>

    </div>

</div>



@endsection
