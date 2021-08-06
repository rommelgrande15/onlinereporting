<div id="addFactoryContactPerson" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">


		<div class="modal-content">
			{!!Form::open()!!}
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Contact Person</h4>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-md-12">

						<label class="pull-right"><span class="text-danger">*</span> <i>Indicate required fields</i></label><br />
						<label>Add contact person for <span id="add_contact_for"></span></label><br />
					</div>
					<div class="client-clone-addcontactperson">
						<div class="clone-inputs-addcontactperson">
							<div class="col-md-12">
								<hr>
							</div>
							<div class="col-md-4">

								<div class="form-group">

									{!!Form::label('add_contact_person','<span class="text-danger">*</span> Contact Person',['class'=>''],false)!!}

									<input type="text" id="add_contact_person" name="add_contact_person" class="form-control add_contact_person" onkeyup="addContactPersonValidator('add_contact_person')">


								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">

									{!!Form::label('add_contact_person_email','<span class="text-danger">*</span> Email Address',['class'=>''],false)!!}

									<input type="email" id="add_contact_person_email" name="add_contact_person_email" class="form-control add_contact_person_email" onkeyup="addContactPersonValidator('add_contact_person_email')">

								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									{!!Form::label('add_contact_person_number','<span class="text-danger">*</span> Mobile Number',['class'=>''],false)!!}

									<input type="text" id="add_contact_person_number" name="add_contact_person_number" class="form-control add_contact_person_number" onkeyup="addContactPersonValidator('add_contact_person_number')">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									{!!Form::label('add_contact_tel_number','<span class="text-danger">*</span> Telephone Number',['class'=>''],false)!!}

									<input type="text" id="add_contact_tel_number" name="add_contact_tel_number" class="form-control add_contact_tel_number" onkeyup="addContactPersonValidator('add_contact_tel_number')">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									{!!Form::label('add_client_skype','Skype',['class'=>''])!!}

									<input type="text" id="add_client_skype" name="add_client_skype" class="form-control add_client_skype" onkeyup="addContactPersonValidator('add_client_skype')">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									{!!Form::label('add_client_wechat','We Chat',['class'=>''])!!}

									<input type="text" id="add_client_wechat" name="add_client_wechat" class="form-control add_client_wechat" onkeyup="addContactPersonValidator('add_client_wechat')">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									{!!Form::label('add_client_whatsapp','WhatsApp',['class'=>''])!!}

									<input type="text" id="add_client_whatsapp" name="add_client_whatsapp" class="form-control add_client_whatsapp" onkeyup="addContactPersonValidator('add_client_whatsapp')">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									{!!Form::label('add_client_qqmail','QQ Mail',['class'=>''])!!}

									<input type="text" id="add_client_qqmail" name="add_client_qqmail" class="form-control add_client_qqmail" onkeyup="addContactPersonValidator('add_client_qqmail')">
								</div>
							</div>

						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<button class="btn btn-success" type="button" id="btn_add_more_client_contact"><i class="fa fa-plus"></i> Add more contact person</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">

				<input type="hidden" id="hidden_client_code">
				<input type="hidden" id="hidden_factory_id">
				<input type="hidden" id="statusState">
				{!! Form::button('<i class="fa fa-ban"></i> Close', ['class' => 'btn btn-danger clr','data-dismiss' => "modal",'id'=>'save_client_contact1']) !!}
				{!! Form::button('<i class="fa fa-floppy-o"></i> Save contact person', ['class' => 'btn btn-success', 'id'=>'save_client_contact']) !!}
			</div>
		</div>

	</div>
</div>






