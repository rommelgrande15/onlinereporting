<div id="modalInvoice" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<form data-parsley-validate='' id="invoice_form">
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Update invoice details</h4>
				</div>
				<div class="modal-body">
					<div class="row">



						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('invoice_country', 'Country') !!}
								<select class="form-control country invoice_country validate_input empty_validation_invoice" name="invoice_country" id="invoice_country2">
									<option value="">Select Country</option>
								</select>
								<input type="hidden" name="invoice_country_id" id="invoice_country_id" value="{{$client->company_invoice_country_id}}">
							</div>
						</div>
						<!--<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('invoice_state', 'State') !!}
								{!! Form::text('invoice_state', $client->company_invoice_state_name, ['placeholder'=>'State','class' => 'form-control validate_input empty_validation_invoice','required'=>'','data-parsley-required-message'=>"Please enter your state"]) !!}
								<input type="hidden" class="form-control" name="hidden_invoice_state_id" id="hidden_invoice_state_id" required>
							</div>
						</div>-->
						
		
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('invoice_city', 'City') !!}
								{!! Form::text('invoice_city', $client->company_invoice_city_name, ['placeholder'=>'City','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your City"]) !!}
								<input type="hidden" class="form-control" name="hidden_invoice_city_id" id="hidden_invoice_city_id" required>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('inv_company_zip', 'Zip Code') !!}
								{!! Form::text('inv_company_zip', $client->company_inv_zip_code, ['placeholder'=>'Zip/Postal Code','class' => 'form-control','data-parsley-required-message'=>"Please enter your Zip/Postal Code",'data-parsley-type'=>'number']) !!}
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('company_inv_street_num', 'Street Name') !!}
								{!! Form::text('company_inv_street_num', $client->company_inv_street_num, ['placeholder'=>'Street Name','class' => 'form-control validate_input','required'=>'']) !!}
							</div>
						</div>


						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('inv_house_number', 'House number') !!}
								{!! Form::text('inv_house_number', $client->company_inv_house_num, ['placeholder'=>'House number','class' => 'form-control validate_input','required'=>'','data-parsley-required-message'=>"Please enter your City"]) !!}
							</div>
						</div>

						
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('inv_bldg_number', 'Building Name') !!}
								{!! Form::text('inv_bldg_number', $client->company_inv_bldg_num, ['placeholder'=>'Building Name','class' => 'form-control ']) !!}
							</div>
						</div>
						
						
						<!--<div class="col-md-12">
							<div class="form-group">
								{!! Form::label('company_inv_street_num', 'Street') !!}
								{!! Form::textarea('company_inv_street_num',$client->company_inv_street_num,['class'=>'form-control', 'rows' => 2, 'cols' => 40, 'required'=>'']) !!}

							</div>
						</div>-->


						<div class="col-md-12" id="edit-show-error-invoice" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-invoice">&times;</a>
								<strong>Error</strong> Please fill up the required fields.
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save Changes', ['type'=>'button','class' => 'btn btn-success','id'=>'btn-update-invoice']) !!}
				</div>
			</form>
		</div>

	</div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {
		showAllCountry2();

		$('#close-err-e-prod').click(function() {
			$('#edit-show-error').hide();
		});
		
		$('#btn-update-invoice').click(function() {
			console.log('Edit Invoice Details');
			$('#edit-show-error-invoice').hide();
			var dis = $(this);
			var add = $('.empty_validation_invoice');
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
			if (add_count_null == 0) {
				$('#show-error').hide();
				$(this).text("Saving...");
				$('#btn-update-invoice').attr('disabled', true);showAllCountry
				//console.log(count);
				//console.log(subcount);
				savealldata();
			} else {
				$('#edit-show-error-invoice').show();
			}

		});


		function savealldata() {
			$('#edit-show-error-invoice').hide();
			$.ajax({
				url: '/update-invoice-details',
				type: 'POST',
				data: {
					_token: token,
					'client_code': $('#client_code').val(),
					'inv_company_country_name': $('#invoice_country2 option:selected').text(),
					'inv_country_id': $('#invoice_country2').val(),
					'inv_company_state_name': $('#invoice_state').val(),
					'inv_company_city_name': $('#invoice_city').val(),
					'inv_company_zip': $('#inv_company_zip').val(),
					'inv_company_house_num': $('#inv_house_number').val(),
					'inv_company_bldg_num': $('#inv_bldg_number').val(),
					'company_inv_street_num': $('#company_inv_street_num').val()
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					//console.log(response);
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Invoice Address Details successfully updated!",
						type: "success",
					}, function() {
						$('#modalInvoice').modal('hide');
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

	function showAllCountry2() {
		
		$('.invoice_country').empty();
		$('.invoice_country').append('<option value="">Please Wait...</option>');
		$.ajax({
			url: '/get-all-country/1',
			type: 'GET',
			success: function(result) {
				$('.invoice_country').empty();
				$('.invoice_country').append('<option value="">Select Country</option>');
				data_country = result;
				var data_country = JSON.parse(result);
				/*data_country.forEach(element => {
					if (element.name == "" || element.name == null) {

					} else {
						$('.invoice_country').append('<option value="' + element.id + '">' + element.name + '</option>');
					}
				});*/
				
				$.each(data_country, function(i, item) {
						//console.log(item.name);
						$('.invoice_country').append('<option value="' + item.id + '">' + item.name + '</option>');
					});


			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.invoice_country').empty();
				$('.invoice_country').append('<option value="">Something went wrong. Please try again.</option>');

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

	/*$('.invoice_country').on('change', function() {
		showStateByCountry();
		//textInputValidator(this.id);
	});

	$('#invoice_state').on('change', function() {
		showCityByCountryAndState();
		//textInputValidator(this.id);
	});*/

	var source_state = [];

	$('#invoice_state').autocomplete({
		maxResults: 10,
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(source_state, request.term);

			response(results.slice(0, this.options.maxResults));
		},
		select: function(event, ui) {
			$("#invoice_state").val(ui.item.label); // display the selected text
			$("#hidden_invoice_state_id").val(ui.item.value); // save selected id to hidden input
			return false;
		}
	});


	/*function showStateByCountry() {
		var id = $('.invoice_country').val();
		var country_name = $('.invoice_country option:selected').text();
		$("#invoice_state").val('Please wait...');
		$.ajax({
			url: '/get-state/' + id,
			type: 'GET',
			success: function(result) {
				//var data_country = result;
				var data_country = JSON.parse(result);
				source_state.length = 0;
				data_country.forEach(element => {
					if (element.name == "" || element.name == null) {

					} else {
						//$('#supplier_state').append('<option value="'+element.id+'">'+element.name+'</option>');
						source_state.push({
							value: element.id,
							label: element.name
						});
					}
				});
				
				
				$("#invoice_state").val('');
				

			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#invoice_state').empty();
				$('#invoice_state').append('<option value="">Something went wrong. Please try again.</option>');
				$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
		});
	}*/

	var source_city = [];

	$('#invoice_city').autocomplete({
		maxResults: 10,
		source: function(request, response) {
			var results = $.ui.autocomplete.filter(source_city, request.term);

			response(results.slice(0, this.options.maxResults));
		}
	});

	$("#invoice_city").autocomplete("option", "appendTo", ".eventInsForm");

	/*function showCityByCountryAndState() {
		var cid = $('.invoice_country').val();
		var sid = $('#hidden_invoice_state_id').val();

		$('#invoice_city').val('Please Wait...');
		$.ajax({
			url: '/get-city/' + sid,
			type: 'GET',
			success: function(result) {
				console.log(result);
				//var data_city = result;
				var data_city = JSON.parse(result);
				source_city.length = 0;
				data_city.forEach(element => {
					if (element.name == "" || element.name == null) {

					} else {
						// $('#supplier_city').append('<option value="'+element.id+'">'+element.name+'</option>');
						source_city.push(element.name);
					}
				});
				$('#invoice_city').val('');

			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#minvoice_city').empty();
				$('#minvoice_city').append('<option value="">Something went wrong. Please try again.</option>');
				$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
		});
	}*/

</script>
