{!!Form::open(['id'=>'new_inspection_form','data-parsley-validate'=>'', 'route'=>'saveinspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
<div class="row">
				

	<div class="col-md-12">
	<h4 class="heading">Inspection Details SPK</h4>
	<hr>
	</div>
{{-- 	<div  class="col-md-12">
		{{ Form::label('slider', 'Client Preview') }}
	</div>

	<div  class="col-md-12">

		<input id="invisible" name="invisible" type="hidden" value="">


		<label class="switch">
			<input type="checkbox" name="togBtn[]" id="togBtn">
			<div class="slider round"><!--ADDED HTML -->
				<span class="on">ON</span><span class="off">OFF</span><!--END--></div></label>
	</div> --}}
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('spk_service', 'Service') !!}
		    {!! Form::select('spk_service', [
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
		    ], null, ['class' => 'form-control service spk_required spk_draft_required', 'placeholder'=>'Select a Service', 'id'=>'service', 'required'=>'']) !!}
	  	</div>
		 {{--  <div id="prod0" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
	</div>


	{{-- <div class="contact-select"> --}}
		<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('client', 'Select Client') !!}
					<select class="form-control spk_required client client_select spk_draft_required" id="client" name="client" required>.
						<option value="" >Select Client</option>
						@foreach($clients as $client)
							@if($client->client_status!=2 || $client->client_status!='2')
							<option value="{{$client->client_code}}">{{$client->Company_Name}}</option>
							@endif
						@endforeach
					</select>
				   {{--  <div id="prod4" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
				</div>
		</div>
	{{-- </div> --}}
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('reference_number', 'Reference / Report Number') !!}
			{!! Form::text('reference_number', null, ['class' => 'form-control reference_number spk_required spk_draft_required', 'id'=>'reference_number','required'=>'','readOnly'=>'true']) !!}
		</div>
	</div>

	

	<div class="contact-select">
		
		
		<div class="clone-inputs-contact-person">
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('contact_person', 'Contact Person') !!}
				{{-- <div class="input-group">
					<select class="form-control spk_required contact_persons" id="contact_person"  name="contact_person">
						<option value="1234" selected>Select Contact</option>
					</select>

					<div class="input-group-btn">
						<button class="btn btn-success contact_modal_button" onclick="cliks4()" type="button">
							<i class="fa fa-plus"></i>
						</button>
					</div>
				</div> --}}
				<select class="form-control spk_required contact_persons spk_draft_required" id="contact_person"  name="contact_person">
					<option value="" selected>Select Contact</option>
				</select>
			{{-- 	<div id="prod6" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
			    {!! Form::text('contact_person_number', null, ['class' => 'form-control spk_required numeric contact_number spk_draft_required','required'=>'','id'=>'contact_number']) !!}
		  	</div>
		{{-- 	  <div id="prod7" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
		</div>

		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_email', 'Email Address') !!}
			    {!! Form::text('contact_person_email', null, ['class' => 'form-control spk_required contact_email spk_draft_required','id'=>'email_address']) !!}
		  	</div>
			{{--   <div id="prod8" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
		</div>
	
		<div id="add_more_contact_container">
		</div>

		<div class="col-md-12 show_client_c_p" style="display:none;" id="show_client_c_p">
			<div class="form-group">
				<button class="btn btn-success" type="button" id="add_more_client_c_p" >
					<i class="fa fa-plus"></i> Add More Contact Person
				</button>
			 {{--  <div id="prod999" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
		</div>
	</div>
</div>

		
<div class="col-md-4">
	<div class="form-group">
		{!! Form::label('client_project_number', 'Client Project Number') !!}
		{!! Form::text('client_project_number', null, ['class' => 'form-control  client_project_number spk_required spk_draft_required','required'=>'','id'=>'client_project_number']) !!}
		</div>
		{{-- <div id="prod2" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
</div>




<div class="col-md-4">
	<div class="form-group">
		{!! Form::label('inspection_date', 'Inspection Date') !!}
		{!! Form::text('inspection_date', null, ['class' => 'form-control spk_required inspection_date spk_draft_required', 'id'=>'inspection_date','required'=>'']) !!}
	  </div>
	
</div>

<div class="col-md-4">
	<div class="form-group">
			{!! Form::label('SPK', 'SPK') !!}
		<select class="form-control select_address spk_required spk_draft_required sel-inspector" name="SPK" id="SPK" required>
			<option value="" >Select an Percentage</option>
			<option value="10%" >10%</option>
			<option value="80%" >80%</option>
		
		</select>
	  </div>
	
</div>

	<div class="clone-inspector-container">
		<div class="clone-inspector">
			<div class="col-md-6">
				<div class="form-group">
				    {!! Form::label('inspector', 'Assign Inspector') !!}
				   
				   	<select class="form-control select_address spk_required spk_draft_required sel-inspector" name="inspector" id="inspector" required>
						<option value="" >Select an Inspector</option>
						@foreach($inspectors_two as $inspectors)
							<option value="{{$inspectors->user_id}}">{{$inspectors->name}}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
						@endforeach
					</select>
			  	</div>
			</div>
    		<div class="col-md-6">
				<div class="form-group">
				    {!! Form::label('inspector_address', 'Inspector Address') !!}
				    {!! Form::text('inspector_address', null, ['class' => 'form-control  inspector_address spk_required spk_draft_required insp-addr','required'=>'','id'=>'inspector_address','readOnly'=>'true']) !!}
				</div>
			</div>
		</div>
	</div>		
</div>
	<div class="inspector_container">

	</div>
	<div class="col-md-12">
		<button type="button" class="btn btn-success pull-left" id="add_inspector">
			<i class="fa fa-plus"></i> Add Other Inspector
		</button>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('manday', 'Manday') !!}
			{!! Form::text('manday', 1, ['class' => 'form-control  manday spk_required spk_draft_required','required'=>'','readOnly'=>'true']) !!}
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
			{!! Form::label('factory', 'Factory Name') !!}
		
			<select class="form-control factory spk_required spk_draft_required" name="factory" id="factory" required>
				<option value="" >Select Factory</option>
				@foreach($factories as $factory)
					<option value="{{$factory->id}}">{{$factory->factory_name}}</option>
				@endforeach
			</select>
		
	  	</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
		    {!! Form::label('factory_address', 'Factory Address') !!}
		    {!! Form::text('factory_address', null, ['class' => 'form-control spk_required factory_address spk_draft_required','required'=>'','id'=>'factory_address','readOnly'=>'true']) !!}
	  	</div>
		
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="factory_contact_person">Factory Contact Person</label>
			<select class="form-control spk_required factory_contact_person spk_required spk_draft_required" id="factory_contact_person" name="factory_contact_person" >
				<option value="" >Select Contact Person</option>
			</select>
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('factory_contact_number', 'Contact Telephone Number (Factory)') !!}
		    {!! Form::text('factory_contact_number', null, ['class' => 'form-control spk_required numeric factory_contact_number spk_draft_required','required'=>'','id'=>'factory_contact_number','readOnly'=>'true']) !!}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('factory_email', 'Email Address') !!}
		    {!! Form::text('factory_email', null, ['class' => 'form-control spk_required factory_email spk_draft_required','required'=>'','id'=>'factory_email','readOnly'=>'true']) !!}
	  	</div>
	</div>

	

	<div class="fcp_container">
		<div class="clone_fcp" style="display:none;">
			<div class="col-md-4">
					<div class="form-group">
						<label for="fcp_sel">Factory Contact Person</label>
						<select class="form-control fcp_sel factory_contact_added">
							<option value="" >Select Contact Person</option>
						</select>
					  </div>
			</div>
			<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('factory_contact_number_added', 'Contact Telephone Number (Factory)') !!}
						{!! Form::text('factory_contact_number_added', null, ['class' => 'form-control factory_contact_number_added','required'=>'']) !!}
					  </div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('factory_email_added', 'Email Address') !!}
					<div class="input-group">
						{!! Form::text('factory_email_added', null, ['class' => 'form-control factory_email_added ','required'=>'']) !!}
		
						<div class="input-group-btn">
						  <button class="btn btn-danger rm_fcp" type="button">
							<i class="fa fa-times"></i>
						  </button>
						</div>
					</div> 
				</div>
			</div>
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

<div class="row" id="products_list">
	<hr>
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">
				<h4 class="heading">Product Details</h4>
			</div>

			<div class="col-md-6 text-right">
				<button class="btn btn-primary" type="button" data-toggle="modal" onclick="checked()" data-target="#newProduct">
					<i class="fa fa-plus"></i> Add New Product
				</button>
			
			</div>
		</div>


		<hr>
	</div>
	<div class="col-md-12 products-list">
		<div class="product_row">
			<div class="group-body">
				<div class="row product-clone">
					<div class="clone-inputs">
						<div class="col-md-3">
							<div class="form-group">
								{!! Form::label('product_name', 'Product Name') !!}
									<select class="form-control spk_required product_name spk_draft_required" name="product_name" id="product_name" required>
										<option value="">Select Product</option>
										@foreach($products as $product)
											<option value="{{$product->id}}">{{$product->product_name}}</option>
										@endforeach
									</select>
					
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								{!! Form::label('brand', 'Brand') !!}
								{!! Form::text('brand', null, ['class' => 'form-control brand spk_required spk_draft_required','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								{!! Form::label('po_number', 'PO Number') !!}
								{!! Form::text('po_number', null, ['class' => 'form-control po_number spk_required spk_draft_required','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								{!! Form::label('model_no', 'Model Number') !!}
								{!! Form::text('model_no', null, ['class' => 'form-control model_no spk_required spk_draft_required','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-2 qty-modal">
							<div class="form-group">
								{!! Form::label('qty', 'Qty') !!}
								<div class="input-group">
									<input type="text" class="form-control qty spk_required spk_draft_required" name="qty" id="qty" readonly required>
									<div class="input-group-btn">
										<button class="btn btn-success btn-qty-modal" type="button" >
											<i class="fa fa-plus"></i>
										</button>
									</div>

								</div>
							</div>
							@include('partials._newinspectionmodal')
						</div>
					</div>
				</div>

				


			</div>
		</div>
	</div>
	
	<div class="col-md-3 pull-right">
			<button type="button" class="btn btn-success pull-right" id="btn_product">
			<i class="fa fa-cube"></i> Add More Products
		</button>
	</div>

	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Inspector Cost ($)</h4>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_currency', 'Currency') !!}
				<select class="form-control ins_currency" name="ins_currency" id="ins_currency" required>
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
				{!! Form::label('ins_md_charge', 'MD Charges') !!}
				{!! Form::number('ins_md_charge', null, ['class' => 'form-control ins_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_travel_cost', 'Travel Cost') !!}
				{!! Form::number('ins_travel_cost', null, ['class' => 'form-control ins_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('ins_hotel_cost', null, ['class' => 'form-control ins_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_ot_cost', 'OT Cost') !!}
				{!! Form::number('ins_ot_cost', null, ['class' => 'form-control ins_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="ins_other_cost_container">

		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="add_insp_other_cost">
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
				{!! Form::label('cli_currency', 'Currency') !!}
				<select class="form-control cli_currency" name="cli_currency" id="cli_currency" required>
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
				{!! Form::label('cli_md_charge', 'MD Charges') !!}
				{!! Form::number('cli_md_charge', null, ['class' => 'form-control cli_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_travel_cost', 'Travel Cost') !!}
				{!! Form::number('cli_travel_cost', null, ['class' => 'form-control cli_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('cli_hotel_cost', null, ['class' => 'form-control cli_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_ot_cost', 'OT Cost') !!}
				{!! Form::number('cli_ot_cost', null, ['class' => 'form-control cli_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="cli_other_cost_container">
		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="add_cli_other_cost">
				<i class="fa fa-plus"></i> Add Other Cost
			</button>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('requirement', 'Requirements') !!}
				{!! Form::textarea('requirement', null, ['class' => 'form-control spk_required requirement','rows'=>'4']) !!}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('memo_psi', 'Memo / Notes') !!}
				{!! Form::textarea('memo_psi', null, ['class' => 'form-control spk_required memo_psi','rows'=>'4']) !!}
			</div>
		
		</div>
	</div>

	<div class="row">
	<div class="col-md-12">
			<label>Blank reports, TIC anti-bribery declaration,Onsite quick report, TIC Inspection rules, TIC Inspection criteria-General Merchandise, Product photos and other attachment</label>
			<div class="col-md-12 dropzone-container file_upload_psi" id="file_upload_container">
						<div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
						<div class="fallback">
								<input name="file[]" class="spk_required joe file" type="file" id="file" multiple required />
						</div>
	
			</div>
		</div>
	</div>	


		<div class="row">
				<div class="col-md-12">
						<div class="form-group">
							{!! Form::label('template', 'Select Type of Project') !!}<br/>
					
							<label class="checkbox-inline">
								<input type="radio" name="project_type" value="null" id="app_project" class="spk_required" onclick="changeProjectType('app')" required> APP Project
							</label>
							<label class="checkbox-inline">
								<input type="radio" name="project_type" value="null" id="word_project" class="spk_required" onclick="changeProjectType('word')" required> WORD Project
							</label>
							

						</div>
					</div>
		</div>
	


<div class="row" id="div_template" style="display:none;">
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('template', 'Select App Template') !!}
			<select class="form-control" name="template" id="template" required>
				<option value="" selected>Select App Template</option>
				@foreach($templates as $template)
					<option value="{{$template->id}}">{{$template->name}}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('same_report', 'Select Docs Report') !!}<br/>
			<label class="checkbox-inline">
				<input type="radio" name="same_report" value="" id="same_report" class="" required onclick="chooseEngReport('same_report')"> Same Report
			</label>
			<label class="checkbox-inline">
				<input type="radio" name="same_report" value="" id="other_report" class="" required onclick="chooseEngReport('other_report')"> Other Report Language
			</label>
		</div>
	</div>

	<div class="col-md-4" id="eng_rpt_temp" style="display:none;">
		<div class="form-group">
			{!! Form::label('report_template', 'Select Chinese Report') !!}
			<select class="form-control" name="report_template" id="report_template" required>
				<option value="" selected>Select Chinese Report Template</option>
				@foreach($templates_chinese as $template)
					<option value="{{$template->id}}">{{$template->name}}</option>
				@endforeach
			</select>
		</div>
	</div>

</div>

</div>






<div class="row">
<div class="col-md-offset-9 col-md-3">
	<br/>
		{!! Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-psi-submit-draft','type'=>'button']) !!}
		{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block','id'=>'btn-psi-submit','type'=>'button']) !!}

	</div>
</div>


<script>
jQuery(document).ready(function(){

$('#file').on("change", function(){ alert("test"); });

var id =[
'service',
'sub_service_psi',
'client_project_number',
'inspection_date',
'client',
'reference_number',
'contact_persons',
'contact_number',
'contact_email',
'select_address',
'inspector_address',

'factory',
'factory_address',
'factory_contact_person',
'factory_contact_number',
'factory_email',


'product_name',
'brand',
'po_number',
'model_no',
'qty',
'requirement'

];




function checked()
        {

          for(var x=0;x<=21;x++){
          jQuery('.'+id[x]+'').removeAttr("style");
          }

          for(var x=0;x<=21;x++){
            jQuery('#prod'+x+'').css("display","none");
					}

        }

jQuery('.service').on('change',function(e){
          if(jQuery('.service').val()!=""  ){

            checked();
          }else{

          }
        });

				jQuery('#client_project_number').on('change',function(e){
          if(jQuery('#client_project_number').val()!=""  ){

            checked();
          }else{

          }
        });

		jQuery('.reference_number').on('change',function(e){
          if(jQuery('.reference_number').val()!=""  ){
            checked();
          }else{

          }
        });

		jQuery('.inspection_date').on('change',function(e){
          if(jQuery('.inspection_date').val()!=""  ){

            checked();
          }else{

          }
				});
				
	

		jQuery('.client').on('change',function(e){
          if(jQuery('.client').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.contact_persons').on('change',function(e){
          if(jQuery('.contact_persons').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.contact_number').on('change',function(e){
          if(jQuery('.contact_number').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.contact_email').on('change',function(e){
          if(jQuery('.contact_email').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.inspector').on('change',function(e){
          if(jQuery('.inspector').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.factory').on('change',function(e){
          if(jQuery('.factory').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.factory_address').on('change',function(e){
          if(jQuery('.factory_address').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.factory_contact_person').on('change',function(e){
          if(jQuery('.factory_contact_person').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.factory_contact_number').on('change',function(e){
          if(jQuery('.factory_contact_number').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.factory_email').on('change',function(e){
          if(jQuery('.factory_email').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.product_name').on('change',function(e){
          if(jQuery('.product_name').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.brand').on('change',function(e){
          if(jQuery('.brand').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.po_number').on('change',function(e){
          if(jQuery('.po_number').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.model_no').on('change',function(e){
          if(jQuery('.model_no').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.qty').on('change',function(e){
          if(jQuery('.qty').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.requirement').on('change',function(e){
          if(jQuery('.requirement').val()!=""  ){

            checked();
          }else{

          }
        });
		jQuery('.inspector_address').on('change',function(e){
          if(jQuery('.inspector_address').val()!=""  ){

            checked();
          }else{

          }
        });



		jQuery('#btn-psi-submit').click(function(e){
			var psi_req=$('.spk_required');
			var count_null=0;
			for(var i = 0; i < psi_req.length; i++){
            var data=$(psi_req[i]).val();
            if(data==""){
			  $(psi_req[i]).css("border","1px solid red");
			  count_null+=1;
            }else{
              $(psi_req[i]).removeAttr("style");
            }
		  }

		  if(count_null==0 && !$("input[name='project_type']:checked").val()){	
			alert("Please choose type of project");		  
		  }else if(count_null>0 && !$("input[name='project_type']:checked").val()){
			alert("Please choose type of project");	
		  }else if(count_null>0){
			alert("Please fill up the required fields");
		  }else{

		  }
		});
				


});



function cliks(){
jQuery('#new_client_name').val("");
jQuery('#new_client_code').val("");
jQuery('#require1').css("display","none");
jQuery('#require2').css("display","none");
jQuery('#new_client_name').removeAttr("style");
jQuery('#new_client_code').removeAttr("style");

}

function cliks4(){
	jQuery('#add_contact_person').val("");
	jQuery('#add_contact_person').removeAttr("style");
	jQuery('#field11').css("display","none");
	jQuery('#add_contact_person_email').val("");
	jQuery('#add_contact_person_email').removeAttr("style");
jQuery('#field12').css("display","none");
	jQuery('#add_contact_person_number').val("");
	jQuery('#add_contact_person_number').removeAttr("style");
jQuery('#field13').css("display","none");


}

function cliks2(){
jQuery('#new_client_code_factory').val("");
jQuery('#new_client_code_factory').removeAttr("style");
jQuery('#field1').css("display","none");

jQuery('#new_factory_name').val("");
jQuery('#new_factory_name').removeAttr("style");
jQuery('#field2').css("display","none");

jQuery('#new_factory_address').val("");
jQuery('#new_factory_address').removeAttr("style");
jQuery('#field3').css("display","none");

jQuery('#new_factory_country').val("");
jQuery('#new_factory_country').removeAttr("style");
jQuery('#field4').css("display","none");

jQuery('#new_factory_city').val("");
jQuery('#new_factory_city').removeAttr("style");
jQuery('#field5').css("display","none");
}


var id =[
'new_client_code_product',
'new_product_name',
'new_product_category',
'unit',
'new_po_number',
'new_model_number',
'new_brand',
'new_cmf',
'new_tech_specs',
'new_shipping_mark',
'new_additional_product_info',
];
function checked()
        {
          for(var x=0;x<=10;x++){
          jQuery('#'+id[x]+'').removeAttr("style");
		  jQuery('#'+id[x]+'').val("");
          }

          for(var x=1;x<=10;x++){
            jQuery('#productRequired'+x+'').css("display","none");
          }
        }


$('#client').on('change', function() {
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

</script>


{!!Form::close()!!}
