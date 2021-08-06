@extends('layouts.new')
@section('title','Client Management')
@section('page-title', $client->client_name.' Contacts')
@section('stylesheets')
  {{ Html::style('/css/admin/clients.css') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 padding-b-25">
               <h3 class="h3-link"><small><a href="{{route('clients')}}"><i class="fa fa-arrow-left"></i> Go Back to Clients List</a></small> </h3> 
            <div class="table-responsive">
                <table id="clients_table" class="table table-condensed small dataTable no-footer">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Contact Person</th>
                            <th class="text-center">Contact Number</th>
                            <th class="text-center">Email Address</th>
                           {{--  <th class="text-center">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $key => $contact)
                            <tr>
                                <td class="text-center">{{$key+1}}</td>
                                <td class="text-center">{{$contact->contact_person}}</td>
                                <td class="text-center">{{$contact->contact_number}}</td>
                                <td class="text-center">{{$contact->email_address}}</td>
                               {{--  <td class="text-center"> --}}
                                  {{--   <button class="btn btn-xs btn-primary btn-edit-contact" data-id="{{$contact->id}}" title="Edit Contact Details"><i class="fa fa-pencil"></i></button> --}}
                                   {{--  <button class="btn btn-xs btn-danger btn-delete-contact" data-id="{{$contact->id}}" title="Delete Contact Details"><i class="fa fa-times"></i></button> --}}
                               {{--  </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('partials.admin.client._updatecontact')
    @include('partials.admin.client._deletecontact')
    
@endsection

@section('scripts')
	{{ Html::script('/js/admin/clients.js') }}
@endsection
