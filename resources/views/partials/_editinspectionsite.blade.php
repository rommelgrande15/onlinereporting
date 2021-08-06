{!!Form::open(['id'=>'new_inspection_form','data-parsley-validate'=>'', 'route'=>'edited-draft-inspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
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
            	'physical' => 'Factory Audit',
				'detail' => 'Detail Audit',
				'social' => 'Social Audit'
				], $inspection_details->service, ['class' => 'form-control service site_required site_draft_required', 'placeholder'=>'Select a Service', 'disabled'=>'']) !!}
	  	</div>
	</div>
	
	<div class="contact-select">
	<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('client', 'Select Client') !!}
				
					@if($inspection_details->client_book=='true')
						<select class="form-control site_required client client_select site_draft_required" id="site_client" name="site_client" required disabled>.
					@else
						<select class="form-control site_required client client_select site_draft_required" id="site_client" name="site_client" required>.
					@endif
					<option value="" >Select Client</option>
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
					<label>Reference / Report Number</label>
					<input type="text" name="site_reference_number" id="site_reference_number" class="form-control reference_number site_required site_draft_required" value="{{$inspection_details->reference_number}}" required readOnly>
				</div>
		</div>
		
		<div class="clone-inputs-contact-person">
			@foreach($contact_person_list as $index=>$contact) 
				@if ($index==0)
					<div class="col-md-4">
						<div class="form-group">
							{!! Form::label('site_contact_person', 'Contact Person ') !!}
							<select class="form-control site_required contact_persons site_draft_required" id="site_contact_person"  name="site_contact_person">

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
								{!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
								@foreach($client_contacts as $cc) 
								@if($cc->id==$contact)
									{!! Form::text('contact_person_number', $cc->contact_number, ['class' => 'form-control site_required numeric contact_number site_draft_required',			'required'=>'','id'=>'contact_number']) !!}
								@endif
								@endforeach
						
					  	</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							{!! Form::label('site_contact_person_email', 'Email Address') !!}

								@foreach($client_contacts as $cc) 
								@if($cc->id==$contact)
									{!! Form::text('site_contact_person_email', $cc->email_address, ['class' => 'form-control site_required contact_email site_draft_required']) !!}
								@endif
								@endforeach
						  </div>
					</div>
		@else
		<div class="am_cp_parent">
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('site_contact_person', 'Contact Person ') !!}
					<select class="form-control site_required  added_contact_persons_site site_draft_required" id="site_contact_person"  name="site_contact_person">
						
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
						{!! Form::label('site_contact_person_number', 'Contact Number') !!}
						@foreach($client_contacts as $cc) 
						@if($cc->id==$contact)
							{!! Form::text('site_contact_person_number', $cc->contact_number, ['class' => 'form-control site_required numeric contact_number site_draft_required','required'=>'']) !!}
						@endif
						@endforeach
				  
				  </div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label>Email Address</label>
					<div class="input-group">
						<input type="text" class= "form-control site_required numeric am_contact_email site_draft_required" value="{{$cc->email_address}}" required>
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
	
		<div id="add_more_contact_container_site">
		</div>

			<div class="col-md-12 show_client_c_p" id="show_client_c_p">
				<div class="form-group">
					<button class="btn btn-success" type="button" id="add_more_client_c_p_site" >
						<i class="fa fa-plus"></i> Add More Contact Person
					</button>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label>Client Project Number</label>
					<input type="text" name="client_project_number_site" id="client_project_number_site" class="form-control client_project_number site_required site_draft_required" value="{{$inspection_details->client_project_number}}" required>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Inspection Date From</label>
					<input type="text" name="site_inspection_date" id="site_inspection_date" class="form-control inspection_date site_required site_draft_required" value="{{$inspection_details->inspection_date}}" required>
			  	</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Inspection Date To</label>
					<input type="text" name="site_inspection_date_to" id="site_inspection_date_to" class="form-control inspection_date site_required site_draft_required" value="{{$inspection_details->inspection_date_to}}" required>
			  	</div>
			</div>
		</div>

		<div class="clone-inspector-container-site">
			<div class="clone-inspector-site">
				<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('site_inspector', 'Assign Inspector') !!}
					   {{--  {!! Form::select('site_inspector', $inspectors, $inspection_details->inspector_id, ['class' => 'form-control site_required select_address site_draft_required sel-inspector','placeholder'=>'Select an Inspector','required'=>'']) !!} --}}
					   <select class="form-control site_required select_address site_draft_required sel-inspector" name="site_inspector" id="site_inspector" required>
							<option value="" >Select an Inspector</option>
							@foreach($inspector_list as $inspectors)
								@if($inspection_details->inspector_id==0)
									<option value="{{$inspectors->user_id}}">{{$inspectors->name}}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
								@else	
									@if($inspectors->user_id==$inspection_details->inspector_id)
										<option value="{{$inspectors->user_id}}" selected>{{$inspectors->name}}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
									@else
										<option value="{{$inspectors->user_id}}">{{$inspectors->name}}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
									@endif
								@endif			
							@endforeach
						</select>
				  	</div>
				</div>
    			<div class="col-md-6">
					<div class="form-group">
							<label>Inspector Address</label>
							<input type="text" name="inspector_address" id="inspector_address" class="form-control inspector_address site_required site_draft_required insp-addr" value="{{$inspector_info->address}}" required >
				  	</div>
				</div>
			</div>
			@foreach($other_inspector as $other)
				@if($other=='null' || $other==null)
				
				@else
					<div class="clone-inspector-site">
						<div class="col-md-6">
							<div class="form-group">
							    {!! Form::label('inspector_sec', 'Assign Inspector') !!}
								<select id="inspector_sec" name="inspector_sec" class="form-control site_required site_draft_required sel-inspector sel-added-inspector">
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
									<input type="text" name="inspector_address" id="inspector_address" class="form-control site_required site_draft_required added-inspector-address" value="{{$inspector_info->address}}" required >
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
	<div class="site_inspector_container"></div>
	<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="site_add_inspector">
				<i class="fa fa-plus"></i> Add Other Inspector
			</button>
		</div>

		<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('site_manday', 'Manday') !!}
					{!! Form::text('site_manday', $inspection_details->manday, ['class' => 'form-control  manday site_required site_draft_required']) !!}
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
			{!! Form::text('site_company_name', $inspection_details->com_name, ['class' => 'form-control site_company_name','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_company_addr', 'Company Address') !!}
			{!! Form::text('site_company_addr', $inspection_details->comp_addr, ['class' => 'form-control site_company_addr','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_company_other_info', 'Other Information') !!}
			{!! Form::text('site_company_other_info', $inspection_details->comp_other_info, ['class' => 'form-control site_company_other_info','required'=>'']) !!}
		</div>
	</div>
</div>

	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Inspector Cost ($)</h4>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_ins_currency', 'Currency') !!}
				<select class="form-control ins_currency" name="site_ins_currency" id="site_ins_currency" required>
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
				{!! Form::label('site_ins_md_charge', 'MD Charges') !!}
				{!! Form::number('site_ins_md_charge', $inspector_cost->md_charges, ['class' => 'form-control ins_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_ins_travel_cost', 'Travel Cost') !!}
				{!! Form::number('site_ins_travel_cost', $inspector_cost->travel_cost, ['class' => 'form-control ins_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_ins_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('site_ins_hotel_cost', $inspector_cost->hotel_cost, ['class' => 'form-control ins_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_ins_ot_cost', 'OT Cost') !!}
				{!! Form::number('site_ins_ot_cost', $inspector_cost->ot_cost, ['class' => 'form-control ins_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="site_ins_other_cost_container">
			@foreach($ins_other_cost_array as $key => $value)
				@if(count($ins_other_cost_array)>1)
					<div class="ins_cost_div">
						<div class="col-md-6">
							<div class="form-group">
								<label>Other Cost Description</label>
							<input type="text" class="form-control site_ins_other_cost_text site_required" placeholder="Enter description cost here" value="{{$key}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cost</label>
								<div class="input-group">
									<input type="number" class="form-control site_ins_other_cost_value site_required" value="{{$value}}">
									<div class="input-group-btn">
										<button class="btn btn-danger site_del_added_insp_cost" type="button">
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
			<button type="button" class="btn btn-success pull-left" id="site_add_insp_other_cost">
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
				{!! Form::label('site_cli_currency', 'Currency') !!}
				<select class="form-control site_cli_currency" name="site_cli_currency" id="site_cli_currency" required>

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
				{!! Form::label('site_cli_md_charge', 'MD Charges') !!}
				{!! Form::number('site_cli_md_charge', $client_cost->md_charges, ['class' => 'form-control site_cli_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_cli_travel_cost', 'Travel Cost') !!}
				{!! Form::number('site_cli_travel_cost', $client_cost->travel_cost, ['class' => 'form-control site_cli_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_cli_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('site_cli_hotel_cost',  $client_cost->hotel_cost, ['class' => 'form-control site_cli_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_cli_ot_cost', 'OT Cost') !!}
				{!! Form::number('site_cli_ot_cost', $client_cost->ot_cost, ['class' => 'form-control site_cli_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="site_cli_other_cost_container">
			@foreach($client_other_cost_array as $key => $value)
				@if(count($client_other_cost_array)>1)
					<div class="site_cli_cost_div">
						<div class="col-md-6">
							<div class="form-group">
								<label>Other Cost Description</label>
							<input type="text" class="form-control site_cli_other_cost_text site_required" placeholder="Enter description cost here" value="{{$key}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cost</label>
								<div class="input-group">
									<input type="number" class="form-control site_cli_other_cost_value site_required" value="{{$value}}">
									<div class="input-group-btn">
										<button class="btn btn-danger site_del_added_cli_cost" type="button">
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
			<button type="button" class="btn btn-success pull-left" id="site_add_cli_other_cost">
				<i class="fa fa-plus"></i> Add Other Cost
			</button>
		</div>
	</div>
	<br>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('site_requirements', 'Requirements') !!}
				{!! Form::textarea('site_requirements', $inspection_details->requirement, ['class' => 'form-control site_required requirement','rows'=>'4']) !!}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('site_memo', 'Memo / Notes') !!}
				{!! Form::textarea('site_memo', $inspection_details->memo, ['class' => 'form-control site_required site_memo','rows'=>'4']) !!}
			</div>
		</div>
	</div>


	<div class="row">
	<div class="col-md-12">
			<label>Blank reports and other attachment</label>
			<div class="col-md-12 dropzone-container file_upload_site" id="file_upload_container_site">
						<div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
						<div class="fallback">
								<input name="file[]" class="site_required joe file" type="file" id="file" multiple required />
						</div>
	
			</div>
		</div>
	</div>	


	<div class="col-md-12">

		<div class="row">
				<div class="col-md-12">
						<div class="form-group">
							{!! Form::label('template', 'Select Type of Project') !!}<br/>
							<label class="checkbox-inline">
								@if($inspection_details->project_type=="app_project")
									<input type="radio" name="project_type_site" value="app_project" id="app_project_site" class="site_required" onclick="changeProjectTypeSite('app')" required checked> APP Project
								@else
									<input type="radio" name="project_type_site" value="null" id="app_project_site" class="" onclick="changeProjectTypeSite('app')" required> APP Project
								@endif
								
							</label>
							<label class="checkbox-inline">
								@if($inspection_details->project_type=="word_project")
								<input type="radio" name="project_type_site" value="word_project" id="word_project_site" class="site_required" onclick="changeProjectTypeSite('word')" required checked> WORD Project
								@else
									<input type="radio" name="project_type_site" value="null" id="word_project_site" class="" onclick="changeProjectTypeSite('word')" required> WORD Project
								@endif
								
							</label>


						</div>
					</div>
		</div>
	</div>



	@if($inspection_details->project_type=="app_project")
		<div class="row" id="div_template_site">
			<div class="col-md-4" >
				<div class="form-group">
					{!! Form::label('site_template', 'Select App Template') !!}
					<select class="form-control site_required" name="site_template" id="site_template" required>
						<option value="">Select App Template</option>
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

			{{-- <div class="col-md-4">
				<div class="form-group">
					{!! Form::label('site_same_report', 'Select Docs Report') !!}<br/>
					@if($inspection_details->word_template=="")
						<label class="checkbox-inline">
							<input type="radio" name="same_report" value="" id="site_same_report" class="" required onclick="chooseEngReportSite('same_report')" checked> Same Report
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="same_report" value="" id="site_other_report" class="" required onclick="chooseEngReportSite('other_report')"> Other Report 	Language
						</label>
					@else
						<label class="checkbox-inline">
							<input type="radio" name="same_report" value="" id="site_same_report" class="" required onclick="chooseEngReportSite('same_report')"> Same Report
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="same_report" value="" id="site_other_report" class="" required onclick="chooseEngReportSite('other_report')" checked> Other Report 		Language
						</label>
					@endif
				</div>
			</div> --}}
			@if($inspection_details->word_template=="")
				<div class="col-md-4" id="site_eng_rpt_temp" style="display:none;">
					<div class="form-group">
						{!! Form::label('site_report_template', 'Select Chinese Report') !!}
						<select class="form-control" name="site_report_template" id="site_report_template" required>
							<option value="" selected>Select Chinese Report Template</option>
							@foreach($templates_chinese as $template)
								<option value="{{$template->id}}">{{$template->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			@else
				<div class="col-md-4" id="site_eng_rpt_temp">
					<div class="form-group">
						{!! Form::label('site_report_template', 'Select Chinese Report') !!}
						<select class="form-control" name="site_report_template" id="site_report_template" required>
							<option value="" selected>Select Chinese Report Template</option>
							@foreach($templates_chinese as $template)
								<option value="{{$template->id}}">{{$template->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			@endif
		</div>	
	@else
	<div class="row" id="site_div_template" style="display:none">
		<div class="col-md-4" >
			<div class="form-group">
				{!! Form::label('site_template', 'Select Template') !!}
				<select class="form-control" name="site_template" id="site_template" required>
					<option value="">Select App Template</option>
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

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('same_report', 'Select Docs Report') !!}<br/>
				<label class="checkbox-inline">
					<input type="radio" name="same_report" value="" id="site_same_report" class="" required onclick="chooseEngReportSite('same_report')"> Same Report
				</label>
				<label class="checkbox-inline">
					<input type="radio" name="same_report" value="" id="site_other_report" class="" required onclick="chooseEngReportSite('other_report')"> Other Report Language
				</label>
			</div>
		</div>

		<div class="col-md-4" id="site_eng_rpt_temp" style="display:none;">
			<div class="form-group">
				{!! Form::label('site_report_template', 'Select Chinese Report') !!}
				<select class="form-control" name="site_report_template" id="site_report_template" required>
					<option value="" selected>Select Chinese Report Template</option>
					@foreach($templates_chinese as $template)
						<option value="{{$template->id}}">{{$template->name}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>	
	@endif






<div class="row">
<div class="col-md-offset-9 col-md-3">
	<br/>
		<?php
			$inspect_stat_lower=strtolower($inspection_details->inspection_status);
		?>
		@if($inspect_stat_lower=='pending')
			{!! Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-site-edit-draft','type'=>'button']) !!}
		@endif
		@if($inspect_stat_lower=='released')
			{!! Form::button('Save and Publish (No Email)', ['class' => 'btn btn-warning btn-block','id'=>'btn-site-submit-no-email','type'=>'button']) !!}
		@endif
		{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block','id'=>'btn-site-submit','type'=>'button']) !!}
		<input type="hidden" name="edit_inspection_id_site" id="edit_inspection_id_site" value="{{$inspection_details->inspec_id}}">
		<input type="hidden" name="client_cost_id" id="client_cost_id" value="{{$client_cost->id}}">
		<input type="hidden" name="inspector_cost_id" id="inspector_cost_id" value="{{$inspector_cost->id}}">
	</div>
</div>

<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script type="text/javascript">
    $(function() {
		$('#site_inspection_date').on('change', function() {
            var client_code = $('#site_client').val();
            var inspect_date_val = $('#site_inspection_date').val();
            if (client_code != "") {
                $.ajax({
                    type: "GET",
                    url: '/getclientcountinspection-new/' + client_code + '/' + inspect_date_val,
                    success: function(data) {
                        $('#site_reference_number').val(data.ref_num);
                    },
                    error: function(err){
                        console.log('Reference Number Error: ' + err);
                        $('#site_reference_number').val('');
                    }
                });
            }
		});
		
		$('#site_client').on('change', function() {
            var client_code = $('#site_client').val();
            var inspect_date_val = $('#site_inspection_date').val();
            if (inspect_date_val != "") {
                $.ajax({
                    type: "GET",
                    url: '/getclientcountinspection-new/' + client_code + '/' + inspect_date_val,
                    success: function(data) {
                        $('#site_reference_number').val(data.ref_num);
                    },
                    error: function(err){
                        console.log('Reference Number Error: ' + err);
                        $('#site_reference_number').val('');
                    }
                });
            }
        });

$('#client_old_function').on('change', function() {
  var client_code=this.value;
	if(client_code!=""){
		var d = new Date();
		//var date_now = d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear();
		var date_now = d.getFullYear()+''+(d.getMonth()+1);
		
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
					 	$('#reference_number').val(set_pn);			
        }
    });

	}else{
		$('#reference_number').val("");
	}
	
});


});

</script>


{!!Form::close()!!}
