{!!Form::open(['enctype'=>'multipart/form-data','id'=>'new_loading_form','data-parsley-validate'=>'', 'route'=>'savecbpiinspection','class'=>'form-inspection'])!!}
	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Inspection Details</h4>
			<hr>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group" style="margin-left:18px;">
				    {!! Form::label('loading_service', 'Service') !!}
				    {!! Form::select('loading_service', [
				    	'iqi' => 'Incoming Quality Inspection',
				    	'dupro' => 'During Production Inspection',
						'psi' => 'Pre Shipment Inspection',
						'cbpi' => 'CBPI',
						'cli' => 'Container Loading Inspection',
						'physical' => 'Factory Audit',
						'detail' => 'Detail Audit',
						'social' => 'Social Audit',
				    ], $inspection->service, ['class' => 'form-control service cli_required cli_draft_required', 'placeholder'=>'Select a Service', 'disabled']) !!}
			  	</div>
			</div>
			<input type="hidden" value="{{$reference_num ?? ''}}" class="form-control loading_reference_number" id="loading_reference_number">
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('client_project_number_cbpi', 'Project Number') !!}
					{!! Form::text('client_project_number_cbpi', $inspection->client_project_number, ['class' => 'form-control  client_project_number cli_required cli_draft_required','required'=>'']) !!}
					<br/><br/><br/>				
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">			
					{!! Form::label('loading_inspection_date', 'Inspection Date') !!}
					{!! Form::text('loading_inspection_date', $inspection->inspection_date, ['class' => 'form-control cli_required inspection_date cli_draft_required','required'=>'']) !!}
					<label title="Selecting this will not allow the factory to postpone or advance the inspection date">
						@if($inspection->factory_change_date=='yes')					
							<input type="checkbox" id="loading_fac_change_date" name="loading_fac_change_date" value="yes" checked> Do not allow factory to change this date.
						@else
							<input type="checkbox" id="loading_fac_change_date" name="loading_fac_change_date" value="no"> Do not allow factory to change this date.				
						@endif
					</label>
				</div>
			</div>
		</div>

		
		{{-- <div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cbpi_shipment_date', 'Expected Shipment Date') !!}
				{!! Form::text('cbpi_shipment_date', $inspection->shipment_date, ['class' => 'form-control cli_required inspection_date cli_draft_required','required'=>'']) !!}
				<br/><br/><br/>
			</div>
		</div> --}}
	
		<div class="contact-select">	
			<div class="clone-inputs-contact-person">
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('loading_contact_person', 'Contact Person') !!}
						{!! Form::select('loading_contact_person', $client_contact, $get_cc->id, ['class' => 'form-control cli_required contact_persons cli_draft_required', 'placeholder'=>'Select Contact']) !!}
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    {!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
					    {!! Form::text('contact_person_number', $get_cc->tel_number, ['class' => 'form-control cli_required numeric contact_number cli_draft_required','readOnly'=>true]) !!}
				  	</div>
				</div>	
				<div class="col-md-4">
					<div class="form-group">
					    {!! Form::label('loading_email', 'Email Address') !!}
					    {!! Form::text('loading_email', $get_cc->email_address, ['class' => 'form-control cli_required contact_email cli_draft_required','readOnly'=>true]) !!}
				  	</div>
				</div>
			</div>
			<div class="col-md-12 text-right">
				<div class="form-group">
					<button style="margin-left:20px;" class="btn btn-primary btn-contact-person" type="button"><i class="fa fa-list-alt"></i> Contact Persons List</button>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row factory-select">
		<div class="col-md-12">
			<h4 class="heading">Factory &amp; Supplier Details</h4>
			<hr>
		</div>
		<div class="col-md-12 text-right">
			<div class="form-group">
				<button style="margin-left:20px;"  class="btn btn-primary btn-supplier" type="button"><i class="fa fa-plus"></i> Add New Supplier</button>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('loading-supplier', 'Supplier') !!}
				{!! Form::select('loading-supplier', $supplier_list, $inspection->supplier_id, ['class' => 'form-control supplier cli_required cli_draft_required', 'placeholder'=>'Select supplier']) !!}
		  	</div>
		</div>
		<div class="col-md-8">
			<div class="form-group">
				{!! Form::label('supplier_address', 'Supplier Address') !!}
				@if($supplier_info)
					{!! Form::text('supplier_address', $supplier_info->supplier_address, ['class' => 'form-control cli_required supplier_address cli_draft_required','readOnly'=>'true']) !!}
				@else
					{!! Form::text('supplier_address', null, ['class' => 'form-control cli_required supplier_address cli_draft_required','readOnly'=>'true']) !!}
				@endif
			    
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('loading_supplier_contact_person', 'Supplier Contact Person') !!}
				{!! Form::select('loading_supplier_contact_person', $supplier_con_list, $inspection->supplier_contact_id, ['class' => 'form-control supplier_contact_person cli_required cli_draft_required', 'placeholder'=>'Select Supplier Contact Person']) !!}
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_contact_number', 'Contact Telephone Number (Supplier)') !!}
				@if($supplier_con_info)
					{!! Form::text('supplier_contact_number', $supplier_con_info->supplier_tel_number, ['class' => 'form-control cli_required numeric supplier_contact_number cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				@else
					{!! Form::text('supplier_contact_number', null, ['class' => 'form-control cli_required numeric supplier_contact_number cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				@endif
			    
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_email', 'Email Address') !!}
				@if($supplier_con_info)
					{!! Form::text('supplier_email', $supplier_con_info->supplier_email, ['class' => 'form-control cli_required supplier_email cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				@else
					{!! Form::text('supplier_email', null, ['class' => 'form-control cli_required supplier_email cli_draft_required','required'=>'','readOnly'=>'true']) !!}
				@endif
			    
		  	</div>
		</div>
		<div class="col-md-12 text-right">
			<div class="form-group">
				<button style="margin-left:20px;"  class="btn btn-primary l-btn-cli-factory" type="button"><i class="fa fa-plus"></i> Add New Factory</button>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('loading_factory', 'Factory Name') !!}
				{!! Form::select('loading_factory', $factory_list, $get_factory->id, ['class' => 'form-control factory cli_required cli_draft_required', 'placeholder'=>'Select Factory',  'required'=>'']) !!}
		  	</div>
		</div>
		<div class="col-md-8">
			<div class="form-group">
			    {!! Form::label('loading_factory_address', 'Factory Address') !!}
			    {!! Form::text('loading_factory_address', $get_factory->factory_address, ['class' => 'form-control cli_required factory_address cli_draft_required','required'=>'','readOnly'=>'true']) !!}
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('loading_factory_contact_person', 'Factory Contact Person') !!}
				{!! Form::select('loading_factory_contact_person', $factory_con_list, $get_fc->id, ['class' => 'form-control cli_required factory_contact_person cli_required cli_draft_required', 'placeholder'=>'Select Contact Person',  'required'=>'']) !!}

		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('loading_factory_contact_number', 'Contact Telephone Number (Factory)') !!}
			    {!! Form::text('loading_factory_contact_number', $get_fc->factory_tel_number, ['class' => 'form-control cli_required numeric factory_contact_number cli_draft_required','required'=>'','readOnly'=>'true']) !!}
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('loading_factory_email', 'Email Address') !!}
			    {!! Form::text('loading_factory_email', $get_fc->factory_email, ['class' => 'form-control cli_required factory_email cli_draft_required','required'=>'','id'=>'factory_email','readOnly'=>'true']) !!}
		  	</div>
		</div>


		<div class="col-md-12 show_fac_c_p" style="display:none;" id="show_fac_c_p">
			<div class="form-group">
				<button class="btn btn-success" type="button" id="add_more_fac_c_p" >
					<i class="fa fa-plus"></i> Add More Contact Person
				</button>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('loading_requirements', 'Requirements') !!}
				{!! Form::textarea('loading_requirements', $inspection->requirement, ['class' => 'form-control requirement','rows'=>'4']) !!}
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('memo_cbpi', 'Memo / Notes') !!}
				{!! Form::textarea('memo_cbpi', $inspection->memo, ['class' => 'form-control memo_cbpi','rows'=>'4']) !!}
			</div>
		</div>


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
	<div class="">
		<div class="col-md-offset-10 col-md-2">
			<br/>
			<input type="hidden" id="hidden_client_id" value="{{$client_id}}">
			<input type="hidden" id="loading_client" value="{{$client_code}}">
			<input type="hidden" id="hidden_client_code" value="{{$client_code}}">
			<input type="hidden" id="edit_inspection_id" value="{{$inspection->id}}">
			{!! Form::button('<i class="fa fa-paper-plane"></i> Submit', ['class' => 'btn btn-success btn-block','id'=>'CBPI_submit','type'=>'button']) !!}
		</div>
	</div>
<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	$(document).ready(function(){

		$('.cli_required').change(function() {
    	    var val = $(this).val();
    	    if (val == '' || val == null) {
    	        $(this).css("border", "1px solid red");
    	    } else {
    	        $(this).removeAttr("style");
    	    }
		});
		
		$('#loading_fac_change_date').click(function(){
			if ($('#loading_fac_change_date').prop('checked')==true) { 
				$('#loading_fac_change_date').val('yes');
			}else{
				$('#loading_fac_change_date').val('no');
			}
		});
		$('#loading_inspection_date').change(function() {
			console.log('cbpi inspection date on change...');
            //function for referenece number
            var client_code = $('#loading_client').val();
            var inspect_date_val = $('#loading_inspection_date').val();
            if (client_code != "") {
                $.ajax({
                    type: "GET",
                    url: '/getclientdbcountinspection-new/' + client_code + '/' + inspect_date_val,
                    success: function(data) {
                        $('#loading_reference_number').val(data.ref_num);
                    },
                    error: function(err){
                        console.log('Reference Number Error: ' + err);
                        $('#loading_reference_number').val('');
                    }
                });
            }
		});

	});



</script>


{!!Form::close()!!}
