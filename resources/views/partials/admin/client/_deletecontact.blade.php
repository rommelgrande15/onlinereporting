<div id="deleteContact" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      {!!Form::open(['data-parsley-validate'=>'', 'route'=>'deletecontact' ])!!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Contact</h4>
      </div>
      <div class="modal-body">
          <p>Are you sure you want to delete this Contact?</p>
          <div class="form-group">
              {!!Form::label('contact_name','Client Name',['class'=>''])!!}
              {!!Form::text('contact_name',null,['class'=>'form-control','id'=>'del_contact_name','readOnly'=>''])!!}
              {!!Form::hidden('contact_id',null,['class'=>'form-control','id'=>'del_contact_id','readOnly'=>''])!!}
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