<div id="cancelInspect" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      {{-- {!!Form::open(['data-parsley-validate'=>'', 'route'=>'deleteclient' ])!!} --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cancel Inspection</h4>
      </div>
      <div class="modal-body">
          <h4>Are you sure you want to cancel this inspection?</h4>
          <div class="form-group">
              {!!Form::label('cancel_client','Client :')!!}
              {!!Form::text('cancel_client',null,['class'=>'form-control','id'=>'cancel_client','readOnly'=>''])!!}
              {!!Form::label('cancel_service','Inspection Service :')!!}
              {!!Form::text('cancel_service',null,['class'=>'form-control','id'=>'cancel_service','readOnly'=>''])!!}
              {!!Form::label('cancel_rn','Report Number :')!!}
              {!!Form::text('cancel_rn',null,['class'=>'form-control','id'=>'cancel_rn','readOnly'=>''])!!}
              {!!Form::hidden('cancel_ins_id',null,['class'=>'form-control','id'=>'cancel_ins_id','readOnly'=>''])!!}
          </div>        
      </div>
      <div class="modal-footer">
        {!! Form::button('No', ['class' => 'btn btn-primary', 'data-dismiss' => "modal"]) !!}
        {!! Form::button('Yes', ['class' => 'btn btn-danger', 'type'=>'button','id' => 'btn_cancel_inspect']) !!}
      </div>
      {{-- {!!Form::close()!!} --}}
    </div>

  </div>
</div>

{{-- <script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
 --}}