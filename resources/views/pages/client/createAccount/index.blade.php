@extends('layouts.master')
@section('title','Create an account')
@section('stylesheets')
<link rel="stylesheet" type="text/css" href="https://tic-service.company/cloudfare/bootstrap.min.css">
<script type="text/javascript" src="https://tic-service.company/cloudfare/jquery.min.js"></script>
<script type="text/javascript" src="https://tic-service.company/cloudfare/bootstrap.min.js"></script>
<script type="text/javascript" src="https://tic-service.company/cloudfare/bootstrap-show-password.min.js"></script>
{!! Html::style('/css/admin/login.css') !!}
{!! Html::style('/css/admin/project.css') !!}
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

	.password_size {
		width: 100% !important;
	}
</style>
@endsection

@section('content')
@if(strpos(Request::url(''), 'tic-sera') !== false)
@php
$color_border='sera-border';
$color_bg='sera-background';
$color_text='sera-text';
$color_panel_body='panel-body-sera';
$site_url='tic-sera';
@endphp
@else
@php
$color_border='orange-border';
$color_bg='orange-background';
$color_text='orange-text';
$color_panel_body='';
$site_url='tic';
@endphp
@endif
<div class="col-md-12 text-center logo-container">

	@if(strpos(Request::url(''), 'tic-sera') !== false)
	<div class="text-center">
		<img class="img-responsive" src="{{URL::asset('/images/ticsera-logo.png')}}"
			style="margin-left:auto; margin-right:auto;">
	</div>
	@else
	<img src="{{URL::asset('/images/logo.png')}}" width="500">
	@endif
</div>
<div class="col-md-6 col-md-offset-3">
	@include('partials._messages')
