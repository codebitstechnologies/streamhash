@extends('layouts.admin')

@section('title', tr('banner_videos'))

@section('content-header', tr('banner_videos'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-university"></i> {{tr('banner_videos')}}</li>
@endsection

@section('content')

    @include('notification.notify')


	<div class="row">
        <div class="col-xs-12">

        <p class="text-justify" style="color:brown;"><b>Please Note : </b> You can able to add banner videos upto 6 only. If want to add new video, other than this 6 videos means change anyone of the video as "Normal video" and upload a banner video.</p>
          <div class="box box-primary">

          	<div class="box-header label-primary">
                <b style="font-size:18px;">{{tr('banner_videos')}}</b>
                <a href="{{route('admin.add.banner.video')}}" class="btn btn-default pull-right">{{tr('add_banner_videos')}}</a>
            </div>

            <div class="box-body">

            	@if(count($videos) > 0)

	              	<table id="example1" class="table table-bordered table-striped">

						<thead>
						    <tr>
						      <th>{{tr('id')}}</th>
						      <th>{{tr('category')}}</th>
						      <th>{{tr('sub_category')}}</th>
						      <th>{{tr('genre')}}</th>
						      <th>{{tr('title')}}</th>
						      <th>{{tr('description')}}</th>
						      @if(Setting::get('theme') == 'default')
						      	<th>{{tr('slider_video')}}</th>
						      @endif
						      <th>{{tr('status')}}</th>
						      <th>{{tr('change')}}</th>
						      <th>{{tr('action')}}</th>
						    </tr>
						</thead>

						<tbody>
							@foreach($videos as $i => $video)

							    <tr>
							      	<td>{{$i+1}}</td>
							      	<td>{{$video->category_name}}</td>
							      	<td>{{$video->sub_category_name}}</td>
							      	<td>@if($video->genre_name) {{$video->genre_name}} @else - @endif</td>
							      	<td>{{substr($video->title , 0,25)}}...</td>
							      	<td>{{substr($video->description , 0, 25)}}...</td>
							      	@if(Setting::get('theme') == 'default')
							      	<td>
							      		@if($video->is_home_slider == 0 && $video->is_approved && $video->status)
							      			<a href="{{route('admin.slider.video' , $video->video_id)}}"><span class="label label-danger">{{tr('set_slider')}}</span></a>
							      		@elseif($video->is_home_slider)
							      			<span class="label label-success">{{tr('slider')}}</span>
							      		@else
							      			-
							      		@endif
							      	</td>

							      	@endif
							      	<td>
							      		@if($video->is_approved)
							      			<span class="label label-success">{{tr('approved')}}</span>
							       		@else
							       			<span class="label label-warning">{{tr('pending')}}</span>
							       		@endif
							      	</td>
							      	<td>
							      		@if(Setting::get('admin_delete_control') == 1) 
							      			<button class="btn btn-primary btn-xs" disabled>Remove Banner</button>
							      		@else
							      			<a class="btn btn-primary btn-xs" href="{{route('admin.change.video' ,$video->video_id )}}">Remove Banner</a>
							      		@endif
							      	</td>
								    <td>
            							<ul class="admin-action btn btn-default">
            								<li class="dropup">
								                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
								                  {{tr('action')}} <span class="caret"></span>
								                </a>
								                <ul class="dropdown-menu">

								                  	<li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))
                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('edit')}}</a>
                                                        @else
                                                            <a role="menuitem" tabindex="-1" href="{{route('admin.edit.video' , array('id' => $video->video_id))}}">{{tr('edit')}}</a>
                                                        @endif
                                                    </li>

								                  	<li role="presentation"><a role="menuitem" tabindex="-1" target="_blank" href="{{route('admin.view.video' , array('id' => $video->video_id))}}">{{tr('view')}}</a></li>
								                  	
								                  	<li class="divider" role="presentation"></li>

								                  	@if($video->is_approved)
								                		<li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('admin.video.decline',$video->video_id)}}">{{tr('decline')}}</a></li>
								                	@else
								                  		<li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('admin.video.approve',$video->video_id)}}">{{tr('approve')}}</a></li>
								                  	@endif

								                  	<li class="divider" role="presentation"></li>

								                  	<li role="presentation">
									                  	@if(Setting::get('admin_delete_control'))
									                  	 	<a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>
									                  	 @else
									                  		<a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?')" href="{{route('admin.delete.video' , array('id' => $video->video_id))}}">{{tr('delete')}}</a>
									                  	@endif
								                  	</li>
								                </ul>
              								</li>
            							</ul>
								    </td>
							    </tr>
							@endforeach
						</tbody>
					</table>
				@else
					<h3 class="no-result">{{tr('no_video_found')}}</h3>
				@endif
            </div>
          </div>
        </div>
    </div>

@endsection
