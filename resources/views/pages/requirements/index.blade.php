@extends('layouts.master')
@section('title','Products')
@section('stylesheets')
  {{ Html::style('/css/requirements/requirements.css') }}
@endsection

@section('content')
    <div class="row">
    	<div class="col-md-3">
    		@include('partials._sidebar')
    	</div>
    	<div class="col-md-9">
    		<div class="panel panel-default panel-primary main-content-panel">
				<div class="panel-heading heading-text">Customer Requirements</div>
				<div class="panel-body">
          <div class="col-md-12">
            {!! Form::model($cust, ['route'=>'updatecr', 'class'=>'form-horizontal']) !!}
              @include('partials.requirements._conditions')
              @include('partials.requirements._special')
              @include('partials.requirements._specific')
              @include('partials.requirements._packing')
              @include('partials.requirements._additional')
            <div class="row">
              <div class="col-md-3">
                {{ Form::button('Edit Requirements', ['class' => 'btn btn-success','id'=>'edit_requirements']) }}
                {{ Form::button('Save Changes', ['class' => 'btn btn-primary','id'=>'save_requirements','type'=>'submit']) }}
                {{ Form::button('Cancel', ['class' => 'btn btn-danger','id'=>'cancel_requirements']) }}
              </div>
            </div>
            {!! Form::close() !!}
          </div>
				</div>
			</div>
    	</div>
    </div>

@endsection

@section('scripts')
	{{ Html::script('/js/requirements/requirements.js') }}
@endsection