</div>
<div class="col-md-6 col-md-offset-3">
	<div class="panel panel-default {{$color_border}}">
		<div class="panel-heading {{$color_bg}} {{$color_border}} white-text">Register Account</div>
		<div class="panel-body {{$color_border}}  login-box-background">
			<div class="row">
				<!---First Row---->
				<div class="form-group">
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('TermsOfAddress','Terms of Address:') !!}<span class="error-messages" id="gender-error"></span>
							<div class="input-group">
								<span class="input-group-addon" id="addon1"><i class="fa fa-user"></i></span>
								<select class="form-control validate_input" name="TermsOfAddress" id="TermsOfAddress" required>
									<option value="">--Select Terms of Address--</option>
									<option value="1">Mr.</option>
									<option value="0">Ms.</option>
									<option value="2">Mrs.</option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						{!! Form::open(['data-parsley-validate'=>'','route'=>'signinuser']) !!}
						<div class="form-group">
							{!! Form::label('fullName','Full Name:') !!}<span class="error-messages" id="username-error"></span>
							<div class="input-group">
								<span class="input-group-addon" id="addon1"><i class="fa fa-address-book"></i></span>
								{!! Form::text('fullName',null,['class'=>'form-control validate_input']) !!}
							</div>
						</div>
					</div>
				</div>
				<!-----Second Row---->
				<div class="form-group">
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('Company_name','Company Name:') !!}
							<span class="error-messages" id="password-error"></span>
							<div class="input-group">
								<span class="input-group-addon" id="addon2"><i class="fa fa-address-card"></i></span>
								{!! Form::text('Company_name',null,['class'=>'form-control validate_input']) !!}

							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('Country','Country:') !!}<span class="error-messages" id="username-error"></span>
							<div class="input-group">
								<span class="input-group-addon" id="addon1"><i class="fa fa-map"></i></span>
								<select class="form-control validate_input" required name="company_country" id="company_country">
									<option value="">--Select Country--</option>
								</select>

							</div>
						</div>
					</div>
				</div>
				<!----Third Row--->
				<div class="form-group">
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('client_Telephone','Telephone:') !!}<span class="error-messages" id="username-error"></span>
							<div class="input-group">
								<span class="input-group-addon" id="addon1"><i class="fa fa-phone"></i></span>
								{!! Form::text('client_Telephone',null,['class'=>'form-control validate_input']) !!}
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('Clinet_email','Email / Username:') !!}<span class="error-messages" id="password-error"></span>
							<div class="input-group">
								<span class="input-group-addon" id="addon2"><i class="fa fa-envelope"></i></span>
								{!! Form::text('Clinet_email',null,['class'=>'form-control validate_input_email']) !!}
							</div>
						</div>
					</div>
				</div>
				<!----Last Row----->
				<div class="form-group">
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('client_Password','Password:') !!}<span class="error-messages" id="username-error"></span>
							<div class="input-group">
								<span class="input-group-addon" id="addon1"><i class="fa fa-key"></i></span>
								{!! Form::password('client_Password',['class'=>'form-control validate_input']) !!}
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							{!! Form::label('client_Password_confirm','Confirm Password:') !!}<span class="error-messages" id="password-error"></span>
							<div class="input-group">
								<span class="input-group-addon" id="addon2"><i class="fa fa-check"></i></span>
								{!! Form::password('client_Password_confirm',['class'=>'form-control validate_input'])
								!!}
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="form-group">
					<div class="col-md-12 text-center">
						<h4 class="{{$color_text}}">Terms and Conditions</h4>
					</div>
					<div class="col-md-12">
						@include('partials._terms')
					</div>
					<div class="col-md-12 agree-panel text-center" style="color:red;">
						<p>
							Please check your email after completing the registration to activate your account, please
							check also your spam folder. Thank you.
						</p>
					</div>
					<div class="col-md-12 agree-panel text-center">
						<p class="agree {{$color_text}}">By Clicking the Submit button, you agree on our terms and
							conditions.</p>
					</div>


					<div class="col-md-4 col-md-offset-2">
						@if(strpos(Request::url(''), 'tic-sera') !== false)
						<a href="{!!route('tic-sera-login')!!}" class="btn btn-primary btn-block"> Back to login </a>
						@else
						<a href="{!!route('login')!!}" class="btn btn-primary btn-block"> Back to login </a>
						@endif
					</div>
					<div class="col-md-4 submit-btn">
						{!! Form::button('Submit', ['type'=>'button','class' => 'btn btn-success
						btn-block','id'=>'SaveClientData']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


{!! Form::close() !!}

<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
{!! Html::script('/js/register/index.js') !!}
@endsection

<script type="text/javascript" src="https://tic-service.company/cloudfare/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://tic-service.company/cloudfare/jquery-ui.min.js"></script>


<script>
	$(window).on('load', function () {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});
	$(document).ready(function () {
		var token = "{{csrf_token()}}";
		var site_url = "{{$site_url}}";
		console.log(site_url);
		var url_login = 'https://tic-service.company/';
		if (site_url == 'tic-sera') {
			url_login = 'http://tic-service.company/tic-sera-login';
		}
		showAllCountry();
		$("#SaveClientData").click(function () {
			var add = $('.validate_input');
			var email_add = $('.validate_input_email');
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
				if (!isEmail(data)) {
					$(email_add[i]).css("border", "1px solid red");
					email_err += 1;
				} else {
					$(email_add[i]).removeAttr("style");
				}
			}
			$('#client_Password_confirm').removeAttr("style");
			if (add_count_null == 0 && email_err == 0) {
				if ($("#client_Password").val() != $("#client_Password_confirm").val()) {
					swal({
						title: "Error",
						text: "Error: Password not match",
						type: "error",
					});
					$('#client_Password_confirm').css("border", "1px solid red");
				} else {
					saveClientData();
				}

				console.log('test');
			} else {
				swal({
					title: "Oops!",
					text: "Please check empty or invalid input fields!",
					type: "warning",
				});
			}

		});

		function isEmail(email) {
			//var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			var regex =
				/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
			return regex.test(email);
		}

		function saveClientData() {
			var fullName = $("#fullName").val();
			var TermsOfAddress = $("#TermsOfAddress").val();
			var country = $("#company_country").val();
			var countryname = $("#company_country option:selected").text();
			var Company_name = $("#Company_name").val();
			var Telephone = $("#client_Telephone").val();
			var userNameEmail = $("#Clinet_email").val();
			var password = $("#client_Password").val();
			var cpassword = $("#client_Password_confirm").val();
			var _url = "{{$site_url}}";
			$('.send-loading ').show();
			$.ajax({
				url: '/register-client',
				type: 'POST',
				datatype: 'json',
				data: {
					registerClient: 1,
					_token: token,
					name: fullName,
					TermsOfAddress: TermsOfAddress,
					Company_name: Company_name,
					country: country,
					countryname: countryname,
					company_phone: Telephone,
					username: userNameEmail,
					password: password,
					cpassword: cpassword,
					site_url: _url

				},
				success: function (result) {
					$('.send-loading ').hide();
					console.log(result.message);
					if (result.message == "dupticateEmail") {
						swal({
							title: "Oops!",
							text: "Your Email is not Available",
							type: "warning",
						});
					} else {
						swal({
							title: "Succes",
							text: "Successful Registered",
							type: "success",
						}, function () {
							//location.reload();
							//url = "https://ticapp.tk/";
							//$(location).attr("href", url);
							window.location.href = url_login;

						});
					}

				},
				error: function (jqXHR, textStatus, errorThrown) {
					$('.send-loading ').hide();
					swal({
						title: "Error",
						text: "Someting went wrong. Please try again later.",
						type: "error",
					});
				}
			});


		}


		function showAllCountry() {
			$('#company_country').empty();
			$('#company_country').append('<option value="">Please Wait...</option>');
			$.ajax({
				url: '/get-all-country/1',
				type: 'GET',
				success: function (result) {
					$('#company_country').empty();
					$('#company_country').append('<option value="">Select Country</option>');
					//data_country = result;
					var data_country = JSON.parse(result);
					console.log(data_country);
					//for (var i = 0; i < data_country.length; i++) {
					//	//data_country[i].checked = source.checked;
					//	var obj = data_country[i];
					//	for ( var key in obj) {
					//		var Name = key;
					//		var Value = obj[key].toString();
					//		$('#company_country').append('<option value="' + Name + '">' + Value + '</option>');

					//	}
					//	
					//}
					//data_country.forEach(element => {
					//	if (element.name == "" || element.name == null) {
					//	} else {
					//		$('#company_country').append('<option value="' + element.id + '">' + element.name + '</option>');
					//	}
					//});
					$.each(data_country, function (i, item) {
						//console.log(item.name);
						$('#company_country').append('<option value="' + item.id + '">' + item
							.name + '</option>');
					});
					//jQuery.each(data_country, function(index, item){
					//	a.push(jQuery(item).text());
					//});

				},
				error: function (jqXHR, textStatus, errorThrown) {
					$('#company_country').empty();
					$('#company_country').append(
						'<option value="">Something went wrong. Please try again.</option>');

					$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' +
						errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText +
						'</div>');
					console.log('jqXHR:');
					console.log(jqXHR);
					console.log('textStatus:');
					console.log(textStatus);
					console.log('errorThrown:');
					console.log(errorThrown);
				}
			});
		}

		$('#company_country').on('change', function () {
			//showStateByCountry();
			/*  textInputValidator(this.id); */
		});

		$('#company_state').on('change', function () {
			showCityByCountryAndState();
			/* textInputValidator(this.id); */
		});

		var source_state = [];

		$('#company_state').autocomplete({
			maxResults: 10,
			source: function (request, response) {
				var results = $.ui.autocomplete.filter(source_state, request.term);

				response(results.slice(0, this.options.maxResults));
			},
			select: function (event, ui) {
				$("#company_state").val(ui.item.label); // display the selected text
				$("#hidden_company_state_id").val(ui.item.value); // save selected id to hidden input
				return false;
			}
		});


		function showStateByCountry() {
			var id = $('#company_country').val();
			var country_name = $('#company_country option:selected').text();
			$("#company_state").val('Please wait...');
			$.ajax({
				url: '/get-state/' + id,
				type: 'GET',
				success: function (result) {
					//var data_country = result;
					var data_country = JSON.parse(result);
					source_state.length = 0;
					//data_country.forEach(element => {
					//	if (element.name == "" || element.name == null) {
					//
					//	} else {
					//		//$('#supplier_state').append('<option value="'+element.id+'">'+element.name+'</option>');
					//		source_state.push({
					//			value: element.id,
					//			label: element.name
					//		});
					//	}
					//});

					$.each(data_country, function (i, item) {
						source_state.push({
							value: item.id,
							label: item.name
						});
					});
					$("#company_state").val('');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					$('#company_state').empty();
					$('#company_state').append(
						'<option value="">Something went wrong. Please try again.</option>');
					$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' +
						errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText +
						'</div>');
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

		$('#company_city').autocomplete({
			maxResults: 10,
			source: function (request, response) {
				var results = $.ui.autocomplete.filter(source_city, request.term);

				response(results.slice(0, this.options.maxResults));
			}
		});

		$("#company_city").autocomplete("option", "appendTo", ".eventInsForm");

		function showCityByCountryAndState() {
			var cid = $('#company_country').val();
			var sid = $('#hidden_company_state_id').val();

			$('#company_city').val('Please Wait...');
			$.ajax({
				url: '/get-city/' + sid,
				type: 'GET',
				success: function (result) {
					console.log(result);
					//var data_city = result;
					var data_city = JSON.parse(result);
					source_city.length = 0;
					//data_city.forEach(element => {
					//	if (element.name == "" || element.name == null) {
					//
					//	} else {
					//		// $('#supplier_city').append('<option value="'+element.id+'">'+element.name+'</option>');
					//		source_city.push(element.name);
					//	}
					//});
					$.each(data_city, function (i, item) {
						//console.log(item.name);
						source_city.push(item.name);
					});
					$('#company_city').val('');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					$('#mcompany_city').empty();
					$('#mcompany_city').append(
						'<option value="">Something went wrong. Please try again.</option>');
					$('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' +
						errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText +
						'</div>');
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