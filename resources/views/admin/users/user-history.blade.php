@extends('layouts.admin')

@section('title', tr('view_history'))

@section('content-header',tr('view_history'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('admin.users')}}"><i class="fa fa-user"></i> {{tr('users')}}</a></li>
    <li class="active"> {{tr('view_history')}}</li>
@endsection

@section('content')

@include('notification.notify')

	<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">

            	@if(count($data) > 0)

	              	<table id="example1" class="table table-bordered table-striped">

						<thead>
						    <tr>
						      <th>{{tr('id')}}</th>
						      <th>{{tr('username')}}</th>
						      <th>{{tr('video')}}</th>
						      <th>{{tr('date')}}</th>
						      <th>{{tr('action')}}</th>
						    </tr>
						</thead>

						<tbody>

							@foreach($data as $i => $history)

							    <tr>
							      	<td>{{$i+1}}</td>
							      	<td>{{$history->username}}</td>
							      	<td>{{$history->title}}</td>
							      	<td>{{$history->date}}</td>
								    <td>
            							<ul class="admin-action btn btn-default">
            								<li class="dropup">

								                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
								                  {{tr('action')}} 
								                  <span class="caret"></span>
								                </a>

								                <ul class="dropdown-menu">
								                  	<li role="presentation"><a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('admin.delete.history' , $history->user_history_id)}}">{{tr('delete_history')}}</a></li>
								                </ul>

              								</li>
            							</ul>
								    </td>
							    </tr>					

							@endforeach
						</tbody>
					</table>
				@else
					<h3 class="no-result">{{tr('no_history_found')}}</h3>
				@endif
            </div>
          </div>
        </div>
    </div>

@endsection


