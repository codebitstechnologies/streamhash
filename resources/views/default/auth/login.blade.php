@extends('layouts.user.focused')

@section('content')

<section class="registration">

    <div class="row secBg">

        <div class="large-12 columns">

            <div class="login-register-content">

                <!-- <div class="row collapse borderBottom">
                    <div class="medium-6 large-centered medium-centered">
                        <div class="page-heading text-center" style="margin-top:20px;padding:0px !important">
                            <h3>{{tr('login')}}</h3>
                        </div>
                    </div>
                </div> -->

                <div class="row" data-equalizer="1hfmzc-equalizer" data-equalize-on="medium" id="test-eq" data-resize="xrev0j-eq" data-events="resize" style="margin-top: 50px;">
                    
                    <div class="large-4 large-offset-1 medium-6 columns ">
                        <div class="register-form">

                            <h5 class="text-center">{{tr('login')}}</h5>

                            <form data-abide="xdc2hs-abide" novalidate="" role="form" method="POST" action="{{ url('/login') }}">

                                {!! csrf_field() !!}

                                @if($errors->has('email') || $errors->has('password'))
                                    <div data-abide-error="" class="alert callout">
                                        <p>
                                            <i class="fa fa-exclamation-triangle"></i> 
                                            <strong> 
                                                @if($errors->has('email')) 
                                                    {{ $errors->first('email') }}
                                                @else 
                                                    {{$errors->first('password')}}
                                                @endif
                                            </strong>
                                        </p>
                                    </div>
                                @endif

                                <div class="input-group">

                                    <span class="input-group-label"><i class="fa fa-user"></i></span>

                                    <input class="input-group-field" type="text" name="email" placeholder="Enter your email" required="">

                                    @if($errors->has('email'))
                                        <span class="form-error"><strong>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                    
                                </div>

                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                    
                                    <input type="password" id="password" name="password" placeholder="Enter your password" required="">

                                    <span class="form-error">
                                        @if ($errors->has('password'))
                                            <strong>{{ $errors->first('password') }}</strong>
                                        @endif
                                    </span>

                                </div>

                                <!-- <div class="checkbox">
                                    <input id="remember" type="checkbox" name="check" value="remember">
                                    <label class="customLabel" for="remember">{{tr('remember')}}</label>
                                </div> -->

                                <button class="button expanded" type="submit" name="submit">{{tr('login')}}</button>
                                <input type="hidden" name="timezone" value="" id="userTimezone">
                                <p class="loginclick">
                                    <a href="{{ url('/password/reset') }}">{{tr('forgot_password')}}</a>
                                    {{tr('new_here')}} 
                                    <a href="{{route('user.register.form')}}">{{tr('new_account')}}</a>
                                </p>
                            </form>
                        </div>
                    </div>

                    <div class="large-2 medium-2 columns show-for-large">
                        <div class="middle-text text-center hide-for-small-only" data-equalizer-watch="" style="height: 314px;">
                            <p>
                                <i class="fa fa-arrow-left arrow-left"></i>
                                <span>OR</span>
                                <i class="fa fa-arrow-right arrow-right"></i>
                            </p>
                        </div>
                    </div>

                    <div class="large-4  medium-6 columns end">
                        <div class="social-login" data-equalizer-watch="" style="height: 314px;">
                            <h5 class="text-center">{{tr('login_via_social')}}</h5>

                            @if(config('services.facebook.client_id') && config('services.facebook.client_secret'))
                            
                                <div class="social-login-btn facebook">
                                    <form class="social-form form-horizontal" role="form" method="POST" action="{{ route('SocialLogin') }}">
                                        <input type="hidden" value="facebook" name="provider" id="provider">
                                        <a href="#">
                                            <button type="submit">
                                                <i class="fa fa-facebook"></i>{{tr('login_via_fb')}}
                                            </button>
                                        </a>
                                    </form>
                                </div>

                            @endif

                            @if(config('services.twitter.client_id') && config('services.twitter.client_secret'))
                                
                                <div class="social-login-btn twitter">
                                    <form class="social-form form-horizontal" role="form" method="POST" action="{{ route('SocialLogin') }}">
                                        <input type="hidden" value="twitter" name="provider" id="provider">
                                        <a href="#">
                                            <button type="submit">
                                                <i class="fa fa-twitter"></i>{{tr('login_via_twitter')}}
                                            </button>
                                        </a>
                                    </form>
                                </div>

                            @endif

                            @if(config('services.google.client_id') && config('services.google.client_secret'))

                                <div class="social-login-btn g-plus">

                                    <form class="social-form form-horizontal" role="form" method="POST" action="{{ route('SocialLogin') }}">
                                        <input type="hidden" value="google" name="provider" id="provider">
                                        <a href="#">
                                            <button type="submit">
                                                <i class="fa fa-google-plus"></i>{{tr('login_via_google')}}
                                            </button>
                                        </a>
                                    </form>
                                </div>

                            @endif

                            <!-- <div class="social-login-btn linkedin">
                                <a href="#"><i class="fa fa-linkedin"></i>login via linkedin</a>
                            </div> -->
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')

<script src="{{asset('assets/js/jstz.min.js')}}"></script>
<script>
    
    $(document).ready(function() {

        var dMin = new Date().getTimezoneOffset();
        var dtz = -(dMin/60);
        // alert(dtz);
        $("#userTimezone").val(jstz.determine().name());
    });

</script>

@endsection