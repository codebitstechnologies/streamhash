@extends('layouts.user.focused')

@section('content')

<div class="login-box">
    <h4>{{tr('forgot_password')}}</h4>               
    
    <form method="post" novalidate="" action="{{ url('/password/email') }}">
        <div class="form-group">
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

            <label for="email">{{tr('email')}}</label>
            <input type="email" name="email" class="form-control" placeholder="{{tr('email')}}" id="email">
        </div>  

        <button type="submit" class="btn btn-default">{{tr('reset_now')}}</button>
                   
        <p class="help"><a href="{{route('user.register.form')}}">{{tr('new_account')}}</a></p>

        <p class="help"><a href="{{ route('user.login.form') }}">{{tr('login')}}</a></p>
    </form> 

</div>

@endsection