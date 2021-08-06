{{-- <div id="updateContact" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="{{route('updatecontact')}}" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Contact</h4>
      </div>
      <div class="modal-body">
          {{csrf_field()}}
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                  <label for="client_name">Client Name</label>
                  <select class="form-control" id="update_contact_name" name="client_name">
                    @foreach($clients as $cl)
                      <option value="{{$cl->client_code}}">{{$cl->client_name}}</option>
                    @endforeach
                  </select>
                  <input type="hidden" name="contact_id" id="update_contact_id">
              </div>
            </div>
     
          <div class="form-group">
              <label for="contact_person">Contact Person</label>
              <input type="text" name="contact_person" id="update_contact_person" class="form-control" required>
          </div>
          <div class="form-group">
              <label for="contact_person_email">Email Address</label>
              <input type="email" name="contact_person_email" id="update_contact_person_email" class="form-control" required>
          </div>
          <div class="form-group">
              <label for="contact_person_number">Contact Number</label>
              <input type="text" name="contact_person_number" id="update_contact_person_number" class="form-control numeric" required>
          </div>
        </div><!-- end of row-->
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
        <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Save Client Details</button>
      </div>
      </form>
    </div>
  </div>
</div> --}}


<div id="updateFactory" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg ui-front">
  
	  <!-- Modal content-->
	  <div class="modal-content">
		<form data-parsley-validate='' method="POST" action="">
		  
		  {!!csrf_field()!!}
		   
		 
		  
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Update Factory Information</h4>
		</div>
		<div class="modal-body">
		  <div class="row">
		  <div class="form-group">
			 {{--  <div class="col-md-12">
				<div class="form-group">
				  <label for="client">Client</label><span class="error_messages client_error"></span>
				  <input type="text" name="update_client_code" class="form-control" id="update_client_code"readonly>
				   <select class="form-control" required data-parsley-required-message="Please select a client!" data-parsley-errors-container=".client_error" name="update_client_code" id="update_client_code">
				  <option disabled selected>--Select Client--</option>
					@foreach($clients as $client)
					  <option value="{{$client->client_code}}">{{$client->client_name}}</option>
					@endforeach
				  </select> 
				  <div id="updateFac0" style="display:none" ><p style="color:red;">This field is required! </p></div>
				</div>
			  </div> --}}
			  <div class="col-md-4">
				<div class="form-group">
				  <label for="factory_name">Factory Name</label><span class="error_messages factory_error"></span>
				  <input type="text" name="update_factory_name" class="form-control" id="update_factory_name" required data-parsley-required-message="Please enter a Factory name!" data-parsley-errors-container=".factory_error" onchange="textInputValidator(this.id)">
				
					<input type="hidden" name="update_factory_id" id="update_factory_id"  class="form-control">
					<input type="hidden" name="update_country_id" id="update_country_id"  class="form-control">
					<input type="hidden" name="update_state_id" id="update_state_id"  class="form-control">
					<input type="hidden" name="update_city_id" id="update_city_id"  class="form-control">
					<div id="updateFac1" style="display:none" ><p style="color:red;">This field is required! </p></div>              
				</div>
			  </div>
  
			  {{-- <div class="col-md-4">
				<div class="form-group">
				  <label for="update_factory_address">Factory address</label><span class="error_messages address_error"></span>
				  <input type="text" name="update_factory_address" class="form-control" id="update_factory_address" required data-parsley-required-message="Please enter the factory address!" data-parsley-errors-container=".address_error">
				  <div id="updateFac2" style="display:none" ><p style="color:red;">This field is required! </p></div>
				</div>
			  </div> --}}
  
			  <div class="col-md-8">
				<div class="form-group">
				  <label for="update_factory_address_local">Factory address Local</label><span class="error_messages address_local_error"></span>
				  <input type="text" name="update_factory_address_local" class="form-control"  id="update_factory_address_local" required data-parsley-required-message="Please enter the factory address local!" data-parsley-errors-container=".address_local_error" onchange="textInputValidator(this.id)">
				  <div id="updateFac3" style="display:none" ><p style="color:red;">This field is required! </p></div>
				</div>
			  </div>
  
			  <div class="col-md-4">
				<div class="form-group">
				  <label for="factory_country">Country</label><span class="error_messages country_error"></span>
				  <select class="form-control" required  name="update_factory_country" id="update_factory_country" onchange="showStateByCountryChange()">
					<option disabled selected>--Select Country--</option>
					{{-- @foreach($countries as $country)
					  <option value="{{$country->id}}">{{$country->nicename}}</option>
					@endforeach --}}
				  </select>
				  <div id="updateFac4" style="display:none" ><p style="color:red;">This field is required! </p></div>
				</div>
			  </div>
  
			  {{-- <div class="col-md-6">
				<div class="form-group">
				  <label for="factory_city">Factory City</label><span class="error_messages city_error"></span>
				  <input type="text" name="update_factory_city" class="form-control" id="update_factory_city" required data-parsley-required-message="Please enter the City!" data-parsley-errors-container=".city_error">
				  <div id="updateFac4" style="display:none" ><p style="color:red;">This field is required! </p></div>
				</div>
			  </div> --}}
  
			  <div class="col-md-4">
				<div class="form-group">
				  <label for="update_factory_state">Enter State</label><span class="error_messages state_error"></span>
				  {{-- <select class="form-control" name="update_factory_state" id="update_factory_state" onchange="showCityByCountryAndStateChange()">
					<option value="">Select State</option>
				  </select> --}}
				  <input type="text" class="form-control" required name="update_factory_state" id="update_factory_state">
				  <input type="hidden" class="form-control" name="update_factory_state_id" id="update_factory_state_id">
	
				  <div id="updateFac5" style="display:none" ><p style="color:red;">This field is required! </p></div>
				</div>
			  </div>
			  
			   <div class="col-md-4">
				<div class="form-group">
				  <label for="update_factory_city">Enter City</label><span class="error_messages city_error"></span>
				  {{-- <select class="form-control" required data-parsley-required-message="Please select a city!"  data-parsley-errors-container=".city_error" name="update_factory_city" id="update_factory_city" onchange="textInputValidator(this.id)">
					<option value="">--Select City--</option>
				  </select> --}}
				  <input type="text" class="form-control" required data-parsley-required-message="Please select a city!"  data-parsley-errors-container=".city_error" name="update_factory_city" id="update_factory_city" onchange="textInputValidator(this.id)">
  
				  <div id="updateFac6" style="display:none" ><p style="color:red;">This field is required! </p></div>
				</div>
			  </div>
  
				  <div class="col-md-12 ">
						<div class="form-group">
						 {{--  {{ Form::button('<i class="fa fa-ban "></i> Cancel', ['class' => 'btn btn-danger pull-right','data-dismiss' => "modal"]) }}
						  &nbsp; {{ Form::button('<i class="fa fa-floppy-o "></i> Save Client Details', ['class' => 'btn btn-success pull-right','type'=>'button','onclick'=>'test()']) }} --}}
						</div>
					  </div>
	 
			  <div id="div_edit_more_fields">
			  </div>
  
  
			</div>   
		  </div>       
		</div><!-- end of modal body -->
		<div class="modal-footer">
		  {!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
		  {!! Form::button('<i class="fa fa-floppy-o"></i> Update Factory Details', ['class' => 'btn btn-success','type'=>'button','onclick'=>'test()']) !!}
		</div>
		 </form>
	  </div>
  
	</div>
  </div>
  
  
  
  <script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
  
		<script>
  function update_Factory_data(id){
	var sure_delete = confirm("Are you sure you want to delete this factory contact person?");
		  var dis_btn = this;
		  if (sure_delete) {
			$('.send-loading ').show();
			//alert(id);
			$.ajaxSetup({
							  headers: {
								  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
							  }
							  });
						   
							  $.ajax({
								 type:'POST',
								 url:'/deletecontactfactory',
								 data:{contact_id:id},
								 success:function(data){
								   console.log(data);
									$('#'+data).remove();
									alert("successfully deleted");
									$('.send-loading ').hide();
								  },
								  error: function(){
									alert("Error: Server encountered an error. Please try again or contact your system administrator.");
								  }
								 
								 });
		  } else {
		  }
  }
		
  var upFac =[
  'update_client_code',
  'update_factory_name',
  'update_factory_address',
  'update_factory_address_local',
  'update_factory_country',
  'update_factory_state',
  'update_factory_city',
  'update_contact_person',
  'update_contact_person_email',
  'update_contact_person_number'
  ];
  function checkeds()
		  {
		   
			for(var x=0;x<=9;x++){
			jQuery('#'+upFac[x]+'').removeAttr("style");
			}
			for(var x=0;x<=9;x++){
			  jQuery('#updateFac'+x+'').css("display","none");
			}
		  }
	   
	   function test()
	   {
		 var IdcontactFactory = [];
		  var update_contact_person =[];
		  var update_contact_person_email =[];
		  var update_contact_person_number =[];
		  var update_contact_person_tel_number =[];
		  var update_contact_skype = [];
		  var update_contact_wechat =[];
		  var update_contact_whatsapp =[];
		  var update_contact_qqmail =[];
	   //alert("sdfsd");
	/*     checkeds(); */
	  /*   for(var x=0;x<=9;x++){
		if(jQuery('#'+upFac[x]+'').val()=="")
		{
		  jQuery('#updateFac'+x+'').css("display","block");
		  jQuery('#'+upFac[x]+'').css('border-color', 'red');
		  x=10;
		}else if(x==9) { */
		
		  
			  
		var cIdcontactFactory = jQuery('.IdcontactFactory');
		var cupdate_contact_person = jQuery('.update_contact_person');
		var cupdate_contact_person_email = jQuery('.update_contact_person_email');
		var cupdate_contact_person_number = jQuery('.update_contact_person_number');
		var cupdate_contact_person_tel_number = jQuery('.update_contact_tel_person_number');
		var cupdate_contact_skype = jQuery('.update_contact_skype');
		var cupdate_contact_wechat = jQuery('.update_contact_wechat');
		var cupdate_contact_whatsapp = jQuery('.update_contact_whatsapp');
		var cupdate_contact_qqmail = jQuery('.update_contact_qqmail');
		
		var count_null=0; //variable for counting the null values
		for(var i = 0; i < cIdcontactFactory.length; i++){
				var g_data=$(cIdcontactFactory[i]).val();
				IdcontactFactory.push(g_data);
				/* if(g_data==""){
					count_null+=1;
					$(cIdcontactFactory[i]).css("border","1px solid red");
				  }else{
					$(cIdcontactFactory[i]).removeAttr("style");
				  } */
			  }
			  for(var i = 0; i < cupdate_contact_person.length; i++){
				var g_data=$(cupdate_contact_person[i]).val();
				update_contact_person.push(g_data);
				if(g_data==""){
					count_null+=1;
					$(cupdate_contact_person[i]).css("border","1px solid red");
				  }else{
					$(cupdate_contact_person[i]).removeAttr("style");
				  }
			  }
			   for(var i = 0; i < cupdate_contact_person_email.length; i++){
				var g_data=$(cupdate_contact_person_email[i]).val();
				update_contact_person_email.push(g_data);
				if(g_data==""){
					count_null+=1;
					$(cupdate_contact_person_email[i]).css("border","1px solid red");
				  }else{
					$(cupdate_contact_person_email[i]).removeAttr("style");
				  }
			  }
				for(var i = 0; i < cupdate_contact_person_number.length; i++){
				var g_data=$(cupdate_contact_person_number[i]).val();
				update_contact_person_number.push(g_data);
				if(g_data==""){
					count_null+=1;
					$(cupdate_contact_person_number[i]).css("border","1px solid red");
				  }else{
					$(cupdate_contact_person_number[i]).removeAttr("style");
				  }
			  }
			  for(var i = 0; i < cupdate_contact_person_tel_number.length; i++){
				var g_data=$(cupdate_contact_person_tel_number[i]).val();
				update_contact_person_tel_number.push(g_data);
				if(g_data==""){
					count_null+=1;
					$(cupdate_contact_person_tel_number[i]).css("border","1px solid red");
				  }else{
					$(cupdate_contact_person_tel_number[i]).removeAttr("style");
				  }
			  }
				 for(var i = 0; i < cupdate_contact_skype.length; i++){
				var g_data=$(cupdate_contact_skype[i]).val();
				update_contact_skype.push(g_data);
				if(g_data==""){
					count_null+=1;
					$(cupdate_contact_skype[i]).css("border","1px solid red");
				  }else{
					$(cupdate_contact_skype[i]).removeAttr("style");
				  }
			  }
			   for(var i = 0; i < cupdate_contact_wechat.length; i++){
				var g_data=$(cupdate_contact_wechat[i]).val();
				update_contact_wechat.push(g_data);
				if(g_data==""){
					count_null+=1;
					$(cupdate_contact_wechat[i]).css("border","1px solid red");
				  }else{
					$(cupdate_contact_wechat[i]).removeAttr("style");
				  }
			  }
			   for(var i = 0; i < cupdate_contact_whatsapp.length; i++){
				var g_data=$(cupdate_contact_whatsapp[i]).val();
				update_contact_whatsapp.push(g_data);
				if(g_data==""){
					count_null+=1;
					$(cupdate_contact_whatsapp[i]).css("border","1px solid red");
				  }else{
					$(cupdate_contact_whatsapp[i]).removeAttr("style");
				  }
			  }
			  for(var i = 0; i < cupdate_contact_qqmail.length; i++){
				var g_data=$(cupdate_contact_qqmail[i]).val();
				update_contact_qqmail.push(g_data);
				if(g_data==""){
					count_null+=1;
					$(cupdate_contact_qqmail[i]).css("border","1px solid red");
				  }else{
					$(cupdate_contact_qqmail[i]).removeAttr("style");
				  }
			  }
			  /* console.log(IdcontactFactory);
			  console.log(update_contact_person);
			  console.log(update_contact_person_email);
			  console.log(update_contact_person_number);
			  console.log(update_contact_skype);
			  console.log(update_contact_wechat);
			  console.log(update_contact_whatsapp);
			  console.log(update_contact_qqmail); */
			  var update_factory_id =jQuery('#update_factory_id').val();
			  /* var update_client_code =jQuery('#update_client_code').val(); */
			  var update_factory_name = jQuery('#update_factory_name').val();
			  /* var update_factory_address = jQuery('#update_factory_address').val(); */
			 
			  var update_factory_address_local = jQuery('#update_factory_address_local').val();
			  var update_factory_country = jQuery('#update_factory_country').val();
			  var update_factory_country_name = jQuery('#update_factory_country option:selected').text();
			  //var update_factory_state= jQuery('#update_factory_state option:selected').text();
			  var update_factory_state_id= jQuery('#update_factory_state_id').val();
			  //var update_factory_city = jQuery('#update_factory_city option:selected').text();
			  var update_factory_city_id = jQuery('#update_factory_city').val();
			  var update_factory_city = jQuery('#update_factory_city').val();
			  var update_factory_state= jQuery('#update_factory_state').val();
			   var update_factory_address = update_factory_city +' '+ update_factory_state +' '+ update_factory_country_name;
   /* 
			  var update_contact_person = jQuery('#update_contact_person').val();
			  var update_contact_person_email = jQuery('#update_contact_person_email').val();
			  var update_contact_person_number = jQuery('#update_contact_person_number').val();
			   var update_contact_skype = jQuery('#update_contact_skype').val();
			  var update_contact_wechat = jQuery('#update_contact_wechat').val();
			  var update_contact_whatsapp = jQuery('#update_contact_whatsapp').val();
			  var update_contact_qqmail = jQuery('#update_contact_qqmail').val(); */ 
			  var update_id_name = ['update_factory_name','update_factory_address_local','update_factory_country','update_factory_state','update_factory_city'];
			  update_id_name.forEach(element => {
				var val=$('#'+element).val();
				  if(val==""){
					count_null+=1;
					$('#'+element).css("border","1px solid red");
				  }else{
					$('#'+element).removeAttr("style");
				  }
				});
				if(count_null==0){
				  $('.send-loading ').show();
				$.ajaxSetup({
				  headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				  }
				});
			  
			  $.ajax({
				 type:'POST',
				 url:'/postupdatefactory',
				 data:{
				   update_factory_id:update_factory_id,
				   /* update_client_code:update_client_code, */
				   update_factory_name:update_factory_name,
				   update_factory_address:update_factory_address,
				   update_factory_address_local:update_factory_address_local,
				   update_factory_country:update_factory_country,
				   update_factory_country_name:update_factory_country_name,
				   update_factory_state:update_factory_state,
				   update_factory_state_id:update_factory_state_id,
				   update_factory_city:update_factory_city,
				   update_factory_city_id:update_factory_city_id,
				
				   IdcontactFactory:IdcontactFactory,
				   update_contact_person:update_contact_person,
				   update_contact_person_email:update_contact_person_email,
				   update_contact_person_number:update_contact_person_number,
				   update_contact_person_tel_number:update_contact_person_tel_number,
				   update_contact_skype:update_contact_skype,
				   update_contact_wechat:update_contact_wechat,
				   update_contact_whatsapp:update_contact_whatsapp,
				   update_contact_qqmail:update_contact_qqmail
				  },
				 success:function(data){            
				  alert("Factory successfully updated.");
				  $('.send-loading ').hide();
				  window.location.href = 'factorylist';
				  //redirect()->route('clientcontacts',$client->client_code);
				},
				error: function(){
				  alert("Error: Server encountered an error. Please try again or contact your system administrator.");
				}
	 
			  });
				}else{
				  alert("Please fill up all the fields! Put N/A if unavailable.");
				}
  /* $('#clr').click(); */
	   /*  } 
	  } */
	   }
	   function updateFCPerson(id)
	   {
		  $.ajaxSetup({
			  headers: {
				  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			  });
			  var update_contact_person = jQuery('#update_contact_person'+id).val();
			  var update_contact_person_email = jQuery('#update_contact_person_email'+id).val();
			  var update_contact_person_number = jQuery('#update_contact_person_number'+id).val();
			   var update_contact_skype = jQuery('#update_contact_skype'+id).val();
			  var update_contact_wechat = jQuery('#update_contact_wechat'+id).val();
			  var update_contact_whatsapp = jQuery('#update_contact_whatsapp'+id).val();
			  var update_contact_qqmail = jQuery('#update_contact_qqmail'+id).val();
			  
			  $.ajax({
				 type:'POST',
				 url:'/postupdatefactorycontactperson',
				 data:{
				   update_contact_person:update_contact_person,
				   update_contact_person_email:update_contact_person_email,
				   update_contact_person_number:update_contact_person_number,
				   update_contact_id:id,
				   update_contact_skype:update_contact_skype,
				   update_contact_wechat:update_contact_wechat,
				   update_contact_whatsapp:update_contact_whatsapp,
				   update_contact_qqmail:update_contact_qqmail
				  },
				 success:function(data){
				window.location.href = 'factorylist';
				  alert("Updated");
				  //redirect()->route('clientcontacts',$client->client_code);
			  }
	 
			  });
	   }
	  $('#update_factory_state').autocomplete({
		maxResults: 10,
		source: function(request, response) {
		  var results = $.ui.autocomplete.filter(update_source_state, request.term);
		  
		  response(results.slice(0, this.options.maxResults));
		  },
		select: function (event, ui) {
			$("#update_factory_state").val(ui.item.label); // display the selected text
			$("#update_factory_state_id").val(ui.item.value); // save selected id to hidden input
			showCityByCountryAndStateChange();
			return false;
		}
	  });
	   function showStateByCountryChange() {
	   var id = $('#update_factory_country').val();
	   textInputValidator('update_factory_country');
	   $('#update_factory_state').val('Please wait...');
	  $.ajax({
		  //url: 'http://world.t-i-c.asia/webapi_state_controller.php?id=' + id,
		  url: '/get-state/'+id,
		  type: 'GET',
		  /*datatype: 'json',
		  data: {
			  show_all_country: 1
		  },*/
		  success: function(result) {
			update_source_state.length = 0;
			  //var data_country = result;
			  var data_country = JSON.parse(result);
			  $('#update_factory_state').val('');
			  //data_country.forEach(element => {
			  $.each(data_country, function(i, element) {
				  if (element.name == "" || element.name == null) {
				  } else {
					  //$('#update_factory_state').append('<option value="' + element.id + '">' + element.name + '</option>');
					  update_source_state.push({ value: element.id, label: element.name });
				  }
			  });
		  },
		  error: function(jqXHR, textStatus, errorThrown) {
			  $('#update_factory_state').empty();
			  $('#update_factory_state').append('<option value="">Something went wrong. Please try again.</option>');
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
  $('#update_factory_city').autocomplete({
	  maxResults: 10,
		  source: function(request, response) {
		  var results = $.ui.autocomplete.filter(update_source_city, request.term);
		  
		  response(results.slice(0, this.options.maxResults));
		  }
	});
  function showCityByCountryAndStateChange() {
	   var cid = $('#update_factory_country').val();
	   var sid = $('#update_factory_state_id').val();
	   textInputValidator('update_factory_state');
	   $('#update_factory_city').val('Please wait...');
	  //$('#update_factory_city').empty();
	  //$('#update_factory_city').append('<option value="">Please Wait...</option>');
	  $.ajax({
		  //url: 'http://world.t-i-c.asia/webapi_city_controller.php?state_id=' + sid,
		  url: '/get-city/'+sid,
		  type: 'GET',
		  /*datatype: 'json',
		  data: {
			  show_all_country: 1
		  },*/
		  success: function(result) {
			  //console.log(result);
			  //$('#update_factory_city').empty();
			  //$('#update_factory_city').append('<option value="">Select City</option>');
			  //var data_city=  JSON.parse(result);
			  $('#update_factory_city').val('');
			  var data_city = JSON.parse(result);
			  //var data_city = result;
			  update_source_city.length = 0;
			  //data_city.forEach(element => {
			  $.each(data_city, function(i, element) {
				  if (element.name == "" || element.name == null) {
				  } else {
					  //$('#update_factory_city').append('<option value="' + element.id + '">' + element.name + '</option>');
					  update_source_city.push(element.name);
				  }
			  });
		  },
		  error: function(jqXHR, textStatus, errorThrown) {
			  $('#update_factory_city').empty();
			  $('#update_factory_city').append('<option value="">Something went wrong. Please try again.</option>');
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
  function textInputValidator(input_id){
		 if(jQuery('#'+input_id).val()!=""){
			  jQuery('#'+input_id).removeAttr("style");
		  }
	   }
	   function multipleTextValidator(input_class){
		 if(jQuery('.'+input_class).val()!=""){
			  jQuery('.'+input_class).removeAttr("style");
		  }
	   }
		</script>