<div id="companyModal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form data-parsley-validate=''>
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Company Details</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="hidden" name="client_code" id="client_code" value="{{$client->client_code}}">
								{!! Form::label('company_name', 'Company Name') !!}
								{!! Form::text('company_name', $client->Company_Name, ['placeholder'=>'Company Name','class' => 'form-control validate_input empty_validation_company','required'=>'','data-parsley-required-message'=>"Please enter your company name"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('company_email', 'Email Address') !!}
								{!! Form::text('company_email', $client->Company_Email, ['placeholder'=>'Company Email Address','class' => 'form-control validate_input empty_validation_company','required'=>'','data-parsley-required-message'=>"Please enter at least one company email"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('company_phone', 'Phone') !!}
								{!! Form::text('company_phone', $client->Phone_number, ['placeholder'=>'Company Phone','class' => 'form-control validate_input empty_validation_company','required'=>'','data-parsley-required-message'=>"Please enter company phone number"]) !!}
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('company_country', 'Country') !!}
								<select class="form-control country validate_input empty_validation_company" name="company_country" id="company_country">
									<option value="">Select Country</option>
								</select>
								<input type="hidden" name="country_id" id="country_id" value="{{$client->company_country_id}}">
							</div>
						</div>
						<!--<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('company_state', 'State') !!}
								{!! Form::text('company_state', $client->company_state_name, ['placeholder'=>'State','class' => 'form-control validate_input empty_validation_company','required'=>'','data-parsley-required-message'=>"Please enter your state"]) !!}
								<input type="hidden" class="form-control" name="hidden_company_state_id" id="hidden_company_state_id" required>
							</div>
						</div>-->

						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('company_city', 'City') !!}
								{!! Form::text('company_city', $client->company_city_name, ['placeholder'=>'City','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your City"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('company_zip', 'Zip Code') !!}
								{!! Form::text('company_zip', $client->company_zip_code, ['placeholder'=>'Zip/Postal Code','class' => 'form-control number','required'=>'','data-parsley-required-message'=>"Please enter your Zip/Postal Code",'data-parsley-type'=>'number']) !!}
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('company_street_num', 'Street Name') !!}
								{!! Form::text('company_street_num',$client->company_street_num,['class'=>'form-control', 'rows' => 2, 'cols' => 40, 'required'=>'']) !!}

							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('house_number', 'House Number') !!}
								{!! Form::text('house_number', $client->company_house_num, ['placeholder'=>'House number','class' => 'form-control','required'=>'','data-parsley-required-message'=>"Please enter your City"]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('bldg_number', 'Building Name') !!}
								{!! Form::text('bldg_number', $client->company_bldg_num, ['placeholder'=>'Building Number','class' => 'form-control number','required'=>'']) !!}
							</div>
						</div>
					
						<div class="col-md-12" id="edit-show-error-company" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-contact">&times;</a>
								<strong>Error</strong> Please fill up the required fields.
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save changes', ['class' => 'btn btn-success','id'=>'btn_upd_comp']) !!}
				</div>
			</form>
		</div>

	</div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {
		$('#close-err-e-contact').click(function() {
			$('#edit-show-error-company').hide();
		});
		showAllCountry();
		
		$('#btn_upd_comp').click(function() {
			console.log('Edit Company Details');
			$('#edit-show-error-company').hide();
			var dis = $(this);
			var add = $('.empty_validation_company');
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
				$('#btn_upd_comp').attr('disabled', true);
				//console.log(count);
				//console.log(subcount);
				savealldata();
			} else {
				$('#edit-show-error-company').show();
			}

		});


		function savealldata() {
			$('#edit-show-error-company').hide();
			$.ajax({
				url: '/update-company-details',
				type: 'POST',
				data: {
					_token: token,
					'client_code': $('#client_code').val(),
					'company_name': $('#company_name').val(),
					'company_email': $('#company_email').val(),
					'company_phone': $('#company_phone').val(),
					'company_country_id': $('#company_country').val(),
					'company_country': $('#company_country option:selected').text(),
					'company_state': $('#company_state').val(),
					'company_city': $('#company_city').val(),
					'company_zip': $('#company_zip').val(),
					'house_number': $('#house_number').val(),
					'bldg_number': $('#bldg_number').val(),
					'company_street_num': $('#company_street_num').val()
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					console.log(response);
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Company Details successfully updated!",
						type: "success",
					}, function() {
						$('#companyModal').modal('hide');
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
		
		
		

		/*$('#btn_upd_comp').click(function() {
			console.log('test Edit Aql Details');
			$('#edit-show-error-company').hide();
			$('.send-loading ').show();
			$.ajax({
				url: '/update-company-details',
				type: 'POST',
				data: {
					_token: token,
					'client_code': $('#client_code').val(),
					'company_name': $('#company_name').val(),
					'company_email': $('#company_email').val(),
					'company_phone': $('#company_phone').val(),
					'company_country_id': $('#company_country').val(),
					'company_country': $('#company_country option:selected').text(),
					'company_state': $('#company_state').val(),
					'company_city': $('#company_city').val(),
					'company_zip': $('#company_zip').val(),
					'house_number': $('#house_number').val(),
					'bldg_number': $('#bldg_number').val(),
					'company_street_num': $('#company_street_num').val()
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					console.log(response);
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Company Details successfully updated!",
						type: "success",
					}, function() {
						$('#companyModal').modal('hide');
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
		});*/

		function showAllCountry() {
			$('#company_country').empty();
			$('#company_country').append('<option value="">Please Wait...</option>');
			$.ajax({
				url: '/get-all-country/1',
				type: 'GET',
				success: function(result) {
					$('#company_country').empty();
					$('#company_country').append('<option value="">Select Country</option>');
					//data_country = result;
					var data_country = JSON.parse(result);
					/*data_country.forEach(element => {
						if (element.name == "" || element.name == null) {

						} else {
							$('#company_country').append('<option value="' + element.id + '">' + element.name + '</option>');
						}

					});*/
					
					$.each(data_country, function(i, item) {
						//console.log(item.name);
						$('#company_country').append('<option value="' + item.id + '">' + item.name + '</option>');
					});
					

				},
				error: function(jqXHR, textStatus, errorThrown) {
					$('#company_country').empty();
					$('#company_country').append('<option value="">Something went wrong. Please try again.</option>');

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

		//$('#company_country').on('change', function() {
		//	showStateByCountry();
			/*textInputValidator(this.id);*/
		//});

		//$('#company_state').on('change', function() {
			//showCityByCountryAndState();
			/*textInputValidator(this.id);*/
		//});

		var source_state = [];

		$('#company_state').autocomplete({
			maxResults: 10,
			source: function(request, response) {
				var results = $.ui.autocomplete.filter(source_state, request.term);

				response(results.slice(0, this.options.maxResults));
			},
			select: function(event, ui) {
				$("#company_state").val(ui.item.label); // display the selected text
				$("#hidden_company_state_id").val(ui.item.value); // save selected id to hidden input
				return false;
			}
		});


		/*function showStateByCountry() {
			var id = $('#company_country').val();
			var country_name = $('#company_country option:selected').text();
			$("#company_state").val('Please wait...');
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
							//$('#company_state').append('<option value="'+element.id+'">'+element.name+'</option>');
							source_state.push({
								value: element.id,
								label: element.name
							});
						}
					});
					
					$.each(data_country, function(i, item) {
						//console.log(item.name);
						$('#company_country').append('<option value="' + item.id + '">' + item.name + '</option>');
					});
					$("#company_state").val('');

				},
				error: function(jqXHR, textStatus, errorThrown) {
					$('#company_state').empty();
					$('#company_state').append('<option value="">Something went wrong. Please try again.</option>');
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

		$('#company_city').autocomplete({
			maxResults: 10,
			source: function(request, response) {
				var results = $.ui.autocomplete.filter(source_city, request.term);

				response(results.slice(0, this.options.maxResults));
			}
		});

		$("#company_city").autocomplete("option", "appendTo", ".eventInsForm");

		/*function showCityByCountryAndState() {
			var cid = $('#company_country').val();
			var sid = $('#hidden_company_state_id').val();

			$('#company_city').val('Please Wait...');
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
							// $('#company_city').append('<option value="'+element.id+'">'+element.name+'</option>');
							source_city.push(element.name);
						}
					});
					$('#company_city').val('');

				},
				error: function(jqXHR, textStatus, errorThrown) {
					$('#mcompany_city').empty();
					$('#mcompany_city').append('<option value="">Something went wrong. Please try again.</option>');
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
	});

</script>
