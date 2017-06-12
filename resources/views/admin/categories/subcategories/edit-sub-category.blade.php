@extends('layouts.admin')

@section('title', tr('edit_sub_category'))

@section('content-header')

    {{tr('edit_sub_category') }} - <span style="color:#1d880c !important">{{$sub_category->name}} </span>

@endsection

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('admin.categories')}}"><i class="fa fa-suitcase"></i> {{tr('categories')}}</a></li>
    <li><a href="{{route('admin.sub_categories' , array('category' => $category->id))}}"><i class="fa fa-suitcase"></i> {{tr('sub_categories')}}</a></li>
    <li class="active"><i class="fa fa-suitcase"></i> {{tr('edit_sub_category')}}</li>
@endsection

@section('content')

@include('notification.notify')

    <div class="row">

        <div class="col-md-8">

            <div class="box box-primary">

                <div class="box-header label-primary">
                    <b style="font-size:18px;">{{tr('sub_categories')}}</b>
                    <a href="{{route('admin.add.sub_category' , array('category' => $category->id))}}" class="btn btn-default pull-right">{{tr('add_sub_category')}}</a>
                </div>

                <form class="form-horizontal" action="{{route('admin.save.sub_category')}}" method="POST" enctype="multipart/form-data" role="form">

                    <div class="box-body">

                        <input type="hidden" name="category_id" value="{{$category->id}}">
                        <input type="hidden" name="id" value="{{$sub_category->id}}">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">{{tr('name')}}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" value="{{$sub_category->name}}" id="name" name="name" placeholder="Sub Category Name">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">{{tr('description')}}</label>
                            <div class="col-sm-10">
                                <input type="text" required class="form-control" value="{{$sub_category->description}}" id="description" name="description" placeholder="{{tr('description')}}">
                            </div>
                        </div>

                        @if($sub_category_images[0]->picture)

                            <div class="col-sm-12">
                                <label for="picture1" class="col-sm-2 control-label"></label>
                                <img style="height: 90px;margin-bottom: 15px; border-radius:2em;" src="{{$sub_category_images[0]->picture}}">
                            </div>
                        @endif

                        <div class="form-group">

                            <label for="picture1" class="col-sm-2 control-label">{{tr('picture1')}}</label>                           

                            <div class="col-sm-10">
                                <input type="file" accept="image/png, image/jpeg" id="picture1" name="picture1" placeholder="{{tr('picture1')}}">
                                <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                            </div>

                        </div>

                        @if($sub_category_images[1]->picture)
                            <div class="col-sm-12">
                                <label for="picture1" class="col-sm-2 control-label"></label>
                                <img style="height: 90px;margin-bottom: 15px; border-radius:2em;" src="{{$sub_category_images[1]->picture}}">
                            </div>
                        @endif

                        <div class="form-group">

                            <label for="picture2" class="col-sm-2 control-label">{{tr('picture2')}}</label>

                            <div class="col-sm-10">
                                <input type="file" accept="image/png, image/jpeg" id="picture2" name="picture2" placeholder="{{tr('picture2')}}">
                                <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                            </div>
                        </div>

                        @if($sub_category_images[2]->picture)
                            <div class="col-sm-12">
                                <label for="picture1" class="col-sm-2 control-label"></label>
                                <img style="height: 90px;margin-bottom: 15px; border-radius:2em;" src="{{$sub_category_images[2]->picture}}">
                            </div>
                        
                        @endif

                        <div class="form-group">

                            <label for="picture3" class="col-sm-2 control-label">{{tr('picture3')}}</label>

                            <div class="col-sm-10">
                                <input type="file" accept="image/png, image/jpeg" id="picture3" name="picture3" placeholder="{{tr('picture3')}}">
                                <p class="help-block">{{tr('image_validate')}} {{tr('image_square')}}</p>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer">
                        <button type="reset" class="btn btn-danger">{{tr('cancel')}}</button>
                        <button type="submit" class="btn btn-success pull-right">{{tr('submit')}}</button>
                    </div>
                </form>
            
            </div>

        </div>

        @if($category->is_series)

            <div class="col-md-4">

                <div class="box box-warning">

                    <div class="box-header with-border">
                        <h3 class="box-title">{{tr('add_genre')}}</h3>
                    </div>

                    <form class="form-horizontal" action="{{route('admin.save.genre')}}" method="POST" enctype="multipart/form-data" role="form">

                        <div class="box-body">

                            <input type="hidden" name="category_id" value="{{$category->id}}">
                            <input type="hidden" name="id" value="{{$sub_category->id}}">

                            <div class="form-group">
                                <div class="col-sm-10">
                                    <input type="text" required class="form-control" name="genre" placeholder="{{tr('genre_placeholder')}}">
                                </div>
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="reset" class="btn btn-danger">{{tr('cancel')}}</button>
                            <button type="submit" class="btn btn-success pull-right">{{tr('submit')}}</button>
                        </div>
                    </form>
                
                </div>

                @if(count($genres) > 0)

                    @foreach($genres as $genre)

                        <div class="box">

                            <div class="box-header with-border">
                                <h3 class="box-title">{{$genre->name}}</h3>

                                <a style="margin-left:5px" title="Delete" href="{{route('admin.delete.genre' , $genre->id)}}" class="btn btn-danger pull-right btn-sm">
                                    <i class="fa fa-trash"></i>
                                </a>
                                
                                <!-- @if($genre->is_approved)

                                    <a title="Decline" href="{{route('admin.genre.approve' , array('id' => $genre->id , 'status' => 0))}}" class="btn btn-warning pull-right btn-sm">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @else 
                                    <a title="Approve" href="{{route('admin.genre.approve' , array('id' => $genre->id , 'status' => 1))}}" class="btn btn-success pull-right btn-sm">
                                        <i class="fa fa-check"></i>
                                    </a>
                                @endif -->

                                
                            </div>
                        </div>

                    @endforeach

                @endif

            </div>

        @endif

    </div>

@endsection