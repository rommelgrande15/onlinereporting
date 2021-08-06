<div id="changePassword" class="modal fade" role="dialog">
	<div class="modal-dialog modal-md">

		<!-- Modal content-->
		<div class="modal-content">
			<form data-parsley-validate=''>
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Change Account Details</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('change_new_pass', 'New Password') !!}
								<input type="password" class="form-control password" id="change_new_pass" name="change_new_pass" placeholder="New Password" autocomplete="off" autofocus>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('change_conf_pass', 'Confirm New Password') !!}
								<input type="password" class="form-control password" id="change_conf_pass" name="change_conf_pass" placeholder="Confirm New Password" autocomplete="off">
								<span id='message'></span>
							</div>
						</div>
						<div class="col-md-12" id="add-show-error-wrong-password" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-account-wrong-password">&times;</a>
								<strong>Error</strong> Password Not Match.
							</div>
						</div>
						<div class="col-md-12" id="add-show-error-empty-password" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-account-wrong-password">&times;</a>
								<strong>Error</strong> Password Empty.
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save changes', ['class' => 'btn btn-success','id'=>'bnt_update_password']) !!}
				</div>
			</form>
		</div>

	</div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {
		$('#close-err-a-account-wrong-password').click(function() {
			$('#add-show-error-wrong-password').hide();
		});

		$('#bnt_update_password').click(function() {
			$('#add-show-error-wrong-password').hide();
			var add_password = $('.password');
			/*if (!filter.test(email.value)) {
				$('#add-show-error-edit-user').show();
				if ($('#change_new_pass').val() == $('#change_conf_pass').val()) {
					$('#add-show-error-wrong-password').hide();
				} else {
					$('#add-show-error-wrong-password').show();
				}
				$('#change_username').css("border", "1px solid red");
			} else {*/
			if ($('#change_new_pass').val().length === 0) {
				$('#add-show-error-empty-password').show();
				$(add_password).css("border", "1px solid red");
				
			} else {
				if ($('#change_new_pass').val() == $('#change_conf_pass').val()) {
					$(this).text("Saving...");
					$('#bnt_update_password').attr('disabled', true);
					savealldata();
				} else {
					$('#add-show-error-wrong-password').show();
					$('#add-show-error-empty-password').hide();
					add_password.css("border", "1px solid red");
				}
			}
			//}
		});

		function savealldata() {
			$('#add-show-error-change-account').hide();
			$.ajax({
				url: '/update-client-userpass',
				type: 'POST',
				data: {
					_token: token,
					//'change_username': $('#change_username').val(),
					//'change_fullname': $('#change_fullname').val(),
					'change_new_pass': $('#change_new_pass').val(),
					'change_conf_pass': $('#change_conf_pass').val()
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(result) {
					console.log(result.message);
					/*if (result.message == "dupticateEmail") {
						$('#bnt_update_password').attr('disabled', false).text("Save Changes");
						$('#add-show-error-wrong-password').hide();
						swal({
							title: "Oops!",
							text: "Your Email is not Available",
							type: "warning",
						});
					} else {*/
					swal({
						title: "Succes",
						text: "Password successfully updated!",
						type: "success",
					}, function() {
						$('#changePassword').modal('hide');
						location.reload();
					});
					//}

				},
				error: function() {
					swal({
						title: "Error!",
						text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
						type: "error",
					});
					$('#bnt_update_password').attr('disabled', false);
				}
			});
		}
	});

</script>
