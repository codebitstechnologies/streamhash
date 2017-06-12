@extends('layouts.admin')

@section('title', tr('moderators'))

@section('content-header', tr('moderators'))

@section('breadcrumb')
	<li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-users"></i> {{tr('moderators')}}</li>
@endsection

@section('content')

	@include('notification.notify')

	<div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
          	<div class="box-header label-primary">
                <b style="font-size:18px;">{{tr('moderators')}}</b>
                <a href="{{route('admin.add.moderator')}}" class="btn btn-default pull-right">{{tr('add_moderator')}}</a>
            </div>
            <div class="box-body">

            	@if(count($moderators) > 0)

	              	<table id="example1" class="table table-bordered table-striped">

						<thead>
						    <tr>
						      <th>{{tr('id')}}</th>
						      <th>{{tr('username')}}</th>
						      <th>{{tr('email')}}</th>
						      <th>{{tr('mobile')}}</th>
						      <th>{{tr('address')}}</th>
						      <th>{{tr('status')}}</th>
						      <th>{{tr('action')}}</th>
						    </tr>
						</thead>

						<tbody>
							@foreach($moderators as $i => $moderator)

							    <tr>
							      <td>{{$i+1}}</td>
							      <td>{{$moderator->name}}</td>
							      <td>{{$moderator->email}}</td>
							      <td>{{$moderator->mobile}}</td>
							      <td>{{$moderator->address}}</td>
							      <td>
							      		@if($moderator->is_activated)
							      			<span class="label label-success">{{tr('approved')}}</span>
							       		@else
							       			<span class="label label-warning">{{tr('pending')}}</span>
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
															<a role="menuitem" tabindex="-1" href="{{route('admin.edit.moderator',$moderator->id)}}">{{tr('edit')}}</a>
														@endif
													</li>

								                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('admin.moderator.view',$moderator->id)}}">{{tr('view')}}</a></li>
								                  	
								                  	<li role="presentation" class="divider"></li>
								                  	@if($moderator->is_activated)
								                		<li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('admin.moderator.decline',$moderator->id)}}">{{tr('decline')}}</a></li>
								                	@else
								                  		<li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('admin.moderator.approve',$moderator->id)}}">{{tr('approve')}}</a></li>
								                  	@endif
								                  	
								                  	<li role="presentation" class="divider"></li>
								                  	<li role="presentation">

								                  		@if(Setting::get('admin_delete_control'))

									                  	 	<a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>

									                  	 @else

								                  			<a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('admin.delete.moderator', $moderator->id)}}">{{tr('delete')}}</a>
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
					<h3 class="no-result">No results found</h3>
				@endif
            </div>
          </div>
        </div>
    </div>

@endsection
