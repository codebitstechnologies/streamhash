@extends('layouts.user.focused')

@section('content')

<section class="registration">
    <div class="row secBg">
        <div class="large-12 columns forgot-password-min">
            <div class="login-register-content">

                <div class="row collapse borderBottom">
                    <div class="medium-6 large-centered medium-centered">
                        <div class="page-heading text-center" style="margin-top:20px;padding:0px !important">
                            <h3>{{tr('forgot_password')}}</h3>
                        </div>
                    </div>
                </div>

                <div class="row" data-equalizer="fldb3f-equalizer" data-equalize-on="medium" id="test-eq" data-resize="mmu5g8-eq" data-events="resize">

                    <div class="large-4 medium-6 large-centered medium-centered columns">

                    <br><br><br>

                        <div class="register-form">

                        <h5 class="text-center">Enter your email to reset password.</h5>

                            <form method="post" data-abide="bhwxrp-abide" novalidate="" action="{{ url('/password/email') }}">
                            
                                {!! csrf_field() !!}

                                @if($errors->has('email'))
                                    <div data-abide-error="" class="alert callout">
                                        <p>
                                            <i class="fa fa-exclamation-triangle"></i> 
                                            <strong> 
                                                @if($errors->has('email')) 
                                                    {{ $errors->first('email') }}
                                                @endif
                                            </strong>
                                        </p>
                                    </div>
                                
                                @endif

                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                    <input type="email" name="email" placeholder="Enter your email" required="">
                                </div>

                                <button class="button expanded" type="submit" name="submit">{{tr('reset_now')}}</button>

                                <p class="loginclick">
                                    <a href="{{ route('user.login.form') }}">{{tr('login')}}</a>
                                    {{tr('new_here')}} 
                                    <a href="{{route('user.register.form')}}">{{tr('new_account')}}</a>
                                </p>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
