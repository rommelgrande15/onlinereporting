@extends('layouts.new')
@section('title','Edit Permissions')
@section('page-title','Edit User Permissions')
@section('stylesheets')
  {{ Html::style('/css/admin/permissions.css') }}
@endsection

@section('content')
    <div class="row">
            <div class="col-md-12 padding-b-25">
                <form method="POST" action="{{route('updatepermissions',$user_id)}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Client Management</h4>
                            <ul class="no-bullet">
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_client_view" {{$role->hasRole('role_client_view') ? 'checked' : ''}}>
                                        View Clients list
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_client_add" {{$role->hasRole('role_client_add') ? 'checked' : ''}}>
                                        Add new Client
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_client_edit" {{$role->hasRole('role_client_edit') ? 'checked' : ''}}>
                                        Update Client Info
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_client_delete" {{$role->hasRole('role_client_delete') ? 'checked' : ''}}>
                                        Delete Client Info
                                    </label>
                                </li>
                            </ul>
                        </div>  

                        <div class="col-md-6">
                            <h4>Inspectors Management</h4>
                            <ul class="no-bullet">
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_inspector_view" {{$role->hasRole('role_inspector_view') ? 'checked' : ''}}>
                                        View Inspectors List
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_inspector_add" {{$role->hasRole('role_inspector_add') ? 'checked' : ''}}>
                                        Add New Inspector
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_inspector_edit" {{$role->hasRole('role_inspector_edit') ? 'checked' : ''}}>
                                        Update Inspector Info
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_inspector_delete" {{$role->hasRole('role_inspector_delete') ? 'checked' : ''}}>
                                        Delete Inspector Info
                                    </label>
                                </li>
                            </ul>
                        </div>  
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h4>Factory Management</h4>
                            <ul class="no-bullet">
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_factory_view" {{$role->hasRole('role_factory_view') ? 'checked' : ''}}>
                                        View Factory List
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_factory_add" {{$role->hasRole('role_factory_add') ? 'checked' : ''}}>
                                        Add new Factory
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_factory_edit" {{$role->hasRole('role_factory_edit') ? 'checked' : ''}}>
                                        Update Factory Info
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_factory_delete" {{$role->hasRole('role_factory_delete') ? 'checked' : ''}}> 
                                        Delete Factory Info
                                    </label>
                                </li>
                            </ul>
                        </div>  
                        <div class="col-md-6">
                            <h4>User Permissions Management</h4>
                            <ul class="no-bullet">
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_change_permissions" {{$role->hasRole('role_change_permissions') ? 'checked' : ''}}>
                                        Change User Permissions
                                    </label>
                                </li>
                            </ul>
                        </div>  
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h4>Accounts Management</h4>
                            <ul class="no-bullet">
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_account_view" {{$role->hasRole('role_account_view') ? 'checked' : ''}}>
                                        View Accounts List
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_account_add" {{$role->hasRole('role_account_add') ? 'checked' : ''}}>
                                        Add New Account
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_account_edit" {{$role->hasRole('role_account_edit') ? 'checked' : ''}}>
                                        Update Account Info
                                    </label>
                                </li>
                                <li>
                                    <label>
                                        <input type="checkbox" name="role_account_delete" {{$role->hasRole('role_account_delete') ? 'checked' : ''}}>
                                        Delete Account Info
                                    </label>
                                </li>
                            </ul>
                        </div>  
                    </div>
                    <div class="row col-md-6 col-md-offset-6">
                        <button class="btn btn-success pull-right">Change User Permission</button>
                    </div>
                </form>
                
            </div>
    </div>
@endsection

@section('scripts')
	{{ Html::script('/js/admin/permissions.js') }}
@endsection
