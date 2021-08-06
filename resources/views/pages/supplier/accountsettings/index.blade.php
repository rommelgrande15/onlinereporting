@extends('layouts.supplier._new')
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
				<center><h3>Supplier Settings</h3></center>
			</div> 
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<tbody>
									<tr>
										<th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">User Details</th>
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
						<button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#changeUsername"><i class="fa fa-pencil"></i> Edit Account Details</button>
					</div>
				</div>
				<hr>

				 <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<tbody>
									<tr>
										<th colspan="4" style="background-color: {{ $header_bg_color}}; color:white;">Supplier Details</th>
									</tr>
									<tr>
										<th class="col-md-3">Supplier Name:</th>
										<td class="col-md-3">{{ $supplierInfo->supplier_name}}</td>
										<th>Supplier Number</th>
										<td>{{ $supplierInfo->supplier_number}}</td>
									</tr>
									<tr>
										<th class="col-md-3">Supplier Code:</th>
										<td class="col-md-3">{{ $supplierInfo->supplier_code}}</td>
										<th>Address:</th>
										<td>{{ $supplierInfo->supplier_address}}</td>
									</tr>
									<tr>
										<th>Supplier Local Address</th>
										<td>{{ $supplierInfo->supplier_address_local}}</td>
										<th>Country:</th>
										<td>{{ $supplierInfo->supplier_country_name}}</td>
									</tr>
									<tr>
										<th>Local City:</th>
										<td>{{ $supplierInfo->supplier_local_city}}</td>
										<th>City</th>
										<td>{{ $supplierInfo->supplier_city}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-md-12">
						<button class="btn btn-success pull-right" type="button" data-toggle="modal" data-target="#updateSupplier"><i class="fa fa-pencil"></i> Edit Supplier Details</button>
					</div>
				</div>

				<hr>

				 <div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<thead>
									<tr>
										<th colspan="12" style="background-color: {{ $header_bg_color }}; color:white;">Supplier Client Contact Details </th>
									</tr>
								</thead>
								<tbody>        
									<tr>
                                        <th>Contact Person Name</th>
                                        <th>Contact Number</th>
                                        <th>Tel #</th>
                                        <th>Email</th>
                                        <th>Skype</th>
                                        <th>WeChat</th>
                                        <th>WhatsApp</th>
                                        <th>QQMail</th>
										{{-- <th>Actions</th> --}}
                                    </tr>

                                    {{-- @foreach ($supplierContactNameInfo as $supplierContactName)      
									<tr>
										<td>{{ $supplierContactName->supplier_contact_person}}</td>
										<td>{{ $supplierContactName->supplier_contact_number}}</td>
										<td>{{ $supplierContactName->supplier_tel_number}}</td>
                                        <td>{{ $supplierContactName->supplier_email}}</td>
                                        <td>{{ $supplierContactName->supplier_contact_skype}}</td>
										<td>{{ $supplierContactName->supplier_contact_wechat}}</td>
                                        <td>{{ $supplierContactName->supplier_contact_whatsapp}}</td>
                                        <td>{{ $supplierContactName->supplier_contact_qq}}</td>
										<td>
											<button class="btn btn-warning btn-sm btn-cp btn-edit-supplier" id="btn-edit-supplier" type="button" data-id="{{ $supplierContactName->id}}" data-toggle="tooltip" title="Edit" disabled><i class="fa fa-pencil" ></i></button>
											<button class="btn btn-danger btn-sm btn-cp" id="btn-delete-supplier"  type="button" data-delete_id="{{ $supplierContactName->id}}" data-toggle="tooltip" title="Delete" disabled><i class="fa fa-trash"></i></button>
										</td>
									</tr>
								    @endforeach --}}
									{{-- @foreach ($supplierClientContact as $supplierClientContact)       --}}
									@if($supplierClientContact)
									<tr>
										<td>{{ $supplierClientContact->contact_person}}</td>
										<td>{{ $supplierClientContact->contact_number}}</td>
										<td>{{ $supplierClientContact->tel_number}}</td>
                                        <td>{{ $supplierClientContact->email_address}}</td>
                                        <td>{{ $supplierClientContact->client_skype}}</td>
										<td>{{ $supplierClientContact->client_wechat}}</td>
                                        <td>{{ $supplierClientContact->client_whatsapp}}</td>
                                        <td>{{ $supplierClientContact->client_qqmail}}</td>
										{{-- <td>
											<button class="btn btn-warning btn-sm btn-cp btn-edit-supplier" id="btn-edit-supplier" type="button" data-id="{{ $supplierClientContact->id}}" data-toggle="tooltip" title="Edit" disabled><i class="fa fa-pencil" ></i></button> --}}
											{{-- <button class="btn btn-danger btn-sm btn-cp" id="btn-delete-supplier"  type="button" data-delete_id="{{ $supplierContactName->id}}" data-toggle="tooltip" title="Delete" disabled><i class="fa fa-trash"></i></button> --}}
										{{-- </td> --}}
									</tr>
									@else
									<tr>
										<td>No data available</td>
										<td></td>
										<td></td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                        <td></td>
										{{-- <td>
											<button class="btn btn-warning btn-sm btn-cp btn-edit-supplier" id="btn-edit-supplier" type="button" data-id="{{ $supplierClientContact->id}}" data-toggle="tooltip" title="Edit" disabled><i class="fa fa-pencil" ></i></button> --}}
											{{-- <button class="btn btn-danger btn-sm btn-cp" id="btn-delete-supplier"  type="button" data-delete_id="{{ $supplierContactName->id}}" data-toggle="tooltip" title="Delete" disabled><i class="fa fa-trash"></i></button> --}}
										{{-- </td> --}}
									</tr>
									@endif
								    {{-- @endforeach --}}
								</tbody>
							</table>
						</div>
					</div>
					{{-- <div class="col-md-12">
						<button class="btn btn-success pull-right" data-toggle="modal" data-target="#modalAddContact" type="button"><i class="fa fa-plus"></i> Add Supplier Contact Person</button>
					</div> --}}
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-hover table-bordered">
								<thead>
									<tr>
										<th colspan="12" style="background-color: {{ $header_bg_color }}; color:white;">Supplier Contact Details </th>
									</tr>
								</thead>
								<tbody>        
									<tr>
                                        <th>Contact Person Name</th>
                                        <th>Contact Number</th>
                                        <th>Tel #</th>
                                        <th>Email</th>
                                        <th>Skype</th>
                                        <th>WeChat</th>
                                        <th>WhatsApp</th>
                                        <th>QQMail</th>
                                    </tr>
									{{-- @foreach ($supplierContactNameName as $supplierContactName)  --}}
									@if($supplierContactName)
									<tr>
										<td>{{ $supplierContactName->supplier_contact_person}}</td>
										<td>{{ $supplierContactName->supplier_contact_number}}</td>
										<td>{{ $supplierContactName->supplier_tel_number}}</td>
                                        <td>{{ $supplierContactName->supplier_email}}</td>
                                        <td>{{ $supplierContactName->supplier_contact_skype}}</td>
										<td>{{ $supplierContactName->supplier_contact_wechat}}</td>
                                        <td>{{ $supplierContactName->supplier_contact_whatsapp}}</td>
                                        <td>{{ $supplierContactName->supplier_contact_qq}}</td>
									</tr>
									{{-- @endforeach --}}
									@else
									<tr>
										<td>No data available</td>
										<td></td>
										<td></td>
                                        <td></td>
                                        <td></td>
										<td></td>
                                        <td></td>
                                        <td></td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<hr>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table id="aql_table" class="table table-hover table-bordered">
								<tbody>
									<tr>
										<th colspan="6" style="background-color: {{ $header_bg_color}}; color:white;">Client AQL Details</th>
									</tr>
									<tr>
										<th class="col-md-3">Normal Level:</th>
										<td class="col-md-3">
											{{$client_aql_details->normal_level}}
										</td>
										<th class="col-md-3">Special Level:</th>
										<td class="col-md-3">
											{{$client_aql_details->special_level}}
										</td>
									</tr>
									<tr>
										<th>Major:</th>
										<td class="hi">
											{{$client_aql_details->aql_major}}
										</td>
										<th>Minor:</th>
										<td class="hi">
											{{$client_aql_details->aql_minor}}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@include('partials.admin.supplier._changepasswordsupplier')
@include('partials.admin.supplier._updateusernamefact')
@include('partials.admin.supplier._deletecontact')
@include('partials.admin.supplier._updatesupplier')
@include('partials.admin.supplier._newcontact')
@include('partials.admin.supplier._updatecontact')



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
	function showAllCountry() {
		$('.country').empty();
		$('.country').append('<option value="">Please Wait...</option>');
		$.ajax({
			url: '/get-all-country/1',
			type: 'GET',
			success: function(result) {
				$('.country').empty();
				$('.country').append('<option value="">Select Country</option>');
				var data_country = JSON.parse(result);
				$.each(data_country, function(i, item) {
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

	
</script>
