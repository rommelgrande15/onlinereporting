@extends('layouts.client._new')
@section('title','My Orders')
@section('page-title','My Orders ')

@section('stylesheets')
	@if(strpos(Request::url(''), 'tic-sera') !== false)
		{!! Html::style('/css/admin/dashboard-sera.css') !!}
	@else
		{!! Html::style('/css/admin/dashboard.css') !!}
	@endif
{{-- 	{!! Html::style('/css/admin/project.css') !!} --}}
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
			width: 20%;
			text-align: center;
			margin: 0 auto;
		}
		table.dataTable td:nth-child(3) {
  max-width: 100px;
}
table.dataTable td:nth-child(4) {
  max-width: 100px;
}

table.dataTable td:nth-child(5) {
  max-width: 100px;
}
table.dataTable td  {
  white-space: nowrap;
  text-overflow: ellipsis;
  overflow: hidden;
}

.dropdown{position:absolute;}

	</style>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="col-md-12 padding-b-25">
			<div class="table-responsive">
				{{-- <div class="pull-right">
					<b>Filtered by :</b>
					<select class="form-control pull-right" id="engines" style="margin-bottom:5px;">
						<option value="">All</option>
						<option value="Cancelled">Cancelled</option>
						<option value="Waiting for approval">Waiting for approval</option>
						<option value="On-going Inspection">On-going Inspection</option>
						<option value="Finished">Finished</option>
					</select>
					<br> <br>
				</div> --}}
				<br> <br>
				<table id="inspections_table" class="table table-condensed cell-border small dataTable no-footer">
					<thead>
						<tr>
							<th class="text-left">Project No.</th>
							<th class="text-left">Factory</th>
							<th class="text-left">Product Name</th>
							<th class="text-left">Model / Part No.</th>
							<th class="text-left">Manday</th>
							<th class="text-left">PO #</th>
							<th class="text-left">Status</th>
							<th class="text-left">Created</th>
							<th class="text-center">View / Track</th>
							<th class="text-center">Edit / Cancel</th>
						</tr>
					</thead>
					<tbody>
						@php 
							$edit_order="";
							$copy_order="";
							$cancel_order="";
							$delete_order="";
						@endphp
						@if($sub_acc=='yes' && !empty($privelege))
							@php 
								$edit_order=$privelege->edit_order;
								$copy_order=$privelege->copy_order;
								$cancel_order=$privelege->cancel_order;
								$delete_order=$privelege->delete_order;
							@endphp
						@endif
						@foreach($inspections as $inspection)
							@if($inspection->inspection_status=="Pending" || $inspection->inspection_status=="pending" || $inspection->inspection_status=="Client Pending")
							<tr>
								@else
							<tr>
								@endif
								<td class="text-left">{{$inspection->client_project_number}}</td>
								<td class="text-left">{!!$inspection->factory_name!!}</td>
								<td class="text-left">
									@if($inspection->service=="cbpi" || $inspection->service=="cbpi_serial" || $inspection->service=="cbpi_isce" || $inspection->service=="cli" || $inspection->service=="site_visit" || $inspection->service == 'physical' || $inspection->service == 'detail' || $inspection->service == 'social')
										No product
									@else
										@foreach ($psiproduct as $psi_prod)
											@if($psi_prod->inspection_id==$inspection->id)
												({!!$psi_prod->product_name!!})
											@endif
										@endforeach
									@endif
								</td>
								<td class="text-left">
									@if($inspection->service=="cbpi" || $inspection->service=="cbpi_serial" || $inspection->service=="cbpi_isce" || $inspection->service=="cli" || $inspection->service=="site_visit" || $inspection->service == 'physical' || $inspection->service == 'detail' || $inspection->service == 'social')
										No PO
									@else
										@foreach ($psiproduct as $psi_prod)
											@if($psi_prod->inspection_id==$inspection->id)
												({{$psi_prod->model_no}})
											@endif
										@endforeach
									@endif
								</td>
								<td class="text-left">
									@if($inspection->manday > 0)
										{{ $inspection->manday }}
									@else
									N/A
									@endif
								</td>
								<td class="text-left">
									@if($inspection->service=="cbpi" || $inspection->service=="cbpi_serial" || $inspection->service=="cbpi_isce" || $inspection->service=="cli" || $inspection->service=="site_visit" || $inspection->service == 'physical' || $inspection->service == 'detail' || $inspection->service == 'social')
										No PO
									@else
										@foreach ($psiproduct as $psi_prod)
											@if($psi_prod->inspection_id==$inspection->id)
												({{$psi_prod->po_no}})
											@endif
										@endforeach
									@endif
								</td>
								<td class="text-left">
									@if($inspection->inspection_status=="Client Pending")
										<span class="text-primary">Waiting for approval</span>
									@elseif($inspection->inspection_status=="Cancelled")
										<span class="text-danger">Cancelled</span>
									@elseif($inspection->inspection_status=="Released" )
										<span class="text-success">Approved</span>
									@elseif($inspection->inspection_status=="Shipment Accepted")
										<span class="text-success">Shipment Accepted</span>
									@elseif($inspection->inspection_status=="Report Released")
										<span class="text-success">Report Released</span>
									@elseif($inspection->inspection_status=="Shipment Rejected")
										<span class="text-danger">Shipment Rejected</span>
									@elseif($inspection->inspection_status=="Hold" )
										<span class="text-danger">Hold / Under Review</span>
									@endif
								</td>
								<td class="text-left">{{ substr($inspection->created_at,0,10) }}</td>
								<td class="text-center">
									<div class="dropdown" >
										<button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action<span class="caret"></span></button>
										<ul class="dropdown-menu " >
											<li><a class="btn_view_project" data-id="{{$inspection->id}}">View</a></li>
											{{-- @if($services[$inspection->service] == "Container Loading Inspection")
												<li><a class="btn_view_project" data-id="{{$inspection->id}}">View</a></li>
											@else
												<li><a class="btn_view_project" data-id="{{$inspection->id}}">View</a></li>
											@endif --}}

											@if($inspection->inspection_status=="Client Pending")
												<li><a style="cursor: not-allowed;">Track</a></li>
											@else
												@if(strpos(Request::url(''), 'tic-sera') !== false)
													<li><a href="{{ route('track-inspection-tic-sera', $inspection->id) }}">Track</a></li>
												@else
													<li><a href="{{ route('track-inspection', $inspection->id) }}">Track</a></li>
												@endif
											@endif
										</ul>
									</div>

								</td>
								<td class="text-center">
									<div class="dropdown" >
										<button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action<span class="caret"></span></button>
										<ul class="dropdown-menu" >
											@if($services[$inspection->service] == "Container Loading Inspection" || $inspection->service == "physical"  || $inspection->service == "detail"  || $inspection->service == "social" || $inspection->service == "CBPI" || $inspection->service == "cbpi")
												
												@if(strpos(Request::url(''), 'tic-sera') !== false)
													@if($edit_order=="" || $edit_order=="yes")
														<li><a href="{{route('edit-project-client-cli-tic-sera',$inspection->id)}}" title="Edit Order"><small>Edit</small></a></li>
													@else
														<li class="disabled"><a href="#" title="Edit Order"><small>Edit</small></a></li>
													@endif

													@if($copy_order=="" || $copy_order=="yes")
														<li><a href="{{route('copy-project-cli-tic-sera',$inspection->id)}}" title="Repeat or Copy Order"><small>Repeat / Copy</small></a></li>
													@else
														<li class="disabled"><a href="#" title="Repeat or Copy Order"><small>Repeat / Copy</small></a></li>
													@endif
												@else
													@if($edit_order=="" || $edit_order=="yes")
														<li><a href="{{route('edit-project-client-cli',$inspection->id)}}" title="Edit Order"><small>Edit</small></a></li>
													@else													
														<li class="disabled"><a href="#" title="Edit Order"><small>Edit</small></a></li>
													@endif

													@if($copy_order=="" || $copy_order=="yes")
														<li><a href="{{route('copy-project-cli',$inspection->id)}}" title="Repeat or Copy Order"><small>Repeat / Copy</small></a></li>		
													@else
														<li class="disabled"><a href="#" title="Repeat or Copy Order"><small>Repeat / Copy</small></a></li>
													@endif
												@endif
											@else
												@if(strpos(Request::url(''), 'tic-sera') !== false)
													@if($edit_order=="" || $edit_order=="yes")
														<li><a href="{{route('edit-project-client-tic-sera',$inspection->id)}}" title="Edit Order"><small>Edit</small></a></li> 
													@else													
														<li class="disabled"><a href="#" title="Edit Order"><small>Edit</small></a></li>
													@endif

													@if($copy_order=="" || $copy_order=="yes")
														<li><a href="{{route('copy-project-tic-sera',$inspection->id)}}" title="Repeat or Copy Order"><small>Repeat / Copy</small></a></li>
													@else
														<li class="disabled"><a href="#" title="Repeat or Copy Order"><small>Repeat / Copy</small></a></li>
													@endif
												@else
													@if($edit_order=="" || $edit_order=="yes")
														<li><a href="{{route('edit-project-client',$inspection->id)}}" title="Edit Order"><small>Edit</small></a></li>	
													@else
														<li class="disabled"><a href="#" title="Edit Order"><small>Edit</small></a></li>
													@endif
													@if($copy_order=="" || $copy_order=="yes")
														<li><a href="{{route('copy-project',$inspection->id)}}" title="Repeat or Copy Order"><small>Repeat / Copy</small></a></li>
													@else
														<li class="disabled"><a href="#" title="Repeat or Copy Order"><small>Repeat / Copy</small></a></li>
													@endif
														
												@endif
											@endif
											
											@if($inspection->inspection_status=="Cancelled" || $inspection->inspection_status=="Finished")
												<li><a class="btn_cancel"><small>Cancel</small></a></li>
											@else
												@if($cancel_order=="" || $cancel_order=="yes")
													<li><a title="Cancel Order" data-id="{{$inspection->id}}" data-fac="{{$inspection->factory_name}}" data-date="{{$inspection->inspection_date}}" data-service="{{$services_client[$inspection->service]}}" class="btn_cancel"><small>Cancel</small></a></li>
												@else
													<li class="disabled"><a href="#" title="Cancel Order"><small>Cancel</small></a></li>
												@endif
											@endif
											@if($delete_order=="" || $delete_order=="yes")
												<li><a  title="Delete Order" data-id="{{$inspection->id}}" data-fac="{{$inspection->factory_name}}" data-date="{{$inspection->inspection_date}}"  data-service="{{$services_client[$inspection->service]}}" class="btn_delete" ><small>Delete</small></a></li>
											@else
												<li class="disabled"><a href="#" title="Delete Order"><small>Delete</small></a></li>
											@endif
										</ul>
									</div>
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
@include('partials.client.dashboard._viewprojectdetails')
@include('partials.client.dashboard._cancelinspection')
@include('partials.client.dashboard._deleteinspection')
<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
{!! Html::script('/js/client/panel-client.js?v=7') !!}
<script>
	$(window).on('load', function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});
</script>
@endsection
