@extends('layouts.new')
@section('title','Factory Management')
@section('page-title','Factory Management')
@section('stylesheets')
  {!! Html::style('/css/admin/dashboard.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="col-md-12 padding-b-25">
                    <div class="buttons">
                        <button class="btn btn-success" data-toggle="modal" data-target="#newFactory"><i class="fa fa-plus"></i> Add New Factory</button>
                        {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#newContact"><i class="fa fa-plus"></i> Add Contact Person</button> --}}
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="factories_table" class="table table-condensed small dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="text-center">View</th>
                                
                                    <th class="text-center">Factory Name</th>
                                    <th class="text-center">Factory Address</th>    
                                    <th class="text-center">Factory Local Address</th>                        
                                    <th class="text-center">Created</th>
                                    <!-- <th class="text-center">Contact Person</th> -->
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($factories as $factory)
                                    @if($factory->factory_status!='2' || $factory->factory_status!=2)
                                    <tr class="text-center">
                                        <td><button data-id="{{$factory->id}}" class="btn btn-warning btn-xs btn-view" title="View Details"><i class="fa fa-eye"></i> </button></td>
                                       
                                        <td>{!!$factory->factory_name!!}</td>
                                        <td>{!!$factory->factory_address!!}</td>
                                        <td>{!!$factory->factory_address_local!!}</td>
                                        <td>{{$factory->created_at}}</td>
                                        <!-- <td><button data-id="{{$factory->id}}" class="btn btn-success btn-xs btn-add" title="Add More Contact Person"><i class="fa fa-user-plus"></i> </button></td> -->
                                        {{-- <td>{{$factory->nicename}}</td> --}}
                                        {{-- <td>{{$factory->factory_country_name}}</td>
                                        <td>{{$factory->factory_city}}</td> --}}
                                         
                                        <td>
                                           {{--  <a href="{{route('factorycontacts',$factory->id)}}" class="btn btn-warning btn-xs" title="Contact Person"><i class="fa fa-users"></i></a> --}}
                                            
                                            
                                            <button data-id="{{$factory->id}}" class="btn btn-info btn-xs btn-edit" title="Edit Details"><i class="fa fa-pencil"></i> </button>
                                            <button data-id="{{$factory->id}}" class="btn btn-danger btn-xs btn-delete" title="Delete Record"><i class="fa fa-times"></i> </button>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
    @include('partials.admin.factory._newcontact')
    @include('partials.admin.factory._newfactory')
    @include('partials.admin.factory._updatefactory')
    @include('partials.admin.factory._deletefactory')
    @include('partials.admin.factory._viewfactory')
    @include('partials.admin.factory._newfaccontactperson')

    <div class="send-loading"></div>
    
@endsection

@section('scripts')
	{!! Html::script('/js/admin/factory.js') !!}
@endsection

<script>
        var msg = '{{Session::get('alert')}}';
        var exist = '{{Session::has('alert')}}';
        if(exist){
          alert(msg);
        }
      </script>
