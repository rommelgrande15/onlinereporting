{!!Form::open(['enctype'=>'multipart/form-data','id'=>'new_loading_form','data-parsley-validate'=>'', 'route'=>'supplier-client-savecbpiinspection','class'=>'form-inspection'])!!}
	<div class="row">
		<div class="col-md-12">
			<h4 class="heading">Inspection Details</h4>
            @foreach($clientName as $cname)
			    <h4 style="color:green;"><span class="pull-right">Client Name : {{ $cname->client_name }}</span></h4>
                <input type="hidden" id="loading_client" value="{{$cname->client_code}}">
				<input type="hidden" id="loading-supplier" name="loading-supplier" value="{{$supplierData->id}}">
			@endforeach
		</div>
		<div class="col-md-4">
			<div class="form-group" >
			    {!! Form::label('loading_service', 'Service') !!}
			    {!! Form::select('loading_service', [
			    	'iqi' => 'Incoming Quality Inspection',
			    	'dupro' => 'During Production Inspection',
			    	'psi' => 'Pre Shipment Inspection',
					'cli' => 'Container Loading Inspection',
					'cbpi' => 'CBPI',
				], null, ['class' => 'form-control service cli_required cli_draft_required', 'placeholder'=>'Select a Service']) !!}
				<br/><br/>
		  	</div>
		</div>
		<div class="contact-select">
			<input type="hidden" value="{{$ref_num}}" class="loading_reference_number" id="loading_reference_number">
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('client_project_number_cbpi', 'Order Number') !!}
					{!! Form::text('client_project_number_cbpi', null, ['class' => 'form-control cli_required cli_draft_required']) !!}
					<br/><br/>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('loading_inspection_date', 'Inspection Date') !!}
					{!! Form::text('loading_inspection_date', null, ['class' => 'form-control cli_required inspection_date cli_draft_required', 'id'=>'loading_inspection_date']) !!}
					{{-- <label title="Selecting this will not allow the factory to postpone or advance the inspection date">
							<input type="checkbox" id="loading_fac_change_date" name="loading_fac_change_date" value="no"> Do not allow factory to change this date.
					</label> --}}
					<br/><br/>
				</div>
			</div>
			{{-- <div class="col-md-4">
				<div class="form-group">
					{!! Form::label('cbpi_shipment_date', 'Shipment Date') !!}
					{!! Form::text('cbpi_shipment_date', null, ['class' => 'form-control cli_required inspection_date cli_draft_required']) !!}
					<br/><br/><br/>
				</div>
			</div> --}}
			<div class="col-md-4">
				<div class="form-group">
				    {!! Form::label('contact_person', 'Client Contact Person') !!}
					{{-- <select class="form-control contact_persons cli_required cli_draft_required" id="loading_contact_person" name="loading_contact_person">
						<option value="" selected>Select Contact</option>
						@foreach($supplierContactNew as $contact)
							<option value="{{$contact->id}}">{{$contact->contact_person}}</option>
						@endforeach
					</select> --}}
					@if($supplierClientContact)
					{!! Form::text('contact_person',  $supplierClientContact->contact_person , ['class' => 'form-control contact_persons cli_required cli_draft_required','required'=>'','id'=>'loading_contact_person','readOnly'=>'true']) !!}
					@else
					{!! Form::text('contact_person',  'Please ask client to add client contact person for you.' , ['class' => 'form-control contact_persons cli_required cli_draft_required','required'=>'','id'=>'loading_contact_person','readOnly'=>'true','style' =>'color:red;']) !!}
					@endif
			  	</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				    {!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
					@if($supplierClientContact)
				    {!! Form::text('contact_person_number', $supplierClientContact->tel_number, ['class' => 'cli_required form-control numeric contact_number cli_draft_required','id'=>'loading_contact_number','readOnly'=>true]) !!}
					@else
					{!! Form::text('contact_person_number', null, ['class' => 'cli_required form-control numeric contact_number cli_draft_required','id'=>'loading_contact_number','readOnly'=>true]) !!}
					@endif
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				    {!! Form::label('contact_person_email', 'Email Address') !!}
					@if($supplierClientContact)
				    {!! Form::text('contact_person_email', $supplierClientContact->email_address, ['class' => 'cli_required form-control contact_email cli_draft_required','id'=>'loading_email','readOnly'=>true]) !!}
					@else
					{!! Form::text('contact_person_email', null, ['class' => 'cli_required form-control contact_email cli_draft_required','id'=>'loading_email','readOnly'=>true]) !!}
					@endif
				</div>
			</div>
			<div id="add_more_contact_container_cbpi"></div>
			<div class="col-md-12 show_client_c_p" style="display:none;" id="show_client_c_p">
				<div class="form-group">
					<button class="btn btn-success" type="button" id="add_more_client_c_p_cbpi" >
						<i class="fa fa-plus"></i> Add More Contact Person
					</button>
				</div>
			</div>
			{{-- <div class="col-md-12">
				<div class="form-group">
					<button style="margin-left:20px;" class="btn btn-primary btn-contact-person-supplier pull-right" type="button"><i class="fa fa-list-alt"></i> List of Contact Persons</button>
				</div>
			</div> --}}
		</div>
		
		<input type="hidden" id="cbpi_manday" value="1">
	</div>
	<div class="row factory-select">
		<div class="col-md-12">
			<h4 class="heading">Factory & Supplier Details</h4>
		</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('loading_supplier_name', 'Supplier Name') !!}
					{!! Form::text('loading_supplier_name',  $supplierData->supplier_name , ['class' => 'form-control cli_required numeric loading_supplier_name cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				  </div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('loading_supplier_number', 'Supplier Code/Number') !!}
					{!! Form::text('loading_supplier_number',  $supplierData->supplier_code , ['class' => 'form-control cli_required numeric loading_supplier_number cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				  </div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('loading_supplier_address', 'Supplier Address') !!}
					{!! Form::text('loading_supplier_address',  $supplierData->supplier_address , ['class' => 'form-control cli_required numeric loading_supplier_address cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				  </div>
			</div>
	
		<div class="col-md-4">
			<div class="form-group">
				<label for="supplier_contact_person">Supplier Contact Person</label>
				{{-- <select class="form-control cli_required supplier_contact_person cli_required cli_draft_required" id="loading_supplier_contact_person" name="loading_supplier_contact_person" >
					<option value="" >Select Supplier Contact Person</option>
                    @foreach($supplierContact as $contact)
						<option value="{{$contact->id}}">{!!$contact->supplier_contact_person!!}</option>
					@endforeach
				</select> --}}
				@if($supplierContactName)
				{!! Form::text('supplier_contact_person',  $supplierContactName->supplier_contact_person , ['class' => 'form-control cli_required supplier_contact_person cli_required cli_draft_required','required'=>'','id'=>'loading_supplier_contact_person','readOnly'=>'true']) !!}
				@else
				{!! Form::text('supplier_contact_person',  'Please ask client to add supplier contact person for you.' , ['class' => 'form-control cli_required supplier_contact_person cli_required cli_draft_required','required'=>'','id'=>'loading_supplier_contact_person','readOnly'=>'true','style' =>'color:red;']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_contact_number', 'Contact Telephone Number (Supplier)') !!}
				@if($supplierContactName)
				{!! Form::text('supplier_contact_number', $supplierContactName->supplier_tel_number, ['class' => 'form-control cli_required numeric supplier_contact_number cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				@else
				{!! Form::text('supplier_contact_number', null, ['class' => 'form-control cli_required numeric supplier_contact_number cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_email', 'Email Address') !!}
				@if($supplierContactName)
				{!! Form::text('supplier_email', $supplierContactName->supplier_email, ['class' => 'form-control cli_required supplier_email cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				@else
				{!! Form::text('supplier_email', null, ['class' => 'form-control cli_required supplier_email cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				@endif
			</div>
		</div>
		<div id="cli_fac_toggle_div">
			<div class="col-md-12">
				<div class="form-group">
					<button style="margin-left:20px; display:none;" class="btn btn-primary l-btn-cli-factory pull-right" type="button" id="l-btn-add-factory"><i class="fa fa-plus"></i> Add New Factory</button>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('factory', 'Factory Name') !!}
					<select class="form-control factory cli_required cli_draft_required" name="loading_factory" id="loading_factory" required>
						<option value="" >Select Factory</option>
                        @foreach($suppFactory as $factory)
						    <option value="{{$factory->id}}">{!!$factory->factory_name!!}</option>
					    @endforeach
					</select>
				  </div>
			</div>
			<div class="col-md-8">
				<div class="form-group">
				    {!! Form::label('loading_factory_address', 'Factory Address') !!}
				    {!! Form::text('factory_address', null, ['class' => 'cli_required form-control factory_address cli_draft_required','id'=>'loading_factory_address','readOnly'=>'true']) !!}
			  	</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				    {!! Form::label('loading_factory_contact_person', 'Factory Contact Person') !!}
					<select class="cli_required form-control factory_contact_person cli_draft_required" name="loading_factory_contact_person" id="loading_factory_contact_person" required>
						<option value="" selected>Select Contact Person</option>
					</select>
			  	</div> 
			</div>
			<div class="col-md-4">
				<div class="form-group">
				    {!! Form::label('loading_factory_contact_number', 'Contact Telephone Number (Factory)') !!}
				    {!! Form::text('factory_contact_number', null, ['class' => 'cli_required form-control factory_contact_number numeric cli_draft_required','id'=>'loading_factory_contact_number','readOnly'=>'true']) !!}
			  	</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
				    {!! Form::label('loading_factory_email', 'Contact Email') !!}
				    {!! Form::text('factory_email', null, ['class' => 'cli_required form-control factory_email cli_draft_required','id'=>'loading_factory_email','readOnly'=>'true']) !!}
			  	</div>
			</div>
		</div>
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
		<div class="col-md-12 show_fac_c_p_cbpi" style="display:none;" id="show_fac_c_p_cbpi">
			<div class="form-group">
				<button class="btn btn-success" type="button" id="add_more_fac_c_p_cbpi" >
					<i class="fa fa-plus"></i> Add More Contact Person
				</button>
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
			    {!! Form::label('loading_requirements', 'Requirements') !!}
			    {!! Form::textarea('loading_requirements', null, ['class' => 'form-control','rows'=>'7','id'=>'loading_requirements']) !!}
		  	</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('memo_cbpi', 'Memo / Notes') !!}
				{!! Form::textarea('memo_cbpi', null, ['class' => 'form-control memo_cbpi','rows'=>'4']) !!}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('requirement','Product photos and other attachment') !!}
				<div class="dropzone-container file_upload" id="file_upload_container">
				      <div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
				      <div class="fallback">
				          <input name="file[]" class="cli_required" type="file" id="file" multiple required />
				      </div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-offset-10 col-md-2">
			<input type="hidden" id="loading_hidden_client_id" value="{{$client_id}}">
			<input type="hidden" id="loading_client" value="{{$client_code}}">

			@if($supplierClientContact)
			<input type="hidden" id="loading_client_cp" value="{{$supplierClientContact->id}}">
			@else
			<input type="hidden" id="loading_client_cp" value="">
			@endif

			@if($supplierContactName)
			<input type="hidden" id="loading_supplier_cp" value="{{$supplierContactName->id}}">
			@else
			<input type="hidden" id="loading_supplier_cp" value="">
			@endif
		
			@if($create_order=="" || $create_order=="yes")
				{!! Form::button('<i class="fa fa-paper-plane"></i> Submit', ['class' => 'btn btn-success btn-block','style'=>'margin-top: 5px;','type'=>'button', 'id'=>'CBPI_submit']) !!}	
			@else
				{!! Form::button('<i class="fa fa-paper-plane"></i> Submit', ['class' => 'btn btn-success btn-block disabled','style'=>'margin-top: 5px;','type'=>'button']) !!}
			@endif
		</div>
	</div>

{!!Form::close()!!}

