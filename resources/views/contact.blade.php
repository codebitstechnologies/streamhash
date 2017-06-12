@extends('layouts.user')

@section('content')
	
	<div class="row" style="margin-top:10px;margin-bottom:10px;min-height:500px;">

		<div class="large-8 columns">

            <section class="content content-with-sidebar">
                <!-- newest video -->
                <div class="main-heading removeMargin">
                    <div class="row secBg padding-14 removeBorderBottom">
                        <div class="medium-8 small-8 columns">
                            <div class="head-title">
                                <i class="fa fa-user"></i>

                                @if($contact)
                                	<h4>{{$contact->description}}</h4>
                                @else
                                	<h4>{{tr('contact')}}</h4>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row secBg">
                    <div class="large-12 columns">
                        <article class="page-content contact-form">

                            @include('layouts.user.notification')

                                <form action="{{ route('user.profile.save') }}" method="POST" enctype="multipart/form-data">

                                    <div class="setting-form-inner">

                                        <div class="row">

                                            <div class="medium-6 columns">
                                                <label>{{tr('username')}}:
                                                    <input type="text"  name="name" required  placeholder="enter your {{tr('username')}}..">
                                                </label>
                                            </div>

                                            <div class="medium-6 columns">
                                                <label>{{tr('email')}}:
                                                    <input type="email" name="email" required  placeholder="enter your {{tr('username')}}..">
                                                </label>
                                            </div>

                                            <div class="medium-12 columns">
                                                <label>{{tr('description')}}:
                                                    <textarea name="description"></textarea>
                                                </label>
                                            </div>
                                            
                                            <button class="button expanded" type="submit" name="setting">{{tr('submit')}}</button>

                                        </div>

                                        <!--setting-form-inner row end-->
                                    </div>

                                    <!--setting-form-inner end-->


                                </form>
                        	
                        </article>
                    </div>
                </div>
            
            </section>

        </div>

	</div>

@endsection