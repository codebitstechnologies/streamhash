@extends('layouts.admin')

@section('title', tr('add_page'))

@section('content-header', tr('add_page'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('viewPages')}}"><i class="fa fa-book"></i>{{tr('pages')}}</a></li>
    <li class="active"><i class="fa fa-book"></i> {{tr('add_page')}}</li>
@endsection

@section('content')

    @include('notification.notify')

  	<div class="row">

	    <div class="col-md-10">

	        <div class="box box-primary">

	            <div class="box-header label-primary">
                    <b style="font-size:18px;">{{tr('add_page')}}</b>
                    <a href="{{route('viewPages')}}" class="btn btn-default pull-right">{{tr('pages')}}</a>
                </div>

	            <form  action="{{route('adminPagesProcess')}}" method="POST" enctype="multipart/form-data" role="form">

	                <div class="box-body">

	                     <div class="form-group floating-label">
	                     	<label for="select2">{{tr('select_page_type')}}</label>
                            <select id="select2" name="type" class="form-control">
                                <option value="">&nbsp;</option>
                                <option value="about" selected="true">{{tr('about')}}</option>
                                <option value="terms">{{tr('terms_conditions')}}</option>
                                <option value="privacy">{{tr('privacy')}}</option>
                            </select>
                            
                        </div>

	                    <div class="form-group">
	                        <label for="heading">{{tr('heading')}}</label>
	                        <input type="text" required class="form-control" name="heading" id="heading" placeholder="Enter heading">
	                    </div>

	                    <div class="form-group">
	                        <label for="description">{{tr('description')}}</label>

	                        <textarea id="ckeditor" required name="description" class="form-control" placeholder="Enter text ..."></textarea>
	                        
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

@section('scripts')
    <script src="http://cdn.ckeditor.com/4.5.5/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'ckeditor' );
    </script>
@endsection


