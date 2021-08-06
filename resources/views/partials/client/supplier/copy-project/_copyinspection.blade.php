{!!Form::open(['id'=>'new_inspection_form','data-parsley-validate'=>'', 'route'=>'saveinspection','class'=>'form-inspection','enctype'=>'multipart/form-data'])!!}
	<div class="row">		
		<div class="col-md-12">
			<h4 class="heading">Inspection Details</h4>
            @foreach($clientName as $cname)
				<h4 style="color:green;"><span class="pull-right">Client Name : {{ $cname->client_name }}</span></h4>
				<input type="hidden" id="client" value="{{$cname->client_code}}"> 
				<input type="hidden" id="hidden_client_code" value="{{$cname->client_code}}">
			@endforeach
			<hr>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group" style="margin-left:18px;">
				    {!! Form::label('service', 'Service') !!}
				    {!! Form::select('service', $services, $inspection->service, ['class' => 'form-control service psi_required psi_draft_required', 'placeholder'=>'Select a Service', 'id'=>'service', 'readOnly'=>true ,'disabled'=>'']) !!}
			  	</div>
			</div>
		</div>
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
				{!! Form::text('inspection_date', null, ['class' => 'form-control psi_required inspection_date psi_draft_required','required'=>'']) !!}
				{{-- <label title="Selecting this will not allow the factory to postpone or advance the inspection date">
					<input type="checkbox" id="fac_change_date" name="fac_change_date" value="no"> Do not allow factory to change this date.
				</label> --}}
			</div>
		</div>

		
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('psi_shipment_date', 'Expected Shipment Date') !!}
				{!! Form::text('psi_shipment_date', null, ['class' => 'form-control psi_required inspection_date psi_draft_required','required'=>'']) !!}
				<br/><br/><br/>
			</div>
		</div>
	
		<div class="contact-select">	
			<div class="clone-inputs-contact-person">
				<div class="col-md-4">
					<div class="form-group">
						{!! Form::label('contact_person', 'Client Contact Person') !!}
						{{-- {!! Form::select('contact_person', $supplierContactNew, $get_cc->id, ['class' => 'form-control psi_required contact_persons psi_draft_required', 'placeholder'=>'Select Contact']) !!} --}}
						{!! Form::text('contact_person',  $get_cc->contact_person , ['class' => 'form-control psi_required contact_persons psi_draft_required','required'=>'','id'=>'contact_person','readOnly'=>'true']) !!}
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
					    {!! Form::label('contact_person_number', 'Contact Telephone Number') !!}
					    {!! Form::text('contact_person_number', $get_cc->tel_number, ['class' => 'form-control psi_required numeric contact_number psi_draft_required','required'=>'','id'=>'contact_number','readOnly'=>'true']) !!}
				  	</div>
				</div>	
				<div class="col-md-4">
					<div class="form-group">
					    {!! Form::label('contact_person_email', 'Email Address') !!}
					    {!! Form::text('contact_person_email', $get_cc->email_address, ['class' => 'form-control psi_required contact_email psi_draft_required','id'=>'email_address','readOnly'=>'true']) !!}
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
			<h4 class="heading">Factory & Supplier Details</h4>
			<hr>
		</div>

		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_name', 'Supplier Name') !!}
				{!! Form::text('supplier_name',  $supplier_info->supplier_name , ['class' => 'form-control cli_required numeric loading_supplier_name cli_draft_required','required'=>'','readOnly'=>'true']) !!}
                <input type="hidden" id="supplier" value="{{$inspection->supplier_id}}"> 
		  	</div>
		</div>
		<div class="col-md-8">
			<div class="form-group">
				{!! Form::label('supplier_address', 'Supplier Address') !!}
				@if($supplier_info)
					{!! Form::text('supplier_address', $supplier_info->supplier_address, ['class' => 'form-control psi_required supplier_address psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@else
					{!! Form::text('supplier_address', null, ['class' => 'form-control psi_required supplier_address psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@endif
			    
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_contact_person', 'Supplier Contact Person') !!}
				{{-- {!! Form::select('supplier_contact_person', $supplier_con_list, $inspection->supplier_contact_id, ['class' => 'form-control supplier_contact_person psi_required psi_draft_required', 'placeholder'=>'Select Supplier Contact Person']) !!} --}}
				{!! Form::text('supplier_contact_person',  $supplier_con_info->supplier_contact_person , ['class' => 'form-control supplier_contact_person psi_required psi_draft_required','required'=>'','id'=>'supplier_contact_person','readOnly'=>'true']) !!}
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_contact_number', 'Contact Telephone Number (Supplier)') !!}
				@if($supplier_con_info)
					{!! Form::text('supplier_contact_number', $supplier_con_info->supplier_tel_number, ['class' => 'form-control psi_required numeric supplier_contact_number psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@else
					{!! Form::text('supplier_contact_number', null, ['class' => 'form-control psi_required numeric supplier_contact_number psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@endif
			    
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('supplier_email', 'Email Address') !!}
				@if($supplier_con_info)
					{!! Form::text('supplier_email', $supplier_con_info->supplier_email, ['class' => 'form-control psi_required supplier_email psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@else
					{!! Form::text('supplier_email', null, ['class' => 'form-control psi_required supplier_email psi_draft_required','required'=>'','readOnly'=>'true']) !!}
				@endif
			    
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('factory', 'Factory Name') !!}
				{!! Form::select('factory', $factory_list, $get_factory->id, ['class' => 'form-control factory psi_required psi_draft_required', 'placeholder'=>'Select Factory',  'required'=>'']) !!}
		  	</div>
		</div>
		<div class="col-md-8">
			<div class="form-group">
			    {!! Form::label('factory_address', 'Factory Address') !!}
			    {!! Form::text('factory_address', $get_factory->factory_address, ['class' => 'form-control psi_required factory_address psi_draft_required','required'=>'','id'=>'factory_address','readOnly'=>'true']) !!}
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('factory_contact_person', 'Factory Contact Person') !!}
				{!! Form::select('factory_contact_person', $factory_con_list, $get_fc->id, ['class' => 'form-control psi_required factory_contact_person psi_required psi_draft_required', 'placeholder'=>'Select Contact Person',  'required'=>'']) !!}

		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('factory_contact_number', 'Contact Telephone Number (Factory)') !!}
			    {!! Form::text('factory_contact_number', $get_fc->factory_tel_number, ['class' => 'form-control psi_required numeric factory_contact_number psi_draft_required','required'=>'','id'=>'factory_contact_number','readOnly'=>'true']) !!}
		  	</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
			    {!! Form::label('factory_email', 'Email Address') !!}
			    {!! Form::text('factory_email', $get_fc->factory_email, ['class' => 'form-control psi_required factory_email psi_draft_required','required'=>'','id'=>'factory_email','readOnly'=>'true']) !!}
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
				<div class="col-md-12 text-right">
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
						@foreach($psiproducts as $psi)
						<div class="clone-inputs">
							<div class="row" style="margin-left:0.5px;">
								<div class="col-md-4">
									<div class="form-group" >										
											{!! Form::label('product_name', 'Product Name') !!}
											<div class="input-group">
												{!! Form::select('product_name', $products, $psi->product_id, ['class' => 'form-control psi_required product_name_new psi_draft_required s_pname', 'placeholder'=>'Select Product']) !!}
												<span class="input-group-btn">
													<button type="button" class="btn btn-primary product-click-new" id="pclick-0">Search here</button>
												</span>
											</div>
										<input type="hidden" class="edit_pid" value="{{$psi->id}}">
									</div>
								</div>
								
							</div>
							<div class="col-md-4 div_category">
								<div class="form-group">
									{!! Form::label('product_category', 'Product Category') !!}
									<div class="input-group">
											{!! Form::select('product_category', $p_category, $psi->product_first_category, ['class' => 'form-control psi_required psi_draft_required input-new-prod epc pcat s_pcat', 'placeholder'=>'Select Product Category']) !!}
										<div class="input-group-btn">
											<button class="btn btn-primary btn-show-cat-modal" type="button" title="Add new category">
												<i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
								</div>
								@include('partials.client.edit-project._inputcat')
							</div>
							<div class="col-md-4 div_sub_category">
								<div class="form-group">
									{!! Form::label('product_sub_category', 'Product Sub-Category') !!}
									<div class="input-group">
										{!! Form::select('product_sub_category', $p_category, null, ['class' => 'form-control psi_required psi_draft_required input-new-prod epsc s_scat', 'placeholder'=>'Select Sub-Product Category']) !!}
										<input type="hidden" class="epsc_value" value="{{$psi->product_category}}">
										<div class="input-group-btn">
											<button class="btn btn-primary btn-add-sub-cat-modal" type="button" title="Add new sub-category">
												<i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
								</div>
								@include('partials.client.edit-project._inputsubcat')
							</div>

							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('brand', 'Brand') !!}
									{!! Form::text('brand', $psi->brand, ['class' => 'form-control brand psi_required psi_draft_required input-new-prod s_brand']) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('po_number', 'PO Number') !!}
									{!! Form::text('po_number', $psi->po_no, ['class' => 'form-control po_number psi_required psi_draft_required input-new-prod s_po']) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('model_no', 'Model / Part No.') !!}
									{!! Form::text('model_no',  $psi->model_no, ['class' => 'form-control model_no psi_required psi_draft_required input-new-prod s_model']) !!}
								</div>
							</div>

							<div class="col-md-4 qty-modal">
								<div class="form-group">
									{!! Form::label('qty', 'Qty') !!}
									<div class="input-group">
										<input type="text" class="form-control qty psi_required psi_draft_required input-new-prod edit_qty s_qty" value="{{$psi->aql_qty}}" name="qty" id="qty" readonly required>
										<div class="input-group-btn">
											<button class="btn btn-primary edit-btn-qty-modal" type="button" >
												<i class="fa fa-plus"></i>
											</button>
										</div>
									</div>
								</div>
								@include('partials.client.edit-project._editinspectionmodal')
							</div>
							
							<div class="row">
								@if($attach_arr[$psi->product_id]==0)
									<div class="col-md-4 col-view-att" style="display:none">
										<button type="button" class="btn btn-primary view_prod_attachment_new" style="margin-left:15px;"><i class="fa fa-file"></i> View Attachments</button>
									</div>
								@else
									<div class="col-md-4 col-view-att" style="display:block">
										<button type="button" class="btn btn-primary view_prod_attachment_new" style="margin-left:15px;"><i class="fa fa-file"></i> View Attachments</button>
									</div>
								@endif
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<br>
										<button type="button" class="btn btn-danger btn-rm-perm pull-right" style="margin-right:10px;"><i class="fa fa-times"></i> Remove Product</button>
									</div>
								</div>
							</div>
						</div>
						@endforeach

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
				{!! Form::textarea('requirement', $inspection->requirement, ['class' => 'form-control requirement','rows'=>'4']) !!}
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				{!! Form::label('memo_psi', 'Memo / Notes') !!}
				{!! Form::textarea('memo_psi', $inspection->memo, ['class' => 'form-control memo_psi','rows'=>'4']) !!}
			</div>
		</div>
	
		<div class="col-md-12">
			<label>Product photos and other attachment</label>
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
			<input type="hidden" id="client" value="{{$client_code}}">
			{{-- <input type="hidden" id="hidden_client_code" value="{{$client_code}}"> --}}
			<input type="hidden" id="edit_inspection_id" value="{{$inspection->id}}">
			<input type="hidden" id="client_cp" value="{{$inspection->contact_person}}">
			<input type="hidden" id="supplier_cp" value="{{$inspection->supplier_contact_id}}">
			{!! Form::button('<i class="fa fa-paper-plane"></i> Submit', ['class' => 'btn btn-success btn-block','id'=>'btn-psi-submit','type'=>'button']) !!}
		</div>
	</div>
<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	$(document).ready(function(){
		setSubCat();

		$('.psi_required').change(function() {
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

		$('#inspection_date').change(function() {
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
		
		hideAql();

	});

	function hideAql(){
		var serv=$('#service').val();
		if(serv=='st'){
			$('#div_edit_hide_st').hide();
		}else{
			$('#div_edit_hide_st').show();
		}
	}

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

function setSubCat(){
	$('.epc').each(function(){
		var val = $(this).val();
		var sub_cat_class=$(this).closest('.clone-inputs').find('.epsc');
		var sub_cat_val=$(this).closest('.clone-inputs').find('.epsc_value').val();
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


</script>


{!!Form::close()!!}
