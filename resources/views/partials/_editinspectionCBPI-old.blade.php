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
		    {!! Form::label('loading_service', 'Service') !!}
		    {!! Form::select('loading_service', [
		    	'iqi' => 'Incoming Quality Inspection',
		    	'dupro' => 'During Production Inspection',
		    	'psi' => 'Pre Shipment Inspection',
		    	'cli' => 'Container Loading Inspection',
		    	'pls' => 'Setting up Production Lines',
		    	'cbpi' => 'CBPI - No Serial',
		    	'cbpi_serial' => 'CBPI - with Serial',
				'cbpi_isce' => 'CBPI - ISCE',
				'site_visit' => 'Site Visit',
		    ], $inspection_details->service, ['class' => 'form-control service cli_required cli_draft_required', 'placeholder'=>'Select a Service', 'id'=>'loading_service_inspection','disabled'=>'']) !!}
	  	</div>
	</div>

	<div class="contact-select">
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('client', 'Select Client') !!}
			    <select class="form-control client_select cli_required cli_draft_required" id="loading_client" name="loading_client" required>
					<option value="" selected>Select Client</option>
					@foreach($clients as $client)
						@if($client->client_status!=2 || $client->client_status!='2')
							@if($client->client_code==$inspection_details->client_id)
								<option value="{{$client->client_code}}" selected>{{$client->Company_Name}}</option>
							@else
								<option value="{{$client->client_code}}">{{$client->Company_Name}}</option>
							@endif
						@endif
					@endforeach
				</select>
		  	</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('loading_reference_number', 'Reference / Report Number') !!}
				{!! Form::text('loading_reference_number', $inspection_details->reference_number, ['class' => 'cli_required form-control cli_draft_required', 'id'=>'loading_reference_number','readOnly']) !!}
			  </div>
		</div>
	</div>	
	
	

	


	
	
	<div class="contact-select">
		@foreach($contact_person_list as $index=>$contact) 
				@if ($index==0)
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('contact_person', 'Contact Person ') !!}
				<select class="form-control cli_required contact_persons cli_draft_required" id="loading_contact_person"  name="loading_contact_person">
					
					@foreach($client_contacts as $cc) 
						@if($cc->id==$contact)
							<option value="{{$cc->id}}" selected>{{$cc->contact_person}}</option>
						@else
							<option value="{{$cc->id}}">{{$cc->contact_person}}</option>
						@endif
						
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
					{!! Form::label('contact_person_number', 'Contact Number') !!}
					@foreach($client_contacts as $cc) 
					@if($cc->id==$contact)
						{!! Form::text('contact_person_number', $cc->contact_number, ['class' => 'form-control cli_required numeric contact_number cli_draft_required','required'=>'','id'=>'loading_contact_number'])!!}
					@endif
					@endforeach
			  
		  	</div>
		</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('contact_person_email', 'Email Address') !!}
						
						@foreach($client_contacts as $cc) 
						@if($cc->id==$contact)
							{!! Form::text('contact_person_email', $cc->email_address, ['class' => 'form-control cli_required contact_email cli_draft_required','id'=>'loading_email']) !!}
						@endif
						@endforeach
				  </div>
			</div>
		@else
		<div class="am_cp_parent">
		<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('contact_person', 'Contact Person ') !!}
					<select class="form-control cli_required contact_persons added_contact_persons cli_draft_required" id="loading_contact_person"  name="loading_contact_person">
						
						@foreach($client_contacts as $cc) 
							@if($cc->id==$contact)
								<option value="{{$cc->id}}" selected>{{$cc->contact_person}}</option>
							@else
								<option value="{{$cc->id}}">{{$cc->contact_person}}</option>
							@endif
							
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
						{!! Form::label('contact_person_number', 'Contact Number') !!}
						@foreach($client_contacts as $cc) 
						@if($cc->id==$contact)
							{!! Form::text('contact_person_number', $cc->contact_number, ['class' => 'form-control cli_required numeric contact_number cli_draft_required','required'=>'','id'=>'loading_contact_number']) !!}
						@endif
						@endforeach
				  
				  </div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label>Email Address</label>
					<div class="input-group">
						<input type="text" class= "form-control cli_required numeric am_contact_email cli_draft_required" value="{{$cc->email_address}}" required>
						<div class="input-group-btn">
						<button class="btn btn-danger del_more_client_c_p" type="button">
						<i class="fa fa-times"></i>
						</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		@endif
		
		@endforeach 

		<div id="add_more_contact_container_cbpi">
		</div>
	
		<div class="col-md-12 show_client_c_p"  id="show_client_c_p">
			<div class="form-group">
				<button class="btn btn-success" type="button" id="add_more_client_c_p_cbpi" >
					<i class="fa fa-plus"></i> Add More Contact Person
				</button>
			</div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('client_project_number_cbpi', 'Client Project Number') !!}
				{!! Form::text('client_project_number_cbpi', $inspection_details->client_project_number, ['class' => 'form-control cli_required cli_draft_required','id'=>'client_project_number_cbpi']) !!}
			  </div>
		</div>

		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('loading_inspection_date', 'Inspection Date') !!}
				{!! Form::text('loading_inspection_date', $inspection_details->inspection_date, ['class' => 'form-control cli_required inspection_date cli_draft_required', 'id'=>'loading_inspection_date']) !!}
			  </div>
		</div>

		<div class="cbpi-clone-inspector-container">
			<div class="cbpi-clone-inspector">
      			<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('loading_inspector', 'Assign Inspector') !!}
					    {!! Form::select('loading_inspector', $inspectors,  $inspection_details->inspector_id, ['class' => 'cli_required form-control cli_draft_required sel-inspector','placeholder'=>'Select an Inspector','required'=>'','id'=>'loading_inspector']) !!}
	  				</div>
				</div>

      			<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('inspector_address', 'Inspector Address') !!}
					    {!! Form::text('inspector_address', $inspector_info->address, ['class' => 'form-control  inspector_address_2 cli_draft_required insp-addr','required'=>'','id'=>'inspector_address_2']) !!}
				  	</div>
				</div>
			</div>
			@foreach($other_inspector as $other)
				@if($other=='null' || $other==null)
				@else
					<div class="cbpi-clone-inspector">
						<div class="col-md-6">
							<div class="form-group">
							    {!! Form::label('inspector_sec', 'Assign Inspector') !!}
								{{-- {!! Form::select('inspector_sec', $inspectors, $inspection_details->inspector_id, ['class' => 'form-control psi_required psi_draft_required sel-inspector sel-added-inspector','placeholder'=>'Select an Inspector','required'=>'']) !!} --}}
								<select id="inspector_sec" name="inspector_sec" class="form-control cli_required sel-inspector cbpi-sel-added-inspector">
									<option value="">Select an Inspector</option>
									@foreach($inspector_list as $inspector)	
										@if($inspector->id==$other)
											<option value="{{$inspector->user_id}}" selected>{{$inspector->name}}</option>
										@else
											<option value="{{$inspector->user_id}}">{{$inspector->name}}</option>
										@endif														
									@endforeach
								</select>
						  	</div>
						</div>
    					<div class="col-md-6">
							<div class="form-group">
									<label>Inspector Address</label>
									<input type="text" name="cb_inspector_address" id="cb_inspector_address" class="form-control cbpi-added-inspector-address insp-addr" 	value="{{$inspector_info->address}}" required >
						  	</div>
						</div>
						<div class="col-md-12">
							<button class="btn btn-danger btn-rm-inspector" type="button"><i class="fa fa-times"></i> Remove</button>
							<br><br>
						</div>
					</div>
				@endif
			@endforeach
		</div>
	</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="cbpi_add_inspector">
				<i class="fa fa-plus"></i> Add Other Inspector
			</button>
		</div>

		<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('cbpi_manday', 'Manday') !!}
					{!! Form::text('cbpi_manday', 1, ['class' => 'form-control  psi_required psi_draft_required cbpi_manday','required'=>'','readOnly'=>'true']) !!}
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
			{!! Form::label('loading_factory', 'Factory Name') !!}
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
			<select class="cli_required form-control factory cli_draft_required" name="loading_factory" id="loading_factory" required>
				<option value="" selected>Select Factory</option>
				@foreach($factories as $factory)				
					@if($factory->id==$inspection_details->factory_id)
						<option value="{{$factory->id}}" selected>{{$factory->factory_name}}</option>
					@else
						<option value="{{$factory->id}}">{{$factory->factory_name}}</option>
					@endif
				@endforeach
			</select>
	  	</div> 
	</div>
	<div class="col-md-8">
		<div class="form-group">
		    {!! Form::label('loading_factory_address', 'Factory Address') !!}
		    {!! Form::text('factory_address', $factory_info->factory_address, ['class' => 'cli_required form-control factory_address cli_draft_required','id'=>'loading_factory_address']) !!}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('loading_factory_contact_person', 'Factory Contact Person') !!}
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
			<select class="cli_required form-control factory_contact_person cli_draft_required" name="loading_factory_contact_person" id="loading_factory_contact_person" required>
				{{-- <option value="" selected>Select Contact Person</option> --}}
				@foreach($factory_contactlist as $contact)			
					@if($contact->id==$inspection_details->factory_contact_person)
						<option value="{{$contact->id}}" selected>{{$contact->factory_contact_person}}</option>
					@else
						<option value="{{$contact->id}}" >{{$contact->factory_contact_person}}</option>
					@endif
				@endforeach
			</select>
	  	</div> 
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('loading_factory_contact_number', 'Contact Number (Factory)') !!}
		    {!! Form::text('factory_contact_number', $factory_contact1->factory_contact_number, ['class' => 'cli_required form-control factory_contact_number numeric cli_draft_required','id'=>'loading_factory_contact_number']) !!}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('loading_factory_email', 'Contact Email') !!}
		    {!! Form::text('factory_email', $factory_contact1->factory_email, ['class' => 'cli_required form-control factory_email cli_draft_required','id'=>'loading_factory_email']) !!}
	  	</div>
	</div>

	@if($inspection_details->factory_contact_person2=="" || $inspection_details->factory_contact_person2=="N/A" || $inspection_details->factory_contact_person2=="0" || $inspection_details->factory_contact_person2==0 || $inspection_details->factory_contact_person2==null)
		<div class="fcp_container_cbpi">
			<div class="clone_fcp_cbpi" style="display:none;">
				<div class="col-md-4">
						<div class="form-group">
							<label for="fcp_sel_cbpi">Factory Contact Person</label>
							<select class="form-control fcp_sel_cbpi factory_contact_added_cbpi">
								<option value="" >Select Contact Person</option>
							</select>
						  </div>
				</div>
				<div class="col-md-4">
						<div class="form-group">
							{!! Form::label('factory_contact_number_added_cbpi', 'Contact Telephone Number (Factory)') !!}
							{!! Form::text('factory_contact_number_added_cbpi', null, ['class' => 'form-control factory_contact_number_added_cbpi','required'=>'']) !!}
						  </div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('factory_email_added_cbpi', 'Email Address') !!}
						<div class="input-group">
							{!! Form::text('factory_email_added_cbpi', null, ['class' => 'form-control factory_email_added_cbpi ','required'=>'']) !!}
						
							<div class="input-group-btn">
							  <button class="btn btn-danger rm_fcp_cbpi" type="button">
								<i class="fa fa-times"></i>
							  </button>
							</div>
						</div> 
					</div>
				</div>
			</div>
		</div>
	@else

	<div class="fcp_container_cbpi">
		@foreach($fac_contact_person_list as $fcpl)
		<div class="clone_fcp_cbpi">
			<div class="col-md-4">
					<div class="form-group">
						<label for="fcp_sel_cbpi">Factory Contact Person</label>
						<select class="form-control fcp_sel_cbpi factory_contact_added_cbpi">
							<option value="" >Select Contact Person</option>
							@foreach($factory_contactlist as $fc)			
									@if($fc->id==$fcpl)
										<option value="{{$fc->id}}" selected>{{$fc->factory_contact_person}}</option>
									@else
										<option value="{{$fc->id}}" >{{$fc->factory_contact_person}}</option>
									@endif
								@endforeach	
						</select>
					  </div>
			</div>
			<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('factory_contact_number_added_cbpi', 'Contact Telephone Number (Factory)') !!}
							@foreach($factory_contactlist as $fc)			
								@if($fc->id==$fcpl)
									{!! Form::text('factory_contact_number_added_cbpi', $fc->factory_tel_number, ['class' => 'form-control factory_contact_number_added_cbpi',	'required'=>'']) !!}
								@endif
							@endforeach	
					  </div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('factory_email_added_cbpi', 'Email Address') !!}
					<div class="input-group">
						@foreach($factory_contactlist as $fc)			
								@if($fc->id==$fcpl)
								{!! Form::text('factory_email_added_cbpi', $fc->factory_email, ['class' => 'form-control factory_email_added_cbpi ','required'=>'']) !!}
								@endif
							@endforeach	
						<div class="input-group-btn">
						  <button class="btn btn-danger rm_fcp_cbpi" type="button">
							<i class="fa fa-times"></i>
						  </button>
						</div>
					</div> 
				</div>
			</div>
		</div>
		@endforeach	
	</div>


	{{-- <div class="col-md-4 fcp2">
		<div class="form-group">
			<label for="factory_contact_person2">Factory Contact Person 2</label>
			<select class="form-control factory_contact_person2" id="factory_contact_person2_cbpi" name="factory_contact_person2_cbpi" >
				@foreach($factory_contactlist as $contact)			
				@if($contact->id==$inspection_details->factory_contact_person2)
					<option value="{{$contact->id}}" selected>{{$contact->factory_contact_person}}</option>
				@else
					<option value="{{$contact->id}}" >{{$contact->factory_contact_person}}</option>
				@endif
			@endforeach
			</select>
			</div>
	</div>
	<div class="col-md-4 fcp2" >
		<div class="form-group">
				{{ Form::label('factory_contact_number2', 'Contact Number (Factory) 2') }}
				{{ Form::text('factory_contact_number2', $factory_contact2->factory_contact_number, ['class' => 'form-control numeric factory_contact_number2','id'=>'factory_contact_number2']) }}
			</div>
	</div>
	<div class="col-md-4 fcp2" >
		<div class="form-group">
				{{ Form::label('factory_email2', 'Email Address 2') }}
				{{ Form::text('factory_email2', $factory_contact2->factory_email, ['class' => 'form-control factory_email2','id'=>'factory_email2']) }}
			</div>
	</div> --}}
	@endif

