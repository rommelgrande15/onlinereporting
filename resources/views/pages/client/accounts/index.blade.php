@extends('layouts.client._new')
@section('title','Client Accounts')
@section('page-title','Client Accounts')
@section('stylesheets')
  {{ Html::style('/css/admin/accounts.css') }}
@endsection

@section('content')
    @php
        $site_url='tic';
    @endphp
    @if(strpos(Request::url(''), 'tic-sera') !== false)
        @php
            $site_url='tic-sera';
        @endphp
    @else
        @php
            $site_url='tic';
        @endphp
    @endif
    <div class="row">
            <div class="col-md-12 padding-b-25">
                <div class="buttons">
                    <button class="btn btn-success" data-toggle="modal" data-target="#newAccountModal"><i class="fa fa-user-plus"></i> Add new Account</button>
                    <br/><br/>
                </div>
                <div class="table-responsive">
                    <table id="accounts_table" class="table table-condensed small dataTable no-footer">
                        <thead>
                            <tr>
                                <th class="text-center">Account Name</th>
                                <th class="text-center">Username</th>
                                <th class="text-center">Contact Number</th>
                                <th class="text-center">Email Address</th>
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
                                <td>{{$account->created_at}}</td>
                                <td>
                                    <div class="dropdown">
									    <button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action<span class="caret"></span></button>
									    <ul class="dropdown-menu">
									    	<li><a href="#" class="btn-edit" title="Update Account" data-id="{{$account->id}}">Update account</a></li>
                                            <li><a href="#" class="btn-privelege" title="Update Privilege" data-id="{{$account->id}}">Update privelege</a></li>
                                            <li><a href="#" class="btn-delete" title="Delete Account" data-id="{{$account->id}}">Delete account</a></li>
									    </ul>
								    </div>
                                   <!--  <button title="Update Account Data" data-id="{{$account->id}}" class="btn btn-xs btn-edit btn-success"><i class="fa fa-pencil"></i></button>
                                    <button title="Update Privilege" data-id="{{$account->id}}" class="btn btn-xs btn-privelege btn-warning"><i class="fa fa-cog"></i></button>
                                    <button title="Delete Account Data" data-id="{{$account->id}}" class="btn btn-xs btn-delete btn-danger"><i class="fa fa-times"></i></button> -->
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    @include('partials.client.accounts._newaccount')
    @include('partials.client.accounts._updateaccount')
    @include('partials.client.accounts._deleteaccount')
    @include('partials.client.accounts._privilege')

    <div class="send-loading"></div>
@endsection

@section('scripts')
	{!! Html::script('/js/client/sub-accounts.js?v=1') !!}
@endsection
