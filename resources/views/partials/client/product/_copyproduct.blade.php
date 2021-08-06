<div id="copyProduct" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<form data-parsley-validate=''>
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Copy Product</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="hidden" name="copy_client_code_product" id="copy_client_code_product" value="{{$client_code}}">
						<input type="hidden" name="copy_product_id" id="copy_product_id">
						<input type="hidden" name="copy_product_nameHide" id="copy_product_nameHide">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="factory_name">Product Name</label><span class="error_messages product_error"></span>
									<input type="text" name="copy_product_name" class="form-control product_input copy_product" id="copy_product_name" required data-parsley-required-message="Please enter a Product name!" data-parsley-errors-container=".product_error">
									<div id="productRequired2" style="display:none">
										<p style="color:red;">This field is required!</p>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="copy_model_number">Model/Part no.</label>
									<input type="text" name="copy_model_number" class="form-control copy_product" id="copy_model_number" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="copy_supplier_item_no">Supplier item no.</label>
									<input type="text" name="copy_supplier_item_no" class="form-control" id="copy_supplier_item_no" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="email">Brand</label><span class="error_messages brand_error"></span>
									<div id="brand_container">
									</div>
									<input type="text" name="new_brand" class="form-control product_input new_brand copy_product" id="copy_brand" required data-parsley-required-message="Please enter the Product Brand!" data-parsley-errors-container=".brand_error">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="factory_country">Unit</label><span class="error_messages unit_error"></span>
									<select class="form-control unit copy_product" id="copy_unit" name="unit" required data-parsley-required-message="Please select a unit!" data-parsley-errors-container=".unit_error">
										<option selected="selected" value="">Select a unit</option>
										<option value="piece">Piece/s</option>
										<option value="roll">Roll/s</option>
										<option value="set">Set/s</option>
										<option value="pair">Pair/s</option>
										<option value="piece">Box/es</option>
									</select>
								</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('copy_product_category', 'Product Category') !!}
									<div class="input-group">
										{!! Form::select('copy_product_category', $p_category, null, ['class' => 'form-control product_category copy_product', 'placeholder'=>'Select Product Category']) !!}
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
									{!! Form::label('copy_product_sub_category', 'Product Sub-Category') !!}
									<div class="input-group">
										<select class="form-control product_sub_category copy_product" id="copy_product_sub_category" name="copy_product_sub_category">
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
									<label for="copy_product_sub_category">Product Sub-category</label><span class="error_messages category_error"></span>
									<select class="form-control product_sub_category copy_product" id="copy_product_sub_category" name="copy_product_sub_category" >
										<option selected="selected" value="">Select a Category</option>
									</select>
								</div> --}}
							</div>
						</div>
						<div class="row">
							<div id="copy_logistic_fields">
								<div class="col-md-12">
									<h4 class="text-center">Logistic Data</h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-left"><button type="button" class="btn btn-primary btn-block copy-btn-logistics" id="copy_btn_log_prod">Product</button></h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-left"><button type="button" class="btn btn-primary btn-block copy-btn-logistics" id="copy_btn_log_retail">Retail Pack</button></h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-left"><button type="button" class="btn btn-primary btn-block copy-btn-logistics" id="copy_btn_log_inner">Inner Carton</button></h4>
								</div>
								<div class="col-md-3">
									<h4 class="text-left"><button type="button" class="btn btn-primary btn-block copy-btn-logistics" id="copy_btn_log_export">Export Carton</button></h4>
								</div>
							</div>
							<div id="copy_logistic_product" class="copy_logistic_div hidden">
								<div class="col-md-12">
									<h4 class="text-center">Product</h4>
								</div>
								<div class="col-md-12">
									<hr/>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_prod_length">Length (cm)</label>
										<input type="text" name="copy_prod_length" class="form-control" id="copy_prod_length">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_prod_width">Width (cm)</label>
										<input type="text" name="copy_prod_width" class="form-control" id="copy_prod_width">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_prod_height">Height (cm)</label>
										<input type="text" name="copy_prod_height" class="form-control" id="copy_prod_height">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_prod_diameter">Diameter (cm)</label>
										<input type="text" name="copy_prod_diameter" class="form-control" id="copy_prod_diameter">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_prod_weight">Weight (kg)</label>
										<input type="text" name="copy_prod_weight" class="form-control" id="copy_prod_weight">
									</div>
								</div>
								<div class="col-md-12">
									<hr/>
								</div>
							</div>
							<div id="copy_logistic_retail" class="copy_logistic_div hidden">
								<div class="col-md-12">
									<h4 class="text-center">Retail Pack</h4>
								</div>
								<div class="col-md-12">
									<hr/>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_retail_length">Length (cm)</label>
										<input type="text" name="copy_retail_length" class="form-control" id="copy_retail_length">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_retail_width">Width (cm)</label>
										<input type="text" name="copy_retail_width" class="form-control" id="copy_retail_width">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_retail_height">Height (cm)</label>
										<input type="text" name="copy_retail_height" class="form-control" id="copy_retail_height">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_retail_diameter">Diameter (cm)</label>
										<input type="text" name="copy_retail_diameter" class="form-control" id="copy_retail_diameter">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_retail_weight">Weight (kg)</label>
										<input type="text" name="copy_retail_weight" class="form-control" id="copy_retail_weight">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_retail_qty">Retail Box Quantity</label>
										<input type="number" name="copy_retail_qty" class="form-control" id="copy_retail_qty">
									</div>
								</div>

								<div class="col-md-12">
									<hr/>
								</div>
							</div>

							<div id="copy_logistic_inner" class="copy_logistic_div hidden">
								<div class="col-md-12">
									<h4 class="text-center">Inner Carton</h4>
								</div>
								<div class="col-md-12">
									<hr/>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_inner_length">Length (cm)</label>
										<input type="text" name="copy_inner_length" class="form-control" id="copy_inner_length">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_inner_width">Width (cm)</label>
										<input type="text" name="copy_inner_width" class="form-control" id="copy_inner_width">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_inner_height">Height (cm)</label>
										<input type="text" name="copy_inner_height" class="form-control" id="copy_inner_height">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_inner_diameter">Diameter (cm)</label>
										<input type="text" name="copy_inner_diameter" class="form-control" id="copy_inner_diameter">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_inner_weight">Weight (kg)</label>
										<input type="text" name="copy_inner_weight" class="form-control" id="copy_inner_weight">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_inner_qty">Inner Box Quantity</label>
										<input type="number" name="copy_inner_qty" class="form-control" id="copy_inner_qty">
									</div>
								</div>
								<div class="col-md-12">
									<hr/>
								</div>
							</div>
							<div id="copy_logistic_export" class="copy_logistic_div hidden">
								<div class="col-md-12">
									<h4 class="text-center">Export Carton</h4>
								</div>
								<div class="col-md-12">
									<hr/>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_export_length">Length (cm)</label>
										<input type="text" name="copy_export_length" class="form-control" id="copy_export_length">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_export_width">Width (cm)</label>
										<input type="text" name="copy_export_width" class="form-control" id="copy_export_width">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_export_height">Height (cm)</label>
										<input type="text" name="copy_export_height" class="form-control" id="copy_export_height">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_export_diameter">Diameter (cm)</label>
										<input type="text" name="copy_export_diameter" class="form-control" id="copy_export_diameter">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_export_weight">Weight (kg)</label>
										<input type="text" name="copy_export_weight" class="form-control" id="copy_export_weight">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_export_qty">Export Box Quantity</label>
										<input type="number" name="copy_export_qty" class="form-control" id="copy_export_qty">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_export_max_weight">Max. weight of export carton (kg)</label>
										<input type="text" name="copy_export_max_weight" class="form-control" id="copy_export_max_weight">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="copy_export_cbm">Export Carton CBM</label>
										<input type="text" name="copy_export_cbm" class="form-control" id="copy_export_cbm">
									</div>
								</div>
								<div class="col-md-12">
									<hr/>
								</div>
							</div>
							{{-- <div class="col-md-12">
								<div class="form-group">
									<label for="copy_grd">Goods Ready Date</label>
									<input type="text" name="copy_grd" class="form-control" id="copy_grd">
								</div>
							</div> --}}
							<div class="col-md-12">
								<div class="form-group">
									<label for="copy_item_desc">Item Description</label>
									<textarea name="copy_item_desc" class="form-control" id="copy_item_desc"></textarea>
								</div>
							</div>
						</div>

						<div class="row">

							{{-- <div class="col-md-6">
								<div class="form-group">
									<label for="copy_product_number">Product Number</label><span class="error_messages model_error"></span>
									<div id="model_num_container">
									</div>
									<input type="text" name="copy_product_number" class="form-control product_input new_model_number copy_product" id="copy_product_number" required data-parsley-required-message="Please enter the Model Number!" data-parsley-errors-container=".model_error">


									<div id="productRequired6" style="display:none">
										<p style="color:red;">This field is required!</p>
									</div>
								</div>
							</div> --}}

						</div>
						<div class="row">
							<div class="col-md-12">
								<label>Product Photo :</label>
								<select class="form-control copy_product" name="dl_prod_spec" id="id_copy_prod_spec" required autocomplete="off" onchange="copy_disableEditForms('prod_spec')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload Photo</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_copy_prod_spec" style="border:1px solid #ccc;"></div>
							</div>

							<div class="col-md-12">
								<label>Product Spec / Technical Details :</label>
								<select class="form-control copy_product" name="dl_tech_details" id="id_copy_tech_details" required autocomplete="off" onchange="copy_disableEditForms('tech_details')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload Photo</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_copy_tech_details" style="border:1px solid #ccc;"></div>
							</div>

							<div class="col-md-12">
								<label>Art Work :</label>
								<select class="form-control copy_product" name="dl_art_work" id="id_copy_art_work" required autocomplete="off" onchange="copy_disableEditForms('art_work')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload Photo</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_copy_art_work" style="border:1px solid #ccc;"></div>
							</div>

							<div class="col-md-12">
								<label>Shipping Mark :</label>
								<select class="form-control copy_product" name="dl_shipping_mark" id="id_copy_shipping_mark" required autocomplete="off" onchange="copy_disableEditForms('shipping_mark')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload Photo</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_copy_shipping_mark" style="border:1px solid #ccc;"></div>
							</div>

							<div class="col-md-12">
								<label>Packing Details :</label>
								<select class="form-control copy_product" name="dl_packing" id="id_copy_packing" required autocomplete="off" onchange="copy_disableEditForms('packing')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload Photo</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_copy_packing" style="border:1px solid #ccc;"></div>
							</div>




							<div class="col-md-12">
								<label>Other Photos :</label>
								<select class="form-control copy_product" name="dl_photo_files" id="id_copy_photo_files" required autocomplete="off" onchange="copy_disableEditForms('photo_files')">
									<option selected="true" value="">Choose Option</option>
									<option value="UP">Upload Photo</option>
									<option value="N/A">N / A</option>
								</select>
								<div class="dropzone dropzone-previews" id="form_copy_photo_files" style="border:1px solid #ccc;"></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="new_cmf">Additional Information</label><span class="error_messages specs_error"></span>
									<div id="addtl_container">
									</div>
									<input type="text" name="new_additional_product_info" class="form-control product_input new_additional_product_info" id="copy_additional_product_info" required data-parsley-required-message="Please enter dditional information or put N/A if not applicable" data-parsley-errors-container=".brand_error">

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
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save Product Details', ['class' => 'btn btn-success','id'=>'copy_product']) !!}
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

