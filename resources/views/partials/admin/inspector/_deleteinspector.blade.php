<div id="deleteInspectorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      {!!Form::open(['data-parsley-validate'=>'', 'route'=>'deleteinspector' ])!!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Inspector</h4>
      </div>
      <div class="modal-body">
          <p>Are you sure you want to delete this inspector details?</p>
          <div class="form-group">
              {!!Form::hidden('inspector_id',null,['class'=>'form-control','id'=>'del_inspector_id','readOnly'=>''])!!}
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