<div id="editProduct" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<form data-parsley-validate=''>
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Product</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden" name="edit_client_code_product" id="edit_client_code_product" value="{{$client_code}}">
						<input type="hidden" name="edit_product_id" id="edit_product_id">
						<input type="hidden" name="edit_product_nameHide" id="edit_product_nameHide">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="factory_name">Product Name</label><span class="error_messages product_error"></span>
									<input type="text" name="edit_product_name" class="form-control product_input edit_product" id="edit_product_name" required data-parsley-required-message="Please enter a Product name!" data-parsley-errors-container=".product_error">
									<div id="productRequired2" style="display:none">
										<p style="color:red;">This field is required!</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_model_number">Model/Part no.</label>
									<input type="text" name="edit_model_number" class="form-control edit_product" id="edit_model_number" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_supplier_item_no">Supplier item no.</label>
									<input type="text" name="edit_supplier_item_no" class="form-control" id="edit_supplier_item_no" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="email">Brand</label><span class="error_messages brand_error"></span>
									<div id="brand_container">
									</div>
									<input type="text" name="new_brand" class="form-control product_input new_brand edit_product" id="edit_brand" required data-parsley-required-message="Please enter the Product Brand!" data-parsley-errors-container=".brand_error">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="factory_country">Unit</label><span class="error_messages unit_error"></span>
									<select class="form-control unit edit_product" id="edit_unit" name="unit" required data-parsley-required-message="Please select a unit!" data-parsley-errors-container=".unit_error">
										<option selected="selected" value="">Select a unit</option>
										<option value="piece">Piece/s</option>
										<option value="roll">Roll/s</option>
										<option value="set">Set/s</option>
										<option value="pair">Pair/s</option>
										<option value="piece">Box/es</option>
									</select>
								</div>
							</div>		
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('edit_product_category', 'Product Category') !!}
									<div class="input-group">
										{!! Form::select('edit_product_category', $p_category, null, ['class' => 'form-control product_category edit_product', 'placeholder'=>'Select Product Category']) !!}
										<div class="input-group-btn">
											<button class="btn btn-primary btn-add-cat-modal" type="button" title="Add new category">
												<i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
								</div>

							</div>
							<div class="col-md-6">
								<div class="form-group" id="sortt">
									{!! Form::label('edit_product_sub_category', 'Product Sub-Category') !!}
									<div class="input-group">
										<select class="form-control product_sub_category edit_product" id="edit_product_sub_category" name="edit_product_sub_category">
											<option selected="selected" value="">Select a Category</option>
										</select>
										<div class="input-group-btn">
											<button class="btn btn-primary btn-add-sub-cat-modal-edit" type="button" title="Add new sub-category">
												<i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
								</div>
								{{-- <div class="form-group">
									<label for="edit_product_sub_category">Product Sub-category</label><span class="error_messages category_error"></span>
									<select class="form-control product_sub_category edit_product" id="edit_product_sub_category" name="edit_product_sub_category" >
										<option selected="selected" value="">Select a Category</option>
									</select>
								</div> --}}
							</div>			
							
							<div id="logistic_fields">
								<div class="col-md-12">
									<h4 class="text-center">Logistic Data</h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-left"><button type="button" class="btn btn-primary btn-block edit-btn-logistics" id="edit_btn_log_prod">Product</button></h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-left"><button type="button" class="btn btn-primary btn-block edit-btn-logistics" id="edit_btn_log_retail">Retail Pack</button></h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-left"><button type="button" class="btn btn-primary btn-block edit-btn-logistics" id="edit_btn_log_inner">Inner Carton</button></h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-left"><button type="button" class="btn btn-primary btn-block edit-btn-logistics" id="edit_btn_log_export">Export Carton</button></h4>
								</div>
							</div>

							<div id="edit_logistic_product" class="edit_logistic_div hidden">
								<div class="col-md-12">
									<h4 class="text-center">Product</h4>
								</div>
								<div class="col-md-12">
									<hr/>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="edit_prod_length">Length (cm)</label>
										<input type="text" name="edit_prod_length" class="form-control" id="edit_prod_length">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="edit_prod_width">Width (cm)</label>
										<input type="text" name="edit_prod_width" class="form-control" id="edit_prod_width">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="edit_prod_height">Height (cm)</label>
										<input type="text" name="edit_prod_height" class="form-control" id="edit_prod_height">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="edit_prod_diameter">Diameter (cm)</label>
										<input type="text" name="edit_prod_diameter" class="form-control" id="edit_prod_diameter">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="edit_prod_weight">Weight (kg)</label>
										<input type="text" name="edit_prod_weight" class="form-control" id="edit_prod_weight">
									</div>
								</div>
								<div class="col-md-12">
									<hr/>
								</div>
							</div>
						<div id="edit_logistic_retail" class="edit_logistic_div hidden">
							<div class="col-md-12">
								<h4 class="text-center">Retail Pack</h4>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_retail_length">Length (cm)</label>
									<input type="text" name="edit_retail_length" class="form-control" id="edit_retail_length">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_retail_width">Width (cm)</label>
									<input type="text" name="edit_retail_width" class="form-control" id="edit_retail_width">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_retail_height">Height (cm)</label>
									<input type="text" name="edit_retail_height" class="form-control" id="edit_retail_height">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_retail_diameter">Diameter (cm)</label>
									<input type="text" name="edit_retail_diameter" class="form-control" id="edit_retail_diameter">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_retail_weight">Weight (kg)</label>
									<input type="text" name="edit_retail_weight" class="form-control" id="edit_retail_weight">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_retail_qty">Retail Box Quantity</label>
									<input type="number" name="edit_retail_qty" class="form-control" id="edit_retail_qty">
								</div>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
						</div>
						<div id="edit_logistic_inner" class="edit_logistic_div hidden">
							<div class="col-md-12">
								<h4 class="text-center">Inner Carton</h4>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_inner_length">Length (cm)</label>
									<input type="text" name="edit_inner_length" class="form-control" id="edit_inner_length">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_inner_width">Width (cm)</label>
									<input type="text" name="edit_inner_width" class="form-control" id="edit_inner_width">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_inner_height">Height (cm)</label>
									<input type="text" name="edit_inner_height" class="form-control" id="edit_inner_height">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_inner_diameter">Diameter (cm)</label>
									<input type="text" name="edit_inner_diameter" class="form-control" id="edit_inner_diameter">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_inner_weight">Weight (kg)</label>
									<input type="text" name="edit_inner_weight" class="form-control" id="edit_inner_weight">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_inner_qty">Inner Box Quantity</label>
									<input type="number" name="edit_inner_qty" class="form-control" id="edit_inner_qty">
								</div>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
						</div>
						<div id="edit_logistic_export" class="edit_logistic_div hidden">
							<div class="col-md-12">
								<h4 class="text-center">Export Carton</h4>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_export_length">Length (cm)</label>
									<input type="text" name="edit_export_length" class="form-control" id="edit_export_length">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_export_width">Width (cm)</label>
									<input type="text" name="edit_export_width" class="form-control" id="edit_export_width">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_export_height">Height (cm)</label>
									<input type="text" name="edit_export_height" class="form-control" id="edit_export_height">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_export_diameter">Diameter (cm)</label>
									<input type="text" name="edit_export_diameter" class="form-control" id="edit_export_diameter">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_export_weight">Weight (kg)</label>
									<input type="text" name="edit_export_weight" class="form-control" id="edit_export_weight">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_export_qty">Export Box Quantity</label>
									<input type="number" name="edit_export_qty" class="form-control" id="edit_export_qty">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_export_max_weight">Max. weight of export carton (kg)</label>
									<input type="text" name="edit_export_max_weight" class="form-control" id="edit_export_max_weight">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="edit_export_cbm">Export Carton CBM</label>
									<input type="text" name="edit_export_cbm" class="form-control" id="edit_export_cbm">
								</div>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
						</div>

						{{-- <div class="col-md-12">
							<div class="form-group">
								<label for="edit_grd">Goods Ready Date</label>
								<input type="text" name="edit_grd" class="form-control" id="edit_grd">
							</div>
						</div> --}}
						<div class="col-md-12">
							<div class="form-group">
								<label for="edit_item_desc">Item Description</label>
								<textarea name="edit_item_desc" class="form-control" id="edit_item_desc"></textarea>
							</div>
						</div>

						</div>

						<div class="row">

							{{-- <div class="col-md-6">
								<div class="form-group">
									<label for="edit_product_number">Product Number</label><span class="error_messages model_error"></span>
									<div id="model_num_container">
									</div>
									<input type="text" name="edit_product_number" class="form-control product_input new_model_number edit_product" id="edit_product_number" required data-parsley-required-message="Please enter the Model Number!" data-parsley-errors-container=".model_error">


									<div id="productRequired6" style="display:none">
										<p style="color:red;">This field is required!</p>
									</div>
								</div>
							</div> --}}

						</div>
						<div class="row">
							<div class="col-md-12">
								<label>Product Photo :</label>
								<select class="form-control edit_product" name="dl_prod_spec" id="id_edit_prod_spec" required autocomplete="off" onchange="disableEditForms('prod_spec')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload File</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_edit_prod_spec" style="border:1px solid #ccc;"></div>
							</div>

							<div class="col-md-12">
								<label>Product Spec / Technical Details :</label>
								<select class="form-control edit_product" name="dl_tech_details" id="id_edit_tech_details" required autocomplete="off" onchange="disableEditForms('tech_details')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload File</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_edit_tech_details" style="border:1px solid #ccc;"></div>
							</div>

							<div class="col-md-12">
								<label>Art Work :</label>
								<select class="form-control edit_product" name="dl_art_work" id="id_edit_art_work" required autocomplete="off" onchange="disableEditForms('art_work')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload File</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_edit_art_work" style="border:1px solid #ccc;"></div>
							</div>

							<div class="col-md-12">
								<label>Shipping Mark :</label>
								<select class="form-control edit_product" name="dl_shipping_mark" id="id_edit_shipping_mark" required autocomplete="off" onchange="disableEditForms('shipping_mark')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload File</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_edit_shipping_mark" style="border:1px solid #ccc;"></div>
							</div>

							<div class="col-md-12">
								<label>Packing Details :</label>
								<select class="form-control edit_product" name="dl_packing" id="id_edit_packing" required autocomplete="off" onchange="disableEditForms('packing')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload File</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_edit_packing" style="border:1px solid #ccc;"></div>
							</div>




							<div class="col-md-12">
								<label>Other Photos :</label>
								<select class="form-control edit_product" name="dl_photo_files" id="id_edit_photo_files" required autocomplete="off" onchange="disableEditForms('photo_files')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload File</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_edit_photo_files" style="border:1px solid #ccc;"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="new_cmf">Additional Information</label><span class="error_messages specs_error"></span>
									<div id="addtl_container">
									</div>
									<input type="text" name="new_additional_product_info" class="form-control product_input new_additional_product_info" id="edit_additional_product_info" required data-parsley-required-message="Please enter dditional information or put N/A if not applicable" data-parsley-errors-container=".brand_error">

									<div id="productRequired11" style="display:none">
										<p style="color:red;">This field is required!</p>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" id="edit-show-error" style="display:none;">
								<div class="alert alert-danger alert-dismissable" role="alert">
									<a href="#" class="close" id="close-err-e-prod">&times;</a>
									<strong>Error</strong> Please fill up the required fields.
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal" ,'id'=>'close_modal']) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save Product Details', ['class' => 'btn btn-success','id'=>'update_product']) !!}
				</div>
			</form>
		</div>

	</div>
