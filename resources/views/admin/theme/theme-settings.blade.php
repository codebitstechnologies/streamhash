@extends('layouts.admin')

@section('title', tr('theme_settings'))

@section('content-header', tr('theme_settings'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-refresh"></i> {{tr('theme_settings')}}</li>
@endsection

@section('content')

@include('notification.notify')

    <div class="row">

        <div class="col-md-12">

        @foreach($settings as $s => $setting)

            <div class="nav-tabs-custom" >

                <div class="tab-content" @if($s== 0) style="background-color:#1e282c;padding:30px;padding-bottom:10px;box-shadow: 0px 0px 10px -2px #000;" @else style="padding:30px;padding-bottom:10px;box-shadow: 0px 0px 10px -2px #000;" @endif>

                    <div class="post">
                        
                        <div class="user-block">

                            <form action="{{(Setting::get('admin_theme_control') == 1) ? '' : route('admin.save.settings')}}" method="POST" enctype="multipart/form-data" role="form">

                                <span class="username" style="margin-left:0px !important">
                                    <a href="#" @if($s== 0) style="color:#fff" @endif>
                                        {{tr($setting)}}
                                    </a>
                                    @if($s== 0)
                                        <button type="submit" class="pull-right btn btn-warning full-opacity" disabled>{{tr('current_theme')}}</button>
                                    @else
                                        <input type="hidden" name="theme" value="{{$setting}}">
                                        @if(Setting::get('admin_theme_control') == 1)
                                            <button type="submit" class="pull-right btn btn-primary" disabled>{{tr('select_theme')}}</button>
                                        @else 
                                            <button type="submit" class="pull-right btn btn-primary">{{tr('select_theme')}}</button>
                                        @endif
                                    @endif
                                </span>

                            </form>

                            <span style="margin-left:0px !important" class="description"></span>
                        </div>
                              
                        <div class="row margin-bottom">

                            <div class="col-sm-6">
                                  <img class="img-responsive" src='{{asset("theme/$setting/home.png")}}' alt="Photo">
                            </div>

                            <div class="col-sm-6">

                                <div class="row">

                                    <div class="col-sm-6">
                                        <img class="img-responsive" src='{{asset("theme/$setting/single.png")}}' alt="Photo">
                                        <br>
                                        <img class="img-responsive" src='{{asset("theme/$setting/profile.png")}}' alt="Photo">
                                    </div>

                                    <!-- /.col -->
                                    <div class="col-sm-6">
                                        <img class="img-responsive" src='{{asset("theme/$setting/login.png")}}' alt="Photo">
                                        <br>
                                        <img class="img-responsive" src='{{asset("theme/$setting/wishlist.png")}}' alt="Photo">
                                    </div>

                                </div>

                            </div>
                                <!-- /.col -->
                        </div>
                    
                    </div>

                </div>
            </div>

        @endforeach
        </div>

    </div>

@endsection