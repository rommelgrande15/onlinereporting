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
				'st' => 'Sample Test',
		    	'cbpi' => 'CBPI',
				'site_visit' => 'Site Visit',
				'physical' => 'Factory Audit',
				'SPK' => 'SPK',
				'FRI' => 'FRI',
		    ], null, ['class' => 'form-control service site_required site_draft_required', 'placeholder'=>'Select a Service']) !!}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_client', 'Select Client') !!}
			<select class="form-control site_required client client_select site_draft_required" id="site_client" name="site_client" required>.
				<option value="" >Select Client</option>
				@foreach($clients as $client)
					@if($client->client_status!=2 || $client->client_status!='2')
					<option value="{{$client->client_code}}">{{$client->Company_Name}}</option>
					@endif
				@endforeach
			</select>
			<div id='site_clientResult'></div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_reference_number', 'Reference / Report Number') !!}
			{!! Form::text('site_reference_number', null, ['class' => 'form-control reference_number site_required site_draft_required', 'id'=>'site_reference_number','required'=>'']) !!}
		</div>
	</div>
	<div class="contact-select">			
		<div class="clone-inputs-contact-person">
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('site_contact_person', 'Contact Person') !!}
					<select class="form-control site_required contact_persons site_draft_required" id="site_contact_person"  name="site_contact_person">
						<option value="" selected>Select Contact</option>
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
			<div id="add_more_contact_container_site">
			</div>
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
				{!! Form::label('client_project_number_site', 'Client Project Number') !!}
				{!! Form::text('client_project_number_site', null, ['class' => 'form-control  client_project_number site_required site_draft_required']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_inspection_date', 'Inspection Date From') !!}
				{!! Form::text('site_inspection_date', null, ['class' => 'form-control site_required inspection_date site_draft_required', 'autocomplete'=>'off']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_inspection_date_to', 'Inspection Date To') !!}
				{!! Form::text('site_inspection_date_to', null, ['class' => 'form-control site_required inspection_date site_draft_required', 'autocomplete'=>'off']) !!}
			</div>
		</div>
		<div class="clone-inspector-container-site">
			<div class="clone-inspector-site">
				<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('site_inspector', 'Assign Inspector') !!}
					   	<select class="form-control select_address site_required site_draft_required site-sel-inspector" name="site_inspector" id="site_inspector" required>
							<option value="" >Select an Inspector</option>
							@foreach($inspectors_two as $inspectors)
								<option value="{{$inspectors->user_id}}">{{$inspectors->name}}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
							@endforeach
						</select>
						
						<div id='site_InspectoResult'></div>
				  	</div>
				</div>
    			<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('site_inspector_address', 'Inspector Address') !!}
					    {!! Form::text('site_inspector_address', null, ['class' => 'form-control  inspector_address site_required site_draft_required site-insp-addr','readOnly'=>'true']) !!}
					</div>
				</div>
			</div>
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
			{!! Form::text('site_manday', 1, ['class' => 'form-control  manday site_required site_draft_required']) !!}
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
			<h4 class="heading">Inspector Cost</h4>
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
				{!! Form::number('site_ins_md_charge', 0, ['class' => 'form-control ins_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_ins_travel_cost', 'Travel Cost') !!}
				{!! Form::number('site_ins_travel_cost', 0, ['class' => 'form-control ins_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_ins_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('site_ins_hotel_cost', 0, ['class' => 'form-control ins_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_ins_ot_cost', 'OT Cost') !!}
				{!! Form::number('site_ins_ot_cost', 0, ['class' => 'form-control ins_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="site_ins_other_cost_container">

		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="site_add_insp_other_cost">
				<i class="fa fa-plus"></i> Add Other Cost
			</button>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_Inspector_Total_Cost', 'Inspector total cost') !!}
				{!! Form::number('site_Inspector_Total_Cost', 0, ['class' => 'form-control site_Inspector_Total_Cost','required'=>'','readOnly'=>'true']) !!}
			</div>
		</div>

	</div>
	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Client Cost</h4>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_cli_currency', 'Currency') !!}
				<select class="form-control cli_currency" name="site_cli_currency" id="site_cli_currency" required>
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
				{!! Form::number('site_cli_md_charge', 0, ['class' => 'form-control cli_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_cli_travel_cost', 'Travel Cost') !!}
				{!! Form::number('site_cli_travel_cost', 0, ['class' => 'form-control cli_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_cli_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('site_cli_hotel_cost', 0, ['class' => 'form-control cli_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_cli_ot_cost', 'OT Cost') !!}
				{!! Form::number('site_cli_ot_cost', 0, ['class' => 'form-control cli_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="site_cli_other_cost_container">
		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="site_add_cli_other_cost">
				<i class="fa fa-plus"></i> Add Other Cost
			</button>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('site_cli_Total_Cost', 'Client total cost') !!}
				{!! Form::number('site_cli_Total_Cost', 0, ['class' => 'form-control site_cli_Total_Cost','required'=>'','readOnly'=>'true']) !!}
			</div>
		</div>

	</div>
	<br>
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
			<div class="col-md-12">
					<div class="form-group">
						{!! Form::label('template', 'Select Type of Project') !!}<br/>
						<label class="checkbox-inline">
							<input type="radio" name="project_type_site" value="null" id="app_project_site" class="site_required" onclick="changeProjectTypeSite('app')" required> APP Project
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="project_type_site" value="null" id="word_project_site" class="site_required" onclick="changeProjectTypeSite('word')" required> WORD Project
						</label>
					</div>
			</div>
		</div>



<div class="row" id="div_template_site" style="display:none;">
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('site_template', 'Select App Template') !!}
			<select class="form-control" name="site_template" id="site_template" required>
				<option value="" selected>Select App Template</option>
				@foreach($templates as $template)
					<option value="{{$template->id}}">{{$template->name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	{{-- <div class="col-md-12">
		<label title="Checking this means the report is complex.">
			<input type="checkbox" id="complex_report_site" name="complex_report_site" value="0"> Complex Report (Check if complex, leave blank if not).
		</label>
	</div> --}}


</div>



<div class="row">
<div class="col-md-offset-9 col-md-3">
	<br/>
		{!! Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-site-submit-draft','type'=>'button']) !!}
		{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block','id'=>'btn-site-submit','type'=>'button']) !!}

	</div>
</div>


<script type="text/javascript">
     $( function() {


 

    $("#site_inspection_date").datepicker({
        
			dateFormat:"yy-mm-dd",
			minDate: 0,
            onSelect: function (date) {
                var date2 = $('#site_inspection_date').datepicker('getDate');
                date2.setDate(date2.getDate());

				$('#site_inspection_date_to').datepicker('option', 'minDate', date2);
				

				var dt1 = $('#site_inspection_date').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#site_inspection_date_to').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#site_inspection_date_to').datepicker('option', 'minDate');
                    $('#site_inspection_date_to').datepicker('setDate', minDate);
				}
				
				
            }
        });
        $('#site_inspection_date_to').datepicker({
			dateFormat:"yy-mm-dd",
            onClose: function () {
                var dt1 = $('#site_inspection_date').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#site_inspection_date_to').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#site_inspection_date_to').datepicker('option', 'minDate');
                    $('#site_inspection_date_to').datepicker('setDate', minDate);
                }
            }
		});
		$('#complex_report_site').click(function(){
			if ($('#complex_report_site').prop('checked')==true) { 
				$('#complex_report_site').val('1');
			}else{
				$('#complex_report_site').val('0');
			}
		});
  } );
  </script>
<script>

	
function site_Inspector_Total_Cost_New2(){
	
	var ins_md_charge=jQuery('#site_cli_md_charge').val();
	var ins_travel_cost=jQuery('#site_cli_travel_cost').val();
	var ins_hotel_cost=jQuery('#site_cli_hotel_cost').val();
	var ins_ot_cost=jQuery('#site_cli_ot_cost').val();
	var total =0;
	var othercost2 =0;

	var ins_other_cost_value  = jQuery('.site_cli_other_cost_value');
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

	jQuery('#site_cli_Total_Cost').val(total)

}

function site_Inspector_Total_Cost_New(){
	var ins_md_charge=jQuery('#site_ins_md_charge').val();
	var ins_travel_cost=jQuery('#site_ins_travel_cost').val();
	var ins_hotel_cost=jQuery('#site_ins_hotel_cost').val();
	var ins_ot_cost=jQuery('#site_ins_ot_cost').val();
	var total =0;
	var othercost=0;

	var ins_other_cost_value  = jQuery('.site_ins_other_cost_value');
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

	jQuery('#site_Inspector_Total_Cost').val(total)

}

$(document).ready(function(){



$('#site_ins_md_charge,#site_ins_travel_cost,#site_ins_hotel_cost,#site_ins_ot_cost').on('change', function() {
	site_Inspector_Total_Cost_New()
});


$('#site_cli_md_charge,#site_cli_travel_cost,#site_cli_hotel_cost,#site_cli_ot_cost').on('change', function() {
	site_Inspector_Total_Cost_New2()
});

		/* jQuery('#btn-site-submit').click(function(e){
			var site_req=$('.site_required');
			var count_null_site=0;
			for(var i = 0; i < site_req.length; i++){
            var data=$(site_req[i]).val();
            if(data==""){
			  $(site_req[i]).css("border","1px solid red");
			  count_null_site+=1;
            }else{
              $(site_req[i]).removeAttr("style");
            }
		  }

		  if(count_null_site==0 && !$("input[name='project_type_site']:checked").val()){	
			alert("Please choose type of project");		  
		  }else if(count_null_site>0 && !$("input[name='project_type_site']:checked").val()){
			alert("Please choose type of project");	
		  }else if(count_null_site>0){
			alert("Please fill up the required fields");
		  }else{

		  }
		}); */
				

});


$('#site_client').on('change', function() {
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
					 	$('#site_reference_number').val(set_pn);			
        }
    });

	}else{
		$('#site_reference_number').val("");
	}
	
});

</script>


{!!Form::close()!!}
