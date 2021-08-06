@extends('layouts.new')
@section('title','Supplier Management')
@section('page-title','Supplier Management')
@section('stylesheets')
  {!! Html::style('/css/admin/dashboard.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
                <div class="col-md-12 padding-b-25">
                    <div class="buttons">
                        <button class="btn btn-success" data-toggle="modal" data-target="#newSupplier"><i class="fa fa-plus"></i> Add New Supplier</button>
                        {{-- <button class="btn btn-primary" data-toggle="modal" data-target="#newContact"><i class="fa fa-plus"></i> Add Contact Person</button> --}}
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table id="factories_table" class="table table-condensed small dataTable no-footer">
                            <thead>
                                <tr>
                                    <th class="text-center">Supplier Name</th>                          
                                    <th class="text-center">Supplier Code / Number</th>
                                    <th class="text-center">Supplier Address</th>    
                                    <th class="text-center">Supplier Address(Local)</th>                        
                                    <th class="text-center">Date Created</th>
                                    <th class="text-center">View / Edit / Delete</th>
                                    <th class="text-center">Factory</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($suppliers as $supplier)
                                    @if($supplier->supplier_status!='2' || $supplier->supplier_status!=2)
                                    <tr class="text-center">                             
                                        <td>{!!$supplier->supplier_name!!}</td>
                                        <td>{!!$supplier->supplier_number!!}</td>
                                        <td>{!!$supplier->supplier_address!!}</td>
                                        <td>{!!$supplier->supplier_address_local!!}</td>
                                        <td>{{$supplier->created_at}}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                    <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
            
                                                    <li><a data-id="{!!$supplier->id!!}" class="btn-view" title="View Details">View</a></li>
                                                    <li><a data-id="{!!$supplier->id!!}" class="btn-edit" title="Edit Details">Edit</a></li>
                                                    <li><a data-id="{!!$supplier->id!!}" class="btn-delete" title="Delete Record">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td><a href="{{route('view-factory',$supplier->id)}}" data-id="{{$supplier->id}}" class="btn btn-warning btn-xs" title="View Details of Factory"><i class="fa fa-eye"></i> </a></td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>
    @include('partials.admin.supplier._newsupplier')
    @include('partials.admin.supplier._viewsupplier')
    @include('partials.admin.supplier._updatesupplier')
    @include('partials.admin.supplier._deletesupplier')


    <div class="send-loading"></div>
    
@endsection

@section('scripts')
    {!! Html::script('/js/admin/supplier.js') !!}
    <script type="text/javascript">
        var token = "{{csrf_token()}}";
    </script>
@endsection


