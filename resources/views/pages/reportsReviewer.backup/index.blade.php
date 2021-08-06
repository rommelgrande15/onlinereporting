@extends('layouts.reports_reviewer_template')

@section('title', 'Reports Reviewer')
@section('stylesheets')
{!! Html::style('/css/dropzone.css') !!}
@endsection


@section('topbar')

@endsection
@section('sidebar')

@endsection

@section('content')
<div class="row">
	<div class="col-md-12 padding-b-25">
		<h3>Inspections</h3>
		<div class="table-responsive">
			<table id="clients_table" class="display table table-condensed cell-border small dataTable no-footer">
				<thead>
					<tr>
						<th class="text-left">Reference #</th>
						<th class="text-left">Client Name</th>
						<th class="text-left">Date</th>
						<th class="text-left">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($inspections as $inspection)
					<tr>
						<td>{{$inspection->reference_number}}</td>
						<td>{{$inspection->client_name}}</td>
						<td>{{$inspection->created_at}}</td>
						<td>
							<a class="btn btn-xs btn-success" id="btn_select" data-id="{{$inspection->id}}" data-ref_no="{{$inspection->reference_number}}" data-toggle="tooltip" title="Upload Report"><i class="fa fa-upload"></i></a>
							<a class="btn btn-xs btn-primary btn_view" data-id="{{$inspection->id}}" data-ref_no="{{$inspection->reference_number}}" data-toggle="tooltip" title="Uploaded Report"><i class="fa fa-cloud"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@include('partials.reports_reviewer.dashboard._upload_report')
@include('partials.reports_reviewer.dashboard._view_report')

@endsection
@section('scripts')
{!! Html::script('/js/dropzone.js') !!}
{!! Html::script('/js/reports-reviewer/panel-reports_reviewer.js') !!}
<script>
	$(document).ready(function() {
		//$('#clients_table').DataTable();
		$('#clients_table').dataTable({

			"order": [
				[2, "desc"]
			],
			"columns": [
				null,
				null,
				null,
				{
					"orderable": false,
					"searchable": false
				}
			]
		});


		/*$('#reports_table').DataTable({
			serverSide: true
		});*/
		$('#reports_table').DataTable({
			serverSide: true,
			ajax: {
				url: '/view-uploaded-report',
				type: 'POST'
			}
		});
	});

</script>
@endsection
