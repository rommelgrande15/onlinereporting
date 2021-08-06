<div  class="modal fade modalCategory" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <form data-parsley-validate=''>
          {!!csrf_field()!!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Input New Category</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                  {!! Form::label('prod_category', 'Product Category') !!}
                  {!! Form::text('prod_category', null, ['class' => 'form-control prod_category']) !!}
              </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('prod_sub_category', 'Product Sub-category') !!}
                    {!! Form::text('prod_sub_category', null, ['class' => 'form-control prod_sub_category']) !!}
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          {!! Form::button('<i class="fa fa-ban"></i> Close', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
          {!! Form::button('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-success btn_save_category']) !!}
        </div>
         </form>
      </div>
  
    </div>
  </div>
    
  