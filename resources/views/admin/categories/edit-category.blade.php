@extends('layouts.admin')

@section('title', tr('edit_category'))

@section('content-header', tr('edit_category'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('admin.categories')}}"><i class="fa fa-suitcase"></i> {{tr('categories')}}</a></li>
    <li class="active">{{tr('edit_category')}}</li>
@endsection

@section('content')

@include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-primary">

                <div class="box-header label-primary">
                    <b style="font-size:18px;">{{tr('edit_category')}}</b>
                    <a href="{{route('admin.add.category')}}" class="btn btn-default pull-right">{{tr('add_category')}}</a>
                </div>

                <form class="form-horizontal" action="{{route('admin.save.category')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <input type="hidden" name="id" value="{{$category->id}}">

                        <div class="form-group">
                            <label for="name" class="col-sm-1 control-label">{{tr('name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" value="{{$category->name}}" id="name" name="name" placeholder="Category Name">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="picture" class="col-sm-1 control-label">{{tr('picture')}}</label>

                            @if($category->picture)
                                <img style="height: 90px;margin-bottom: 15px; border-radius:2em;" src="{{$category->picture}}">
                            @endif

                            <div class="col-sm-10" style="margin-left:70px !important">
                                <input type="file" accept="image/png, image/jpeg" id="picture" name="picture" placeholder="{{tr('picture')}}">
                                <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                            </div>
                            
                        </div>

                        <div class="checkbox">
                            <label for="picture" class="col-sm-1 control-label"></label>
                            <label>
                                <input type="checkbox" name="is_series" value="1" @if($category->is_series) checked @endif> {{tr('is_series')}}
                            </label>
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger">{{tr('cancel')}}</button>
                        <button type="submit" class="btn btn-success pull-right">{{tr('submit')}}</button>
                    </div>
                </form>
            
            </div>

        </div>

    </div>

@endsection