@extends('layouts.user.focused')

@section('content')

    <div class="form-background forgot-password-reset">
        <div class="common-form login-common forgot">

            <div class="social-form">
                <div class="signup-head">
                    <h3>{{tr('forgot_password')}}</h3>
                </div><!--end  of signup-head-->        
            </div><!--end of socila-form-->

            <div class="sign-up login-page">
                <form class="signup-form login-form" method="post" action="{{ url('/password/email') }}">
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
                    <div class="form-group">
                        <label for="exampleInputEmail1">{{tr('email')}}</label>
                        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Your email">
                    </div>

                    <div class="change-pwd">
                        <button type="submit" class="btn btn-primary signup-submit">{{tr('submit')}}</button>
                    </div>          
                    <p>Already Have an Account? <a href="{{route('user.login.form')}}">{{tr('login')}}</a></p>         
                </form>
            </div><!--end of sign-up-->
        </div><!--end of common-form-->     
    </div><!--end of form-background-->

@endsection
