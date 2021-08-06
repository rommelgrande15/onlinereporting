<div id="newProduct" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add new Product</h4>
				</div>
				<form id="id_dropzone"  action="/dropzoneupload/" enctype="multipart/form-data" method="post">
					{!!csrf_field()!!}
				<div class="modal-body ">

					<div class="row">
						<div class="col-md-6">
							<input type="hidden" name="new_client_code_product" id="new_client_code_product" value="{{$client_code}}">
							<div class="form-group">
								<label for="factory_name">Product Name</label><span class="error_messages product_error"></span>
								<input type="text" name="new_product_name" class="form-control product_input add_product" id="new_product_name" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="new_model_number">Model/Part no.</label>
								<input type="text" name="new_model_number" class="form-control add_product" id="new_model_number" required >
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="email">Brand</label><span class="error_messages brand_error"></span>
								<div id="brand_container">
								</div>
								<input type="text" name="new_brand" class="form-control product_input new_brand new_product add_product" id="new_brand" required >
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="factory_country">Unit</label><span class="error_messages unit_error"></span>
								<select class="form-control unit add_product" id="unit" name="unit">
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
								{!! Form::label('new_product_category', 'Product Category') !!}
								<div class="input-group">
									{!! Form::select('new_product_category', $p_category, null, ['class' => 'form-control product_category add_product pcat', 'placeholder'=>'Select Product Category']) !!}
									<div class="input-group-btn">
										<button class="btn btn-primary btn-add-cat-modal" type="button" title="Add new category">
											<i class="fa fa-plus"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							{{-- <div class="form-group">
								<label for="factory_address">Product Sub-category</label><span class="error_messages category_error"></span>
								<select class="form-control product_sub_category add_product" id="new_product_sub_category" name="new_product_sub_category" required >
									<option selected="selected" value="">Select a Category</option>
								</select>
							</div> --}}
							<div class="form-group">
								{!! Form::label('new_product_sub_category', 'Product Sub-Category') !!}
								<div class="input-group">
									<select class="form-control product_sub_category add_product" name="new_product_sub_category" id="new_product_sub_category" required>
										<option value="">Select Sub-Product Category</option>
									</select>
									<div class="input-group-btn">
										<button class="btn btn-primary btn-add-sub-cat-modal2" type="button" title="Add new sub-category">
											<i class="fa fa-plus"></i>
										</button>
									</div>
								</div>
							</div>
						</div>

						<div id="logistic_fields">
							<div class="col-md-12">
								<h4 class="text-center">Logistic Data</h4>
							</div>
							<div class="col-md-3">
								<h4 class="text-left"><button type="button" class="btn btn-primary btn-block btn-logistics" id="btn_log_prod">Product +</button></h4>
							</div>
							<div class="col-md-3">
								<h4 class="text-left"><button type="button" class="btn btn-primary btn-block btn-logistics" id="btn_log_retail">Retail Pack +</button></h4>
							</div>
							<div class="col-md-3">
								<h4 class="text-left"><button type="button" class="btn btn-primary btn-block btn-logistics" id="btn_log_inner">Inner Carton +</button></h4>
							</div>
							<div class="col-md-3">
								<h4 class="text-left"><button type="button" class="btn btn-primary btn-block btn-logistics" id="btn_log_export">Export Carton +</button></h4>
							</div>
						</div>
						<div id="logistic_product" class="logistic_div hidden">
							<div class="col-md-12">
								<h4 class="text-center">Product</h4>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_prod_length">Length (cm)</label>
									<input type="text" name="new_prod_length" class="form-control" id="new_prod_length">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_prod_width">Width (cm)</label>
									<input type="text" name="new_prod_width" class="form-control" id="new_prod_width">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="new_prod_height">Height (cm)</label>
									<input type="text" name="new_prod_height" class="form-control" id="new_prod_height">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_prod_diameter">Diameter (cm)</label>
									<input type="text" name="new_prod_diameter" class="form-control" id="new_prod_diameter">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="new_prod_weight">Weight (kg)</label>
									<input type="text" name="new_prod_weight" class="form-control" id="new_prod_weight">
								</div>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
						</div>
						<div id="logistic_retail" class="logistic_div hidden">
							<div class="col-md-12">
								<h4 class="text-center">Retail Pack</h4>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_retail_length">Length (cm)</label>
									<input type="text" name="new_retail_length" class="form-control" id="new_retail_length">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_retail_width">Width (cm)</label>
									<input type="text" name="new_retail_width" class="form-control" id="new_retail_width">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="new_retail_height">Height (cm)</label>
									<input type="text" name="new_retail_height" class="form-control" id="new_retail_height">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_retail_diameter">Diameter (cm)</label>
									<input type="text" name="new_retail_diameter" class="form-control" id="new_retail_diameter">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="new_retail_weight">Weight (kg)</label>
									<input type="text" name="new_retail_weight" class="form-control" id="new_retail_weight">
								</div>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
						</div>
						<div id="logistic_inner" class="logistic_div hidden">
							<div class="col-md-12">
								<h4 class="text-center">Inner Carton</h4>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_inner_length">Length (cm)</label>
									<input type="text" name="new_inner_length" class="form-control" id="new_inner_length">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_inner_width">Width (cm)</label>
									<input type="text" name="new_inner_width" class="form-control" id="new_inner_width">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="new_inner_height">Height (cm)</label>
									<input type="text" name="new_inner_height" class="form-control" id="new_inner_height">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_inner_diameter">Diameter (cm)</label>
									<input type="text" name="new_inner_diameter" class="form-control" id="new_inner_diameter">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="new_inner_weight">Weight (kg)</label>
									<input type="text" name="new_inner_weight" class="form-control" id="new_inner_weight">
								</div>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
						</div>
						<div id="logistic_export" class="logistic_div hidden">
							<div class="col-md-12">
								<h4 class="text-center">Export Carton</h4>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_export_length">Length (cm)</label>
									<input type="text" name="new_export_length" class="form-control" id="new_export_length">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_export_width">Width (cm)</label>
									<input type="text" name="new_export_width" class="form-control" id="new_export_width">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="new_export_height">Height (cm)</label>
									<input type="text" name="new_export_height" class="form-control" id="new_export_height">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_export_diameter">Diameter (cm)</label>
									<input type="text" name="new_export_diameter" class="form-control" id="new_export_diameter">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="new_export_weight">Weight (kg)</label>
									<input type="text" name="new_export_weight" class="form-control" id="new_export_weight">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="new_export_max_weight">Max. weight of export carton (kg)</label>
									<input type="text" name="new_export_max_weight" class="form-control" id="new_export_max_weight">
								</div>
							</div>
							<div class="col-md-12">
								<hr/>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="new_grd">GRD</label>
								<input type="date" name="new_grd" class="form-control" id="new_grd">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="new_item_desc">Item Description</label>
								<textarea name="new_item_desc" class="form-control" id="new_item_desc"></textarea>
							</div>
						</div>
						

						

						<div class="col-md-12">
							<label>Product Photo :</label>
							<select class="form-control add_product" name="dl_prod_spec" id="id_prod_spec" required autocomplete="off" onchange="disableForms('prod_spec')">
								<option selected="true" value="">Choose Option</option>
								<option value="UP">Upload File</option>
								<option value="N/A">N / A</option>
							</select>
							<div class="dropzone dropzone-previews" id="form_prod_spec" style="border:1px solid #ccc;"></div>
						</div>


						<div class="col-md-12">
							<label>Product Spec / Technical Details :</label>
							<select class="form-control add_product" name="dl_tech_details" id="id_tech_details" required autocomplete="off" onchange="disableForms('tech_details')">
								<option selected="true" value="">Choose Option</option>
								<option value="UP">Upload File</option>
								<option value="N/A">N / A</option>
							</select>
							<div class="dropzone dropzone-previews" id="form_tech_details" style="border:1px solid #ccc;"></div>
						</div>

						<div class="col-md-12">
							<label>Art Work :</label>
							<select class="form-control add_product" name="dl_art_work" id="id_art_work" required autocomplete="off" onchange="disableForms('art_work')">
								<option selected="true" value="">Choose Option</option>
								<option value="UP">Upload File</option>
								<option value="N/A">N / A</option>
							</select>
							<div class="dropzone dropzone-previews" id="form_art_work" style="border:1px solid #ccc;"></div>
						</div>

						<div class="col-md-12">
							<label>Shipping Mark :</label>
							<select class="form-control add_product" name="dl_shipping_mark" id="id_shipping_mark" required autocomplete="off" onchange="disableForms('shipping_mark')">
								<option selected="true" value="">Choose Option</option>
								<option value="UP">Upload File</option>
								<option value="N/A">N / A</option>
							</select>
							<div class="dropzone dropzone-previews" id="form_shipping_mark" style="border:1px solid #ccc;"></div>
						</div>

						<div class="col-md-12">
							<label>Packing Details :</label>
							<select class="form-control add_product" name="dl_packing" id="id_packing" required autocomplete="off" onchange="disableForms('packing')">
								<option selected="true" value="">Choose Option</option>
								<option value="UP">Upload File</option>
								<option value="N/A">N / A</option>
							</select>
							<div class="dropzone dropzone-previews" id="form_packing" style="border:1px solid #ccc;"></div>
						</div>


						

						<div class="col-md-12">
							<label>Other Photos :</label>
							<select class="form-control add_product" name="dl_photo_files" id="id_photo_files" required autocomplete="off" onchange="disableForms('photo_files')">
								<option selected="true" value="">Choose Option</option>
								<option value="UP">Upload File</option>
								<option value="N/A">N / A</option>
							</select>
							<div class="dropzone dropzone-previews" id="form_photo_files" style="border:1px solid #ccc;"></div>
						</div>



						<div class="col-md-12">
							<div class="form-group">
								<label for="new_cmf">Additional Information</label><span class="error_messages specs_error"></span>
								<div id="addtl_container">
								</div>
								<input type="text" name="new_additional_product_info" class="form-control product_input new_additional_product_info " id="new_additional_product_info" required data-parsley-required-message="Please enter dditional information or put N/A if not applicable" data-parsley-errors-container=".brand_error">
							</div>
						</div>

						<div class="col-md-12" id="add-show-error" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-prod">&times;</a>
								<strong>Error</strong> Please fill up the required fields.
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save Product Details', ['class' => 'btn btn-success','id'=>'save_product']) !!}
				</div>
			</form>
		</div>

	</div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dropzone/dropzoneold3.js')}}"></script>




