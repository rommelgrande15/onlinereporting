@extends('layouts.new')
@section('title','New Clients')
@section('page-title','New Clients')
@section('stylesheets')
{!! Html::style('/css/admin/clients.css') !!}
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12 padding-b-25">
            <div class="buttons">
                <!--<button class="btn btn-success" data-toggle="modal" data-target="#newClient"><i class="fa fa-plus"></i> Add New Client</button>-->
                {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#newContact"><i class="fa fa-plus"></i> Add Contact Person</button> --}}
            </div>
            <div class="table-responsive">
                <table id="new_clients_table" class="table table-condensed small dataTable no-footer">
                    <thead>
                        <tr>
                            <th class="text-center">Client</th>
                            <th class="text-center">Client Code</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Client Type</th>
                            <th class="text-center">Date Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($clients)
                        @foreach($clients as $key => $client)
                        @if($client->client_status!=2 || $client->client_status!='2')
                        <tr>
                            <td class="text-center">
                                {!!$client->Company_Name!!}
                            </td>
                            @if($client->client_code =='000')
                            <td class="text-center">
                                Not Updated
                            </td>
                            @else
                            <td class="text-center">
                                Client code updated
                            </td>
                            @endif
                            <td class="text-center">
                                {!!$client->Company_Email!!}
                            </td>
                            <td class="text-center">
                                {!!$client->company_city_name!!} {!!$client->company_state_name!!} {!!$client->company_country_name!!}
                            </td>
                            @if($client->client_type=='tic_sera')
                            <td class="text-center text-danger">
                                TIC-SERA
                            </td>
                            @else
                            <td class="text-center text-warning">
                                TIC
                            </td>
                            @endif
                            <td class="text-center">
                                {{$client->created_at}}
                            </td>
                            <td class="text-center">
                                <button data-id="{{$client->id}}" class="btn btn-info btn-xs btn-edit" title="Edit Details"><i class="fa fa-pencil"></i> </button>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
{{-- @include('partials.admin.client._newcontact') --}}
{{-- @include('partials.admin.client._newclient')
    @include('partials.admin.client._deleteclient') --}}
@include('partials.admin.client._updatenewclient')

{{-- jesser --}}
{{-- @include('partials.admin.client._viewclient') 
    @include('partials.admin.client._newcontactperson') --}}

<div class="send-loading"></div>

@endsection

@section('scripts')
{!! Html::script('/js/admin/clients.js?n=1') !!}
@endsection
