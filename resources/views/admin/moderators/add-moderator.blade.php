@extends('layouts.admin')

@section('title', tr('add_moderator'))

@section('content-header', tr('add_moderator'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('admin.moderators')}}"><i class="fa fa-users"></i> {{tr('moderators')}}</a></li>
    <li class="active">{{tr('add_moderator')}}</li>
@endsection

@section('content')

@include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-primary">

                <div class="box-header label-primary">
                    <b style="font-size:18px;">{{tr('add_moderator')}}</b>
                    <a href="{{route('admin.moderators')}}" class="btn btn-default pull-right">{{tr('moderators')}}</a>
                </div>

                <form class="form-horizontal" action="{{route('admin.save.moderator')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <div class="form-group">
                            <label for="email" class="col-sm-1 control-label">{{tr('email')}}</label>
                            <div class="col-sm-10">
                                <input type="email" maxlength="255" required class="form-control" id="email" name="email" placeholder="{{tr('email')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username" class="col-sm-1 control-label">{{tr('username')}}</label>

                            <div class="col-sm-10">
                                <input type="text" required name="name" class="form-control" id="username" placeholder="{{tr('name')}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mobile" class="col-sm-1 control-label">{{tr('mobile')}}</label>

                            <div class="col-sm-10">
                                <input type="text" required name="mobile" class="form-control" id="mobile" placeholder="{{tr('mobile')}}" minlength="6" maxlength="13" pattern="[0-9]{6,}">
                                <br>
                                 <small style="color:brown">Note : The mobile must be between 6 and 13 digits.</small>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="timezone" value="" id="userTimezone">
                    
                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger">{{tr('cancel')}}</button>
                        <button type="submit" class="btn btn-success pull-right">{{tr('submit')}}</button>
                    </div>


                </form>
            
            </div>

        </div>

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