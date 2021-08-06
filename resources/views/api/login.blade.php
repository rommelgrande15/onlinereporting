@extends('layouts.admin')
@section('title','Login to your account')
@section('stylesheets')
  {{ Html::style('/css/admin/login.css') }}
@endsection

@section('content')
    <div class="col-md-12 text-center logo-container">
      <img src="{{URL::asset('/images/tic.png')}}">
    </div>
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default orange-border">
      <div class="panel-heading orange-background orange-border white-text">Login</div>
        <div class="panel-body orange-border login-box-background">
          <hr>
          {!! Form::open(['data-parsley-validate'=>'','route'=>'applogin']) !!}
              <div class="form-group">
                {{ Form::label('username','Username:') }}<span class="error-messages" id="username-error"></span>
                <div class="input-group">
                  <span class="input-group-addon" id="addon1">@</span>
                    {{ Form::text('username',null,['class'=>'form-control','aria-describedby'=>'addon1',
                      'required'=>'','data-parsley-errors-container'=>'#username-error',
                      'data-parsley-required-message'=>"Please enter your username",
                      ]) }}
                </div>
              </div>


              <div class="form-group">
                {{ Form::label('password','Password:') }}<span class="error-messages" id="password-error"></span>
                <div class="input-group">
                  <span class="input-group-addon" id="addon2"><i class="fa fa-key" aria-hidden="true"></i></span>
                  {{ Form::password('password',['class'=>'form-control','id'=>'txtPassword','required'=>'',
                    'data-parsley-errors-container'=>'#password-error','aria-describedby'=>'addon2','data-parsley-required-message'=>"Please enter your password"]) }}
                </div>
              </div>

              <div class="form-group">
                {{ Form::submit('Login  ',['class'=>'btn btn-primary','style'=>'margin-top:20px;']) }}
              </div>

          {!! Form::close() !!}
            <hr>
        </div>
      </div>

    </div>
@endsection

@section('scripts')

@endsection
