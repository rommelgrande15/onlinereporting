<div id="changeUsername" class="modal fade" role="dialog">
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
								{!! Form::label('change_username', 'Username') !!}
								{!! Form::text('change_username', $user->username, ['placeholder'=>'Username','class' => 'form-control change_account','required'=>'','autofocus'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('change_fullname', 'Full Name') !!}
								{!! Form::text('change_fullname', $user_info->name, ['placeholder'=>'Full Name','class' => 'form-control change_account','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-12" id="add-show-error-change-account" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-account">&times;</a>
								<strong>Error</strong> Please fill up the required fields.
							</div>
						</div>
						<div class="col-md-12" id="add-show-error-edit-user" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-account-wrong-user-email">&times;</a>
								<strong>Error</strong> Please provide a valid email address.
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save changes', ['class' => 'btn btn-success','id'=>'btn_update_username']) !!}
				</div>
			</form>
		</div>

	</div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {
		$('#close-err-a-account').click(function() {
			$('#add-show-error-change-account').hide();
		});
		$('#close-err-a-account-wrong-user-email').click(function() {
			$('#add-show-error-edit-user').hide();
		});

		$('#btn_update_username').click(function() {
					savealldata();
		});

		function savealldata() {
			$('#add-show-error-change-account').hide();
			$.ajax({
				url: '/update-factory-username',
				type: 'POST',
				data: {
					_token: token,
					'change_username': $('#change_username').val(),
					'change_fullname': $('#change_fullname').val()
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(result) {
					console.log(result.message);
					if (result.message == "dupticateEmail") {
						$('#btn_update_username').attr('disabled', false).text("Save Changes");
						swal({
							title: "Oops!",
							text: "Your Email is not Available",
							type: "warning",
						});
					} else {
						swal({
							title: "Succes",
							text: "Account Details successfully updated!",
							type: "success",
						}, function() {
							$('#changeUsername').modal('hide');
							location.reload();
						});
					}
				},
				error: function() {
					swal({
						title: "Error!",
						text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
						type: "error",
					});
					$('#btn_update_username').attr('disabled', false);
				}
			});
		}
	});

</script>