<script>
	Dropzone.autoDiscover = false;
	$(document).ready(function() {

		
$("#modalInputNewCat").on('hidden.bs.modal', function (event) {
  if ($('.modal:visible').length) {
    $('body').addClass('modal-open');
  }
});

$("#modalInputNewSubCat2").on('hidden.bs.modal', function (event) {
  if ($('.modal:visible').length) {
    $('body').addClass('modal-open');
  }
});

$("#btn_log_prod").click(function (event) {
	if($('#logistic_product').hasClass('hidden')){
		$('.logistic_div').addClass('hidden');
		$('#logistic_product').removeClass('hidden');
		$('.btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.logistic_div').addClass('hidden');
		$('.btn-logistics').removeClass('btn-warning');
	}
});

$("#btn_log_retail").click(function (event) {
	if($('#logistic_retail').hasClass('hidden')){
		$('.logistic_div').addClass('hidden');
		$('#logistic_retail').removeClass('hidden');
		$('.btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.logistic_div').addClass('hidden');
		$('.btn-logistics').removeClass('btn-warning');
	}
});

$("#btn_log_inner").click(function (event) {
	if($('#logistic_inner').hasClass('hidden')){
		$('.logistic_div').addClass('hidden');
		$('#logistic_inner').removeClass('hidden');
		$('.btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.logistic_div').addClass('hidden');
		$('.btn-logistics').removeClass('btn-warning');
	}
});

$("#btn_log_export").click(function (event) {
	if($('#logistic_export').hasClass('hidden')){
		$('.logistic_div').addClass('hidden');
		$('#logistic_export').removeClass('hidden');
		$('.btn-logistics').removeClass('btn-warning');
		$(this).addClass('btn-warning');
	}else{
		$('.logistic_div').addClass('hidden');
		$('.btn-logistics').removeClass('btn-warning');
	}
});
		$('#form_prod_spec').hide();
		$('#form_tech_details').hide();
		$('#form_art_work').hide();
		$('#form_shipping_mark').hide();
		$('#form_packing').hide();
		$('#form_photo_files').hide();
	
		

		var d1 = "nd";
		var d2 = "nd";
		var d3 = "nd";
		var d4 = "nd";
		var d5 = "nd";
		var d6 = "nd";
	
		var count;
		var subcount = 0;
		var count2;
		var subcount2 = 0;
		var count3;
		var subcount3 = 0;
		var count4;
		var subcount4 = 0;
		var count5;
		var subcount5 = 0;
		var count6;
		var subcount6 = 0;
		



		var myDropzone1 = new Dropzone(

			//id of drop zone element 1
			'#form_prod_spec', {
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {

					var userId = $('#new_client_code_product').val();

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
                    	}
                	})

					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {

						if (responseText == "Successfully uploaded") {
							subcount++;
							if (count <= subcount) {
								d1 = "ok";
								console.log("d1");

							}

							request();

						}

					});
				}
			}
		);


		var myDropzone2 = new Dropzone(
			//id of drop zone element 1
			'#form_tech_details', {
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#new_client_code_product').val();

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
                    	}
					})
					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							subcount2++;
							console.log("d2");

							if (count2 <= subcount2) {
								d2 = "ok";


							}

							request();

						}

					});
				}
			}
		);


		var myDropzone3 = new Dropzone(
			//id of drop zone element 1
			'#form_art_work', {
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#new_client_code_product').val();

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
                    	}
					})
					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							subcount3++;
							if (count3 <= subcount3) {
								d3 = "ok";
								console.log("d3");

							}

							request();

						}

					});
				}
			}
		);


		var myDropzone4 = new Dropzone(
			//id of drop zone element 1
			'#form_shipping_mark', {
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#new_client_code_product').val();

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
                    	}
					})
					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							subcount4++;
							if (count4 <= subcount4) {
								d4 = "ok";
								console.log("d4");
							}

							request();

						}

					});
				}
			}
		);


		var myDropzone5 = new Dropzone(
			//id of drop zone element 1
			'#form_packing', {
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#new_client_code_product').val();

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
                    	}
					})
					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							subcount5++;
							if (count5 <= subcount5) {
								d5 = "ok";
								console.log("d5");
							}

							request();

						}

						
					});
				}
			}
		);


		var myDropzone6 = new Dropzone(
			//id of drop zone element 1
			'#form_photo_files', {
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {

					var userId = $('#new_client_code_product').val();

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
                    	}
					})
					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							subcount6++;
							if (count6 <= subcount6) {
								d6 = "ok";
								console.log("d6");
							}

							request();

						}

					});
				}
			}
		);








		$('#close-err-a-prod').click(function() {
			$('#add-show-error').hide();
		});
		$('#save_product').click(function() {
			var dis = $(this);
			var add = $('.add_product');
			var add_count_null = 0;
			for (var i = 0; i < add.length; i++) {
				var data = $(add[i]).val();
				if (data == "") {
					$(add[i]).css("border", "1px solid red");
					add_count_null += 1;

				} else {
					$(add[i]).removeAttr("style");
				}
			}
			if (add_count_null == 0) {



				//$('#show-error').hide();
				//$(this).text("Saving...");
				//$('#save_product').find('i').removeClass('fa fa-refresh');
            	//$('#save_product').find('i').addClass('fa fa-floppy-o');
				//$('#save_product').attr('disabled', true);
				$('.send-loading').show();
				count = myDropzone1.files.length;
				count2 = myDropzone2.files.length;
				count3 = myDropzone3.files.length;
				count4 = myDropzone4.files.length;
				count5 = myDropzone5.files.length;
				count6 = myDropzone6.files.length;
				
				console.log(count);
				console.log(subcount);
				dropzoneupload();


			} else {
				//$('#add-show-error').show();
				swal({
                    title: "Oops!",
                    text: "Please fill up required fields!",
                    type: "warning",
                });
			}


		});

		$('#id_dropzone .add_product').change(function(){
        	var val= $(this).val();
        	if(val=='' || val==null){              
        	    $(this).css("border", "1px solid red");
        	}else{
        	    $(this).removeAttr("style");
        	}
    	});

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


		function request() {


			dropzoneupload();
		}

		function dropzoneupload() {
			
			if (d1 == "nd" && $('#id_prod_spec').val() != "N/A") {
				myDropzone1.processQueue();
			} else
			if (d2 == "nd" && $('#id_tech_details').val() != "N/A") {
				myDropzone2.processQueue();
			} else
			if (d3 == "nd" && $('#id_art_work').val() != "N/A") {
				myDropzone3.processQueue();
			} else
			if (d4 == "nd" && $('#id_shipping_mark').val() != "N/A") {
				myDropzone4.processQueue();
			} else
			if (d5 == "nd" && $('#id_packing').val() != "N/A") {
				myDropzone5.processQueue();
			} else
			if (d6 == "nd" && $('#id_photo_files').val() != "N/A") {
				myDropzone6.processQueue();
			} else {
				savealldata();
			}

		}


		function savealldata() {


			$('#add-show-error').hide();
			$.ajax({
				url: '/save-client-product-new',
				type: 'POST',
				data: {
					_token: token,
					'client_code': $('#new_client_code_product').val(),
					'product_name': $('#new_product_name').val(),
					'product_category': $('#new_product_category').val(),
					'product_sub_category': $('#new_product_sub_category').val(),
					'product_unit': $('#unit').val(),
					/* 'product_number': $('#new_product_number').val(), */
					'model_no': $('#new_model_number').val(),
					'brand': $('#new_brand').val(),
					'additional_product_info': $('#new_additional_product_info').val(),
					'prod_length': $('#new_prod_length').val(),
					'prod_width': $('#new_prod_width').val(),
					'prod_height': $('#new_prod_height').val(),
					'prod_diameter': $('#new_prod_diameter').val(),
					'prod_weight': $('#new_prod_weight').val(),
					'retail_length': $('#new_retail_length').val(),
					'retail_width': $('#new_retail_width').val(),
					'retail_height': $('#new_retail_height').val(),
					'retail_diameter': $('#new_retail_diameter').val(),
					'retail_weight': $('#new_retail_weight').val(),
					'inner_length': $('#new_inner_length').val(),
					'inner_width': $('#new_inner_width').val(),
					'inner_height': $('#new_inner_height').val(),
					'inner_diameter': $('#new_inner_diameter').val(),
					'inner_weight': $('#new_inner_weight').val(),
					'export_length': $('#new_export_length').val(),
					'export_width': $('#new_export_width').val(),
					'export_height': $('#new_export_height').val(),
					'export_diameter': $('#new_export_diameter').val(),
					'export_weight': $('#new_export_weight').val(),
					'export_max_weight': $('#new_export_max_weight').val(),
					'grd': $('#new_grd').val(),
					'item_desc': $('#new_item_desc').val()
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					console.log(response);
					$('.send-loading ').hide();
					$('.product_name').append('<option value="'+response.product_id+'">'+$('#new_product_name').val()+'</option>');
					swal({
						title: "Success!",
						text: "Product successfully added!",
						type: "success",
					}, function() {
						$('#newProduct').modal('hide');
						clearFields();
						//location.reload();
					});
					//$('#save_product').text("Save Product Details");
					//$('#save_product').find('i').removeClass('fa fa-refresh');
            		//$('#save_product').find('i').addClass('fa fa-floppy-o');
					//$('#save_product').removeAttr('disabled');
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
		function clearFields(){
			var add = $('.add_product');
			for (var i = 0; i < add.length; i++) {
				$(add[i]).val('');
			}
			$('.dz-preview').remove();
			document.getElementById('form_prod_spec').style.display = 'none';
			document.getElementById('form_tech_details').style.display = 'none';
			document.getElementById('form_art_work').style.display = 'none';
			document.getElementById('form_shipping_mark').style.display = 'none';
			document.getElementById('form_packing').style.display = 'none';
			document.getElementById('form_photo_files').style.display = 'none';
		}

	});
	

</script>

<script>
	function disableForms(getName) {
		description = $('#id_prod_spec').val();
		description1 = $('#id_tech_details').val();
		description2 = $('#id_art_work').val();
		description3 = $('#id_shipping_mark').val();
		description4 = $('#id_packing').val();
		description5 = $('#id_photo_files').val();

		var get_text = $('#id_' + getName).val();
		if (get_text == 'N / A' || get_text == 'n / a' || get_text == 'N/A' || get_text == 'n/a' || get_text == '') {
			$('#form_' + getName).css({
				'border': '1px solid #980808',
				'pointer-events': 'none'
			});
			document.getElementById('form_' + getName).style.display = 'none';
			document.getElementById('form_' + getName).style.display = 'none';
			document.getElementById('form_' + getName).style.display = 'none';
			document.getElementById('form_' + getName).style.display = 'none';
			document.getElementById('form_' + getName).style.display = 'none';
			document.getElementById('form_' + getName).style.display = 'none';
			
		} else {
			$('#form_' + getName).css({
				'border': '1px solid #ccc',
				'pointer-events': 'auto'
			});
			document.getElementById('form_' + getName).style.display = 'block';
			document.getElementById('form_' + getName).style.display = 'block';
			document.getElementById('form_' + getName).style.display = 'block';
			document.getElementById('form_' + getName).style.display = 'block';
			document.getElementById('form_' + getName).style.display = 'block';
			document.getElementById('form_' + getName).style.display = 'block';
			

		}

	}
	
</script>
