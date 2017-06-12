@extends('layouts.admin')

@section('title', 'Profile')

@section('content-header', 'Profile')

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-diamond"></i> {{tr('account')}}</li>
@endsection

@section('content')

@include('notification.notify')


    <div class="row">

        <div class="col-md-4">

            <div class="box box-primary">

                <div class="box-body box-profile">

                    <img class="profile-user-img img-responsive img-circle" src="@if(Auth::guard('admin')->user()->picture) {{Auth::guard('admin')->user()->picture}} @else {{asset('placeholder.png')}} @endif" alt="User profile picture">

                    <h3 class="profile-username text-center">{{Auth::guard('admin')->user()->name}}</h3>

                    <p class="text-muted text-center">{{tr('admin')}}</p>

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>{{tr('username')}}</b> <a class="pull-right">{{Auth::guard('admin')->user()->name}}</a>
                        </li>
                        <li class="list-group-item">
                            <b>{{tr('email')}}</b> <a class="pull-right">{{Auth::guard('admin')->user()->email}}</a>
                        </li>

                        <li class="list-group-item">
                            <b>{{tr('mobile')}}</b> <a class="pull-right">{{Auth::guard('admin')->user()->mobile}}</a>
                        </li>

                        <li class="list-group-item">
                            <b>{{tr('address')}}</b> <a class="pull-right">{{Auth::guard('admin')->user()->address}}</a>
                        </li>
                    </ul>
                
                </div>

            </div>

        </div>

         <div class="col-md-8">
            <div class="nav-tabs-custom">

                <ul class="nav nav-tabs">
                    <li class="active"><a href="#adminprofile" data-toggle="tab">{{tr('update_profile')}}</a></li>
                    <li><a href="#image" data-toggle="tab">{{tr('upload_image')}}</a></li>
                    <li><a href="#password" data-toggle="tab">{{tr('change_password')}}</a></li>
                </ul>
               
                <div class="tab-content">
                   
                    <div class="active tab-pane" id="adminprofile">

                        <form class="form-horizontal" action="{{(Setting::get('admin_delete_control') == 1) ? '' : route('admin.save.profile')}}" method="POST" enctype="multipart/form-data" role="form">

                            <input type="hidden" name="id" value="{{Auth::guard('admin')->user()->id}}">

                            <div class="form-group">
                                <label for="name" required class="col-sm-2 control-label">{{tr('username')}}</label>

                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="name"  name="name" value="{{Auth::guard('admin')->user()->name}}" placeholder="{{tr('username')}}" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">{{tr('email')}}</label>

                                <div class="col-sm-10">
                                  <input type="email" required value="{{Auth::guard('admin')->user()->email}}" name="email" class="form-control" id="email" placeholder="{{tr('email')}}" readonly>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="mobile" class="col-sm-2 control-label">{{tr('mobile')}}</label>

                                <div class="col-sm-10">
                                  <input type="text" required value="{{Auth::guard('admin')->user()->mobile}}" name="mobile" class="form-control" id="mobile" placeholder="{{tr('mobile')}}" pattern="[0-9]{6,}">
                                  <small style="color:brown">Note : The mobile must be between 6 and 13 digits.</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="col-sm-2 control-label">{{tr('address')}}</label>

                                <div class="col-sm-10">
                                  <input type="text" required value="{{Auth::guard('admin')->user()->address}}" name="address" class="form-control" id="address" placeholder="{{tr('address')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    @if(Setting::get('admin_delete_control') == 1)
                                        <button type="submit" class="btn btn-danger" disabled>{{tr('submit')}}</button>
                                    @else
                                        <button type="submit" class="btn btn-danger">{{tr('submit')}}</button>
                                    @endif
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="tab-pane" id="image">

                        <form class="form-horizontal" action="{{(Setting::get('admin_delete_control') == 1) ? '' : route('admin.save.profile')}}" method="POST" enctype="multipart/form-data" role="form">

                            <input type="hidden" name="id" value="{{Auth::guard('admin')->user()->id}}">

                            @if(Auth::guard('admin')->user()->picture)
                                <img style="height: 90px; margin-bottom: 15px; border-radius:2em;" src="{{Auth::guard('admin')->user()->picture}}">
                            @else
                                <img style="margin-left: 15px;margin-bottom: 10px" class="profile-user-img img-responsive img-circle"  src="{{asset('placeholder.png')}}">
                            @endif

                            <div class="form-group">
                                <label for="picture" class="col-sm-2 control-label">{{tr('picture')}}</label>

                                <div class="col-sm-10">
                                  <input type="file" required accept="image/png,image/jpeg" name="picture" id="picture">
                                  <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    @if(Setting::get('admin_delete_control') == 1) 
                                        <button type="submit" class="btn btn-danger" disabled>{{tr('submit')}}</button>
                                    @else 
                                        <button type="submit" class="btn btn-danger">{{tr('submit')}}</button>
                                    @endif
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="tab-pane" id="password">

                        <form class="form-horizontal" action="{{ (Setting::get('admin_delete_control') == 1) ? '' : route('admin.change.password')}}" method="POST" enctype="multipart/form-data" role="form">

                            <input type="hidden" name="id" value="{{Auth::guard('admin')->user()->id}}">

                            <div class="form-group">
                                <label for="old_password" class="col-sm-3 control-label">{{tr('old_password')}}</label>

                                <div class="col-sm-8">
                                  <input required type="password" class="form-control" name="old_password" id="old_password" placeholder="{{tr('old_password')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">{{tr('new_password')}}</label>

                                <div class="col-sm-8">
                                  <input required type="password" class="form-control" name="password" id="password" placeholder="{{tr('new_password')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="col-sm-3 control-label">{{tr('confirm_password')}}</label>

                                <div class="col-sm-8">
                                  <input required type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="{{tr('confirm_password')}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    @if(Setting::get('admin_delete_control') == 1)
                                        <button type="submit" class="btn btn-danger" disabled>{{tr('submit')}}</button>
                                    @else
                                        <button type="submit" class="btn btn-danger">{{tr('submit')}}</button>
                                    @endif
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

    </div>

@endsection