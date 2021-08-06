<div id="deleteSalesModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      {!!Form::open(['data-parsley-validate'=>'', 'route'=>'deletesales' ])!!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Sales</h4>
      </div>
      <div class="modal-body">
          <p>Are you sure you want to delete this sales details?</p>
          <div class="form-group">
              {!!Form::hidden('sales_id',null,['class'=>'form-control','id'=>'del_sales_id','readOnly'=>''])!!}
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