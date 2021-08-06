{!!Form::open(['enctype'=>'multipart/form-data','id'=>'new_loading_form','data-parsley-validate'=>'', 'route'=>'savecbpiinspection','class'=>'form-inspection'])!!}
<div class="row">
	<div class="col-md-12">
	<h4 class="heading">Inspection Details</h4>
	<hr>
	</div>
	{{-- <div  class="col-md-12">
		{{ Form::label('slider', 'Client Preview') }}
	</div>

	<div  class="col-md-12">

		<input id="loading_invisible" name="loading_invisible" type="hidden" value="">


		<label class="switch">
			<input type="checkbox" name="togBtn[]" id="togBtn">
			<div class="slider round"><!--ADDED HTML -->
				<span class="on">ON</span><span class="off">OFF</span><!--END--></div></label>
	</div> --}}
	<div class="col-md-4">
		<div class="form-group">
		    {{ Form::label('loading_service', 'Service') }}
		    {{ Form::select('loading_service', [
		    	'iqi' => 'Incoming Quality Inspection',
		    	'dupro' => 'During Production Inspection',
		    	'psi' => 'Pre Shipment Inspection',
		    	'cli' => 'Container Loading Inspection',
		    	'pls' => 'Setting up Production Lines',
		    	'cbpi' => 'CBPI - No Serial',
		    	'cbpi_serial' => 'CBPI - with Serial',
		    	'cbpi_isce' => 'CBPI - ISCE',
		    ], null, ['class' => 'form-control service cli_required', 'placeholder'=>'Select a Service', 'id'=>'loading_service_inspection']) }}
	  	</div>
	</div>

	<div class="col-md-4">
			<div class="form-group">
				{{ Form::label('sub_service_cbpi', 'Sub-service') }}
				{{ Form::select('sub_service_cbpi', [
					'garments' => 'Garments',
				], null, ['class' => 'form-control sub_service_cbpi cli_required', 'placeholder'=>'Select a Sub-service', 'id'=>'sub_service_cbpi', 'required'=>'']) }}
			  </div>
			  <div id="prod0" style="display:none" ><p style="color:red;">This field is required! </p></div>
		</div>
	
	

	<div class="col-md-4">
		<div class="form-group">
			{{ Form::label('client_project_number_cbpi', 'Client Project Number') }}
			{{ Form::text('client_project_number_cbpi', null, ['class' => 'form-control cli_required','id'=>'client_project_number_cbpi']) }}
		  </div>
	</div>


	<div class="col-md-4">
		<div class="form-group">
		    {{ Form::label('loading_inspection_date', 'Inspection Date') }}
		    {{ Form::text('loading_inspection_date', null, ['class' => 'form-control cli_required inspection_date', 'id'=>'loading_inspection_date']) }}
	  	</div>
	</div>
	
	<div class="contact-select">
		<div class="col-md-4">
			<div class="form-group">
			    {{ Form::label('client', 'Select Client') }}
			    {{-- <div class="input-group">
					<select class="form-control client_select cli_required" id="loading_client" name="loading_client" required>
				    	<option value="" selected>Select Client</option>
				    	@foreach($clients as $client)
				    		<option value="{{$client->client_code}}">{{$client->client_name}}</option>
				    	@endforeach
				    </select>
					<div class="input-group-btn">
					  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#newClient">
					    <i class="fa fa-plus"></i>
					  </button>
					</div>
				</div> --}}
			    <select class="form-control client_select cli_required" id="loading_client" name="loading_client" required>
					<option value="" selected>Select Client</option>
					@foreach($clients as $client)
						<option value="{{$client->client_code}}">{{$client->Company_Name}}</option>
					@endforeach
				</select>
		  	</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				{{ Form::label('loading_reference_number', 'Reference / Report Number') }}
				{{ Form::text('loading_reference_number', null, ['class' => 'cli_required form-control', 'id'=>'loading_reference_number','readOnly']) }}
			  </div>
		</div>


		<div class="col-md-4">
			<div class="form-group">
			    {{ Form::label('contact_person', 'Contact Person') }}
			     {{-- <div class="input-group">
					<select class="form-control contact_persons cli_required" id="loading_contact_person" name="loading_contact_person">
				    	<option value="" selected>Select Contact</option>
				    </select>
					<div class="input-group-btn">
					  <button class="btn btn-success contact_modal_button" type="button">
					    <i class="fa fa-plus"></i>
					  </button>
					</div>
				</div> --}}
				<select class="form-control contact_persons cli_required" id="loading_contact_person" name="loading_contact_person">
					<option value="" selected>Select Contact</option>
				</select>
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {{ Form::label('contact_person_number', 'Contact Number') }}
			    {{ Form::text('contact_person_number', null, ['class' => 'cli_required form-control numeric contact_number','id'=>'loading_contact_number']) }}
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {{ Form::label('contact_person_email', 'Email Address') }}
			    {{ Form::text('contact_person_email', null, ['class' => 'cli_required form-control contact_email','id'=>'loading_email']) }}
		  	</div>
		</div>

		<div id="add_more_contact_container_cbpi">
		</div>
	
		<div class="col-md-12 show_client_c_p" style="display:none;" id="show_client_c_p">
			<div class="form-group">
				<button class="btn btn-success" type="button" id="add_more_client_c_p_cbpi" >
					<i class="fa fa-plus"></i> Add More Contact Person
				</button>
			</div>
		</div>

      <div class="col-md-4">
		<div class="form-group">
		    {{ Form::label('loading_inspector', 'Assign Inspector') }}
		    {{ Form::select('loading_inspector', $inspectors, null, ['class' => 'cli_required form-control','placeholder'=>'Select an Inspector','required'=>'','id'=>'loading_inspector']) }}
	  	</div>
	</div>

  
  
  
      <div class="col-md-4">
			<div class="form-group">
			    {{ Form::label('inspector_address', 'Inspector Address') }}
			    {{ Form::text('inspector_address', null, ['class' => 'form-control  inspector_address_2','required'=>'','id'=>'inspector_address_2']) }}
		  	</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{{ Form::label('template', 'Select Template') }}
			<select class="form-control cli_required" name="loading_template" id="loading_template" required>
				<option value="" selected>Select Template</option>
				@foreach($templates as $template)
					<option value="{{$template->id}}">{{$template->name}}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>