<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script>
	function view2() {
		$.ajax({
			url: '/getonefactory/' + $('#hidden_factory_id').val(),
			type: 'GET',
			success: function(response) {
				console.log(response);

				$('#div_edit_more_fields').empty();
				//response.contacts.forEach(element => {
				$.each(response.contacts, function(i, element) {
					if (element.factory_contact_status != 2 || element.factory_contact_status != '2') {
						console.log(element.factory_contact_person);
						$('#div_edit_more_fields').append('<div id="' + element.id + '"><div class="col-md-12">' +
							'        <div class="form-group">' +
							'          <hr/>' +
							'      </div>' +
							'    </div>' +
							'    <div class="col-md-12">' +
							'      <div class="form-group">    ' +
							'        <h4 class="modal-title">Factory Contact Person</h4>' +
							'      </div>' +
							'    </div>' +

							'    <div class="col-md-4">      ' +
							'      <div class="form-group">' +
							'          <label for="update_contact_person">Contact Person</label>' +
							'          <input type="text" name="update_contact_person" value="' + element.factory_contact_person + '" onchange="test2()" id="update_contact_person' + element.id + '" class="form-control update_contact_person" required>' +

							'      </div>' +
							'    </div>' +
							'    ' +
							'    <div class="col-md-4">' +
							'      <div class="form-group">' +
							'          <label for="update_contact_person_email">Email Address</label>' +
							'          <input type="email" name="update_contact_person_email" value="' + element.factory_email + '" onchange="test2()" id="update_contact_person_email' + element.id + '" class="form-control update_contact_person_email" required>' +

							'      </div>' +
							'    </div>' +

							'    <div class="col-md-4">' +
							'      <div class="form-group">' +
							'          <label for="update_contact_person_number">Mobile Number</label>' +
							'          <input type="text" name="update_contact_person_number" value="' + element.factory_contact_number + '" onchange="test2()" id="update_contact_person_number' + element.id + '" class="form-control numeric update_contact_person_number" required>' +

							'      </div>' +
							'    </div>' +

							'    <div class="col-md-4">' +
							'      <div class="form-group">' +
							'          <label for="update_contact_tel_person_number">Telephone Number</label>' +
							'          <input type="text" name="update_contact_tel_person_number" value="' + element.factory_tel_number + '" onchange="test2()" id="update_contact_tel_person_number' + element.id + '" class="form-control numeric update_contact_tel_person_number" required>' +

							'      </div>' +
							'    </div>' +


							'    <div class="col-md-4">' +
							'        <div class="form-group">' +
							'            <label for="update_contact_skype">Skype</label>' +
							'            <input type="text" name="update_contact_skype" value="' + element.factory_contact_skype + '"  id="update_contact_skype' + element.id + '" class="form-control update_contact_skype" required>' +

							'        </div>' +
							'      </div>' +

							'      <div class="col-md-4">' +
							'          <div class="form-group">' +
							'              <label for="update_contact_wechat">We Chat</label>' +
							'              <input type="text" name="update_contact_wechat"  value="' + element.factory_contact_wechat + '" id="update_contact_wechat' + element.id + '" class="form-control update_contact_wechat" required>' +

							'          </div>' +
							'        </div>' +
							'    ' +
							'        <div class="col-md-4">' +
							'            <div class="form-group">' +
							'                <label for="update_contact_whatsapp">WhatsApp</label>' +
							'                <input type="text" name="update_contact_whatsapp" value="' + element.factory_contact_whatsapp + '" id="update_contact_whatsapp' + element.id + '" class="form-control update_contact_whatsapp" required>' +

							'            </div>' +
							'          </div>' +

							'          <div class="col-md-4">' +
							'              <div class="form-group">' +
							'                  <label for="update_contact_qqmail">QQ Mail</label>' +
							'                  <input type="text" name="update_contact_qqmail"  value="' + element.factory_contact_qq + '" id="update_contact_qqmail' + element.id + '" class="form-control update_contact_qqmail" required>' +

							'              </div>' +
							'            </div>' +
							'          <div class="col-md-1">' +
							'              <div class="form-group">' +
							'          <input type="hidden" name="hidden_contact_id" id="IdcontactFactory" class="IdcontactFactory" value="' + element.id + '">' +


							'              </div>' +
							'            </div>' +
							'<div class="col-md-1">' +
							'<div class="form-group"><br>' +
							'<button onclick ="update_Factory_data(' + element.id + ')" type="button"  class="btn btn-danger btn-rm update_Client_data" ><i class="fa fa-times"></i></button>' +
							'</div>' +
							'</div> </div>');

					}

				});


				$('#btn_add_more_contact_factory_id').val(response.factory_id);
				$('#update_factory_id').val(response.factory_id);
				$('#update_client_code').val(response.client_code);
				$('#update_factory_name').val(response.factory_name);
				$('#update_factory_address').val(response.factory_address);
				$('#update_factory_address_local').val(response.factory_address_local);
				$('#update_factory_country').val(response.factory_country);
				$('#update_factory_city').val(response.factory_city);

				$('#update_country_id').val(response.factory_country);
				$('#update_state_id').val(response.factory_state);
				$('#update_city_id').val(response.factory_city);

				$('#update_contact_person').val(response.factory_contact_person);
				$('#update_contact_person_email').val(response.factory_email);
				$('#update_contact_person_number').val(response.factory_contact_number);
				$('#hidden_contact_id').val(response.factory_contact_id);

				$('#update_contact_skype').val(response.factory_contact_skype);
				$('#update_contact_wechat').val(response.factory_contact_wechat);
				$('#update_contact_whatsapp').val(response.factory_contact_whatsapp);
				$('#update_contact_qqmail').val(response.factory_contact_qq);

				$('#updateFactory').modal('show');

				showAllCountryUpdate(response.factory_country);
				showStateByCountryUpdate(response.factory_country, response.factory_state_id);
				showCityByCountryAndStateUpdate(response.factory_country, response.factory_state_id, response.factory_city_id);
				//$('#update_factory_city').val(response.factory_state);
				$('#update_factory_state').val(response.factory_state);
				$('#update_factory_state_id').val(response.factory_state_id);

				//$("#update_factory_country").attr("onchange", "showStateByCountryChange()");
				//$("#update_factory_state").attr("onchange", "showCityByCountryAndStateChange()");

			}

		});

	}

	function view() {

		$('#addFactoryContactPerson').modal('toggle');

		$.ajax({
			url: '/getonefactory/' + $('#hidden_factory_id').val(),
			type: 'GET',
			success: function(response) {
				console.log(response);
				$('#view_fac_name').text(response.factory_name);
				$('#view_fac_addr_local').text(response.factory_address_local);
				var fac_addr = response.factory_city + ', ' + response.factory_state + ', ' + response.factory_country_name;
				$('#view_fac_addr').text(fac_addr);
				$('.factory_added_row').remove();
				$('#table_view_factory > tbody:last-child').append('<tr class="factory_added_row" style="background-color:lightgrey"><th colspan="4"><h4>2. Factory Contact Person</h4></th></tr>');
				var count_contact = 0;
				//response.contacts.forEach(element => {
				$.each(response.contacts, function(i, element) {

					count_contact += 1;
					$('#table_view_factory > tbody:last-child').append('<tr class="factory_added_row">' +
						'<th>Contact Person ' + count_contact + ' :</th>' +
						'<td colspan="3">' + element.factory_contact_person + '</td>' +
						'</tr>' +

						'<tr class="factory_added_row">' +
						'<th>Contact Person Email :</th>' +
						'<td>' + element.factory_email + '</td>' +
						'<th>Contact Person Mobile Number :</th>' +
						'<td>' + element.factory_contact_number + '</td>' +
						'</tr>' +

						'<tr class="factory_added_row">' +
						'<th>Telephone Number :</th>' +
						'<td>' + element.factory_tel_number + '</td>' +
						'<th>Skype :</th>' +
						'<td>' + element.factory_contact_skype + '</td>' +
						'</tr>' +

						'<tr class="factory_added_row">' +
						'<th>We Chat :</th>' +
						'<td>' + element.factory_contact_wechat + '</td>' +
						'<th>WhatsApp :</th>' +
						'<td>' + element.factory_contact_whatsapp + '</td>' +
						'</tr>' +

						'<tr class="factory_added_row">' +
						'<th>QQ Mail :</th>' +
						'<td colspan="3">' + element.factory_contact_qq + '</td>' +
						'</tr>' +
						'<tr class="factory_added_row">' +
						'<td colspan="4"></td>' +
						'</tr>');
				});
				setTimeout(function() {
					$('#viewFactoryDetails').modal('show');
				}, 1000);


			}
		});

	}
	$(document).ready(function() {

		$('#save_client_contact1').click(function(e) {

			if ($('#statusState').val() == "btn-add") {
				view();
			} else {
				view2();
			}


		});

		$('#save_client_contact').click(function(e) {
			var checked;
			var emailValidator = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
			var add_client_code = $('#hidden_client_code').val();
			var add_factory_id = $('#hidden_factory_id').val();
			var add_c_person = $('.add_contact_person');
			var add_c_person_email = $('.add_contact_person_email');
			var add_c_person_number = $('.add_contact_person_number');
			var add_c_person_tel_number = $('.add_contact_tel_number');

			var add_c_client_skype = $('.add_client_skype');
			var add_c_client_wechat = $('.add_client_wechat');
			var add_c_client_whatsapp = $('.add_client_whatsapp');
			var add_c_client_qqmail = $('.add_client_qqmail');

			var add_contact_person = [];
			var add_contact_person_email = [];
			var add_contact_person_number = [];
			var add_contact_person_tel_number = [];

			var add_client_skype = [];
			var add_client_wechat = [];
			var add_client_whatsapp = [];
			var add_client_qqmail = [];

			var add_count_null = 0; //variable for counting the null values

			for (var i = 0; i < add_c_person.length; i++) {
				var g_data = $(add_c_person[i]).val();
				add_contact_person.push(g_data);
				if (g_data == "") {
					add_count_null += 1;
					$(add_c_person[i]).css("border", "1px solid red");
				} else {


					$(add_c_person[i]).removeAttr("style");
				}
			}
			for (var i = 0; i < add_c_person_email.length; i++) {
				var g_data = $(add_c_person_email[i]).val();
				add_contact_person_email.push(g_data);
				if (g_data == "") {
					add_count_null += 1;
					$(add_c_person_email[i]).css("border", "1px solid red");
				} else {
					$(add_c_person_email[i]).removeAttr("style");


					if (emailValidator.test(g_data)) {
						if (checked == "Not Ok") {

						} else {
							checked = "ok";
						}
					} else {

						checked = "Not Ok"
					}
				}


			}
			for (var i = 0; i < add_c_person_number.length; i++) {
				var g_data = $(add_c_person_number[i]).val();
				add_contact_person_number.push(g_data);
				if (g_data == "") {
					add_count_null += 1;
					$(add_c_person_number[i]).css("border", "1px solid red");
				} else {
					$(add_c_person_number[i]).removeAttr("style");
				}
			}

			for (var i = 0; i < add_c_person_tel_number.length; i++) {
				var g_data = $(add_c_person_tel_number[i]).val();
				add_contact_person_tel_number.push(g_data);
				if (g_data == "") {
					add_count_null += 1;
					$(add_c_person_tel_number[i]).css("border", "1px solid red");
				} else {
					$(add_c_person_tel_number[i]).removeAttr("style");
				}
			}


			for (var i = 0; i < add_c_client_skype.length; i++) {
				var g_data = $(add_c_client_skype[i]).val();
				add_client_skype.push(g_data);
				/* if(g_data==""){
				  add_count_null+=1;
				  $(add_c_client_skype[i]).css("border","1px solid red");
				}else{
				  $(add_c_client_skype[i]).removeAttr("style");
				} */
			}

			for (var i = 0; i < add_c_client_wechat.length; i++) {
				var g_data = $(add_c_client_wechat[i]).val();
				add_client_wechat.push(g_data);
				/* if(g_data==""){
				  add_count_null+=1;
				  $(add_c_client_wechat[i]).css("border","1px solid red");
				}else{
				  $(add_c_client_wechat[i]).removeAttr("style");
				} */
			}

			for (var i = 0; i < add_c_client_whatsapp.length; i++) {
				var g_data = $(add_c_client_whatsapp[i]).val();
				add_client_whatsapp.push(g_data);
				/*  if(g_data==""){
				   add_count_null+=1;
				   $(add_c_client_whatsapp[i]).css("border","1px solid red");
				 }else{
				   $(add_c_client_whatsapp[i]).removeAttr("style");
				 } */
			}

			for (var i = 0; i < add_c_client_qqmail.length; i++) {
				var g_data = $(add_c_client_qqmail[i]).val();
				add_client_qqmail.push(g_data);
				/* if(g_data==""){
				  add_count_null+=1;
				  $(add_c_client_qqmail[i]).css("border","1px solid red");
				}else{
				  $(add_c_client_qqmail[i]).removeAttr("style");
				} */
			}
			console.log(add_count_null);

			console.log(add_contact_person);
			console.log(add_contact_person_email);
			console.log(add_contact_person_number);
			console.log(add_client_skype);
			console.log(add_client_wechat);
			console.log(add_client_whatsapp);
			console.log(add_client_qqmail);

			//add_count_null=1;
			if (add_count_null == 0) {
				console.log(checked);
				if (checked == "Not Ok") {
					// alert("Please Input Corect Email!");

					for (var i = 0; i < add_c_person_email.length; i++) {
						var g_data = $(add_c_person_email[i]).val();

						$(add_c_person_email[i]).removeAttr("style");

						if (emailValidator.test(g_data)) {

						} else {
							alert("Please Input Corect Email!");
							$(add_c_person_email[i]).css("border", "1px solid red");

						}


					}


				} else {
					$('.send-loading ').show();
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});

					$.ajax({
						type: 'POST',
						url: '/postnewfactorycontact',
						data: {
							add_factory_id: add_factory_id,
							/*  client_code:add_client_code, */
							contact_person: add_contact_person,
							contact_person_email: add_contact_person_email,
							contact_person_number: add_contact_person_number,
							add_contact_person_tel_number: add_contact_person_tel_number,


							factory_contact_skype: add_client_skype,
							factory_contact_wechat: add_client_wechat,
							factory_contact_whatsapp: add_client_whatsapp,
							factory_contact_qqmail: add_client_qqmail

						},
						success: function(data) {
							alert("Factory contact person successfully added.");
							$('.send-loading ').hide();
							if ($('#statusState').val() == "btn-add") {
								view();
							} else {
								view2();
							}
							$('.add_contact_person').val('');
							$('.add_contact_person_email').val('');
							$('.add_contact_person_number').val('');
							$('.add_contact_tel_number').val('');
							$('.add_client_skype').val('');
							$('.add_client_wechat').val('');
							$('.add_client_whatsapp').val('');
							$('.add_client_qqmail').val('');
						},
						error: function() {
							alert("Error: Server encountered an error. Please try again or contact your system administrator.");
						}
					});
				}
			} else {
				alert("Please fill-up all the fields!");
			}
		});

		$('#btn_add_more_client_contact').click(function() {
			$('.clone-inputs-addcontactperson:first').clone().appendTo('.client-clone-addcontactperson').find("input").val("");
			$('.clone-inputs-addcontactperson:last').append('<div class="col-md-1">' +
				'<div class="form-group"><br>' +
				'<button type="button" class="btn btn-danger btn-rm-cp"><i class="fa fa-times"></i></button>' +
				'</div>' +
				'</div>');
		});

		$('body').on('click', '.btn-rm-cp', function() {
			$(this).closest('.clone-inputs-addcontactperson').remove();
		});

	});



	function addContactPersonValidator(class_name) {
		if (jQuery('.' + class_name).val() != "") {
			jQuery('.' + class_name).removeAttr("style");
		}
	}

</script>
{!!Form::close()!!}
