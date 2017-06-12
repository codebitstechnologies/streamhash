@extends('layouts.user.focused')

@section('content')

@include('notification.notify')

<section class="registration">
    <div class="row secBg">
        <div class="large-12 columns forgot-password-min">
            <div class="login-register-content">

                <div class="row collapse borderBottom">
                    <div class="medium-6 large-centered medium-centered">
                        <div class="page-heading text-center" style="margin-top:20px;padding:0px !important">
                            <h3>{{tr('delete_account')}}</h3>
                        </div>
                    </div>
                </div>

                <div class="row" data-equalizer="fldb3f-equalizer" data-equalize-on="medium" id="test-eq" data-resize="mmu5g8-eq" data-events="resize">

                    <div class="large-4 medium-6 large-centered medium-centered columns">

                    <br><br><br>

                        <div class="register-form">

                        <h5 class="text-center">{{tr('delete_account_heading')}}</h5>

                        <p>
                            <strong style="color: brown">Note:</strong> {{tr('delete_account_content')}}
                        </p>

                            <form method="post" data-abide="bhwxrp-abide" novalidate="" action="{{ route('user.delete.account.process') }}">                                

                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                    <input type="password" name="password" placeholder="Enter your Password" required="">
                                </div>

                                <button class="button expanded" type="submit" name="submit">{{tr('delete')}}</button>

                                

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection
