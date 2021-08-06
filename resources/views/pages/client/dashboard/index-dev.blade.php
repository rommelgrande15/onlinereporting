@extends('layouts.client._new')
@section('title','My Orders')
@section('page-title','My Orders ')

@section('stylesheets')
@if(strpos(Request::url(''), 'tic-sera') !== false)
{!! Html::style('/css/admin/dashboard-sera.css') !!}
@else
{!! Html::style('/css/admin/dashboard.css') !!}
@endif
{{-- {!! Html::style('/css/admin/project.css') !!} --}}
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
    table.dataTable td:nth-child(9) {
		margin: 0 auto;
		align: center !important;
		text-align: center !important;
		padding-left: 3.3%;
		max-width: 100px;
	}

	table.dataTable td:nth-child(10) {
		margin: 0 auto;
		align: center !important;
		text-align: center !important;
		padding-left: 3.3%;
		padding-right: 3.3%;
		max-width: 100px;
	}

    table.dataTable td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .dropdown {
        position: absolute;
    }

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
                <table id="inspections_tbl" class="table table-condensed cell-border small dataTable no-footer">
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
{!! Html::script('/js/client/panel-client.js?v=4') !!}
<script>
    $(window).on('load', function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });

    $(document).ready(function() {
        $('#inspections_tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('panel-client-get-mrn') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{csrf_token()}}",
                    client_book: 'true'
                }
            },
            "order": [[ 7, "desc" ]],
            "columns": [{
                    "data": "client_project_number"
                },
                {
                    "data": "factory_name"
                },
                {
                    "data": "product_names"
                },
                {
                    "data": "model_no"
                },
                {
                    "data": "manday"
                },
                {
                    "data": "po_no"
                },
                {
                    "data": "inspection_status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "view_edit",
                    "orderable":false,
                    "searcheable":false
                },
                {
                    "data": "edit_cancel",
                    "orderable":false,
                    "searcheable":false
                }
            ]

        });
    });

</script>
@endsection
