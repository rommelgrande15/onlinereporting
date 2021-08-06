<div id="profile_pic_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<form method="post" action="" enctype="multipart/form-data">
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-center">Change Profile</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Profile :</label>
						<div class="col-md-12 dropzone-container dz-clickable" id="form_report_profile_pics">
							<div class="dz-message default-dropzone-text" data-dz-message=""><span class="text-default">Drag files or click here to Upload</span></div>
						</div>
					</div>
					<div id="add-show-error-send-file" style="display:none;">
						<div class="alert alert-sm alert-danger alert-dismissable" role="alert">
							<a href="#" class="close" id="close-err-a-send-file">&times;</a>
							<strong>Error</strong> Please add the file.
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							{!! Form::button('Close', ['class' => 'btn btn-default btn-block', 'data-dismiss' => "modal"]) !!}
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							{!! Form::button('<i class="fa fa-upload"></i> Upload', ['class' => 'btn btn-block btn-primary', 'type'=>'button','id'=>'btn_upload_profile']) !!}
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function() {
		var d1 = "nd";
		var count;
		var subcount = 0;

		var myDropzone_profile = new Dropzone(

			//id of drop zone element 1
			'#form_report_profile_pics', {
				//url: "http://ticapp.tk/js/dropzone/report_reviewer/upload.php",
				url: "/change-profile-picture",
				addRemoveLinks: true,
				autoProcessQueue: false,

				removedfile: function(file) {
					var name = file.name;
					$.ajax({
						type: 'POST',
						url: '/change-profile-picture',
						data: {
							_token: token,
							id: file.name,
							request: 2
						},
						sucess: function(data) {
							console.log('success: ' + data);
							$('#btn_upload_profile').attr('disabled', false);

						},
						error: function() {
							console.log('Error: ' + data);
							swal({
								title: "Error!",
								text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
								type: "error",
							});
							$('#btn_upload_profile').attr('disabled', false);
						}
					});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
				},
				maxFiles: 1,
				acceptedFiles: '.jpeg, .jpg, .png, .gif',
				maxFilesize: 100,
				paramName: "file",
				init: function() {
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
						formData.append("_token", token);
					});

					this.on("success", function(file, responseText) {
						if (responseText.message == "Report Saved") {
							$('#modalViewReport').modal('hide');
							swal({
								title: "Succes",
								text: "Report successfully sent!",
								type: "success",
							}, function() {
								location.reload();
							});
						} else if (responseText.message == "Save Error") {
							swal({
								title: "Failed",
								text: "Report Not Save",
								type: "error",
							}, function() {
								location.reload();
							});
						} else if (responseText.message == "Email Error") {
							swal({
								title: "Failed",
								text: "Email Not Send",
								type: "error",
							}, function() {
								location.reload();
							});
						}
					});
				}
			}
		);

		$('#close-err-a-send-file').click(function() {
			$('#add-show-error-send-file').hide();
		});
		$('#btn_upload_profile').click(function() {
			var dis = $(this);
			//var file_report = $('.data-dz-name').val();
			var file_report = $(this).data('dz-name');
			count_file = myDropzone_profile.files.length;

			$('.dropzone-container').removeAttr("css");
			if (count_file != "") {
				$(this).text("Saving...");
				$('#btn_upload_profile').attr('disabled', true);
				$('add-show-error-send').hide();
				$('add-show-error-send-file').hide();
				count = myDropzone_profile.files.length;
				//console.log(count);
				//console.log(subcount);
				myDropzone_profile.processQueue();
				//savealldata();
				//dropzoneupload();
			} else {
				$('add-show-error-send').hide();
				$('#add-show-error-send-file').show();
				$('#btn_upload_profile').attr('disabled', false);
			}
		});
	});

</script>
