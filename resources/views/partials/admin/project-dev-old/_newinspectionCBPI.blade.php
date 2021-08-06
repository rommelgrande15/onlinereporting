{!!Form::open(['enctype'=>'multipart/form-data','id'=>'new_loading_form','data-parsley-validate'=>'', 'route'=>'savecbpiinspection','class'=>'form-inspection'])!!}
<div class="row">
	<div class="col-md-12">
		<h4 class="heading">Inspection Details</h4>
		<hr>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('loading_service', 'Service') !!}
		    {!! Form::select('loading_service', [
		    	'iqi' => 'Incoming Quality Inspection',
		    	'dupro' => 'During Production Inspection',
		    	'psi' => 'Pre Shipment Inspection',
		    	'cli' => 'Container Loading Inspection',
		    	'pls' => 'Setting up Production Lines',
				'st' => 'Sample Test',
		    	'cbpi' => 'CBPI',
				'site_visit' => 'Site Visit',
				'physical' => 'Factory Audit',
				'SPK' => 'SPK',
				'FRI' => 'FRI',
		    ], null, ['class' => 'form-control service cli_required cli_draft_required', 'placeholder'=>'Select a Service', 'id'=>'loading_service_inspection']) !!}
	  	</div>
	</div>

	<div class="contact-select">

		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('loading_client', 'Select Client') !!}
			    <select class="form-control client_select cli_required cli_draft_required select-clients" style="width:523.328px !important" id="loading_client" name="loading_client" required>
					<option value="" selected>Select Client</option>
					{{-- @foreach($clients as $client)
						@if($client->client_status!=2 || $client->client_status!='2')
							<option value="{{$client->client_code}}">{{$client->Company_Name}}</option>
						@endif
					@endforeach --}}
				</select>
				<div id='loading_clientResult'></div>
		  	</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('loading_reference_number', 'Reference / Report Number') !!}
				{!! Form::text('loading_reference_number', null, ['class' => 'cli_required form-control cli_draft_required', 'id'=>'loading_reference_number']) !!}
			  </div>
		</div>


		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person', 'Contact Person') !!}
				<select class="form-control contact_persons cli_required cli_draft_required" id="loading_contact_person" name="loading_contact_person">
					<option value="" selected>Select Contact</option>
				</select>
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
			    {!! Form::text('contact_person_number', null, ['class' => 'cli_required form-control numeric contact_number cli_draft_required','id'=>'loading_contact_number','readOnly'=>true]) !!}
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_email', 'Email Address') !!}
			    {!! Form::text('contact_person_email', null, ['class' => 'cli_required form-control contact_email cli_draft_required','id'=>'loading_email','readOnly'=>true]) !!}
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
	</div>
	

	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('client_project_number_cbpi', 'Client Project Number') !!}
			{!! Form::text('client_project_number_cbpi', null, ['class' => 'form-control cli_required cli_draft_required','id'=>'client_project_number_cbpi']) !!}
		  </div>
	</div>


	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('loading_inspection_date', 'Inspection Date From') !!}
		    {!! Form::text('loading_inspection_date', null, ['class' => 'form-control cli_required inspection_date cli_draft_required', 'id'=>'loading_inspection_date']) !!}
	  	</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('loading_inspection_date_to', 'Inspection Date To') !!}
		    {!! Form::text('loading_inspection_date_to', null, ['class' => 'form-control cli_required inspection_date cli_draft_required']) !!}
	  	</div>
	</div>
	
	{{-- <div class="contact-select"> --}}
		<div class="cbpi-clone-inspector-container">
			<div class="cbpi-clone-inspector">
      			<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('loading_inspector', 'Assign Inspector') !!}
					   {{--  {!! Form::select('loading_inspector', $inspectors, null, ['class' => 'cli_required form-control cli_draft_required','placeholder'=>'Select an Inspector','required'=>'','id'=>'loading_inspector']) !!} --}}
					   	<select class="form-control select_address cli_required cli_draft_required sel-inspector select-inspectors" name="loading_inspector" id="loading_inspector" required>
							<option value="" >Select an Inspector</option>
							{{-- @foreach($inspectors_two as $inspectors)
								<option value="{{$inspectors->user_id}}">{{$inspectors->name}}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
							@endforeach --}}
						</select>
						{{-- <div id='loading_InspectoResult'></div> --}}
	  				</div>
				</div>
      			<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('inspector_address', 'Inspector Address') !!}
					    {!! Form::text('inspector_address', null, ['class' => 'form-control  inspector_address_2 cli_required cli_draft_required insp-addr','required'=>'','id'=>'inspector_address_2','readOnly'=>'true']) !!}
				  	</div>
				</div>
			</div>
		</div>
	{{-- </div> --}}
	<div class="col-md-12">
		<button type="button" class="btn btn-success pull-left" id="cbpi_add_inspector">
			<i class="fa fa-plus"></i> Add Other Inspector
		</button>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_manday', 'Manday') !!}
			{!! Form::text('cbpi_manday', 1, ['class' => 'form-control  cbpi_manday','required'=>'']) !!}
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
			<select class="cli_required form-control factory cli_draft_required select-factories" name="loading_factory" id="loading_factory" required>
				<option value="" selected>Select Factory</option>
				{{-- @foreach($factories as $factory)
					<option value="{{$factory->id}}">{!!$factory->factory_name!!}</option>
				@endforeach --}}
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
	<div class="col-md-6">
		<div class="form-group">
		    {!! Form::label('loading_supplier_name', 'Supplier Name') !!}
		    {!! Form::text('loading_supplier_name', null, ['class' => 'cli_required form-control ', 'id'=>'loading_supplier_name']) !!}
	  	</div>
	</div>
