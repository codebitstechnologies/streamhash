@extends('layouts.user.focused')

@section('content')

    <div class="login-box">
        <h4>{{tr('login')}}</h4>

        @if(config('services.facebook.client_id') && config('services.facebook.client_secret'))

            <div class="social-login-btn facebook">
                <form class="social-form form-horizontal" role="form" method="POST" action="{{ route('SocialLogin') }}">
                    <input type="hidden" value="facebook" name="provider" id="provider">
                        <button type="submit" class="fb-btn">
                            <i class="fa fa-facebook"></i>{{tr('login_via_fb')}}
                        </button>
                </form>
            </div>

        @endif

        @if(config('services.twitter.client_id') && config('services.twitter.client_secret'))

            <form role="form" method="POST" action="{{ route('SocialLogin') }}">
                <input type="hidden" value="twitter" name="provider" id="provider">
                <!-- <a href="#" class="gp-btn"> -->
                    <button type="submit" class="twt-btn">
                        {{tr('login_via_twitter')}}
                    </button>
                <!-- </a> -->
            </form>
        
        @endif

        @if(config('services.google.client_id') && config('services.google.client_secret'))

            <div class="social-login-btn g-plus">
                <form class="social-form form-horizontal" role="form" method="POST" action="{{ route('SocialLogin') }}">
                    <input type="hidden" value="google" name="provider" id="provider">
                        <button type="submit" class="gp-btn">
                            <i class="fa fa-google-plus"></i>{{tr('login_via_google')}}
                        </button>
                </form>
            </div>

        @endif

        <p class="or text-center">OR</p>

        <form role="form" method="POST" action="{{ url('/login') }}">
            {!! csrf_field() !!}

            <div class="form-group">
                <label for="email">{{tr('email')}}:</label>
                <input type="email" name="email" required class="form-control" placeholder="{{tr('email')}}" id="email">

                @if($errors->has('email'))
                    <span class="form-error"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>

            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" name="password" required class="form-control" placeholder="{{tr('password')}}" id="pwd">
                <span class="form-error">
                    @if ($errors->has('password'))
                        <strong>{{ $errors->first('password') }}</strong>
                    @endif
                </span>
            </div> 

            <input type="hidden" name="timezone" value="" id="userTimezone">

            <button type="submit" class="btn btn-default">{{tr('login')}}</button>
        
        </form> 

        <p class="help"><a href="{{route('user.register.form')}}">{{tr('new_account')}}</a></p>
        <p class="help"><a href="{{ url('/password/reset') }}">{{tr('forgot_password')}}</a></p>
    </div>

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