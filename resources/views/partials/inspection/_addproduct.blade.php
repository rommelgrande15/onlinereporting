<div id="productModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Product</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('new_product_name', 'Product Name') }}
                {{ Form::text('new_product_name', null, ['id'=>'new_product_name','class' => 'form-control required-field-product']) }}
            </div>
            </div>
            <div class="col-md-6">
                 <div class="form-group">
                    {{ Form::label('new_product_category', 'Product Category') }}
                    {{ Form::select('new_product_category', [] , null, ['id'=>'new_product_category','class' => 'form-control categories required-field-product','placeholder'=>'--Select Category--']) }}
                </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
                  {{ Form::label('new_product_unit', 'Unit') }}
                  {{ Form::select('number', [
                    'piece' => 'Piece/s',
                    'roll' => 'Roll/s',
                    'set' => 'Set/s', 
                    'pair' => 'Pair/s',
                    'box' => 'Box/es',
                  ], null, ['id'=>'new_product_unit','class' => 'form-control required-field-product','placeholder'=>'--Select Unit--']) }}
              </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  {{ Form::label('new_po_no', 'PO Number') }}
                  {{ Form::text('new_po_no', null, ['id'=>'new_po_no','class' => 'form-control required-field-product']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  {{ Form::label('new_brand', 'Brand') }}
                  {{ Form::text('new_brand', null, ['id'=>'new_brand','class' => 'form-control required-field-product']) }}
                </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('new_cmf', 'Color/Material/Finish') }}
                  {{ Form::textarea('new_cmf', null, ['id'=>'new_cmf','class' => 'form-control required-field-product', 'rows'=>'3']) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('new_tech_specs', 'Technical Specifications/Rating') }}
                  {{ Form::textarea('new_tech_specs', null, ['id'=>'new_tech_specs','class' => 'form-control required-field-product', 'rows'=>'3']) }}
                </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('new_shipping_mark', 'Shipping Mark') }}
                  {{ Form::textarea('new_shipping_mark', null, ['id'=>'new_shipping_mark','class' => 'form-control required-field-product', 'rows'=>'3']) }}
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  {{ Form::label('new_additional_product_info', 'Additional Product Info') }}
                  {{ Form::textarea('new_additional_product_info', null, ['id'=>'new_additional_product_info','class' => 'form-control required-field-product', 'rows'=>'3']) }}
                </div>
              </div>
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_product_details">Save Product</button>
      </div>
    </div>

  </div>
</div>
