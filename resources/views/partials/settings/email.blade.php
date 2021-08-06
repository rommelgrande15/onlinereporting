<div class="panel panel-default">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordion" href="#email">
    <h4 class="panel-title">
      Change Email
    </h4>
    </a>
  </div>
  <div id="email" class="panel-collapse collapse in">
    <div class="panel-body">
      <div class="col-md-8">
        {!!Form::open(['data-parsley-validate'=>'','route'=>'updateemail'])!!}
          <div class="form-group">
              {{ Form::label('email', 'Current Email Address', ['class' => '']) }}
              {{ Form::text('email', $user->email, ['placeholder'=>'Email Address','class' => 'form-control','data-parsley-type'=>'email','required'=>'','data-parsley-required-message'=>"Please enter your email address",'data-parsley-type-message'=>'Please enter a valid email address!', 'readOnly'=>'']) }}
          </div>
          <div class="form-group">
              {{ Form::label('new_email', 'New Email Address', ['class' => '']) }}
              {{ Form::text('new_email', null, ['id'=>'txtEmail','placeholder'=>'New Email Address','class' => 'form-control','data-parsley-type'=>'email','required'=>'','data-parsley-required-message'=>"Please enter your email address",'data-parsley-type-message'=>'Please enter a valid email address!']) }}
          </div>
          <div class="form-group">
              {{ Form::label('confirm_email', 'Confirm Email Address', ['class' => '']) }}
              {{ Form::text('confirm_email', null, ['placeholder'=>'Confirm Email Address','class' => 'form-control','data-parsley-type'=>'email','required'=>'','data-parsley-required-message'=>"Please enter your email address",'data-parsley-type-message'=>'Please enter a valid email address!','data-parsley-equalto'=>'#txtEmail','data-parsley-equalto-message'=>"Emails do not match!"]) }}
          </div>
          <div class="">
              {{ Form::button('Change Email Address', ['type'=>'submit','class' => 'btn btn-success']) }}
          </div>
        {!!Form::close()!!}
      </div>
      <div class="col-md-4">
          <div class="alert alert-warning">
            <strong>Warning!</strong> 
              Changing your email address will log you out of the system. 
              You will have to confirm the new email address again. An email with activation code will be sent to your new email.
              Please make sure that you enter a valid and working email address.
          </div>
      </div>
      

    </div>
  </div>
</div>