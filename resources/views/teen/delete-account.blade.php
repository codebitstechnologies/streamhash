@extends('layouts.user.focused')

@section('content')

    @include('notification.notify')

    <div class="login-box">
        <h4>{{tr('delete_account_heading')}}</h4>

        <p style="color: gray">
            <strong>Note:</strong> {{tr('delete_account_content')}}
        </p>
        
        <form role="form" method="POST" action="{{ route('user.delete.account.process') }}">

            <div class="form-group">
                <label for="pwd">{{tr('password')}}:</label>
                <input type="password" name="password" required placeholder="{{tr('password')}}" class="form-control" id="pwd">
                <span class="form-error">
                    @if ($errors->has('password'))
                        <strong>{{ $errors->first('password') }}</strong>
                    @endif
                </span>
            </div>     

          <button type="submit" class="btn btn-default" onclick="getPassword();">{{tr('delete_account')}}</button>

        </form> 
    </div>
<script>
    function getPassword() {
        var password = $('#pwd').val(); 
        if(password != '') {
            return confirm('Are you sure?.')  
        } else {
            return false; 
        }  
    }
</script>
@endsection
