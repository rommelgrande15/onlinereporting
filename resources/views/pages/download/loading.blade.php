@extends('layouts.wide')
@section('title','Download Report')
@section('stylesheets')
  {{ Html::style('/css/reports/loading.css') }}
@endsection

@section('content')
    <table class="table" width="100%" border>
    	<tr>
    		<td class="table-header-background-color-red text-center bold" colspan="6">
    			CBPI REPORT
    		</td>
    	</tr>
    	<tr>
    		<td>Reference:</td>
    		<td colspan="3">{{$inpect_info->report_number}}</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-grey bold" colspan="6">
    			1. General Information
    		</td>
    	</tr>
    	<tr>
    		<td class="bold">Date:</td>
    		<td>{{$inpect_info->inspection_date}}</td>
    		<td class="bold">Place of inspection:</td>
    		<td>{{$inpect_info->factory_address}}</td>
    	</tr>
    	<tr>
    		<td class="bold">Client Name:</td>
    		<td colspan="3">{{$inpect_info->supplier_name}}</td>
    	</tr>
    	<tr>
    		<td class="bold">Supplier Name:</td>
    		<td colspan="3">{{$inpect_info->supplier_name}}</td>
    	</tr>
    	<tr>
    		<td class="bold">Factory Name:</td>
    		<td colspan="3">{{$inpect_info->supplier_name}}</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-grey bold" colspan="6">
    			2. Inspection Checklist
    		</td>
    	</tr>
    	<tr>
    		<td class="fill-with-image" colspan="6">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/checklist/'.$checklist->image_path) }}">
    		</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-grey bold" colspan="6">
    			3. Supplier Overview
    		</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Factory Location
    		</td>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Factory Gate
    		</td>
    	</tr>
    	<tr>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/supplier/'.$supplier->factory_location)}}">
    		</td>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/supplier/'.$supplier->factory_gate)}}">
    		</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Warehouse Picture
    		</td>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Loading Area
    		</td>
    	</tr>
    	<tr>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/supplier/'.$supplier->warehouse)}}">
    		</td>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/supplier/'.$supplier->loading_area)}}">
    		</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-grey bold" colspan="6">
    			4. Cargo Information
    		</td>
    	</tr>
    	<tr>
    		<td colspan="3" class="bold">Inspector Arrival Time</td>
    		<td colspan="3">{{$cargo->inspector_arrival_time}}</td>
    	</tr>
    	<tr>
    		<td colspan="3" class="bold">Cargo Ready Time</td>
    		<td colspan="3">{{$cargo->cargo_ready_time}}</td>
    	</tr>
    	<tr>
    		<td colspan="3" class="bold">Container Arrival Time</td>
    		<td colspan="3">{{$cargo->container_arrival_time}}</td>
    	</tr>
    	<tr>
    		<td colspan="3" class="bold">Loading Started</td>
    		<td colspan="3">{{$cargo->loading_started}}</td>
    	</tr>
    	<tr>
    		<td colspan="3" class="bold">Inspection Finished</td>
    		<td colspan="3">{{$cargo->inspection_finished}}</td>
    	</tr>
    	<tr>
    		<td colspan="3" class="bold">Loading Facility Cooperation</td>
    		<td colspan="3" class="capitalize">{{$cargo->loading_facility_cooperation}}</td>
    	</tr>
    	<tr>
    		<td colspan="3" class="bold">Container Number</td>
    		<td colspan="3" class="bold-red-text">{{$cargo->container_number}}</td>
    	</tr>
    	<tr>
    		<td class="bold">Shipping Seal No.</td>
    		<td class="bold-red-text">{{$cargo->shipping_seal_number}}</td>
    		<td class="bold">SERA Seal No.</td>
    		<td class="bold-red-text">{{$cargo->sera_seal_number}}</td>
    	</tr>
    	<tr>
    		<td class="bold">Container Size</td>
    		<td class="bold-red-text uppercase">{{$cargo->container_size}}</td>
    		<td class="bold">Container Status</td>
    		<td class="bold-red-text capitalize">{{$cargo->container_status}}</td>
    	</tr>
    	<tr>
    		<td class="bold" colspan="6">
    			If damaged, please specify,
    		</td>
    	</tr>
    	<tr>
    		<td class="text-center" colspan="3"><img src="{{URL::to('/images/placeholder.PNG')}}" width="300" height="300"></td>
    		<td class="text-center" colspan="3"><img src="{{URL::to('/images/placeholder.PNG')}}" width="300" height="300"></td>
    	</tr>
    	<tr>
    		<td class="bold">Holes</td>
    		<td class="bold-red-text uppercase">{{$cargo->holes}}</td>
    		<td class="bold">Dents</td>
    		<td class="bold-red-text uppercase">{{$cargo->dents}}</td>
    	</tr>
    	<tr>
    		<td class="bold">Floor Condition</td>
    		<td class="bold-red-text uppercase">{{$cargo->floor_condition}}</td>
    		<td class="bold">Doors Condition</td>
    		<td class="bold-red-text uppercase">{{$cargo->doors_condition}}</td>
    	</tr>
    	<tr>
    		<td class="bold" colspan="3">Light Proof</td>
    		<td class="capitalize" colspan="3">{{$cargo->light_proof}}</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Front(Doors)
    		</td>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Back
    		</td>
    	</tr>
    	<tr>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->loading_area)}}">
    		</td>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->front_doors)}}">
    		</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Left Side
    		</td>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Right Side
    		</td>
    	</tr>
    	<tr>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->left_side)}}">
    		</td>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->right_side)}}">
    		</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Container Floor & Joint (inside)                    
    		</td>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Container Wall & Joint (inside)    
    		</td>
    	</tr>
    	<tr>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->container_floor_and_joint)}}">
    		</td>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->container_wall_and_joint)}}">
    		</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Container Ceiling                    
    		</td>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Container Doors Closed
    		</td>
    	</tr>
    	<tr>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->container_ceiling)}}">
    		</td>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->container_doors_closed)}}">
    		</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-black text-center bold" colspan="6">
    			Equipment Interchange Receipt (EIR)           
    		</td>
    	</tr>
    	<tr>
    		<td class="text-center" colspan="6">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->equipment_interchange_receipt)}}">
    		</td>
    	</tr>
    	<tr>
    		<td class="bold">Palletized Cargo</td>
    		<td class="bold-red-text uppercase">{{$cargo->palletized_cargo}}</td>
    		<td class="bold">Specify Pallet Material</td>
    		<td class="bold-red-text uppercase">{{$cargo->specify_pallet_material}}</td>
    	</tr>
    	<tr>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Pallet's Material                 
    		</td>
    		<td class="table-header-background-color-black text-center bold" colspan="3">
    			Fumigation Stamp
    		</td>
    	</tr>
    	<tr>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->pallet_material)}}">
    		</td>
    		<td class="text-center" colspan="3">
    			<img src="{{URL::to('/images/reports/'.$inpect_info->report_number.'/cargo/'.$cargo->fumigation_stamp)}}">
    		</td>
    	</tr>
    	<tr>
    		<td class="bold">Number of Pallets Loaded</td>
    		<td>{{$cargo->number_of_pallets_loaded}}</td>
    		<td class="bold">From Pallet Number</td>
    		<td>{{$cargo->from_pallet_number}}</td>
    		<td class="bold">To Pallet Number</td>
    		<td>{{$cargo->from_pallet_number}}</td>
    	</tr>


    </table>
@endsection

@section('scripts')

@endsection


