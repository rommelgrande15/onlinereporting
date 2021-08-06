<div id="newAccountModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<form method="POST" action="">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add New Supplier Account</h4>
				</div>
				<div class="modal-body">
					{!!csrf_field()!!}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="loading_supplier">Supplier</label>
								<select class="form-control" name="loading_supplier" id="loading_supplier">
									<option value="" selected>Select Supplier</option>
									@foreach ($supplierData as $supplier)
									<option value="{{$supplier->id}}" >{{$supplier->supplier_name}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="loading_supplier_contact_person">Supplier Contact Person</label>
								<select class="form-control loading_supplier_contact_person" name="loading_supplier_contact_person" id="loading_supplier_contact_person">
									<option value="" >Select Contact Person</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="loading_client_contact_person">Client Contact Person</label>
								<select class="form-control loading_client_contact_person" name="loading_client_contact_person" id="loading_client_contact_person">
									<option value="" >Select Contact Person</option>
								</select>
							</div>
						</div>
					</div>
					
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('username', 'Username') !!}
									{!! Form::text('username', null, ['class' => 'form-control username','id'=>'username']) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('email', 'Email Address') !!}
									{!! Form::text('email', null, ['class' => 'form-control email','required'=>'','readonly' =>'true']) !!}
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
									{!! Form::label('contact_number', 'Contact Number') !!}
									{!! Form::text('contact_number', null, ['class' => 'form-control contact_number','id'=>'contact_number']) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('account_name', 'Account Name:') !!}
									{!! Form::text('account_name', null, ['class' => 'form-control account_name','id'=>'account_name']) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label class="checkbox-inline checkbox-bootstrap checkbox-lg">
									<input type="checkbox" id="email_reciever">
									<span class="checkbox-placeholder"></span>
									Checked if you want to send email to factory after the inspection.
							  </label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label class="">
									
							  </label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label class="checkbox-inline checkbox-bootstrap checkbox-lg">
									<input type="checkbox" id="report_access">
									<span class="checkbox-placeholder"></span>
									Checked if you want supplier to access the reports online.
							  </label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label class="">
									
							  </label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label class="checkbox-inline checkbox-bootstrap checkbox-lg">
									<input type="checkbox" id="no_email">
									<span class="checkbox-placeholder"></span>
									Checked if you dont want supplier account to recieve any email.
							  </label>
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
		$('#loading_supplier').on('change', function() {
        $('#new_supplier_id').val($(this).val());
        $.ajax({
            url: '/getonesupplierclientcontact/' + $(this).val(),
            type: 'GET',
            success: function(response) {
				$('#username').val('');
				$('#email').val('');
				$('#account_name').val(response.supplier.supplier_name);
				$('#loading_supplier_contact_person option').remove();
                $('#loading_supplier_contact_person').append($('<option value="">Select Contact Person</option>'));
                var count = response.supplier_contact.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#loading_supplier_contact_person').append($("<option></option>").attr("value", response.supplier_contact[i].id).text(response.supplier_contact[i].supplier_contact_person));
                }
				$('#loading_client_contact_person option').remove();
                $('#loading_client_contact_person').append($('<option value="">Select Contact Person</option>'));
                var count = response.contacts.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#loading_client_contact_person').append($("<option></option>").attr("value", response.contacts[i].id).text(response.contacts[i].contact_person));
                }
            }
        });
    });

	$('#loading_supplier_contact_person').on('change', function() {
        var dis = $(this);
        $.ajax({
            url: '/getonesuppliercontactclient/' + dis.val(),
            type: 'GET',
            success: function(response) {
				$('#email').val(response.supplier_contact.supplier_email);
                $('#contact_number').val(response.supplier_contact.supplier_contact_number);
				document.getElementById("loading_supplier_contact_person").style.border="1px solid gray";
				document.getElementById("email").style.border="1px solid gray";
            },
			error: function(xhr) {
				var err = JSON.parse(xhr.responseText);
				//alert(err.message);
				swal({
					title: "Error!",
					text: "Error: " + err.message,
					type: "error",
				});
				document.getElementById("loading_supplier_contact_person").style.border="1px solid red";
				document.getElementById("email").style.border="1px solid red";
			}
        });
    })

	$('#email_reciever').click(function() {
			var $this = $(this);
			if ($this.is("#email_reciever")) {
				if ($("#email_reciever:checked").length > 0) {
					$("#no_email").prop({ disabled: true, checked: false });
				} else {
					$("#no_email").prop("disabled", false);
				}
			}
		});
	});

	
	function AddnewAccount() {
		var emailValidator = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
		var count_null = 0;
		var array_Id = [
			'loading_supplier',
			'loading_supplier_contact_person',
			'loading_client_contact_person',
			'username',
			'password',
			'loading_email',
			'password_confirmation',
			'contact_number',
			'account_name'
		];
		var message;
		var array_message = [
			'Please Select Supplier',
			'Please Select Supplier Contact',
			'Please Select Client Contact',
			'Username Required',
			'Password Required',
			'Email',
			'Password Confirmation Does Not Match',
			'Contact Number Required',
			'Account Name Required'
		];

			if($("#email_reciever").is(':checked')){
				var email_reciever = 1;
			}
			else{
				var email_reciever = 0;
			}

			if($("#report_access").is(':checked')){
				var report_access = 1;
			}
			else{
				var report_access = 0;
			}

			if($("#no_email").is(':checked')){
				var no_email = 1;
			}
			else{
				var no_email = 0;
			}


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
			var supplierData = $('#loading_supplier').val();
			var supplierContactData = $('#loading_supplier_contact_person').val();
			var supplierClientContactData = $('#loading_client_contact_person').val();
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
						url: '/supplier-postnewaccount',
						data: {
							username: username,
							email: email,
							password: password,
							account_name: account_name,
							contact_number: contact_number,
							email_reciever:email_reciever,
							report_access:report_access,
							no_email:no_email,
							site_url: site_url,
							supplier_id:supplierData,
							supplier_client_contact_id:supplierClientContactData,
							supplier_contact_id:supplierContactData,
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
			swal({
				title: "Error!",
				text: "Error: " + message,
				type: "error",
			});
		}

	}

</script>
