@extends('layouts.admin')
@section('title','Report Details')
@section('page-title','Report Details And Password')
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

        .fa-loader {
            -webkit-animation: spin 2s linear infinite;
            -moz-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }
    
        @-moz-keyframes spin {
            100% {
                -moz-transform: rotate(360deg);
            }
        }
    
        @-webkit-keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
            }
        }
    
        @keyframes spin {
            100% {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    
        .content-header h1 {
            border-bottom: 3px solid orange;
            width: 30%;
            text-align: center;
            margin: 0 auto;
        }
    </style>
@endsection

@section('content')


@php
$color_border='orange-border';
$color_bg='orange-background';
@endphp
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
        <div class="panel-heading {{$color_bg}} {{$color_border}} white-text">Inspection Details</div>
        <div class="panel-body {{$color_border}} login-box-background">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <hr>
                    {!! Form::open(['data-parsley-validate'=>'','route'=>'reportsdatalogin']) !!}

                    <div class="form-group">
                        {!! Form::label('report_no','Report Number:') !!}<span class="error-messages" id="report_no-error"></span>
                        <div class="input-group">
                            <span class="input-group-addon" id="addon1"><i class="fa fa-user"></i></span>
                            {!! Form::text('report_no',null,['class'=>'form-control','aria-describedby'=>'addon1',
                            'required'=>'','data-parsley-errors-container'=>'#report_no-error',
                            'data-parsley-required-message'=>"Please enter your report_no",
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
                        <button type="submit" class="btn btn-primary btn-block" style="margin-top:20px;"><i class="fa fa-sign-in"></i>&nbsp;Start Online Reporting</button>
                        {{-- <button type="button" class="btn btn-success btn-block" style="margin-top:20px;"><a  href="{{ route('inspector-reports-general') }}">Start Online Reporting</a></button> --}}
                        {{-- <a href="{{ URL::route('inspector-reports-general') }}" class="btn btn-primary btn-block" style="margin-top:20px;">Start Online Reporting </a> --}}
                        <br />
                        
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
	{{-- {!! Html::script('/js/client/sub-accounts.js?v=1') !!} --}}
@endsection
