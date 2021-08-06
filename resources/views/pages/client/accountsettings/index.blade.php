@extends('layouts.client._new')
@section('title','Account Settings')
{{-- @section('page-title','Account Settings') --}}

@section('stylesheets')

@if(strpos(Request::url(''), 'tic-sera') !== false)
{{ Html::style('/css/admin/dashboard-sera.css') }}
@else
{{ Html::style('/css/admin/dashboard.css') }}
@endif
{!! Html::style('/css/register/index.css') !!}


<style>
	.ui-autocomplete {
		position: fixed;
		top: 100%;
		left: 0;
		z-index: 1051 !important;
		float: left;
		display: none;
		min-width: 160px;
		width: 160px;
		padding: 4px 0;
		margin: 2px 0 0 0;
		list-style: none;
		background-color: #ffffff;
		border-color: #ccc;
		border-color: rgba(0, 0, 0, 0.2);
		border-style: solid;
		border-width: 1px;
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		border-radius: 2px;
		-webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
		-moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
		box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
		-webkit-background-clip: padding-box;
		-moz-background-clip: padding;
		background-clip: padding-box;
		*border-right-width: 2px;
		*border-bottom-width: 2px;
	}

</style>
@endsection

@section('content')

<div class="row">
	@php
	$header_bg_color = '#ffa500';
	@endphp
	@if(strpos(Request::url(''), 'tic-sera') !== false)
	@php $header_bg_color='#dd4b39'; @endphp
	@endif
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading orange-background">
				<h3>Account Settings</h3>
			</div>

			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<tbody>
									<tr>
										<th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Account Details</th>
									</tr>
									<tr>
										<th class="col-md-3">Username:</th>
										<td class="col-md-3">{{ $user->username}}</td>
										<th class="col-md-3">Full Name:</th>
										<td class="col-md-3">{{ $user_info->name }}</td>
									</tr>
									<tr>
										<th class="col-md-3">Password:</th>
										<td class="col-md-3">
											{!! str_repeat('*', strlen($user->plain)) !!}
											<button class="btn btn-xs btn-default pull-right" type="button" data-toggle="modal" data-target="#changePassword"><i class="fa fa-key"></i> Change Password</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#changeUsername"><i class="fa fa-pencil"></i> Edit account details</button>
					</div>
				</div>
				<hr>
				<!-- AQL Settings -->

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<tbody>
									<tr>
										<th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Company Details</th>
									</tr>
									<tr>
										<th class="col-md-3">Company Name:</th>
										<td class="col-md-3">{{ $client->Company_Name}}</td>
										<th>Email:</th>
										<td>{{ $client->Company_Email}}</td>
									</tr>
									<tr>

										<th>Phone:</th>
										<td>{{ $client->Phone_number}}</td>
										<th>Country:</th>
										<td>{{ $client->company_country_name}}</td>
									</tr>
									<tr>
										<th>City:</th>
										<td>{{ $client->company_city_name}}</td>
										<th>Zip:</th>
										<td>{{ $client->company_zip_code}}</td>
									</tr>
									<tr>
										<th>Street Name:</th>
										<td>{{ $client->company_street_num}}</td>

										<th>House Number:</th>
										<td>{{ $client->company_house_num}}</td>
									</tr>
									<tr>
										<th>Building Name:</th>
										<td>{{ $client->company_bldg_num}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#companyModal"><i class="fa fa-pencil"></i> Edit company details</button>
					</div>
				</div>
				<hr>

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<tbody>
									<tr>
										<th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Invoice Address Details</th>
									</tr>
									<tr>
										<th class="col-md-3">Country:</th>
										<td class="col-md-3">{{ $client->company_invoice_country_name }}</td>
										<th>City:</th>
										<td>{{ $client->company_invoice_city_name}}</td>
									</tr>
									<tr>
										<th>Zip Code:</th>
										<td>{{ $client->company_inv_zip_code}}</td>
										<th>Street Name:</th>
										<td>{{ $client->company_inv_street_num}}</td>
									</tr>
									<tr>
										<th>House Number:</th>
										<td>{{ $client->company_inv_house_num}}</td>
										<th>Building Name:</th>
										<td>{{ $client->company_inv_bldg_num}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<button class="btn btn-success modalInvoiceShow  pull-right" type="button"><i class="fa fa-pencil"></i> Edit invoice details</button>
					</div>
				</div>
				<hr>

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<thead>
									<tr>
										<th colspan="6" style="background-color: {{ $header_bg_color}}; color:white;">Contact Person Details </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Tel #</th>
										<th>Mobile #</th>
										<th>Report Notifications</th>
										<th>Actions</th>
									</tr>
									@foreach($client_contact as $contacts)

									<tr>
										<td>{{ $contacts->contact_person}}</td>
										<td>{{ $contacts->email_address}}</td>
										<td>{{ $contacts->tel_number}}</td>
										<td>{{ $contacts->contact_number}}</td>
										@php
										if($contacts->report_notify == 1){
										$notify = "Yes";
										} else {
										$notify = "No";
										}
										@endphp
										<td>{{ $notify }}</td>
										<td>
											<button class="btn btn-warning btn-sm btn-cp" id="btn-edit-supplier-contact" data-id="{{ $contacts->id}}" type="button" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil"></i></button>
											<button class="btn btn-danger btn-sm btn-cp" id="btn-delete--supplier-contact" data-delete_id="{{ $contacts->id}}" type="button" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>

					<div class="col-md-12">
						<button class="btn btn-success pull-right" data-toggle="modal" data-target="#modalAddContact" type="button"><i class="fa fa-plus"></i> Add contact person</button>
					</div>

				</div>

				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="aql_table" class="table table-hover table-bordered">
								<tbody>
									<tr>
										<th colspan="6" style="background-color: {{ $header_bg_color}}; color:white;">Factory AQL Details</th>
									</tr>
									<tr>
										<th class="col-md-3">Normal Level:</th>
										<td class="col-md-3">
											@if ($client_aql_detail)
											{{$client_aql_detail->normal_level}}
											@endif
										</td>
										<th class="col-md-3">Special Level:</th>
										<td class="col-md-3">
											@if ($client_aql_detail)
											{{$client_aql_detail->special_level}}
											@endif
										</td>
									</tr>
									<tr>
										<th>Major:</th>
										<td class="hi">
											@if ($client_aql_detail)
											{{$client_aql_detail->aql_major}}
											@endif
										</td>
										<th>Minor:</th>
										<td class="hi">
											@if ($client_aql_detail)
											{{$client_aql_detail->aql_minor}}
											@endif
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#changeAQL"><i class="fa fa-pencil"></i> Edit AQL details</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('partials.client.accountSettings._changepass')
@include('partials.client.accountSettings.edit_username')
@include('partials.client.accountSettings.aql_details')
@include('partials.client.accountSettings.company')
@include('partials.client.accountSettings.invoice')
@include('partials.client.accountSettings.contactperson')
@include('partials.client.accountSettings.add_contact_person')
@include('partials.client.accountSettings.delete_contact_person')
<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
{!! Html::script('/js/client/account.js') !!}
{!! Html::script('/js/client/project.js') !!}
<script type="text/javascript">
	var auth_id = "{{Auth::id()}}";
	var token = "{{csrf_token()}}";

</script>

@endsection

<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	$(window).on('load', function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});

	$(document).ready(function() {





		$('.modalInvoiceShow').click(function() {
			console.log();
			var iddata = $("#invoice_country_id").val();
			$("#invoice_country2").val(iddata);
			//$("#invoice_country").val();
			$('#modalInvoice').modal();
			console.log($("#invoice_country2").val());
		});

		showAllCountry();
		var curr_county_id = $('#country_id').val();
		setTimeout(function() {
			$('#company_country').val(curr_county_id);
		}, 1000);
		$('#btn_upd_invoice').click(function() {
			var add = $('#invoice_form .validate_input');
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
				//updateCompany();
				console.log('test');
			} else {
				swal({
					title: "Oops!",
					text: "Please fill up required fields!",
					type: "warning",
				});
			}
		});
		$('#invoice_form .validate_input').change(function() {
			var val = $(this).val();
			if (val == '' || val == null) {
				$(this).css("border", "1px solid red");
			} else {
				$(this).removeAttr("style");
			}
		});
	});

	function showAllCountry() {
		$('.country').empty();
		$('.country').append('<option value="">Please Wait...</option>');
		$.ajax({
			url: '/get-all-country/1',
			type: 'GET',
			success: function(result) {
				$('.country').empty();
				$('.country').append('<option value="">Select Country</option>');
				//data_country = result;
				var data_country = JSON.parse(result);
				/*data_country.forEach(element => {
					if (element.name == "" || element.name == null) {

					} else {
						$('.country').append('<option value="' + element.id + '">' + element.name + '</option>');
					}
				});*/
				$.each(data_country, function(i, item) {
					//console.log(item.name);
					$('.country').append('<option value="' + item.id + '">' + item.name + '</option>');
					//$('.country').append('<option value="' + element.id + '">' + element.name + '</option>');
				});
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('.country').empty();
				$('.country').append('<option value="">Something went wrong. Please try again.</option>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
		});
	}

	function updateCompany() {
		$.ajax({
			url: '/update-client-info',
			type: 'POST',
			data: {
				_token: token,
				'is_request': 'company_request',
				'client_id': $('#client_id').val(),
				'company_name': $('#company_name').val(),
				'company_email': $('#company_email').val(),
				'company_phone': $('#company_phone').val(),
				'company_country_name': $('#company_country option:selected').text(),
				'company_country_id': $('#company_country').val(),
				'company_state_name': $('#company_state').val(),
				'company_state_id': $('#company_state').val(),
				'company_city_name': $('#company_city').val(),
				'company_city_id': $('#company_city').val(),
				'company_zip': $('#company_zip').val(),
				'company_house_num': $('#house_number').val(),
				'company_bldg_num': $('#bldg_number').val(),
			},
			beforeSend: function() {
				$('.send-loading ').show();
			},
			success: function(response) {
				console.log(response);
				$('.send-loading ').hide();

				swal({
					title: "Success!",
					text: "Company successfully updated!",
					type: "success",
				}, function() {
					//$('#newProduct').modal('hide');
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

	function updateInvoice() {
		$.ajax({
			url: '/update-client-info',
			type: 'POST',
			data: {
				_token: token,
				'is_request': 'invoice_request',
				'client_id': $('#client_id').val(),
				'inv_company_country_name': $('#inv_company_country option:selected').text(),
				'inv_company_country_id': $('#inv_company_country').val(),
				'inv_company_state_name': $('#inv_company_state').val(),
				'inv_company_state_id': $('#inv_company_state').val(),
				'inv_company_city_name': $('#inv_company_city').val(),
				'inv_company_city_id': $('#inv_company_city').val(),
				'inv_company_zip': $('#inv_company_zip').val(),
				'inv_company_house_num': $('#inv_house_number').val(),
				'inv_company_bldg_num': $('#inv_bldg_number').val(),
			},
			beforeSend: function() {
				$('.send-loading ').show();
			},
			success: function(response) {
				console.log(response);
				$('.send-loading ').hide();

				swal({
					title: "Success!",
					text: "Invoice successfully updated!",
					type: "success",
				}, function() {
					//$('#newProduct').modal('hide');
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
	$(document).ready(function() {
		$('#contactTable').DataTable();
	});

</script>
