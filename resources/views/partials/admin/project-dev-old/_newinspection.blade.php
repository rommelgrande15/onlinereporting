{!!Form::open(['id'=>'new_inspection_form','data-parsley-validate'=>'', 'route'=>'saveinspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
<div class="row">
				

	<div class="col-md-12">
	<h4 class="heading">Inspection Details</h4>
	<hr>
	</div>


	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('service', 'Service') !!}
		    {!! Form::select('service', [
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
		    ], null, ['class' => 'form-control service psi_required psi_draft_required', 'placeholder'=>'Select a Service', 'id'=>'service', 'required'=>'']) !!}
	  	</div>
	</div>


		<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('client', 'Select Client') !!}
					<select class="form-control psi_required client client_select psi_draft_required select-clients"  id="client" name="client" required>.
						<option value=""  >Select Client</option>
						{{-- @foreach($clients as $client)
							@if($client->client_status!=2 || $client->client_status!='2')
							<option value="{{$client->client_code}}">{{$client->Company_Name}}</option>
							@endif
						@endforeach --}}
					</select>

					<div id='clientResult'></div>
				</div>
		</div>

	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('reference_number', 'Reference / Report Number') !!}
			{!! Form::text('reference_number', null, ['class' => 'form-control reference_number psi_required psi_draft_required', 'id'=>'reference_number','required'=>'']) !!}
		</div>
	</div>

	

	<div class="contact-select">
			
		<div class="clone-inputs-contact-person">
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('contact_person', 'Contact Person') !!}
				<select class="form-control psi_required contact_persons psi_draft_required" id="contact_person"  name="contact_person">
					<option value="" selected>Select Contact</option>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
			    {!! Form::text('contact_person_number', null, ['class' => 'form-control psi_required numeric contact_number psi_draft_required','required'=>'','id'=>'contact_number']) !!}
		  	</div>
		</div>

		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_email', 'Email Address') !!}
			    {!! Form::text('contact_person_email', null, ['class' => 'form-control psi_required contact_email psi_draft_required','id'=>'email_address']) !!}
		  	</div>

		</div>
	
		<div id="add_more_contact_container">
		</div>

		<div class="col-md-12 show_client_c_p" style="display:none;" id="show_client_c_p">
			<div class="form-group">
				<button class="btn btn-success" type="button" id="add_more_client_c_p" >
					<i class="fa fa-plus"></i> Add More Contact Person
				</button>

		</div>
	</div>
</div>

		
<div class="col-md-4">
	<div class="form-group">
		{!! Form::label('client_project_number', 'Client Project Number') !!}
		{!! Form::text('client_project_number', null, ['class' => 'form-control  client_project_number psi_required psi_draft_required','required'=>'','id'=>'client_project_number']) !!}
		</div>

</div>




<div class="col-md-4">
	<div class="form-group">
		{!! Form::label('inspection_date', 'Inspection Date From') !!}
		{!! Form::text('inspection_date', null, ['class' => 'form-control psi_required inspection_date psi_draft_required', 'id'=>'inspection_date','required'=>'']) !!}
	  </div>

</div>

<div class="col-md-4">
	<div class="form-group">
		{!! Form::label('inspection_date_to', 'Inspection Date To') !!}
		{!! Form::text('inspection_date_to', null, ['class' => 'form-control psi_required inspection_date psi_draft_required']) !!}
	  </div>

