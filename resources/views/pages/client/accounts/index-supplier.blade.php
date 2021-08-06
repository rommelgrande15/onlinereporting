@extends('layouts.client._new')
@section('title','Supplier Accounts')
@section('page-title','Supplier Accounts')
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
                                <th class="text-center">Privileges</th>
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
                                            <li><a class="btn-report-access" title="Update Access" data-id="{{$account->id}}">Update Report Access</a></li>
                                            <li><a class="btn-email-notify" title="Update Email" data-id="{{$account->id}}">Update Email Notifications</a></li>
                                            <li><a class="btn-no-email" title="Update NoEmail" data-id="{{$account->id}}">Update No Email Notifications</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
									    <button class="btn btn-xs btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Action<span class="caret"></span></button>
									    <ul class="dropdown-menu">
                                            <li><a class="btn-view" title="View Account" data-id="{{$account->id}}">View Account</a></li>
									    	<li><a class="btn-edit" title="Update Account" data-id="{{$account->id}}">Update Account</a></li>
                                            <li><a class="btn-delete" title="Delete Account" data-id="{{$account->id}}">Delete account</a></li>
									    </ul>
								    </div>
                                   <!--  <button title="Update Account Data" data-id="{{$account->id}}" class="btn btn-xs btn-edit btn-success"><i class="fa fa-pencil"></i></button>
                                    <button title="Update Privilege" data-id="{{$account->id}}" class="btn btn-xs btn-privelege btn-warning"><i class="fa fa-cog"></i></button>
                                    <button title="Delete Account Data" data-id="{{$account->id}}" class="btn btn-xs btn-delete btn-danger"><i class="fa fa-times"></i></button> -->
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">.</th>
                                <th class="text-center">.</th>
                                <th class="text-center">.</th>
                                <th class="text-center">.</th>
                                <th class="text-center">.</th>
                                <th class="text-center">.</th>
                                <th class="text-center">.</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
    </div>
    @include('partials.client.accounts.supplier._newaccount')
    @include('partials.client.accounts.supplier._updateaccount')
    @include('partials.client.accounts.supplier._deleteaccount')
    {{-- @include('partials.client.accounts.supplier._privilege') --}}
    @include('partials.client.accounts.supplier._viewaccount')
    @include('partials.client.accounts.supplier._updateemailnotifications')
    @include('partials.client.accounts.supplier._updatereportaccessonline')
    @include('partials.client.accounts.supplier._updatenoeemail')

    <div class="send-loading"></div>
@endsection

@section('scripts')
	{!! Html::script('/js/client/sub-accounts.js?v=2') !!}
@endsection
