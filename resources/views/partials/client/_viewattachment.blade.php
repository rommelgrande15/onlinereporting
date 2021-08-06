<div id="modalViewAttachment" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <form data-parsley-validate=''>
          {!!csrf_field()!!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">View Product Attachments</h4>
        </div>
        <div class="modal-body">

          <table class="table table-hover table-bordered" id="view_att_ps">
            <tbody>
              <tr>
                  <th colspan="4">Product Photo :</th>
              </tr>
            </tbody>
          </table>
          <table class="table table-hover table-bordered" id="view_att_td">
            <tbody>
              <tr>
                  <th colspan="4">Product Spec / Technical Details:</th>
              </tr>
            </tbody>
          </table>
          <table class="table table-hover table-bordered" id="view_att_aw">
            <tbody>
              <tr>
                  <th colspan="4">Art Work :</th>
              </tr>
            </tbody>
          </table>
          <table class="table table-hover table-bordered" id="view_att_sm">
            <tbody>
              <tr>
                  <th colspan="4">Shipping Mark :</th>
              </tr>
            </tbody>
          </table>
          <table class="table table-hover table-bordered" id="view_att_pd">
            <tbody>
              <tr>
                  <th colspan="4">Packing Details :</th>
              </tr>
            </tbody>
          </table>
          <table class="table table-hover table-bordered" id="view_att_pp">
            <tbody>
              <tr>
                  <th colspan="4">Other Photos :</th>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          {!! Form::button('<i class="fa fa-ban"></i> Close', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
        </div>
         </form>
      </div>
  
    </div>
  </div>
  