<div class="row factory-select">
	<div class="col-md-12">
		<h4 class="heading">Factory Details</h4>
		<hr>
	</div>	
	<div class="col-md-4">
		<div class="form-group">
			{{ Form::label('loading_factory', 'Factory Name') }}
			{{-- <div class="input-group">
				<select class="cli_required form-control factory" name="loading_factory" id="loading_factory" required>
					<option value="" selected>Select Factory</option>
					@foreach($factories as $factory)
						<option value="{{$factory->id}}">{{$factory->factory_name}}</option>
					@endforeach
				</select>
				<div class="input-group-btn">
				  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#newFactory">
				    <i class="fa fa-plus"></i>
				  </button>
				</div>
			</div> --}}
			<select class="cli_required form-control factory" name="loading_factory" id="loading_factory" required>
				<option value="" selected>Select Factory</option>
				@foreach($factories as $factory)
					<option value="{{$factory->id}}">{{$factory->factory_name}}</option>
				@endforeach
			</select>
	  	</div> 
	</div>
	<div class="col-md-8">
		<div class="form-group">
		    {{ Form::label('loading_factory_address', 'Factory Address') }}
		    {{ Form::text('factory_address', null, ['class' => 'cli_required form-control factory_address','id'=>'loading_factory_address']) }}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {{ Form::label('loading_factory_contact_person', 'Factory Contact Person') }}
		    {{-- <div class="input-group">
				<select class="cli_required form-control factory_contact_person" name="loading_factory_contact_person" id="loading_factory_contact_person" required>
					<option value="" selected>Select Contact Person</option>
				</select>
				<div class="input-group-btn">
				  <button class="btn btn-success new-factory-contact" type="button">
				    <i class="fa fa-plus"></i>
				  </button>
				</div>
			</div> --}}
			<select class="cli_required form-control factory_contact_person" name="loading_factory_contact_person" id="loading_factory_contact_person" required>
				<option value="" selected>Select Contact Person</option>
			</select>
	  	</div> 
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {{ Form::label('loading_factory_contact_number', 'Contact Number (Factory)') }}
		    {{ Form::text('factory_contact_number', null, ['class' => 'cli_required form-control factory_contact_number numeric','id'=>'loading_factory_contact_number']) }}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {{ Form::label('loading_factory_email', 'Contact Email') }}
		    {{ Form::text('factory_email', null, ['class' => 'cli_required form-control factory_email','id'=>'loading_factory_email']) }}
	  	</div>
	</div>
{{-- jesser --}}
	<div class="col-md-4 fcp2" style="display:none;">
		<div class="form-group">
			<label for="factory_contact_person2">Factory Contact Person 2</label>
			<select class="form-control factory_contact_person2" id="factory_contact_person2_cbpi" name="factory_contact_person2_cbpi" >
				<option value="" >Select Contact Person</option>
			</select>
			</div>
	</div>
	<div class="col-md-4 fcp2" style="display:none;">
		<div class="form-group">
				{{ Form::label('factory_contact_number2', 'Contact Number (Factory) 2') }}
				{{ Form::text('factory_contact_number2', null, ['class' => 'form-control numeric factory_contact_number2','id'=>'factory_contact_number2']) }}
			</div>
	</div>
	<div class="col-md-4 fcp2" style="display:none;">
		<div class="form-group">
				{{ Form::label('factory_email2', 'Email Address 2') }}
				{{ Form::text('factory_email2', null, ['class' => 'form-control factory_email2','id'=>'factory_email2']) }}
			</div>
	</div>

	{{-- <div class="col-md-6">
		<div class="form-group">
		    {{ Form::label('loading_client_name', 'Client Name') }}
		    {{ Form::text('loading_client_name', null, ['class' => 'cli_required form-control','id'=>'loading_client_name']) }}
	  	</div>
	</div> --}}
	<div class="col-md-6">
		<div class="form-group">
		    {{ Form::label('loading_supplier_name', 'Supplier Name') }}
		    {{ Form::text('loading_supplier_name', null, ['class' => 'cli_required form-control', 'id'=>'loading_supplier_name']) }}
	  	</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
		    {{ Form::label('loading_requirements', 'Requirements') }}
		    {{ Form::textarea('loading_requirements', null, ['class' => 'cli_required form-control','rows'=>'7','id'=>'loading_requirements']) }}
	  	</div>
	</div>
	 {{ Form::label('requirement', 'Attachments') }}
	<div class="col-md-6 dropzone-container file_upload" id="file_upload_container">

	      <div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
	      <div class="fallback">
	          <input name="file[]" class="cli_required" type="file" id="file" multiple required />
	      </div>
	</div>
