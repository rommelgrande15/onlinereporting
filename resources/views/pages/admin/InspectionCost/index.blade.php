@extends('layouts.new')
@section('title','Inspection Cost Management')
@section('page-title','Inspection Cost')
@section('stylesheets')
  {{ Html::style('/css/admin/dashboard.css') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="col-md-12 padding-b-25">
                <h4>Client Cost</h4>
                    <br>
                    <div class="table-responsive">
                        <table id="InspectionCost_table" class="table table-condensed small dataTable no-footer">
                            <thead>
                                <tr>                        
                                    <th class="text-center">Client Project Number</th>
                                    <th class="text-center">Report Number</th>  
                                    <th class="text-center">Currency</th>  
                                    <th class="text-center">MD Charges($)</th>                        
                                    <th class="text-center">Travel Cost($)</th>
                                    <th class="text-center">Hotel Cost($)</th>{{-- 1 --}}
                                    <th class="text-center">OT Cost($)</th>{{-- 2 --}}
                                    <th class="text-center">Others($)</th>{{-- 3 --}}
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($client_cost as $cli_cost)
                                    <tr class="text-center">
                                        <td>{{$client_pn[$cli_cost->inspection_id]}}</td>
                                        <td>{{$client_rn[$cli_cost->inspection_id]}}</td>
                                        <td>{{$cli_cost->currency}}</td>
                                        <td>{{$cli_cost->md_charges}}</td>
                                        <td>{{$cli_cost->travel_cost}}</td>
                                        <td>{{$cli_cost->hotel_cost}}</td>
                                        <td>{{$cli_cost->ot_cost}}</td>
                                        <td>{{$cli_cost->md_charges}}</td>                                                                
                                        <td>
                                            <!-- <button data-id="0" class="btn btn-info btn-xs btn-view-cost-ins" title="View" data-id="{{$cli_cost->inspection_id}}"><i class="fa fa-eye"></i> </button>
                                            <button data-id="0" class="btn btn-danger btn-xs" title="Save as PDF"><i class="fa fa-file-pdf-o"></i> </button> -->
                                        </td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>


                    <h4>Inspector Cost</h4>
                    <br>
                    <div class="table-responsive">
                        <table id="InspectionCost_table2" class="table table-condensed small dataTable no-footer">
                            <thead>
                                <tr>
                                   {{--  <th class="text-center">View</th> --}}
                                
                                    <th class="text-center">Client Project Number</th>
                                    <th class="text-center">Report Number</th>    
                                    <th class="text-center">Currency</th>
                                    <th class="text-center">MD Charges($)</th>                        
                                    <th class="text-center">Travel Cost($)</th>
                                    <th class="text-center">Hotel Cost($)</th>{{-- 1 --}}
                                    <th class="text-center">OT Cost($)</th>{{-- 2 --}}
                                    <th class="text-center">Others($)</th>{{-- 3 --}}
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inspector_cost as $ins_cost)
                                    <tr class="text-center">
                                        <td>{{$client_pn[$ins_cost->inspection_id]}}</td>
                                        <td>{{$client_rn[$ins_cost->inspection_id]}}</td>
                                        <td>{{$ins_cost->currency}}</td>
                                        <td>{{$ins_cost->md_charges}}</td>
                                        <td>{{$ins_cost->travel_cost}}</td>
                                        <td>{{$ins_cost->hotel_cost}}</td>
                                        <td>{{$ins_cost->ot_cost}}</td>
                                        <td>{{$ins_cost->md_charges}}</td>                                                                
                                        <td>
                                           <!--  <button data-id="0" class="btn btn-info btn-xs btn-view-cost-cli" title="View" data-id="{{$ins_cost->inspection_id}}"><i class="fa fa-eye"></i> </button>
                                            <button data-id="0" class="btn btn-danger btn-xs" title="Save as PDF"><i class="fa fa-file-pdf-o"></i> </button> -->
                                        </td>
                                    </tr>
                                @endforeach 
                            </tbody>
                        </table>
                    </div>



                </div>
        </div>
    </div>
        @include('partials.admin.inspectioncost._viewclientcost')

    <div class="send-loading"></div>
    
@endsection

@section('scripts')
	{!! Html::script('/js/admin/InspectionCost.js') !!}
@endsection


