<div id="deleteInspect" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      {{-- {!!Form::open(['data-parsley-validate'=>'', 'route'=>'deleteclient' ])!!} --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Inspection</h4>
      </div>
      <div class="modal-body">
          <h4>Are you sure you want to delete this inspection?</h4>
          <div class="form-group">
              {!!Form::label('delete_client','Client :')!!}
              {!!Form::text('delete_client',null,['class'=>'form-control','id'=>'delete_client','readOnly'=>''])!!}
              {!!Form::label('delete_service','Inspection Service :')!!}
              {!!Form::text('delete_service',null,['class'=>'form-control','id'=>'delete_service','readOnly'=>''])!!}
              {!!Form::label('delete_rn','Report Number :')!!}
              {!!Form::text('delete_rn',null,['class'=>'form-control','id'=>'delete_rn','readOnly'=>''])!!}
              {!!Form::hidden('delete_ins_id',null,['class'=>'form-control','id'=>'delete_ins_id','readOnly'=>''])!!}
          </div>        
      </div>
      <div class="modal-footer">
        {!! Form::button('No', ['class' => 'btn btn-primary', 'data-dismiss' => "modal"]) !!}
        {!! Form::button('Yes', ['class' => 'btn btn-danger', 'type'=>'button','id' => 'btn_del_inspect']) !!}
      </div>
      {{-- {!!Form::close()!!} --}}
    </div>

  </div>
</div>

{{-- <script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
 --}}