</div>

<div class="row" id="type_of_project">
		<hr>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
					<h4 class="heading">Type of Project</h4>
					<br/>
				</div>
			</div>
			<div class="row">
					<div class="col-md-4">
							<div class="form-group">
								{{ Form::label('template', 'Select Type of Project') }}<br/>
							{{-- 	<select class="form-control psi_required" name="project_type" id="project_type" required>
									<option value="" selected>Select type</option>
									<option value="app_project" selected>APP Project</option>
									<option value="word_project" selected>WORD Project</option>
								</select> --}}
								<label class="checkbox-inline">
									<input type="radio" name="project_type_cbpi" value="null" id="app_project_cbpi" class="psi_required" onclick="changeProjectTypeCbpi('app')"> APP Project
								</label>
								<label class="checkbox-inline">
									<input type="radio" name="project_type_cbpi" value="null" id="word_project_cbpi" class="psi_required" onclick="changeProjectTypeCbpi('word')"> WORD Project
								</label>

							</div>
						</div>
			</div>
	
			<hr>
		</div>
	</div>

<div class="col-md-offset-9 col-md-3">
{{ Form::button('Submit Inspection Details', ['class' => 'btn btn-success btn-block','style'=>'margin-top: 5px;','type'=>'button', 'id'=>'CBPI_submit']) }}	
</div>

{!!Form::close()!!}

<script>
	$('#loading_client').on('change', function() {
		var client_code=this.value;
		  if(client_code!=""){
			  var d = new Date();
			  //var date_now = d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear();
			  var date_now = d.getFullYear()+''+(d.getMonth()+1)
			  //var set_pn=client_code+"-"+date_now;
			  var options_year = {
        		year: '2-digit'
    			};
    			var options_month = {
    			    month: '2-digit'
    			};
					var today = new Date();
    			var two_digit_y = today.toLocaleDateString("en-US", options_year);
    			var two_digit_m = today.toLocaleDateString("en-US", options_month);
    			var date_today = two_digit_y + '' + two_digit_m;

				var set_pn=client_code+"-"+date_today;
	  
			  $.ajax({
			  type: "GET",
			  url: '/getclientcountinspection/'+client_code,
			  success: function(data) {
							  var c_count=data.count;
							  var get_count=parseInt(c_count)+1;
							   var set_count;
							  // get_count=10;
							   if(get_count<=9){
								  set_count='0'+get_count;
							   }else{
								  set_count=get_count;
							   }
							   set_pn=set_pn+'-'+set_count;
							   $('#loading_reference_number').val(set_pn);			
			  }
		  });
	  
		  }else{
			  $('#loading_reference_number').val("");
		  }
		  
	  });
	  
	  </script>

