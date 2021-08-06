<div id="modalCancelInspection" class="modal fade" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      <div class="modal-content">
        {!!Form::open(['data-parsley-validate'=>''])!!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cancel Inspection</h4>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to cancel inspection?</p>
            <table class="table table-hover table-bordered">
                <tbody>
                    <tr>
                      <th>Service Type: </th>
                      <td><span id="cancel_service"></span></td>
                    </tr>
                    <tr>
                      <th>Factory Name: </th>
                      <td><span id="cancel_fac_name"></span></td>
                    </tr>
                    <tr>
                      <th>Inspection Date: </th>
                      <td><span id="cancel_ins_date"></span></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <input type="hidden" id="cancel_ins_id">
            </div>        
        </div>
        <div class="modal-footer">
          {!! Form::button('No', ['class' => 'btn btn-primary', 'data-dismiss' => "modal"]) !!}
          {!! Form::button('Yes', ['class' => 'btn btn-danger', 'type'=>'button','id'=>'btn_cancel_inspection']) !!}
        </div>
        {!!Form::close()!!}
      </div>
  
    </div>
  </div>