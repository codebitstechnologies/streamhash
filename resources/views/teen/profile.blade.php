@extends('layouts.user')

@section('content')

    <div class="col-md-9 col-sm-8">
        <div class="row">
            <div class="profile">

                @if(Auth::user()->picture == "")
                    <img src="{{asset('placeholder.png')}}">
                @else
                    <img src="{{Auth::user()->picture}}">
                @endif

                <h5>{{Auth::user()->name}}</h5>
                
                @if(Auth::user()->login_by == 'manual')
                    <h6>{{Auth::user()->email}}</h6>
                @endif

                @if(Auth::user()->user_type) 
                    <h5 style="color:rgb(241, 19, 19)">The Pack will Expiry within <b>{{get_expiry_days(Auth::user()->id)}} days</b></h5>
                @endif

                <h6>{{Auth::user()->mobile}}</h6>
                <h6>{{Auth::user()->address}}</h6>
                <h6>{{Auth::user()->description}}</h6>


                @if(envfile('PAYPAL_ID') && envfile('PAYPAL_SECRET'))
                    <a class="payment-pro" href="{{route('paypal' , Auth::user()->id)}}">{{tr('payment')}}</a>
                @endif

                
                <a class="edit-pro" href="{{route('user.update.profile')}}">{{tr('edit')}} {{tr('profile')}}</a>
                
                <a class="change-pwd" href="{{route('user.change.password')}}">{{tr('change_password')}}</a>
            </div>
        </div>

        @if(count($videos = wishlist(Auth::user()->id)) > 0)
        
            <div class="row">
                <div class="video-full-box single">
                    <div class="box-title">
                        <h3>{{tr('wishlist')}}</h3>
                    </div>

                    @foreach($videos as $i => $video)

                    <div class="video-box">
                        <a href="{{route('user.single' , $video->admin_video_id)}}">
                            <?php 
                                $video_images = get_video_image($video->admin_video_id);
                            ?>
                            @if($video_images->count() == 0)
                                <img class="first" src="{{$video->default_image}}"><!-- main image -->
                                <img class="second" src="{{$video->default_image}}"><!-- main image -->
                                <img class="third" src="{{$video->default_image}}"><!-- main image -->
                            @else
                              @foreach($video_images as $video_image)

                                  @if($video_image->position == 2)
                                      <img class="first" src="{{$video_image->image}}"><!-- last -->
                                  @else
                                      <img class="third" src="{{$video_image->image}}"><!-- second image -->
                                  @endif
                                  <img class="second" src="{{$video->default_image}}"><!-- main image -->
                              @endforeach
                              @endif
                            <span class="time">{{$video->duration}}</span>
                            <h5 class="video-title">{{$video->title}}</h5>
                        </a>

                        <a onclick="return confirm('Are you sure?');" href="{{route('user.delete.wishlist' , array('wishlist_id' => $video->wishlist_id))}}" class="remove-btn">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a>
                    </div>

                    @endforeach
                   
                </div>
            
            </div>

        @endif
              
    </div>

    @if(count($videoss = trending()) > 0)
    
        <div class="col-md-3 col-sm-4">
            <div class="row sidebar">
                <div class="video-full-box">

                    <div class="box-title">
                      <h3>{{tr('trending')}}</h3>
                    </div>

                    @foreach($videoss as $videos)

                    <div class="video-box">
                        <a href="{{route('user.single' , $videos->admin_video_id)}}">
                            <?php 
                                $video_imagess = get_video_image($videos->admin_video_id); 
                            ?>
                            @if($video_imagess->count() == 0)
                                <img class="first" src="{{$videos->default_image}}"><!-- main image -->
                                <img class="second" src="{{$videos->default_image}}"><!-- main image -->
                                <img class="third" src="{{$videos->default_image}}"><!-- main image -->
                            @else
                              @foreach($video_imagess as $video_image)

                                  @if($video_image->position == 2)
                                      <img class="first" src="{{$video_image->image}}"><!-- last -->
                                  @else
                                      <img class="third" src="{{$video_image->image}}"><!-- second image -->
                                  @endif
                                  <img class="second" src="{{$videos->default_image}}"><!-- main image -->

                              @endforeach
                            @endif
                            <span class="time">{{$videos->duration}}</span>
                            <h5 class="video-title">{{$videos->title}}</h5>
                        </a>
                    </div>

                    @endforeach

                </div>
            </div>
        
        </div>

    @endif

@endsection