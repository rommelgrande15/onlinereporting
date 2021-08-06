@extends('layouts.master')
@section('title','Dashboard')
@section('stylesheets')
  {{ Html::style('/css/profile/index.css') }}
@endsection
<!-- need to update  -->
@section('content')
    <div class="row">
    	<div class="col-md-3">
    		@include('partials._sidebar')
    	</div>
    	<div class="col-md-9">
    		<div class="panel panel-default panel-primary main-content-panel">
				<div class="panel-heading heading-text">My Profile</div>
				<div class="panel-body">
          <div class="col-md-8">
            {!!Form::open(['data-parsley-validate'=>'', 'route'=>'updateprofile'])!!}
              <h4 class="orange-text">Account Details</h4>
              <div class="form-group">
                <div class="input-group">
                    {{ Form::text('email', $user->email, ['placeholder'=>'Email Address','class' => 'form-control','data-parsley-type'=>'email','required'=>'','data-parsley-required-message'=>"Please enter your email address",'data-parsley-type-message'=>'Please enter a valid email address!', 'disabled'=>'true']) }}
                  <div class="input-group-btn">
                  {{ Form::button('<i class="glyphicon glyphicon-pencil"></i> Change Email', ['type'=>'button','class' => 'btn btn-warning settings_btn']) }}
                  </div>
                </div>                
              </div>

              <div class="form-group">
                <div class="input-group">
                    {{ Form::text('username', $user->username, ['placeholder'=>'Username','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter a username",'disabled'=>'true']) }}
                  <div class="input-group-btn">
                  {{ Form::button('<i class="glyphicon glyphicon-pencil"></i> Change Username', ['type'=>'button','class' => 'btn btn-warning settings_btn']) }}
                  </div>
                </div>                
              </div>
              <hr>
              <h4 class="orange-text">Company Details</h4>
              <div class="form-group">
                  {{ Form::text('company_name', $company->company_name, ['placeholder'=>'Company Name','class' => 'form-control disabled','required'=>'','data-parsley-required-message'=>"Please enter your company name"]) }}
              </div>

              <div class="form-group">
                  {{ Form::text('company_website', $company->company_website, ['placeholder'=>'Company Website','class' => 'form-control disabled','required'=>'','data-parsley-required-message'=>"Please enter your company website"]) }}
              </div>

              <div class="form-group">
                  {{ Form::text('company_email', $company->company_email, ['placeholder'=>'Company Email/s','class' => 'form-control disabled','required'=>'','data-parsley-required-message'=>"Please enter at least one company email"]) }}
              </div>

              <div class="form-group">
                  {{ Form::text('company_address', $company->company_address, ['placeholder'=>'Company Address','class' => 'form-control disabled','required'=>'','data-parsley-required-message'=>"Please enter your Company Address"]) }}
              </div>

              <div class="form-group">
                  {{ Form::text('invoice_address', $company->invoice_address, ['placeholder'=>'Invoice Address','class' => 'form-control disabled','required'=>'','data-parsley-required-message'=>"Please enter your invoice Address"]) }}
              </div>

              <div class="form-group">
                  {{Form::select('country', $countries , $company->country_code, ['placeholder' => 'Select Country', 'class'=>'form-control disabled', 'required'=>'', 'data-parsley-required-message'=>'Select your company Country','id'=>'country_select'])}}
              </div>

              <div class="form-group">
                  {{ Form::text('company_city', $company->company_city, ['placeholder'=>'City','class' => 'form-control disabled','required'=>'','data-parsley-required-message'=>"Please enter your City"]) }}
              </div>

              <div class="form-group">
                  {{ Form::text('company_zip', $company->company_zip, ['placeholder'=>'Zip/Postal Code','class' => 'form-control number disabled','required'=>'','data-parsley-required-message'=>"Please enter your Zip/Postal Code"]) }}
              </div>
              <hr>
              <h4 class="orange-text">Contact Details</h4>
              <div class="form-group">
                  {{ Form::text('full_name', $company->full_name, ['placeholder'=>'Full Name','class' => 'form-control disabled','required'=>'','data-parsley-required-message'=>"Please enter Contact Person Name"]) }}
              </div>

              <div class="form-group">
                  {{ Form::text('position', $company->position, ['placeholder'=>'Position/Title','class' => 'form-control disabled','required'=>'','data-parsley-required-message'=>"Please enter Position/Title"]) }}
              </div>

              <div class="row">
                  <div class="col-md-3">
                      <div class="form-group">
                          {{ Form::text('area_code', $company->country_code, ['class'=>'form-control disabled','readOnly'=>'','id'=>'area_code']) }}
                      </div>
                  </div>
                  <div class="col-md-9">
                      <div class="form-group">
                          {{ Form::text('phone_number', $company->phone_number, ['placeholder'=>'Phone Number','class' => 'form-control disabled numeric','required'=>'','data-parsley-required-message'=>"Please enter phone number",'maxlength'=>'15']) }}
                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-md-9">
                  {{ Form::button('Cancel', ['type'=>'button','class' => 'btn btn-danger','id'=>'cancel_btn']) }}
                  {{ Form::button('Save Changes', ['type'=>'submit','class' => 'btn btn-info','id'=>'save_btn']) }} <!--change this button type to submit later-->
                  {{ Form::button('Update Profile Information', ['type'=>'button','class' => 'btn btn-success', 'id'=>'update_btn']) }}
                </div>
                  
              </div>
              
              
          {!!Form::close()!!}
          </div>
					 
				</div>  
			</div>
    	</div>
    </div>
@endsection

@section('scripts')
	{{ Html::script('/js/profile/index.js') }}
@endsection
