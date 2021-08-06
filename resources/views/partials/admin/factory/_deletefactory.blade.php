<div id="deleteFactory" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      {!!Form::open(['data-parsley-validate'=>'', 'route'=>'postdeletefactory' ])!!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Factory</h4>
      </div>
      <div class="modal-body">
          <p>Are you sure you want to delete this Factory?</p>
          <div class="form-group">
              {!!Form::label('factory_name','Factory Name',['class'=>''])!!}
              {!!Form::text('factory_name',null,['class'=>'form-control','id'=>'del_factory_name','readOnly'=>''])!!}
              {!!Form::hidden('factory_id',null,['class'=>'form-control','id'=>'del_factory_id','readOnly'=>''])!!}
          </div>        
      </div>
      <div class="modal-footer">
        {!! Form::button('No', ['class' => 'btn btn-primary', 'data-dismiss' => "modal"]) !!}
        {!! Form::button('Yes', ['class' => 'btn btn-danger', 'type'=>'submit']) !!}
      </div>
      {!!Form::close()!!}
    </div>

  </div>
</div>