@extends('layouts.user')

@section('content')

    <div class="form-background">
        <div class="common-form login-common">

            @include('notification.notify')

            <div class="social-form">
                <div class="signup-head">
                    <h3>{{tr('change_password')}}</h3>
                </div><!--end  of signup-head-->        
            </div><!--end of socila-form-->

            <div class="sign-up login-page">            
                <form class="signup-form login-form" method="post" action="{{ route('user.profile.password') }}">

                    <div class="form-group">
                        <label for="old_password">{{tr('old_password')}}</label>
                        <input type="password" required name="old_password" class="form-control" id="old_password" placeholder="{{tr('old_password')}}">
                    </div>

                    <div class="form-group">
                        <label for="new_password">{{tr('new_password')}}</label>
                        <input type="password" required name="password" class="form-control" id="new_password" placeholder="{{tr('new_password')}}">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">{{tr('confirm_password')}}</label>
                        <input type="password" required name="password_confirmation" class="form-control" id="confirm_password" placeholder="{{tr('confirm_password')}}">
                    </div>

                    <div class="change-pwd">
                        <button type="submit" class="btn btn-primary signup-submit">{{tr('submit')}}</button>
                    </div>              
                </form>
            </div><!--end of sign-up-->

        </div><!--end of common-form-->     
    </div><!--end of form-background-->

@endsection
