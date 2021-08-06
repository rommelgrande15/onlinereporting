<div id="updateProductModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View/Edit Product</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('edit_product_name', 'Product Name') }}
                {{ Form::text('edit_product_name', null, ['id'=>'edit_product_name','class' => 'form-control required-field-product readonly']) }}
                {{ Form::hidden('edit_product_id', null, ['id'=>'edit_product_id','class' => 'form-control required-field-product readonly']) }}
            </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('edit_product_category', 'Product Category') }}
                    {{ Form::select('edit_product_category', [] , null, ['id'=>'edit_product_category','class' => 'form-control categories required-field-product readonly','placeholder'=>'--Select Category--']) }}
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                  {{ Form::label('edit_product_unit', 'Unit') }}
                  {{ Form::select('number', [
                    'piece' => 'Piece/s',
                    'roll' => 'Roll/s',
                    'set' => 'Set/s', 
                    'pair' => 'Pair/s',
                    'box' => 'Box/es',
                  ], null, ['id'=>'edit_product_unit','class' => 'readonly form-control required-field-product','placeholder'=>'--Select Unit--']) }}
              </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  {{ Form::label('edit_po_no', 'PO Number') }}
                  {{ Form::text('edit_po_no', null, ['id'=>'edit_po_no','class' => 'readonly form-control required-field-product']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  {{ Form::label('edit_brand', 'Brand') }}
                  {{ Form::text('edit_brand', null, ['id'=>'edit_brand','class' => 'readonly form-control required-field-product']) }}
                </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('edit_cmf', 'Color/Material/Finish') }}
                  {{ Form::textarea('edit_cmf', null, ['id'=>'edit_cmf','class' => 'readonly form-control required-field-product', 'rows'=>'3']) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('edit_tech_specs', 'Technical Specifications/Rating') }}
                  {{ Form::textarea('edit_tech_specs', null, ['id'=>'edit_tech_specs','class' => ' readonly form-control required-field-product', 'rows'=>'3']) }}
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('edit_shipping_mark', 'Shipping Mark') }}
                  {{ Form::textarea('edit_shipping_mark', null, ['id'=>'edit_shipping_mark','class' => 'readonly form-control required-field-product', 'rows'=>'3']) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('edit_additional_product_info', 'Additional Product Info') }}
                  {{ Form::textarea('edit_additional_product_info', null, ['id'=>'edit_additional_product_info','class' => 'readonly form-control required-field-product', 'rows'=>'3']) }}
                </div>
              </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="close_product_modal">Close</button>
        <button type="button" class="btn btn-success" id="edit_product_details">Edit Details</button>
        <button type="button" class="btn btn-primary" id="update_product_details">Save Changes</button>

      </div>
    </div>

  </div>
</div>
