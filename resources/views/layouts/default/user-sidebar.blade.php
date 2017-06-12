 <div class="large-4 columns mar-top-space">
    <aside class="secBg sidebar">
        <div class="row">
            <!-- profile overview -->
            <div class="large-12 columns">
                <div class="widgetBox">
                    <div class="widgetTitle">
                        <h5>{{tr('profile')}}</h5>
                    </div><!--widget-title end-->
                    
                    <div class="round" style="width:100px !important;height:100px!important">

                        <?php $image = asset('placeholder.png'); ?> 

                        @if(Auth::check()) 

                            @if(Auth::user()->picture)
                                <?php $image = Auth::user()->picture; ?> 
                            @endif

                        @endif

                        <a data-rel="lightcase"><img src="{{$image}}"></a>
                    </div><!--end round-->

                    <div class="user-name"><p>@if(Auth::check()) {{Auth::user()->name}} @else {{tr('user')}} @endif</p></div>

                    <div class="widgetContent">
                        <ul class="profile-overview">

                            <li class="clearfix">
                                <a id="user-profile" href="{{route('user.profile')}}">
                                    <i class="fa fa-user"></i>
                                    {{tr('about')}}
                                </a>
                            </li>

                            <li class="clearfix">
                                <a  id="user-update-profile" href="{{route('user.update.profile')}}">
                                    <i class="fa fa-pencil-square-o"></i>{{tr('update_profile')}}
                                </a>
                            </li>

                            <li class="clearfix">
                                <a id="user-history" href="{{route('user.history')}}">
                                    <i class="fa fa-video-camera"></i>
                                    {{tr('history')}} 
                                    <span class="float-right">
                                        {{get_user_history_count(Auth::user()->id)}}
                                    </span>
                                </a>
                            </li>

                            <li class="clearfix">
                                <a id="user-wishlist" href="{{route('user.wishlist')}}">
                                    <i class="fa fa-heart"></i>{{tr('wishlist')}}
                                    <span class="float-right">
                                        {{get_user_wishlist_count(Auth::user()->id)}}
                                    </span>
                                </a>
                            </li>

                             <li class="clearfix">
                                <a id="user-spam-videos" href="{{route('user.spam-videos')}}">
                                    <i class="fa fa-flag"></i>{{tr('spam_videos')}}
                                    <span class="float-right">
                                        {{getFlagVideosCnt(Auth::user()->id)}}
                                    </span>
                                </a>
                            </li>

                            <li class="clearfix">
                                <a href="{{route('user.comments')}}" id="user-comments">
                                    <i class="fa fa-comments-o"></i>{{tr('comments')}}
                                    <span class="float-right">{{get_user_comment_count(Auth::user()->id)}}</span>
                                </a>
                            </li>

                            <li class="clearfix">
                                <a id="pay_per_videos" href="{{route('user.pay-per-videos')}}">
                                    <i class="fa fa-video-camera"></i>{{tr('pay_per_videos')}}
                                    <span class="float-right">${{user_total_amount()}}</span>
                                </a>
                            </li>

                            @if(Auth::user()->login_by == 'manual')

                                <li class="clearfix">
                                    <a href="{{route('user.change.password')}}" id="user-change-password">
                                        <i class="fa fa-magic"></i>{{tr('change_password')}}
                                    </a>
                                </li>

                            @endif

                            <li class="clearfix">
                                <a href="{{route('user.delete.account')}}" @if(Auth::user()->login_by != 'manual') onclick="return confirm('Are you sure? . Once you deleted account, you will lose your history and wishlist details.')" @endif>
                                    <i class="fa fa-trash"></i>{{tr('delete_account')}}
                                </a>
                            </li>

                            <li class="clearfix">
                                <a href="{{route('user.logout')}}">
                                    <i class="fa fa-sign-out"></i>{{tr('logout')}}
                                </a>
                            </li>

                        </ul>
        
                    </div><!-- End widgetContent -->
                </div><!-- End widgetbox-->
            </div><!-- End profile overview -->
        </div>
    </aside>
</div>