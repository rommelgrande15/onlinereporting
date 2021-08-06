@extends('layouts.master')
@section('title','Login to your account')
@section('stylesheets')
  {{ Html::style('/css/login/index.css') }}
@endsection

@section('content')
    <div class="col-md-12 text-center logo-container">
        @if(Request::url('') == 'tk.tic-sera.com')
          <img src="{{URL::asset('/images/ticsera-logo.png')}}" width="200">
        @else
          <img src="{{URL::asset('/images/tic.png')}}" width="200">
        @endif
      
    </div>
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-default orange-border">
      <div class="panel-heading orange-background orange-border white-text">Login</div>
        <div class="panel-body orange-border login-box-background">
          <hr> 
          {!! Form::open(['data-parsley-validate'=>'','route'=>'loginuser']) !!}
              <div class="form-group">
                {{ Form::label('username','Username/Email:') }}<span class="error-messages" id="username-error"></span>
                <div class="input-group">
                  <span class="input-group-addon" id="addon1"><i class="fa fa-user"></i></span>
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
              <div class="row">
                <div class="col-md-12">
                    {{ Form::submit('Login  ',['class'=>'btn btn-warning']) }}
                    <div class="pull-right bold">
                      <a class="anchor-no-underline" href="#">Forgot Password? | </a>
                      <a class="anchor-no-underline" href="/register">Register</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <span>NOTE: </span> We are not sending any email to change your password nor system is asking it. Please be careful on viruses and spam nowadays. Don't click unfamiliar link. Thank you.
                        </p>
                    </div>
                </div>
              </div>
          {!! Form::close() !!}
            <hr>
        </div>
      </div>
    </div>
@endsection

@section('scripts')

@endsection
