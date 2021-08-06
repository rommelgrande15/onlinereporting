{!!Form::open(['enctype'=>'multipart/form-data','id'=>'new_loading_form','data-parsley-validate'=>'', 'route'=>'savesitevisitinspection','class'=>'form-inspection'])!!}
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
		    ], null, ['class' => 'form-control service site_required site_draft_required', 'placeholder'=>'Select a Service', 'id'=>'site_service_inspection']) !!}
	  	</div>
	</div>

	
	<div class="contact-select">
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('client', 'Select Client') !!}
			    <select class="form-control client_select site_required site_draft_required" id="site_client" name="site_client" required>
					<option value="" selected>Select Client</option>
					@foreach($clients as $client)
						@if($client->client_status!=2 || $client->client_status!='2')
							<option value="{{$client->client_code}}">{{$client->Company_Name}}</option>
						@endif
					@endforeach
				</select>
		  	</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_reference_number', 'Reference / Report Number') !!}
				{!! Form::text('site_reference_number', null, ['class' => 'site_required form-control site_draft_required', 'id'=>'site_reference_number']) !!}
			  </div>
		</div>


		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person', 'Contact Person') !!}
				<select class="form-control contact_persons site_required site_draft_required" id="site_contact_person" name="site_contact_person">
					<option value="" selected>Select Contact</option>
				</select>
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
			    {!! Form::text('contact_person_number', null, ['class' => 'site_required form-control numeric contact_number site_draft_required','id'=>'site_contact_number','readOnly'=>true]) !!}
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_email', 'Email Address') !!}
			    {!! Form::text('contact_person_email', null, ['class' => 'site_required form-control contact_email site_draft_required','id'=>'site_loading_email','readOnly'=>true]) !!}
		  	</div>
		</div>

		<div id="add_more_contact_container_site">
		</div>
	
		<div class="col-md-12 show_client_c_p_site" style="display:none;" id="show_client_c_p_site">
			<div class="form-group">
				<button class="btn btn-success" type="button" id="add_more_client_c_p_site" >
					<i class="fa fa-plus"></i> Add More Contact Person
				</button>
			</div>
		</div>
	</div>
	

	<div class="col-md-6">
		<div class="form-group">
			{!! Form::label('client_project_number_site', 'Client Project Number') !!}
			{!! Form::text('client_project_number_site', null, ['class' => 'form-control site_required site_draft_required','id'=>'client_project_number_site']) !!}
		  </div>
	</div>


	<div class="col-md-6">
		<div class="form-group">
		    {!! Form::label('site_inspection_date', 'Inspection Date') !!}
		    {!! Form::text('site_inspection_date', null, ['class' => 'form-control site_required inspection_date site_draft_required', 'id'=>'site_inspection_date']) !!}
	  	</div>
	</div>
	
	<div class="contact-select">
		<div class="site-clone-inspector-container">
			<div class="site-clone-inspector">
      			<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('site_inspector', 'Assign Inspector') !!}
					   	<select class="form-control select_address site_required site_draft_required sel-inspector" name="site_inspector" id="site_inspector" required>
							<option value="" >Select an Inspector</option>
							@foreach($inspectors_two as $inspectors)
								<option value="{{$inspectors->user_id}}">{{$inspectors->name}}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
							@endforeach
						</select>
	  				</div>
				</div>
      			<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('site_inspector_address', 'Inspector Address') !!}
					    {!! Form::text('site_inspector_address', null, ['class' => 'form-control  inspector_address_2 site_required site_draft_required insp-addr','required'=>'','id'=>'site_inspector_address','readOnly'=>'true']) !!}
				  	</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<button type="button" class="btn btn-success pull-left" id="site_add_inspector">
			<i class="fa fa-plus"></i> Add Other Inspector
		</button>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_manday', 'Manday') !!}
			{!! Form::text('site_manday', 1, ['class' => 'form-control  site_manday','required'=>'','readOnly'=>'true']) !!}
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
			{!! Form::text('site_company_name', null, ['class' => 'form-control site_company_name','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_company_addr', 'Company Address') !!}
			{!! Form::text('site_company_addr', null, ['class' => 'form-control site_company_addr','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_company_other_info', 'Other Information') !!}
			{!! Form::text('site_company_other_info', null, ['class' => 'form-control site_company_other_info','required'=>'']) !!}
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
			<select class="form-control site_ins_currency" name="site_ins_currency" id="site_ins_currency" required>
				<option value="" selected>Select Currency</option>
				<option value="usd">($) Us Dollar</option>
				<option value="eur">(€) Euro</option>
				<option value="gbp">(£) British Pound</option>
				<option value="inr">(₹) Indian Rupee</option>
				<option value="myr">(RM) Malaysian Ringgit</option>
				<option value="cny">(¥) Chinese Yuan Renminbi</option>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_ins_md_charge', 'MD Charges') !!}
			{!! Form::number('site_ins_md_charge', null, ['class' => 'form-control site_ins_md_charge','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_ins_travel_cost', 'Travel Cost') !!}
			{!! Form::number('site_ins_travel_cost', null, ['class' => 'form-control site_ins_travel_cost','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_ins_hotel_cost', 'Hotel Cost') !!}
			{!! Form::number('site_ins_hotel_cost', null, ['class' => 'form-control site_ins_hotel_cost','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_ins_ot_cost', 'OT Cost') !!}
			{!! Form::number('site_ins_ot_cost', null, ['class' => 'form-control site_ins_ot_cost','required'=>'']) !!}
		</div>
	</div>
	<div class="site_ins_other_cost_container">

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
				<option value="" selected>Select Currency</option>
				<option value="usd">($) Us Dollar</option>
				<option value="eur">(€) Euro</option>
				<option value="gbp">(£) British Pound</option>
				<option value="inr">(₹) Indian Rupee</option>
				<option value="myr">(RM) Malaysian Ringgit</option>
				<option value="cny">(¥) Chinese Yuan Renminbi</option>
			</select>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_cli_md_charge', 'MD Charges') !!}
			{!! Form::number('site_cli_md_charge', null, ['class' => 'form-control site_cli_md_charge','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_cli_travel_cost', 'Travel Cost') !!}
			{!! Form::number('site_cli_travel_cost', null, ['class' => 'form-control site_cli_travel_cost','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_cli_hotel_cost', 'Hotel Cost') !!}
			{!! Form::number('site_cli_hotel_cost', null, ['class' => 'form-control site_cli_hotel_cost','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_cli_ot_cost', 'OT Cost') !!}
			{!! Form::number('site_cli_ot_cost', null, ['class' => 'form-control site_cli_ot_cost','required'=>'']) !!}
		</div>
	</div>
	<div class="site_cli_other_cost_container">
	</div>
	<div class="col-md-12">
		<button type="button" class="btn btn-success pull-left" id="site_add_cli_other_cost">
			<i class="fa fa-plus"></i> Add Other Cost
		</button>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		    {!! Form::label('site_requirements', 'Requirements') !!}
		    {!! Form::textarea('site_requirements', null, ['class' => 'site_required form-control','rows'=>'7','id'=>'site_requirements']) !!}
	  	</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			{!! Form::label('site_memo', 'Memo / Notes') !!}
			{!! Form::textarea('site_memo', null, ['class' => 'form-control site_required site_memo','rows'=>'4']) !!}
		</div>
	</div>
</div>

<div class="row">
	 {!! Form::label('requirement', 'Blank reports, TIC anti-bribery declaration,Onsite quick report, TIC Inspection rules, TIC Inspection criteria-General Merchandise, Product photos and other attachment') !!}
	<div class="col-md-12 dropzone-container site_file_upload" id="file_upload_container">

	      <div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
	      <div class="fallback">
	          <input name="file[]" class="site_required" type="file" id="file" multiple required />
	      </div>
	</div>
</div>



<div class="col-md-12">

	<div class="row">
			<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('template', 'Select Type of Project') !!}<br/>
						<label class="checkbox-inline">
							<input type="radio" name="project_type_site" value="null" id="app_project_site" class="site_required" onclick="changeProjectTypeSite('app')"> APP Project
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="project_type_site" value="null" id="word_project_site" class="site_required" onclick="changeProjectTypeSite('word')"> WORD Project
						</label>

					</div>
				</div>
	</div>
</div>


<div class="row" id="div_template_site" style="display:none;">
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_template', 'Select App Template') !!}
			<select class="form-control site_required" name="site_template" id="site_template" required>
				<option value="" selected>Select Template</option>
				@foreach($templates as $template)
					<option value="{{$template->id}}">{{$template->name}}</option>
				@endforeach
			</select>
		</div>
	</div> 
	<input type="hidden" name="site_report_template" id="site_report_template">
</div>


<div class="col-md-offset-9 col-md-3">
	{!! Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-site-submit-draft','type'=>'button']) !!}
	{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block','style'=>'margin-top: 5px;','type'=>'button', 'id'=>'site_submit']) !!}	
</div>

{!!Form::close()!!}

<script>
	$('#site_client').on('change', function() {
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
							   $('#site_reference_number').val(set_pn);			
			  }
		  });
	  
		  }else{
			  $('#site_reference_number').val("");
		  }
		  
	  });

	  </script>

