{!!Form::open(['id'=>'new_inspection_form','data-parsley-validate'=>'', 'route'=>'edited-draft-inspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
<div class="row">
	<div class="col-md-12">
		<h4 class="heading">Inspection Details</h4>
		{{-- <input type="text" name="user_category" id="user_category" value="{{$inspection_details->supplier_book}}"> --}}
		<hr>
	</div>
	<div class="col-md-4">
		<div class="form-group">	
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		    {!! Form::label('service', 'Service') !!}
		    {!! Form::select('service', $services, $inspection_details->service, ['class' => 'form-control service psi_required ', 'placeholder'=>'Select a Service', 'id'=>'service', 'required'=>'', 'disabled'=>'']) !!}
	  	</div>
	</div>
	<div class="contact-select">
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('client', 'Select Client') !!}
				<select class="form-control psi_required client client_select " id="client" name="client" required disabled>
					@foreach($clients as $client)
						@if($client->client_status!=2 || $client->client_status!='2')
							@if($client->client_code==$inspection_details->client_id)
								<option value="{{$client->client_code}}" selected>{{$client->Company_Name}}</option>
							@endif
						@endif					
					@endforeach
				</select>
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Reference / Report Number</label>
				<input type="text" name="reference_number" id="reference_number" class="form-control reference_number psi_required " value="{{$inspection_details->reference_number}}" required readOnly>
			</div>
		</div>	
		<div class="clone-inputs-contact-person">
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('contact_person', 'Contact Person') !!}
					{!! Form::select('contact_person', $client_contact, $get_cc->id, ['class' => 'form-control psi_required contact_persons ', 'placeholder'=>'Select Contact']) !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
					{!! Form::text('contact_person_number', $get_cc->tel_number, ['class' => 'form-control psi_required numeric contact_number ','required'=>'','id'=>'contact_number']) !!}
				  </div>
			</div>	
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('contact_person_email', 'Email Address') !!}
					{!! Form::text('contact_person_email', $get_cc->email_address, ['class' => 'form-control psi_required contact_email ','id'=>'email_address']) !!}
				  </div>
			</div>
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
					<input type="text" name="client_project_number" id="client_project_number" class="form-control client_project_number psi_required " value="{{$inspection_details->client_project_number}}" required>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Inspection Date From</label>
					<input type="text" name="inspection_date" id="inspection_date" class="form-control inspection_date psi_required " value="{{$inspection_details->inspection_date}}" required>
			  	</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label>Inspection Date To</label>
					<input type="text" name="inspection_date_to" id="inspection_date_to" class="form-control inspection_date psi_required " value="{{$inspection_details->inspection_date_to}}" required>
			  	</div>
			</div>
		</div>

		<div class="clone-inspector-container">
			<div class="clone-inspector">
				<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('inspector', 'Assign Inspector') !!}
					   {{--  {!! Form::select('inspector', $inspectors, $inspection_details->inspector_id, ['class' => 'form-control psi_required select_address  sel-inspector','placeholder'=>'Select an Inspector','required'=>'']) !!} --}}
					   <select class="form-control psi_required sel-inspector" name="inspector" id="inspector" required>
						<option value="" >Select an Inspector</option>
							@foreach($inspector_list as $inspectors)
								@if($inspection_details->inspector_id==$inspectors->user_id && $inspection_details->inspector_id!=0)
									<option value="{{$inspectors->user_id}}" selected>{!!$inspectors->name!!}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>
								@else
									<option value="{{$inspectors->user_id}}">{!!$inspectors->name!!}&nbsp;&nbsp;&nbsp;({{$inspectors->email_address}})</option>		
								@endif
							@endforeach
						</select>
				  	</div>
				</div>
    			<div class="col-md-6">
					<div class="form-group">
						<label>Inspector Address</label>
						@if($inspection_details->inspector_id==0)
							<input type="text" name="inspector_address" id="inspector_address" class="form-control inspector_address psi_required  insp-addr add_inspector">
						@elseif($inspection_details->inspector_id!=0)
							<input type="text" name="inspector_address" id="inspector_address" class="form-control inspector_address psi_required  insp-addr add_inspector" value="{{$inspector_info->address}}">
						@else
							<input type="text" name="inspector_address" id="inspector_address" class="form-control inspector_address psi_required  insp-addr add_inspector">
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<button type="button" class="btn btn-success pull-left" id="add_inspector">
			<i class="fa fa-plus"></i> Add Other Inspector
		</button>
	</div>

	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('manday', 'Manday') !!}
			{!! Form::text('manday', $inspection_details->manday, ['class' => 'form-control  manday psi_required ','required'=>'']) !!}
		</div>
	</div>
