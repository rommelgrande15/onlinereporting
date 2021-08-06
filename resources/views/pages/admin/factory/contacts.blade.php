@extends('layouts.new')
@section('title','Factory Management')
@section('page-title', $factory->factory_name . ' Contacts')
@section('stylesheets')
  {!! Html::style('/css/admin/factory.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 padding-b-25">
            <h3 class="h3-title"><small><a href="{{route('factorylist')}}"><i class="fa fa-arrow-left"></i> Go Back to Factory List</a></small></h3> 

            <div class="table-responsive">
                <table id="contacts_table" class="table table-condensed small dataTable no-footer">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Contact Person</th>
                            <th class="text-center">Contact Number</th>
                            <th class="text-center">Email Address</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $key => $contact)
                            <tr class="text-center">
                                <td>{{$key+1}}</td>
                                <td>{{$contact->factory_contact_person}}</td>
                                <td>{{$contact->factory_contact_number}}</td>
                                <td>{{$contact->factory_email}}</td>
                                <td>
                                    <button class="btn btn-xs btn-primary btn-update-contact" data-id="{{$contact->id}}"><i class="fa fa-pencil"></i></button>
                                    <button class="btn btn-xs btn-danger btn-delete-contact" data-id="{{$contact->id}}"><i class="fa fa-times"></i></button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    @include('partials.admin.factory._updatecontact')
    @include('partials.admin.factory._deletecontact')
    
@endsection

@section('scripts')
	{!! Html::script('/js/admin/factory.js') !!}
@endsection
