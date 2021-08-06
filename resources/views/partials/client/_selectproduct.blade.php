<div id="modalSelectProduct" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <form data-parsley-validate=''>
          {!!csrf_field()!!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Select Product</h4>
        </div>
        <div class="modal-body">

          <table class="table table-hover table-bordered" id="table_select_product">
            <thead>
              <tr>
                {{-- <th colspan="4" class="text-center">Select Product</th> --}}
                <th>Product Name</th>
                <th>Brand</th>
                <th>Model/Part No.</th>
                <th>Select</th>
              </tr>
            </thead>
            <tbody>
              {{-- <tr>
                <td>Product Name</td>
                <td>Brand</td>
                <td>Category</td>
                <td>Select</td>
              </tr> --}}
              {{-- <tr></tr> --}}
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
  
