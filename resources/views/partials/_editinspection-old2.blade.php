{!!Form::open(['id'=>'new_inspection_form','data-parsley-validate'=>'', 'route'=>'edited-draft-inspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
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
		    	'cbpi' => 'CBPI - No Serial',
		    	'cbpi_serial' => 'CBPI - with Serial',
				'cbpi_isce' => 'CBPI - ISCE',
				'site_visit' => 'Site Visit',
                'SPK' => 'SPK',
                'FRI' => 'FRI',
				], $inspection_details->service, ['class' => 'form-control service psi_required psi_draft_required', 'placeholder'=>'Select a Service', 'id'=>'service', 'required'=>'', 'disabled'=>'']) !!}
	  	</div>
	</div>
	
	<div class="contact-select">
	<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('client', 'Select Client') !!}
				@if($inspection_details->client_book=='true')
					<select class="form-control psi_required client client_select psi_draft_required" id="client" name="client" required disabled>.
				@else
					<select class="form-control psi_required client client_select psi_draft_required" id="client" name="client" required>.
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
					<input type="text" name="reference_number" id="reference_number" class="form-control reference_number psi_required psi_draft_required" value="{{$inspection_details->reference_number}}" required>
				</div>
		</div>
		
		<div class="clone-inputs-contact-person">
			@foreach($contact_person_list as $index=>$contact) 
				@if ($index==0)
					<div class="col-md-4">
						<div class="form-group">
							{!! Form::label('contact_person', 'Contact Person ') !!}
							<select class="form-control psi_required contact_persons psi_draft_required" id="contact_person"  name="contact_person">

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
									{!! Form::text('contact_person_number', $cc->contact_number, ['class' => 'form-control psi_required numeric contact_number psi_draft_required',			'required'=>'','id'=>'contact_number']) !!}
								@endif
								@endforeach
						
					  	</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							{!! Form::label('contact_person_email', 'Email Address') !!}

								@foreach($client_contacts as $cc) 
								@if($cc->id==$contact)
									{!! Form::text('contact_person_email', $cc->email_address, ['class' => 'form-control psi_required contact_email psi_draft_required',		'id'=>'email_address']) !!}
								@endif
								@endforeach
						  </div>
					</div>
		@else
		<div class="am_cp_parent">
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('contact_person', 'Contact Person ') !!}
					<select class="form-control psi_required contact_persons added_contact_persons psi_draft_required" id="contact_person"  name="contact_person">
						
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
						{!! Form::label('contact_person_number', 'Contact Number') !!}
						@foreach($client_contacts as $cc) 
						@if($cc->id==$contact)
							{!! Form::text('contact_person_number', $cc->contact_number, ['class' => 'form-control psi_required numeric contact_number psi_draft_required','required'=>'','id'=>'contact_number']) !!}
						@endif
						@endforeach
				  
				  </div>
			</div>
			
			<div class="col-md-4">
				<div class="form-group">
					<label>Email Address</label>
					<div class="input-group">
						<input type="text" class= "form-control psi_required numeric am_contact_email psi_draft_required" value="{{$cc->email_address}}" required>
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
	
		<div id="add_more_contact_container">
		</div>

			<div class="col-md-12 show_client_c_p" id="show_client_c_p">
				<div class="form-group">
					<button class="btn btn-success" type="button" id="add_more_client_c_p" >
						<i class="fa fa-plus"></i> Add More Contact Person
					</button>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label>Client Project Number</label>
					<input type="text" name="client_project_number" id="client_project_number" class="form-control client_project_number psi_required psi_draft_required" value="{{$inspection_details->client_project_number}}" required>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Inspection Date From</label>
					<input type="text" name="inspection_date" id="inspection_date" class="form-control inspection_date psi_required psi_draft_required" value="{{$inspection_details->inspection_date}}" required>
			  	</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Inspection Date To</label>
					<input type="text" name="inspection_date_to" id="inspection_date_to" class="form-control inspection_date psi_required psi_draft_required" value="{{$inspection_details->inspection_date_to}}" required>
			  	</div>
			</div>
		</div>

		<div class="clone-inspector-container">
			<div class="clone-inspector">
				<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('inspector', 'Assign Inspector') !!}
					   {{--  {!! Form::select('inspector', $inspectors, $inspection_details->inspector_id, ['class' => 'form-control psi_required select_address psi_draft_required sel-inspector','placeholder'=>'Select an Inspector','required'=>'']) !!} --}}
					   <select class="form-control psi_required select_address psi_draft_required sel-inspector" name="inspector" id="inspector" required>
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
							<input type="text" name="inspector_address" id="inspector_address" class="form-control inspector_address psi_required psi_draft_required insp-addr" value="{{$inspector_info->address}}" required >
				  	</div>
				</div>
			</div>
			@foreach($other_inspector as $other)
				@if($other=='null' || $other==null)
				@else
					<div class="clone-inspector">
						<div class="col-md-6">
							<div class="form-group">
							    {!! Form::label('inspector_sec', 'Assign Inspector') !!}
								{{-- {!! Form::select('inspector_sec', $inspectors, $inspection_details->inspector_id, ['class' => 'form-control psi_required psi_draft_required sel-inspector sel-added-inspector','placeholder'=>'Select an Inspector','required'=>'']) !!} --}}
								<select id="inspector_sec" name="inspector_sec" class="form-control psi_required psi_draft_required sel-inspector sel-added-inspector">
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
									<input type="text" name="inspector_address" id="inspector_address" class="form-control psi_required psi_draft_required added-inspector-address" 	value="{{$inspector_info->address}}" required >
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
	<div class="col-md-12">
			<button type="button" class="btn btn-success pull-left" id="add_inspector">
				<i class="fa fa-plus"></i> Add Other Inspector
			</button>
		</div>

		
				@if($inspection_details->service=="FRI"|| $inspection_details->service=="SPK")
				<div class="col-md-6">
				@else
				<div class="col-md-4">
				@endif
				<div class="form-group">
					{!! Form::label('manday', 'Manday') !!}
					{!! Form::text('manday', $inspection_details->manday, ['class' => 'form-control  manday psi_required psi_draft_required','required'=>'']) !!}
				</div>
			</div>

			
			@if($inspection_details->service=="FRI")						
				<div id="fri-form" class="col-md-6" >
					<div class="form-group">
						{!! Form::label('FRI', 'FRI') !!}
						<select class="form-control  psi_required" name="FRI" id="FRI" required>
							<option @if($inspection_details->percentageFriSpk=="80%") selected='selected' @endif value="80%" >80%</option>
							<option @if($inspection_details->percentageFriSpk=="100%") selected='selected' @endif value="100%" >100%</option>			
						</select>
					</div>					
				</div>
			@endif
			@if($inspection_details->service=="SPK")
				<div id="spk-form" class="col-md-6" >
					<div class="form-group">
						{!! Form::label('SPK', 'SPK') !!}
						<select class="form-control psi_required" name="SPK" id="SPK" required>
							<option @if($inspection_details->percentageFriSpk=="10%") selected='selected' @endif value="10%" >10%</option>
							<option  @if($inspection_details->percentageFriSpk=="80%") selected='selected' @endif value="80%" >80%</option>
						</select>
					</div>				
				</div>
			@endif




	
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
					@if($factory->id==$inspection_details->factory_id)
						<option value="{{$factory->id}}" selected>{{$factory->factory_name}}</option>
					@else
						<option value="{{$factory->id}}">{{$factory->factory_name}}</option>
					@endif
				@endforeach
			</select>
		{{-- 	<div id="prod11" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
	  	</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
		  {{--   {{ Form::label('factory_address', 'Factory Address') }}
				{{ Form::text('factory_address', null, ['class' => 'form-control psi_required factory_address','required'=>'','id'=>'factory_address']) }} --}}
				<label>Inspector Address</label>
				<input type="text" name="factory_address" id="factory_address" class="form-control factory_address psi_required psi_draft_required" value="{{$factory_info->factory_address}}" required >
	  	</div>
		{{--   <div id="prod12" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="factory_contact_person">Factory Contact Person</label>
			<select class="form-control psi_required factory_contact_person psi_draft_required" id="factory_contact_person" name="factory_contact_person" >
				{{-- <option value="" >Select Contact Person</option> --}}
				@foreach($factory_contactlist as $contact)			
					@if($contact->id==$inspection_details->factory_contact_person)
						<option value="{{$contact->id}}" selected>{{$contact->factory_contact_person}}</option>
					@else
						<option value="{{$contact->id}}" >{{$contact->factory_contact_person}}</option>
					@endif
				@endforeach
			</select>
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('factory_contact_number', 'Contact Telephone Number (Factory)') !!}
		    {!! Form::text('factory_contact_number', $factory_contact1->factory_contact_number, ['class' => 'form-control psi_required numeric factory_contact_number psi_draft_required','required'=>'','id'=>'factory_contact_number']) !!}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
		    {!! Form::label('factory_email', 'Email Address') !!}
		    {!! Form::text('factory_email', $factory_contact1->factory_email, ['class' => 'form-control psi_required factory_email psi_draft_required','required'=>'','id'=>'factory_email']) !!}
	  	</div>

	</div>
	@if($inspection_details->factory_contact_person2=="" || $inspection_details->factory_contact_person2=="N/A" || $inspection_details->factory_contact_person2=="0" || $inspection_details->factory_contact_person2==0 || $inspection_details->factory_contact_person2==null)
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
		
	@else
	<div class="fcp_container">
		@foreach($fac_contact_person_list as $fcpl)
			<div class="clone_fcp">
				<div class="col-md-4">
						<div class="form-group">
							<label for="fcp_sel">Factory Contact Person</label>
							<select class="form-control fcp_sel factory_contact_added">
								<option value="" >Select Contact Person</option>
								@foreach($factory_contactlist as $fc)			
									@if($fc->id==$fcpl)
										<option value="{{$fc->id}}" selected>{{$fc->factory_contact_person}}</option>
									@else
										<option value="{{$fc->id}}" >{{$fc->factory_contact_person}}</option>
									@endif
								@endforeach	
							</select>
						  </div>
				</div>
				<div class="col-md-4">
						<div class="form-group">
							{!! Form::label('factory_contact_number_added', 'Contact Telephone Number (Factory)') !!}
								@foreach($factory_contactlist as $fc)			
									@if($fc->id==$fcpl)
										{!! Form::text('factory_contact_number_added', $fc->factory_tel_number, ['class' => 'form-control factory_contact_number_added',	'required'=>'']) !!}
									@endif
								@endforeach	

						  </div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('factory_email_added', 'Email Address') !!}
						<div class="input-group">

							@foreach($factory_contactlist as $fc)			
								@if($fc->id==$fcpl)
								{!! Form::text('factory_email_added', $fc->factory_email, ['class' => 'form-control factory_email_added ','required'=>'']) !!}
								@endif
							@endforeach	
						
							<div class="input-group-btn">
							  <button class="btn btn-danger rm_fcp" type="button">
								<i class="fa fa-times"></i>
							  </button>
							</div>
						</div> 
					</div>
				</div>
			</div>
		@endforeach	
	</div>
	@endif

		<div class="col-md-12 show_fac_c_p" id="show_fac_c_p">
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
				<button class="btn btn-primary" type="button" data-toggle="modal"  data-target="#newProduct">
					<i class="fa fa-plus"></i> Add New Product
				</button>
			
			</div>
		</div>


		<hr>
	</div>
	<div class="col-md-12 products-list">
		<div class="product_row">
			<div class="group-body">
				<div class="row product-clone-edit">
					@foreach ($psi_product as $product)
					<div class="clone-inputs-edit">					
						<input type="hidden" name="hidden_product_id" class="hidden_product_id" value="{{$product->id}}">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group" style="margin-left:18px;">
									{!! Form::label('product_name', 'Product Name') !!}
									<select class="form-control psi_required product_name psi_draft_required" name="product_name" id="product_name" required>
										@foreach ($products as $prod)
											@if($prod->id==$product->product_name)
											<option value="{{$prod->id}}">{{$prod->product_name}}</option>
											@else
											@endif
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('p_unit', 'Unit') !!}
								{!! Form::select('p_unit', [
									'piece' => 'Piece/s',
		    						'roll' => 'Roll/s',
		    						'set' => 'Set/s',
		    						'pair' => 'Pair/s',
		    						'box' => 'Box/es',
		    						], $product->product_unit, ['class' => 'form-control service psi_required psi_draft_required', 'placeholder'=>'Select pieces']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('brand', 'Brand') !!}
								{!! Form::text('brand', $product->brand, ['class' => 'form-control brand psi_required psi_draft_required','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('po_number', 'PO Number') !!}
								{!! Form::text('po_number', $product->po_no, ['class' => 'form-control po_number psi_required psi_draft_required','required'=>'']) !!}
							</div>

					 	</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('model_no', 'Model Number') !!}
								{!! Form::text('model_no', $product->model_no, ['class' => 'form-control model_no psi_required psi_draft_required','required'=>'']) !!}
							</div>					
						</div>

					{{--	<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('cmf', 'Color/Material/Finish') !!}
								{!! Form::text('cmf', $product->cmf, ['class' => 'form-control cmf psi_required psi_draft_required']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('technical', 'Technical Specifications') !!}
								{!! Form::text('technical', $product->tech_specs, ['class' => 'form-control technical psi_required psi_draft_required']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('shipping', 'Shipping Mark') !!}
								{!! Form::text('shipping', $product->shipping_mark, ['class' => 'form-control shipping psi_required psi_draft_required']) !!}
							</div>
						</div> --}}


						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('prod_addtl_info', 'Additional Information') !!}
								{!! Form::text('prod_addtl_info', $product->additional_product_info, ['class' => 'form-control prod_addtl_info psi_required psi_draft_required']) !!}
							</div>
						</div>
						<div class="col-md-4 qty-modal">
							<div class="form-group">
								{!! Form::label('qty', 'Qty') !!}
								<div class="input-group">
								<input type="text" class="form-control qty psi_required edit_qty psi_draft_required" name="qty" id="qty" readonly required value="{{$product->aql_qty}}">
									<div class="input-group-btn">
										<button class="btn btn-success btn-qty-modal-edit" type="button" data-id="{{$product->id}}">
											<i class="fa fa-plus"></i>
										</button>
									</div>

								</div>

							</div>
							@include('partials._editaqlmodal')
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<br/>
									<button type="button" class="btn btn-danger btn-rm-edit-product" data-id="{{$product->id}}" style="margin-left:20px; margin-top:-40px;"><i class="fa fa-times"></i> Remove Product</button>
								</div>
							</div>
						</div>	
						
					</div>
					@endforeach
				</div>

				<div class="row product-clone">
					<div class="clone-inputs" style="display:none;">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group" style="margin-left:18px;">
									{!! Form::label('product_name', 'Product Name') !!}
										<select class="form-control  new_product_name" name="new_product_name" id="new_product_name" required>
											<option value="">Select Product</option>
											@foreach($products as $product)
												<option value="{{$product->id}}">{{$product->product_name}}</option>
											@endforeach
										</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('new_p_unit', 'Unit') !!}
								{!! Form::select('new_p_unit', [
									'' => 'Select pieces',
									'piece' => 'Piece/s',
		    						'roll' => 'Roll/s',
		    						'set' => 'Set/s',
		    						'pair' => 'Pair/s',
		    						'box' => 'Box/es',
		    						], null, ['class' => 'form-control new_p_unit  ', 'placeholder'=>'Select pieces']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('new_brand', 'Brand') !!}
								{!! Form::text('new_brand', null, ['class' => 'form-control new_brand ','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('new_po_number', 'PO Number') !!}
								{!! Form::text('new_po_number', null, ['class' => 'form-control new_po_number ','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('new_model_no', 'Model Number') !!}
								{!! Form::text('new_model_no', null, ['class' => 'form-control new_model_no ','required'=>'']) !!}
							</div>
						</div>



						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('new_prod_addtl_info', 'Additional Information') !!}
								{!! Form::text('new_prod_addtl_info', null, ['class' => 'form-control new_prod_addtl_info ']) !!}
							</div>
						</div>
						<div class="col-md-4 qty-modal">
							<div class="form-group">
								{!! Form::label('qty', 'Qty') !!}
								<div class="input-group">
									<input type="text" class="form-control qty " name="qty" id="qty" readonly required>
									<div class="input-group-btn">
										<button class="btn btn-success btn-qty-modal" type="button" >
											<i class="fa fa-plus"></i>
										</button>
									</div>

								</div>
							</div>
							
							@include('partials._aqldraftmodal')
						</div>
					</div>
				</div>
			
				


			</div>
		</div>
	</div>

		{{-- @include('partials._newinspectionmodal') --}}
	
	<div class="col-md-3 pull-right">
			<button type="button" class="btn btn-success pull-right" id="btn_product_edit">
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
				<select class="form-control ins_currency" name="ins_currency" id="ins_currency" required>
					{{-- <option value="" selected>Select Currency</option>
					<option value="usd">($) Us Dollar</option>
					<option value="eur">(€) Euro</option>
					<option value="gbp">(£) British Pound</option>
					<option value="inr">(₹) Indian Rupee</option>
					<option value="myr">(RM) Malaysian Ringgit</option>
					<option value="cny">(¥) Chinese Yuan Renminbi</option> --}}
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
				{!! Form::label('ins_md_charge', 'MD Charges') !!}
				{!! Form::number('ins_md_charge', $inspector_cost->md_charges, ['class' => 'form-control ins_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_travel_cost', 'Travel Cost') !!}
				{!! Form::number('ins_travel_cost', $inspector_cost->travel_cost, ['class' => 'form-control ins_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('ins_hotel_cost', $inspector_cost->hotel_cost, ['class' => 'form-control ins_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_ot_cost', 'OT Cost') !!}
				{!! Form::number('ins_ot_cost', $inspector_cost->ot_cost, ['class' => 'form-control ins_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="ins_other_cost_container">
			@foreach($ins_other_cost_array as $key => $value)
				@if(count($ins_other_cost_array)>1)
					<div class="ins_cost_div">
						<div class="col-md-6">
							<div class="form-group">
								<label>Other Cost Description</label>
							<input type="text" class="form-control ins_other_cost_text psi_required" placeholder="Enter description cost here" value="{{$key}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cost</label>
								<div class="input-group">
									<input type="number" class="form-control ins_other_cost_value psi_required" value="{{$value}}">
									<div class="input-group-btn">
										<button class="btn btn-danger del_added_insp_cost" type="button">
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
			<button type="button" class="btn btn-success pull-left" id="add_insp_other_cost">
				<i class="fa fa-plus"></i> Add Other Cost
			</button>
		</div>
	</div>
	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Client Cost</h4>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_currency', 'Currency') !!}
				<select class="form-control cli_currency" name="cli_currency" id="cli_currency" required>
					{{-- <option value="usd">($) Us Dollar</option>
					<option value="eur">(€) Euro</option>
					<option value="gbp">(£) British Pound</option>
					<option value="inr">(₹) Indian Rupee</option>
					<option value="myr">(RM) Malaysian Ringgit</option>
					<option value="cny">(¥) Chinese Yuan Renminbi</option> --}}
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
				{!! Form::label('cli_md_charge', 'MD Charges') !!}
				{!! Form::number('cli_md_charge', $client_cost->md_charges, ['class' => 'form-control cli_md_charge','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_travel_cost', 'Travel Cost') !!}
				{!! Form::number('cli_travel_cost', $client_cost->travel_cost, ['class' => 'form-control cli_travel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_hotel_cost', 'Hotel Cost') !!}
				{!! Form::number('cli_hotel_cost',  $client_cost->hotel_cost, ['class' => 'form-control cli_hotel_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_ot_cost', 'OT Cost') !!}
				{!! Form::number('cli_ot_cost', $client_cost->ot_cost, ['class' => 'form-control cli_ot_cost','required'=>'']) !!}
			</div>
		</div>
		<div class="cli_other_cost_container">
			@foreach($client_other_cost_array as $key => $value)
				@if(count($client_other_cost_array)>1)
					<div class="cli_cost_div">
						<div class="col-md-6">
							<div class="form-group">
								<label>Other Cost Description</label>
							<input type="text" class="form-control cli_other_cost_text psi_required" placeholder="Enter description cost here" value="{{$key}}">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Cost</label>
								<div class="input-group">
									<input type="number" class="form-control cli_other_cost_value psi_required" value="{{$value}}">
									<div class="input-group-btn">
										<button class="btn btn-danger del_added_cli_cost" type="button">
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
				{!! Form::textarea('requirement', $inspection_details->requirement, ['class' => 'form-control psi_required requirement','rows'=>'4']) !!}
			</div>
		{{-- 	<div id="prod20" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('memo_psi', 'Memo / Notes') !!}
				{!! Form::textarea('memo_psi', $inspection_details->memo, ['class' => 'form-control psi_required memo_psi','rows'=>'4']) !!}
			</div>
		{{-- 	<div id="prod20" style="display:none" ><p style="color:red;">This field is required! </p></div> --}}
		</div>
	</div>


	<div class="row">
	<div class="col-md-12">
			<label>Blank reports and other attachment</label>
			<div class="col-md-12 dropzone-container file_upload_psi" id="file_upload_container">
						<div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
						<div class="fallback">
								<input name="file[]" class="psi_required joe file" type="file" id="file" multiple required />
						</div>
	
			</div>
		</div>
	</div>	


	<div class="col-md-12">
		{{-- <div class="row">
			<div class="col-md-6">
				<h4 class="heading">Type of Project</h4>
				<br/>
			</div>
		</div> --}}
		<div class="row">
				<div class="col-md-12">
						<div class="form-group">
							{!! Form::label('template', 'Select Type of Project') !!}<br/>
							<label class="checkbox-inline">
								@if($inspection_details->project_type=="app_project")
									<input type="radio" name="project_type" value="app_project" id="app_project" class="psi_required" onclick="changeProjectType('app')" required checked> APP Project
								@else
									<input type="radio" name="project_type" value="null" id="app_project" class="" onclick="changeProjectType('app')" required> APP Project
								@endif
								
							</label>
							<label class="checkbox-inline">
								@if($inspection_details->project_type=="word_project")
								<input type="radio" name="project_type" value="word_project" id="word_project" class="psi_required" onclick="changeProjectType('word')" required checked> WORD Project
								@else
									<input type="radio" name="project_type" value="null" id="word_project" class="" onclick="changeProjectType('word')" required> WORD Project
								@endif
								
							</label>

						</div>
					</div>
		</div>
	</div>
	@if($inspection_details->project_type=="word_project")

	@else

	@endif


	@if($inspection_details->project_type=="app_project")
		<div class="row" id="div_template">
			<div class="col-md-4" >
				<div class="form-group">
					{!! Form::label('template', 'Select App Template') !!}
					<select class="form-control" name="template" id="template" required>
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
					{!! Form::label('same_report', 'Select Docs Report') !!}<br/>
					@if($inspection_details->word_template=="")
						<label class="checkbox-inline">
							<input type="radio" name="same_report" value="" id="same_report" class="" required onclick="chooseEngReport('same_report')" checked> Same Report
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="same_report" value="" id="other_report" class="" required onclick="chooseEngReport('other_report')"> Other Report 	Language
						</label>
					@else
						<label class="checkbox-inline">
							<input type="radio" name="same_report" value="" id="same_report" class="" required onclick="chooseEngReport('same_report')"> Same Report
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="same_report" value="" id="other_report" class="" required onclick="chooseEngReport('other_report')" checked> Other Report 		Language
						</label>
					@endif
				</div>
			</div> --}}
			{{-- @if($inspection_details->word_template=="")
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
			@else
				<div class="col-md-4" id="eng_rpt_temp">
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
			@endif --}}
		</div>	
	@else
	<div class="row" id="div_template" style="display:none">
		<div class="col-md-4" >
			<div class="form-group">
				{!! Form::label('template', 'Select Template') !!}
				<select class="form-control" name="template" id="template" required>
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
	@endif


</div>




{{-- <div class="col-md-offset-9 col-md-3">
	{{ Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-psi-submit-draft','style'=>'margin-top: 5px;','type'=>'button']) }}
	{{ Form::button('Submit Inspection Details', ['class' => 'btn btn-success btn-block','id'=>'btn-psi-submit','style'=>'margin-top: 5px;','type'=>'button']) }}
</div> --}}
<div class="row">
<div class="col-md-offset-9 col-md-3">
	<br/>
		{!! Form::button('Save as Draft', ['class' => 'btn btn-primary btn-block','id'=>'btn-psi-edit-draft','type'=>'button']) !!}
		{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block','id'=>'btn-psi-submit','type'=>'button']) !!}
		<input type="hidden" name="edit_inspection_id" id="edit_inspection_id" value="{{$inspection_details->inspec_id}}">
		<input type="hidden" name="is_new_product_added" id="is_new_product_added" value="0">
		<input type="hidden" name="client_cost_id" id="client_cost_id" value="{{$client_cost->id}}">
		<input type="hidden" name="inspector_cost_id" id="inspector_cost_id" value="{{$inspector_cost->id}}">
	</div>
</div>


<script>
jQuery(document).ready(function(){


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
		  /* if(count_null>0){
			  alert("Please fill up the required fields");
		  } */
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