$("#copy_btn_log_prod").click(function (event) {
	if($('#copy_logistic_product').hasClass('hidden')){
		$('.copy_logistic_div').addClass('hidden');
		$('#copy_logistic_product').removeClass('hidden');
		$('.copy-btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.copy_logistic_div').addClass('hidden');
		$('.copy-btn-logistics').removeClass('btn-warning');
	}

});

$("#copy_btn_log_retail").click(function (event) {
	if($('#copy_logistic_retail').hasClass('hidden')){
		$('.copy_logistic_div').addClass('hidden');
		$('#copy_logistic_retail').removeClass('hidden');
		$('.copy-btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.copy_logistic_div').addClass('hidden');
		$('.copy-btn-logistics').removeClass('btn-warning');
	}
});

$("#copy_btn_log_inner").click(function (event) {
	if($('#copy_logistic_inner').hasClass('hidden')){
		$('.copy_logistic_div').addClass('hidden');
		$('#copy_logistic_inner').removeClass('hidden');
		$('copy-btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.copy_logistic_div').addClass('hidden');
		$('.copy-btn-logistics').removeClass('btn-warning');
	}
});

$("#copy_btn_log_export").click(function (event) {
	if($('#copy_logistic_export').hasClass('hidden')){
		$('.copy_logistic_div').addClass('hidden');
		$('#copy_logistic_export').removeClass('hidden');
		$('.copy-btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.copy_logistic_div').addClass('hidden');
		$('.copy-btn-logistics').removeClass('btn-warning');
	}
	
});

		var copy_d1 = "nd";
		var copy_d2 = "nd";
		var copy_d3 = "nd";
		var copy_d4 = "nd";
		var copy_d5 = "nd";
		var copy_d6 = "nd";
		var copy_count;
		var copy_subcount = 0;
		var copy_count2;
		var copy_subcount2 = 0;
		var copy_count3;
		var copy_subcount3 = 0;
		var copy_count4;
		var copy_subcount4 = 0;
		var copy_count5;
		var copy_subcount5 = 0;
		var copy_count6;
		var copy_subcount6 = 0;



		$('#form_copy_prod_spec').hide();
		$('#form_copy_tech_details').hide();
		$('#form_copy_art_work').hide();
		$('#form_copy_shipping_mark').hide();
		$('#form_copy_packing').hide();
		$('#form_copy_photo_files').hide();
		var checker = 0;
		var checker2 = 0;

		function copyDropzoneupload() {

			if (myDropzone1.getQueuedFiles().length > 0 || myDropzone2.getQueuedFiles().length > 0 || myDropzone3.getQueuedFiles().length > 0 || myDropzone4.getQueuedFiles().length > 0 || myDropzone5.getQueuedFiles().length > 0 || myDropzone6.getQueuedFiles().length > 0) {
				checker2++;
				if (checker2 >= 1) {
					checker++
					console.log("continu");
			
				}
			} else if (checker2 == 0) {
				console.log("save from no upload");
				Copyalldata();

			}

			if (checker >= 1) {

				if (copy_d1 == "nd" && $('#id_copy_prod_spec').val() != "N/A" && copy_count > 0) {
					console.log("dz1");
					myDropzone1.processQueue();

				} else
				if (copy_d2 == "nd" && $('#id_copy_tech_details').val() != "N/A" && copy_count2 > 0) {
					console.log("dz2");
					myDropzone2.processQueue();
				} else
				if (copy_d3 == "nd" && $('#id_copy_art_work').val() != "N/A" && copy_count3 > 0) {
					console.log("dz3");
					myDropzone3.processQueue();
				} else
				if (copy_d4 == "nd" && $('#id_copy_shipping_mark').val() != "N/A" && copy_count4 > 0) {
					console.log("dz4");
					myDropzone4.processQueue();
				} else
				if (copy_d5 == "nd" && $('#id_copy_packing').val() != "N/A" && copy_count5 > 0) {
					console.log("dz5");
					myDropzone5.processQueue();
				} else
				if (copy_d6 == "nd" && $('#id_copy_photo_files').val() != "N/A" && copy_count6 > 0) {
					console.log("dz6");
					myDropzone6.processQueue();
				} else {
					Copyalldata();
					console.log("finish");
				}
			}


		}

		function request() {


			copyDropzoneupload();
		}


		function Copyalldata() {

			if('product_name' != ''){
			$('#edit-show-error').hide();
			$('.send-loading ').show();
			$.ajax({
				url: '/copy-client-product',
				type: 'POST',
				data: {
					_token: token,
					'product_id': $('#copy_product_id').val(),
					'client_code': $('#copy_client_code_product').val(),
					'product_name': $('#copy_product_name').val(),
					'product_category': $('#copy_product_category option:selected').text(),
					'product_sub_category': $('#copy_product_sub_category').val(),
					'product_unit': $('#copy_unit').val(),
					'po_no': $('#copy_po_number').val(),
					'model_no': $('#copy_model_number').val(),
					'supplier_item_no': $('#copy_supplier_item_no').val(),
					'brand': $('#copy_brand').val(),
					'additional_product_info': $('#copy_additional_product_info').val(),

					'prod_length': $('#copy_prod_length').val(),
					'prod_width': $('#copy_prod_width').val(),
					'prod_height': $('#copy_prod_height').val(),
					'prod_diameter': $('#copy_prod_diameter').val(),
					'prod_weight': $('#copy_prod_weight').val(),
					'retail_length': $('#copy_retail_length').val(),
					'retail_width': $('#copy_retail_width').val(),
					'retail_height': $('#copy_retail_height').val(),
					'retail_diameter': $('#copy_retail_diameter').val(),
					'retail_weight': $('#copy_retail_weight').val(),
					'retail_box_qty': $('#copy_retail_qty').val(),
					'inner_length': $('#copy_inner_length').val(),
					'inner_width': $('#copy_inner_width').val(),
					'inner_height': $('#copy_inner_height').val(),
					'inner_diameter': $('#copy_inner_diameter').val(),
					'inner_weight': $('#copy_inner_weight').val(),
					'inner_box_qty': $('#copy_inner_qty').val(),
					'export_length': $('#copy_export_length').val(),
					'export_width': $('#copy_export_width').val(),
					'export_height': $('#copy_export_height').val(),
					'export_diameter': $('#copy_export_diameter').val(),
					'export_weight': $('#copy_export_weight').val(),
					'export_box_qty': $('#copy_export_qty').val(),
					'export_max_weight': $('#copy_export_max_weight').val(),
					'export_cbm': $('#copy_export_cbm').val(),
					'grd': $('#copy_grd').val(),
					'item_desc': $('#copy_item_desc').val()
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {

					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Product successfully copied!",
						type: "success",
					}, function() {
						$('#copyProduct').modal('hide');
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
		}else{
			$('#edit-show-error').show();
		}

		}


		var myDropzone1 = new Dropzone(

			//id of drop zone element 1
			'#form_copy_prod_spec', {
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
					var userId = $('#copy_client_code_product').val();

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
							copy_subcount++;
							if (copy_count == copy_subcount) {
								copy_d1 = "ok";
								console.log("d1");
								checker++;
							}

							request();

						}

					});
					var this_dz = this;
					$('#copyProduct').on('shown.bs.modal', function(e) {
						setFileDZ2(this_dz, 'PS');

					});

				}
			}
		);



		var myDropzone2 = new Dropzone(
			//id of drop zone element 1
			'#form_copy_tech_details', {
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

					var userId = $('#copy_client_code_product').val();
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
							copy_subcount2++;
							console.log("d2");

							if (copy_count2 == copy_subcount2) {
								copy_d2 = "ok";
								checker++;

							}

							request();

						}

					});
					var this_dz = this;
					$('#copyProduct').on('shown.bs.modal', function(e) {
						setFileDZ2(this_dz, 'TD');
					});
				}
			}
		);


		var myDropzone3 = new Dropzone(
			//id of drop zone element 1
			'#form_copy_art_work', {
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


					var userId = $('#copy_client_code_product').val();

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
							copy_subcount3++;
							if (copy_count3 == copy_subcount3) {
								copy_d3 = "ok";
								console.log("d3");
								checker++;
							}

							request();

						}

					});
					var this_dz = this;
					$('#copyProduct').on('shown.bs.modal', function(e) {
						setFileDZ2(this_dz, 'AW');
					});
				}
			}
		);


		var myDropzone4 = new Dropzone(
			//id of drop zone element 1
			'#form_copy_shipping_mark', {
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


					var userId = $('#copy_client_code_product').val();

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
							copy_subcount4++;
							if (copy_count4 == copy_subcount4) {
								copy_d4 = "ok";
								console.log("d4");
								checker++;
							}

							request();

						}

					});
					var this_dz = this;
					$('#copyProduct').on('shown.bs.modal', function(e) {
						setFileDZ2(this_dz, 'SM');
					});
				}
			}
		);


		var myDropzone5 = new Dropzone(
			//id of drop zone element 1
			'#form_copy_packing', {
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


					var userId = $('#copy_client_code_product').val();

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
							copy_subcount5++;
							if (copy_count5 == copy_subcount5) {
								copy_d5 = "ok";
								console.log("d5");
								checker++;
							}

							request();

						}

						this.createThumbnailFromUrl(file, newimage);
					});
					var this_dz = this;
					$('#copyProduct').on('shown.bs.modal', function(e) {
						setFileDZ2(this_dz, 'PD');
					});
				}
			}
		);


		var myDropzone6 = new Dropzone(
			//id of drop zone element 1
			'#form_copy_photo_files', {
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



					var userId = $('#copy_client_code_product').val();
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
							copy_subcount6++;
							if (copy_count6 == copy_subcount6) {
								copy_d6 = "ok";
								console.log("d6");
								checker++;
							}

							request();

						}

					});
					var this_dz = this;
					$('#copyProduct').on('shown.bs.modal', function(e) {
						setFileDZ2(this_dz, 'PP');
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
		$('#copy_product').click(function() {

			var checkDuplicateProductedit = 0;
			$('#add-show-error').hide();
			$.ajax({
				url: '/getproductbyclientcode/' + $('#copy_client_code_product').val() + '',
				type: 'GET',
				success: function(response) {
					var productname = $('#copy_product_name').val();
					var copy_product_nameHide = $('#copy_product_nameHide').val();

					//response.products.forEach(element => {
					$.each(response.products, function(i, element) {


						if (productname == element.product_name) {
							checkDuplicateProductedit++;


						}

					});
					console.log(checkDuplicateProductedit);
					if (copy_product_nameHide == productname) {
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
						copyStartEdit();

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

		function copyStartEdit() {
			console.log('test edit');

			var edit = $('.copy_product');
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
				$('#copy_product').attr('disabled', true);
				copy_count = myDropzone1.getQueuedFiles().length;
				copy_count2 = myDropzone2.getQueuedFiles().length;
				copy_count3 = myDropzone3.getQueuedFiles().length;
				copy_count4 = myDropzone4.getQueuedFiles().length;
				copy_count5 = myDropzone5.getQueuedFiles().length;
				copy_count6 = myDropzone6.getQueuedFiles().length;

				copyDropzoneupload();



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


	function setFileDZ2(dz, categ) {


		//dz.removeAllFiles();
		$('.dz-preview').remove();
		var pid = $('#copy_product_id').val();
		var dz_ids = {
			'PS': 'form_copy_prod_spec',
			'TD': 'form_copy_tech_details',
			'AW': 'form_copy_art_work',
			'SM': 'form_copy_shipping_mark',
			'PD': 'form_copy_packing',
			'PP': 'form_copy_photo_files',
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
				console.log("ok");
				console.log(response.productphoto);
				count_upl = response.productphoto.length;
				var get_dz_id = dz_ids[categ];
				console.log(count_upl);
				console.log(categ);
				if (count_upl == 0) {
					//$('#'+get_dz_id).hide();
					/* 	if(categ=="PS"){
					$('#id_copy_prod_spec').val("N/A");
						} if(categ=="TD"){
					$('#id_copy_tech_details').val("N/A");
						} if(categ=="AW"){
						$('#id_copy_art_work').val("N/A");
						} if(categ=="SM"){
						$('#id_copy_shipping_mark').val("N/A");
						} if(categ=="PD"){
							 $('#id_copy_packing').val("N/A");
						}
						 if(categ=="PP"){
							$('#id_copy_photo_files').val("N/A");
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
								$('#id_copy_prod_spec').val("UP");
							}
							if (cat == "TD") {
								$('#' + get_dz_id).show();
								$('#id_copy_tech_details').val("UP");
							}
							if (cat == "AW") {
								$('#' + get_dz_id).show();
								$('#id_copy_art_work').val("UP");
							}
							if (cat == "SM") {
								$('#' + get_dz_id).show();
								$('#id_copy_shipping_mark').val("UP");
							}
							if (cat == "PD") {
								$('#' + get_dz_id).show();
								$('#id_copy_packing').val("UP");
							}
							if (cat == "PP") {
								$('#' + get_dz_id).show();
								$('#id_copy_photo_files').val("UP");
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
	function copy_disableEditForms(getName) {
		description =  $('#id_copy_prod_spec').val();
		description1 = $('#id_copy_tech_details').val();
		description2 = $('#id_copy_art_work').val();
		description3 = $('#id_copy_shipping_mark').val();
		description4 = $('#id_copy_packing').val();
		description5 = $('#id_copy_photo_files').val();

		var get_text = $('#id_copy_' + getName).val();
		if (get_text == 'N / A' || get_text == 'n / a' || get_text == 'N/A' || get_text == 'n/a' || get_text == '') {
			$('#form_copy_' + getName).css({
				'border': '1px solid #980808',
				'pointer-events': 'none'
			});
			document.getElementById('form_copy_' + getName).style.display = 'none';
			document.getElementById('form_copy_' + getName).style.display = 'none';
			document.getElementById('form_copy_' + getName).style.display = 'none';
			document.getElementById('form_copy_' + getName).style.display = 'none';
			document.getElementById('form_copy_' + getName).style.display = 'none';
			document.getElementById('form_copy_' + getName).style.display = 'none';
		} else {
			$('#form_' + getName).css({
				'border': '1px solid #ccc',
				'pointer-events': 'auto'
			});
			document.getElementById('form_copy_' + getName).style.display = 'block';
			document.getElementById('form_copy_' + getName).style.display = 'block';
			document.getElementById('form_copy_' + getName).style.display = 'block';
			document.getElementById('form_copy_' + getName).style.display = 'block';
			document.getElementById('form_copy_' + getName).style.display = 'block';
			document.getElementById('form_copy_' + getName).style.display = 'block';
		}




	}

</script>
<script>


</script>
