@extends('layouts.moderator')

@section('title', tr('edit_video'))

@section('content-header', tr('edit_video'))

@section('styles')

    <link rel="stylesheet" href="{{asset('admin-css/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin-css/plugins/iCheck/all.css')}}">

    <link rel="stylesheet" href="{{asset('assets/css/wizard.css')}}">

@endsection

@section('breadcrumb')
    <li><a href="{{route('moderator.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li><a href="{{route('moderator.videos')}}"><i class="fa fa-video-camera"></i>{{tr('videos')}}</a></li>
    <li class="active"> {{tr('edit_video')}}</li>
@endsection 

@section('content')

    @include('notification.notify')

<div class="row">
    <div class="col-lg-12">
        <section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">
                <!--class="disabled"-->
                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Video Details">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-book"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Category">
                            <span class="round-tab">
                                <i class="fa fa-suitcase"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Sub Category">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-folder-open"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Upload Video/Image">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-picture"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

            <form id="video-upload" action="{{(Setting::get('admin_delete_control') == 1) ? '' : route('moderator.save.edit.video')}}" method="POST" enctype="multipart/form-data" role="form">
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <input type="hidden" value="1" name="ajax_key">
                        <!-- <h3>Video Details</h3> -->
                        <div style="margin-left: 15px"><small>Note : <span style="color:red">*</span> fields are mandatory. Please fill and click next.</small></div> 
                        <hr>
                        <div class="">
                            <input type="hidden" value="{{$video->admin_video_id}}" name="id">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="title" class="">{{tr('title')}} * </label>
                                    <input type="text" required class="form-control" id="title" name="title" placeholder="{{tr('title')}}" value="{{$video->title}}">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="display: none">
                                <div class="form-group">
                                    <label for="datepicker" class="">{{tr('publish_time')}} * </label>

                                    <input type="text" name="publish_time" placeholder="Select the Publish Time i.e YYYY-MM-DD" class="form-control pull-right" id="datepicker" value="{{$video->publish_time}}">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label>{{tr('duration')}} * : </label><small> Note: Format must be HH:MM:SS</small>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input required type="text" name="duration" class="form-control" data-inputmask="'alias': 'hh:mm:ss'" data-mask id="duration" value="{{$video->duration}}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="ratings" class="">{{tr('ratings')}}</label>
                                    <div class="starRating">
                                        <input id="rating5" type="radio" name="ratings" value="5" @if($video->ratings == 5) checked @endif>
                                        <label for="rating5">5</label>

                                        <input id="rating4" type="radio" name="ratings" value="4" @if($video->ratings == 4) checked @endif>
                                        <label for="rating4">4</label>

                                        <input id="rating3" type="radio" name="ratings" value="3" @if($video->ratings == 3) checked @endif>
                                        <label for="rating3">3</label>

                                        <input id="rating2" type="radio" name="ratings" value="2" @if($video->ratings == 2) checked @endif>
                                        <label for="rating2">2</label>

                                        <input id="rating1" type="radio" name="ratings" value="1" @if($video->ratings == 1) checked @endif>
                                        <label for="rating1">1</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="description" class="">{{tr('description')}} * </label>
                                    <textarea  style="overflow:auto;resize:none" class="form-control" required rows="4" cols="50" id="description" name="description">{{$video->description}}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="reviews" class="">{{tr('reviews')}} * </label>
                                    <textarea  style="overflow:auto;resize:none" class="form-control" required rows="4" cols="50" id="reviews" name="reviews">{{$video->reviews}}</textarea>
                                </div>
                            </div>
                        </div>
                        <ul class="list-inline pull-right">
                            <li>
                                <button type="button" style="display: none;" id="{{REQUEST_STEP_1}}" class="btn btn-primary next-step">Next</button>
                                <button type="button" class="btn btn-primary" onclick="saveVideoDetails({{REQUEST_STEP_1}})">Next</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <h3>Category</h3>
                        <hr>
                        <div id="category">
                            @foreach($categories as $category)
                            <?php
                                $css = ($category->id == $video->category_id) ? 'category-item-active' : '';
                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-sx-12">
                                <a onclick="saveCategory({{$category->id}}, {{REQUEST_STEP_2}})" class="{{$css}} category-item text-center">
                                    <div style="background-image: url({{$category->picture}})" class="category-img bg-img"></div>
                                    <h3 class="category-tit"><i id="{{$category->id}}_i" class="fa fa-check-circle" style="display:none;color:#51af33" aria-hidden="true"></i> {{$category->name}}</h3>
                                </a>
                            </div>
                            @endforeach
                            <input type="hidden" name="category_id" id="category_id" value="{{$video->category_id}}"/>
                        </div>
                        <div class="clearfix"></div>
                        <ul class="list-inline">
                            <li class="pull-left"><button type="button" class="btn btn-danger prev-step">Previous</button></li>
                            <li class="pull-right"><button type="button" class="btn btn-primary next-step" id="{{REQUEST_STEP_2}}">Next</button></li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <h3>Sub Category</h3>
                        <hr>
                        <div id="sub_category">
                            @foreach($subCategories as $subCategory)
                             <?php
                                $subcss = ($subCategory->id == $video->sub_category_id) ? 'category-item-active' : '';
                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-sx-12">
                                <a onclick="saveSubCategory({{$subCategory->id}}, {{REQUEST_STEP_3}})" class="{{$subcss}} category-item text-center">
                                    <div style="background-image: url({{$subCategory->picture}})" class="category-img bg-img"></div>
                                    <h3 class="category-tit"><i id="{{$subCategory->id}}_sub_i" class="fa fa-check-circle" style="display:none;color:#51af33" aria-hidden="true"></i> {{$subCategory->name}}</h3>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="sub_category_id" id="sub_category_id" value="{{$video->sub_category_id}}"/>
                        <div class="clearfix"></div>
                        <ul class="list-inline">
                            <li><button type="button" class="btn btn-danger prev-step">Previous</button></li>
                            <!-- <li><button type="button" class="btn btn-default next-step">Skip</button></li> -->
                            <li class="pull-right" style="display: none;"><button  id="{{REQUEST_STEP_3}}" type="button" class="btn btn-primary btn-info-full next-step">Next</button></li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Upload Video/Image</h3>
                        <hr>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="genre_id">
                                <div class="form-group">

                                    <label for="genre" class="">{{tr('select_genre')}}</label>

                                    <select id="genre" name="genre_id" class="form-control" @if(!$video->is_series) disabled @endif>
                                        @if($video->genre_id)
                                            <option value="{{$video->genre_id}}">{{$video->genre_name}}</option>
                                        @else
                                            <option value="">{{tr('select_genre')}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                               <small style="color:brown">Note : Check the view video for video images.</small>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="default_image" class="">{{tr('default_image')}} *</label>
                                    <input type="file" id="default_image" accept="image/png,image/jpeg" name="default_image" placeholder="{{tr('default_image')}}" style="display:none" onchange="loadFile(this,'default_img')">
                                    <div>
                                        <img src="{{($video->default_image) ? $video->default_image : asset('images/320x150.png')}}" style="width:150px;height:75px;" 
                                        onclick="$('#default_image').click();return false;" id="default_img"/>
                                    </div>
                                    <p class="help-block">{{tr('image_validate')}} {{tr('rectangle_image')}}</p>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?php $videoimages = get_video_image($video->admin_video_id);?>
                                <div class="form-group">
                                    <label for="other_image1" class="">{{tr('other_image1')}} * </label>
                                    <input type="file" id="other_image1" accept="image/png,image/jpeg" name="other_image1" placeholder="{{tr('other_image1')}}" style="display:none" onchange="loadFile(this,'other_img1')">
                                    <div>
                                        <img src="{{isset($videoimages[0]->image) ? $videoimages[0]->image : asset('images/320x150.png')}}" style="width:150px;height:75px;" 
                                        onclick="$('#other_image1').click();return false;" id="other_img1"/>
                                    </div>
                                    <p class="help-block">{{tr('image_validate')}} {{tr('rectangle_image')}}</p>
                                </div>
                            </div>
                        
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="other_image2" class="">{{tr('other_image2')}} *</label>
                                    <input type="file" id="other_image2" accept="image/png,image/jpeg" name="other_image2" placeholder="{{tr('other_image2')}}" style="display:none" onchange="loadFile(this,'other_img2')">
                                    <div>
                                        <img src="{{isset($videoimages[1]->image) ? $videoimages[1]->image : asset('images/320x150.png')}}" style="width:150px;height:75px;" 
                                        onclick="$('#other_image2').click();return false;" id="other_img2"/>
                                    </div>
                                    <p class="help-block">{{tr('image_validate')}} {{tr('rectangle_image')}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="video_type" class="">{{tr('video_type')}}</label></br>

                                    <label style="margin-top:10px" id="video_upload">
                                        <input required type="radio" name="video_type" value="1" class="flat-red" @if($video->video_type == 1) checked @endif>
                                        {{tr('video_upload_link')}}
                                    </label>

                                    <label style="margin-top:10px" id="youtube">
                                        <input required type="radio" name="video_type" class="flat-red"  value="2" @if($video->video_type == 2) checked @endif>
                                        {{tr('youtube')}}
                                    </label>

                                    <label style="margin-top:10px" id="other_link">
                                        <input required type="radio" name="video_type" value="3" class="flat-red" @if($video->video_type == 3) checked @endif>
                                        {{tr('other_link')}}
                                    </label>

                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="compress">
                                <div class="form-group">
                                    <label>{{tr('compress_video')}}</label>
                                    <br>
                                    <div>
                                        <input type="radio" name="compress_video" value="1"> <label>{{tr('yes')}}</label> &nbsp;&nbsp;
                                        <input type="radio" name="compress_video" value="0" checked> <label>{{tr('no')}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="resolution">
                                <div class="form-group">
                                    <label>{{tr('resize_video_resolutions')}}</label>
                                    <br>
                                    <div>
                                        @foreach(getVideoResolutions() as $resolution)
                                            <input type="checkbox" name="video_resolutions[]" value="{{$resolution->value}}"> <label>{{$resolution->value}}</label> &nbsp;&nbsp;
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div id="upload">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="video" class="">{{tr('video')}}</label>
                                        <input type="file" id="video" accept="video/mp4" name="video" placeholder="{{tr('picture')}}">
                                        <p class="help-block">{{tr('video_validate')}}</p>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="trailer_video" class="">{{tr('trailer_video')}}</label>
                                        <input type="file" id="trailer_video" accept="video/mp4" name="trailer_video" placeholder="{{tr('trailer_video')}}">
                                        <p class="help-block">{{tr('video_validate')}}</p>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">

                                        <label for="video_upload_type" class="">{{tr('video_upload_type')}}</label></br>

                                        <label style="margin-top:10px" >
                                            <input type="radio" @if(!check_s3_configure()) disabled @endif name="video_upload_type" value="1" class="flat-red" @if($video->video_upload_type == 1) checked @endif>
                                            {{tr('s3')}}
                                        </label>

                                        <label style="margin-top:10px">
                                            <input type="radio" name="video_upload_type" class="flat-red"  value="2" @if($video->video_upload_type == 2) checked @endif>
                                            {{tr('direct')}}
                                        </label>

                                    </div>
                                </div>
                            </div>
                            <div id="others">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="other_video" class="">{{tr('video')}}</label>
                                        <input type="text" class="form-control" id="other_video" name="other_video" placeholder="{{tr('video')}}" @if($video->video_type == 2 || $video->video_type == 3) value="{{$video->video}}" @endif>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="other_trailer_video" class="">{{tr('trailer_video')}}</label>
                                        <input type="text" class="form-control" id="other_trailer_video" name="other_trailer_video" placeholder="{{tr('trailer_video')}}" @if($video->video_type == 2 || $video->video_type == 3) value="{{$video->trailer_video}}" @endif>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <ul class="list-inline">
                            <li><button type="button" class="btn btn-danger prev-step">Previous</button></li>
                            <!-- <li><button type="button" class="btn btn-default next-step">Skip</button></li> -->
                            @if(Setting::get('admin_delete_control') == 1) 
                            <li class="pull-right"><button disabled id="{{REQUEST_STEP_FINAL}}" type="button" class="btn btn-primary btn-info-full">Finish</button></li>
                            @else
                                <li class="pull-right"><button id="{{REQUEST_STEP_FINAL}}" type="submit" class="btn btn-primary btn-info-full">Finish</button></li>
                                <li class="pull-right">
                                    <div class="progress">
                                        <div class="bar"></div >
                                        <div class="percent">0%</div >
                                    </div>
                                <li>
                            @endif
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
   </div>
</div>

<div class="overlay">
    <div id="loading-img"></div>
</div>

@endsection

@section('scripts')

    <script src="{{asset('admin-css/plugins/bootstrap-datetimepicker/js/moment.min.js')}}"></script> 

    <script src="{{asset('admin-css/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script> 

    <script src="{{asset('admin-css/plugins/iCheck/icheck.min.js')}}"></script>

    <script src="http://malsup.github.com/jquery.form.js"></script>

    <script type="text/javascript">
        var cat_url = "{{ url('select/sub_category')}}";
        var step3 = "{{REQUEST_STEP_3}}";
        var sub_cat_url = "{{ url('select/genre')}}";
        var video_id = "{{$video->id}}";
        var genreId = "{{$video->genre_id}}";

        $("#"+"{{$video->category_id}}"+"_i").show();
        $("#"+"{{$video->sub_category_id}}"+"_sub_i").show();
        var final = "{{REQUEST_STEP_FINAL}}";



        $(function () {

            $('#datepicker').datetimepicker({
                minTime: "00:00:00",
                maxDate: moment(),
                defaultDate: "{{$video->publish_time}}",
                autoclose:true,
            });

            $('#upload').hide();
            $('#others').hide();
            $("#compress").hide();
            $("#resolution").hide();

            @if($video->video_type == 1)
                $('#upload').show();
                $("#compress").show();
                $("#resolution").show();
            @else
                $('#others').show();
                $("#compress").hide();
                $("#resolution").hide();
            @endif

            $("#video_upload").click(function(){

                $("#upload").show();
                $("#others").hide();
                $("#compress").show();
                $("#resolution").show();
            });

            $("#youtube").click(function(){
                $("#others").show();
                $("#upload").hide();
                $("#compress").hide();
                $("#resolution").hide();
            });

            $("#other_link").click(function(){
                $("#others").show();
                $("#upload").hide();
                $("#compress").hide();
                $("#resolution").hide();    
            });
        });

    </script>  
    <script src="{{asset('assets/js/wizard.js')}}"></script>
    <script>
        
        loadGenre(genreId);
        

        $('form').submit(function () {
           window.onbeforeunload = null;
        });
        
        window.onbeforeunload = function() {
            return "Data will be lost if you leave the page, are you sure?";
        };
    </script>
@endsection


