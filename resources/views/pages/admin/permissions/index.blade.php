@extends('layouts.new')
@section('title','Permissions')
@section('page-title','User Accounts')
@section('stylesheets')
  {{ Html::style('/css/admin/permissions.css') }}
@endsection

@section('content')
    <div class="row">
            <div class="col-md-12 padding-b-25">
                <div class="table-responsive">
                    <table id="accounts_table" class="table table-condensed small dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center">Account Name</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Contact Number</th>
                                <th class="text-center">Email Address</th>
                                <th class="text-center">Designation</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($accounts as $account)
                            <tr class="text-center">
                                <td>{{$account->name}}</td>
                                <td>{{$account->username}}</td>
                                <td>{{$account->contact_number}}</td>
                                <td>{{$account->email}}</td>
                                <td>{{$designation[$account->designation]}}</td>
                                <td>
                                    <a title="Change Permissions" href="{{route('setpermission',$account->id)}}" class="btn btn-xs btn-edit btn-warning"><i class="fa fa-lock"></i></a>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
@endsection

@section('scripts')
	{{ Html::script('/js/admin/permissions.js') }}
@endsection
