<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Factory;
use App\Client;
use App\Country;
use App\User;
use App\UserInfo;
use App\FactoryContact;
use App\Report;
use App\PSIProduct;
use App\ClientCost;
use App\InspectorCost;
use App\Inspection;
use Session;
use DB;

class AdminInspectionCostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function InspectionCost(){
  		$role = User::where('id',Auth::id())->first();
    	//$FactoryContact = FactoryContact::all();
    	$factories = DB::table('factories')
              
                    ->select('factories.*')
                    ->get();
        $countries = Country::all();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $client_cost = ClientCost::orderBy('created_at', 'desc')->get();
        $inspector_cost = InspectorCost::orderBy('created_at', 'desc')->get();
        $inspection = Inspection::all();

        $client_pn=array();  //project number
        $client_rn=array();  //reference number
        foreach($inspection as $insp){
            $client_pn[$insp->id] = $insp->client_project_number;
            $client_rn[$insp->id] = $insp->reference_number;
        }

    	return view('pages.admin.InspectionCost.index',compact('role','factories','user_info','countries','client_cost','inspector_cost','client_pn','client_rn'));
    }

    public function ClientCost(){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_status','Client Pending')->count();
        return view('pages.admin.InspectionCost.index_client_cost',compact('role','user_info','new_client_count','new_post_client'));
    }
    public function InspectorCost(){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_status','Client Pending')->count();
        return view('pages.admin.InspectionCost.index_ins_cost',compact('role','user_info','new_client_count','new_post_client'));
    }


    
}
