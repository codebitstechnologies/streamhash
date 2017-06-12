@extends('layouts.user.focused')

@section('content')

<div class="login-box">
    <h4>{{tr('register')}}</h4>
    
    @if(config('services.facebook.client_id') && config('services.facebook.client_secret'))
        <div class="social-login-btn facebook">
            <form class="social-form form-horizontal" role="form" method="POST" action="{{ route('SocialLogin') }}">
                <input type="hidden" value="facebook" name="provider" id="provider">
                    <button type="submit" class="fb-btn">
                        <i class="fa fa-facebook"></i>{{tr('signup_via_fb')}}
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
    <form role="form" method="POST" action="{{ url('/register') }}">
      <div class="form-group">
        {!! csrf_field() !!}
        @if($errors->has('email') || $errors->has('name') || $errors->has('password_confirmation') ||$errors->has('password'))
            <div data-abide-error="" class="alert callout">
                <p>
                    <i class="fa fa-exclamation-triangle"></i> 
                    <strong> 
                        @if($errors->has('email')) 
                            {{ $errors->first('email') }}
                        @endif

                        @if($errors->has('name')) 
                            {{ $errors->first('name') }}
                        @endif

                        @if($errors->has('password')) 
                            {{$errors->first('password') }}
                        @endif

                        @if($errors->has('password_confirmation'))
                            {{ $errors->first('password_confirmation') }}
                        @endif

                    </strong>
                </p>
            </div>
        @endif
        <label for="name">{{tr('name')}}</label>
        <input type="text" name="name" required class="form-control" placeholder="{{tr('name')}}" id="name">
      </div>
      <div class="form-group">
        <label for="email">{{tr('email')}}</label>
        <input type="email" name="email" required class="form-control" placeholder="{{tr('email')}}" id="email">
      </div>
      <div class="form-group">
        <label for="pwd">{{tr('password')}}</label>
        <input type="password" name="password" required class="form-control" placeholder="{{tr('password')}}" id="pwd">
      </div>  
      <div class="form-group">
        <label for="s_pwd">{{tr('confirm_password')}}</label>
        <input type="password" name="password_confirmation" placeholder="{{tr('confirm_password')}}" required class="form-control" id="c_pwd">
      </div>                  
      <input type="hidden" name="timezone" value="" id="userTimezone">
      <button type="submit" class="btn btn-default">{{tr('signup')}}</button>
    </form>                
    <p class="help"><a href="{{ route('user.login.form') }}">{{tr('login')}}</a></p>         
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