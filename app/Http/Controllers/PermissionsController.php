<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use DB;
use App\UserInfo;
use Session;

class PermissionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllAccounts(){
    	$role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
    	$accounts = DB::table('user_infos')
                    ->join('users','users.id','=','user_infos.user_id')
                    ->select('users.id','users.email','users.username','users.id','user_infos.contact_number','user_infos.id as user_info_id', 'user_infos.name','user_infos.designation')
                    ->whereNotIn('designation',['inspector'])
                    ->get();

        $designation = [
        				'reports_review'=>'Reports Review',
        				'administrator' => 'Administrator',
        				'super_admin' => 'Super Admin',
        				'sales' => 'Sales',
        				'booking' => 'Booking'
       				];

    	return view('pages.admin.permissions.index',compact('accounts','role','user_info','designation'));
    }

    public function setPermissions($id){
    		$role = User::where('id',Auth::id())->first();
        	$user_info = UserInfo::where('user_id',Auth::id())->first();
        	$user_id = $id;
        	return view('pages.admin.permissions.show',compact('user_info','role','user_id'));
    }

    public function updatePermissions(Request $request,$id){
    	$user = User::find($id);
    	$user->roles()->detach();

    	if ($request['role_client_view']) {
    		$user->roles()->attach(Role::where('name','role_client_view')->first());
    	}
    	if ($request['role_client_add']) {
    		$user->roles()->attach(Role::where('name','role_client_add')->first());
    	}
    	if ($request['role_client_edit']) {
    		$user->roles()->attach(Role::where('name','role_client_edit')->first());
    	}
    	if ($request['role_client_delete']) {
    		$user->roles()->attach(Role::where('name','role_client_delete')->first());
    	}
    	if ($request['role_inspector_view']) {
    		$user->roles()->attach(Role::where('name','role_inspector_view')->first());
    	}
    	if ($request['role_inspector_add']) {
    		$user->roles()->attach(Role::where('name','role_inspector_add')->first());
    	}
    	if ($request['role_inspector_edit']) {
    		$user->roles()->attach(Role::where('name','role_inspector_edit')->first());
    	}
    	if ($request['role_inspector_delete']) {
    		$user->roles()->attach(Role::where('name','role_inspector_delete')->first());
    	}
    	if ($request['role_factory_view']) {
    		$user->roles()->attach(Role::where('name','role_factory_view')->first());
    	}
    	if ($request['role_factory_add']) {
    		$user->roles()->attach(Role::where('name','role_factory_add')->first());
    	}
    	if ($request['role_factory_edit']) {
    		$user->roles()->attach(Role::where('name','role_factory_edit')->first());
    	}
    	if ($request['role_factory_delete']) {
    		$user->roles()->attach(Role::where('name','role_factory_delete')->first());
    	}
    	if ($request['role_change_permissions']) {
    		$user->roles()->attach(Role::where('name','role_change_permissions')->first());
    	}
    	if ($request['role_account_view']) {
    		$user->roles()->attach(Role::where('name','role_account_view')->first());
    	}
    	if ($request['role_account_add']) {
    		$user->roles()->attach(Role::where('name','role_account_add')->first());
    	}
    	if ($request['role_account_edit']) {
    		$user->roles()->attach(Role::where('name','role_account_edit')->first());
    	}
    	if ($request['role_account_delete']) {
    		$user->roles()->attach(Role::where('name','role_account_delete')->first());
    	}
    	Session::flash('success','Successfully changed user permissions!');
    	return redirect()->route('permissions');

    }
}
