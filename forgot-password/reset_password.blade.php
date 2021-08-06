@extends('layouts.master')
@section('title','Reset Password')
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
$logo='ticsera-logo.png';
@endphp
@else
@php
$color_border='orange-border';
$color_bg='orange-background';
$logo='logo.png';
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
        <div class="panel-heading {{$color_bg}} {{$color_border}} white-text">New Password</div>
        <div class="panel-body {{$color_border}} login-box-background">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <hr>
                    @if(strpos(Request::url(''), 'tic-sera') !== false)
                    {!! Form::open(['data-parsley-validate'=>'','route'=>'resetpasswordSerasubmit']) !!}
                    @else
                    {!! Form::open(['data-parsley-validate'=>'','route'=>'resetpasswordsubmit']) !!}
                    @endif
                    <div class="form-group">
                        {!! Form::label('email','Email Address:') !!}<span class="error-messages" id="email-error"></span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon1"><i class="fa fa-envelope-open"></i></span>
                            {!! Form::email('email',$user->email,['class'=>'form-control','autocomplete'=>'off','readonly','aria-describedby'=>'addon1',
                            'required'=>'required','data-parsley-errors-container'=>'#email-error',
                            'data-parsley-required-message'=>"Please enter your Email Address",
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('password','Password:') !!}<span class="error-messages" id="password-error"></span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon2"><i class="fa fa-key"></i></span>
                            {!! Form::password('password',['class'=>'form-control','id'=>'txtPassword','required'=>'required',
                            'data-parsley-errors-container'=>'#password-error','aria-describedby'=>'addon2','data-parsley-required-message'=>"Please enter your password"]) !!}
                            <input type="hidden" value="{{ $reset_code }}" required name="reset_code">
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('repeat_password','Repeat-Password:') !!}<span class="error-messages" id="password-error"></span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon2"><i class="fa fa-key"></i></span>
                            {!! Form::password('repeat_password',['class'=>'form-control','id'=>'repeat_password','required'=>'required',
                            'data-parsley-errors-container'=>'#repeat_password-error','aria-describedby'=>'addon2','data-parsley-required-message'=>"Please enter your password"]) !!}
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="row">
                            <div class="col-md-6">
                                @if(strpos(Request::url(''), 'tic-sera') !== false)
                                <a href="{{route('tic-sera-login')}}" class="btn btn-default btn-block"><i class="fa fa-times"></i> Cancel</a>
                                @else
                                <a href="{{route('login')}}" class="btn btn-default btn-block"><i class="fa fa-times"></i> Cancel</a>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-check"></i> Reset</button>
                            </div>
                        </div>

                        <!--<br />
						<label class="text-center" align="center">Not registered? <a href="/create-account" class="text-success">Create an account</a></label>
						<br>-->
                        <!--<label class="text-center" align="center">Forgot Password? <a href="/create-account" class="text-success">Reset your password here</a></label>-->
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    {!! Form::close() !!}
                    <hr>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')

@endsection
