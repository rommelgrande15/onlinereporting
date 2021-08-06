@extends('layouts.admin')
@section('title','Login to your account')
@section('stylesheets')
{!! Html::style('/css/admin/login.css') !!}
<link rel="stylesheet" type="text/css" href="{{asset('cloudfare/bootstrap.min.css')}}">
<script type="text/javascript" src="{{asset('cloudfare/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/bootstrap-show-password.min.js')}}"></script>
<style>
    .password_size {
        width: 100% !important;
    }
</style>
@endsection

@section('content')

@if(strpos(Request::url(''), 'tic-sera') !== false)
@php
$color_border='sera-border';
$color_bg='sera-background';
@endphp
@else
@php
$color_border='orange-border';
$color_bg='orange-background';
@endphp
@endif
<div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 text-center logo-container">
    <!-- <img class="img-responsive" src="{{URL::asset('/images/logo.png')}}"> -->
    @if(strpos(Request::url(''), 'tic-sera') !== false)
    <div class="text-center">
        <img class="img-responsive" src="{{URL::asset('/images/ticsera-logo.png')}}" style="margin-left:auto; margin-right:auto;">
    </div>
    @else
    <img class="img-responsive" src="{{URL::asset('/images/logo.png')}}">
    @endif
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        @include('partials._messages')
    </div>
</div>
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default {{$color_border}}">
        <div class="panel-heading {{$color_bg}} {{$color_border}} white-text">Login</div>
        <div class="panel-body {{$color_border}} login-box-background">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <hr>
                    @if(strpos(Request::url(''), 'tic-sera') !== false)
                    {!! Form::open(['data-parsley-validate'=>'','route'=>'signin-tic-sera']) !!}
                    @else
                    {!! Form::open(['data-parsley-validate'=>'','route'=>'signinuser']) !!}
                    @endif

                    <div class="form-group">
                        {!! Form::label('username','Username:') !!}<span class="error-messages" id="username-error"></span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon1"><i class="fa fa-user"></i></span>
                            {!! Form::text('username',null,['class'=>'form-control','aria-describedby'=>'addon1',
                            'required'=>'','data-parsley-errors-container'=>'#username-error',
                            'data-parsley-required-message'=>"Please enter your username",
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password','Password:') !!}<span class="error-messages" id="password-error"></span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon2"><i class="fa fa-key"></i></span>
                            {!! Form::password('password',['class'=>'form-control','id'=>'txtPassword','required'=>'',
                            'data-parsley-errors-container'=>'#password-error','aria-describedby'=>'addon2','data-parsley-required-message'=>"Please enter your password"]) !!}
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top:20px;"><i class="fa fa-sign-in"></i> Login</button>
                        <br />
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div><br>
                        @endif
                    </div>
                    <div class="form-group">
                        @if(strpos(Request::url(''), 'tic-sera') !== false)
                        <label>Forgot Password? <a href="/forgot-password-tic-sera" class="text-danger">Reset here</a></label><br>
                        <label>Not registered? <a href="/create-account-tic-sera" class="text-success">Create an account</a></label>
                        @else
                        <label>Forgot Password? <a href="/forgot-password" class="text-danger">Reset here</a></label><br>
                        <label>Not registered? <a href="/create-account" class="text-success">Create an account</a></label>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <span style="color:red; font-weight:bold;">NOTE: </span> We are not sending any email to change your password nor system is asking it. Please be careful on viruses and spam nowadays. Don't click unfamiliar link. Thank you.
                            </p>
                        </div>
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
