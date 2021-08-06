<div id="newAccountModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form method="POST" action="">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Client Account</h4>
				</div>
				<div class="modal-body">
					{!!csrf_field()!!}
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" class="form-control" id="username" name="username" required>
							</div>
						</div>
						<div class="col-md-6">

							<div class="form-group">
								<label for="email">Email address:</label>
								<input type="email" class="form-control" name="email" id="email" required>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control" minlength="6" id="password" name="password" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="password_confirmation">Confirm Password</label>
								<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="contact_number">Contact Number:</label>
								<input type="text" minlength="11" maxlength="15" class="form-control numeric" name="contact_number" id="contact_number" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="email">Account Name:</label>
								<input type="text" class="form-control" name="account_name" id="account_name" required>
							</div>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="button" onclick="AddnewAccount()" class="btn btn-success">Save Details</button>
				</div>
			</div>
			<!-- Modal content end-->
		</form>
	</div>
</div>

<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>

<script>
	$(document).ready(function() {

		/*$("#designation").change(function() {
		    if ($("#designation").val() == "booking") {
		        $('#BookingState').show();
		    } else {
		        $('#BookingState').hide();

		    }

		});


		$("#GroupSection").change(function() {
		    if ($("#GroupSection").val() == "Others") {
		        $('#groupInput').show();
		    } else {
		        $('#groupInput').hide();

		    }

		});*/

	});

	function AddnewAccount() {
		var emailValidator = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
		var count_null = 0;
		var array_Id = [
			'username',
			'password',
			'email',
			'password_confirmation',
			'contact_number',
			'account_name'

		];
		var message;
		var array_message = [
			'Username',
			'Password',
			'Email',
			'Password confirmation',
			'Contact number',
			'Account name'

		];
		for (let index = 0; index < array_Id.length; index++) {

			const element = $('#' + array_Id[index] + '').val();
			if (element == "") {
				count_null += 1;
				$('#' + array_Id[index] + '').css("border", "1px solid red");
				message = array_message[index];
				break;
			} else {
				$('#' + array_Id[index] + '').removeAttr("style");
			}
		}
		if (count_null <= 0) {
			var username = document.getElementById('username').value;
			var password = document.getElementById('password').value;
			var email = document.getElementById('email').value;
			var contact_number = document.getElementById('contact_number').value;
			var account_name = document.getElementById('account_name').value;
			var site_url = "{{$site_url}}";
			//var designation = document.getElementById('designation').value;
			//var GroupSection = document.getElementById('GroupSection').value;
			//var groupInputdata = document.getElementById('groupInputdata').value;


			//var address= document.getElementById('address').value;

			if (emailValidator.test(email)) {
				if (password == $('#password_confirmation').val()) {
					$('.send-loading ').show();
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					$.ajax({
						type: 'POST',
						//dataType: "json",
						url: '/client-postnewaccount',
						data: {
							username: username,
							email: email,
							password: password,
							account_name: account_name,
							contact_number: contact_number,
							site_url: site_url
							//designation: designation,
							//GroupSection: GroupSection,
							//groupInputdata: groupInputdata
						},
						success: function(data) {
							$('.send-loading ').hide();
							swal({
								title: "Success!",
								text: "New Client account successfully created.",
								type: "success",
							}, function() {
								location.reload();
							});
							//alert("New Client account successfully created");                   
						},
						error: function(xhr) {
							$('.send-loading ').hide();
							var err = JSON.parse(xhr.responseText);
							//alert(err.message);
							swal({
                                title: "Error!",
                                text: "Error: " + err.message,
                                type: "error",
                            });
						}
						/*error: function(data) {
                            console.log(data);
                            console.log(data.message);
                            $('.send-loading ').hide();
                            if(data.message){
								swal({
                                title: "Error!",
                                text: "Error: " + data.message,
                                type: "error",
                            });
							} else {
								swal({
                                title: "Error!",
                                text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                                type: "error",
                            });
							}
                        }*/

					});

				} else {
					//alert("Password not Match!");
					swal({
						title: "Error!",
						text: "Password does not match!",
						type: "warning",
					});
				}


			} else {

				//alert("Please Input Corect Email!");
				swal({
					title: "Error!",
					text: "Please input corect email!",
					type: "warning",
				});
				$('#email').css("border", "1px solid red");
			}
		} else {

			alert(message + " are Required");
		}

	}

</script>
