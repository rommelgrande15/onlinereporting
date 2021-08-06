@extends('layouts.new')
@section('title','Home')
@section('page-title','Client Project Management ')

@section('stylesheets')
  {{ Html::style('/css/admin/dashboard.css') }}
@endsection

@section('content')
    <div class="row">
    <div class="col-md-12">
	<div class="col-md-12 padding-b-25">
        <h3 align="center">Client Booking List</h3>
        <div class="table-responsive">
            <div class="pull-right">
                <b>Filtered by :</b>
               <select class="form-control pull-right" id="engines" style="margin-bottom:5px;">
                    <option value="">All</option>
                    <option value="Pending">Pending</option>
                    <option value="Released">Released</option>
                </select>
                <br> <br> 
            </div>
            <br> <br> 
            <table id="inspections_table" class="table table-condensed cell-bor small dataTable no-footer">
                <thead>
                    <tr>
                        <th class="text-center">View</th>
                        <th class="text-center">Inspector</th>
                        <th class="text-center">Client</th>
                        <th class="text-center">User</th>
                        <th class="text-center">Service Type</th>                     
                        <th class="text-center">Product Name</th>
                        <th class="text-center">PO #</th>
                        <th class="text-center">Input Date</th>
                        <th class="text-center">Inspection Date</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>                    
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspections as $inspection)
                        {{-- @if($inspection->inspection_status=="Client Pending" || $inspection->inspection_status=="client pending")
                            <tr style="background-color:#ff7c72;color:white;">
                        @else
                            <tr>
                        @endif  --}}
                        <tr>        
                            <td class="text-center">                                 
                                @if($services[$inspection->service] == "CBPI - No Serial" || $services[$inspection->service] == "CBPI - with Serial" || $services[$inspection->service] == "CBPI - ISCE" || $services[$inspection->service] == "Container Loading Inspection")                       
                                    <button data-id="{{$inspection->id}}" class="btn btn-warning btn-xs btn_view_project_cbpi" title="View Project Details"><i class="fa  fa-eye"></i></button>                                               
                                @endif
                                @if($inspection->service=="site_visit")                       
                                    <button data-id="{{$inspection->id}}" class="btn btn-warning btn-xs btn_view_project_site" title="View Project Details"><i class="fa  fa-eye"></i></button>                                               
                                @endif
                                @if($services[$inspection->service] == "Pre Shipment Inspection" || $services[$inspection->service] == "During Production Inspection" || $services[$inspection->service] == "Incoming Quality Inspection" || $services[$inspection->service] == "Setting Up Production Lines" || $services[$inspection->service] == "FRI" || $services[$inspection->service] == "SPK")                    
                                    <button data-id="{{$inspection->id}}" class="btn btn-warning btn-xs btn_view_project" title="View Project Details"><i class="fa  fa-eye"></i></button>
                                @endif                                 
                            </td>
                            <td class="text-center">{{ ucwords($inspector_list[$inspection->inspector_id]) }}</td>
                            <td class="text-center">{{$inspection->client_name}}</td>
                            <td class="text-center">
                                @foreach ($user_manager as $user)                          
                                    @if($user->user_id==$inspection->created_by)
                                        {{$user->name}}
                                    @endif
                                @endforeach
                            </td>         
                            <td class="text-center">{{$services_new[$inspection->service]}}</td>
                            <td class="text-center">
                                @if($inspection->service=="cbpi" || $inspection->service=="cbpi_serial" || $inspection->service=="cbpi_isce" || $inspection->service=="cli" || $inspection->service=="site_visit")
                                    No product
                                @else
                                    @foreach ($psiproduct as $psi_prod)                          
                                        @if($psi_prod->inspection_id==$inspection->id)                                      
                                            ({{$psi_prod->product_name}})
                                        @endif
                                    @endforeach
                                @endif
                            </td> 
                            <td class="text-center">
                                @if($inspection->service=="cbpi" || $inspection->service=="cbpi_serial" || $inspection->service=="cbpi_isce" || $inspection->service=="cli" || $inspection->service=="site_visit")
                                    No PO
                                @else
                                    @foreach ($psiproduct as $psi_prod)                          
                                        @if($psi_prod->inspection_id==$inspection->id)
                                            ({{$psi_prod->po_no}})
                                        @endif
                                    @endforeach
                                @endif
                            </td> 
                            <td class="text-center">{{$inspection->created_at}}</td>
                            <td class="text-center">{{$inspection->inspection_date}}</td>    
                            <td class="text-center">
                                @if($inspection->inspection_status=="Client Pending" || $inspection->inspection_status=="client pending")
                                    <span class="text-warning text-bold">Pending</span>
                                @elseif($inspection->inspection_status=="Cancelled")
                                    <span class="text-danger text-bold">Cancelled</span>
                                @else
                                    <span class="text-success text-bold">{{$inspection->inspection_status}}</span>
                                @endif
                               
                            </td>                                                   
                            <td class="text-center">
                                @if($inspection->service=="cbpi" || $inspection->service=="cbpi_serial" || $inspection->service=="cbpi_isce" || $inspection->service=="cli")
                                    <a href="{{route('release-client-order-loading',$inspection->id)}}" class="btn btn-info btn-xs" title="Edit Project Details"><i class="fa  fa-pencil"></i></a>
                                @elseif($inspection->service=="site_visit")
                                    <a href="{{route('edit-project-site',$inspection->id)}}" class="btn btn-info btn-xs" title="Edit Project Details"><i class="fa  fa-pencil"></i></a>
                                @else
                                    <a href="{{route('release-client-order',$inspection->id)}}" class="btn btn-info btn-xs" title="Edit Project Details"><i class="fa  fa-pencil"></i></a>
                                @endif
                            </td>              
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
    @include('partials.admin.dashboard._viewprojectdetails')
    @include('partials.admin.dashboard._publishdraft')

    <div class="send-loading"></div>
@endsection

@section('scripts')
	{!! Html::script('/js/admin/panel-client-booking.js?v=2') !!}
@endsection