</div>

<div class="row">		
	<div class="col-md-12">
		<h4 class="heading">Inspector Cost</h4>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_ins_currency', 'Currency') !!}
			<select class="form-control cbpi_ins_currency cli_required" name="cbpi_ins_currency" id="cbpi_ins_currency" required>
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
			{!! Form::label('cbpi_ins_md_charge', 'MD Charges') !!}
			{!! Form::number('cbpi_ins_md_charge', 0, ['class' => 'form-control cbpi_ins_md_charge cli_required','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_ins_travel_cost', 'Travel Cost') !!}
			{!! Form::number('cbpi_ins_travel_cost', 0, ['class' => 'form-control cbpi_ins_travel_cost cli_required','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_ins_hotel_cost', 'Hotel Cost') !!}
			{!! Form::number('cbpi_ins_hotel_cost', 0, ['class' => 'form-control cbpi_ins_hotel_cost cli_required','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_ins_ot_cost', 'OT Cost') !!}
			{!! Form::number('cbpi_ins_ot_cost', 0, ['class' => 'form-control cbpi_ins_ot_cost cli_required','required'=>'']) !!}
		</div>
	</div>
	<div class="cbpi_ins_other_cost_container">

	</div>
	<div class="col-md-12">
		<button type="button" class="btn btn-success pull-left" id="cbpi_add_insp_other_cost">
			<i class="fa fa-plus"></i> Add Other Cost
		</button>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_Inspector_Total_Cost', 'Inspector total cost') !!}
			{!! Form::number('cbpi_Inspector_Total_Cost', 0, ['class' => 'form-control cbpi_Inspector_Total_Cost','required'=>'','readOnly'=>'true']) !!}
		</div>
	</div>

</div>
<div class="row">		
	<div class="col-md-12">
		<h4 class="heading">Client Cost</h4>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_cli_currency', 'Currency') !!}
			<select class="form-control cbpi_cli_currency cli_required" name="cbpi_cli_currency" id="cbpi_cli_currency" required>
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
			{!! Form::label('cbpi_cli_md_charge', 'MD Charges') !!}
			{!! Form::number('cbpi_cli_md_charge', 0, ['class' => 'form-control cbpi_cli_md_charge cli_required','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_cli_travel_cost', 'Travel Cost') !!}
			{!! Form::number('cbpi_cli_travel_cost', 0, ['class' => 'form-control cbpi_cli_travel_cost cli_required','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_cli_hotel_cost', 'Hotel Cost') !!}
			{!! Form::number('cbpi_cli_hotel_cost', 0, ['class' => 'form-control cbpi_cli_hotel_cost cli_required','required'=>'']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_cli_ot_cost', 'OT Cost') !!}
			{!! Form::number('cbpi_cli_ot_cost', 0, ['class' => 'form-control cbpi_cli_ot_cost cli_required','required'=>'']) !!}
		</div>
	</div>
	<div class="cbpi_cli_other_cost_container">
	</div>
	<div class="col-md-12">
		<button type="button" class="btn btn-success pull-left" id="cbpi_add_cli_other_cost">
			<i class="fa fa-plus"></i> Add Other Cost
		</button>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('cbpi_cli_Total_Cost', 'Client total cost') !!}
			{!! Form::number('cbpi_cli_Total_Cost', 0, ['class' => 'form-control cbpi_cli_Total_Cost','required'=>'','readOnly'=>'true']) !!}
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
		    {!! Form::label('loading_requirements', 'Requirements') !!}
		    {!! Form::textarea('loading_requirements', null, ['class' => 'cli_required form-control','rows'=>'7','id'=>'loading_requirements']) !!}
	  	</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			{!! Form::label('memo_cbpi', 'Memo / Notes') !!}
			{!! Form::textarea('memo_cbpi', null, ['class' => 'form-control cli_required memo_cbpi','rows'=>'4']) !!}
		</div>
	{{-- 	<div id="prod20" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
	</div>
</div>

<div class="row">
	 {!! Form::label('requirement', 'Blank reports, TIC anti-bribery declaration,Onsite quick report, TIC Inspection rules, TIC Inspection criteria-General Merchandise, Product photos and other attachment') !!}
	<div class="col-md-12 dropzone-container file_upload" id="file_upload_container">

	      <div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
	      <div class="fallback">
	          <input name="file[]" class="cli_required" type="file" id="file" multiple required />
	      </div>
	</div>
</div>



<div class="col-md-12">

	<div class="row">
			<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('template', 'Select Type of Project') !!}<br/>
						<label class="checkbox-inline">
							<input type="radio" name="project_type_cbpi" value="null" id="app_project_cbpi" class="cli_required" onclick="changeProjectTypeCbpi('app')"> APP Project
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="project_type_cbpi" value="null" id="word_project_cbpi" class="cli_required" onclick="changeProjectTypeCbpi('word')"> WORD Project
						</label>

					</div>
				</div>
	</div>
</div>


<div class="row" id="div_template_cbpi" style="display:none;">
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('template', 'Select App Template') !!}
			<select class="form-control cli_required select-templates" name="loading_template" id="loading_template" required>
				<option value="" selected>Select Template</option>
				{{-- @foreach($templates as $template)
					<option value="{{$template->id}}">{{$template->name}}</option>
				@endforeach --}}
			</select>
		</div>
	</div> 


	<input type="hidden" name="loading_report_template" id="loading_report_template">
</div>


<div class="col-md-offset-9 col-md-3">
	{!! Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-cbpi-submit-draft','type'=>'button']) !!}
	{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block','style'=>'margin-top: 5px;','type'=>'button', 'id'=>'CBPI_submit']) !!}	
</div>

{!!Form::close()!!}



<script type="text/javascript">
     $( function() {


 

    $("#loading_inspection_date").datepicker({
        
			dateFormat:"yy-mm-dd",
            onSelect: function (date) {
                var date2 = $('#loading_inspection_date').datepicker('getDate');
                date2.setDate(date2.getDate());

				$('#loading_inspection_date_to').datepicker('option', 'minDate', date2);
				

				var dt1 = $('#loading_inspection_date').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#loading_inspection_date_to').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#loading_inspection_date_to').datepicker('option', 'minDate');
                    $('#loading_inspection_date_to').datepicker('setDate', minDate);
				}
				
				
            }
        });
        $('#loading_inspection_date_to').datepicker({
			dateFormat:"yy-mm-dd",
            onClose: function () {
                var dt1 = $('#loading_inspection_date').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#loading_inspection_date_to').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#loading_inspection_date_to').datepicker('option', 'minDate');
                    $('#loading_inspection_date_to').datepicker('setDate', minDate);
                }
            }
        });
  } );
  </script>


<script>


function cbpi_Inspector_Total_Cost_New2(){
	
	var ins_md_charge=jQuery('#cbpi_cli_md_charge').val();
	var ins_travel_cost=jQuery('#cbpi_cli_travel_cost').val();
	var ins_hotel_cost=jQuery('#cbpi_cli_hotel_cost').val();
	var ins_ot_cost=jQuery('#cbpi_cli_ot_cost').val();
	var total =0;
	var othercost2 =0;

	var ins_other_cost_value  = jQuery('.cbpi_cli_other_cost_value');
var inspector_other_cost_value  = [];

for(var i = 0; i < ins_other_cost_value.length; i++){
						var g_data=$(ins_other_cost_value[i]).val();
						if(i==0){
							othercost2=parseInt(g_data);
						}else{
							othercost2=othercost2+parseInt(g_data);
						}
						
					 
					}
//console.log(othercost);
	total=parseInt(ins_md_charge)+parseInt(ins_travel_cost)+parseInt(ins_hotel_cost)+parseInt(ins_ot_cost)+parseInt(othercost2);

	jQuery('#cbpi_cli_Total_Cost').val(total)

}

function cbpi_Inspector_Total_Cost_New(){
		var ins_md_charge=jQuery('#cbpi_ins_md_charge').val();
		var ins_travel_cost=jQuery('#cbpi_ins_travel_cost').val();
		var ins_hotel_cost=jQuery('#cbpi_ins_hotel_cost').val();
		var ins_ot_cost=jQuery('#cbpi_ins_ot_cost').val();
		var total =0;
		var othercost=0;
	
		var ins_other_cost_value  = jQuery('.cbpi_ins_other_cost_value');
	var inspector_other_cost_value  = [];
	
	for(var i = 0; i < ins_other_cost_value.length; i++){
		
							var g_data=$(ins_other_cost_value[i]).val();
							if(i==0){
								othercost=parseInt(g_data);
							}else{
								othercost=othercost+parseInt(g_data);
							}
							
						 
						}
	//console.log(othercost);
		total=parseInt(ins_md_charge)+parseInt(ins_travel_cost)+parseInt(ins_hotel_cost)+parseInt(ins_ot_cost)+parseInt(othercost);
	
		jQuery('#cbpi_Inspector_Total_Cost').val(total)
	
	}

jQuery(document).ready(function(){
	

	

	$('#cbpi_ins_md_charge,#cbpi_ins_travel_cost,#cbpi_ins_hotel_cost,#cbpi_ins_ot_cost').on('change', function() {
		cbpi_Inspector_Total_Cost_New()
});


$('#cbpi_cli_md_charge,#cbpi_cli_travel_cost,#cbpi_cli_hotel_cost,#cbpi_cli_ot_cost').on('change', function() {
	cbpi_Inspector_Total_Cost_New2()
});

});
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