</div>

	<div class="clone-inspector-container">
		<div class="clone-inspector">
			<div class="col-md-6">
				<div class="form-group">
				    {!! Form::label('inspector', 'Assign Inspector') !!}

				   	<select class="form-control select_address psi_required psi_draft_required sel-inspector select-inspectors" name="inspector" id="inspector" required>
						<option value="" >Select an Inspector</option>
						{{-- @foreach($inspectors_two as $inspectors)
							<option value="{{$inspectors->user_id}}">{!!$inspectors->name!!}&nbsp;&nbsp;&nbsp;({!!$inspectors->email_address!!})</option>
						@endforeach --}}
					</select>

					{{-- <br/>
						<div id='InspectoResult'></div> --}}
			  	</div>
			</div>
    		<div class="col-md-6">
				<div class="form-group">
				    {!! Form::label('inspector_address', 'Inspector Address') !!}
				    {!! Form::text('inspector_address', null, ['class' => 'form-control  inspector_address psi_required psi_draft_required insp-addr','required'=>'','id'=>'inspector_address','readOnly'=>'true']) !!}
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
	<div id="mandaySection" class="col-md-4">
		<div class="form-group">
			{!! Form::label('manday', 'Manday') !!}
			{!! Form::text('manday', 1, ['class' => 'form-control  manday psi_required psi_draft_required']) !!}
		</div>
	</div>


	<div id="fri-form" class="col-md-6" style="display: none;">
		<div class="form-group">
				{!! Form::label('FRI', 'FRI') !!}
			<select class="form-control select_address  sel-inspector" name="FRI" id="FRI" required>
				<option value="" >Select an Percentage</option>
				<option value="80%" >80%</option>
				<option value="100%" >100%</option>
			
			</select>
			</div>
		
	</div>


	<div id="spk-form" class="col-md-6" style="display: none;">
		<div class="form-group">
				{!! Form::label('SPK', 'SPK') !!}
			<select class="form-control select_address  sel-inspector" name="SPK" id="SPK" required>
				<option value="" >Select an Percentage</option>
				<option value="10%" >10%</option>
				<option value="80%" >80%</option>
			
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
			{!! Form::label('factory', 'Factory Name') !!}
			<select class="form-control factory psi_required psi_draft_required select-factories" name="factory" id="factory" required>
				<option value="" >Select Factory</option>
				{{-- @foreach($factories as $factory)
					<option value="{{$factory->id}}">{!!$factory->factory_name!!}</option>
				@endforeach --}}
			</select>
			<div id='factoryResult'></div>

	  	</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
		    {!! Form::label('factory_address', 'Factory Address') !!}
		    {!! Form::text('factory_address', null, ['class' => 'form-control psi_required factory_address psi_draft_required','required'=>'','id'=>'factory_address','readOnly'=>'true']) !!}
	  	</div>

	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="factory_contact_person">Factory Contact Person</label>
			<select class="form-control psi_required factory_contact_person psi_required psi_draft_required" id="factory_contact_person" name="factory_contact_person" >
				<option value="" >Select Contact Person</option>
			</select>
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('factory_contact_number', 'Contact Telephone Number (Factory)') !!}
		    {!! Form::text('factory_contact_number', null, ['class' => 'form-control psi_required numeric factory_contact_number psi_draft_required','required'=>'','id'=>'factory_contact_number','readOnly'=>'true']) !!}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('factory_email', 'Email Address') !!}
		    {!! Form::text('factory_email', null, ['class' => 'form-control psi_required factory_email psi_draft_required','required'=>'','id'=>'factory_email','readOnly'=>'true']) !!}
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
			<div class="col-md-12">
				<h4 class="heading">Product Details</h4>
			</div>

			{{-- <div class="col-md-6 text-right">
				<button class="btn btn-primary" type="button" data-toggle="modal" onclick="checked()" data-target="#newProduct">
					<i class="fa fa-plus"></i> Add New Product
				</button>
			
			</div> --}}
		</div>


		<hr>
	</div>
	<div class="col-md-12 products-list">
		<div class="product_row">
			<div class="group-body">
				<div class="row product-clone">
					<div class="clone-inputs">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group" style="margin-left:18px;">
									{!! Form::label('product_name', 'Product Name') !!}									
									{!! Form::text('product_name', null, ['class' => 'form-control product_name psi_required psi_draft_required']) !!}

										{{-- <select class="form-control psi_required product_name psi_draft_required" name="product_name" id="product_name" required>
											<option value="">Select Product</option>
											@foreach($products as $product)
												<option value="{{$product->id}}">{{$product->product_name}}</option>
											@endforeach
										</select> --}}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="new_product_category">Product Category</label><span class="error_messages category_error"></span>
									<select class="form-control product_category categories product_input" id="new_product_category" name="new_product_category" required data-parsley-required-message="Please select a product category!" data-parsley-errors-container=".category_error">
										<option selected="selected" value="">Select a Category</option>
									</select>
								</div>
							</div>	
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('p_unit', 'Unit') !!}
								<select class="form-control p_unit psi_required psi_draft_required" id="p_unit" name="p_unit" >
									<option value="">Select Unit</option>
									<option value="piece">Piece/s</option>
									<option value="roll">Roll/s</option>
									<option value="set">Set/s</option>
									<option value="pair">Pair/s</option>
									<option value="piece">Box/es</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('brand', 'Brand') !!}
								{!! Form::text('brand', null, ['class' => 'form-control brand psi_required psi_draft_required']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('po_number', 'PO Number') !!}
								{!! Form::text('po_number', null, ['class' => 'form-control po_number psi_required psi_draft_required']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('model_no', 'Model Number') !!}
								{!! Form::text('model_no', null, ['class' => 'form-control model_no psi_required psi_draft_required']) !!}
							</div>
						</div>
					{{-- 	<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('cmf', 'Color/Material/Finish') !!}
								{!! Form::text('cmf', null, ['class' => 'form-control cmf psi_required psi_draft_required']) !!}
							</div>
						</div> --}}
					{{-- 	<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('technical', 'Technical Specifications') !!}
								{!! Form::text('technical', null, ['class' => 'form-control technical psi_required psi_draft_required']) !!}
							</div>
						</div> --}}
						{{-- <div class="col-md-4">
							<div class="form-group">
								{!! Form::label('shipping', 'Shipping Mark') !!}
								{!! Form::text('shipping', null, ['class' => 'form-control shipping psi_required psi_draft_required']) !!}
							</div>
						</div> --}}
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('prod_addtl_info', 'Additional Information') !!}
								{!! Form::text('prod_addtl_info', null, ['class' => 'form-control prod_addtl_info psi_required psi_draft_required']) !!}
							</div>
						</div>
						<div class="col-md-4 qty-modal">
							<div class="form-group">
								{!! Form::label('qty', 'Qty') !!}
								<div class="input-group">
									<input type="text" class="form-control qty psi_required psi_draft_required" name="qty" id="qty" readonly required>
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
			<h4 class="heading">Inspector Cost</h4>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_currency', 'Currency') !!}
				<select class="form-control ins_currency psi_required" name="ins_currency" id="ins_currency" required>
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

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('Inspector_Total_Cost', 'Inspector total cost') !!}
				{!! Form::number('Inspector_Total_Cost', 0, ['class' => 'form-control Inspector_Total_Cost','required'=>'','readOnly'=>'true']) !!}
			</div>
		</div>
	</div>
	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Client Cost</h4>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_currency', 'Currency') !!}
				<select class="form-control cli_currency psi_required" name="cli_currency" id="cli_currency" required>
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
				{!! Form::number('cli_md_charge', 0, ['class' => 'form-control cli_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_travel_cost', 'Travel Cost') !!}
				{!! Form::number('cli_travel_cost', 0, ['class' => 'form-control cli_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('cli_hotel_cost', 0, ['class' => 'form-control cli_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_ot_cost', 'OT Cost') !!}
				{!! Form::number('cli_ot_cost', 0, ['class' => 'form-control cli_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="cli_other_cost_container">
		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="add_cli_other_cost">
				<i class="fa fa-plus"></i> Add Other Cost
			</button>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_Total_Cost', 'Client total cost') !!}
				{!! Form::number('cli_Total_Cost', 0, ['class' => 'form-control cli_Total_Cost','required'=>'','readOnly'=>'true']) !!}
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('requirement', 'Requirements') !!}
				{!! Form::textarea('requirement', null, ['class' => 'form-control psi_required requirement','rows'=>'4']) !!}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('memo_psi', 'Memo / Notes') !!}
				{!! Form::textarea('memo_psi', null, ['class' => 'form-control psi_required memo_psi','rows'=>'4']) !!}
			</div>
		</div>
	</div>

	<div class="row">
	<div class="col-md-12">
			<label>Blank reports, TIC anti-bribery declaration,Onsite quick report, TIC Inspection rules, TIC Inspection criteria-General Merchandise, Product photos and other attachment</label>
			<div class="col-md-12 dropzone-container file_upload_psi" id="file_upload_container">
						<div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
						<div class="fallback">
								<input name="file[]" class="psi_required joe file" type="file" id="file" multiple required />
						</div>
	
			</div>
		</div>
	</div>	


		<div class="row">
				<div class="col-md-12">
						<div class="form-group">
							{!! Form::label('template', 'Select Type of Project') !!}<br/>
							<label class="checkbox-inline">
								<input type="radio" name="project_type" value="null" id="app_project" class="" onclick="changeProjectType('app')" required> APP Project
							</label>
							<label class="checkbox-inline">
								<input type="radio" name="project_type" value="null" id="word_project" class="" onclick="changeProjectType('word')" required> WORD Project
							</label>


						</div>
					</div>
		</div>



<div class="row" id="div_template" style="display:none;">
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('template', 'Select App Template') !!}
			<select class="form-control select-templates" name="template" id="template" required>
				<option value="" selected>Select App Template</option>
				{{-- @foreach($templates as $template)
					<option value="{{$template->id}}">{{$template->name}}</option>
				@endforeach --}}
			</select>
		</div>
	</div>
	<div class="col-md-12">
		<label title="Checking this means the report is complex.">
			<input type="checkbox" id="complex_report" name="complex_report" value="0"> Complex Report (Check if complex, leave blank if not).
		</label>
	</div>

	{{-- <div class="col-md-4">
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
	</div> --}}

</div>

</div>

<div class="row">
<div class="col-md-offset-9 col-md-3">
	<br/>
		{!! Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-psi-submit-draft','type'=>'button']) !!}
		{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block','id'=>'btn-psi-submit','type'=>'button']) !!}

	</div>
</div>


<script type="text/javascript">
    $( function() {
    	$("#inspection_date").datepicker({  
			dateFormat:"yy-mm-dd",
            onSelect: function (date) {
                var date2 = $('#inspection_date').datepicker('getDate');
                date2.setDate(date2.getDate());

				$('#inspection_date_to').datepicker('option', 'minDate', date2);
				

				var dt1 = $('#inspection_date').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#inspection_date_to').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#inspection_date_to').datepicker('option', 'minDate');
                    $('#inspection_date_to').datepicker('setDate', minDate);
				}
				
				
            }
        });
        $('#inspection_date_to').datepicker({
			dateFormat:"yy-mm-dd",
            onClose: function () {
                var dt1 = $('#inspection_date').datepicker('getDate');
                console.log(dt1);
                var dt2 = $('#inspection_date_to').datepicker('getDate');
                if (dt2 <= dt1) {
                    var minDate = $('#inspection_date_to').datepicker('option', 'minDate');
                    $('#inspection_date_to').datepicker('setDate', minDate);
                }
            }
		});
		$('#complex_report').click(function(){
			if ($('#complex_report').prop('checked')==true) { 
				$('#complex_report').val('1');
			}else{
				$('#complex_report').val('0');
			}
		});
  	});
  </script>
<script>
	function Inspector_Total_Cost_New2(){
		var ins_md_charge=jQuery('#cli_md_charge').val();
		var ins_travel_cost=jQuery('#cli_travel_cost').val();
		var ins_hotel_cost=jQuery('#cli_hotel_cost').val();
		var ins_ot_cost=jQuery('#cli_ot_cost').val();
		var total =0;
		var othercost2 =0;	
		var ins_other_cost_value  = jQuery('.cli_other_cost_value');
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
	
		jQuery('#cli_Total_Cost').val(total)
	
	}
	
	function Inspector_Total_Cost_New(){
		var ins_md_charge=jQuery('#ins_md_charge').val();
		var ins_travel_cost=jQuery('#ins_travel_cost').val();
		var ins_hotel_cost=jQuery('#ins_hotel_cost').val();
		var ins_ot_cost=jQuery('#ins_ot_cost').val();
		var total =0;
		var othercost=0;
	
		var ins_other_cost_value  = jQuery('.ins_other_cost_value');
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
	
		jQuery('#Inspector_Total_Cost').val(total)
	
	}
	</script>

<script>


function Inspector_Total_Cost_New(){
	var ins_md_charge=jQuery('#ins_md_charge').val();
	var ins_travel_cost=jQuery('#ins_travel_cost').val();
	var ins_hotel_cost=jQuery('#ins_hotel_cost').val();
	var ins_ot_cost=jQuery('#ins_ot_cost').val();
	var total =0;
	var othercost =0;

	var ins_other_cost_value  = jQuery('.ins_other_cost_value');
var inspector_other_cost_value  = [];

for(var i = 0; i < ins_other_cost_value.length; i++){
            var g_data=$(ins_other_cost_value[i]).val();
						if(i=0){
							othercost=parseInt(g_data);
						}else{
							othercost=othercost+parseInt(g_data);
						}
            
           
          }
console.log(othercost);
	total=parseInt(ins_md_charge)+parseInt(ins_travel_cost)+parseInt(ins_hotel_cost)+parseInt(ins_ot_cost)+parseInt(othercost);

	jQuery('#Inspector_Total_Cost').val(total)

}
</script>
<script>


jQuery(document).ready(function(){

jQuery('#ins_md_charge').val(0);
jQuery('#ins_travel_cost').val(0);
jQuery('#ins_hotel_cost').val(0);
jQuery('#ins_ot_cost').val(0);

$('#ins_md_charge,#ins_travel_cost,#ins_hotel_cost,#ins_ot_cost').on('change', function() {
	Inspector_Total_Cost_New()
});


$('#cli_md_charge,#cli_travel_cost,#cli_hotel_cost,#cli_ot_cost').on('change', function() {
	Inspector_Total_Cost_New2()
});




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
	getProductByClientCode('client');
	}else{
		$('#reference_number').val("");
	}
	
});





$( "#ins_md_charge" ).keyup(function() {
	Inspector_Total_Cost_New();
});


$( "#ins_travel_cost" ).keyup(function() {
	Inspector_Total_Cost_New();
});
$( "#ins_hotel_cost" ).keyup(function() {
	Inspector_Total_Cost_New();
});
$( "#ins_ot_cost" ).keyup(function() {
	Inspector_Total_Cost_New();
});

		/* jQuery('#btn-psi-submit').click(function(e){
			var psi_req=$('.psi_required');
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
			console.log(psi_req);
		  }else{

		  }
		}); */
				


});



/* $('#client').on('change', function() {
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
	
}); */

function getProductByClientCode(select_id){
	var client_code=$('#'+select_id).val();
	$.ajax({
    	type: "GET",
    	url: '/getproductbyclientcode/'+client_code,
    	success: function(data) {					
			console.log(data);	
			$('.product_name').empty();
			$('.product_name').append('<option value="">Select Product</option>');		
			data.products.forEach(element => {
				$('.product_name').append('<option value="' + element.id + '">' + element.product_name + '</option>');
			});
    	}
    });
}



</script>


{!!Form::close()!!}
