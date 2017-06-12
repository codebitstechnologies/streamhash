@extends('layouts.admin')

@section('title', tr('categories'))

@section('content-header', tr('categories'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-suitcase"></i> {{tr('categories')}}</li>
@endsection

@section('content')

	@include('notification.notify')

	<div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
          	<div class="box-header label-primary">
                <b style="font-size:18px;">{{tr('categories')}}</b>
                <a href="{{route('admin.add.category')}}" class="btn btn-default pull-right">{{tr('add_category')}}</a>
            </div>
            <div class="box-body">

            	@if(count($categories) > 0)

	              	<table id="example1" class="table table-bordered table-striped">

						<thead>
						    <tr>
						      <th>{{tr('id')}}</th>
						      <th>{{tr('category')}}</th>
						      <th>{{tr('picture')}}</th>
						      <th>{{tr('is_series')}}</th>
						      <th>{{tr('status')}}</th>
						      <th>{{tr('action')}}</th>
						    </tr>
						</thead>

						<tbody>
							@foreach($categories as $i => $category)

							    <tr>
							      	<td>{{$i+1}}</td>
							      	<td>{{$category->name}}</td>
							      	<td>
	                                	<img style="height: 30px;" src="{{$category->picture}}">
	                            	</td>

	                            	<td>
							      		@if($category->is_series)
							      			<span class="label label-success">{{tr('yes')}}</span>
							       		@else
							       			<span class="label label-warning">{{tr('no')}}</span>
							       		@endif
							       	</td>

							      <td>
							      		@if($category->is_approved)
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
                                                            <a role="menuitem" tabindex="-1" href="{{route('admin.edit.category' , array('id' => $category->id))}}">{{tr('edit')}}</a>
                                                        @endif
                                                    </li>
								                  	<li role="presentation">

									                  	@if(Setting::get('admin_delete_control'))

										                  	<a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>

										                @else

								                  			<a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?')" href="{{route('admin.delete.category' , array('category_id' => $category->id))}}">{{tr('delete')}}</a>
								                  		@endif
								                  	</li>

													<li class="divider" role="presentation"></li>

								                  	@if($category->is_approved)
								                  		<li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('admin.category.approve' , array('id' => $category->id , 'status' =>0))}}">{{tr('decline')}}</a></li>
								                  	@else
								                  		<li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('admin.category.approve' , array('id' => $category->id , 'status' => 1))}}">{{tr('approve')}}</a></li>
								                  	@endif

								                  	<li class="divider" role="presentation"></li>

								                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('admin.add.sub_category' , array('category' => $category->id))}}">{{tr('add_sub_category')}}</a></li>
								                  	<li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('admin.sub_categories' , array('category' => $category->id))}}">{{tr('view_sub_categories')}}</a></li>
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
