<div id="editFactoryContactPerson" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<form data-parsley-validate="">
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Factory Contact Person</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="hidden" name="factory_contact_id" id="factory_contact_id">
								{!! Form::label('factory_contact_person', 'Contact Person Name') !!}
								{!! Form::text('factory_contact_person', $factoryContact->factory_contact_person, ['placeholder'=>'Contact Person Name','class' => 'form-control edit_factory','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('factory_contact_number', 'Mobile #') !!}
								{!! Form::email('factory_contact_number', null, ['placeholder'=>'Contact Number','class' => 'form-control edit_factory','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('factory_tel_number', 'Telephone #') !!}
								{!! Form::text('factory_tel_number', null, ['placeholder'=>'Telephone #','class' => 'form-control edit_factory','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('factory_email', 'Email') !!}
								{!! Form::text('factory_email', null, ['placeholder'=>'Email','class' => 'form-control edit_factory phone','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('factory_contact_skype', 'Skype') !!}
								{!! Form::text('factory_contact_skype', null, ['placeholder'=>'Skype','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('factory_contact_wechat', 'Wechat') !!}
								{!! Form::text('factory_contact_wechat', null, ['placeholder'=>'Wechat','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('factory_contact_whatsapp', 'WhatsApp') !!}
								{!! Form::text('factory_contact_whatsapp', null, ['placeholder'=>'WhatsApp','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('factory_contact_qq', 'QQ Mail') !!}
								{!! Form::text('factory_contact_qq', null, ['placeholder'=>'QQ Mail','class' => 'form-control','required'=>'']) !!}
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
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save changes', ['class' => 'btn btn-success','id'=>'update_factory_contact']) !!}
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

		$('#update_factory_contact').click(function() {
			console.log('Edit Factory Contact Person Details');
			$('#edit-show-error').hide();
			var dis = $(this);
			var add = $('.edit_factory');
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
		// 	var email = document.getElementById('factory_email');
		// 	var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		// 	if (add_count_null == 0) {
		// 		if (!filter.test(email.value)) {
		// 			$('#add-show-error-edit-email').show();
		// 			$('#factory_email').css("border", "1px solid red");
		// 		} else {
		// 			$('#show-error').hide();
		// 			$('#add-show-error-edit-email').hide();
		// 			$(this).text("Saving...");
		// 			$('#update_factory_contact').attr('disabled', true);
		// 			savealldata();
		// 		}

		// 	} else {
		// 		$('#edit-show-error').show();
		// 		$('#add-show-error-edit-email').hide();
		// 	}

		// });


		function savealldata() {
			$('#edit-show-error').hide();
			$.ajax({
				url: '/factory-updatefactorycontact',
				type: 'POST',
				data: {
					_token: token,
					'factory_contact_id': $('#factory_contact_id').val(),
					'factory_contact_person': $('#factory_contact_person').val(),
          'factory_contact_number': $('#factory_contact_number').val(),
          'factory_tel_number': $('#factory_tel_number').val(),
					'factory_email': $('#factory_email').val(),
					'factory_contact_skype': $('#factory_contact_skype').val(),
					'factory_contact_wechat': $('#factory_contact_wechat').val(),
					'factory_contact_whatsapp': $('#factory_contact_whatsapp').val(),
					'factory_contact_qq': $('#factory_contact_qq').val(),
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
});
</script>