</div>

<div class="row factory-select">
	<div class="col-md-6">
		<h4 class="heading">Supplier Details
			{{-- <button style="margin-left:20px;"  class="btn btn-primary btn-supplier" type="button" data-toggle="modal" data-target="#newSupplier"><i class="fa fa-plus"></i> Add New Supplier</button>	 --}}
		</h4>
	</div>
	<div class="col-md-6 text-right">
		<div class="form-group">
			<button style="margin-left:20px;"  class="btn btn-primary btn-supplier" type="button" data-toggle="modal" data-target="#newSupplier"><i class="fa fa-plus"></i> Add New Supplier</button>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('supplier', 'Supplier') !!}
			{!! Form::select('supplier', $supplier_list, $inspection_details->supplier_id, ['class' => 'form-control supplier psi_required ', 'placeholder'=>'Select supplier',  'required'=>'']) !!}
	  	</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
			{!! Form::label('supplier_address', 'Supplier Address') !!}
			@if($supplier_info)
				{!! Form::text('supplier_address', $supplier_info->supplier_address, ['class' => 'form-control psi_required supplier_address ']) !!}
			@else
				{!! Form::text('supplier_address', null, ['class' => 'form-control psi_required supplier_address ']) !!}
			@endif
		    
	  	</div>
	</div>
	
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('supplier_contact_person', 'Supplier Contact Person') !!}
			{!! Form::select('supplier_contact_person', $supplier_con_list, $inspection_details->supplier_contact_id, ['class' => 'form-control supplier_contact_person psi_required ', 'placeholder'=>'Select Supplier Contact Person']) !!}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('supplier_contact_number', 'Contact Telephone Number (Supplier)') !!}
			@if($supplier_con_info)
				{!! Form::text('supplier_contact_number', $supplier_con_info->supplier_tel_number, ['class' => 'form-control psi_required numeric supplier_contact_number ',]) !!}
			@else
				{!! Form::text('supplier_contact_number', null, ['class' => 'form-control psi_required numeric supplier_contact_number']) !!}
			@endif
		    
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('supplier_email', 'Email Address') !!}
			@if($supplier_con_info)
				{!! Form::text('supplier_email', $supplier_con_info->supplier_email, ['class' => 'form-control psi_required supplier_email ']) !!}
			@else
				{!! Form::text('supplier_email', null, ['class' => 'form-control psi_required supplier_email ']) !!}
			@endif
		    
	  	</div>
	</div>
	<div class="col-md-6">
		<h4 class="heading">Factory Details
		</h4>
	</div>
	<div class="col-md-6 text-right">
		<div class="form-group">
			<button style="margin-left:20px;"  class="btn btn-primary btn-cli-factory" type="button"><i class="fa fa-plus"></i> Add New Factory</button>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('factory', 'Factory Name') !!}
			{!! Form::select('factory', $factory_list, $get_factory->id, ['class' => 'form-control factory psi_required ', 'placeholder'=>'Select Factory']) !!}
	  	</div>
	</div>
	<div class="col-md-8">
		<div class="form-group">
			{!! Form::label('factory_address', 'Factory Address') !!}
			{!! Form::text('factory_address', $get_factory->factory_address, ['class' => 'form-control factory_address psi_required ']) !!}	
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('factory_contact_person', 'Factory Contact Person') !!}
			{!! Form::select('factory_contact_person', $factory_con_list, $get_fc->id, ['class' => 'form-control psi_required factory_contact_person ', 'placeholder'=>'Select Contact Person']) !!}
	  	</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('factory_contact_number', 'Contact Telephone Number (Factory)') !!}
			{!! Form::text('factory_contact_number', $get_fc->factory_tel_number, ['class' => 'form-control psi_required numeric factory_contact_number ']) !!}
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			{!! Form::label('factory_email', 'Email Address') !!}
			{!! Form::text('factory_email', $get_fc->factory_email, ['class' => 'form-control psi_required factory_email ']) !!}  
		</div>

	</div>

	{{-- <div class="col-md-12 show_fac_c_p" id="show_fac_c_p">
		<div class="form-group">
			<button class="btn btn-success" type="button" id="add_more_fac_c_p" >
				<i class="fa fa-plus"></i> Add More Contact Person
			</button>
		</div>
	</div> --}}
