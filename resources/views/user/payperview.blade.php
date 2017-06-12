@extends('layouts.user')

@section('content')

<div class="y-content">
    <div class="row content-row">

        @include('layouts.user.nav')

        <div class="history-content page-inner col-sm-9 col-md-10">
            
            @include('notification.notify')

            <div class="new-history">
                <div class="content-head">
                    <div><h4>{{tr('pay_per_videos')}} ( ${{user_total_amount()}} )</h4></div>              
                </div><!--end of content-head-->

                @if(count($model) > 0)

                    <ul class="history-list">

                        @foreach($model as $i => $video)

                        <li class="sub-list row">
                            <div class="main-history">
                                 <div class="history-image">
                                    <a href="{{($video->adminVideo->is_approved == 1) ? route('user.single' , $video->video_id) : ''}}"><img src="{{$video->adminVideo->default_image}}"></a>                        
                                </div><!--history-image-->

                                <div class="history-title">
                                    <div class="history-head row">
                                        <div class="cross-title">
                                            <h5><a href="{{($video->adminVideo->is_approved == 1) ? route('user.single' , $video->video_id) : ''}}">{{$video->adminVideo->title}} (${{$video->amount}})</a></h5>
                                            <p class="duration">{{tr('duration')}}: {{$video->adminVideo->duration}}</p>
                                        </div> 
                                    </div> <!--end of history-head--> 

                                    <div class="description">
                                        <p>{{$video->adminVideo->description}}</p>
                                    </div><!--end of description--> 

                                    <span class="stars">
                                        <a href="#"><i @if($video->adminVideo->ratings > 1) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i @if($video->adminVideo->ratings > 2) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i @if($video->adminVideo->ratings > 3) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i @if($video->adminVideo->ratings > 4) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                        <a href="#"><i @if($video->adminVideo->ratings > 5) style="color:gold" @endif class="fa fa-star" aria-hidden="true"></i></a>
                                    </span>                                                       
                                </div><!--end of history-title--> 
                                
                            </div><!--end of main-history-->
                        </li>    

                        @endforeach
                       
                    </ul>

                @else
                    <p>{{tr('no_payper_found')}}</p>
                @endif

                @if(count($model) > 0)
                    <div class="row">
                        <div class="col-md-12">
                            <div align="center" id="paglink"><?php echo $model->links(); ?></div>
                        </div>
                    </div>
                @endif
                
            </div>
        
        </div>

    </div>
</div>

@endsection
