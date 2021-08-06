@extends('layouts.client._new2')
@section('title','My Orders')
@section('page-title','My Orders ')

@section('stylesheets')
    {{ Html::style('/css/admin/dashboard.css') }}
    {!! Html::style('/css/admin/project.css') !!}

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
        .content-header h1{
            border-bottom:3px solid orange; 
            width:20%; 
            text-align:center; 
            margin:0 auto;
        }



  </style>
@endsection

@section('content')
    <div class="row">
    <div class="col-md-12">
	<div class="col-md-12 padding-b-25">
        {{-- <h3>Inspections</h3> --}}
        <div class="table-responsive">
            <div class="pull-right">
                <b>Filtered by :</b>
               <select class="form-control pull-right" id="engines" style="margin-bottom:5px;">
                    <option value="">All</option>
                    <option value="Cancelled">Cancelled</option>
                    <option value="Waiting for approval">Waiting for approval</option>
                    <option value="On-going Inspection">On-going Inspection</option>
                    <option value="Finished">Finished</option>
                </select>
                <br> <br> 
            </div>
            <br> <br> 
            <table id="inspections_table" class="table table-condensed cell-border small dataTable no-footer">
                <thead>
                    <tr>
                        <th class="text-left">Project No.</th> 
                        <th class="text-left">Factory</th>                     
                        <th class="text-left">Product Name</th>
                        <th class="text-left">PO #</th>
                        <th class="text-left">Created</th>
                     
						
                       <!-- <th class="text-center">Shipment</th>-->
                       <th class="text-center">View / Track</th>
                        <th class="text-center">Edit / Cancel</th>
                        <th class="text-left">Status</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($inspections as $inspection)
                        @if($inspection->inspection_status=="Pending" || $inspection->inspection_status=="pending" || $inspection->inspection_status=="Client Pending")
                        <tr>
                            {{-- <tr style="background-color:#ff7c72;color:white;"> --}}
                        @else
                        <tr>
                        @endif        

                        <td class="text-left">{{$inspection->client_project_number}}</td>                 
                        <td class="text-left">{{$inspection->factory_name}}</td>
                        <td class="text-left">
                            @if($inspection->service=="cbpi" || $inspection->service=="cbpi_serial" || $inspection->service=="cbpi_isce" || $inspection->service=="cli" || $inspection->service=="site_visit")
                                No product
                            @else
                                @foreach ($psiproduct as $psi_prod)                          
                                    @if($psi_prod->inspection_id==$inspection->id)     
                                    {{$psi_prod->product_name}}             
    
                                    @endif
                                @endforeach
                            @endif
                        </td> 
                        <td class="text-left">
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
                        <td class="text-left">{{ substr($inspection->created_at,0,10) }}</td>                                                                  
                        <!--<td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-xs  btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action<span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Approve</a></li>
                                    <li><a href="#">Reject</a></li>
                                </ul>
                            </div>							                        
                        </td>  -->

                        <td class="text-left">
                            @if($inspection->inspection_status=="Client Pending")
                                <span class="text-primary">Waiting for approval</span>
                            @elseif($inspection->inspection_status=="Cancelled")
                                <span class="text-danger">Cancelled</span>
                            @elseif($inspection->inspection_status=="Released")
                                <span class="text-success">Approved</span>
                            @endif                          
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action<span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    @if($services[$inspection->service] == "CBPI - No Serial" || $services[$inspection->service] == "CBPI - with Serial" || $services[$inspection->service] == "CBPI - ISCE" || $services[$inspection->service] == "Container Loading Inspection")       
                                        <li><a  class="btn_view_project_cbpi" data-id="{{$inspection->id}}" >View</a></li>
                                    @elseif($services[$inspection->service] == "Pre Shipment Inspection" || $services[$inspection->service] == "During Production Inspection" || $services[$inspection->service] == "Incoming Quality Inspection" || $services[$inspection->service] == "Setting Up Production Lines" || $services[$inspection->service] == "FRI" || $services[$inspection->service] == "SPK")  
                                        <li><a  class="btn_view_project"  data-id="{{$inspection->id}}" >View</a></li>
                                    @endif

                                    @if($inspection->inspection_status=="Client Pending")
                                        <li><a  style="cursor: not-allowed;" >Track</a></li>
                                    @else
                                        <li><a href="{{ route('track-inspection', $inspection->id) }}"  >Track</a></li>
                                    @endif
                                </ul>
                            </div>

                        </td>    
                        <td class="text-center">                                                    
                            <div class="dropdown">
                                <button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action<span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('edit-project-client',$inspection->id)}}" title="Edit Order">Edit</a></li>
                                    <li><a href="{{route('copy-project',$inspection->id)}}" title="Repeat or Copy Order">Repeat / Copy</a></li>
                                    @if($inspection->inspection_status=="Cancelled" || $inspection->inspection_status=="Finished")
                                        <li><a class="btn_cancel" >Cancel</a></li>
                                    @else
                                        <li><a  title="Cancel Order" data-id="{{$inspection->id}}" data-fac="{{$inspection->factory_name}}" data-date="{{$inspection->inspection_date}}"  data-service="{{$services_client[$inspection->service]}}" class="btn_cancel" >Cancel</a></li>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</div>
    @include('partials.client.dashboard._viewprojectdetails')
    @include('partials.client.dashboard._cancelinspection')
    
    <div class="se-pre-con"></div>
    <div class="send-loading"></div>
@endsection

@section('scripts')
    {!! Html::script('/js/client/panel-client.js?n=1') !!}
    <script>
        $(window).on('load',function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
            //window.location.href="/account-settings";
        });
    </script>
@endsection
