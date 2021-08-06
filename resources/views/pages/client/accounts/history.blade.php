@extends('layouts.client._new')
@section('title','Sub-Account History')
@section('page-title','Sub-Account History')
@section('stylesheets')
  {{ Html::style('/css/admin/accounts.css') }}
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
                                <th class="text-center">Transaction</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td>Jesser Galapon</td>
                                <td>jess19</td>
                                <td>Book an inspection</td>
                                <td>2020-05-14 00:01:20</td>
                                <td>
                                    <button class="btn btn-warning btn-xs">View</button>
                                </td>
                            </tr>
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
	{!! Html::script('/js/client/sub-account-history.js') !!}
@endsection