</div>


<style>
	.dz-image img {
		width: 100%;
		height: 100%;
	}

</style>
<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dropzone/dropzoneold3.js')}}"></script>

<script>
	Dropzone.autoDiscover = false;

	$(document).ready(function() {

		$("#modalInputNewSubCatEdit").on('hidden.bs.modal', function (event) {
  if ($('.modal:visible').length) {
    $('body').addClass('modal-open');
  }
});

$("#edit_btn_log_prod").click(function (event) {
	if($('#edit_logistic_product').hasClass('hidden')){
		$('.edit_logistic_div').addClass('hidden');
		$('#edit_logistic_product').removeClass('hidden');
		$('.edit-btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.edit_logistic_div').addClass('hidden');
		$('.edit-btn-logistics').removeClass('btn-warning');
	}

});

$("#edit_btn_log_retail").click(function (event) {
	if($('#edit_logistic_retail').hasClass('hidden')){
		$('.edit_logistic_div').addClass('hidden');
		$('#edit_logistic_retail').removeClass('hidden');
		$('.edit-btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.edit_logistic_div').addClass('hidden');
		$('.edit-btn-logistics').removeClass('btn-warning');
	}
});

$("#edit_btn_log_inner").click(function (event) {

	if($('#edit_logistic_inner').hasClass('hidden')){
		$('.edit_logistic_div').addClass('hidden');
		$('#edit_logistic_inner').removeClass('hidden');
		$('.edit-btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.edit_logistic_div').addClass('hidden');
		$('.edit-btn-logistics').removeClass('btn-warning');
	}
	
});

$("#edit_btn_log_export").click(function (event) {
	if($('#edit_logistic_export').hasClass('hidden')){
		$('.edit_logistic_div').addClass('hidden');
		$('#edit_logistic_export').removeClass('hidden');
		$('.edit-btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.edit_logistic_div').addClass('hidden');
		$('.edit-btn-logistics').removeClass('btn-warning');
	}
	
});

		var edit_d1 = "nd";
		var edit_d2 = "nd";
		var edit_d3 = "nd";
		var edit_d4 = "nd";
		var edit_d5 = "nd";
		var edit_d6 = "nd";
		var edit_count;
		var edit_subcount = 0;
		var edit_count2;
		var edit_subcount2 = 0;
		var edit_count3;
		var edit_subcount3 = 0;
		var edit_count4;
		var edit_subcount4 = 0;
		var edit_count5;
		var edit_subcount5 = 0;
		var edit_count6;
		var edit_subcount6 = 0;



		$('#form_edit_prod_spec').hide();
		$('#form_edit_tech_details').hide();
		$('#form_edit_art_work').hide();
		$('#form_edit_shipping_mark').hide();
		$('#form_edit_packing').hide();
		$('#form_edit_photo_files').hide();
		var checker = 0;
		var checker2 = 0;

		function dropzoneupload() {

			if (myDropzone1.getQueuedFiles().length > 0 || myDropzone2.getQueuedFiles().length > 0 || myDropzone3.getQueuedFiles().length > 0 || myDropzone4.getQueuedFiles().length > 0 || myDropzone5.getQueuedFiles().length > 0 || myDropzone6.getQueuedFiles().length > 0) {
				checker2++;
				if (checker2 >= 1) {
					checker++
					console.log("continu");
					/* 	if(myDropzone1.getQueuedFiles().length>0 && checker==1){
					myDropzone1.processQueue();
						} else if(myDropzone2.getQueuedFiles().length>0 && checker==1){
					myDropzone2.processQueue();
						}else if(myDropzone3.getQueuedFiles().length>0 && checker==1){
					myDropzone3.processQueue();
					}else if(myDropzone4.getQueuedFiles().length>0 && checker==1){
						myDropzone4.processQueue();
						}else if(myDropzone5.getQueuedFiles().length>0 && checker==1){
						myDropzone5.processQueue();
						}else if(myDropzone6.getQueuedFiles().length>0 && checker==1){
						myDropzone6.processQueue();	
						} */
				}
			} else if (checker2 == 0) {
				console.log("save from no upload");
				savealldata();

			}

			if (checker >= 1) {

				if (edit_d1 == "nd" && $('#id_edit_prod_spec').val() != "N/A" && edit_count > 0) {
					console.log("dz1");
					myDropzone1.processQueue();

				} else
				if (edit_d2 == "nd" && $('#id_edit_tech_details').val() != "N/A" && edit_count2 > 0) {
					console.log("dz2");
					myDropzone2.processQueue();
				} else
				if (edit_d3 == "nd" && $('#id_edit_art_work').val() != "N/A" && edit_count3 > 0) {
					console.log("dz3");
					myDropzone3.processQueue();
				} else
				if (edit_d4 == "nd" && $('#id_edit_shipping_mark').val() != "N/A" && edit_count4 > 0) {
					console.log("dz4");
					myDropzone4.processQueue();
				} else
				if (edit_d5 == "nd" && $('#id_edit_packing').val() != "N/A" && edit_count5 > 0) {
					console.log("dz5");
					myDropzone5.processQueue();
				} else
				if (edit_d6 == "nd" && $('#id_edit_photo_files').val() != "N/A" && edit_count6 > 0) {
					console.log("dz6");
					myDropzone6.processQueue();
				} else {
					savealldata();
					console.log("finish");
				}
			}


		}

		function request() {


			dropzoneupload();
		}


		function savealldata() {


			$('#edit-show-error').hide();
			$('.send-loading ').show();
			$.ajax({
				url: '/update-client-product',
				type: 'POST',
				data: {
					_token: token,
					'product_id': $('#edit_product_id').val(),
					'client_code': $('#edit_client_code_product').val(),
					'product_name': $('#edit_product_name').val(),
					'product_category': $('#edit_product_category option:selected').text(),
					'product_sub_category': $('#edit_product_sub_category').val(),
					'product_unit': $('#edit_unit').val(),
					'po_no': $('#edit_po_number').val(),
					'model_no': $('#edit_model_number').val(),
					'supplier_item_no': $('#edit_supplier_item_no').val(),
					'brand': $('#edit_brand').val(),
					'additional_product_info': $('#edit_additional_product_info').val(),
					'prod_length': $('#edit_prod_length').val(),
					'prod_width': $('#edit_prod_width').val(),
					'prod_height': $('#edit_prod_height').val(),
					'prod_diameter': $('#edit_prod_diameter').val(),
					'prod_weight': $('#edit_prod_weight').val(),
					'retail_length': $('#edit_retail_length').val(),
					'retail_width': $('#edit_retail_width').val(),
					'retail_height': $('#edit_retail_height').val(),
					'retail_diameter': $('#edit_retail_diameter').val(),
					'retail_weight': $('#edit_retail_weight').val(),
					'retail_box_qty': $('#edit_retail_qty').val(),
					'inner_length': $('#edit_inner_length').val(),
					'inner_width': $('#edit_inner_width').val(),
					'inner_height': $('#edit_inner_height').val(),
					'inner_diameter': $('#edit_inner_diameter').val(),
					'inner_weight': $('#edit_inner_weight').val(),
					'inner_box_qty': $('#edit_inner_qty').val(),
					'export_length': $('#edit_export_length').val(),
					'export_width': $('#edit_export_width').val(),
					'export_height': $('#edit_export_height').val(),
					'export_diameter': $('#edit_export_diameter').val(),
					'export_weight': $('#edit_export_weight').val(),
					'export_box_qty': $('#edit_export_qty').val(),
					'export_max_weight': $('#edit_export_max_weight').val(),
					'export_cbm': $('#edit_export_cbm').val(),
					'grd': $('#edit_grd').val(),
					'item_desc': $('#edit_item_desc').val(),
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {

					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Product successfully updated!",
						type: "success",
					}, function() {
						$('#editProduct').modal('hide');
						location.reload();
					});
				},
				error: function() {
					swal({
						title: "Error!",
						text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
						type: "error",
					});
				}
			});


		}


		var myDropzone1 = new Dropzone(

			//id of drop zone element 1
			'#form_edit_prod_spec', {
				url: "/js/dropzone/upload.php",
				addRemoveLinks: true,
				autoProcessQueue: false,



				removedfile: function(file) {

					var name = file.name;


					$.ajax({
						type: 'POST',
						url: '/js/dropzone/upload.php',
						data: {
							name: name,
							request: 2
						},
						sucess: function(data) {
							console.log('success: ' + data);

						}
					});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
				},
				maxFiles: 100,
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .rar, .zip',
				maxFilesize: 500,
				paramName: "file",
				init: function() {
					this.removeAllFiles();
					var userId = $('#edit_client_code_product').val();

					this.on('addedfile', function(file) {
						var ext = file.name.split('.').pop();

						if (ext == "pdf") {
							$(file.previewElement).find(".dz-image img").attr("src", pdf_icon);
						} else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", doc_icon);
						} else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", xls_icon);
						} else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", ppt_icon);
						} else if (ext.indexOf("pub") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", pub_icon);
						} else if (ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", rar_icon);

						}
					})

					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});


					this.on("success", function(file, responseText) {

						if (responseText == "Successfully uploaded") {
							edit_subcount++;
							if (edit_count == edit_subcount) {
								edit_d1 = "ok";
								console.log("d1");
								checker++;
							}

							request();

						}

					});
					var this_dz = this;
					$('#editProduct').on('shown.bs.modal', function(e) {

						setFileDZ(this_dz, 'PS');

					});

				}
			}
		);



		var myDropzone2 = new Dropzone(
			//id of drop zone element 1
			'#form_edit_tech_details', {
				url: "/js/dropzone/upload1.php",
				addRemoveLinks: true,
				autoProcessQueue: false,


				removedfile: function(file) {

					var name = file.name;

					$.ajax({
						type: 'POST',
						url: '/js/dropzone/upload1.php',
						data: {
							name: name,
							request: 2,

						},
						sucess: function(data) {
							console.log('success: ' + data);
						}
					});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
				},
				maxFiles: 100,
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .rar, .zip',
				maxFilesize: 500,
				paramName: "file",
				init: function() {
					this.removeAllFiles();

					var userId = $('#edit_client_code_product').val();
					this.on('addedfile', function(file) {
						var ext = file.name.split('.').pop();

						if (ext == "pdf") {
							$(file.previewElement).find(".dz-image img").attr("src", pdf_icon);
						} else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", doc_icon);
						} else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", xls_icon);
						} else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", ppt_icon);
						} else if (ext.indexOf("pub") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", pub_icon);
						} else if (ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", rar_icon);

						}
					})

					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount2++;
							console.log("d2");

							if (edit_count2 == edit_subcount2) {
								edit_d2 = "ok";
								checker++;

							}

							request();

						}

					});
					var this_dz = this;
					$('#editProduct').on('shown.bs.modal', function(e) {
						setFileDZ(this_dz, 'TD');
					});
				}
			}
		);


		var myDropzone3 = new Dropzone(
			//id of drop zone element 1
			'#form_edit_art_work', {
				url: "/js/dropzone/upload2.php",
				addRemoveLinks: true,
				autoProcessQueue: false,


				removedfile: function(file) {

					var name = file.name;

					$.ajax({
						type: 'POST',
						url: '/js/dropzone/upload2.php',
						data: {
							name: name,
							request: 2,

						},
						sucess: function(data) {
							console.log('success: ' + data);
						}
					});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
				},
				maxFiles: 100,
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .rar, .zip',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#edit_client_code_product').val();

					this.on('addedfile', function(file) {
						var ext = file.name.split('.').pop();

						if (ext == "pdf") {
							$(file.previewElement).find(".dz-image img").attr("src", pdf_icon);
						} else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", doc_icon);
						} else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", xls_icon);
						} else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", ppt_icon);
						} else if (ext.indexOf("pub") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", pub_icon);
						} else if (ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", rar_icon);

						}
					})
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount3++;
							if (edit_count3 == edit_subcount3) {
								edit_d3 = "ok";
								console.log("d3");
								checker++;
							}

							request();

						}

					});
					var this_dz = this;
					$('#editProduct').on('shown.bs.modal', function(e) {
						setFileDZ(this_dz, 'AW');
					});
				}
			}
		);


		var myDropzone4 = new Dropzone(
			//id of drop zone element 1
			'#form_edit_shipping_mark', {
				url: "/js/dropzone/upload3.php",
				addRemoveLinks: true,
				autoProcessQueue: false,


				removedfile: function(file) {

					var name = file.name;

					$.ajax({
						type: 'POST',
						url: '/js/dropzone/upload3.php',
						data: {
							name: name,
							request: 2,

						},
						sucess: function(data) {
							console.log('success: ' + data);
						}
					});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
				},
				maxFiles: 100,
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .rar, .zip',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#edit_client_code_product').val();

					this.on('addedfile', function(file) {
						var ext = file.name.split('.').pop();

						if (ext == "pdf") {
							$(file.previewElement).find(".dz-image img").attr("src", pdf_icon);
						} else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", doc_icon);
						} else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", xls_icon);
						} else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", ppt_icon);
						} else if (ext.indexOf("pub") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", pub_icon);
						} else if (ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", rar_icon);

						}
					})
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount4++;
							if (edit_count4 == edit_subcount4) {
								edit_d4 = "ok";
								console.log("d4");
								checker++;
							}

							request();

						}

					});
					var this_dz = this;
					$('#editProduct').on('shown.bs.modal', function(e) {
						setFileDZ(this_dz, 'SM');
					});
				}
			}
		);


		var myDropzone5 = new Dropzone(
			//id of drop zone element 1
			'#form_edit_packing', {
				url: "/js/dropzone/upload4.php",
				addRemoveLinks: true,
				autoProcessQueue: false,


				removedfile: function(file) {

					var name = file.name;

					$.ajax({
						type: 'POST',
						url: '/js/dropzone/upload4.php',
						data: {
							name: name,
							request: 2,

						},
						sucess: function(data) {
							console.log('success: ' + data);
						}
					});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
				},
				maxFiles: 100,
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .rar, .zip',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#edit_client_code_product').val();

					this.on('addedfile', function(file) {
						var ext = file.name.split('.').pop();

						if (ext == "pdf") {
							$(file.previewElement).find(".dz-image img").attr("src", pdf_icon);
						} else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", doc_icon);
						} else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", xls_icon);
						} else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", ppt_icon);
						} else if (ext.indexOf("pub") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", pub_icon);
						} else if (ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", rar_icon);

						}
					})
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount5++;
							if (edit_count5 == edit_subcount5) {
								edit_d5 = "ok";
								console.log("d5");
								checker++;
							}

							request();

						}

						this.createThumbnailFromUrl(file, newimage);
					});
					var this_dz = this;
					$('#editProduct').on('shown.bs.modal', function(e) {
						setFileDZ(this_dz, 'PD');
					});
				}
			}
		);


		var myDropzone6 = new Dropzone(
			//id of drop zone element 1
			'#form_edit_photo_files', {
				url: "/js/dropzone/upload5.php",
				addRemoveLinks: true,
				autoProcessQueue: false,


				removedfile: function(file) {

					var name = file.name;

					$.ajax({
						type: 'POST',
						url: '/js/dropzone/upload5.php',
						data: {
							name: name,
							request: 2,

						},
						sucess: function(data) {
							console.log('success: ' + data);
						}
					});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
				},
				maxFiles: 100,
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .rar, .zip',
				maxFilesize: 500,
				paramName: "file",
				init: function() {



					var userId = $('#edit_client_code_product').val();
					this.on('addedfile', function(file) {
						var ext = file.name.split('.').pop();

						if (ext == "pdf") {
							$(file.previewElement).find(".dz-image img").attr("src", pdf_icon);
						} else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", doc_icon);
						} else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", xls_icon);
						} else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", ppt_icon);
						} else if (ext.indexOf("pub") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", pub_icon);
						} else if (ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1) {
							$(file.previewElement).find(".dz-image img").attr("src", rar_icon);

						}
					})
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount6++;
							if (edit_count6 == edit_subcount6) {
								edit_d6 = "ok";
								console.log("d6");
								checker++;
							}

							request();

						}

					});
					var this_dz = this;
					$('#editProduct').on('shown.bs.modal', function(e) {
						setFileDZ(this_dz, 'PP');
					});
				}
			}
		);

		$('#close-err-e-prod').click(function() {
			$('#edit-show-error').hide();
		});

		$('#close_modal').click(function() {
			$('.dz-preview').remove();
		});
		$('#update_product').click(function() {

			var checkDuplicateProductedit = 0;
			$('#add-show-error').hide();
			$.ajax({
				url: '/getproductbyclientcode/' + $('#edit_client_code_product').val() + '',
				type: 'GET',
				success: function(response) {
					var productname = $('#edit_product_name').val();
					var edit_product_nameHide = $('#edit_product_nameHide').val();

					//response.products.forEach(element => {
					$.each(response.products, function(i, element) {


						if (productname == element.product_name) {
							checkDuplicateProductedit++;


						}

					});
					console.log(checkDuplicateProductedit);
					if (edit_product_nameHide == productname) {
						checkDuplicateProductedit = 0;
					} else {

					}

					if (checkDuplicateProductedit > 0) {
						swal({
							title: "Warning!",
							text: "Duplicate Product Name.",
							type: "warning",
						});

					} else {
						editStartEdit();

					}

				},
				error: function() {
					swal({
						title: "Error!",
						text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
						type: "error",
					});
				}
			});

		});

		function editStartEdit() {
			console.log('test edit');

			var edit = $('.edit_product');
			var count_null = 0;
			for (var i = 0; i < edit.length; i++) {
				var data = $(edit[i]).val();
				if (data == "") {
					$(edit[i]).css("border", "1px solid red");
					count_null += 1;

				} else {
					$(edit[i]).removeAttr("style");

				}
			}
			if (count_null == 0) {


				$('#show-error').hide();
				$(this).text("Updating...");
				$('#update_product').attr('disabled', true);
				edit_count = myDropzone1.getQueuedFiles().length;
				edit_count2 = myDropzone2.getQueuedFiles().length;
				edit_count3 = myDropzone3.getQueuedFiles().length;
				edit_count4 = myDropzone4.getQueuedFiles().length;
				edit_count5 = myDropzone5.getQueuedFiles().length;
				edit_count6 = myDropzone6.getQueuedFiles().length;

				dropzoneupload();



			} else {
				$('#edit-show-error').show();
			}


		}

		function setEnEy(cb_id, text_id, group_class, btn_id) {
			if ($('#' + cb_id).prop('checked') == true) {
				$('#' + text_id).attr('disabled', 'disabled');
				$('#' + text_id).val('N/A');
				$('.' + group_class).remove();
				$('#' + btn_id).attr('disabled', 'disabled');
			} else {
				$('#' + text_id).removeAttr("disabled");
				$('#' + text_id).val('');
				$('#' + btn_id).removeAttr("disabled");
			}

		}

	});


	function setFileDZ(dz, categ) {


		//dz.removeAllFiles();
		$('.dz-preview').remove();
		var pid = $('#edit_product_id').val();
		var dz_ids = {
			'PS': 'form_edit_prod_spec',
			'TD': 'form_edit_tech_details',
			'AW': 'form_edit_art_work',
			'SM': 'form_edit_shipping_mark',
			'PD': 'form_edit_packing',
			'PP': 'form_edit_photo_files',
		};
		$.ajax({
			url: '/getProductPhoto',
			type: 'POST',
			data: {
				_token: token,
				id: pid
			},
			success: function(response) {
				var count_upl = 0;
				var existing_files = [];
				console.log(response.productphoto);
				count_upl = response.productphoto.length;
				var get_dz_id = dz_ids[categ];
				console.log(count_upl);
				console.log(categ);
				if (count_upl == 0) {
					//$('#'+get_dz_id).hide();
					/* 	if(categ=="PS"){
					$('#id_edit_prod_spec').val("N/A");
						} if(categ=="TD"){
					$('#id_edit_tech_details').val("N/A");
						} if(categ=="AW"){
						$('#id_edit_art_work').val("N/A");
						} if(categ=="SM"){
						$('#id_edit_shipping_mark').val("N/A");
						} if(categ=="PD"){
							 $('#id_edit_packing').val("N/A");
						}
						 if(categ=="PP"){
							$('#id_edit_photo_files').val("N/A");
						} */
				} else {


					//$('#'+get_dz_id).show();
					//response.productphoto.forEach(element => {
					$.each(response.productphoto, function(i, element) {

						var c_code = element.user_id;
						var cat = element.photo_category;
						var f_name = element.file_name;
						var f_size = element.file_size;

						if (cat == categ) {
							if (cat == "PS") {
								$('#' + get_dz_id).show();
								$('#id_edit_prod_spec').val("UP");
							}
							if (cat == "TD") {
								$('#' + get_dz_id).show();
								$('#id_edit_tech_details').val("UP");
							}
							if (cat == "AW") {
								$('#' + get_dz_id).show();
								$('#id_edit_art_work').val("UP");
							}
							if (cat == "SM") {
								$('#' + get_dz_id).show();
								$('#id_edit_shipping_mark').val("UP");
							}
							if (cat == "PD") {
								$('#' + get_dz_id).show();
								$('#id_edit_packing').val("UP");
							}
							if (cat == "PP") {
								$('#' + get_dz_id).show();
								$('#id_edit_photo_files').val("UP");
							}
							console.log("cat " + cat);





							existing_files.push({
								name: f_name,
								size: f_size
							});



							var ext = f_name.split('.').pop();
							var srcpath;
							if (ext == "pdf") {

								srcpath = pdf_icon;
							} else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {

								srcpath = doc_icon;
							} else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {

								srcpath = xls_icon;
							} else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {

								srcpath = ppt_icon;
							} else if (ext.indexOf("pub") != -1) {

								srcpath = pub_icon;
							} else if (ext.indexOf("rar") != -1) {

								srcpath = rar_icon;
							} else if (ext.indexOf("zip") != -1) {
								srcpath = rar_icon;
							}


							for (i = 0; i < existing_files.length; i++) {
								var new_src = "/js/dropzone/upload/" + cat + "/" + c_code + "/" + f_name;
								//var existing_files = { status: 'success', name:'name.jpg', size: '20000'};
								dz.emit("addedfile", existing_files[i]);
								if (ext == "pdf" || ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1 || ext.indexOf("pub") != -1 || ext.indexOf("zip") != -1) {
									dz.emit('thumbnail', existing_files[i], srcpath)
								} else {
									existing_files[i].previewElement.querySelector("img").src = new_src;
								}

								dz.emit("complete", existing_files[i]);
								dz.files.push(existing_files[i]); // file must be added manually

							}


							existing_files = [];
						}

					});



				}
			}
		});
	}