{{-- jesser --}}
	{{-- <div class="col-md-4 fcp2" style="display:none;">
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
	</div> --}}

	{{-- <div class="col-md-6">
		<div class="form-group">
		    {{ Form::label('loading_client_name', 'Client Name') }}
		    {{ Form::text('loading_client_name', null, ['class' => 'cli_required form-control','id'=>'loading_client_name']) }}
	  	</div>
	</div> --}}

	<div class="col-md-12 show_fac_c_p_cbpi"  id="show_fac_c_p_cbpi">
		<div class="form-group">
			<button class="btn btn-success" type="button" id="add_more_fac_c_p_cbpi" >
				<i class="fa fa-plus"></i> Add More Contact Person
			</button>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
		    {!! Form::label('loading_supplier_name', 'Supplier Name') !!}
		    {!! Form::text('loading_supplier_name', $inspection_details->supplier, ['class' => 'cli_required form-control', 'id'=>'loading_supplier_name']) !!}
	  	</div>
	</div>
</div>

<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Inspector Cost ($)</h4>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_ins_currency', 'Currency') !!}
				<select class="form-control cbpi_ins_currency" name="cbpi_ins_currency" id="cbpi_ins_currency" required>
					@foreach($currency as $key => $value)				
						@if($inspector_cost->currency==$key)
							<option value="{{$key}}" selected>{{htmlentities($value)}}</option>
						@else
							<option value="{{$key}}">{{htmlentities($value)}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_ins_md_charge', 'MD Charges') !!}
				{!! Form::number('cbpi_ins_md_charge', $inspector_cost->md_charges, ['class' => 'form-control cbpi_ins_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_ins_travel_cost', 'Travel Cost') !!}
				{!! Form::number('cbpi_ins_travel_cost', $inspector_cost->travel_cost, ['class' => 'form-control cbpi_ins_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_ins_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('cbpi_ins_hotel_cost', $inspector_cost->hotel_cost, ['class' => 'form-control cbpi_ins_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_ins_ot_cost', 'OT Cost') !!}
				{!! Form::number('cbpi_ins_ot_cost', $inspector_cost->ot_cost, ['class' => 'form-control cbpi_ins_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="cbpi_ins_other_cost_container">
			@foreach($ins_other_cost_array as $key => $value)
				@if(count($ins_other_cost_array)>1)
					<div class="cbpi_ins_cost_div">
						<div class="col-md-6">
							<div class="form-group">
								<label>Other Cost Description</label>
							<input type="text" class="form-control cbpi_ins_other_cost_text cli_required" placeholder="Enter description cost here" value="{{$key}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cost</label>
								<div class="input-group">
									<input type="number" class="form-control cbpi_ins_other_cost_value cli_required" value="{{$value}}">
									<div class="input-group-btn">
										<button class="btn btn-danger cbpi_del_added_insp_cost" type="button">
										<i class="fa fa-times"></i> 
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			@endforeach
		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="cbpi_add_insp_other_cost">
				<i class="fa fa-plus"></i> Add Other Cost
			</button>
		</div>
	</div>
	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Client Cost ($)</h4>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_cli_currency', 'Currency') !!}
				<select class="form-control cbpi_cli_currency" name="cbpi_cli_currency" id="cbpi_cli_currency" required>
					@foreach($currency as $key => $value)				
						@if($client_cost->currency==$key)
							<option value="{{$key}}" selected>{{htmlentities($value)}}</option>
						@else
							<option value="{{$key}}">{{htmlentities($value)}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_cli_md_charge', 'MD Charges') !!}
				{!! Form::number('cbpi_cli_md_charge', $client_cost->md_charges, ['class' => 'form-control cbpi_cli_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_cli_travel_cost', 'Travel Cost') !!}
				{!! Form::number('cbpi_cli_travel_cost', $client_cost->travel_cost, ['class' => 'form-control cbpi_cli_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_cli_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('cbpi_cli_hotel_cost', $client_cost->hotel_cost, ['class' => 'form-control cbpi_cli_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_cli_ot_cost', 'OT Cost') !!}
				{!! Form::number('cbpi_cli_ot_cost', $client_cost->ot_cost, ['class' => 'form-control cbpi_cli_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="cbpi_cli_other_cost_container">
			@foreach($client_other_cost_array as $key => $value)
				@if(count($client_other_cost_array)>1)
					<div class="cli_cost_div">
						<div class="col-md-6">
							<div class="form-group">
								<label>Other Cost Description</label>
							<input type="text" class="form-control cbpi_cli_other_cost_text cli_required" placeholder="Enter description cost here" value="{{$key}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cost</label>
								<div class="input-group">
									<input type="number" class="form-control cbpi_cli_other_cost_value cli_required" value="{{$value}}">
									<div class="input-group-btn">
										<button class="btn btn-danger cbpi_del_added_cli_cost" type="button">
										<i class="fa fa-times"></i> 
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			@endforeach
		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="cbpi_add_cli_other_cost">
				<i class="fa fa-plus"></i> Add Other Cost
			</button>
		</div>
	</div>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		    {!! Form::label('loading_requirements', 'Requirements') !!}
		    {!! Form::textarea('loading_requirements', $inspection_details->requirement, ['class' => 'cli_required form-control','rows'=>'7','id'=>'loading_requirements']) !!}
	  	</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			{!! Form::label('memo_cbpi', 'Memo / Notes') !!}
			{!! Form::textarea('memo_cbpi', $inspection_details->memo, ['class' => 'form-control cli_required memo_cbpi','rows'=>'4']) !!}
		</div>
	{{-- 	<div id="prod20" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
	</div>
</div>

<div class="row">	
	 {!! Form::label('requirement', 'Blank reports and other attachment') !!}
	<div class="col-md-12 dropzone-container file_upload" id="file_upload_container">

	      <div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
	      <div class="fallback">
	          <input name="file[]" class="cli_required" type="file" id="file" multiple required />
	      </div>
	</div>
</div>

{{-- <div class="col-md-12">
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
						<label class="checkbox-inline">
							<input type="radio" name="project_type_cbpi" value="null" id="app_project_cbpi" class="cli_required" onclick="changeProjectTypeCbpi('app')"> APP Project
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="project_type_cbpi" value="null" id="word_project_cbpi" class="cli_required" onclick="changeProjectTypeCbpi('word')"> WORD Project
						</label>

					</div>
				</div>
	</div>
</div> --}}

{{-- <div class="col-md-4 div_sub_service" style="display:none;">
		<div class="form-group">
				{{ Form::label('word_template_cbpi', 'Word Template') }}
				{{ Form::select('word_template_cbpi', [
					'psi-garmets' => 'PSI-Garments',
					'psi-decoration' => 'PSI-Decoration',
					'psi-electoronics' => 'PSI-Electoronics',
				], null, ['class' => 'form-control word_template_cbpi', 'placeholder'=>'Select a Word Template', 'id'=>'word_template_cbpi', 'required'=>'']) }}
			</div>
	</div>

<div class="col-md-12" id="blank_report_cbpi" style="display:none;">

	<div class="row">
			<div class="col-md-4">
					<div class="form-group">
						{{ Form::label('blank_report_type_cbpi', 'Select Type of Blank Report') }}<br/>
						<label class="checkbox-inline">
							<input type="radio" name="blank_report_type_cbpi" value="qr" id="report_qr" class="blank_report_type_cbpi"  required> QR
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="blank_report_type_cbpi" value="dr" id="report_dr" class="blank_report_type_cbpi"  required> DR
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="blank_report_type_cbpi" value="qr_dr" id="report_qr_dr" class="blank_report_type_cbpi"  required> BOTH
						</label>

					</div>
				</div>
	</div>

</div>



<div class="col-md-4" id="div_template_cbpi" style="display:none;">
		<div class="form-group">
			{{ Form::label('template', 'Select Template') }}
			<select class="form-control" name="loading_template" id="loading_template" required>
				<option value="" selected>Select Template</option>
				@foreach($templates as $template)
					<option value="{{$template->id}}">{{$template->name}}</option>
				@endforeach
			</select>
		</div>
	</div> --}}


	<div class="col-md-12">
			<div class="row">
					<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('template', 'Select Type of Project') !!}<br/>
								<label class="checkbox-inline">
									@if($inspection_details->project_type=="app_project")
										<input type="radio" name="project_type_cbpi" value="app_project" id="project_type_cbpi"  onclick="changeProjectTypeCbpi('app')" required checked> APP Project
									@else
										<input type="radio" name="project_type_cbpi" value="null" id="project_type_cbpi"  onclick="changeProjectTypeCbpi('app')" required> APP Project
									@endif
									
								</label>
								<label class="checkbox-inline">
									@if($inspection_details->project_type=="word_project")
									<input type="radio" name="project_type_cbpi" value="word_project" id="word_project_cbpi"  onclick="changeProjectTypeCbpi('word')" required checked> WORD Project
									@else
										<input type="radio" name="project_type_cbpi" value="null" id="word_project_cbpi" onclick="changeProjectTypeCbpi('word')" required> WORD Project
									@endif
									
								</label>
	
							</div>
						</div>
			</div>
		</div>
		@if($inspection_details->project_type=="word_project")
			{{-- <div class="col-md-4 div_sub_service">
				<div class="form-group">
						{{ Form::label('word_template_cbpi', 'Word Template') }}
						{{ Form::select('word_template_cbpi', [
							'psi-garmets' => 'PSI-Garments',
							'psi-decoration' => 'PSI-Decoration',
							'psi-electoronics' => 'PSI-Electoronics',
						], null, ['class' => 'form-control word_template_cbpi', 'placeholder'=>'Select a Word Template', 'id'=>'word_template_cbpi', 'required'=>'']) }}
					</div>
			</div>
			<div class="col-md-12" id="blank_report_cbpi">
				<div class="row">
						<div class="col-md-4">
								<div class="form-group">
									{{ Form::label('blank_report_type_cbpi', 'Select Type of Blank Report') }}<br/>
									<label class="checkbox-inline">
										<input type="radio" name="blank_report_type_cbpi" value="qr" id="report_qr" class="blank_report_type_cbpi"  required> QR
									</label>
									<label class="checkbox-inline">
										<input type="radio" name="blank_report_type_cbpi" value="dr" id="report_dr" class="blank_report_type_cbpi"  required> DR
									</label>
									<label class="checkbox-inline">
										<input type="radio" name="blank_report_type_cbpi" value="qr_dr" id="report_qr_dr" class="blank_report_type_cbpi"  required> BOTH
									</label>
								
								</div>
							</div>
				</div>
			</div> --}}
		@else
			{{-- <div class="col-md-4 div_sub_service" style="display:none;">
				<div class="form-group">
						{{ Form::label('word_template_cbpi', 'Word Template') }}
						{{ Form::select('word_template_cbpi', [
							'psi-garmets' => 'PSI-Garments',
							'psi-decoration' => 'PSI-Decoration',
							'psi-electoronics' => 'PSI-Electoronics',
						], null, ['class' => 'form-control word_template_cbpi', 'placeholder'=>'Select a Word Template', 'id'=>'word_template_cbpi', 'required'=>'']) }}
					</div>
			</div>
			<div class="col-md-12" id="blank_report_cbpi" style="display:none;">
				<div class="row">
						<div class="col-md-4">
								<div class="form-group">
									{{ Form::label('blank_report_type_cbpi', 'Select Type of Blank Report') }}<br/>
									<label class="checkbox-inline">
										<input type="radio" name="blank_report_type_cbpi" value="qr" id="report_qr" class="blank_report_type_cbpi"  required> QR
									</label>
									<label class="checkbox-inline">
										<input type="radio" name="blank_report_type_cbpi" value="dr" id="report_dr" class="blank_report_type_cbpi"  required> DR
									</label>
									<label class="checkbox-inline">
										<input type="radio" name="blank_report_type_cbpi" value="qr_dr" id="report_qr_dr" class="blank_report_type_cbpi"  required> BOTH
									</label>
								
								</div>
							</div>
				</div>
			</div> --}}
		@endif
		@if($inspection_details->project_type=="app_project")
			@if($inspection_details->service=="site_visit")
			@else
				<div class="col-md-4" id="div_template_cbpi">
					<div class="form-group">
						{!! Form::label('template', 'Select Template') !!}
						<select class="form-control" name="loading_template" id="loading_template" required>
							<option value="">Select Template</option>
							@foreach($templates as $template)
								@if($inspection_details->template_id==$template->id)
									<option value="{{$template->id}}" selected>{{$template->name}}</option>
								@else
									<option value="{{$template->id}}">{{$template->name}}</option>
								@endif
							@endforeach
						</select>
					</div>
				</div>
			@endif
		@else
			@if($inspection_details->service=="site_visit")
			@else
				<div class="col-md-4" id="div_template_cbpi" style="display:none;">
					<div class="form-group">
						{!! Form::label('loading_template', 'Select Template') !!}
						<select class="form-control" name="loading_template" id="loading_template" required>
							<option value="" selected>Select Template</option>
							@foreach($templates as $template)
								<option value="{{$template->id}}">{{$template->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			@endif
		@endif


<div class="col-md-offset-9 col-md-3">
	<input type="hidden" name="loading_report_template" id="loading_report_template">
	{!! Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-cbpi-edit-draft','type'=>'button']) !!}
	{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block btn-cbpi-edit-submit','style'=>'margin-top: 5px;','type'=>'button', 'id'=>'CBPI_submit']) !!}	
	<input type="hidden" name="edit_inspection_id_cbpi" id="edit_inspection_id_cbpi" value="{{$inspection_details->inspec_id}}">
	<input type="hidden" name="client_cost_id" id="client_cost_id" value="{{$client_cost->id}}">
	<input type="hidden" name="inspector_cost_id" id="inspector_cost_id" value="{{$inspector_cost->id}}">
</div>

<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
      </script>

<script>
	jQuery(document).ready(function(){

	jQuery('#loading_client').on('change', function() {
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
	  
	  jQuery('#CBPI_submit').click(function(e){
			var cbpi_req=$('.cli_required');
			var count_null=0;
			for(var i = 0; i < cbpi_req.length; i++){
            var data=$(cbpi_req[i]).val();
            if(data==""){
			  $(cbpi_req[i]).css("border","1px solid red");
			  count_null+=1;
            }else{
              $(cbpi_req[i]).removeAttr("style");
            }
		  }

		  if(count_null==0 && !$("input[name='project_type_cbpi']:checked").val()){	
			alert("Please choose type of project");		  
		  }else if(count_null==1 && !$("input[name='project_type_cbpi']:checked").val()){
			alert("Please choose type of project");	
		  }else if(count_null>0){
			alert("Please fill up the required fields");
		  }else{

		  }
		});

	  /* jQuery('#btn-cbpi-edit-draft').click(function(e){
		  alert("test");
			
			var cbpi_draft_req=$('.cli_draft_required');
			var cbpi_req=$('.cli_required');
			var count_draft_null=0;
			for(var i = 0; i < cbpi_req.length; i++){
              	$(cbpi_req[i]).removeAttr("style");
			}
			for(var i = 0; i < cbpi_draft_req.length; i++){
            var data=$(cbpi_draft_req[i]).val();
            if(data==""){
			  $(cbpi_draft_req[i]).css("border","1px solid red");
			  count_draft_null+=1;
            }else{
              $(cbpi_draft_req[i]).removeAttr("style");
            }
		  }
		  if(count_draft_null==0){
			updateDraftCbpi();
		  }else{
			  alert("Please fill up the required fields");
		  }
			  
		}); */
	});
		
		function updateDraftCbpi(){
			var edit_inspection_id_cbpi = $("#edit_inspection_id_cbpi").val();
        var loading_service = $("#loading_service_inspection").val();
        var loading_reference_number = $("#loading_reference_number").val();
        var loading_inspection_date = $("#loading_inspection_date").val();
        var loading_client = $('#loading_client').val();
        var loading_contact_person = $('#loading_contact_person').val();

        var loading_inspector = $('#loading_inspector').val();
        var loading_factory = $('#loading_factory').val();
        var loading_factory_contact_person = $('#loading_factory_contact_person').val();
        var loading_client_name = $('#loading_client_name').val();
        var loading_supplier_name = $('#loading_supplier_name').val();
        var memo = $('#memo_cbpi').val();
        var loading_requirements = $('#loading_requirements').val();
        var loading_template = $('#loading_template').val();
        var client_project_number_cbpi = $('#client_project_number_cbpi').val();
        var factory_contact_person2_cbpi = $('#factory_contact_person2_cbpi').val();
        if (loading_template == "") { loading_template = 0; }

        var type_of_project = $('input[name=project_type_cbpi]:checked').val();
        var blank_report_type = $('input[name=blank_report_type_cbpi]:checked').val();
        var word_template = $('#word_template_cbpi').val();
        if (type_of_project == "") { type_of_project = "N/A"; }
        if (blank_report_type == "") { blank_report_type = "N/A"; }
        if (word_template == "") { word_template = "N/A"; }

        var new_contact_person = null;
        var added_contact_person = jQuery('.added_contact_persons');
        if (added_contact_person.length > 0) {
            for (var i = 0; i < added_contact_person.length; i++) {
                var data = $(added_contact_person[i]).val();
                if (i == 0) {
                    new_contact_person = data;
                } else {
                    new_contact_person = new_contact_person + ',' + data;
                }
            }
        }


        if (new_contact_person == "" || new_contact_person == null) {
            new_contact_person = $('#loading_contact_person').val();
        } else {
            new_contact_person = new_contact_person + ',' + $('#loading_contact_person').val();
        }
        var contact_person = new_contact_person;


        $.ajax({
            url: '/editcbpidraft',
            type: 'POST',
            data: {
                _token: token,
                edit_inspection_id_cbpi: edit_inspection_id_cbpi,
                loading_service: loading_service,
                loading_reference_number: loading_reference_number,
                loading_inspection_date: loading_inspection_date,
                loading_client: loading_client,
                loading_contact_person: loading_contact_person,
                loading_inspector: loading_inspector,
                loading_factory: loading_factory,
                loading_factory_contact_person: loading_factory_contact_person,
                loading_requirements: loading_requirements,
                memo: memo,
                loading_template: loading_template,
                client_project_number_cbpi: client_project_number_cbpi,
                factory_contact_person2_cbpi: factory_contact_person2_cbpi,
                type_of_project: type_of_project,
                word_template: word_template,
                blank_report_type: blank_report_type,
                contact_person: contact_person,
                loading_supplier_name: loading_supplier_name

            },
            beforeSend: function() {
                $('.send-loading ').show();
            },
            success: function(response) {
                $('.send-loading ').hide();
                alert("Draft successfully saved");
                location.reload();

            },
            error: function(error) {
                console.log(error);
            }
        });
		}
		
	  </script>


{!!Form::close()!!}

