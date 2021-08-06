<?php

namespace App\Http\Controllers;

use App\User;
use App\UserInfo;
use App\Client;
use App\UserLog;
use App\SubAccountPrivelege;
use App\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $group = User::select('group_id')->where('id',Auth::id())->first();
            $role="";
            $sub_acc="no";
         	$privelege="";
            if(!empty($group->group_id)){
                //return 'dev';
                $role = User::where('id',$group->group_id)->first(); 
                $sub_acc="yes";
		        $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
            } else {            
                $role = User::where('id',Auth::id())->first();
                $sub_acc="no";
            }
        
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        //$group_id = User::select('group_id')->where('id',Auth::id())->first();
        
       //$logs = \LogActivity::logActivityLists();
            $logs = DB::table('user_logs')
    		->join('users', 'user_logs.user_id', '=', 'users.id')
    		->select('user_logs.*','users.username')
            ->where('user_logs.group_id',Auth::id())
            ->get();
        return view('pages.client.user-logs.index',compact('logs','user','user_info','role','sub_acc','privelege'));
    }
    
    public function history($category)
    {
        $group = User::select('group_id')->where('id',Auth::id())->first();
            $role="";
            $sub_acc="no";
         	$privelege="";
            if(!empty($group->group_id)){
                //return 'dev';
                $role = User::where('id',$group->group_id)->first(); 
                $sub_acc="yes";
		        $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
            } else {            
                $role = User::where('id',Auth::id())->first();
                $sub_acc="no";
            }
        
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        
        if($category == 'factory'){
            $logs = DB::table('user_logs')
    		->join('users', 'user_logs.user_id', '=', 'users.id')
    		->select('user_logs.*','users.username')
            ->where('user_logs.group_id',Auth::id())
            ->whereIn('user_logs.category',['factory','supplier'])
            //->orWhere('user_logs.category')
            ->get();
        } else {
            $logs = DB::table('user_logs')
    		->join('users', 'user_logs.user_id', '=', 'users.id')
    		->select('user_logs.*','users.username')
            ->where('user_logs.group_id',Auth::id())
            ->where('user_logs.category',$category)
            ->get();
        }
        $ccode = DB::table('clients')->where('user_id',Auth::id())->first();
       $new_post_client = Inspection::where('inspection_type',null)
                                    ->where('inspection_status','Client Pending')
                                    ->where('supplier_book','true')
                                    ->where('client_id',$ccode->client_code)
                                    ->count();
            
        return view('pages.client.user-logs.index',compact('logs','user','user_info','role','sub_acc','privelege','category','new_post_client'));
    } 
    
    public function myTestAddToLog()
    {
        \LogActivity::addToLog('test');
        dd('log insert successfully.');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
/*    public function logActivity()
    {
        $logs = \LogActivity::logActivityLists();
        return view('logActivity',compact('logs'));
    }*/

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function show(UserLog $userLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function edit(UserLog $userLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserLog $userLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserLog  $userLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserLog $userLog)
    {
        //
    }
}
