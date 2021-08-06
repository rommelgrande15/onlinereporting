{!!Form::open(['id'=>'new_inspection_form','data-parsley-validate'=>'', 'route'=>'saveinspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
<div class="row">
				

	<div class="col-md-12">
	<h4 class="heading">Inspection Details</h4>
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
		    {!! Form::label('service', 'Service') !!}
		    {!! Form::select('service', [
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
		    ], null, ['class' => 'form-control service psi_required psi_draft_required', 'placeholder'=>'Select a Service', 'id'=>'service', 'required'=>'']) !!}
	  	</div>
		 {{--  <div id="prod0" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
	</div>


	{{-- <div class="contact-select"> --}}
		<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('client', 'Select Client') !!}
					<select class="form-control psi_required client client_select psi_draft_required" id="client" name="client" required>.
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
			{!! Form::text('reference_number', null, ['class' => 'form-control reference_number psi_required psi_draft_required', 'id'=>'reference_number','required'=>'']) !!}
		</div>
	</div>

	

	<div class="contact-select">
		
		
		<div class="clone-inputs-contact-person">
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('contact_person', 'Contact Person') !!}
				{{-- <div class="input-group">
					<select class="form-control psi_required contact_persons" id="contact_person"  name="contact_person">
						<option value="1234" selected>Select Contact</option>
					</select>

					<div class="input-group-btn">
						<button class="btn btn-success contact_modal_button" onclick="cliks4()" type="button">
							<i class="fa fa-plus"></i>
						</button>
					</div>
				</div> --}}
				<select class="form-control psi_required contact_persons psi_draft_required" id="contact_person"  name="contact_person">
					<option value="" selected>Select Contact</option>
				</select>
			{{-- 	<div id="prod6" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
			    {!! Form::text('contact_person_number', null, ['class' => 'form-control psi_required numeric contact_number psi_draft_required','required'=>'','id'=>'contact_number']) !!}
		  	</div>
		{{-- 	  <div id="prod7" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
		</div>

		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('contact_person_email', 'Email Address') !!}
			    {!! Form::text('contact_person_email', null, ['class' => 'form-control psi_required contact_email psi_draft_required','id'=>'email_address']) !!}
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

		
<div class="col-md-6">
	<div class="form-group">
		{!! Form::label('client_project_number', 'Client Project Number') !!}
		{!! Form::text('client_project_number', null, ['class' => 'form-control  client_project_number psi_required psi_draft_required','required'=>'','id'=>'client_project_number']) !!}
		</div>
		{{-- <div id="prod2" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
</div>




<div class="col-md-6">
	<div class="form-group">
		{!! Form::label('inspection_date', 'Inspection Date') !!}
		{!! Form::text('inspection_date', null, ['class' => 'form-control psi_required inspection_date psi_draft_required', 'id'=>'inspection_date','required'=>'']) !!}
	  </div>
	{{--   <div id="prod3" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
</div>

	<div class="clone-inspector-container">
		<div class="clone-inspector">
			<div class="col-md-6">
				<div class="form-group">
				    {!! Form::label('inspector', 'Assign Inspector') !!}
				   {{--  {!! Form::select('inspector', $inspectors, null, ['class' => 'form-control psi_required select_address psi_draft_required','placeholder'=>'Select an Inspector','required'=>'']) !!} --}}
				   	<select class="form-control select_address psi_required psi_draft_required sel-inspector" name="inspector" id="inspector" required>
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
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('manday', 'Manday') !!}
			{!! Form::text('manday', 1, ['class' => 'form-control  manday psi_required psi_draft_required','required'=>'']) !!}
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
			{{-- <div class="input-group">
				<select class="form-control factory psi_required" name="factory" id="factory" required>
					<option value="" >Select Factory</option>
					@foreach($factories as $factory)
						<option value="{{$factory->id}}">{{$factory->factory_name}}</option>
					@endforeach
				</select>

				<div class="input-group-btn">
				  <button class="btn btn-success" type="button" onclick="cliks2()" data-toggle="modal" data-target="#newFactory">
				    <i class="fa fa-plus"></i>
				  </button>
				</div>
			</div> --}}
			<select class="form-control factory psi_required psi_draft_required" name="factory" id="factory" required>
				<option value="" >Select Factory</option>
				@foreach($factories as $factory)
					<option value="{{$factory->id}}">{{$factory->factory_name}}</option>
				@endforeach
			</select>
		{{-- 	<div id="prod11" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
	  	</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
		    {!! Form::label('factory_address', 'Factory Address') !!}
		    {!! Form::text('factory_address', null, ['class' => 'form-control psi_required factory_address psi_draft_required','required'=>'','id'=>'factory_address','readOnly'=>'true']) !!}
	  	</div>
		{{--   <div id="prod12" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
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

	{{-- <div class="col-md-4 fcp2" style="display:none;">
			<div class="form-group">
				<label for="factory_contact_person2">Factory Contact Person 2</label>
				<select class="form-control factory_contact_person2" id="factory_contact_person2_psi" name="factory_contact_person2_psi" >
					<option value="N/A">Select Contact Person</option>
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
									<select class="form-control psi_required product_name psi_draft_required" name="product_name" id="product_name" required>
										<option value="">Select Product</option>
										@foreach($products as $product)
											<option value="{{$product->id}}">{{$product->product_name}}</option>
										@endforeach
									</select>
						{{-- 			<div id="prod15" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								{!! Form::label('brand', 'Brand') !!}
								{!! Form::text('brand', null, ['class' => 'form-control brand psi_required psi_draft_required','required'=>'']) !!}
							</div>
						{{-- 	<div id="prod16" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
						</div>
						<div class="col-md-2">
							<div class="form-group">
								{!! Form::label('po_number', 'PO Number') !!}
								{!! Form::text('po_number', null, ['class' => 'form-control po_number psi_required psi_draft_required','required'=>'']) !!}
							</div>
						{{-- 	<div id="prod17" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
						</div>
						<div class="col-md-2">
							<div class="form-group">
								{!! Form::label('model_no', 'Model Number') !!}
								{!! Form::text('model_no', null, ['class' => 'form-control model_no psi_required psi_draft_required','required'=>'']) !!}
							</div>
							{{-- <div id="prod18" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
						</div>
						<div class="col-md-2 qty-modal">
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
							{{-- 	<div id="prod19" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
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
				{!! Form::textarea('requirement', null, ['class' => 'form-control psi_required requirement','rows'=>'4']) !!}
			</div>
		{{-- 	<div id="prod20" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('memo_psi', 'Memo / Notes') !!}
				{!! Form::textarea('memo_psi', null, ['class' => 'form-control psi_required memo_psi','rows'=>'4']) !!}
			</div>
		{{-- 	<div id="prod20" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
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

	{{-- <div class="row">
		<div class="col-md-12">
				<br/><label>Anti Bribery Etc and other files</label>
				<div class="file-clone">
					<div class="file-clone-inputs">
						<div class="input-group">
							<input type="file" class="form-control other_files" name="other_files">
							<div class="input-group-btn">
								<button class="btn btn-success btn_add_files" type="button" >
									<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div> --}}

		<div class="row">
				<div class="col-md-12">
						<div class="form-group">
							{!! Form::label('template', 'Select Type of Project') !!}<br/>
						{{-- 	<select class="form-control psi_required" name="project_type" id="project_type" required>
								<option value="" selected>Select type</option>
								<option value="app_project" selected>APP Project</option>
								<option value="word_project" selected>WORD Project</option>
							</select> --}}
							<label class="checkbox-inline">
								<input type="radio" name="project_type" value="null" id="app_project" class="psi_required" onclick="changeProjectType('app')" required> APP Project
							</label>
							<label class="checkbox-inline">
								<input type="radio" name="project_type" value="null" id="word_project" class="psi_required" onclick="changeProjectType('word')" required> WORD Project
							</label>
							{{-- <label class="checkbox-inline">
								<input type="radio" name="project_type" value="null" id="esprit_project" class="psi_required" onclick="changeProjectType('esprit')" required> ESPRIT Project
							</label> --}}

						</div>
					</div>
		</div>
	{{-- <div class="col-md-4 div_sub_service" style="display:none;">
		<div class="form-group">
				{{ Form::label('sub_service', 'Sub-service') }}
				{{ Form::select('sub_service', [
					'garments' => 'Garments',
				], null, ['class' => 'form-control sub_service sub_service_psi psi_required', 'placeholder'=>'Select a Sub-service', 'id'=>'sub_service', 'required'=>'']) }}
			</div>
	</div> --}}

	{{-- <div class="col-md-4 div_sub_service" style="display:none;">
		<div class="form-group">
				{{ Form::label('word_template', 'Word Template') }}
				{{ Form::select('word_template', [
					'psi-garmets' => 'PSI-Garments',
					'psi-decoration' => 'PSI-Decoration',
					'psi-electoronics' => 'PSI-Electoronics',
				], null, ['class' => 'form-control word_template', 'placeholder'=>'Select a Word Template', 'id'=>'word_template', 'required'=>'']) }}
			</div>
	</div> --}}

{{-- <div class="col-md-12" id="blank_report" style="display:none;">

	<div class="row">
			<div class="col-md-4">
					<div class="form-group">
						{{ Form::label('blank_report_type', 'Select Type of Blank Report') }}<br/>
						<label class="checkbox-inline">
							<input type="radio" name="blank_report_type" value="qr" id="report_qr" class="blank_report_type"  required> QR
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="blank_report_type" value="dr" id="report_dr" class="blank_report_type"  required> DR
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="blank_report_type" value="qr_dr" id="report_qr_dr" class="blank_report_type"  required> BOTH
						</label>

					</div>
				</div>
	</div>

</div> --}}


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




{{-- <div class="col-md-offset-9 col-md-3">
	{{ Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-psi-submit-draft','style'=>'margin-top: 5px;','type'=>'button']) }}
	{{ Form::button('Submit Inspection Details', ['class' => 'btn btn-success btn-block','id'=>'btn-psi-submit','style'=>'margin-top: 5px;','type'=>'button']) }}
</div> --}}

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



 /*  jQuery('#btn-psi-submit').click(function(e){
	checked();



 if(jQuery('.service').val()==""  ){
	alert("Service are Required");
}

else if(jQuery('.client_project_number').val()==""  ){
	alert("Client project number  are Required");
}
else if(jQuery('.inspection_date ').val()==""  ){
	alert("Inspection Date  are Required");
}

else if(jQuery('.client ').val()==""  ){
	alert("Client  are Required");
}
else if(jQuery('.reference_number  ').val()==""  ){
	alert("Reference number  are Required");
}
 

          for(var x=0;x<=21;x++)
              {
              if(jQuery('.'+id[x]+'').val()=="" || jQuery('.'+id[x]+'').val()==null || jQuery('.'+id[x]+'').val()=="1234" ){
                  jQuery('.'+id[x]+'').css('border-color', 'red');
                 jQuery('#prod'+x+'').css("display","block");
                  x=22;
                }
                else if(x==21){



                }
              }

				}); */
		jQuery('#btn-psi-submit').click(function(e){
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
		  }else{

		  }
		});
				

		/* jQuery('#btn-psi-submit-draft').click(function(e){
			
			var psi_draft_req=$('.psi_draft_required');
			var psi_req=$('.psi_required');
			var count_draft_null=0;
			for(var i = 0; i < psi_req.length; i++){
              	$(psi_req[i]).removeAttr("style");
			}
			for(var i = 0; i < psi_draft_req.length; i++){
            var data=$(psi_draft_req[i]).val();
            if(data==""){
			  $(psi_draft_req[i]).css("border","1px solid red");
			  count_draft_null+=1;
            }else{
              $(psi_draft_req[i]).removeAttr("style");
            }
		  }
		  if(count_draft_null==0){
			savePsiAsDraft();
		  }else{
			  alert("Please fill up the required fields");
		  }
			  
    	}); */

});


/* function savePsiAsDraft(){
		var form_data=new FormData();
		var service = $("#service").val();
        var reference_number = $("#reference_number").val();
        var inspection_date = $("#inspection_date").val();
        var client = $('#client').val();
        var inspector = $('#inspector').val();
        var factory = $('#factory').val();
        var factory_contact_person = $('#factory_contact_person').val();
		var requirement = $('#requirement').val();
		var memo = $('#memo_psi').val();
        var invisible = $('#invisible').val();
        var template = $('#template').val();
        if (template == "") { template = 0; }
        var client_project_number = $('#client_project_number').val();
        var factory_contact_person2_psi = $('#factory_contact_person2_psi').val();
        var sub_service = $('#sub_service').val();
        if (sub_service == "") { sub_service = "N/A"; }

        var type_of_project = $('input[name=project_type]:checked').val();
        var blank_report_type = $('input[name=blank_report_type]:checked').val();
        var word_template = $('#word_template').val();
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
            new_contact_person = $('#contact_person').val();
        } else {
            new_contact_person = new_contact_person + ',' + $('#contact_person').val();
        }
        var contact_person = new_contact_person;
        var product_name = [];
        var brand = [];
        var po_number = [];
        var model_no = [];
        var aql_qty = [];
        var aql_normal_level = [];
        var aql_special_level = [];
        var aql_major = [];
        var max_major = [];
        var aql_minor = [];
        var max_minor = [];
        var aql_normal_letter = [];
        var aql_normal_sampsize = [];
        var aql_special_letter = [];
        var aql_special_sampsize = [];

        $('.product_name').each(function(i, obj) {
            var val = $(this).val();
			product_name.push(val);
			form_data.append('product_name[]',val);
        });
        $('.brand').each(function(i, obj) {
            var val = $(this).val();
			brand.push(val);
			form_data.append('brand[]',val);
        });
        $('.po_number').each(function(i, obj) {
            var val = $(this).val();
			po_number.push(val);
			form_data.append('po_number[]',val);
        });
        $('.model_no').each(function(i, obj) {
            var val = $(this).val();
			model_no.push(val);
			form_data.append('model_no[]',val);
        });
        $('.aql_qty').each(function(i, obj) {
            var val = $(this).val();
			aql_qty.push(val);
			form_data.append('aql_qty[]',val);
        });

        $('.aql_normal_level').each(function(i, obj) {
            var val = $(this).val();
			aql_normal_level.push(val);
			form_data.append('aql_normal_level[]',val);
        });
        $('.aql_special_level').each(function(i, obj) {
            var val = $(this).val();
			aql_special_level.push(val);
			form_data.append('aql_special_level[]',val);
        });
        $('.aql_major').each(function(i, obj) {
            var val = $(this).val();
			aql_major.push(val);
			form_data.append('aql_major[]',val);
        });
        $('.max_major').each(function(i, obj) {
            var val = $(this).val();
			max_major.push(val);
			form_data.append('max_major[]',val);
        });
        $('.aql_minor').each(function(i, obj) {
            var val = $(this).val();
			aql_minor.push(val);
			form_data.append('aql_minor[]',val);
        });
        $('.max_minor').each(function(i, obj) {
            var val = $(this).val();
			max_minor.push(val);
			form_data.append('max_minor[]',val);
        });
        $('.aql_normal_letter').each(function(i, obj) {
            var val = $(this).val();
			aql_normal_letter.push(val);
			form_data.append('aql_normal_letter[]',val);
        });
        $('.aql_normal_sampsize').each(function(i, obj) {
            var val = $(this).val();
			aql_normal_sampsize.push(val);
			form_data.append('aql_normal_sampsize[]',val);
        });
        $('.aql_special_letter').each(function(i, obj) {
            var val = $(this).val();
			aql_special_letter.push(val);
			form_data.append('aql_special_letter[]',val);
        });
        $('.aql_special_sampsize').each(function(i, obj) {
            var val = $(this).val();
			aql_special_sampsize.push(val);
			form_data.append('aql_special_sampsize[]',val);
		});
		
		form_data.append('_token', token);
        form_data.append('service', service);
        form_data.append('reference_number', reference_number);
        form_data.append('inspection_date', inspection_date);
        form_data.append('client', client);
        form_data.append('inspector', inspector);
        form_data.append('factory', factory);
        form_data.append('factory_contact_person', factory_contact_person);
		form_data.append('requirement', requirement);
		form_data.append('memo',memo);
        form_data.append('invisible', invisible);
        form_data.append('template', template);
        form_data.append('client_project_number', client_project_number);
        form_data.append('factory_contact_person2_psi', factory_contact_person2_psi);
        form_data.append('sub_service', sub_service);
        form_data.append('type_of_project', type_of_project);
        form_data.append('word_template', word_template);
        form_data.append('blank_report_type', blank_report_type);
        form_data.append('contact_person', contact_person);

        $.ajax({
            url: '/savedraftinspection',
            type: 'POST',
            data: form_data,
			contentType: false,
    		processData: false,
            beforeSend: function() {
                $('.send-loading ').show();
            },
            success: function(response) {
                $('.send-loading ').hide();
                alert("Draft successfully saved");
                //window.location.href="/panel/1";
                document.location = './panel/' + auth_id;

            },
            error: function(error) {
                console.log(error);
            }
        });
} */

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

/* function cliks3(){
	jQuery('#aql_qty').removeAttr("style");
          jQuery('#aql_normal_level').removeAttr("style");
          jQuery('#aql_special_level').removeAttr("style");
          jQuery('#aql_major').removeAttr("style");
          jQuery('#max_major').removeAttr("style");
          jQuery('#aql_minor').removeAttr("style");
          jQuery('#max_minor').removeAttr("style");
          jQuery('#aql_normal_letter').removeAttr("style");
          jQuery('#aql_normal_sampsize').removeAttr("style");
          jQuery('#aql_special_letter').removeAttr("style");
          jQuery('#aql_special_sampsize').removeAttr("style");
          jQuery('#aql_qty').val("");
		  jQuery('#aql_normal_level').val("");
          jQuery('#aql_special_level').val("");
          jQuery('#aql_major').val("");
          jQuery('#max_major').val("");
          jQuery('#aql_minor').val("");
          jQuery('#max_minor').val("");
          jQuery('#aql_normal_letter').val("");
          jQuery('#aql_normal_sampsize').val("");
          jQuery('#aql_special_letter').val("");
          jQuery('#aql_special_sampsize').val("");

		  
          for(var x=1;x<=12;x++){
            jQuery('#aqlRequired'+x+'').css("display","none");
          }
} */

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
