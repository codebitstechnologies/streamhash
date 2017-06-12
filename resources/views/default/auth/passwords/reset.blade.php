@extends('layouts.user.focused')

@section('content')

<section class="registration">

    <div class="row secBg">

        <div class="large-12 columns forgot-password-min">

            <div class="login-register-content">

                <div class="row" data-equalizer="1hfmzc-equalizer" data-equalize-on="medium" id="test-eq" data-resize="xrev0j-eq" data-events="resize" style="margin-top: 50px;">
                    
                    <div class="large-4 large-offset-4 medium-6 columns ">
                        
                        <div class="register-form">

                            <h5 class="text-center">{{tr('reset_password')}}</h5>

                            <form data-abide="xdc2hs-abide" novalidate="" role="form" method="POST" action="{{ url('password/reset') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="token" value="{{ $token }}">


                                <div class="input-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                    <span class="input-group-label"><i class="fa fa-user"></i></span>

                                    <input class="input-group-field" id="email" type="email" placeholder="Enter your email" required="" name="email" value="{{ $email or old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                    <span class="input-group-label"><i class="fa fa-user"></i></span>

                                    <input class="input-group-field" id="password" type="password" name="password" placeholder="Enter Password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="input-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                    <span class="input-group-label"><i class="fa fa-user"></i></span>

                                    <input class="input-group-field" id="password_confirmation" type="password" name="password_confirmation" placeholder="Enter Password">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <button class="button expanded" type="submit" name="submit">Reset Password</button>

                            </form>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

</section>

@endsection
