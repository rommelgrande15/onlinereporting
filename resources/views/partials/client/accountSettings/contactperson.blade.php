<div id="modalContactPerson" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<form data-parsley-validate="">
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Contact Person</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="hidden" name="contact_id" id="contact_id">
								{!! Form::label('contact_name', 'Name') !!}
								{!! Form::text('contact_name', $client->contact_person, ['placeholder'=>'Name','class' => 'form-control edit_contact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('contact_email', 'Email') !!}
								{!! Form::email('contact_email', null, ['placeholder'=>'Email','class' => 'form-control edit_contact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('contact_tel', 'Telephone #') !!}
								{!! Form::text('contact_tel', null, ['placeholder'=>'Telephone #','class' => 'form-control edit_contact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('contact_mobile', 'Mobile #') !!}
								{!! Form::text('contact_mobile', null, ['placeholder'=>'Mobile #','class' => 'form-control edit_contact phone','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('contact_skype', 'Skype') !!}
								{!! Form::text('contact_skype', null, ['placeholder'=>'Skype','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('contact_wechat', 'Wechat') !!}
								{!! Form::text('contact_wechat', null, ['placeholder'=>'Wechat','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('contact_whatsapp', 'WhatsApp') !!}
								{!! Form::text('contact_whatsapp', null, ['placeholder'=>'WhatsApp','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('contact_qq', 'QQ Mail') !!}
								{!! Form::text('contact_qq', null, ['placeholder'=>'QQ Mail','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6 pull-right">
							<div class="form-group">
								{!! Form::label('report_notify', 'Report Notification') !!}
								<select class="form-control" id="edit_report_notify">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
						</div>
						<div class="col-md-12" id="edit-show-error" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-contact">&times;</a>
								<strong>Error</strong> Please fill up the required fields.
							</div>
						</div>
						<div class="col-md-12" id="add-show-error-edit-email" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-email">&times;</a>
								<strong>Error</strong> Please provide a valid email address.
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save changes', ['class' => 'btn btn-success','id'=>'update_contact']) !!}
				</div>
			</form>
		</div>
	</div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {
		$('#close-err-e-contact').click(function() {
			$('#edit-show-error').hide();
		});

		$('.phone').keypress(function(key) {
			if (key.charCode < 48 || key.charCode > 57) return false;
		});

		$('#update_contact').click(function() {
			console.log('Edit Contact Person Details');
			$('#edit-show-error').hide();
			var dis = $(this);
			var add = $('.edit_contact');
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
			var email = document.getElementById('contact_email');
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (add_count_null == 0) {
				if (!filter.test(email.value)) {
					$('#add-show-error-edit-email').show();
					$('#contact_email').css("border", "1px solid red");
				} else {
					$('#show-error').hide();
					$('#add-show-error-edit-email').hide();
					$(this).text("Saving...");
					$('#update_contact').attr('disabled', true);
					savealldata();
				}

			} else {
				$('#edit-show-error').show();
				$('#add-show-error-edit-email').hide();
			}

		});


		function savealldata() {
			$('#edit-show-error').hide();
			$.ajax({
				url: '/client-updateclientcontact',
				type: 'POST',
				data: {
					_token: token,
					'contact_id': $('#contact_id').val(),
					'contact_person': $('#contact_name').val(),
					'contact_person_email': $('#contact_email').val(),
					'contact_person_tel_number': $('#contact_tel').val(),
					'contact_person_number': $('#contact_mobile').val(),
					'client_skype': $('#contact_skype').val(),
					'client_wechat': $('#contact_wechat').val(),
					'client_whatsapp': $('#contact_whatsapp').val(),
					'client_qqmail': $('#contact_qq').val(),
					'report_notify': $('#edit_report_notify').val(),
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					console.log(response);
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Contact Person Details successfully updated!",
						type: "success",
					}, function() {
						$('#changeAQL').modal('hide');
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
	});

</script>
