@extends('layouts.client._new')
@section('title','Product Management')
@section('page-title','Product Management')
@section('stylesheets')
{!! Html::style('/js/dropzone/dropzone3.css') !!}
	@if(strpos(Request::url(''), 'tic-sera') !== false)
		{!! Html::style('/css/admin/dashboard-sera.css') !!}
	@else
		{!! Html::style('/css/admin/dashboard.css') !!}
	@endif
<style>
	.fa-loader {
		-webkit-animation: spin 2s linear infinite;
		-moz-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
	}

	@-moz-keyframes spin {
		100% {
			-moz-transform: rotate(360deg);
		}
	}

	@-webkit-keyframes spin {
		100% {
			-webkit-transform: rotate(360deg);
		}
	}

	@keyframes spin {
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	.content-header h1 {
		border-bottom: 3px solid orange;
		width: 30%;
		text-align: center;
		margin: 0 auto;
	}

</style>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 padding-b-25">
			<div class="buttons">
				@php 
					$create_product="";
					$copy_product="";
					$update_product="";
					$delete_product="";
				@endphp
				@if($sub_acc=='yes')
					@if(!empty($privelege))
						@php 
							$create_product=$privelege->create_product;
							$copy_product="";
							$update_product=$privelege->update_product;
							$delete_product=$privelege->delete_product;
						@endphp
						
						@if($create_product=='yes')
							<button class="btn btn-success" data-toggle="modal" data-target="#newProduct"><i class="fa fa-plus"></i> Add New Product</button>
						@else
							<button class="btn btn-success disabled"><i class="fa fa-plus"></i> Add New Product</button>
						@endif
					@else
						<button class="btn btn-success disabled"><i class="fa fa-plus"></i> Add New Product</button>
					@endif		
				@else
					<button class="btn btn-success" data-toggle="modal" data-target="#newProduct"><i class="fa fa-plus"></i> Add New Product</button>
				@endif
			</div>
			<div class="table-responsive">
				<br>
				<table id="inspections_table" class="table table-condensed cell-border small dataTable no-footer">
					<thead>
						<tr>
							<th class="text-left">Product Name</th>
							{{-- <th class="text-center">Product Number</th> --}}
							{{-- <th class="text-center">Category</th>   --}}
							<!--<th class="text-center">Sub-category</th>-->
							<th class="text-left">Brand</th>

							<th class="text-left">Model / Part Number</th>
							<!--<th class="text-center">Additional Info</th>-->

							<th class="text-left">Date Created</th>
							<th class="text-left">Date Modified</th>
							<th class="text-center">View / Edit / Delete</th>
						</tr>
					</thead>
					<tbody>
						@foreach($products as $product)
						<tr>
							<td class="text-left">{{$product->product_name}}</td>
							{{-- <td class="text-center">{{$product->product_number}}</td> --}}
							{{-- <td class="text-center">{{$product->product_category}}</td> --}}
							<td class="text-left">{{$product->brand}}</td>
							<td class="text-left">{{$product->model_no}}</td>
							<!--<td class="text-center">{{$product->additional_product_info}}</td>-->

							<td class="text-left">{{ substr($product->created_at,0,10) }}</td>
							<td class="text-left">{{ substr($product->updated_at,0,10) }}</td>
							<td class="text-center">
								<div class="dropdown">
									<button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
									<ul class="dropdown-menu">
										<li><a class="view-product" data-id="{{$product->id}}" title="View Product">View</a></li>
										@if($update_product=="" || $update_product=="yes")
											<li><a class="edit-client-picture" data-id="{{$product->id}}" title="Edit Product">Edit</a></li>
										@else
											<li class="disabled"><a title="Edit Product">Edit</a></li>
										@endif
										@if($copy_product=="" || $copy_product=="yes")
											<li><a class="Copy-client-picture" data-id="{{$product->id}}" title="Copy Product">Copy</a></li>
										@else
											<li  class="disabled"><a title="Copy Product">Copy</a></li>
										@endif
										
										@if($delete_product=="" || $delete_product=="yes")
											<li><a class="delete-product" data-name="{{$product->product_name}}" data-id="{{$product->id}}" title="Delete Product">Delete</a></li>
										@else
											<li class="disabled"><a  title="Delete Product">Delete</a></li>
										@endif

									</ul>
								</div>
								{{-- <button class="btn btn-warning btn-xs view-product" data-id="{{$product->id}}" title="View Product"><i class="fa fa-eye"></i></button>
								<button class="btn btn-warning btn-xs edit-client-picture" data-id="{{$product->id}}" title="Edit Product"><i class="fa fa-pencil"></i></button>
								<button class="btn btn-warning btn-xs delete-product" data-name="{{$product->product_name}}" data-id="{{$product->id}}" title="Delete Product"><i class="fa fa-times"></i></button> --}}
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
							<th class="text-center">.</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>
@include('partials.client.product._newproduct')
@include('partials.client.product._copyproduct')
@include('partials.client.product._editproduct')
@include('partials.client.product._deleteproduct')
@include('partials.client.product._viewproduct')
@include('partials.client.product._inputcategory')
@include('partials.client.product._inputsubcategory')
@include('partials.client.product._inputsubcategoryedit')
<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(window).on('load', function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});
	var auth_id = "{{Auth::id()}}";
	var token = "{{csrf_token()}}";
	var pdf_icon = "{{asset('images/icons/pdf.png')}}";
	var doc_icon = "{{asset('images/icons/doc.png')}}";
	var xls_icon = "{{asset('images/icons/xls.png')}}";
	var ppt_icon = "{{asset('images/icons/ppt.png')}}";
	var pub_icon = "{{asset('images/icons/pub.png')}}";
	var rar_icon = "{{asset('images/icons/rar.png')}}";

</script>
{!! Html::script('/js/client/product.js?v=5') !!}
@endsection
