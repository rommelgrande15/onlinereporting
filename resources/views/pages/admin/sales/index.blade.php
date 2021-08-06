@extends('layouts.new')
@section('title','Sales Manager')
@section('page-title','Sales Accounts')
@section('stylesheets')
  {!! Html::style('/css/admin/sales.css') !!}
  <link rel="stylesheet" href="{{asset('cloudfare/jquery-ui.css')}}" />
@endsection

@section('content')
    <div class="row">
            <div class="col-md-12 padding-b-25">
                <div class="buttons">
                    <button class="btn btn-success" data-toggle="modal" data-target="#newSalesModal"><i class="fa fa-user-plus"></i> Add new Sales Manager</button>
                </div>
                <div class="table-responsive">
                    <table id="sales_table" class="table table-condensed small dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center">View</th>
                                <th class="text-center">Sales Name</th>
                                {{-- <th class="text-center">Contact Number</th> --}}
                                <th class="text-center">Email Address</th>
                                {{-- <th class="text-center">Address</th> --}}
                                <th class="text-center">Date Created</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($sales_manager as $sales)
                            <tr class="text-center">
                                <td><button data-id="{{$sales->id}}" class="btn btn-warning btn-xs btn-view" title="View Details"><i class="fa fa-eye"></i> </button></td>
                                <td>{!!$sales->name!!}</td>
                                {{-- <td>{{$sales->contact_number}}</td> --}}
                                <td>{{$sales->email}}</td>
                                {{-- <td>{!!$sales->address!!}</td> --}}
								<td>{{$sales->user_info_created}}</td>
                                <td>
                                    <button title="Update Inspector Data" data-id="{{$sales->id}}" class="btn btn-xs btn-edit btn-info"><i class="fa fa-pencil"></i></button>
                                    <button title="Delete Inspector Data" data-id="{{$sales->id}}" class="btn btn-xs btn-delete btn-danger"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    
    @include('partials.admin.sales._newsales')
    @include('partials.admin.sales._updatesales')
    @include('partials.admin.sales._deletesales')
    @include('partials.admin.sales._viewsales')
    <div class="send-loading"></div>
    
@endsection

@section('scripts')
    {!! Html::script('/js/admin/sales.js?n=3') !!}
@endsection
