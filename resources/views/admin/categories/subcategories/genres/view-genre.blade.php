@extends('layouts.admin')

@section('title', tr('view_video'))

@section('content-header', tr('view_video'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('admin.videos')}}"><i class="fa fa-video-camera"></i> {{tr('videos')}}</a></li>
    <li class="active">{{tr('video')}}</li>
@endsection 

@section('content')

    @include('notification.notify')

    <div class="row">

        <div class="col-lg-7">

            <div class="box box-widget">

                <div class="box-header with-border">
                    <div class="user-block">
                        <span style="margin-left:0px" class="username"><a href="#">{{$video->title}}</a></span>
                        <span style="margin-left:0px" class="description">Created Time - {{$video->video_date}}</span>
                    </div>
                    
                    
                    <div class="box-tools">

                        <!-- <button title="Mark as read" data-toggle="tooltip" class="btn btn-box-tool" type="button">
                            <i class="fa fa-circle-o"></i>
                        </button> -->

                        <button data-widget="collapse" class="btn btn-box-tool" type="button">
                            <i class="fa fa-minus"></i>
                        </button>

                        <!-- <button data-widget="remove" class="btn btn-box-tool" type="button">
                            <i class="fa fa-times"></i>
                        </button> -->
                    </div>

                </div>

                <div class="box-body">

                    <video class="img-responsive pad" id="myVideo" width="800" height="350" controls style="background-color:black !important;margin-bottom:15px">
                      <source src="{{$video->video}}" type="video/mp4">
                    </video>

                    <h4 style="font-weight:800;color:#3c8dbc">{{tr('description')}}</h4>


                    <p style="margin-top:10px;border-bottom: 1px solid #f4f4f4;padding-bottom: 10px;">{{$video->description}}</p>

                    <h4 style="font-weight:800;color:#3c8dbc">{{tr('ratings')}}</h4>

                    <span class="starRating-view">
                        <input id="rating5" type="radio" name="ratings" value="5" @if($video->ratings == 5) checked @endif>
                        <label for="rating5">5</label>

                        <input id="rating4" type="radio" name="ratings" value="4" @if($video->ratings == 4) checked @endif>
                        <label for="rating4">4</label>

                        <input id="rating3" type="radio" name="ratings" value="3" @if($video->ratings == 3) checked @endif>
                        <label for="rating3">3</label>

                        <input id="rating2" type="radio" name="ratings" value="2" @if($video->ratings == 2) checked @endif>
                        <label for="rating2">2</label>

                        <input id="rating1" type="radio" name="ratings" value="1" @if($video->ratings == 1) checked @endif>
                        <label for="rating1">1</label>
                    </span>
                    
                    <h4 style="font-weight:800;color:#3c8dbc">{{tr('reviews')}}</h4>

                    <p style="">{{$video->reviews}}</p>
                
                </div>

            </div>

        </div>

        <div class="col-lg-5">

            <div class="box box-widget">

                <div class="box-header with-border">
                    <div class="user-block">
                        <span style="margin-left:0px" class="username"><a href="#">{{tr('trailer_video')}}</a></span>
                    </div>

                    <div class="box-tools">

                        <!-- <button title="Mark as read" data-toggle="tooltip" class="btn btn-box-tool" type="button">
                            <i class="fa fa-circle-o"></i>
                        </button> -->

                        <button data-widget="collapse" class="btn btn-box-tool" type="button">
                            <i class="fa fa-minus"></i>
                        </button>

                        <!-- <button data-widget="remove" class="btn btn-box-tool" type="button">
                            <i class="fa fa-times"></i>
                        </button> -->
                    </div>

                </div>

                <div class="box-body">

                    <video class="img-responsive pad" id="myVideo" width="800" height="auto" controls style="background-color:black !important;margin-bottom:15px">
                      <source src="{{$video->trailer_video}}" type="video/mp4">
                    </video>

                </div>

            </div>


            @if(count($video_images) > 0)
                
                @foreach($video_images as $i => $image)
                    
                    <div class="box box-widget">

                        <div class="box-header with-border">
                            <div class="user-block">
                                @if($image->is_default)
                                    <span style="margin-left:0px" class="username"><a href="#">{{tr('default_image')}}</a></span>
                                @else
                                    <span style="margin-left:0px" class="username"><a href="#">Image {{$image->position}}</a></span>
                                @endif
                            </div>

                            <div class="box-tools">

                                <!-- <button title="Mark as read" data-toggle="tooltip" class="btn btn-box-tool" type="button">
                                    <i class="fa fa-circle-o"></i>
                                </button> -->

                                <button data-widget="collapse" class="btn btn-box-tool" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>

                                <!-- <button data-widget="remove" class="btn btn-box-tool" type="button">
                                    <i class="fa fa-times"></i>
                                </button> -->
                            </div>

                        </div>

                        <div class="box-body">
                            <img alt="Photo" src="{{$image->image}}" style="width:100%;height:150px;">
                        </div>
                    </div>

                @endforeach

            @endif

        </div>


    </div>

@endsection

