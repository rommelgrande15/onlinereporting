@extends('layouts.master')
@section('title','Dashboard')
@section('stylesheets')
  {{ Html::style('/css/settings/index.css') }}
@endsection

@section('content')
    <div class="row">
    	<div class="col-md-3">
    		@include('partials._sidebar')
    	</div>
    	<div class="col-md-9">
    		<div class="panel panel-default panel-primary main-content-panel">
				<div class="panel-heading heading-text">Account Settings</div>
				<div class="panel-body settings-wrapper">
            <div class="panel-group" id="accordion">
              @include('partials.settings.email')
              @include('partials.settings.password')
              @include('partials.settings.username')
            </div>
				</div>  
			</div>
    	</div>
    </div>
@endsection

@section('scripts')
	{{ Html::script('/js/settings/index.js') }}
@endsection
