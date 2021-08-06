@extends('layouts.new')
@section('title','Inspection List')
@section('page-title','Inspection List')

@section('stylesheets')
  {!! Html::style('/css/admin/dashboard.css') !!}
    <style>
        .content-header h1 {
			text-align: center;
			margin: 0 auto;
		}
    </style>
@endsection

@section('content')
    <div class="row">
    <div class="col-md-12">
	<div class="col-md-12 padding-b-25">
        <div class="table-responsive">
            <br> <br> 
            <table id="inspections_table" class="table table-condensed cell-bor small dataTable no-footer">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Report #</th>
                        <th>Product</th>
                        <th>PO #</th>
                        <th>Location</th>
                        <th>Inspector</th>                        
                        <th>Account Manager</th>                 
                        <th>Inspection Date</th>
                        <th>Status</th>
                        <th>Action</th>                    
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
</div>
    @include('partials.admin.dashboard._viewprojectdetails')
    @include('partials.admin.dashboard._publishdraft')
    @include('partials.admin.dashboard._cancelinspect')

    <div class="send-loading"></div>
@endsection

@section('scripts')
    {!! Html::script('/js/admin/panel-dev.js') !!}
    <script type="text/javascript">
        var token = "{{csrf_token()}}";
        var auth_id = "{{Auth::id()}}"; 
    </script>
@endsection
{{-- <script src="http://newapi.t-i-c.asia/js/jquery-3.1.1.min.js"></script> --}}
<script>
    //$(document).ready(function() {
    //    $('#inspections_table').DataTable({
    //        "order": [
    //             [7, "desc"]
    //         ],
    //        "processing": true,
    //        "serverSide": true,
    //        "ajax":{
    //                 "url": "{{ url('panel-get-data') }}",
    //                 "dataType": "json",
    //                 "type": "POST",
    //                 "data":{ _token: "{{csrf_token()}}"}
    //               },
    //        "columns": [
    //            { "data": "inspector" },
    //            { "data": "client" },
    //            { "data": "user" },
    //            { "data": "service" },
    //            { "data": "product" },
    //            { "data": "po_no" },
    //            { "data": "inspection_date" },
    //            { "data": "created_at" },
    //            { "data": "status" },
    //            { "data": "action" }
    //        ]	 
//
    //    });
    //});
</script>