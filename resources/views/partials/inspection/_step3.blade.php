<div class="row step3">
    <h3>Product Information</h3>
<hr>
<section>
    <div class="col-md-8 product-pane">
        <div class="col-md-12 product-container">

            <div class="panel panel-default">
                  <div class="panel-heading">
                    <span>Product Details</span>
                    <span>
                        <button class="btn btn-danger btn-xs delete-product pull-right" type="button"><i class="fa fa-times"></i></button>
                    </span>
                  </div>
                  <div class="panel-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                   {{ Form::label('product_name', 'Product Name') }}<span class="error-product_name"></span>
                                   <div class="input-group">
                                       {{ Form::select('product_name[]',$products, null, ['class' => 'form-control required products-list product_name', 'placeholder'=>'--Select Product--','data-msg-required'=>"Please select a product",'id'=>'product_name']) }}
                                        <i class="input-group-btn">
                                            {{ Form::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-success','data-toggle'=>"modal", 'data-target'=>'#productModal']) }}
                                        </i>
                                   </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                   {{ Form::label('product_category', 'Category') }}<span class="error-product_category"></span>
                                   {{ Form::select('product_category[]',[], null, ['class' => 'form-control required categories product_category', 'placeholder'=>'--Select Category--',
                                    'data-msg-required'=>"Please select a category",'id'=>'categories']) }}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group aql_prod_qty">
                                   {{ Form::label('product_qty', 'Quantity') }}<span class="error-qty"></span>
                                   <div class="input-group">
                                        {{ Form::text('product_qty', null, ['class' => 'form-control required product_qty','data-msg-required'=>"Please enter a quantity",'disabled'=>'']) }}
                                        <i class="input-group-btn">
                                            {{ Form::button('<i class="fa fa-plus"></i>', ['class' => 'btn btn-success btn-aql-modal','data-toggle'=>"modal"]) }}
                                        </i>
                                   </div>
                                </div>
                                @include('partials.inspection._aql')
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                   {{ Form::label('unit', 'Unit') }}<span class="error-unit"></span>
                                    {{ Form::select('unit[]',[
                                        'piece' => 'Piece/s',
                                        'roll' => 'Roll/s',
                                        'set' => 'Set/s', 
                                        'pair' => 'Pair/s',
                                        'box' => 'Box/es'
                                        ], null, ['class' => 'form-control required unit', 'placeholder'=>'--Select Unit--','data-msg-required'=>"Please select a unit"]) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ Form::label('po_no', 'PO Number') }}<span class="error-po_no"></span>
                                    {{ Form::text('po_no[]', null, ['class' => 'form-control required po_no','data-msg-required'=>"Please enter the PO Number"]) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('cmf', 'Color/Material/Finish') }}<span class="error-cmf"></span>
                                    {{ Form::textarea('cmf[]', null, ['class' => 'form-control required cmf','rows'=>'2']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('shipping_mark', 'Shipping Mark') }}<span class="error-shipping_mark"></span>
                                    {{ Form::textarea('shipping_mark[]', null, ['class' => 'form-control required shipping_mark','rows'=>'2']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    {{ Form::label('brand', 'Brand') }}<span class="error-brand"></span>
                                    {{ Form::text('brand[]', null, ['class' => 'form-control required brand','data-msg-required'=>"Please enter the product brand"]) }}
                                </div>

                                <div class="form-group">
                                    {{ Form::label('tech_specs', 'Technical Specifications/Rating') }}<span class="error-tech_specs"></span>
                                    {{ Form::textarea('tech_specs[]', null, ['class' => 'form-control required tech_specs','rows'=>'2']) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('additional_info', 'Additional Information') }}<span class="error-additional_info"></span>
                                    {{ Form::textarea('additional_info[]', null, ['class' => 'form-control required additional_info','rows'=>'2']) }}
                                </div>
                            </div>
                        </div>
                  </div>
            </div>
            
        </div>
    </div> 

    <div class="col-md-4 photo-upload-pane">
        <div class="form-group table-reponsive">
            {{ Form::label('file', 'Upload Photos') }}
            <div class="col-md-12 dropzone-container file_upload" id="file_upload_container">
                <div class="fallback">
                    <input name="file[]" type="file" id="file" multiple />
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 btn-add-product">
        <button type="button" class="btn btn-success" id="add_product_btn">Add Another Product</button> 
        
        <span class="small-text">(Click to select more product for Inspection)</span>
    </div>

</section>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <button class="btn btn-primary" id="second-back" type="button">Previous</button>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-warning" id="third-next" type="button">Next</button>
        </div>
    </div>
</div>
@include('partials._confirm')
</div>