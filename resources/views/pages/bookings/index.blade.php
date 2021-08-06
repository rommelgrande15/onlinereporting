@extends('layouts.master')
@section('title','My Bookings')
@section('stylesheets')
  {{ Html::style('/css/jquery.dataTables.css') }}
  {{ Html::style('/css/bookings/index.css') }}

@endsection

@section('content')
    <div class="row">
    	<div class="col-md-3">
    		@include('partials._sidebar')
    	</div>
    	<div class="col-md-9">
    		<div class="panel panel-default panel-primary main-content-panel">
				<div class="panel-heading heading-text">My Bookings</div>
				<div class="panel-body">
          <div class="row">
            <div class="col-md-12 legend">
                  <div class="col-md-7 col-md-offset-5 text-right">
                    <label class="legend-title">Status Legend:</label>
                    <a class="btn btn-success btn-xs">
                      <i class="fa fa-calendar-check-o"></i>
                    </a> <span class="legend-label">Booked</span>

                    <a class="btn btn-info btn-xs">
                      <i class="fa fa-check-square-o"></i>
                    </a> <span class="legend-label">Confirmed</span>

                    <a class="btn btn-warning btn-xs">
                      <i class="fa fa-refresh fa-spin"></i>
                    </a> <span class="legend-label">In Process</span>

                    <a class="btn btn-success btn-xs">
                      <i class="fa fa-flag-checkered"></i>
                    </a> <span class="legend-label">Finished</span>

                    <a class="btn btn-warning btn-xs">
                      <i class="fa fa-hourglass-half fa-spin"></i>
                    </a> <span class="legend-label">Cancel Pending</span>

                    <a class="btn btn-danger btn-xs">
                      <i class="fa fa-ban"></i>
                    </a> <span class="legend-label">Cancelled</span>
                  </div>
            </div>
          </div>
          <div class="table-responsive table-wrapper">
            <table id="bookingsTable">
              <thead>
                <th>Reference Number</th>
                <th>Date Booked</th>
                <th>Inspection Date</th>
                <th>Service</th>
                <th>Factory</th>
                <th>Manday</th>
                <th>Status</th>
                <th>Actions</th>
              </thead>
              <tbody>
                <input type="hidden" value="{{$bookings}}" id="json_log">
                @foreach($bookings as $booking)
                  <tr class="{{$booking->booking_status == 'pending' ? 'disabled' : ''}}">
                    <td>{{$booking->reference_number}}</td>
                    <td class="text-center">{{date("M-d-Y h:i:s A", strtotime($booking->created_at))}}</td>
                    <td class="text-center">{{date("M-d-Y", strtotime($booking->inspection_date))}}</td>
                    <td class="text-center">{{$service[$booking->service_type]}}</td>
                    <td class="text-center">{{$booking->factory_name}}</td>
                    <td class="text-center">{{$booking->manday}}</td>
                    <td class="text-center">
                    @if($booking->booking_status == 'booked')
                      <a class="btn btn-success btn-xs" title="Inspection Booked">
                        <i class="fa fa-calendar-check-o"></i>
                      </a>
                    @elseif($booking->booking_status == 'confirmed')
                      <a class="btn btn-info btn-xs" title="Inspection Confirmed">
                        <i class="fa fa-check-square-o"></i>
                      </a>
                    @elseif($booking->booking_status == 'in process')
                      <a class="btn btn-warning btn-xs" title="Inspection in Process">
                        <i class="fa fa-refresh fa-spin"></i>
                      </a>
                    @elseif($booking->booking_status == 'finished')
                      <a class="btn btn-success btn-xs" title="Inspection Finished">
                        <i class="fa fa-flag-checkered"></i>
                      </a>
                    @elseif($booking->booking_status == 'pending')
                      <a class="btn btn-warning btn-xs" title="Cancellation Pending">
                        <i class="fa fa-hourglass-half fa-spin"></i>
                      </a>                    
                    @else
                      <a class="btn btn-danger btn-xs" title="Cancelled">
                        <i class="fa fa-ban"></i>
                      </a>
                    @endif
                    @if($booking->booking_status == 'pending' || $booking->booking_status == 'cancelled')
                    </td>
                    <td class="text-center">
                      <a class="btn btn-primary btn-xs" title="View Booking" href="/booking/{{$booking->id}}"><i class="fa fa-eye"></i></a>
                      <a class="btn btn-success btn-xs" title="Download Booking Sheet" href="/download/{{$booking->id}}"><i class="fa fa-download"></i></a>
                    </td>
                    @else
                    <td class="text-center">
                      <a class="btn btn-primary btn-xs" title="View Booking" href="/booking/{{$booking->id}}"><i class="fa fa-eye"></i></a>
                      <a class="btn btn-success btn-xs" title="Download Booking Sheet" href="/download/{{$booking->id}}"><i class="fa fa-download"></i></a>
                      <a class="btn btn-danger btn-xs btn-cancel" data-id="{{$booking->id}}" title="Request Booking Cancellation" data-toggle="modal" data-target="#cancelBookingModal"><i class="fa fa-ban"></i></a>
                    </td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
           </table>
          </div>
					 
				</div>
			</div>
    	</div>
    </div>
    @include('partials._cancelbooking');
@endsection

@section('scripts')
  {{ Html::script('/js/jquery.dataTables.js') }}
	{{ Html::script('/js/bookings/index.js') }}
  <script type="text/javascript">
    var session ="{{Session::token()}}";
    var cancel = "{{route('delete')}}";
  </script>
@endsection
