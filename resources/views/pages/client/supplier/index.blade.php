@extends('layouts.client._new')
@section('title','Supplier Management')
@section('page-title','Supplier Management')
@section('stylesheets')
	@if(strpos(Request::url(''), 'tic-sera') !== false)
		{!! Html::style('/css/admin/dashboard-sera.css') !!}
	@else
		{!! Html::style('/css/admin/dashboard.css') !!}
	@endif
<style>

:root {
  /* larger checkbox */
}
:root label.checkbox-bootstrap input[type=checkbox] {
  /* hide original check box */
  opacity: 0;
  position: absolute;
  /* find the nearest span with checkbox-placeholder class and draw custom checkbox */
  /* draw checkmark before the span placeholder when original hidden input is checked */
  /* disabled checkbox style */
  /* disabled and checked checkbox style */
  /* when the checkbox is focused with tab key show dots arround */
}
:root label.checkbox-bootstrap input[type=checkbox] + span.checkbox-placeholder {
  width: 14px;
  height: 14px;
  border: 1px solid;
  border-radius: 3px;
  /*checkbox border color*/
  border-color: #737373;
  display: inline-block;
  cursor: pointer;
  margin: 0 7px 0 -20px;
  vertical-align: middle;
  text-align: center;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked + span.checkbox-placeholder {
  background: #727272;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked + span.checkbox-placeholder:before {
  display: inline-block;
  position: relative;
  vertical-align: text-top;
  width: 5px;
  height: 9px;
  /*checkmark arrow color*/
  border: solid white;
  border-width: 0 2px 2px 0;
  /*can be done with post css autoprefixer*/
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);
  content: "";
}
:root label.checkbox-bootstrap input[type=checkbox]:disabled + span.checkbox-placeholder {
  background: #ececec;
  border-color: #c3c2c2;
}
:root label.checkbox-bootstrap input[type=checkbox]:checked:disabled + span.checkbox-placeholder {
  background: #d6d6d6;
  border-color: #bdbdbd;
}
:root label.checkbox-bootstrap input[type=checkbox]:focus:not(:hover) + span.checkbox-placeholder {
  outline: 1px dotted black;
}
:root label.checkbox-bootstrap.checkbox-lg input[type=checkbox] + span.checkbox-placeholder {
  width: 26px;
  height: 26px;
  border: 2px solid;
  border-radius: 5px;
  /*checkbox border color*/
  border-color: #737373;
}
:root label.checkbox-bootstrap.checkbox-lg input[type=checkbox]:checked + span.checkbox-placeholder:before {
  width: 9px;
  height: 15px;
  /*checkmark arrow color*/
  border: solid white;
  border-width: 0 3px 3px 0;
}

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
					$create_supplier="";
					$update_supplier="";
					$delete_supplier="";
				@endphp
				@if($sub_acc=='yes')
					@if(!empty($privelege))
						@php 
							$create_supplier=$privelege->create_supplier;
							$update_supplier=$privelege->update_supplier;
							$delete_supplier=$privelege->delete_supplier;
						@endphp
						
						@if($create_supplier=='yes')
						<button class="btn btn-success" data-toggle="modal" data-target="#newSupplier"><i class="fa fa-plus"></i> Add New Supplier</button>
						@else
							<button class="btn btn-success disabled"><i class="fa fa-plus"></i> Add New Supplier</button>
						@endif
					@else
						<button class="btn btn-success disabled"><i class="fa fa-plus"></i> Add New Supplier</button>
					@endif		
				@else
				<button class="btn btn-success" data-toggle="modal" data-target="#newSupplier"><i class="fa fa-plus"></i> Add New Supplier</button>
				@endif
				

			</div>
			<br>
			<div class="table-responsive">
				<table id="factories_table" class="table table-condensed cell-border  small dataTable no-footer">
					<thead>
						<tr>
							<th class="text-left">Supplier Name</th>
							<th class="text-left">Supplier Code / Number</th>
							<th class="text-left">Supplier Address</th>
							
							<th class="text-left">Date Created</th>
							<th class="text-left">Date Modified</th>
							<th class="text-center">View / Edit / Delete</th>
							<th class="text-center">Factory</th>
						</tr>
					</thead>
					<tbody>
						@forelse($suppliers as $supplier)
						@if($supplier->supplier__status!='2' || $supplier->supplier__status!=2)
						<tr class="text-left">
							<td class="text-left">{!!$supplier->supplier_name!!}</td>
							<td class="text-left">{!!$supplier->supplier_number!!}</td>
							<td class="text-left">{!!$supplier->supplier_address!!}</td>
							
							<td class="text-left">{!! substr($supplier->created_at,0,10) !!}</td>
							<td class="text-left">{!! substr($supplier->updated_at,0,10) !!}</td>

							<td class="text-center">
								<div class="dropdown">
									<button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
									<ul class="dropdown-menu">
										{{-- <li><a data-id="{!!$supplier->id!!}" data-toggle="modal" data-target="#newFactory" title="View Details">Add New Factory</a></li> --}}
										<li><a data-id="{!!$supplier->id!!}" class="btn-add-factory" title="Add Factory">Add New Factory</a></li>
										<li><a data-id="{!!$supplier->id!!}" class="btn-view" title="View Details">View</a></li>
										@if($update_supplier=="" || $update_supplier=="yes")
										<li><a data-id="{!!$supplier->id!!}" class="btn-edit" title="Edit Details">Edit</a></li>
										@else
											<li class="disabled"><a title="Edit Details">Edit</a></li>
										@endif
										@if($delete_supplier=="" || $delete_supplier=="yes")
											<li><a data-id="{!!$supplier->id!!}" class="btn-delete" title="Delete Record">Delete</a></li>
										@else
											<li class="disabled"><a title="Delete Record">Delete</a></li>
										@endif
										
										
									</ul>
								</div>
							</td>
							<td class="text-center">
								@if(strpos(Request::url(''), 'tic-sera') !== false)
									<a href="{{route('view-factory-list-tic-sera',$supplier->id)}}" class="btn btn-warning btn-xs btn-view-fact" title="View Details"><i class="fa fa-eye"></i> View</a>
								@else
									<a href="{{route('view-factory-list',$supplier->id)}}" class="btn btn-warning btn-xs btn-view-fact" title="View Details"><i class="fa fa-eye"></i> View</a>
								@endif
							</td>
							
						</tr>
						@endif
						@empty
						No data
						@endforelse
					</tbody>
					<tfoot>
						<tr>
							<th class="text-center">.</th>
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
@include('partials.client.supplier._newfactorysupp')
@include('partials.client.supplier._newcontact')
@include('partials.client.supplier._newsupplier')
@include('partials.client.supplier._updatesupplier')
@include('partials.client.supplier._deletesupplier')
@include('partials.client.supplier._viewsupplier')
@include('partials.client.supplier._newfaccontactperson')
<div class="send-loading"></div>
@endsection
@section('scripts')
{!! Html::script('/js/client/supplier.js?v=1') !!}
@endsection
<script>
	var msg = '{!!Session::get('
	alert ')!!}';
	var exist = '{!!Session::has('
	alert ')!!}';
	if (exist) {
		alert(msg);
	}
	var auth_id = "{{Auth::id()}}";
	var token = "{{csrf_token()}}";

</script>
