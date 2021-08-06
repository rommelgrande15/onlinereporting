@extends('layouts.client._new2')
@section('title','Account Settings')
{{-- @section('page-title','Account Settings') --}}

@section('stylesheets')
{{ Html::style('/css/admin/dashboard.css') }}
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
@if(strpos(Request::url(''), 'tic-sera') !== false)
	@php
		$color_border='sera-border'; 
		$color_bg='sera-background'; 
		$color_text='sera-text'; 
		$color_panel_body='panel-body-sera'; 
		$site_url='tic-sera';
		$th_bg='f71d3a';
	@endphp
@else
	@php
		$color_border='orange-border'; 
		$color_bg='orange-background'; 
		$color_text='orange-text'; 
		$color_panel_body=''; 
		$site_url='tic';
		$th_bg='fb9012';
	@endphp
@endif
		<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading orange-background ">
						<h5 style="color:black">Greetings! You're one step away on using our online booking system.</h5>


						<h5 style="color:black">Please setup first the following to continue and click finish button once all details below has been set.</h5>


						<h5 style="color:red"> - Update Company Details.</h5>

						<h5 style="color:red">- Add Invoice Address Details.</h5>

						<h5 style="color:red">- Set Up your default AQL Settings.</h5>


						<button class="btn btn-info" type="button" id="finish_details"><i class="fa fa-paper-plane"></i> Finish</button>
					</div>


				
		
	
				</div>

			
			</div>

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
										<th colspan="4" style="background-color: {{$th_bg}}; color:white;">Account Details</th>
									</tr>
									<tr>
										<th class="col-md-3">Username:</th>
										<td class="col-md-3">{{ $user->username}}</td>
										<th class="col-md-3">Full Name:</th>
										<td class="col-md-3">{{ $user_info->name }}</td>
									</tr>
									<tr>
										<th class="col-md-3">Password:</th>
										<td class="col-md-3">{!! str_repeat('*', strlen($user->plain)) !!}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#changePassword"><i class="fa fa-pencil"></i> Edit account details</button>
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
										<th colspan="4" style="background-color: {{$th_bg}}; color:white;">Company Details</th>
									</tr>
									<tr>
										<th class="col-md-3">Company Name:</th>
										<td class="col-md-3 comp_detail">{{ $client->Company_Name}}</td>
										<th>Email:</th>
										<td class="comp_detail">{{ $client->Company_Email}}</td>
									</tr>
									<tr>
										
										<th>Phone:</th>
										<td class="comp_detail">{{ $client->Phone_number}}</td>
										<th>Country:</th>
										<td class="comp_detail">{{ $client->company_country_name}}</td>
									</tr>
									<tr>
										
										<th>City:</th>
										<td class="comp_detail">{{ $client->company_city_name}}</td>
										<th>Zip:</th>
										<td class="comp_detail">{{ $client->company_zip_code}}</td>
									</tr>
									<tr>
									<th>Street Name:</th>
										<td class="comp_detail">{{ $client->company_street_num}}</td>
										
										<th>House Number:</th>
										<td class="comp_detail">{{ $client->company_house_num}}</td>
									</tr>
									<tr>
										
										<th>Building Name:</th>
										<td class="comp_detail">{{ $client->company_bldg_num}}</td>
										
									</tr>
									
								</tbody>
							</table>
							<input type="hidden" class="complete_details" value="{{ $client->Company_Name }}">
							<input type="hidden" class="complete_details" value="{{ $client->Company_Email }}">
							<input type="hidden" class="complete_details" value="{{ $client->Phone_number }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_country_name }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_city_name }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_zip_code }}">

							<input type="hidden" class="complete_details" value="{{ $client->company_street_num }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_house_num }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_bldg_num }}">
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
										<th colspan="4" style="background-color: {{$th_bg}}; color:white;">Invoice Address Details</th>
									</tr>
									<tr>
										<th class="col-md-3">Country:</th>
										<td class="col-md-3">{{ $client->company_invoice_country_name }}</td>
										<!--<th class="col-md-3">State:</th>
										<td class="col-md-3">{{ $client->company_invoice_state_name}}</td>-->
										<th>City:</th>
										<td class="comp_detail">{{ $client->company_invoice_city_name}}</td>
									</tr>
									<tr>
									
										<th>Zip Code:</th>
										<td class="comp_detail">{{ $client->company_inv_zip_code}}</td>
									


										<th>Street Name:</th>
										<td class="comp_detail">{{ $client->company_inv_street_num}}</td>


									</tr>
									<tr>
									<th>House Number:</th>
										<td class="comp_detail">{{ $client->company_inv_house_num}}</td>
										<th>Building Name:</th>
										<td class="comp_detail">{{ $client->company_inv_bldg_num}}</td>
									</tr>
									
								</tbody>
							</table>
							<input type="hidden" class="complete_details" value="{{ $client->company_invoice_country_name }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_invoice_city_name }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_inv_zip_code }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_inv_house_num }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_inv_street_num }}">
							<input type="hidden" class="complete_details" value="{{ $client->company_inv_bldg_num }}">
						</div>
					</div>
					<div class="col-md-12">
					<!-- data-target="#modalInvoice" -->
						<button class="btn btn-success modalInvoiceShow pull-right"   type="button"><i class="fa fa-pencil"></i> Edit invoice details</button>
					</div>
				</div>
				<hr>


				
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered" id="contactTable">
								<thead>
									<tr>
									


										<th colspan="5" style="background-color: {{$th_bg}}; color:white;">Contact Person Details </th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Tel #</th>
										<th>Mobile #</th>
										<th>Actions</th>
									</tr>
									@foreach($client_contact as $contacts)

									<tr>
										<td>{{ $contacts->contact_person}}</td>
										<td>{{ $contacts->email_address}}</td>
										<td>{{ $contacts->tel_number}}</td>
										<td>{{ $contacts->contact_number}}</td>
										<td>
											<button class="btn btn-success btn-cp" id="btn-edit-contact" data-id="{{ $contacts->id}}" type="button"><i class="fa fa-pencil"></i></button>
											<button class="btn btn-danger btn-cp" id="btn-delete-contact" data-delete_id="{{ $contacts->id}}" type="button"><i class="fa fa-trash"></i></button>
										</td>
									</tr>

									<!--<tr>
                                <th class="col-md-3">Name:</th>
                                <td class="col-md-3">{{ $contacts->contact_person}}</td>
                                <th class="col-md-3">Email:</th>
                                <td class="col-md-3">{{ $contacts->email_address}}</td>
                            </tr>
                            <tr>
                                <th>Tel #:</th>
                                <td>{{ $contacts->tel_number}}</td>
                                <th>Mobile #:</th>
                                <td>{{ $contacts->contact_number}}</td>
                            </tr>
                            <tr>
                                <th>Skype:</th>
                                <td>{{ $contacts->client_skype}}</td>
                                <th>We Chat:</th>
                                <td>{{ $contacts->client_wechat}}</td>
                            </tr>
                            <tr>
                                <th>WhatsApp:</th>
                                <td>{{ $contacts->client_whatsapp}}</td>
                                <th>QQ Mail:</th>
                                <td>{{ $contacts->client_qqmail}}</td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <button class="btn btn-success pull-right btn-cp" data-id="{{ $contacts->id}}" type="button"><i class="fa fa-pencil"></i> Edit contact details</button>
                                </td>
                            </tr>-->
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="col-md-12">
					<br>
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
										<th colspan="6" style="background-color: {{$th_bg}}; color:white;">AQL Details</th>
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


			
				<hr>

				
		
		{!!Form::close()!!}
	</div>
