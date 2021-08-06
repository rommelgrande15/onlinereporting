@extends('layouts.master')
@section('title','My Bookings')
@section('stylesheets')
  {{ Html::style('/css/jquery.dataTables.css') }}
  {{ Html::style('/css/bookings/index.css') }}
  <style type="text/css">
    .company-title{
      margin-top: -35px;
      margin-left: 305px;
      color: #3cb5d0;
      font-size: 22px;
      font-weight: bold;
    }
    .label{
        font-weight: bold;
    }
    .tr-head{
        background: #e5e5e5;
    }
    .page-break {
        page-break-after: always;
    }
    table {
    border-collapse: collapse;
    width: 100%
    }

    table, th, td {
        border: 1px solid black;
        font-size: 13px;
    }

    td:nth-child(odd){
      font-weight: bold;
    }
    .uppercase{
      text-transform: uppercase;
    }
  </style>
@endsection

@section('content')
    <div class="row">
    	<div class="col-md-3">
    		@include('partials._sidebar')
    	</div>
    	<div class="col-md-9">
    		<div class="panel panel-default panel-primary main-content-panel">
				<div class="panel-heading heading-text ">View Booking</div>
				<div class="panel-body">
          <h4>Reference Number: <span class="uppercase">{{$booking->reference_number}}</span></h4>
          <hr>
          <div class="col-md-10 col-md-offset-1">
              <table class="table">
              <tr>
                  <td>Date Booked</td>
                  <td>{{date_format($booking->created_at, "M-d-Y h:i:s A")}}</td>
                  <td >Project Reference Number:</td>
                  <td>{{$booking->reference_number}}</td>
              </tr>
              <tr>
                  <td >Company Name:</td>
                  <td>{{$company->company_name}}</td>
                  <td >Tel No:</td>
                  <td>{{$company->phone_number}}</td>
              </tr>
              <tr>
                  <td >Contact Person:</td>
                  <td>{{$company->full_name}}</td>
                  <td >Email:</td>
                  <td>{{$company->company_email}}</td>
              </tr>
              <tr>
                  <td >Address:</td>
                  <td colspan="3">{{$company->company_address}}</td>
              </tr>
              <tr>
                  <td >Factory Name:</td>
                  <td>{{$factory->factory_name}}</td>
                  <td >Tel No:</td>
                  <td>{{$factory->factory_contact_number}}</td>
              </tr>
              <tr>
                  <td >Contact Person:</td>
                  <td>{{$factory->factory_contact_person}}</td>
                  <td >Email:</td>
                  <td>{{$factory->factory_email}}</td>
              </tr>
              <tr>
                  <td >Factory Address:</td>
                  <td colspan="3">{{$factory->factory_address}}</td>
              </tr>
              <tr>
                  <td >Inspection Date:</td>
                  <td>{{$booking->inspection_date}}</td>
                  <td >Shipment Date:</td>
                  <td>{{$booking->shipment_date}}</td>
              </tr>
              <tr>
                  <td >Date Remarks:</td>
                  <td colspan="3">{{ $factory->factory_address === 0 ? "Do not allow factory to change inspection date" : "Allow factory to change inspection date" }}</td>
              </tr>
              <tr>
                  <td >Service Requested:</td>
                  <td colspan="3">{{ $service_type }}</td>
              </tr>
          </table>
          <br>
          <table class="table">
              @foreach($productInfo as $i => $product)
                  <tr class="tr-head">
                      <td>Product:</td>
                      <td>{{$product->product_name}}</td>
                      <td >Brand:</td>
                      <td>{{$product->brand}}</td>
                  </tr>

                  <tr>
                      <td >Unit:</td>
                      <td>{{$product->product_unit}}</td>
                      <td >PO Number:</td>
                      <td>{{$product->po_no}}</td>
                  </tr>
                  <tr>
                      <td >Quantity:</td>
                      <td colspan="3">{{$products[$i]->qty}}</td>
                  </tr>
                  <tr>
                      <td >Shipping Mark:</td>
                      <td colspan="3">{{$product->shipping_mark}}</td>
                  </tr>
                  <tr>
                      <td >Technical Specifications:</td>
                      <td colspan="3">{{$product->tech_specs}}</td>
                  </tr>
                  <tr>
                      <td >Product Info:</td>
                      <td colspan="3">{{$product->additional_product_info}}</td>
                  </tr>
                  <tr>
                      <td class=" text-center tr-head" colspan="2">AQL Acceptable Level:</td>
                      <td class=" text-center tr-head" colspan="2">AQL Sampling Level:</td>
                  </tr>
                  <tr>
                      <td >Visual:</td>
                      <td>{{$products[$i]->gen_sample_size}}</td>
                      <td >Minor:</td>
                      <td>{{$products[$i]->minor}}</td>
                  </tr>
                  <tr>
                      <td >Functional:</td>
                      <td>{{$products[$i]->special_sample_size}}</td>
                      <td >Major:</td>
                      <td>{{$products[$i]->major}}</td>
                  </tr>
                  <tr>
                      <td ></td>
                      <td></td>
                      <td >Critical:</td>
                      <td>{{$products[$i]->crit}}</td>
                  </tr>
                  <tr>
                      <td >Manday</td>
                      <td>{{$booking->manday}}</td>
                      <td >Function:</td>
                      <td>{{$products[$i]->functional}}</td>
                  </tr>
                  
              @endforeach
              <tr>
                  <td colspan="4" class="tr-head text-center ">Additional Remarks</td>
              </tr>
              <tr>
                  <td colspan="4">{{!empty($booking->more_info) ? $booking->more_info : 'No additional information'}}</td>
              </tr>
          </table>
          <table class="table">
             <tr>
                  <td colspan="4" class="tr-head text-center ">Samples</td>
              </tr>
              <tr>
                  <td >Reference Samples</td>
                  <td>{{$booking->reference_sample}}</td>
                  <td >Courier:</td>
                  <td>{{$booking->courier}}</td>
              </tr>
              <tr>
                  <td >Tracking Number</td>
                  <td colspan="3">{{$booking->tracking_number}}</td>
              </tr>
          </table>
          <hr>
          <div class="">
            <h3>Attachments</h3>
            @foreach($photos as $photo)
              <a href="/images/booking/{{$booking->id}}/{{$photo->photo_path}}" target="_blank">
                <img src="/images/booking/{{$booking->id}}/{{$photo->photo_path}}" class="img-thumbnail" width="150">
              </a>
              
            @endforeach
          </div>
          </div>
					
				</div>
			</div>
    	</div>
    </div>
@endsection

@section('scripts')
  {{ Html::script('/js/jquery.dataTables.js') }}
	{{ Html::script('/js/bookings/index.js') }}
@endsection
