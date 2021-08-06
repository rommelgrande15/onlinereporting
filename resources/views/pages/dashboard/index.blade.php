@extends('layouts.master')
@section('title','Dashboard')
@section('stylesheets')
  {{ Html::style('/css/dashboard/index.css') }}
@endsection

@section('content')
    <div class="row">
    	<div class="col-md-3">
    		@include('partials._sidebar')
    	</div>
    	<div class="col-md-9">
    		<div class="panel panel-default panel-primary main-content-panel">
				<div class="panel-heading heading-text">Book a Service</div>
				<div class="panel-body">
					<div class="col-md-4 text-center">
            <div class="panel panel-default">
              <div class="panel-heading orange-background heading-text">Inspection Services</div>
              <div class="panel-body panel-content">
              <div class="text-justify description">

                    <img src="{{URL::asset('/images/inspect.png')}}" class="img-responsive badges" width="150"><br>
                    Product Inspection are made to ensure the quality of your goods. This will help you make sure that all requirements, criteria and specifications are being implemented properly by the factory.
                    <div class="list">
                        <i class="fa fa-check-square-o"></i> Pre Shipment Inspection<br>
                    </div>
              </div>
              <div class="col-md-12 buttons">
                  <a href="/inspection" class="btn btn-warm btn-block">Book Inspection Service</a>
                 {{--  <a href="#" class="btn btn-warm btn-block">Quick Booking</a> --}}
              </div>

              </div>
            </div>
          </div>

				</div>
			</div>
    	</div>
    </div>
@endsection

@section('scripts')
	{{ Html::script('/js/dashboard/index.js') }}
@endsection
