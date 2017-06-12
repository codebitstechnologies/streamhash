@extends('layouts.admin')

@section('title', tr('add_sub_category'))

@section('content-header')

    <span style="color:#1d880c !important">{{$category->name}} </span> - {{tr('add_sub_category') }}

@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('admin.categories')}}"><i class="fa fa-suitcase"></i> {{tr('categories')}}</a></li>
    <li><a href="{{route('admin.sub_categories' , array('category' => $category->id))}}"><i class="fa fa-suitcase"></i> {{tr('sub_categories')}}</a></li>
    <li class="active"><i class="fa fa-suitcase"></i> {{tr('add_sub_category')}}</li>
@endsection

@section('content')

@include('notification.notify')

    <div class="row">

        <div class="col-md-10">

            <div class="box box-primary">

                <div class="box-header label-primary">
                    <b style="font-size:18px;">{{tr('add_sub_category')}}</b>
                    <a href="{{route('admin.sub_categories' , array('category' => $category->id))}}" class="btn btn-default pull-right">{{tr('sub_categories')}}</a>
                </div>

                <form class="form-horizontal" action="{{route('admin.save.sub_category')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <input type="hidden" name="category_id" value="{{$category->id}}">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">{{tr('name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" id="name" name="name" placeholder="Sub Category Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">{{tr('description')}}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" id="description" name="description" placeholder="{{tr('description')}}">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="picture1" class="col-sm-2 control-label">{{tr('picture1')}}</label>

                            <div class="col-sm-10">
                                <input type="file" accept="image/png, image/jpeg" id="picture1" name="picture1" placeholder="{{tr('picture1')}}">
                                 <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="picture2" class="col-sm-2 control-label">{{tr('picture2')}}</label>

                            <div class="col-sm-10">
                                <input type="file" accept="image/png, image/jpeg" id="picture2" name="picture2" placeholder="{{tr('picture2')}}">
                                 <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="picture3" class="col-sm-2 control-label">{{tr('picture3')}}</label>

                            <div class="col-sm-10">
                                <input type="file" accept="image/png, image/jpeg" id="picture3" name="picture3" placeholder="{{tr('picture3')}}">
                                 <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                            </div>
                        </div>

                        @if($category->is_series)

                            <div class="form-group">

                                <label for="genre" class="col-sm-2 control-label">{{tr('genres')}}</label>

                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" name="genre[]" placeholder="{{tr('genre_placeholder')}}">
                                </div>

                            </div>

                            <div class="form-group">

                                <label for="genre" class="col-sm-2 control-label">{{tr('genres')}}</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="genre[]" placeholder="{{tr('genre_placeholder')}}">
                                </div>
                            </div>

                        @endif

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