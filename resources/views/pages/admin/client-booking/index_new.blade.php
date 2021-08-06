@extends('layouts.new')
@section('title','Client Booking List - TIC')
@section('page-title','Client Booking List - TIC')

@section('stylesheets')
  {!! Html::style('/css/admin/dashboard.css') !!}
  {!! Html::style('/css/admin/project.css') !!}
    <style>
        .content-header h1{
			text-align: center;
			margin: 0 auto;
		}
        /* #inspections_table{
            table-layout: fixed;
        } */
        /* .dataTable td {
            max-width: 200px;
            min-width: 70px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        } */
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
      
        <div class="col-md-12">
            <form class="form-inline" action="" method="post">
                {!!csrf_field()!!}
                <div class="form-group margin-right-twenty">
                    <select class="form-control inspection_status" required data-parsley-required-message="Please select here!" data-parsley-errors-container=".inspection_status" name="inspection_status" id="inspection_status">
                        <option value="">Select Inspection Status</option>
                        <option value="Client Pending">Pending</option>
                        <option value="Released">Released</option>
                        <option value="Hold">Hold</option>
                    </select> 
                </div> 
            </form>
        </div>

	<div class="col-md-12 padding-b-25">
        <div class="table-responsive">
        <br> <br> 
            <table id="inspections_table" class="table table-condensed cell-bor small dataTable no-footer">
                <thead>
                    <tr>
                        <th class="">Client<span class="arrow-icon"></span></th>
                        <th class="">User<span class="arrow-icon"></span></th>
                        <th class="">Report #<span class="arrow-icon"></span></th>                     
                        <th class="">Product<span class="arrow-icon"></span></th>
                        <th class="">PO #<span class="arrow-icon"></span></th>
                        <th class="">Inspection Date<span class="arrow-icon"></span></th>
                        <th class="">Created At<span class="arrow-icon"></span></th>             
                        <th class="">Status<span class="arrow-icon"></span></th>
                        <th class="">Action</th>                    
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
</div>
    @include('partials.admin.dashboard._viewprojectdetails')
    @include('partials.admin.dashboard._publishdraft')
    @include('partials.admin.client-booking._deleteinspect')

    <div class="send-loading"></div>
@endsection

@section('scripts')
	{!! Html::script('/js/admin/panel-client-booking.js?v=8') !!}
    <script type="text/javascript">
        var token = "{{csrf_token()}}";
    </script>
<script>
    $(document).ready(function() {
       
    
        $('#inspection_status').change(function(){
            var status = $('#inspection_status').val();
            $("#inspections_table").dataTable().fnDestroy();
            $('#inspections_table').DataTable({
                "order": [
                    [6, "desc"]
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/client-book-data-status",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: token,
                        status:status
                    }
                },
                "columns": [
                    {
                        "data": "client",
                        "name": "client"
                    },
                    {
                        "data": "created_by",
                        "name": "created_by"
                    },
                    {
                        "data": "client_project_number",
                        "name": "client_project_number"
                    },
                    {
                        "data": "p_name",
                        "name": "p_name"
                    },
                    {
                        "data": "po",
                        "name": "po"
                    },
                    {
                        "data": "inspection_date",
                        "name": "inspection_date"
                    },
                    {
                        "data": "created_at",
                        "name": "created_at"
                    },
                    {
                        "data": "status",
                        "name": "status"
                    },
                    {
                        "data": "action",
                        "name": "action"
                    }
                ]

            });
            
        });       
    });    
</script>
@endsection
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

