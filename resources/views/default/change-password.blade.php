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
                        <span class="show-for-sr">Current: </span> {{tr('change_password')}}
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
                        <i class="fa fa-magic"></i>
                        <h4>{{tr('change_password')}}</h4>
                    </div><!--heading end-->

                    <div class="row">
                        <div class="large-12 columns">
                            <div class="setting-form">

                                <form method="post" action="{{ route('user.profile.password') }}">

                                    <div class="setting-form-inner">
                                        <div class="row">

                                             @include('layouts.user.notification')

                                            <div class="medium-12 columns">
                                                <label>{{tr('old_password')}}:
                                                    <input type="password" name="old_password" placeholder="enter your {{tr('old_password')}}.." required>
                                                </label>
                                            </div>
                                            
                                            <div class="medium-12 columns">
                                                <label>{{tr('new_password')}}:
                                                    <input type="password" name="password" placeholder="enter your {{tr('new_password')}}.." required>
                                                </label>
                                            </div>
                                            <div class="medium-12 columns">
                                                <label>{{tr('confirm_password')}}:
                                                    <input type="password" name="password_confirmation" placeholder="enter your {{tr('confirm_password')}}.." required>
                                                </label>
                                            </div>
                                            <div class="medium-12 columns">
                                                <button class="button expanded" type="submit" name="setting">{{tr('submit')}}</button>
                                            </div>
                                        </div>

                                    </div>

                                    <!--setting-form-inner end-->

                                </form>
                            </div>
                            <!--settin-form end-->
                        </div><!-- large-12 columns end-->
                    </div><!--end row-->

                </div><!-- large-12 columns end-->
            </div><!--secBg end-->
        </section><!-- End profile settings -->
   
    </div>

    <!-- end left side content area -->
</div><!-- row end-->

@endsection