</div>
@if($psi_product)
<div class="row" id="products_list">
	<hr>
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6">
				<h4 class="heading">Product Details
				</h4>
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
						
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('product_name', 'Product Name') !!}
									{!! Form::select('product_name', $products, $product->product_id, ['class' => 'form-control product_name psi_required prod_valid s_pname', 'placeholder'=>'Select Product']) !!}
								</div>
							</div>
							<div class="col-md-4 div_category">
								<div class="form-group">
									<label for="product_category">Product Category</label>
									<div class="input-group">
									{!! Form::select('product_category', $p_category, $product->product_first_category, ['class' => 'form-control pcat psi_required product_input prod_valid s_pcat', 'placeholder'=>'Select Product Category']) !!}
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
									<select class="form-control psubcat psi_required prod_valid s_scat" id="product_sub_category" name="product_sub_category">
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
		    						], $product->aql_qty_unit, ['class' => 'form-control p_unit psi_required prod_valid s_unit', 'placeholder'=>'Select pieces']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('brand', 'Brand') !!}
								{!! Form::text('brand', $product->brand, ['class' => 'form-control brand psi_required prod_valid s_brand']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('po_number', 'PO Number') !!}
								{!! Form::text('po_number', $product->po_no, ['class' => 'form-control po_number psi_required prod_valid s_po']) !!}
							</div>

					 	</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('model_no', 'Model/Part No') !!}
								{!! Form::text('model_no', $product->model_no, ['class' => 'form-control model_no psi_required prod_valid s_model']) !!}
							</div>					
						</div>

						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('prod_addtl_info', 'Additional Information') !!}
								{!! Form::text('prod_addtl_info', $product->additional_product_info, ['class' => 'form-control prod_addtl_info psi_required prod_valid s_add_info']) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('prod_item_description', 'Item Descriptions') !!}
								{!! Form::text('prod_item_description', $product->item_description, ['class' => 'form-control prod_item_description psi_required prod_valid s_item_description']) !!}
							</div>
						</div>
						<div class="col-md-4 qty-modal">
							<div class="form-group">
								{!! Form::label('qty', 'Qty') !!}
								<div class="input-group">
								<input type="text" class="form-control qty psi_required edit_qty prod_valid s_qty" name="qty" id="qty" readonly required value="{{$product->aql_qty}}">
									<div class="input-group-btn">
										<button class="btn btn-success btn-qty-modal" type="button" data-id="{{$product->id}}">
											<i class="fa fa-plus"></i>
										</button>
									</div>

								</div>

							</div>
							@include('partials.admin.release-order._editinspectionmodal')
						</div>
						<div class="row">
							@if($attach_arr[$product->product_id]==0)
								<div class="col-md-4 col-view-att" style="display:none">
									<button type="button" class="btn btn-primary view_prod_attachment" style="margin-left:15px;"><i class="fa fa-file"></i> View Attachments</button>
								</div>
							@else
								<div class="col-md-4 col-view-att" style="display:block">
									<button type="button" class="btn btn-primary view_prod_attachment" style="margin-left:15px;"><i class="fa fa-file"></i> View Attachments</button>
								</div>
							@endif
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<br/>
								<button type="button" class="btn btn-danger btn-rm-edit-product pull-right" data-id="{{$product->id}}"><i class="fa fa-times"></i> Remove Product</button>
							</div>
						</div>
						
					</div>
					@endforeach
				</div>
				

			</div>
		</div>
	</div>
	
	<div class="col-md-3 pull-right">
			<button type="button" class="btn btn-success pull-right" id="btn_more_product">
			<i class="fa fa-cube"></i> Add More Products
		</button>
	</div>
 {{-- </div> --}}
 @endif
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


	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('template', 'Select Type of Project') !!}<br/>
				<label class="checkbox-inline">
					@if($inspection_details->project_type=='null' || $inspection_details->project_type=='')
						<input type="radio" name="project_type" value="null" id="app_project" class="" onclick="changeProjectType('app')" > APP Project
						<input type="radio" name="project_type" value="null" id="word_project" class="" onclick="changeProjectType('word')" > WORD Project
					@elseif($inspection_details->project_type=='word_project')
						<input type="radio" name="project_type" value="null" id="app_project" class="" onclick="changeProjectType('app')" > APP Project
						<input type="radio" name="project_type" value="word_project" id="word_project" class="" onclick="changeProjectType('word')" checked> WORD Project
					@elseif($inspection_details->project_type=='app_project')
						<input type="radio" name="project_type" value="app_project" id="app_project" class="" onclick="changeProjectType('app')" checked> APP Project
						<input type="radio" name="project_type" value="null" id="word_project" class="" onclick="changeProjectType('word')" > WORD Project
					@endif					
				</label>
			</div>
		</div>
	</div>
	@if($inspection_details->project_type=='app_project')
		<div class="row" id="div_template">
			<div class="col-md-4" >
				<div class="form-group">
					{!! Form::label('template', 'Select App Template') !!}
					{{-- {!! Form::select('template', $templates, $inspection_details->template_id, ['class' => 'form-control', 'placeholder'=>'Select App Template']) !!} --}}
					<select class="form-control" name="template" id="template" required>
						<option value="" selected>Select App Template</option>
					 
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
	@else
		<div class="row" id="div_template" style="display:none;">
			<div class="col-md-4" >
				<div class="form-group">
					{!! Form::label('template', 'Select App Template') !!}
					{{-- {!! Form::select('template', $templates, $inspection_details->template_id, ['class' => 'form-control', 'placeholder'=>'Select App Template']) !!} --}}
					<select class="form-control" name="template" id="template" required>
						<option value="" selected>Select App Template</option>
					 
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
	{{-- 04-30-2021 --}}
	@if($inspection_details->project_type=="word_project")
		<div class="row" id="div_template_word" style="display:none;">
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
	@endif
