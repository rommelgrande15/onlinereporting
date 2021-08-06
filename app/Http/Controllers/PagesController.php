<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Client;
use App\Inspection;
use App\UserInfo;

use DB;

class PagesController extends Controller
{
    public function getHome(){
    	return view('pages.main.home');
    }

    public function getNewDashboard(){
    	$role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
    		->where('role_user.user_id',Auth::id())->first();
		$user_info = UserInfo::where('user_id',Auth::id())->first();
		$inspection_count = Inspection::get()->count();
		$client_count = Client::get()->count();
		$inspection_this_day_count = Inspection::whereDay('created_at', '=', date('d'))->get()->count();
		$client_this_month_count = Client::whereMonth('created_at', '=', date('m'))->where('client_code','!=','000')->get()->count();
		
		//$q->whereMonth('created_at', '=', date('m'));
		
    	return view('pages.admin.newdb.index',compact('role','user_info','inspection_count','client_count','inspection_this_day_count','client_this_month_count'));
    }
}
