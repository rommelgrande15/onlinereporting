{!!Form::open(['id'=>'new_inspection_form','data-parsley-validate'=>'', 'route'=>'edited-draft-inspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
<div class="row">
	<div class="col-md-12">
	<h4 class="heading">Inspection Detailsss</h4>
	<hr>
	</div>
	
	<div class="col-md-4">
		<div class="form-group">
		
		    {!! Form::label('service', 'Service') !!}
		    {!! Form::select('service', [
		    	'iqi' => 'Incoming Quality Inspection',
		    	'dupro' => 'During Production Inspection',
		    	'psi' => 'Pre Shipment Inspection',
				'pus' => 'Pick Up Sample',
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
				], $inspection_details->service, ['class' => 'form-control service psi_required psi_draft_required', 'placeholder'=>'Select a Service', 'id'=>'service', 'required'=>'', 'disabled'=>'']) !!}
	  	</div>
	</div>
	
	<div class="contact-select">
	<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('client', 'Select Client') !!}
				<select class="form-control psi_required client client_select psi_draft_required" id="client" name="client" required>
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
					<input type="text" name="reference_number" id="reference_number" class="form-control reference_number psi_required psi_draft_required" value="" required readOnly>
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
					<input type="text" name="client_project_number" id="client_project_number" class="form-control client_project_number psi_required psi_draft_required" value="" required>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Inspection Date From</label>
					<input type="text" name="inspection_date" id="inspection_date" class="form-control inspection_date inspection-date-from psi_required psi_draft_required" value="{{$inspection_details->inspection_date}}" required>
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
					    {!! Form::label('inspector', 'Assign / Change Inspector') !!}
					   {{--  {!! Form::select('inspector', $inspectors, $inspection_details->inspector_id, ['class' => 'form-control psi_required select_address psi_draft_required sel-inspector','placeholder'=>'Select an Inspector','required'=>'']) !!} --}}
					   <input type="hidden" name="old_inspector" id="old_inspector" value="{{$inspection_details->inspector_id}}" disabled>  
					   <select class="form-control psi_required select_address psi_draft_required sel-inspector" name="inspector" id="inspector" required>
						<option value="" >Select an Inspector</option>
						@foreach($inspector_list as $inspectors)
							@if($inspection_details->inspector_id==0)
								<option value="{{$inspectors->user_id}}">{!!$inspectors->name!!}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
							@else	
								@if($inspectors->user_id==$inspection_details->inspector_id)
									<option value="{{$inspectors->user_id}}" selected>{!!$inspectors->name!!}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
								@else
									<option value="{{$inspectors->user_id}}">{!!$inspectors->name!!}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
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
								<select id="inspector_sec" name="inspector_sec" class="form-control psi_required psi_draft_required sel-inspector sel-added-inspector">
									<option value="">Select an Inspector</option>
									@foreach($inspector_list as $inspector)	
										@if($inspector->id==$other)
											<option value="{{$inspector->user_id}}" selected>{!!$inspector->name!!}</option>
										@else
											<option value="{{$inspector->user_id}}">{!!$inspector->name!!}</option>
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
	<div class="col-md-6">
		<div class="form-group">
			{!! Form::label('inspector', '--Select Inspector Account for FM login details--') !!}

			<select class="form-control fm_inspector" name="fm_inspector" id="fm_inspector" required>
				<option value="">Select Inspector FM Account</option>
				@foreach($fm_accounts as $account)

					@if($account['id']==$inspection_details->fm_id)
						<option value="{{ $account['id'] }}" selected>{!!$account['name']!!}&nbsp;&nbsp;&nbsp;({!!$account['email']!!})</option>
					@else
						<option value="{{ $account['id'] }}">{!!$account['name']!!}&nbsp;&nbsp;&nbsp;({!!$account['email']!!})</option>
					@endif
				 
				@endforeach
			</select>

			{{-- <br/>
			<div id='InspectoResult'></div> --}}
		</div>
		<input type="hidden" value="" id="fm_username">
		<input type="hidden" value="" id="fm_password">
		<input type="hidden" value="{{ $inspection_details->fm_id }}" id="fm_inspector">
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
			<select class="form-control factory psi_required psi_draft_required" name="factory" id="factory" required>
				<option value="" >Select Factory</option>
				@foreach($factories as $factory)					
					@if($factory->id==$inspection_details->factory_id)
						<option value="{{$factory->id}}" selected>{!!$factory->factory_name!!}</option>
					@else
						<option value="{{$factory->id}}">{!!$factory->factory_name!!}</option>
					@endif
				@endforeach
			</select>

	  	</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
				<label>Factory Address</label>
				<input type="text" name="factory_address" id="factory_address" class="form-control factory_address psi_required psi_draft_required" value="{{$factory_info->factory_address}}" required >
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label for="factory_contact_person">Factory Contact Person</label>
			<select class="form-control psi_required factory_contact_person psi_draft_required" id="factory_contact_person" name="factory_contact_person" >
				{{-- <option value="" >Select Contact Person</option> --}}
				@foreach($factory_contactlist as $contact)			
					@if($contact->id==$inspection_details->factory_contact_person)
						<option value="{{$contact->id}}" selected>{!!$contact->factory_contact_person!!}</option>
					@else
						<option value="{{$contact->id}}" >{!!$contact->factory_contact_person!!}</option>
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
						<input type="hidden" name="hidden_product_cat" class="hidden_product_cat" value="{{$product->product_category}}">
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('product_name', 'Product Name') !!}
									{!! Form::text('product_name', $product->product_name, ['class' => 'form-control product_name psi_required psi_draft_required']) !!}
								</div>
							</div>
							<div class="col-md-4 div_category">
								<div class="form-group">
									<label for="product_category">Product Category</label>
									<div class="input-group">
									{!! Form::select('product_category', $p_category, $product->product_first_category, ['class' => 'form-control product_category pcat product_input prod_valid s_pcat', 'placeholder'=>'Select Product Category']) !!}
									<div class="input-group-btn">
										<button class="btn btn-primary btn-show-cat-modal" type="button" title="Add new category">
											<i class="fa fa-plus"></i>
										</button>
									</div>
									</div>
								</div>
								@include('partials.product-category._inputcategory')
							</div>
							<div class="col-md-4 div_sub_category">
								<div class="form-group">
									<label for="product_sub_category">Product Sub-Category</label>
									<div class="input-group">
									<select class="form-control product_sub_category psubcat psi_required prod_valid s_scat" id="product_sub_category" name="product_sub_category">
										<option selected="selected" value="">Select a Category</option>
									</select>
									<input type="hidden" class="epsc_value" value="{{$product->product_category}}">
									<div class="input-group-btn">
										<button class="btn btn-primary btn-add-sub-cat-modal-edit" type="button" title="Add new sub-category">
											<i class="fa fa-plus"></i>
										</button>
									</div>
									</div>
								</div>
								@include('partials.product-category._inputsubcategory')
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
									'kg' => 'Kilogram/s',
		    						], $product->product_unit, ['class' => 'form-control p_unit psi_required psi_draft_required', 'placeholder'=>'Select pieces']) !!}
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
								<input type="text" class="form-control qty psi_required edit_qty jesserjOE psi_draft_required" name="qty" id="qty" readonly required value="{{$product->aql_qty}}">
									<div class="input-group-btn">
										<button class="btn btn-success btn-qty-modal-edit" type="button" data-id="{{$product->id}}">
											<i class="fa fa-plus"></i>
										</button>
									</div>

								</div>

							</div>
							@include('partials.admin.copy-project._aqldraftmodal')
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<br/>
									<button type="button" class="btn btn-danger btn-rm-copy-product" data-id="{{$product->id}}" style="margin-left:20px; margin-top:-40px;"><i class="fa fa-times"></i> Remove Product</button>
								</div>
							</div>
						</div>	
						
					</div>
					@endforeach
				</div>
				


			</div>
		</div>
	</div>

	
	<div class="col-md-3 pull-right">
			<button type="button" class="btn btn-success pull-right" id="btn_product_copy">
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
					@if($inspector_cost)
						@foreach($currency as $key => $value)				
							@if($inspector_cost->currency==$key)
								<option value="{{$key}}" selected>{{htmlentities($value)}}</option>
							@else
								<option value="{{$key}}">{{htmlentities($value)}}</option>
							@endif
						@endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_md_charge', 'MD Charges') !!}
				@if($inspector_cost)
					{!! Form::number('ins_md_charge', $inspector_cost->md_charges, ['class' => 'form-control ins_md_charge','required'=>'']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_travel_cost', 'Travel Cost') !!}
				@if($inspector_cost)
					{!! Form::number('ins_travel_cost', $inspector_cost->travel_cost, ['class' => 'form-control ins_travel_cost','required'=>'']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_hotel_cost', 'Hotel Cost') !!}
				@if($inspector_cost)
					{!! Form::number('ins_hotel_cost', $inspector_cost->hotel_cost, ['class' => 'form-control ins_hotel_cost','required'=>'']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('ins_ot_cost', 'OT Cost') !!}
				@if($inspector_cost)
					{!! Form::number('ins_ot_cost', $inspector_cost->ot_cost, ['class' => 'form-control ins_ot_cost','required'=>'']) !!}
				@endif
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
					@if($client_cost)
						@foreach($currency as $key => $value)				
							@if($client_cost->currency==$key)
								<option value="{{$key}}" selected>{{htmlentities($value)}}</option>
							@else
								<option value="{{$key}}">{{htmlentities($value)}}</option>
							@endif
						@endforeach
					@endif
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_md_charge', 'MD Charges') !!}
				@if($client_cost)
					{!! Form::number('cli_md_charge', $client_cost->md_charges, ['class' => 'form-control cli_md_charge','required'=>'']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_travel_cost', 'Travel Cost') !!}
				@if($client_cost)
					{!! Form::number('cli_travel_cost', $client_cost->travel_cost, ['class' => 'form-control cli_travel_cost','required'=>'']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_hotel_cost', 'Hotel Cost') !!}
				@if($client_cost)
					{!! Form::number('cli_hotel_cost',  $client_cost->hotel_cost, ['class' => 'form-control cli_hotel_cost','required'=>'']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('cli_ot_cost', 'OT Cost') !!}
				@if($client_cost)
					{!! Form::number('cli_ot_cost', $client_cost->ot_cost, ['class' => 'form-control cli_ot_cost','required'=>'']) !!}
				@endif
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
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('memo_psi', 'Memo / Notes') !!}
				{!! Form::textarea('memo_psi', $inspection_details->memo, ['class' => 'form-control psi_required memo_psi','rows'=>'4']) !!}
			</div>
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
		<div class="row" id="div_template_word">
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('template_word', 'Select Word Template') !!}
					<select class="form-control" name="template_word" id="template_word" required>
						<option value="" selected>Select Template</option>
						@foreach($templates as $template)
							@if($inspection_details->template_id==$template->id)
								<option value="{{$template->id}}" selected>{{$template->name}}</option>
							@elseif(stripos( $template->name, "geo") !== false)
								<option value="{{$template->id}}">{{$template->name}}</option>
							@endif
					
						@endforeach
					</select>
				</div>
			</div>
		</div>
	@else
		<div class="row" id="div_template_word" style="display:none;">
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('template_word', 'Select Word Template') !!}
					<select class="form-control" name="template_word" id="template_word" required>
						<option value="" selected>Select Template</option>
						@foreach($templates as $template)
							
							@if(stripos( $template->name, "geo") !== false)
							
							<option value="{{$template->id}}">{{$template->name}}</option>
							@endif
					
						@endforeach
					</select>
				</div>
			</div>
		</div>
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
							@elseif(stripos( $template->name, "geo")  !== false)
								
							@else
								<option value="{{$template->id}}">{{$template->name}}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
		</div>	
	@else
	<div class="row" id="div_template" style="display:none">
		<div class="col-md-4" >
			<div class="form-group">
				{!! Form::label('template', 'Select App Template') !!}
				<select class="form-control" name="template" id="template" required>
					<option value="">Select App Template</option>
					@foreach($templates as $template)
						{{-- @if($inspection_details->template_id==$template->id)
							<option value="{{$template->id}}" selected>{{$template->name}}</option> --}}
						@if(stripos( $template->name, "geo")  !== false)
								
						@else
							<option value="{{$template->id}}">{{$template->name}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>

	</div>	
	@endif


</div>





<div class="row">
<div class="col-md-offset-9 col-md-3">
	<br/>
		{!! Form::button('Save and Publish', ['class' => 'btn btn-success btn-block','id'=>'btn-psi-copy','type'=>'button']) !!}
		<input type="hidden" name="edit_inspection_id" id="edit_inspection_id" value="{{$inspection_details->inspec_id}}">
	</div>
</div>


<script>
	$(document).ready(function(){
		// fillCopiedCategories();
		setSubCat();		
		setTimeout(function(){ 
			// setProdCat();
			setRefNumPSI();
		},2000);
	});

	//$(window).on('load',function(){
	//	setProdCat();
	//});
//addeed 04-16-2021
function setSubCat(){
	$('.pcat').each(function(){
		var val = $(this).val();
		var sub_cat_class=$(this).closest('.clone-inputs-edit').find('.psubcat');
		var sub_cat_val=$(this).closest('.clone-inputs-edit').find('.epsc_value').val();
		console.log(sub_cat_val);
		fillEPC(this,sub_cat_class,sub_cat_val)
	 });
}
function fillEPC(pc_dis,sub_pc_cl,sub_val){
	var cat_val = $(pc_dis).val();
	$(sub_pc_cl).empty();
	$(sub_pc_cl).append('<option value="">Select Sub-product Category</option>');
	var sub_cat_arr = [];
    $.ajax({
        url: '/get-saved-sub-category',
        type: 'POST',
        data: {
            _token: token,
            id: cat_val
        },
        success: function(response) {
            console.log(response);
            response.sub_categories.forEach(element => {
                sub_cat_arr.push(element.sub_category);
            });
            if (response.orig_sub_categories.length > 0) {
                response.orig_sub_categories.forEach(element => {
                    sub_cat_arr.push(element.name);
                });
            }
            sub_cat_arr.sort();
            sub_cat_arr.forEach(element => {
				$(sub_pc_cl).append('<option value="' + element + '">' + element + '</option>');
            });
			$(sub_pc_cl).append('<option value="Others">Others</option>');
			$(sub_pc_cl).val(sub_val);
        }
    });

}
	$('#client').on('change', function() {
    	var client_code = $('#client').val();
    	var inspect_date_val = $('#inspection_date').val();
    	if (inspect_date_val != "") {
    	    $.ajax({
    	        type: "GET",
    	        url: '/getclientcountinspection-new/' + client_code + '/' + inspect_date_val,
    	        success: function(data) {
    	            $('#reference_number').val(data.ref_num);
    	        },
    	        error: function(err){
    	            console.log('Reference Number Error: ' + err);
    	            $('#reference_number').val('');
    	        }
    	    });
    	}
    	//condition
    	if (client_code == 'sr' || client_code == 'SR' || client_code == 'A381' || client_code == 'a381') {
    	    $('#reference_number').attr('readOnly', false);
    	} else {
    	    $('#reference_number').attr('readOnly', true);
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

function setRefNumPSI(){

    	var client_code = $('#client').val();
    	var inspect_date_val = $('#inspection_date').val();
    	if (inspect_date_val != "") {
    	    $.ajax({
    	        type: "GET",
    	        url: '/getclientcountinspection-new/' + client_code + '/' + inspect_date_val,
    	        success: function(data) {
    	            $('#reference_number').val(data.ref_num);
    	        },
    	        error: function(err){
    	            console.log('Reference Number Error: ' + err);
    	            $('#reference_number').val('');
    	        }
    	    });
    	}
    	//condition
    	if (client_code == 'sr' || client_code == 'SR' || client_code == 'A381' || client_code == 'a381') {
    	    $('#reference_number').attr('readOnly', false);
    	} else {
    	    $('#reference_number').attr('readOnly', true);
    	}

}

function setRefNumPSIOLD(){
	var client_code=$('#client').val();
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
}

// function setProdCat(){
// 	$('.hidden_product_cat').each(function(){
// 		var val_cat = $(this).val();	
// 		$(this).closest('.clone-inputs-edit').find('.product_category').val(val_cat);   	
// 		console.log('Product Cat: '+val_cat);
// 	});
// }

// function fillCopiedCategories() {
// 	$('.categories').find('optgroup').remove();
// 	$.getJSON("/json/categories.json", function(json) {
// 		$.each(json, function(i, optgroups) {
// 			$.each(optgroups, function(groupName, options) {
// 				var $optgroup = $("<optgroup>", {
// 					label: groupName
// 				});

// 				$.each(options, function(j, option) {
// 					var $option = $("<option>", {
// 						text: option.text,
// 						value: option.val
// 					});
// 					$option.appendTo($optgroup);
// 				});
// 				$optgroup.appendTo('.categories');
// 			});
// 		});
// 	});
// 	console.log('Fill product categories');
// }
qtyPUS();
function qtyPUS(){
        if (jQuery("#service").val() === 'pus' ) {
            jQuery('#qty').attr('readonly',false);
            jQuery('#qty').addClass('aql_qty');
            jQuery('.btn-qty-modal-edit').hide();
            
        } else {
            jQuery('#qty').attr('readonly',true);
            jQuery('#qty').removeClass('aql_qty');
            jQuery('#qty').attr('readonly',false);
            jQuery('.btn-qty-modal-edit').show();
        }
    }

</script>


{!!Form::close()!!}
