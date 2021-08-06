<div id="modalAssignReport" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">
		<!-- Modal content-->
		<div class="modal-content">
			<form method="post" action="" enctype="multipart/form-data" id="my-dropzone">
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title text-center">Assign Reporter</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" id="ins_id" name="ins_id" required>
					<div class="form-group">
						<label for="">Reference #:</label>
						<input type="text" class="form-control" id="ref_n" readonly>
					</div>
					<div class="form-group">
						<label>Reviewer:</label>
						<select class="form-control" name="reviewer_name" id="reviewer_name" required>
							<option selected disabled>--</option>
							@foreach($reviewers as $reviewer)
							<option value="{{$reviewer->id}}">{{$reviewer->name}} ({{$reviewer->email_address}})</option>
							@endforeach
						</select>
					</div>
					<div id="add-show-error-reviewer_name" style="display:none;">
						<div class="alert alert-danger alert-dismissable" role="alert">
							<a href="#" class="close" id="close-err-a-send">&times;</a>
							<strong>Error</strong> Please fill up the required fields.
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							{!! Form::button('Close', ['class' => 'btn btn-default btn-block', 'data-dismiss' => "modal"]) !!}
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							{!! Form::button('<i class="fa fa-plus"></i> Assign', ['class' => 'btn btn-block btn-primary', 'type'=>'button','id'=>'btn_assign']) !!}
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/dropzone.js')}}"></script>
<script>
	Dropzone.autoDiscover = false;
	var auth_id = "{{Auth::id()}}";
	var token = "{{csrf_token()}}";
	var pdf_icon = "{{asset('images/icons/pdf.png')}}";
	var doc_icon = "{{asset('images/icons/doc.png')}}";
	var xls_icon = "{{asset('images/icons/xls.png')}}";
	var ppt_icon = "{{asset('images/icons/ppt.png')}}";
	var pub_icon = "{{asset('images/icons/pub.png')}}";
	var rar_icon = "{{asset('images/icons/rar.png')}}";
	jQuery(document).ready(function() {
		$('#btn_assign').click(function() {
			$('#add-show-error-send').hide();
			var reviewer_name = $('#reviewer_name option:selected').val();
			if (reviewer_name == 0) {
				$('#add-show-error-reviewer_name').show();
			} else {
				$.ajax({
					url: '/assign_reviewer',
					type: 'POST',
					data: {
						_token: token,
						'ins_id': $('#ins_id').val(),
						'reviewer_name': $('#reviewer_name').val()
					},
					beforeSend: function() {
						$('.send-loading ').show();
					},
					success: function(response) {
						if (response.message == "Report Assigned") {
							swal({
								title: "Succes",
								text: "Report successfully Assigned!",
								type: "success",
							}, function() {
								$('#modalAssignReport').modal('hide');
								location.reload();
							});
						} else {
							swal({
								title: "Error",
								text: "Report failed send, please try again!",
								type: "error",
							}, function() {
								$('#btn_assign').attr('disabled', false);
								$('#btn_assign').text("Send");
							});
						}
					},
					error: function() {
						swal({
							title: "Error!",
							text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
							type: "error",
						});
						$('#btn_assign').attr('disabled', false);
					}
				});
			}

		});


		/*var myDropzone1 = new Dropzone(

			//id of drop zone element 1
			'#form_report_files', {
				//url: "http://ticapp.tk/js/dropzone/report_reviewer/upload.php",
				url: "/upload-report",
				addRemoveLinks: true,
				autoProcessQueue: false,
				uploadMultiple: true,
				parallelUploads: 100,

				removedfile: function(file) {
					var name = file.name;
					$.ajax({
						type: 'POST',
						url: '/upload-report',
						data: {
							_token: token,
							id: file.name,
							request: 2
						},
						sucess: function(data) {
							console.log('success: ' + data);
							$('#btn_assign').attr('disabled', false);

						},
						error: function() {
							console.log('Error: ' + data);
							swal({
								title: "Error!",
								text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
								type: "error",
							});
							$('#btn_assign').attr('disabled', false);
						}
					});
					var _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
				},
				acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .rar, .zip',
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
						var inspection_id = $('#inspection_id').val();
						var company_email = $('#company_email').val();
						var recipient_email = $('#recipient_email').val();
						var cc_email = $('#cc_email').val();
						formData.append("_token", token);
						formData.append("inspection_id", inspection_id);
						formData.append("company_email", company_email);
						formData.append("recipient_email", recipient_email);
						formData.append("cc_email", cc_email);
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
		);*/


		$('#close-err-a-send').click(function() {
			$('#add-show-error-send').hide();
		});
		$('#close-err-a-send-file').click(function() {
			$('#add-show-error-send-file').hide();
		});
		/*$('#btn_assign').click(function() {
			var dis = $(this);
			var add = $('.add_report');

			//var file_report = $('.data-dz-name').val();
			var file_report = $(this).data('dz-name');
			count_file = myDropzone1.files.length;
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
			$('.dropzone-container').removeAttr("css");
			if (add_count_null == 0) {
				if (count_file != "") {
					$(this).text("Saving...");
					$('#btn_assign').attr('disabled', true);
					$('add-show-error-send').hide();
					$('add-show-error-send-file').hide();
					count = myDropzone1.files.length;
					//console.log(count);
					//console.log(subcount);
					myDropzone1.processQueue();
					//savealldata();
					//dropzoneupload();
				} else {
					$('add-show-error-send').hide();
					$('#add-show-error-send-file').show();
					$('#btn_assign').attr('disabled', false);
				}
			} else {
				$('#add-show-error-send').show();
				$('#add-show-error-send-file').hide();
				$('#btn_assign').attr('disabled', false);
			}
		});*/



		/*		function request() {
					dropzoneupload();
				}*/

		/*function dropzoneupload() {
			savealldata();

		}*/

		/*function savealldata() {
			$('#add-show-error-send').hide();
			//var name = file.name;
			$.ajax({
				url: '/reportReviewer-send-report',
				type: 'POST',
				data: {
					_token: token,
					'client_id': $('#client_id').val(),
					'company_email': $('#company_email').val(),
					'ref_no': $('#ref_no').val(),
					'recipient_email': $('#recipient_email').val(),
					'report_file': $('#form_report_files').val(),
					'cc_email': $('#cc_email').val()
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					if (response.message == "OK") {
						myDropzone1.processQueue();
						swal({
							title: "Succes",
							text: "Report successfully sent!",
							type: "success",
						}, function() {
							$('#modalViewReport').modal('hide');
							location.reload();
						});
					} else {
						swal({
							title: "Error",
							text: "Report failed send, please try again!",
							type: "error",
						}, function() {
							$('#btn_assign').attr('disabled', false);
							$('#btn_assign').text("Send");
						});
					}
				},
				error: function() {
					swal({
						title: "Error!",
						text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
						type: "error",
					});
					$('#btn_assign').attr('disabled', false);
				}
			});
		}*/
	});

</script>
