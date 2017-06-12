@extends('layouts.user')

@section('content')

 <!--breadcrumbs-->
 
<section id="breadcrumb">
    <div class="row">
        <div class="large-12 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><i class="fa fa-home"></i><a href="{{route('user.dashboard')}}">{{tr('home')}}</a></li>
                    <li><a href="{{route('user.profile')}}">{{tr('profile')}}</a></li>
                    <li>
                        <span class="show-for-sr">Current: </span> {{tr('update_profile')}}
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

<!--end breadcrumbs-->

<div class="row">
   
   <!-- left sidebar -->

    @include('layouts.user.user-sidebar')

    <!-- end sidebar -->

    <!-- right side content area -->

    <div class="large-8 columns profile-inner mar-top-space">

        @include('notification.notify')
        
        <!-- profile settings -->
        <section class="profile-settings">
            <div class="row secBg">
                <div class="large-12 columns">

                    <div class="heading">
                        <i class="fa fa-pencil-square-o"></i>
                        <h4>{{tr('update_profile')}}</h4>
                    </div>

                    <!--heading end-->

                    <div class="row">

                        <div class="large-12 columns">

                            <div class="setting-form">

                                @include('layouts.user.notification')

                                <form action="{{ route('user.profile.save') }}" method="POST" enctype="multipart/form-data">

                                    <div class="setting-form-inner">

                                        <div class="row">

                                            <div class="medium-6 columns">
                                                <label>{{tr('username')}}:
                                                    <input type="text"  name="name" required  value="{{Auth::user()->name}}" placeholder="enter your {{tr('username')}}..">
                                                </label>
                                            </div>

                                            @if(Auth::user()->login_by == 'maunal')
                                                <div class="medium-6 columns">
                                                    <label>{{tr('email')}}:
                                                        <input type="email" name="email" required value="{{Auth::user()->email}}" placeholder="enter your email address..">
                                                    </label>
                                                </div>

                                            @endif

                                            <div class="medium-6 columns">
                                                <label>{{tr('address')}}:
                                                    <input type="text" name="address" value="{{Auth::user()->address}}" placeholder="enter your Address..">
                                                </label>
                                            </div>

                                            <div class="medium-6 columns end">
                                                <label>{{tr('mobile')}}:
                                                    <input type="tel" name="mobile" value="{{Auth::user()->mobile}}" placeholder="enter your Mobile No..">
                                                </label>
                                            </div>

                                            <div class="medium-12 columns">
                                                <label>{{tr('description')}}:
                                                    <textarea name="description">{{Auth::user()->description}}</textarea>
                                                </label>
                                            </div>

                                            <div class="medium-12 columns">
                                            @if(Auth::user()->picture)
                                                <img class="up-img" src="{{Auth::user()->picture}}">
                                            @else
                                                <img class="up-img" src="{{asset('placeholder.png')}}">
                                            @endif
                                            </div>

                                            <div class="medium-12 columns">
                                                <label>{{tr('picture')}}:
                                                    <input type="file" name="picture" id="picture" accept="image/png, image/jpeg">
                                                     <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                                                </label>
                                            </div>
                                            <div class="medium-12 columns">
                                                <button class="button expanded" type="submit" name="setting">{{tr('update_now')}}</button>
                                            </div>
                                        </div>

                                        <!--setting-form-inner row end-->
                                    </div>

                                    <!--setting-form-inner end-->


                                </form>
                            </div>
                        </div>
                    </div>

                </div><!-- large-12 columns end-->
            </div><!--secBg end-->
        </section><!-- End profile settings -->
    </div>

    <!-- end left side content area -->
</div><!-- row end-->

@endsection