<div id="modalInputNewSubCat2" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <form data-parsley-validate=''>
          {!!csrf_field()!!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Input New Sub-Category</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('s_new_sub_cat_other2', 'Product Sub-category') !!}
                    {!! Form::text('s_new_sub_cat_other2', null, ['class' => 'form-control create_new_scat2']) !!}
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          {!! Form::button('<i class="fa fa-ban"></i> Close', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
          {!! Form::button('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-success','id'=>'btn-save-new-scat2',]) !!}
        </div>
         </form>
      </div>
  
    </div>
  </div>
    
  