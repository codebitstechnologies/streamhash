@extends('layouts.admin')

@section('title', tr('pages'))

@section('content-header', tr('pages'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li class="active"><i class="fa fa-book"></i> {{tr('pages')}}</li>
@endsection

@section('content')

    @include('notification.notify')

    <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header label-primary">
                <b style="font-size:18px;">{{tr('pages')}}</b>
                <a href="{{route('addPage')}}" class="btn btn-default pull-right">{{tr('add_page')}}</a>
            </div>
            <div class="box-body">

                @if(count($data) > 0)

                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>#{{tr('id')}}</th>
                                <th>{{tr('heading')}}</th>
                                <th>{{tr('description')}}</th>
                                <th>{{tr('page_type')}}</th>
                                <th>{{tr('action')}}</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data as $i => $value)
                    
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{$value->heading}}</td>
                                    <td>{{$value->description}}</td>
                                    <td>{{$value->type}}</td>
                                    <td>
                                        <ul class="admin-action btn btn-default">
                                            <li class="dropdown">
                                                
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                  {{tr('action')}} <span class="caret"></span>
                                                </a>

                                                <ul class="dropdown-menu">
                                                   
                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="-1" href="{{route('editPage', array('id' => $value->id))}}">
                                                            {{tr('edit_page')}}
                                                        </a>
                                                    </li>

                                                    
                                                    <li role="presentation">
                                                        @if(Setting::get('admin_delete_control'))

                                                            <a role="button" href="javascript:;" class="btn disabled" style="text-align: left">{{tr('delete')}}</a>

                                                        @else
                                                            <a role="menuitem" tabindex="-1" onclick="return confirm('Are you sure?');" href="{{route('deletePage',array('id' => $value->id))}}">
                                                                {{tr('delete_page')}}
                                                            </a>
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
                    <h3 class="no-result">{{tr('no_result_found')}}</h3>
                @endif
            </div>
          </div>
        </div>
    </div>

@endsection