<div class="panel panel-default">
  <div class="panel-heading">
    <a data-toggle="collapse" data-parent="#accordion" href="#username">
    <h4 class="panel-title">
      Change Username
    </h4>
    </a>
  </div>
  <div id="username" class="panel-collapse collapse ">
    <div class="panel-body">
      <div class="col-md-8">
        {!!Form::open(['data-parsley-validate'=>'','route'=>'updateusername'])!!}
          <div class="form-group">
              {{ Form::label('username', 'Username', ['class' => '']) }}
              {{ Form::text('username', $user->username, ['placeholder'=>'Username','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your username"]) }}
          </div>
          <div class="">
              {{ Form::button('Change Email Address', ['type'=>'submit','class' => 'btn btn-success']) }}
          </div>
        {!!Form::close()!!}
      </div>
        
    </div>
  </div>
</div>