</script>
<script>
	function disableEditForms(getName) {
		description = $('#id_edit_prod_spec').val();
		description1 = $('#id_edit_tech_details').val();
		description2 = $('#id_edit_art_work').val();
		description3 = $('#id_edit_shipping_mark').val();
		description4 = $('#id_edit_packing').val();
		description5 = $('#id_edit_photo_files').val();

		var get_text = $('#id_edit_' + getName).val();
		if (get_text == 'N / A' || get_text == 'n / a' || get_text == 'N/A' || get_text == 'n/a' || get_text == '') {
			$('#form_edit_' + getName).css({
				'border': '1px solid #980808',
				'pointer-events': 'none'
			});
			document.getElementById('form_edit_' + getName).style.display = 'none';
			document.getElementById('form_edit_' + getName).style.display = 'none';
			document.getElementById('form_edit_' + getName).style.display = 'none';
			document.getElementById('form_edit_' + getName).style.display = 'none';
			document.getElementById('form_edit_' + getName).style.display = 'none';
			document.getElementById('form_edit_' + getName).style.display = 'none';
		} else {
			$('#form_' + getName).css({
				'border': '1px solid #ccc',
				'pointer-events': 'auto'
			});
			document.getElementById('form_edit_' + getName).style.display = 'block';
			document.getElementById('form_edit_' + getName).style.display = 'block';
			document.getElementById('form_edit_' + getName).style.display = 'block';
			document.getElementById('form_edit_' + getName).style.display = 'block';
			document.getElementById('form_edit_' + getName).style.display = 'block';
			document.getElementById('form_edit_' + getName).style.display = 'block';
		}




	}

</script>
<script>


</script>