</div>
</div>
</div>
@include('partials.client.accountSettings._changepass')
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

<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
$(window).on('load',function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
        });

	$(document).ready(function() {
		
		var site_url="{{$site_url}}";
		console.log(site_url);
		var url_login='account-settings';
		if(site_url=='tic-sera'){
			url_login='account-settings-tic-sera';
		}

		
		$('.modalInvoiceShow').click(function() {
			console.log();
			var iddata=$("#invoice_country_id").val();
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
		$('#finish_details').click(function() {
			var add = $('.comp_detail');
			var add_count_null = 0;
			for (var i = 0; i < add.length; i++) {
				var data = $(add[i]).text();
				if (data == "") {
					add_count_null += 1;
					$(add[i]).css("background", "red");
					console.log(data);
				} else {
				}
			}
			if (add_count_null>0) {
				//updateCompany();
				console.log('test: '+auth_id);
				swal({
					title: "Oops!",
					text: "Please fill up your details first!",
					type: "warning",
				});
			} else {
				
				console.log('test: '+auth_id);
				$.ajax({
				url: '/update-user-level-state',
				type: 'POST',
				data: {
					_token: token,
					'client_code': $('#client_code').val(),
					'user_id': auth_id
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					console.log(response);
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "You may now use our booking website. Thank you",
						type: "success",
					}, function() {
						window.location.href=url_login;
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

	function showAllCountry() {
		$('.country').empty();
		$('.country').append('<option value="">Please Wait...</option>');
		$.ajax({
			url: 'http://world.t-i-c.asia/webapi_world_controller.php',
			type: 'POST',
			datatype: 'json',
			data: {
				show_all_country: 1
			},
			success: function(result) {
				$('.country').empty();
				$('.country').append('<option value="">Select Country</option>');
				data_country = result;
				/*data_country.forEach(element => {
					if (element.name == "" || element.name == null) {

					} else {
						$('.country').append('<option value="' + element.id + '">' + element.name + '</option>');
					}
				});*/
				$.each(data_country, function(i, item) {
						//console.log(item.name);
						$('.country').append('<option value="' + item.id + '">' + item.name + '</option>');
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
/* 	$(document).ready(function() {
		$('#contactTable').DataTable();
	}); */

</script>
