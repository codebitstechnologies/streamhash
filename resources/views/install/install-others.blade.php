@extends('install.layout')

@section('content')

 <div class="install-settings-outer">

	<div class="container">
		<form action="{{route('install.settings')}}" method="POST" enctype="multipart/form-data" role="form">
			<div class="install-settings-inner">

				<div class="row no-margin" style="margin-bottom:10px;">
					<div class="col-md-12">

					<h4 style="color:brown"><strong>Note : </strong></h4>

					<p class="text-justify">It is very simple, just start adding categories and sub-categories and upload video from admin panel or moderator panel, thats it we are good to go. User can able view all trailer videos without payment. Once the payment is done user can able to view the full movie video. Payment is like subscription model. Payment enable, disable and amount for 30 days are controlled by admin.
					</p>

					</div>
				</div>

				<div class="set-image">

					<div class="row no-margin">
						<div class="col-md-12">
							<h4>{{tr('site_settings')}}</h4>
						</div>
					</div>

					<div class="row no-margin">

						<div class="col-sm-6 col-xs-12">
							<div class="form-group">
							    <label for="site_name">{{tr('site_name')}}</label>
							    <input type="text" class="form-control" id="site_name" aria-describedby="emailHelp" name="site_name" placeholder="Please Enter Your Site Name">
							</div><!--end of form-group-->
						</div><!--end of column-->

						<div class="col-sm-6 col-xs-12">
							<div class="form-group">
							    <label for="exampleInputFile"> {{tr('site_logo')}}</label>
					    		<input type="file" name="site_logo" class="form-control-file" accept="image/x-png, image/jpeg" id="exampleInputFile" aria-describedby="fileHelp">
							</div><!--end of form-group-->
						</div><!--end of column-->

					</div><!--end of row-->

					<div class="row no-margin">
						<div class="col-sm-6 col-xs-12">
							<div class="form-group">
							    <label for="fav_icon"> {{tr('site_icon')}}</label>
					    		<input type="file" name="site_icon" class="form-control-file" id="fav_icon" accept="image/x-png, image/jpeg" aria-describedby="fileHelp">
							</div><!--end of form-group-->
						</div><!--end of column-->

						<div class="col-sm-6 col-xs-12">
							<div class="form-group">
							    <label for="streaming_url">Streaming URL</label>
					    		<input type="text" class="form-control" id="streaming_url" name="streaming_url" placeholder="Ex: rtmp://streamhash.com/vod2/" aria-describedby="fileHelp">
							</div><!--end of form-group-->
						</div><!--end of column-->
					</div><!--end of row-->

				</div><!--end of set-image-->
			</div><!--end of install-settings-inner-->

			<div class="row">
				<div class="col-md-6 text-center col-md-offset-3">

					   <button type="submit" style="margin-top: 25px;" class="btn btn-success btn-lg btn-block">{{tr('submit')}}</button>
				</div>
			</div>
		</form>

	</div>

	<!--end of container-->

</div><!--end of install-settings-outer-->

@endsection

@section('footer')


@endsection
