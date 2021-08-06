<div id="newSupplier" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg ui-front">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add New Supplier</h4>
			</div>
			<form data-parsley-validate='' method="POST" action="" id="form_add_supplier">
				{!!csrf_field()!!}
				<div class="modal-body">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="supplier_name"><span class="text-danger">*</span> Supplier Name</label>
								<input type="text" name="supplier_name" class="form-control validate_input" id="supplier_name">
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="supplier_number"><span class="text-danger">*</span> Supplier Code / Number</label>
								<input type="text" name="supplier_number" class="form-control validate_input" id="supplier_number" required>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="supplier_country"><span class="text-danger">*</span> Country</label>
								<select class="form-control validate_input" required name="supplier_country" id="supplier_country">
									<option value="">--Select Country--</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="supplier_address_local"> <span class="text-danger">*</span> Supplier City (English)</label>
								<input type="text" name="supplier_city" class="form-control validate_input" id="supplier_city" required>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="supplier_address2"> <span class="text-danger">*</span> Supplier Address (English)</label>
								<input type="text" name="supplier_address2" class="form-control validate_input" id="supplier_address2" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="supplier_address_local"> Supplier City (Local Language)</label>
								<input type="text" name="supplier_local_city" class="form-control" id="supplier_local_city" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="supplier_address_local"> Supplier Address (Local Language)</label>
								<input type="text" name="supplier_local_address" class="form-control" id="supplier_local_address" required>
							</div>
						</div>

						<div class="supplier-clone">
							<div class="s-clone-inputs">
								<div class="col-md-12">
									<h4>Supplier Contact Person</h4>
									<hr>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="contact_person"><span class="text-danger">*</span> Contact Person</label>
										<input type="text" name="contact_person" id="contact_person" class="form-control f_contact_person validate_input" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="contact_person_email"><span class="text-danger">*</span> Email Address</label>
										<input type="email" name="contact_person_email" id="contact_person_email" class="form-control f_contact_person_email validate_input_email" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="contact_person_number"><span class="text-danger">*</span> Mobile Number</label>
										<input type="text" name="contact_person_number" id="contact_person_number" class="form-control numeric f_contact_person_number validate_input" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="ff_contact_person_tel_number"><span class="text-danger">*</span> Telephone Number</label>
										<input type="text" name="ff_contact_person_tel_number" id="ff_contact_person_tel_number" class="form-control numeric ff_contact_person_tel_number validate_input" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="contact_skype">Skype</label>
										<input type="text" name="contact_skype" id="contact_skype" class="form-control f_contact_skype" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="contact_wechat">We Chat</label>
										<input type="text" name="contact_wechat" id="contact_wechat" class="form-control f_contact_wechat" required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="contact_whatsapp">WhatsApp</label>
										<input type="text" name="contact_whatsapp" id="contact_whatsapp" class="form-control f_contact_whatsapp " required>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<label for="contact_qqmail">QQ Mail</label>
										<input type="text" name="contact_qqmail" id="contact_qqmail" class="form-control f_contact_qqmail " required>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<button class="btn btn-success" type="button" id="s_btn_add_more_fields"><i class="fa fa-plus"></i> Add more contact person</button>
							</div>
						</div>
						<div class="col-md-12">
							<div class="checkbox">
								<label><input type="checkbox" value="false" id="check_factory">Please check if this supplier is same as factory.</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save Supplier Details', ['class' => 'btn btn-success','type'=>'button','id'=>'btn_save_supplier']) !!}
					<input type="hidden" name="hidden_client_code" id="hidden_client_code" value="{{$client_code}}">
				</div>
			</form>
		</div>
	</div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script>
	$(document).ready(function() {
		showAllCountryS();
		var max_fields = 10;
		var new_field_html = '<div class="row"><div class="col-md-12"><hr></div><div class="col-md-4"><div class="form-group"><label for="contact_person">Contact Person</label><input type="text" name="contact_person" onchange="checkeds2()" id="contact_person" class="form-control" required><div id="supplier7" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_person_email">Email Address</label><input type="email" name="contact_person_email" onchange="checkeds2()" id="contact_person_email" class="form-control" required><div id="supplier8" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_person_number">Contact Number</label><input type="text" name="contact_person_number" onchange="checkeds2()" id="contact_person_number" class="form-control numeric" required><div id="supplier9" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_skype">Skype</label><input type="text" name="contact_skype"  id="contact_skype" class="form-control" required><div id="supplier10" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_wechat">We Chat</label><input type="text" name="contact_wechat"  id="contact_wechat" class="form-control" required><div id="supplier11" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_whatsapp">WhatsApp</label><input type="text" name="contact_whatsapp" id="contact_whatsapp" class="form-control" required><div id="supplier12" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_qqmail">QQ Mail</label><input type="text" name="contact_qqmail"  id="contact_qqmail" class="form-control" required><div id="supplier13" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><button class="btn btn-danger remove_input_button" type="button"><i class="fa fa-trash"></i> Remove </button></div>';
		var input_count = 1;
		// Add button dynamically
		$('.btn_add_more').click(function() {
			if (input_count < max_fields) {
				input_count++;
				$('#div_more_supplier').append(new_field_html);
			}
		});

		// Remove dynamically added button
		$('#div_more_supplier').on('click', '.remove_input_button', function(e) {
			e.preventDefault();
			$(this).parent('div').remove();
			input_count--;
		});

		$('#btn_save_supplier').click(function() {
			var add = $('#form_add_supplier .validate_input');
			var email_add = $('#form_add_supplier .validate_input_email');
			var add_count_null = 0;
			var email_err = 0;
			for (var i = 0; i < add.length; i++) {
				var data = $(add[i]).val();
				if (data == "") {
					$(add[i]).css("border", "1px solid red");
					add_count_null += 1;
				} else {
					$(add[i]).removeAttr("style");
				}
			}
			//for email
			for (var i = 0; i < email_add.length; i++) {
				var data = $(email_add[i]).val();
				if (!isEmailS(data)) {
					$(email_add[i]).css("border", "1px solid red");
					email_err += 1;
				} else {
					$(email_add[i]).removeAttr("style");
				}
			}

			if (add_count_null == 0 && email_err == 0) {
				savesupplierDetails();
				console.log('test');
			} else {
				swal({
					title: "Oops!",
					text: "Please check empty or invalid input fields!",
					type: "warning",
				});
			}
		});
		$('#form_add_supplier .validate_input').change(function() {
			var val = $(this).val();
			if (val == '' || val == null) {
				$(this).css("border", "1px solid red");
			} else {
				$(this).removeAttr("style");
			}
		});
		$('#form_add_supplier .validate_input_email').change(function() {
			var val = $(this).val();
			if (val == '' || val == null) {
				$(this).css("border", "1px solid red");
			} else {
				if (!isEmailS(val)) {
					$(this).css("border", "1px solid red");
				} else {
					$(this).removeAttr("style");
				}
			}
		});

		$('#check_factory').click(function() {
			if (this.checked) {
				$(this).val('true');
			} else {
				$(this).val('false');
			}
		})

	});

	function savesupplierDetails() {
		$('.send-loading ').show();
		var same_as_factory = $('#check_factory').val();
		var client_code = jQuery('#hidden_client_code').val();
		var supplier_name = jQuery('#supplier_name').val();
		var supplier_number = jQuery('#supplier_number').val();




		/* var supplier_address_local = jQuery('#supplier_address_local').val(); */
		var supplier_city = jQuery('#supplier_city').val();
		var supplier_address = jQuery('#supplier_address2').val();
		var supplier_local_city = jQuery('#supplier_local_city').val();
		var supplier_local_address = jQuery('#supplier_local_address').val();


		var supplier_country = jQuery('#supplier_country').val();
		//var supplier_state_id = jQuery('#hidden_supplier_state_id').val();
		//var supplier_city_id = jQuery('#supplier_city').val();
		var supplier_country_name = jQuery('#supplier_country option:selected').text();
		//var supplier_state = jQuery('#supplier_state').val();





		//var supplier_address = supplier_city + ', ' + supplier_state + ', ' + supplier_country_name;
		var contact_person = jQuery('.f_contact_person');
		var contact_person_email = jQuery('.f_contact_person_email');
		var contact_person_number = jQuery('.f_contact_person_number');
		var f_contact_person_tel_number = jQuery('.ff_contact_person_tel_number');
		var supplier_contact_skype = jQuery('.f_contact_skype');
		var supplier_contact_wechat = jQuery('.f_contact_wechat');
		var supplier_contact_whatsapp = jQuery('.f_contact_whatsapp');
		var supplier_contact_qqmail = jQuery('.f_contact_qqmail');
		var c_person = [];
		var c_person_email = [];
		var c_person_number = [];
		var c_person_tel_number = [];
		var f_contact_skype = [];
		var f_contact_wechat = [];
		var f_contact_whatsapp = [];
		var f_contact_qqmail = [];
		var count_null = 0; //variable for counting the null values

		for (var i = 0; i < contact_person.length; i++) {
			var g_data = $(contact_person[i]).val();
			if (g_data == "") {
				c_person.push("N/A");
			} else {
				c_person.push(g_data);
			}
		}
		for (var i = 0; i < contact_person_email.length; i++) {
			var g_data = $(contact_person_email[i]).val();
			if (g_data == "") {
				c_person_email.push("N/A");
			} else {
				c_person_email.push(g_data);
			}
		}
		for (var i = 0; i < contact_person_number.length; i++) {
			var g_data = $(contact_person_number[i]).val();
			if (g_data == "") {
				c_person_number.push("N/A");
			} else {
				c_person_number.push(g_data);
			}
		}
		for (var i = 0; i < f_contact_person_tel_number.length; i++) {
			var g_data = $(f_contact_person_tel_number[i]).val();
			if (g_data == "") {
				c_person_tel_number.push("N/A");
			} else {
				c_person_tel_number.push(g_data);
			}
		}
		for (var i = 0; i < supplier_contact_skype.length; i++) {
			var g_data = $(supplier_contact_skype[i]).val();
			if (g_data == "") {
				f_contact_skype.push("N/A");
			} else {
				f_contact_skype.push(g_data);
			}
		}
		for (var i = 0; i < supplier_contact_wechat.length; i++) {
			var g_data = $(supplier_contact_wechat[i]).val();
			if (g_data == "") {
				f_contact_wechat.push("N/A");
			} else {
				f_contact_wechat.push(g_data);
			}
		}
		for (var i = 0; i < supplier_contact_whatsapp.length; i++) {
			var g_data = $(supplier_contact_whatsapp[i]).val();
			if (g_data == "") {
				f_contact_whatsapp.push("N/A");
			} else {
				f_contact_whatsapp.push(g_data);
			}
		}
		for (var i = 0; i < supplier_contact_qqmail.length; i++) {
			var g_data = $(supplier_contact_qqmail[i]).val();
			if (g_data == "") {
				f_contact_qqmail.push("N/A");
			} else {
				f_contact_qqmail.push(g_data);
			}
		}
		$.ajax({
			type: 'POST',
			url: '/client-postnewsupplier',
			data: {
				_token: token,
				same_as_factory: same_as_factory,

				same_as_factory: same_as_factory,
				client_code: client_code,
				supplier_name: supplier_name,
				supplier_number: supplier_number,


				supplier_city: supplier_city,
				supplier_local_address: supplier_local_address,
				supplier_address: supplier_address,
				supplier_local_city: supplier_local_city,

				/* 	supplier_address_local: supplier_address_local, */

				supplier_country: supplier_country,
				supplier_country_name: supplier_country_name,


				//supplier_state: supplier_state,
				//supplier_city_id: supplier_city_id,
				//supplier_state_id: supplier_state_id,
				contact_person: c_person,
				contact_person_email: c_person_email,
				contact_person_number: c_person_number,
				c_person_tel_number: c_person_tel_number,
				supplier_contact_skype: f_contact_skype,
				supplier_contact_wechat: f_contact_wechat,
				supplier_contact_whatsapp: f_contact_whatsapp,
				supplier_contact_qqmail: f_contact_qqmail
			},
			success: function(data) {
				var sup_id = data.supplier;
				$('.supplier').append('<option value="' + sup_id + '">' + supplier_name + '</option>');
				$('.send-loading ').hide();
				swal({
					title: "Success",
					text: "Supplier successfully added",
					type: "success",
				}, function() {
					
					$('#newSupplier').modal('toggle');
					$('#form_add_supplier')[0].reset();
					//$('#supplier_name').val('');
					//$('#check_factory').val();
					/*$('#hidden_client_code').val();
					$('#supplier_name').val();
					$('#supplier_number').val();
					$('#supplier_city').val();
					$('#supplier_address2').val();
					$('#supplier_local_city').val();
					$('#supplier_local_address').val();
					$('#supplier_country').val();
					$('#supplier_country option:selected').text();
					$('.f_contact_person');
					v$('.f_contact_person_email');
					$('.f_contact_person_number');
					$('.ff_contact_person_tel_number');
					$('.f_contact_skype');
					$('.f_contact_wechat');
					$('.f_contact_whatsapp');
					$('.f_contact_qqmail');*/
					
				});
			},
			error: function() {
				swal({
					title: "Error",
					text: "Error: Server encountered an error. Please try again or contact your system administrator.",
					type: "error",
				});
				$('.send-loading ').hide();
			}
		});
	}

	function showAllCountryS() {
		$('#supplier_country').empty();
		$('#supplier_country').append('<option value="">Please Wait...</option>');
		$.ajax({
			url: '/get-all-country/1',
			type: 'GET',
			success: function(result) {
				$('#supplier_country').empty();
				$('#supplier_country').append('<option value="">Select Country</option>');
				//data_country = result;
				var data_country = JSON.parse(result);
				$.each(data_country, function(i, element) {
					if (element.name == "" || element.name == null) {

					} else {
						$('#supplier_country').append('<option value="' + element.id + '">' + element.name + '</option>');
					}

				});

			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#supplier_country').empty();
				$('#supplier_country').append('<option value="">Something went wrong. Please try again.</option>');

				$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
		});
	}

	$('#supplier_country').on('change', function() {
		/* showStateByCountryS();
		textInputValidator(this.id); */
	});

	$('#supplier_state').on('change', function() {
		showCityByCountryAndStateS();
		textInputValidator(this.id);
	});

	var source_state = [];

	$('#supplier_state').autocomplete({
		maxResults: 10,
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(source_state, request.term);

			response(results.slice(0, this.options.maxResults));
		},
		select: function(event, ui) {
			$("#supplier_state").val(ui.item.label); // display the selected text
			$("#hidden_supplier_state_id").val(ui.item.value); // save selected id to hidden input
			return false;
		}
	});


	function showStateByCountryS() {
		var id = $('#supplier_country').val();
		var country_name = $('#supplier_country option:selected').text();
		$("#supplier_state").val('Please wait...');
		$.ajax({
			url: '/get-state/' + id,
			type: 'GET',
			success: function(result) {
				//var data_country = result;
				var data_country = JSON.parse(result);
				source_state.length = 0;
				$.each(data_country, function(i, element) {
					if (element.name == "" || element.name == null) {

					} else {
						//$('#supplier_state').append('<option value="'+element.id+'">'+element.name+'</option>');
						source_state.push({
							value: element.id,
							label: element.name
						});
					}
				});
				$("#supplier_state").val('');

			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#supplier_state').empty();
				$('#supplier_state').append('<option value="">Something went wrong. Please try again.</option>');
				$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
		});
	}

	var source_city = [];

	$('#supplier_city').autocomplete({
		maxResults: 10,
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(source_city, request.term);

			response(results.slice(0, this.options.maxResults));
		}
	});

	$("#supplier_city").autocomplete("option", "appendTo", ".eventInsForm");

	function showCityByCountryAndStateS() {
		var cid = $('#supplier_country').val();
		var sid = $('#hidden_supplier_state_id').val();

		$('#supplier_city').val('Please Wait...');
		$.ajax({
			url: '/get-city' + sid,
			type: 'GET',
			success: function(result) {
				console.log(result);
				//var data_city = result;
				var data_city = JSON.parse(result);
				source_city.length = 0;
				$.each(data_city, function(i, element) {
					if (element.name == "" || element.name == null) {

					} else {
						// $('#supplier_city').append('<option value="'+element.id+'">'+element.name+'</option>');
						source_city.push(element.name);
					}
				});
				$('#supplier_city').val('');

			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#msupplier_city').empty();
				$('#msupplier_city').append('<option value="">Something went wrong. Please try again.</option>');
				$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
		});
	}

	$('#s_btn_add_more_fields').click(function() {
		$('.s-clone-inputs:first').clone().appendTo('.product-clone').find("input").val("");
		$('.s-clone-inputs:last').append('<div class="col-md-4">' +
			'<div class="form-group"><br>' +
			'<button type="button" class="btn btn-danger s-btn-rm btn-block" style="margin-top:5px;" onclick="removeFields()"><i class="fa fa-times"></i> Delete</button>' +
			'</div>' +
			'</div>');
	});

	$('body').on('click', '.s-btn-rm', function() {
		$(this).closest('.s-clone-inputs').remove();
	});


	function isEmailS(email) {
		//var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		var regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
		return regex.test(email);
	}

</script>
