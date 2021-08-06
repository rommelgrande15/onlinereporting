<div id="modalInputNewCat" class="modal fade" role="dialog">
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
                {!! Form::label('new_cat_other', 'Product Category') !!}
                {!! Form::text('new_cat_other', null, ['class' => 'form-control create_new_cat']) !!}
            </div>
          </div>
          <div class="col-md-12">
              <div class="form-group">
                  {!! Form::label('new_sub_cat_other', 'Product Sub-category') !!}
                  {!! Form::text('new_sub_cat_other', null, ['class' => 'form-control create_new_cat']) !!}
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        {!! Form::button('<i class="fa fa-ban"></i> Close', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
        {!! Form::button('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-success','id'=>'btn-save-new-cat',]) !!}
      </div>
       </form>
    </div>

  </div>
</div>
  
