<div class="modal fade aqlModal" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Product AQL and Quantity</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
               <label for="qty">Quantity</label>
               <input type="text" name="qty[]" id="qty" class="form-control numeric qty aql_field" onkeypress="return isNumber(event)">
            </div>
            <div class="row">
              <div class="col-md-6">
                  <label for="gen_inspection_level">General Level</label>
                  <select name="gen_inspection_level[]" id="gen_inspection_level" class="form-control gen_inspection_level aql_field">
                    <option value="">--</option>
                    <option value="N1">N1</option>
                    <option value="N2">N2</option>
                    <option value="N3">N3</option>
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="gen_sample_size">Sample Size</label>
                  <input type="text" name="gen_sample_size[]" id="gen_sample_size" class="form-control gen_sample_size aql_field" readonly>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                  <label for="special_inspection_level">Special Level</label>
                  <select name="special_inspection_level[]" id="special_inspection_level" class="form-control special_inspection_level aql_field ">
                    <option value="">--</option>
                    <option value="S1">S1</option>
                    <option value="S2">S2</option>
                    <option value="S3">S3</option>
                    <option value="S4">S4</option>
                  </select>
              </div>
              <div class="col-md-6">
                  <label for="special_sample_size">Sample Size</label>
                  <input type="text" name="special_sample_size[]" id="special_sample_size" class="form-control special_sample_size aql_field" readonly>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <label>AQL</label>
              <table class="table table-bordered">
                  <tbody><tr>
                    <td><label class="control-label">Minor</label></td>
                    <td>
                      <select class="form-control aql_select aql_field minor" name="minor[]" id="min"></select>
                    </td>
                  </tr>
                  <tr>
                    <td><label class="control-label">Major</label></td>
                    <td>
                      <select class="form-control aql_select major aql_field" name="major[]" id="maj"></select>
                    </td>
                  </tr>
                  <tr>
                    <td><label class="control-label">Crtitical</label></td>
                    <td>
                      <select class="form-control aql_field crit" name="crit[]" id="crit">
                        <option value="" selected="">--</option>
                        <option value="0">0</option>
                      </select>
                    </td>
                  </tr>
                  <tr>
                    <td><label class="control-label">Functional</label></td>
                    <td><select class="form-control functional aql_select aql_field" name="functional[]" id="fn"></select>
                    </td>
                  </tr>
                </tbody>
              </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-aql-confirm">Confirm</button>
      </div>
    </div>
  </div>
</div>
