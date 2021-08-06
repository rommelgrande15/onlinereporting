{!!Form::open(['id'=>'new_inspection_form','data-parsley-validate'=>'', 'route'=>'supplier-client-saveinspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
	
	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Inspection Details</h4>
			@foreach($clientName as $cname)
				<h4 style="color:green;"><span class="pull-right">Client Name : {{ $cname->client_name }}</span></h4>
				<input type="hidden" id="client" value="{{$cname->client_code}}"> 
				<input type="hidden" id="hidden_client_code" value="{{$cname->client_code}}">
			@endforeach
		</div>
		<div class="row">
			<div class="col-md-4" >
				<div class="form-group" style="margin-left:18px;">
				    {!! Form::label('service', 'Service') !!}
				    {!! Form::select('service', $services, null, ['class' => 'form-control service psi_required psi_draft_required', 'placeholder'=>'Select a Service', 'id'=>'service', 'required'=>'']) !!}
			  	</div>
			</div>
		</div>
		{{-- <div class="col-md-4">
			<div class="form-group">
				{!! Form::label('reference_number', 'Reference / Report Number') !!}
				{!! Form::text('reference_number', $ref_num, ['class' => 'form-control reference_number psi_required psi_draft_required','readOnly'=>true]) !!}
			</div>
		</div> --}}
		<input type="hidden" value="{{$ref_num}}" class="form-control reference_number" id="reference_number">
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('client_project_number', 'Order Number') !!}
				{!! Form::text('client_project_number', null, ['class' => 'form-control  client_project_number psi_required psi_draft_required','required'=>'','id'=>'client_project_number']) !!}
				<br/><br/><br/>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">		
				{!! Form::label('inspection_date', 'Inspection Date') !!}
				{!! Form::text('inspection_date', null, ['class' => 'form-control psi_required inspection_date psi_draft_required','required'=>'','autocomplete'=>'off']) !!}
				{{-- <label title="Selecting this will not allow the factory to postpone or advance the inspection date" id="label_change_date">
					<input type="checkbox" id="fac_change_date" name="fac_change_date" value="no"> Do not allow factory to change this date.
				</label> --}}
			</div>
		</div>
	
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('psi_shipment_date', 'Expected Shipment Date') !!}
				{!! Form::text('psi_shipment_date', null, ['class' => 'form-control psi_required inspection_date psi_draft_required','required'=>'','autocomplete'=>'off']) !!}
				<br/><br/><br/>
			</div>
		</div>
	
		<div class="contact-select">	
			<div class="clone-inputs-contact-person">
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('contact_person', 'Client Contact Person') !!}
						@if($supplierClientContact)
						{!! Form::text('contact_person',  $supplierClientContact->contact_person , ['class' => 'form-control psi_required contact_persons psi_draft_required','required'=>'','id'=>'contact_person','readOnly'=>'true']) !!}
						@else
						{!! Form::text('contact_person',  null , ['class' => 'form-control psi_required contact_persons psi_draft_required','required'=>'','id'=>'contact_person','readOnly'=>'true']) !!}
						@endif
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    {!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
						@if($supplierClientContact)
					    {!! Form::text('contact_person_number', $supplierClientContact->tel_number, ['class' => 'form-control psi_required numeric contact_number psi_draft_required','required'=>'','id'=>'contact_number','readOnly'=>'true']) !!}
						@else
						{!! Form::text('contact_person_number', null, ['class' => 'form-control psi_required numeric contact_number psi_draft_required','required'=>'','id'=>'contact_number','readOnly'=>'true']) !!}
						@endif
					</div>
				</div>	
				<div class="col-md-4">
					<div class="form-group">
					    {!! Form::label('contact_person_email', 'Email Address') !!}
						@if($supplierClientContact)
					    {!! Form::text('contact_person_email', $supplierClientContact->email_address, ['class' => 'form-control psi_required contact_email psi_draft_required','id'=>'email_address','readOnly'=>'true']) !!}
						@else
						{!! Form::text('contact_person_email', null , ['class' => 'form-control psi_required contact_email psi_draft_required','id'=>'email_address','readOnly'=>'true']) !!}
						@endif
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
			
			
		</div>
	</div>
	<div class="row factory-select">
		<div class="col-md-12">
			<h4 class="heading">Factory & Supplier Detail</h4>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_name', 'Supplier Name') !!}
				{!! Form::text('supplier_name',  $suppliers1->supplier_name , ['class' => 'form-control cli_required numeric loading_supplier_name cli_draft_required','required'=>'','readOnly'=>'true']) !!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_number', 'Supplier Code/Number') !!}
				{!! Form::text('supplier_number',  $suppliers1->supplier_code , ['class' => 'form-control cli_required numeric loading_supplier_number cli_draft_required','required'=>'','readOnly'=>'true']) !!}
			  </div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_address', 'Supplier Address') !!}
				{!! Form::text('supplier_address',  $suppliers1->supplier_address , ['class' => 'form-control cli_required numeric loading_supplier_address cli_draft_required','required'=>'','readOnly'=>'true']) !!}
			  </div>
		</div>
		<input type="hidden" id="supplier-id" value="{{$suppliers1->id}}">
		<div class="col-md-4">
			<div class="form-group">
				<label for="supplier_contact_person">Supplier Contact Person</label>
				@if($supplierContactName)
				{!! Form::text('supplier_contact_person',  $supplierContactName->supplier_contact_person , ['class' => 'form-control psi_required supplier_contact_person psi_required psi_draft_required','required'=>'','id'=>'supplier_contact_person','readOnly'=>'true']) !!}
				@else
				{!! Form::text('supplier_contact_person',  null , ['class' => 'form-control psi_required supplier_contact_person psi_required psi_draft_required','required'=>'','id'=>'supplier_contact_person','readOnly'=>'true']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('supplier_contact_number', 'Contact Telephone Number (Supplier)') !!}
				@if($supplierContactName)
			    {!! Form::text('supplier_contact_number', $supplierContactName->supplier_tel_number, ['class' => 'form-control psi_required numeric supplier_contact_number psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@else
				{!! Form::text('supplier_contact_number', null, ['class' => 'form-control psi_required numeric supplier_contact_number psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@endif
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('supplier_email', 'Email Address') !!}
				@if($supplierContactName)
			    {!! Form::text('supplier_email', $supplierContactName->supplier_email, ['class' => 'form-control psi_required supplier_email psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@else
				{!! Form::text('supplier_email', null, ['class' => 'form-control psi_required supplier_email psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@endif
		  	</div>
		</div>
		
		<div id="psi_fac_toggle_div">
			<div class="col-md-12 text-right">
				<div class="form-group">
					@if($create_factory=="" || $create_factory=="yes")
						<button style="margin-left:20px; display:none;"  class="btn btn-primary btn-cli-factory" id="btn-add-factory" type="button"><i class="fa fa-plus"></i> Add New Factory</button>
					@else
						<button style="margin-left:20px; display:none;"  class="btn btn-primary disabled" id="btn-add-factory" type="button"><i class="fa fa-plus"></i> Add New Factory</button>
					@endif
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					{!! Form::label('factory', 'Factory Name') !!}
					<select class="form-control factory psi_required psi_draft_required" name="factory" id="factory" required>
						<option value="" >Select Factory</option>
					@foreach($suppFactory as $factory)
						<option value="{{$factory->id}}">{!!$factory->factory_name!!}</option>
					@endforeach
					</select>
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
						<option value="" >Select Factory Contact Person</option>
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
	<div id="products_list">
		<hr>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-6">
					<h4 class="heading">Product Details</h4>
				</div>
				<div class="col-md-6 text-right">
					@if($create_product=="" || $create_product=="yes")
						<button class="btn btn-primary" type="button" data-toggle="modal"  data-target="#newProduct">
							<i class="fa fa-plus"></i> Add New Product
						</button>	
					@else					
						<button class="btn btn-primary disabled" type="button">
							<i class="fa fa-plus"></i> Add New Product
						</button>
					@endif
				</div>
			</div>
		</div>
		
		<div class="col-md-12 products-list">
			<div class="product_row">
				<div class="group-body">
					<div class="row product-clone">
						<div class="clone-inputs">
							<div class="row" style="margin-left:0.5px;">
								<div class="col-md-4">
									<div class="form-group" >										
											{!! Form::label('product_name', 'Product Name') !!}
											<div class="input-group">
												<select class="form-control psi_required product_name_new psi_draft_required input-new-prod" name="product_name_new" id="product_name_new" required>
													<option value="">Select Product</option>
													@foreach ($suppProducts as $product)
													<option value="{{ $product->id }}">{{ $product->product_name }}</option>	
													@endforeach
												</select>
												<span class="input-group-btn">
													<button type="button" class="btn btn-primary product-click-new" id="pclick-0">Search here</button>
												</span>
											</div>
									</div>
								</div>
								
							</div>
							<div class="col-md-4 div_category">
								<div class="form-group">
									{!! Form::label('order_product_category', 'Product Category') !!}
									<div class="input-group">
										{!! Form::select('order_product_category', $p_category, null, ['class' => 'form-control psi_required order_product_category psi_draft_required input-new-prod pcat', 'placeholder'=>'Select Product Category']) !!}
										<div class="input-group-btn">
											<button class="btn btn-primary btn-show-cat-modal" type="button" title="Add new category">
												<i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
								</div>
								@include('partials.client.project._inputcat')
							</div>
							<div class="col-md-4 div_sub_category">
								<div class="form-group">
									{!! Form::label('product_sub_category', 'Product Sub-Category') !!}
									<div class="input-group">
										<select class="form-control psi_required order_product_sub_category psi_draft_required input-new-prod" name="product_sub_category" id="order_product_sub_category" required>
											<option value="">Select Sub-Product Category</option>
										</select>
										<div class="input-group-btn">
											<button class="btn btn-primary btn-add-sub-cat-modal" type="button" title="Add new sub-category">
												<i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
								</div>
								@include('partials.client.project._inputsubcat')
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('brand', 'Brand') !!}
									{!! Form::text('brand', null, ['class' => 'form-control brand psi_required psi_draft_required input-new-prod']) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('po_number', 'PO Number') !!}
									{!! Form::text('po_number', null, ['class' => 'form-control po_number psi_required psi_draft_required input-new-prod']) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('model_no', 'Model / Part No.') !!}
									{!! Form::text('model_no', null, ['class' => 'form-control model_no psi_required psi_draft_required input-new-prod']) !!}
								</div>
							</div>

							<div class="col-md-4 qty-modal">
								<div class="form-group fg_qty_psi">
									{!! Form::label('qty', 'Qty') !!}
									<div class="input-group input_qty_psi">
										<input type="text" class="form-control qty psi_required psi_draft_required input-new-prod" name="qty" id="qty" readonly required>
										<div class="input-group-btn">
											<button class="btn btn-primary btn-qty-modal" type="button" >
												<i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
								</div>
								@include('partials.client.supplier._newinspectionmodal')
							</div>
							<div class="row hidden">
								<div class="col-md-4">
									<div class="form-group" style="margin-left:15px;">
										{!! Form::label('addtnl_pinfo', 'Additional Product Info') !!}
										{!! Form::text('addtnl_pinfo', null, ['class' => 'form-control addtnl_pinfo input-new-prod']) !!}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-view-att" style="display:none">
									<button type="button" class="btn btn-primary view_prod_attachment_new" style="margin-left:15px;"><i class="fa fa-file"></i> View Attachments</button>
									<br/>
									<br/>
								</div>							
							</div>
							

				


						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 pull-right">
				<button type="button" class="btn btn-info pull-right" id="btn_product">
				<i class="fa fa-cube"></i> Add More Products
			</button>
		</div>
		<br>
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('requirement', 'Requirements') !!}
				{!! Form::textarea('requirement', null, ['class' => 'form-control requirement','rows'=>'4']) !!}
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('memo_psi', 'Memo / Notes') !!}
				{!! Form::textarea('memo_psi', null, ['class' => 'form-control memo_psi','rows'=>'4']) !!}
			</div>
		</div>
	
		<div class="col-md-12">
			<label>Other attachment</label>
			<div class="col-md-12 dropzone-container file_upload_psi" id="file_upload_container">
				<div class="dz-message default-dropzone-text" data-dz-message><span class="text-default">Drag files or click here to Upload</span></div>
				<div class="fallback">
					<input name="file[]" class="psi_required joe file" type="file" id="file" multiple required />
				</div>
			</div>
		</div>
	</div>
	<div class="">
		<div class="col-md-offset-10 col-md-2">
			<br/>
			<input type="hidden" id="hidden_client_id" value="{{$client_id}}">

			@if($supplierClientContact)
			<input type="hidden" id="client_cp" value="{{$supplierClientContact->id}}">
			@else
			<input type="hidden" id="client_cp" value="">
			@endif

			@if($supplierContactName)
			<input type="hidden" id="supplier_cp" value="{{$supplierContactName->id}}">
			@else
			<input type="hidden" id="supplier_cp" value="">
			@endif

			@if($create_order=="" || $create_order=="yes")
				{!! Form::button('<i class="fa fa-paper-plane"></i> Submit', ['class' => 'btn btn-success btn-block','id'=>'btn-psi-submit','type'=>'button']) !!}
			@else
				{!! Form::button('<i class="fa fa-paper-plane"></i> Submit', ['class' => 'btn btn-success btn-block disabled','type'=>'button']) !!}
			@endif
		</div>
	</div>		
<script>
	jQuery(document).ready(function(){
		getProductByClientCode('client');

		$('#psi_shipment_date').datepicker({
        	dateFormat: 'yy-mm-dd',
			defaultDate: "+1w",
			beforeShow: function() {
         		$(this).datepicker('option', 'minDate', $('#inspection_date').val());
          		if ($('#inspection_date').val() === '') $(this).datepicker('option', 'minDate', 0);                              
          	}
		});

		$('#inspection_date').change(function() {
			$('#psi_shipment_date').val('');
			console.log('psi inspection date on change...');
            //function for referenece number
            var client_code = $('#client').val();
            var inspect_date_val = $('#inspection_date').val();
            if (client_code != "") {
                $.ajax({
                    type: "GET",
                    url: '/getclientdbcountinspection-new/' + client_code + '/' + inspect_date_val,
                    success: function(data) {
                        $('#reference_number').val(data.ref_num);
                    },
                    error: function(err){
                        console.log('Reference Number Error: ' + err);
                        $('#reference_number').val('');
                    }
                });
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


		$('.psi_required').change(function() {
    	    var val = $(this).val();
    	    if (val == '' || val == null) {
    	        $(this).css("border", "1px solid red");
    	    } else {
    	        $(this).removeAttr("style");
    	    }
		});
		$('.cli_required').change(function() {
    	    var val = $(this).val();
    	    if (val == '' || val == null) {
    	        $(this).css("border", "1px solid red");
    	    } else {
    	        $(this).removeAttr("style");
    	    }
		});
		$('#fac_change_date').click(function(){
			if ($('#fac_change_date').prop('checked')==true) { 
				$('#fac_change_date').val('yes');
			}else{
				$('#fac_change_date').val('no');
			}
		});
		$('#loading_fac_change_date').click(function(){
			if ($('#loading_fac_change_date').prop('checked')==true) { 
				$('#loading_fac_change_date').val('yes');
			}else{
				$('#loading_fac_change_date').val('no');
			}
		});
	});

function getProductByClientCode(select_id){
	var client_code=$('#'+select_id).val();
	$.ajax({
    	type: "GET",
    	url: '/getproductbyclientcode/'+client_code,
    	success: function(data) {					
			console.log(data);	
			$('.product_name').empty();
			$('.product_name').append('<option value="">Select Product</option>');		
			$.each(data.products, function(i, element) {
				$('.product_name').append('<option value="' + element.id + '">' + element.product_name + '</option>');
			});
    	}
    });
}


function setRefNum(){
	var client_code=$('#hidden_client_code');
	if(client_code!=""){
		var d = new Date();
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

</script>

{!!Form::close()!!}