</div>



<div class="row">
<div class="col-md-offset-9 col-md-3">
	<br/>
		{!! Form::button('Hold', ['class' => 'btn btn-primary btn-block','id'=>'btn-psi-hold','type'=>'button']) !!}
		{!! Form::button('Release', ['class' => 'btn btn-success btn-block','id'=>'btn-psi-submit','type'=>'button']) !!}
		<input type="hidden" name="edit_inspection_id" id="edit_inspection_id" value="{{$inspection_details->inspec_id}}">
		<input type="hidden" name="is_new_product_added" id="is_new_product_added" value="0">
		<input type="hidden" name="client_cost_id" id="client_cost_id" value="{{$client_cost->id}}">
		<input type="hidden" name="inspector_cost_id" id="inspector_cost_id" value="{{$inspector_cost->id}}">
		<input type="hidden" name="hidden_product_cat" id="hidden_product_cat" value="{{$product->product_category}}">
	</div>
</div>

<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
$(document).ready(function(){
	setSubCat();
	// user_cat();
});



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
// function user_cat(){
// 	var cat = $('.user_category').val();
// 		if(cat == 'true'|| cat == "true"){
// 			$('#supplier_contact').hide();
// 		}else{
// 			$('#supplier_contact').show();
// 		}
// }

</script>


{!!Form::close()!!}
