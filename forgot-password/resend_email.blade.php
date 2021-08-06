@extends('layouts.master')
@section('title','Resend Email Activation')
@section('stylesheets')
{!! Html::style('/css/admin/login.css') !!}
@endsection

@section('content')
<link rel="stylesheet" type="text/css" href="{{asset('cloudfare/bootstrap.min.css')}}">
<script type="text/javascript" src="{{asset('cloudfare/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/bootstrap-show-password.min.js')}}"></script>
<style>
    .password_size {
        width: 100% !important;
    }

</style>
<div class="col-md-12 text-center logo-container">
    <img src="{{URL::asset('/images/logo.png')}}" width="500">
</div>
<div class="col-md-6 col-md-offset-3">
    @include('partials._messages')
</div>
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default orange-border">
        <div class="panel-heading orange-background orange-border white-text">@yield('title')</div>
        <div class="panel-body orange-border login-box-background">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <hr>
                    {!! Form::open(['data-parsley-validate'=>'','route'=>'resend-activation']) !!}
                    <div class="form-group">
                        {!! Form::label('text','Username/Email Address:') !!}<span class="error-messages" id="email-error"></span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon1"><i class="fa fa-user"></i></span>
                            {!! Form::text('email',null,['class'=>'form-control','autofocus','aria-describedby'=>'addon1','placeholder'=>'Enter Username/Email Address',
                            'required'=>'','data-parsley-errors-container'=>'#email-error',
                            'data-parsley-required-message'=>"Please enter your Username/Email Address",
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="/" class="btn btn-default btn-block"><i class="fa fa-times"></i> Cancel</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Resend</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Have an account? <a href="/" class="text-success">Login page</a></label><br>
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')

@endsection
