@extends('layouts.user')

@section('content')

@include('notification.notify')

    <div class="login-box">
        
        <h4>{{tr('change_password')}}</h4>     

        <form method="post" action="{{ route('user.profile.password') }}">

            <div class="form-group">
                <label for="newpwd">{{tr('old_password')}}:</label>
                <input type="password" required name="old_password" placeholder="{{tr('old_password')}}" class="form-control" id="newpwd">
            </div>

            <div class="form-group">
                <label for="newpwd">{{tr('new_password')}}:</label>
                <input type="password" required name="password" placeholder="{{tr('new_password')}}" class="form-control" id="newpwd">
            </div>

            <div class="form-group">
                <label for="cnfrmpwd">{{tr('confirm_password')}}:</label>
                <input type="password" required name="password_confirmation" placeholder="{{tr('confirm_password')}}" class="form-control" id="cnfrmpwd">
            </div>    

            <button type="submit" class="btn btn-default">{{tr('submit')}}</button>
        </form>  

        <p class="help"><a href="{{route('user.dashboard')}}">{{tr('home')}}</a></p>                
    </div>

@endsection