@extends('layouts.user')

@section('content')

    <div class="col-md-9 col-sm-8">

        @include('notification.notify')
        
        <div class="row">
            
            <div class="profile">
                
                @if(Auth::user()->picture == "")
                    <img src="{{asset('placeholder.png')}}">
                @else
                    <img src="{{Auth::user()->picture}}">
                @endif
                
                <form action="{{ route('user.profile.save') }}" method="POST" enctype="multipart/form-data">
                
                    <div class="form-group">
                        <label for="pro-image">{{tr('upload')}} {{tr('image')}}:</label>
                        <input type="file" name="picture" accept="image/png, image/jpeg" id="pro-image">
                         <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                    </div>

                    <div class="form-group">
                        <label for="name">{{tr('name')}}</label>
                        <input type="text" name="name" required value="{{Auth::user()->name}}" class="form-control" placeholder="{{tr('name')}}" id="name">
                    </div>

                    @if(Auth::user()->login_by == 'manual')
                        <div class="form-group">
                            <label for="email">{{tr('email')}}</label>
                            <input type="email" name="email" required value="{{Auth::user()->email}}" class="form-control" placeholder="{{tr('email')}}" id="email">
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="phone">{{tr('mobile')}}</label>
                        <input type="text" name="mobile" required value="{{Auth::user()->mobile}}" class="form-control" placeholder="{{tr('mobile')}}" id="phone">
                    </div>

                    <div class="form-group">
                        <label for="address">{{tr('description')}}</label>
                        <textarea name="description" class="form-control" id="address">{{Auth::user()->description}}</textarea>                      
                    </div> 

                    <div class="form-group">
                        <label for="address">{{tr('address')}}</label>
                        <textarea name="address" class="form-control" id="address" placeholder="{{tr('address')}}">{{Auth::user()->address}}</textarea>                      
                    </div>

                    <button type="submit" class="btn btn-default">{{tr('submit')}}</button>

                </form>   

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

                                <?php $video_images = get_video_image($video->admin_video_id);?>

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
    
    <div class="col-md-3 col-sm-4">
        <div class="row sidebar">
            <div class="video-full-box">

                <div class="box-title">
                  <h3>{{tr('trending')}}</h3>
                </div>

                @foreach($videoss = trending() as $videos)

                    <div class="video-box">
                        
                        <a href="{{route('user.single' , $videos->admin_video_id)}}">

                            <?php $video_imagess = get_video_image($videos->admin_video_id); ?>

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

@endsection