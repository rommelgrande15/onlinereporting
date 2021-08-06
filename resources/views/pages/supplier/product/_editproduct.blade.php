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
                        @foreach($clientName as $cname)
							<input type="hidden" name="edit_client_code_product" id="edit_client_code_product" value="{{$cname->client_code}}">
						@endforeach
						{{-- <input type="hidden" name="edit_client_code_product" id="edit_client_code_product" value="{{$client_code}}"> --}}
						<input type="hidden" name="edit_product_id" id="edit_product_id">
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
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal",'id'=>'edit_close_modal']) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save Product Details', ['class' => 'btn btn-success','id'=>'update_product']) !!}
				</div>
			</form>
		</div>

	</div>
</div>


<style>
.dz-image img{width: 100%;height: 100%;}
</style>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/dropzone/dropzoneold3.js')}}"></script>

<script>



	Dropzone.autoDiscover = false;
	
	$(document).ready(function() {
	


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
		
		$('#edit_close_modal').click(function() {
		$('.dz-preview').remove();
	});

		$('#form_edit_prod_spec').hide();
		$('#form_edit_tech_details').hide();
		$('#form_edit_art_work').hide();
		$('#form_edit_shipping_mark').hide();
		$('#form_edit_packing').hide();
		$('#form_edit_photo_files').hide();
		var checker=0;
		function dropzoneupload() {
			
			if(myDropzone1.getQueuedFiles().length>0 ||myDropzone2.getQueuedFiles().length>0 ||myDropzone3.getQueuedFiles().length>0 ||myDropzone4.getQueuedFiles().length>0 ||myDropzone5.getQueuedFiles().length>0 ||myDropzone6.getQueuedFiles().length>0 ){
				checker++;
				if(checker==1){
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
			}else if(checker==0){
				savealldata();

			}
			
			if(checker>=1){
				console.log("checker "+checker);
			if (edit_d1 == "nd" && $('#id_edit_prod_spec').val() != "N/A"&&myDropzone1.getQueuedFiles().length>0 ) {
				myDropzone1.processQueue();
			} else
			if (edit_d2 == "nd" && $('#id_edit_tech_details').val() != "N/A"&&myDropzone2.getQueuedFiles().length>0) {
				myDropzone2.processQueue();
			} else
			if (edit_d3 == "nd" && $('#id_edit_art_work').val() != "N/A" &&myDropzone3.getQueuedFiles().length>0) {
				myDropzone3.processQueue();
			} else
			if (edit_d4 == "nd" && $('#id_edit_shipping_mark').val() != "N/A"&&myDropzone4.getQueuedFiles().length>0) {
				myDropzone4.processQueue();
			} else
			if (edit_d5 == "nd" && $('#id_edit_packing').val() != "N/A"&&myDropzone5.getQueuedFiles().length>0) {
				myDropzone5.processQueue();
			} else
			if (edit_d6 == "nd" && $('#id_edit_photo_files').val() != "N/A"&&myDropzone6.getQueuedFiles().length>0) {
				myDropzone6.processQueue();
			} else {
				savealldata();
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
				url: '/update-client-product_only',
				type: 'POST',
				data: {
					_token: token,
					'product_id': $('#edit_product_id').val(),
					'client_code': $('#edit_client_code_product').val(),
					
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					console.log(response);
					$('.dz-preview').remove();
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Product successfully updated!",
						type: "success",
					}, function() {
						//jjjj
						$('#editProduct').modal('hide');
						$('#update_product').text("Save Product Details");
						$('#update_product').removeAttr('disabled');
						checker=0;
						edit_d1 = "nd";
						edit_d2 = "nd";
						edit_d3 = "nd";
						edit_d4 = "nd";
						edit_d5 = "nd";
						edit_d6 = "nd";
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {
					
					var userId = $('#edit_client_code_product').val();


					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

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
					this.on("success", function(file, responseText) {

						if (responseText == "Successfully uploaded") {
							edit_subcount++;
							if (edit_count <= edit_subcount) {
								edit_d1 = "ok";
								console.log("d1");
								checker++;
							}

							request();

						}

					});
					var this_dz=this;					
					$('#editProduct').on('shown.bs.modal', function (e) {
						
						setFileDZ(this_dz,'PS');

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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#edit_client_code_product').val();

					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

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
					
					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount2++;
							console.log("d2");

							if (edit_count2 <= edit_subcount2) {
								edit_d2 = "ok";

								checker++;
							}

							request();

						}

					});
					var this_dz=this;					
					$('#editProduct').on('shown.bs.modal', function (e) {
						setFileDZ(this_dz,'TD');
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#edit_client_code_product').val();

					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

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

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount3++;
							if (edit_count3 <= edit_subcount3) {
								edit_d3 = "ok";
								console.log("d3");
								checker++;
							}

							request();

						}

					});
					var this_dz=this;					
					$('#editProduct').on('shown.bs.modal', function (e) {
						setFileDZ(this_dz,'AW');
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#edit_client_code_product').val();

					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

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
					
					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount4++;
							if (edit_count4 <= edit_subcount4) {
								edit_d4 = "ok";
								console.log("d4");
								checker++;
							}

							request();

						}

					});
					var this_dz=this;					
					$('#editProduct').on('shown.bs.modal', function (e) {
						setFileDZ(this_dz,'SM');
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {


					var userId = $('#edit_client_code_product').val();


					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

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

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount5++;
							if (edit_count5 <= edit_subcount5) {
								edit_d5 = "ok";
								console.log("d5");
								checker++;
							}

							request();

						}

						this.createThumbnailFromUrl(file, newimage);
					});
					var this_dz=this;					
					$('#editProduct').on('shown.bs.modal', function (e) {
						setFileDZ(this_dz,'PD');
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
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
				maxFilesize: 500,
				paramName: "file",
				init: function() {



					var userId = $('#edit_client_code_product').val();
					
					this.on("sending", function(file, xhr, formData) {
						// Append all the additional input data of your form here!
						formData.append("userId", userId);
					});

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

					this.on("success", function(file, responseText) {
						if (responseText == "Successfully uploaded") {
							edit_subcount6++;
							if (edit_count6 <= edit_subcount6) {
								edit_d6 = "ok";
								console.log("d6");
								checker++;
							}

							request();

						}

					});
					var this_dz=this;					
					$('#editProduct').on('shown.bs.modal', function (e) {
						setFileDZ(this_dz,'PP');
					});
				}
			}
		);

		$('#close-err-e-prod').click(function() {
		$('#edit-show-error').hide();
	});
	$('#update_product').click(function() {
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

	});


	function setFileDZ(dz,categ){

		

$('.dz-preview').remove();
var pid=$('#edit_product_id').val();
var dz_ids={
	'PS':'form_edit_prod_spec',
	'TD':'form_edit_tech_details',
	'AW':'form_edit_art_work',
	'SM':'form_edit_shipping_mark',
	'PD':'form_edit_packing',
	'PP':'form_edit_photo_files',
	};
$.ajax({
	url: '/getProductPhoto',
	type: 'POST',
	data: {
		_token: token,
		id: pid
	},
	success: function(response) {	
		var count_upl=0;		
		var existing_files = [];
		console.log(response.productphoto);
		count_upl=response.productphoto.length;
		var get_dz_id=dz_ids[categ];
		console.log(count_upl);
		console.log(categ);
		if(count_upl==0){
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
		}else{
		
			
			//$('#'+get_dz_id).show();
			$.each(response.productphoto, function(i, element) {						
				var c_code=element.user_id;
				var cat=element.photo_category;
				var f_name=element.file_name;
				var f_size=element.file_size;

				if(cat==categ){
					if(cat=="PS"){
						$('#'+get_dz_id).show();
				$('#id_edit_prod_spec').val("UP");
					} if(cat=="TD"){
						$('#'+get_dz_id).show();
				$('#id_edit_tech_details').val("UP");
					} if(cat=="AW"){
						$('#'+get_dz_id).show();
					$('#id_edit_art_work').val("UP");
					} if(cat=="SM"){
						$('#'+get_dz_id).show();
					$('#id_edit_shipping_mark').val("UP");
					} if(cat=="PD"){
						$('#'+get_dz_id).show();
						 $('#id_edit_packing').val("UP");
					}
					 if(cat=="PP"){
						$('#'+get_dz_id).show();
						$('#id_edit_photo_files').val("UP");
					}
					console.log("cat " + cat);
					
					 

					

					existing_files.push({ status: 'success', name: f_name, size: f_size });

					var ext = f_name.split('.').pop();
					var srcpath;
						if (ext == "pdf") {
							
							srcpath=pdf_icon;
						} else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
						
							srcpath=doc_icon;
						} else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
						
							srcpath=xls_icon;
						} else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
						
							srcpath=ppt_icon;
						} else if (ext.indexOf("pub") != -1) {
						
							srcpath=pub_icon;
						}else if (ext.indexOf("rar") != -1) {
						
							srcpath=rar_icon;
						}else if (ext.indexOf("zip") != -1){
							srcpath=rar_icon;
						}
				
					for (i = 0; i < existing_files.length; i++) {
						/* dz.options.addedfile.call(dz, existing_files[i]);
						dz.options.thumbnail.call(dz, existing_files[i], "/js/dropzone/upload/"+cat+"/"+c_code+"/"+f_name);
						existing_files[i].previewElement.classList.add('dz-success');
						existing_files[i].previewElement.classList.add('dz-complete'); */

						var new_src="/js/dropzone/upload/"+cat+"/"+c_code+"/"+f_name;
						//var existing_files = { status: 'success', name:'name.jpg', size: '20000'};
						dz.emit( "addedfile", existing_files[i] );
						if(ext == "pdf" ||ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1||ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1||ext.indexOf("pub") != -1 ||ext.indexOf("zip") != -1){
							dz.emit('thumbnail', existing_files[i], srcpath)
						}else{
							existing_files[i].previewElement.querySelector("img").src = new_src;
						}
    					//existing_files[i].previewElement.querySelector("img").src = new_src;
    					dz.emit( "complete", existing_files[i]);
    					dz.files.push( existing_files[i] ); // file must be added manually
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
