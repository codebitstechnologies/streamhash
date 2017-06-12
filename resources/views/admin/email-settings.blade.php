@extends('layouts.admin')

@section('title', tr('email_settings'))

@section('content-header', tr('email_settings'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-gears"></i> {{tr('email_settings')}}</li>
@endsection

@section('content')

@include('notification.notify')

    <div class="row">
        <div class="col-md-12">

            <div class="box box-primary">

                <div class="box-header label-primary">
                    <h3 class="box-title">{{tr('email_settings')}}</h3>
                </div>

                <form action="{{route('admin.email.settings.save')}}" method="POST" enctype="multipart/form-data" role="form">
                    
                    <div class="box-body">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="paypal_client_id">{{tr('MAIL_DRIVER')}}</label>
                                <input type="text" value="{{ $result['MAIL_DRIVER']}}" class="form-control" name="MAIL_DRIVER" id="MAIL_DRIVER" placeholder="Enter {{tr('MAIL_DRIVER')}}">
                            </div>

                            <div class="form-group">
                                <label for="MAIL_HOST">{{tr('MAIL_HOST')}}</label>
                                <input type="text" class="form-control" value="{{$result['MAIL_HOST']}}" name="MAIL_HOST" id="MAIL_HOST" placeholder="{{tr('MAIL_HOST')}}">
                            </div>

                            <div class="form-group">
                                <label for="MAIL_PORT">{{tr('MAIL_PORT')}}</label>
                                <input type="text" class="form-control" value="{{$result['MAIL_PORT']}}" name="MAIL_PORT" id="MAIL_PORT" placeholder="{{tr('MAIL_PORT')}}">
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="MAIL_USERNAME">{{tr('MAIL_USERNAME')}}</label>
                                <input type="text" class="form-control" value="{{$result['MAIL_USERNAME'] }}" name="MAIL_USERNAME" id="MAIL_USERNAME" placeholder="{{tr('MAIL_USERNAME')}}">
                            </div>

                            <div class="form-group">
                                <label for="MAIL_PASSWORD">{{tr('MAIL_PASSWORD')}}</label>
                                <input type="password" class="form-control" name="MAIL_PASSWORD" id="MAIL_PASSWORD" placeholder="{{tr('MAIL_PASSWORD')}}">
                            </div>

                            <div class="form-group">
                                <label for="MAIL_PORT">{{tr('MAIL_ENCRYPTION')}}</label>
                                <input type="text" class="form-control" value="{{$result['MAIL_ENCRYPTION'] }}" name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION" placeholder="{{tr('MAIL_ENCRYPTION')}}">
                            </div>

                        </div>

                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right">{{tr('submit')}}</button>
                  </div>
                </form>

            </div>
        </div>

    </div>


@endsection