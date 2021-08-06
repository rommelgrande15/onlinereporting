@extends('layouts.new')
@section('title','Clients')
@section('page-title','Clients')
@section('stylesheets')
  {!! Html::style('/css/admin/clients.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12 padding-b-25">
                <div class="buttons">
                    <button class="btn btn-success" data-toggle="modal" data-target="#newClient"><i class="fa fa-plus"></i> Add New Client</button>
                  {{--    <button class="btn btn-primary" data-toggle="modal" data-target="#newContact"><i class="fa fa-plus"></i> Add Contact Person</button> --}}
                </div>
                <div class="table-responsive">
                    <table id="clients_table" class="table table-condensed small dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th class="text-center">View</th>
                                <th class="text-center">Client Name</th>
                                <th class="text-center">Company Name</th>
                                <th class="text-center">Client Code</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Date Created</th>
                              {{--   <th class="text-center">Contact Person</th> --}}
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $key => $client)
                            @if($client->client_status!=2 || $client->client_status!='2')
                            {{-- @if($user==1 || $user='1') --}}
                            <tr>
                                <!-- <td class="text-center">
                                    {{$key + 1}}
                                </td> -->
                                @if($client->is_online==1 || $client->is_online=='1')
                                    <td class="text-center">
                                        <span class='text-success' data-toggle='tooltip' data-placement='top' title='Online'><i class='fa fa-circle center'></i></span> 
                                    </td>
                                @else
                                    <td class="text-center">
                                        <span class='text-danger' data-toggle='tooltip' data-placement='top' title='Offline'><i class='fa fa-circle center'></i></span>
                                    </td>
                                @endif
                                <td class="text-center"> <button data-id="{{$client->id}}" class="btn btn-warning btn-xs btn-view" title="View Details"><i class="fa fa-eye"></i> </button></td>
                                <td class="text-center">
                                    {!!$client->client_name!!}
                                 </td>  
                                <td class="text-center">
                                   {!!$client->Company_Name!!}
                                </td>                              
                                <td class="text-center">{{$client->client_code}}</td>
                                <td class="text-center">
                                    {!!$client->Company_Email!!}
                                </td>
                                <td class="text-center">
                                    {!!$client->company_city_name!!}  {!!$client->company_state_name!!}  {!!$client->company_country_name!!}
                                </td>
                                <td class="text-center">
                                    {{$client->created_at}}
                                </td>
                              {{--   <td class="text-center"><button data-id="{{$client->id}}" class="btn btn-success btn-xs btn-add" title="Add More Contact Person"><i class="fa fa-user-plus"></i> </button></td> --}}
                                <td class="text-center">
                                   
                                   
                                    
                                    <button data-id="{{$client->id}}" class="btn btn-info btn-xs btn-edit" title="Edit Details"><i class="fa fa-pencil"></i> </button>
                                    <button data-id="{{$client->id}}" class="btn btn-danger btn-xs btn-delete" title="Delete Record"><i class="fa fa-times"></i> </button>
                                    
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
    {{-- @include('partials.admin.client._newcontact') --}}
    @include('partials.admin.client._newclient')
    @include('partials.admin.client._deleteclient')
    @include('partials.admin.client._updateclient')
    
    {{-- jesser --}}
    @include('partials.admin.client._viewclient') 
    @include('partials.admin.client._newcontactperson')

    <div class="send-loading"></div>

@endsection

@section('scripts')
	{!! Html::script('/js/admin/clients.js?n=1') !!}
@endsection
