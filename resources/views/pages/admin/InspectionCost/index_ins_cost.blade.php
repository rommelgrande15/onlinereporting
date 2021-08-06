@extends('layouts.new')
@section('title','Inspection Cost Management')
@section('page-title','Inspector Cost / Invoice')
@section('stylesheets')
    {!! Html::style('/css/admin/dashboard.css') !!}
    {!! Html::style('/css/admin/project.css') !!}
    <style>
        .content-header h1 {
			text-align: center;
			margin: 0 auto;
		}
        .dt-loading {
            margin:0 auto;
            width: 15%;
            height: 15vh;
            z-index: 9999;
            background: url('/images/loader-64x/loader.gif') center no-repeat rgba(255,255,255,0.5);
            background-size:cover;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="col-md-12 padding-b-25">
                    <br>
                    <div class="table-responsive">
                        <table id="client_cost" class="table table-condensed small dataTable no-footer">
                            <thead>
                                <tr>                        
                                    <th >Client Name</th>
                                    <th >Project Number</th>
                                    <th >Reference Number</th>  
                                    <th >Currency</th> 
                                    <th >Total Cost</th>  
                                    <th >Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
        </div>
    </div>
    @include('partials.admin.inspectioncost._viewclientcost')

    <div class="se-pre-con"></div>
    <div class="send-loading"></div>
    
@endsection
<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/admin/inspection-cost.js')}}"></script>
<script>
    $(window).on('load',function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
    $(document).ready(function() {
        $('#client_cost').DataTable({
            "order": [
                 [0, "desc"]
             ],
            "processing": true, 
            "serverSide": true,
            "ajax":{
                     "url": "/client-cost-data",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "client_name" },
                { "data": "client_pn" },
                { "data": "report_no" },
                { "data": "currency" },
                { "data": "total_cost" },
                { "data": "actions" }
            ]	 
        });
    });
</script>



