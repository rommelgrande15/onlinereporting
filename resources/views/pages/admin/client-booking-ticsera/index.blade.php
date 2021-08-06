@extends('layouts.new')
@section('title','Client Booking List - TIC-SERA')
@section('page-title','Client Booking List - TIC-SERA')

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
                        <th class="text-center">Inspector</th>
                        <th class="text-center">Client</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Project #</th>                     
                        <th class="text-center">Product</th>
                        <th class="text-center">PO #</th>
                        <th class="text-center">Inspection Date</th>            
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>                    
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
	{!! Html::script('/js/admin/panel-client-booking-ticsera.js') !!}
    <script type="text/javascript">
        var token = "{{csrf_token()}}";
    </script>
@endsection
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
