<div id="updateSupplier" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg ui-front">
	  <!-- Modal content-->
	  <div class="modal-content">
		  <form data-parsley-validate=''>
			  {!!csrf_field()!!}
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Supplier Details</h4>
			  </div>
			  <div class="modal-body">
				<div class="row">
				  <div class="col-md-6">
					<div class="form-group">
						<input type="hidden" name="client_code" id="client_code" value="{{$supplierInfo->client_code}}">
					  {!! Form::label('supplier_name', 'Supplier Name') !!}
					  {!! Form::text('supplier_name', $supplierInfo->supplier_name, ['placeholder'=>'Supplier Name','class' => 'form-control validate_input empty_validation_supplier','required'=>'','data-parsley-required-message'=>"Please enter your supplier name"]) !!}
					</div>
				  </div>
				  <div class="col-md-6">
					  <div class="form-group">
						{!! Form::label('supplier_number', 'Supplier Number') !!}
						{!! Form::text('supplier_number', $supplierInfo->supplier_number, ['placeholder'=>'Supplier Number','class' => 'form-control validate_input empty_validation_supplier','required'=>'','data-parsley-required-message'=>"Please enter your supplier number"]) !!}
					  </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('supplier_code', 'Supplier Code') !!}
						{!! Form::text('supplier_code', $supplierInfo->supplier_code, ['placeholder'=>'Supplier Code','class' => 'form-control validate_input empty_validation_supplier','required'=>'','data-parsley-required-message'=>"Please enter your supplier code"]) !!}
					</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
						{!! Form::label('supplier_address', 'Supplier Address') !!}
						{!! Form::text('supplier_address', $supplierInfo->supplier_address, ['placeholder'=>'Supplier Address','class' => 'form-control validate_input empty_validation_supplier','required'=>'','data-parsley-required-message'=>"Please enter your supplier address "]) !!}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
						{!! Form::label('supplier_address_local', 'Supplier Local Address ') !!}
						{!! Form::text('supplier_address_local', $supplierInfo->supplier_address_local, ['placeholder'=>'Supplier Local Address','class' => 'form-control validate_input empty_validation_supplier','required'=>'','data-parsley-required-message'=>"Please enter your supplier address local"]) !!}
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('supplier_country', 'Country') !!}
							<select class="form-control country validate_input empty_validation_supplier" name="supplier_country" id="supplier_country">
							  <option value="">Select Country</option>
							</select>
							<input type="hidden" name="country_id" id="country_id" value="{{$supplierInfo->supplier_country}}">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('supplier_local_city', 'Supplier Local City') !!}
							{!! Form::text('supplier_local_city', $supplierInfo->supplier_local_city, ['placeholder'=>'City','class' => 'form-control validate_input empty_validation_supplier','required'=>'','data-parsley-required-message'=>"Please enter your supplier state"]) !!}
						</div>
					</div>
				  	<div class="col-md-6">
					  <div class="form-group">
						  {!! Form::label('supplier_city', 'Supplier City') !!}
						  {!! Form::text('supplier_city', $supplierInfo->supplier_city, ['placeholder'=>'Supplier City','class' => 'form-control validate_input empty_validation_supplier','required'=>'','data-parsley-required-message'=>"Please enter your city"]) !!}
					  </div>
					</div>
				</div>
				  <div class="col-md-12" id="edit-show-error-supplier" style="display:none;">
					<div class="alert alert-danger alert-dismissable" role="alert">
					  <a href="#" class="close" id="close-err-a-contact">&times;</a>
					  <strong>Error</strong> Please fill up the required fields.
					</div>
				  </div>
				</div>
			  <div class="modal-footer">
				{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
				{!! Form::button('<i class="fa fa-floppy-o"></i> Save changes', ['class' => 'btn btn-success','id'=>'btn_upd_supplier']) !!}
			  </div>
			</form>
	  	</div>
  	</div>
</div>
<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
  
  <script>
  jQuery(document).ready(function() {
			$('#close-err-e-contact').click(function() {
				$('#edit-show-error-supplier').hide();
			});
			showAllCountry();
			var curr_county_id = $('#country_id').val();
			setTimeout(function() {
			$('#supplier_country').val(curr_county_id);
			}, 1000);
		  $('#btn_upd_supplier').click(function() {
			  console.log('Edit Supplier Details');
			  $('#edit-show-error-supplier').hide();
			  var dis = $(this);
			  var add = $('.empty_validation_supplier');
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
				  $('#btn_upd_supplier').attr('disabled', true);
				  savealldata();
			  } else {
				  $('#edit-show-error-supplier').show();
			  }
  
		  });
		  function savealldata() {
			  $('#edit-show-error-supplier').hide();
			  $.ajax({
				  url: '/update-supplier-details',
				  type: 'POST',
				  data: {
					  _token: token,
					'client_code': $('#client_code').val(),
					'supplier_name' : $('#supplier_name').val(),
					'supplier_number' : $('#supplier_number').val(),
					'supplier_code' : $('#supplier_code').val(),
					'supplier_address' : $('#supplier_address').val(),
					'supplier_address_local' : $('#supplier_address_local').val(),
					'supplier_local_address' : $('#supplier_local_address').val(),
					'supplier_local_city': $('#supplier_local_city').val(),
					'supplier_country': $('#supplier_country').val(),
					'supplier_country_name': $('#supplier_country option:selected').text(),
					'supplier_state' : $('#supplier_state').val(),
					'supplier_state_id' : $('#supplier_state_id').val(),
					'supplier_city' : $('#supplier_city').val(),
					'supplier_city_id' : $('#supplier_city_id').val(),
					'supplier_status': $('#supplier_status').val(),
				  },
				  beforeSend: function() {
					  $('.send-loading ').show();
				  },
				  success: function(response) {
					  console.log(response);
					  $('.send-loading ').hide();
					  swal({
						  title: "Success!",
						  text: "Supplier Details successfully updated!",
						  type: "success",
					  }, function() {
						  $('#updateSupplier').modal('hide');
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
		  function showAllCountry() {
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
					/*data_country.forEach(element => {
						if (element.name == "" || element.name == null) {

						} else {
							$('#company_country').append('<option value="' + element.id + '">' + element.name + '</option>');
						}

					});*/
					
					$.each(data_country, function(i, item) {
						//console.log(item.name);
						$('#supplier_country').append('<option value="' + item.id + '">' + item.name + '</option>');
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
	});
</script>