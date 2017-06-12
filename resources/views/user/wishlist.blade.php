@extends('layouts.user')

@section('content')

<div class="y-content">
    <div class="row content-row">

        @include('layouts.user.nav')

        <div class="history-content page-inner col-sm-9 col-md-10">
            
            @include('notification.notify')

            <div class="new-history">
                <div class="content-head">
                    <div><h4>{{tr('wishlist')}}</h4></div>              
                </div><!--end of content-head-->

                @if(count($videos) > 0)

                    <ul class="history-list">

                        @foreach($videos as $i => $video)

                        <li class="sub-list row">
                            <div class="main-history">
                                 <div class="history-image">
                                    <a href="{{route('user.single' , $video->admin_video_id)}}"><img src="{{$video->default_image}}"></a>                        
                                </div><!--history-image-->

                                <div class="history-title">
                                    <div class="history-head row">
                                        <div class="cross-title">
                                            <h5><a href="{{route('user.single' , $video->admin_video_id)}}">{{$video->title}}</a></h5>
                                            <p class="duration">{{tr('duration')}}: {{$video->duration}}</p>
                                        </div> 
                                        <div class="cross-mark">
                                            <a onclick="return confirm('Are you sure?');" href="{{route('user.delete.wishlist' , array('wishlist_id' => $video->wishlist_id))}}"><i class="fa fa-times" aria-hidden="true"></i></a>
                                        </div><!--end of cross-mark-->                       
                                    </div> <!--end of history-head--> 

                                    <div class="description">
                                        <p>{{$video->description}}</p>
                                    </div><!--end of description--> 

                                    <span class="stars">
                                        <a href="#"><i @if($video->ratings > 1) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i @if($video->ratings > 2) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i @if($video->ratings > 3) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i @if($video->ratings > 4) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i @if($video->ratings > 5) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                    </span>                                                       
                                </div><!--end of history-title--> 
                                
                            </div><!--end of main-history-->
                        </li>    

                        @endforeach
                       
                    </ul>

                @else
                    <p>{{tr('no_wishlist_found')}}</p>
                @endif

                @if(count($videos) > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div align="center" id="paglink"><?php echo $videos->links(); ?></div>
                        </div>
                    </div>
                @endif
                
            </div>
        
        </div>

    </div>
</div>

@endsection