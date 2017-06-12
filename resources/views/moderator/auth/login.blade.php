@extends('layouts.moderator.focused')

@section('title', 'Login')

@section('content')

    <div class="login-box-body" style="height:300px">

    @include('notification.notify')

        <form class="form-layout" role="form" method="POST" action="{{ url('/moderator/login') }}">
            {{ csrf_field() }}

            <div class="login-logo">
            </div>

            <p class="text-center mb30"></p>

            <div class="form-inputs">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="{{tr('email')}}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif

                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                    <input type="password" class="form-control input-lg" name="password" placeholder="{{tr('password')}}">

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif

                </div>


            </div>

            <div class="col-md-6 col-md-offset-3">
                <button class="btn btn-success btn-block mb15" type="submit">
                    <h5><span><i class="fa fa-btn fa-sign-in"></i> {{tr('login')}}</span></h5>
                </button>
            </div>

            <input type="hidden" name="timezone" value="" id="userTimezone">
            <!-- <div class="form-group">
                    <a style="margin-left:100px" class="btn btn-link" href="{{ url('/moderator/password/reset') }}">Reset Password</a>
            </div> -->

        </form>

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