@extends('layouts.master')
@section('title','Forgot Password')
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
<div class="col-md-12 text-center logo-container">
    @if(strpos(Request::url(''), 'tic-sera') !== false)
    <img src="{{URL::asset('/images/ticsera-logo.png')}}" width="300">
    @else
    <img src="{{URL::asset('/images/logo.png')}}" width="500">
    @endif

</div>
<div class="col-md-6 col-md-offset-3">
    @include('partials._messages')
</div>
<div class="col-md-6 col-md-offset-3">
    <div class="panel panel-default {{$color_border}}">
        <div class="panel-heading {{$color_bg}} {{$color_border}} white-text">Forgot Password</div>
        <div class="panel-body {{$color_border}} login-box-background">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <hr>
                    @if(strpos(Request::url(''), 'tic-sera') !== false)
                    {!! Form::open(['data-parsley-validate'=>'','route'=>'forgotuser-tic-sera']) !!}
                    @else
                    {!! Form::open(['data-parsley-validate'=>'','route'=>'forgotuser']) !!}
                    @endif


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
                    @if(strpos(Request::url(''), 'tic-sera') !== false)
                    <div class="form-group text-center">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('tic-sera-login') }}" class="btn btn-default btn-block"><i class="fa fa-times"></i> Cancel</a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Have an account? <a href="{{ route('tic-sera-login') }}" class="text-success">Login page</a></label><br>
                        <label>Not registered? <a href="/create-account-tic-sera" class="text-success">Create an account</a></label>
                        @else
                        <div class="form-group text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('login') }}" class="btn btn-default btn-block"><i class="fa fa-times"></i> Cancel</a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                        <label>Have an account? <a href="{{ route('login') }}" class="text-success">Login page</a></label><br>
                        <label>Not registered? <a href="/create-account" class="text-success">Create an account</a></label>
                        @endif
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    </div>
                    @endif

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')

@endsection
