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
        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc,
        table.dataTable thead .sorting_asc_disabled,
        table.dataTable thead .sorting_desc_disabled
        {
            background: none;
        }
        .arrow-icon{
            margin-left: 5px;
        }
        .sorting .arrow-icon {
            background: url('/images/sort_both.png') no-repeat top left;
            position: absolute;
            height: 17px;
            width: 15px;
            background-size: 19px 19px;
        }
        .sorting_asc .arrow-icon {
            background: url('/images/sort_asc.png') no-repeat top left;
            position: absolute;
            height: 17px;
            width: 15px;
            background-size: 19px 19px;
        }
        .sorting_desc .arrow-icon {
            background: url('/images/sort_desc.png') no-repeat top left;
            position: absolute;
            height: 17px;
            width: 15px;
            background-size: 19px 19px;
        }
        .sorting_asc_disabled .arrow-icon {
            background: url('/images/sort_asc_disabled.png') no-repeat top left;
            position: absolute;
            height: 17px;
            width: 15px;
            background-size: 19px 19px;
        }
        .sorting_desc_disabled .arrow-icon {
            background: url('/images/sort_desc_disabled.png') no-repeat top left;
            position: absolute;
            height: 17px;
            width: 15px;
            background-size: 19px 19px;
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
                <thead class="table-header">
                    <tr>
                        <th>Client<span class="arrow-icon"></span></th>
                        <th>Service<span class="arrow-icon"></span></th>
                        <th>Report #<span class="arrow-icon"></span></th>
                        <th>Product<span class="arrow-icon"></span></th>
                        <th>PO #<span class="arrow-icon"></span></th>
                        <th>Location<span class="arrow-icon"></span></th>
                        <th>Inspector<span class="arrow-icon"></span></th>                        
                        <th>Account Manager<span class="arrow-icon"></span></th>                 
                        <th>Inspection Date<span class="arrow-icon"></span></th>
                        <th>Status<span class="arrow-icon"></span></th>
                        <th>Action</th>                    
                    </tr>
                </thead>
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
    {!! Html::script('/js/admin/panel-mrn.js?v=4') !!}
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