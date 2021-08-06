@extends('layouts.new')
@section('title','Accounts')
@section('page-title','Accounts')
@section('stylesheets')
  {{ Html::style('/css/admin/accounts.css') }}
@endsection

@section('content')
    <div class="row">
            <div class="col-md-12 padding-b-25">
                <div class="buttons">
                    <button class="btn btn-success" data-toggle="modal" data-target="#newAccountModal"><i class="fa fa-user-plus"></i> Add new Account</button>
                </div>
                <div class="table-responsive">
                    <table id="accounts_table" class="table table-condensed small dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center">Account Name</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Contact Number</th>
                                <th class="text-center">Email Address</th>
                                <th class="text-center">Designation</th>
                                <th class="text-center">Created At</th>
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
                                <td>{{$account->created_at}}</td>
                                <td>
                                    <button title="Update Inspector Data" data-id="{{$account->id}}" class="btn btn-xs btn-edit btn-success"><i class="fa fa-pencil"></i></button>
                                    <button title="Delete Inspector Data" data-id="{{$account->id}}" class="btn btn-xs btn-delete btn-danger"><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    @include('partials.admin.accounts._newaccount')
    @include('partials.admin.accounts._updateaccount')
    @include('partials.admin.accounts._deleteaccount')

    <div class="send-loading"></div>
@endsection

@section('scripts')
	{!! Html::script('/js/admin/accounts.js') !!}
@endsection
