@extends('layouts.user')

@section('content')

 <!--breadcrumbs-->

<section id="breadcrumb">
    <div class="row">
        <div class="large-12 columns">
            <nav aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><i class="fa fa-home"></i><a href="{{route('user.dashboard')}}">{{tr('home')}}</a></li>
                    <li><span class="show-for-sr">Current: </span>{{tr('profile')}}</a></li>
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
    <div class="large-8 columns mar-top-space">
        <!-- single post description -->

        @include('notification.notify')

        <section class="singlePostDescription">
            <div class="row secBg">
                <div class="large-12 columns">
                    <div class="heading">
                        <i class="fa fa-user" style="font-size:20px;"></i>
                        <h4>{{tr('description')}}</h4>

                        @if(envfile('PAYPAL_ID') && envfile('PAYPAL_SECRET'))

                            <a href="{{route('paypal' , Auth::user()->id)}}" class="btn btn-warning" style="float:right"><i class="fa fa-envelope" style="color:white"></i>Pay now</a>  
                        @endif
                    </div>
                    <div class="description">

                        <p>{{Auth::user()->description}}</p>

                        @if(Auth::user()->login_by == 'maunal')
                            <div class="email profile-margin">
                                <button><i class="fa fa-envelope"></i>{{tr('email')}}</button>
                                <span class="inner-btn">{{Auth::user()->email}}</span>
                            </div>
                        @endif
                        
                        <div class="email profile-margin">
                            <button><i class="fa fa-location-arrow"></i>{{tr('address')}}</button>
                            @if(Auth::user()->address) <span class="inner-btn">{{Auth::user()->address}}</span> @endif
                        </div>

                        <div class="phone profile-margin">
                            <button><i class="fa fa-phone"></i>{{tr('mobile')}}</button>
                            
                            @if(Auth::user()->mobile) 
                                <span class="inner-btn">
                                    {{Auth::user()->mobile}}
                                </span>
                            @endif
                            
                        </div>


                        <div class="email profile-margin">
                            <button><i class="fa fa-user"></i>{{tr('user')}}</button>
                            @if(Auth::user()->user_type) 
                                <span class="inner-btn" style="background-color:#2f922f;color:white">
                                    <strong>Premium</strong>
                                </span> 
                            @else 
                                <span class="inner-btn" style="background-color:#e40d0d;color:white">
                                    <strong>Normal</strong>
                                </span> 
                            @endif
                        </div>

                        @if(Auth::user()->user_type) 
                            <div class="email profile-margin">
                                <!-- <button><i class="fa fa-user"></i>{{tr('remaning_days')}}</button> -->
                                <span class="btn btn-info">
                                    <strong>{{tr('no_of_days_expiry')}} {{get_expiry_days(Auth::user()->id)}} days</strong>
                                </span> 
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </section>

        <!-- End single post description -->
    </div><!-- end left side content area -->

</div>

<!--end left-sidebar row-->

@endsection