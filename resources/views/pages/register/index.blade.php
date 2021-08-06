@extends('layouts.master')
@section('title','Create an account')
@section('stylesheets')
  {!! Html::style('/css/register/index.css') !!}
@endsection

@section('content')
    <div class="container">
        <div class="col-md-8 col-md-offset-2 register-panel">
            <div class="panel panel-default">
                <div class="panel-heading orange-background"><h2>Create Account</h2></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 note">
                            Please note that all fields are required.
                            <hr>
                        </div>
                        <div class="col-md-8 col-md-offset-2">
                            {!!Form::open(['data-parsley-validate'=>'','route'=>'create'])!!}
                                <h4 class="orange-text">Account Details</h4>
                                <div class="form-group">
                                    {!! Form::text('email', null, ['placeholder'=>'Email Address','class' => 'form-control','data-parsley-type'=>'email','required'=>'','data-parsley-required-message'=>"Please enter your email address",'data-parsley-type-message'=>'Please enter a valid email address!']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('username', null, ['placeholder'=>'Username','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter a username"]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('client_code', null, ['minlength'=>'2', 'maxlength'=>'4','placeholder'=>'Client Code','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter 3-4 characters"]) !!}
                                </div>

                                <div class="form-group">
                                  {!! Form::password('password',['class'=>'form-control','id'=>'txtPassword','required'=>'','placeholder'=>'Password']) !!}
                                </div>

                                <div class="form-group">
                                  {!! Form::password('password_confirmation',array('class'=>'form-control','data-parsley-equalto'=>'#txtPassword','data-parsley-equalto-message'=>"Passwords do not match!",'placeholder'=>'Confirm Password')) !!}
                                </div>
                                <hr>
                                <h4 class="orange-text">Company Details</h4>
                                <div class="form-group">
                                    {!! Form::text('company_name', null, ['placeholder'=>'Company Name','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your company name"]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('company_website', null, ['placeholder'=>'Company Website','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your company website"]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('company_email', null, ['placeholder'=>'Company Email/s','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter at least one company email"]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('company_address', null, ['placeholder'=>'Company Address','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your Company Address"]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('invoice_address', null, ['placeholder'=>'Invoice Address','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your invoice Address"]) !!}
                                </div>

                                <div class="form-group">
                                    {!!Form::select('country', $countries ,null, ['placeholder' => 'Select Country', 'class'=>'form-control', 'required'=>'', 'data-parsley-required-message'=>'Select your company Country','id'=>'country_select'])!!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('company_city', null, ['placeholder'=>'City','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your City"]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('company_zip', null, ['placeholder'=>'Zip/Postal Code','class' => 'form-control number','required'=>'','data-parsley-required-message'=>"Please enter your Zip/Postal Code",'data-parsley-type'=>'number']) !!}
                                </div>
                                <hr>
                                <h4 class="orange-text">Contact Details</h4>
                                <div class="form-group">
                                    {!! Form::text('full_name', null, ['placeholder'=>'Full Name','class' => 'form-control ','required'=>'','data-parsley-required-message'=>"Please enter Contact Person Name"]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::text('position', null, ['placeholder'=>'Position/Title','class' => 'form-control ','required'=>'','data-parsley-required-message'=>"Please enter Position/Title"]) !!}
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::text('area_code', null, ['class'=>'form-control','readOnly'=>'','id'=>'area_code']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            {!! Form::text('phone_number', null, ['placeholder'=>'Phone Number','class' => 'form-control numeric','required'=>'','data-parsley-required-message'=>"Please enter phone number",'maxlength'=>'15']) !!}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row text-center"><h4 class="orange-text">Terms and Conditions</h4></div>
                                <div class="col-md-12">
                                    @include('partials._terms')
                                </div>
                                <div class="col-md-12 agree-panel text-center">
                                    <p class="agree">By Clicking the Submit button, you agree on our terms and conditions.</p>
                                </div>
                                <div class="col-md-12">
                                <p>
                                Please check your email after completing the registration to activate your account, please check also your spam folder. Thank you.
                                </p>
                                </div>
                                <div class="col-md-2 col-md-offset-5 submit-btn">
                                    {!! Form::button('Submit', ['type'=>'submit','class' => 'btn btn-success']) !!}
                                </div>
                                
                            {!!Form::close()!!}
                        </div>
                    </div>
                    
              </div>
            </div>
        </div>
        
    </div>
@endsection

@section('scripts')
	{!! Html::script('/js/register/index.js') !!}
@endsection
