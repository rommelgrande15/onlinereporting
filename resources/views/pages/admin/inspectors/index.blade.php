@extends('layouts.new')
@section('title','Inspectors')
@section('page-title','Inspector Accounts')
@section('stylesheets')
  {!! Html::style('/css/admin/inspectors.css') !!}
  <link rel="stylesheet" href="{{asset('cloudfare/jquery-ui.css')}}" />
@endsection

@section('content')
    <div class="row">
            <div class="col-md-12 padding-b-25">
                <div class="buttons">
                    <button class="btn btn-success" data-toggle="modal" data-target="#newInspectorModal"><i class="fa fa-user-plus"></i> Add new Inspector</button>
                </div>
                <div class="table-responsive">
                    <table id="inspectors_table" class="table table-condensed small dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center">View</th>
                                <th class="text-center">Inspector Name</th>
                                <th class="text-center">Contact Number</th>
                                <th class="text-center">Email Address</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Date Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($inspectors as $inspector)
                            <tr class="text-center">
                                <td><button data-id="{{$inspector->id}}" class="btn btn-warning btn-xs btn-view" title="View Details"><i class="fa fa-eye"></i> </button></td>
                                <td>{!!$inspector->name!!}</td>
                                <td>{{$inspector->contact_number}}</td>
                                <td>{{$inspector->email}}</td>
                                <td>{!!$inspector->address!!}</td>
								<td>{{$inspector->user_info_created}}</td>
                                <td>
                                    <button title="Update Inspector Data" data-id="{{$inspector->id}}" class="btn btn-xs btn-edit btn-info"><i class="fa fa-pencil"></i></button>
                                    <button title="Delete Inspector Data" data-id="{{$inspector->id}}" class="btn btn-xs btn-delete btn-danger"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    
    @include('partials.admin.inspector._newinspector')
    @include('partials.admin.inspector._updateinspector')
    @include('partials.admin.inspector._deleteinspector')
    @include('partials.admin.inspector._viewinspector')
    <div class="send-loading"></div>
    
@endsection

@section('scripts')
    {!! Html::script('/js/admin/inspectors.js?n=3') !!}
@endsection
