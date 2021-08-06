@extends('layouts.master')
@section('title','Products')
@section('stylesheets')
  {{ Html::style('/css/factories/factories.css') }}
@endsection

@section('content')
    <div class="row">
    	<div class="col-md-3">
    		@include('partials._sidebar')
    	</div>
    	<div class="col-md-9">
    		<div class="panel panel-default panel-primary main-content-panel">
				<div class="panel-heading heading-text">Factories List</div>
				<div class="panel-body">
          <div class="col-md-12 btn-control-wrapper">
            <button class="btn btn-success" data-toggle="modal" data-target="#factoryModal"><i class="fa fa-plus"></i> Add a New Factory</button>
          </div>
          <div class="col-md-12">
            <table class="table" id="factories_table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Factory Name</th>
                  <th>Address</th>
                  <th>Contact Person</th>
                  <th>Contact Number</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($factories as $i=>$factory)
                  <tr>
                    <td>{{$i+1}}</td>
                    <td>{{$factory->factory_name}}</td>
                    <td>{{$factory->factory_address}}</td>
                    <td>{{$factory->factory_contact_person}}</td>
                    <td>{{$factory->factory_contact_number}}</td>
                    <td class="text-center">
                      <button class="btn btn-primary btn-xs btn_factory_details" data-toggle="modal" data-id="{{$factory->id}}">
                        <i class="fa fa-pencil"></i>
                      </button>
                      <button class="btn btn-danger btn-xs btn_factory_delete" data-toggle="modal" data-id="{{$factory->id}}">
                        <i class="fa fa-times"></i>
                      </button>
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
				</div>
			</div>
    	</div>
    </div>
    @include('partials.inspection._addfactory');
    @include('partials._editfactory')
    @include('partials._deletefactory')
@endsection

@section('scripts')
	{{ Html::script('/js/factories/factories.js') }}
  <script type="text/javascript">
    var token = "{{Session::token()}}";
    var newfactory = "{{route('newfactory')}}";
    var getfactory = "{{route('getfactory')}}";
    var deletefactory = "{{route('deletefactory')}}";
    var updatefactory = "{{route('updatefactory')}}";
  </script>
@endsection
