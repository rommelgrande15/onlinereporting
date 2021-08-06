@extends('layouts.master')
@section('title','Inspection Service Booking')
@section('stylesheets')
  {{ Html::style('/css/inspection/jquery.steps.css') }}
  {{ Html::style('/css/inspection/dropzone.css') }}
  {{ Html::style('/css/inspection/index.css') }}
@endsection

@section('content')

    <div class="row">
    	<div class="col-md-3 sidebar-container">
    		@include('partials._sidebar')
    	</div>
    	<div class="col-md-9 big-panel">
    		<div class="panel panel-default panel-primary main-content-panel">
				<div class="panel-heading heading-text">Inspection Booking</div>
				<div class="panel-body" id="panel-body">
          <div class="">
            @include('partials.inspection._tabs')
            <div class="col-sm-12 col-md-12 col-lg-12">
              
              {!! Form::open(['class'=>'', 'id'=>'inspection-form','enctype'=>"multipart/form-data"]) !!}
                <div>
                  @include('partials.inspection._step1')
                  @include('partials.inspection._step2')
                  @include('partials.inspection._step3') 
                  @include('partials.inspection._step4')
                  @include('partials.inspection._step5')
                </div>
              {!! Form::close() !!}
            </div>
          </div>
				</div>
			</div>
    	</div>
    </div>
    @include('partials.inspection._addfactory')
    @include('partials.inspection._addproduct')
    <div class="se-pre-con"></div>
@endsection

@section('scripts')
  <script type="text/javascript">
    var token = "{{Session::token()}}";
    var url = "{{route('newfactory')}}";
    var newproduct = "{{route('newproduct')}}";
    var selectproduct = "{{route('selectproduct')}}";
    var getfactory = "{{route('getfactory')}}";
    var upload = "{{route('fileupload')}}";
  </script>
  {{ Html::script('/js/inspection/dropzone.js') }}
  {{ Html::script('/js/inspection/modernizr-2.8.2.min.js') }}
  {{ Html::script('/js/inspection/moment.js') }}
	{{ Html::script('/js/inspection/index.js') }}
  {{ Html::script('/js/inspection/append.js') }}

@endsection
