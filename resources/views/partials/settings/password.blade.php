<div class="panel panel-default">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordion" href="#password">
    <h4 class="panel-title">
      Change Password
    </h4>
    </a>
  </div>
  <div id="password" class="panel-collapse collapse">
    <div class="panel-body">
      <div class="col-md-8">
        {!!Form::open(['data-parsley-validate'=>'','route'=>'updatepassword'])!!}
          <div class="form-group">
              {{ Form::label('old_password', 'Current Password', ['class' => '']) }}
              {{ Form::password('old_password', ['placeholder'=>'Password','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your password"]) }}
          </div>
          <div class="form-group">
              {{ Form::label('password', 'New Password', ['class' => '']) }}
              {{ Form::password('password', ['id'=>'txtPassword','placeholder'=>'New Password','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your password"]) }}
          </div>
          <div class="form-group">
              {{ Form::label('password_confirmation', 'Confirm Password', ['class' => '']) }}
              {{ Form::password('password_confirmation', ['placeholder'=>'Confirm Password','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your password",'data-parsley-equalto'=>'#txtPassword','data-parsley-equalto-message'=>"Passwords do not match!"]) }}
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
              You will have to login again!
          </div>
      </div>
      

    </div>
  </div>
</div>