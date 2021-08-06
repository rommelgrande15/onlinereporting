{!!Form::open(['id'=>'new_inspection_form_site','data-parsley-validate'=>'', 'route'=>'saveinspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
	<div class="row">			
		<div class="col-md-12">
			<h4 class="heading">Inspection Details</h4>
			<hr>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('site_service_inspection', 'Service') !!}
			    {!! Form::select('site_service_inspection', [
			    	'iqi' => 'Incoming Quality Inspection',
			    	'dupro' => 'During Production Inspection',
			    	'psi' => 'Pre Shipment Inspection',
			    	'cli' => 'Container Loading Inspection',
			    	'pls' => 'Setting up Production Lines',
			    	'cbpi' => 'CBPI - No Serial',
			    	'cbpi_serial' => 'CBPI - with Serial',
					'cbpi_isce' => 'CBPI - ISCE',
					'site_visit' => 'Site Visit',
					'SPK' => 'SPK',
					'FRI' => 'FRI',
			    ], null, ['class' => 'form-control service site_required site_draft_required', 'placeholder'=>'Select a Service']) !!}
		  </div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_reference_number', 'Reference / Report Number') !!}
				{!! Form::text('site_reference_number', $ref_num, ['class' => 'form-control reference_number site_required site_draft_required','readOnly'=>true]) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_project_number', 'Client Project Number') !!}
				{!! Form::text('site_project_number', null, ['class' => 'form-control  client_project_number site_required site_draft_required']) !!}
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<button style="margin-left:20px;" class="btn btn-success btn-contact-person" type="button"><i class="fa fa-cog"></i> Contact Persons</button>
				</div>
			</div>
		</div>
		<div class="contact-select">			
			<div class="clone-inputs-contact-person">
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('site_contact_person', 'Contact Person') !!}
						<select class="form-control site_required contact_persons site_draft_required" id="site_contact_person"  name="site_contact_person">
							<option value="" selected>Select Contact</option>
							@foreach($client_contact as $contact)
								<option value="{{$contact->id}}">{{$contact->contact_person}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    {!! Form::label('site_contact_number', 'Contact Telephone Number') !!}
					    {!! Form::text('site_contact_number', null, ['class' => 'form-control site_required numeric contact_number site_draft_required']) !!}
				  	</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    {!! Form::label('site_loading_email', 'Email Address') !!}
					    {!! Form::text('site_loading_email', null, ['class' => 'form-control site_required contact_email site_draft_required']) !!}
				  	</div>
				</div>
				<div id="add_more_contact_container"></div>
				<div class="col-md-12 show_client_c_p" style="display:none;" id="show_client_c_p">
					<div class="form-group">
						<button class="btn btn-success" type="button" id="add_more_client_c_p_site" >
							<i class="fa fa-plus"></i> Add More Contact Person
						</button>
					</div>
				</div>
			</div>	
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('site_inspection_date', 'Inspection Date From') !!}
					{!! Form::text('site_inspection_date', null, ['class' => 'form-control site_required inspection_date site_draft_required']) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('site_inspection_date_to', 'Inspection Date To') !!}
					{!! Form::text('site_inspection_date_to', null, ['class' => 'form-control site_required inspection_date site_draft_required']) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('site_manday', 'Manday') !!}
					{!! Form::text('site_manday', 1, ['class' => 'form-control  manday site_required site_draft_required']) !!}
				</div>
			</div>
		</div>
	</div>
	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Company Details</h4>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_company_name', 'Company Name') !!}
				{!! Form::text('site_company_name', null, ['class' => 'form-control site_company_name site_required','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_company_addr', 'Company Address') !!}
				{!! Form::text('site_company_addr', null, ['class' => 'form-control site_company_addr site_required','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_company_other_info', 'Other Information') !!}
				{!! Form::text('site_company_other_info', null, ['class' => 'form-control site_company_other_info site_required','required'=>'']) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('site_requirements', 'Requirements') !!}
				{!! Form::textarea('site_requirements', null, ['class' => 'form-control site_required requirement','rows'=>'4']) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('site_memo', 'Memo / Notes') !!}
				{!! Form::textarea('site_memo', null, ['class' => 'form-control site_required memo_psi','rows'=>'4']) !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<label>Blank reports, TIC anti-bribery declaration,Onsite quick report, TIC Inspection rules, TIC Inspection criteria-General Merchandise, Product photos and other attachment</label>
			<div class="col-md-12 dropzone-container file_upload_site" id="file_upload_container_site">
				<div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
					<div class="fallback">
						<input name="file[]" class="site_required joe file" type="file" id="file" multiple required />
					</div>
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-offset-9 col-md-3">
			<br/>
			<input type="hidden" id="site_client" value="{{$client_code}}">
			{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block','id'=>'btn-site-submit','type'=>'button']) !!}
		</div>
	</div>
{!!Form::close()!!}
