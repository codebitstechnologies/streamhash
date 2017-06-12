@extends('layouts.admin')

@section('title', tr('payment_settings'))

@section('content-header', tr('payment_settings'))

@section('breadcrumb')
    <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i>{{tr('home')}}</a></li>
    <li class="active"><i class="fa fa-gears"></i> {{tr('payment_settings')}}</li>
@endsection

@section('content')

@include('notification.notify')

    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">{{tr('payment_settings')}}</h3>
                </div>

                <form action="{{route('admin.save.settings')}}" method="POST" enctype="multipart/form-data" role="form">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="paypal_client_id">{{tr('paypal_client_id')}}</label>
                            <input type="text" value="{{ Setting::get('paypal_client_id')}}" class="form-control" name="paypal_client_id" id="paypal_client_id" placeholder="Enter {{tr('paypal_client_id')}}">
                        </div>

                        <div class="form-group">
                            <label for="paypal_secret">{{tr('paypal_secret')}}</label>
                            <input type="text" class="form-control" value="{{Setting::get('paypal_secret')  }}" name="paypal_secret" id="paypal_secret" placeholder="{{tr('paypal_secret')}}">
                        </div>

                        <div class="form-group">
                            <label for="paypal_email">{{tr('paypal_email')}}</label>
                            <input type="text" class="form-control" value="{{Setting::get('paypal_email')  }}" name="paypal_email" id="paypal_email" placeholder="Paypal Email">
                        </div>

                        <div class="form-group">
                            <label for="amount">{{tr('amount')}}</label>
                            <input type="text" class="form-control" value="{{Setting::get('amount')  }}" name="amount" id="amount" placeholder="{{tr('amount')}}">
                        </div>

                        <div class="form-group">
                            <label for="expiry_days">{{tr('expiry_days')}}</label>
                            <input type="text" class="form-control" value="{{Setting::get('expiry_days')  }}" name="expiry_days" id="expiry_days" placeholder="{{tr('expiry_days')}}">
                        </div>

                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">{{tr('submit')}}</button>
                  </div>
                </form>

            </div>
        </div>

    </div>


@endsection