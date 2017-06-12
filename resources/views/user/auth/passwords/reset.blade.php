@extends('layouts.user.focused')

@section('content')

    <div class="form-background forgot-password-reset">
        <div class="common-form login-common forgot">

            <div class="social-form">
                <div class="signup-head">
                    <h3>{{tr('reset_password')}}</h3>
                </div><!--end  of signup-head-->        
            </div><!--end of socila-form-->

            <div class="sign-up login-page">
                <form class="signup-form login-form" role="form" method="POST" action="{{ url('/password/reset') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="exampleInputEmail1">{{tr('email')}}</label>
                        <input type="email" id="email" type="email" placeholder="Enter your email" required="" name="email" value="{{ $email or old('email') }}" aria-describedby="emailHelp" class="form-control"  >
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                        <label for="exampleInputEmail1">{{tr('password')}}</label>

                        <input id="password" type="password" placeholder="Enter your password" required="" name="password" value="{{ $password or old('password') }}" aria-describedby="emailHelp" class="form-control"  >

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                        
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                        <label for="exampleInputEmail1">{{tr('password_confirmation')}}</label>

                        <input  id="password_confirmation" type="password" placeholder="Enter your confirm password " required="" name="password_confirmation" value="{{ $password_confirmation or old('password_confirmation') }}" aria-describedby="emailHelp" class="form-control" >

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="change-pwd">
                        <button type="submit" class="btn btn-primary signup-submit">{{tr('reset_now')}}</button>
                    </div>          
                    <!-- <p>Already Have an Account? <a href="{{route('user.login.form')}}">{{tr('login')}}</a></p>   -->
                </form>
            </div><!--end of sign-up-->
        </div><!--end of common-form-->     
    </div><!--end of form-background-->

@endsection
