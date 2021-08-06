<div id="modalDeletelInspection" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
  
      <!-- Modal content-->
      <div class="modal-content">
        {!!Form::open(['data-parsley-validate'=>''])!!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Inspection</h4>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to Delete this inspection?</p>
            <table class="table table-hover table-bordered">
                <tbody>
                    <tr>
                      <th>Service Type: </th>
                      <td><span id="delete_service"></span></td>
                    </tr>
                    <tr>
                      <th>Factory Name: </th>
                      <td><span id="delete_fac_name"></span></td>
                    </tr>
                    <tr>
                      <th>Inspection Date: </th>
                      <td><span id="delete_ins_date"></span></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <input type="hidden" id="delete_ins_id">
            </div>        
        </div>
        <div class="modal-footer">
         <div class="row">
              <div class="col-md-6">
                  {!! Form::button('No', ['class' => 'btn btn-primary btn-block', 'data-dismiss' => "modal"]) !!}
              </div>
          <div class="col-md-6">
              {!! Form::button('Yes', ['class' => 'btn btn-block btn-danger', 'type'=>'button','id'=>'btn_delete_inspection']) !!}
          </div>
         </div>
        </div>
        {!!Form::close()!!}
      </div>
  
    </div>
  </div>