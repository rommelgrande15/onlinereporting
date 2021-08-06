<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserInfo;
use App\Client;
use App\Inspection;
use Session;
use DB;
 
class SalesManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getSalesManager(){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
    	$sales_manager = DB::table('user_infos')
                    ->join('users','users.id','=','user_infos.user_id')
                    ->select('users.id','users.email','users.username','users.id','user_infos.contact_number','user_infos.id as user_info_id', 'user_infos.name','user_infos.address','user_infos.created_at as user_info_created') 
                    ->where('designation','sales')
                    ->where('user_infos.status',0)
                    ->get();
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_status','Client Pending')->count();
    	return view('pages.admin.sales.index',compact('sales_manager','role','user_info','new_client_count','new_post_client'));
    }

    public function getSalesData(Request $request){
        
        $users = DB::table('user_infos')
                ->where('email_address',$request['email'])
                ->get();
                 echo $users;
        /* return view($users['email_address']); */
    }

    public function getSalesDataNew(Request $request){
        
        $users = DB::table('user_infos')
                ->where('email_address',$request['email'])
                ->get();
                 echo $users;
        /* return view($users['email_address']); */
    }


    public function getSalesUsernameData(Request $request){
        
        $users = DB::table('users')
                ->where('username',$request['username'])
                ->get();
                 echo $users;
        /* return view($users['email_address']); */
    }

    public function getSalesUsernameDataNew(Request $request){
        
        $users = DB::table('users')
                ->where('username',$request['username'])
                ->get();
                 echo $users;
        /* return view($users['email_address']); */
    }

    public function postNewSales(Request $request){
     
 /*    	 $this->validate($request,array(
    	 	'username' => 'required|unique:users',
           	'email' => 'required|email|unique:users',
			'password' => 'required',
			'password_confirmation' => 'required',
			'sales_name' => 'required',
			'contact_number' => 'required',
           'address' => 'required',
        )); */

         $user = new User();
         
    	 $user->username = $request['sales_name'];
    	 $user->email = $request['email'];
        //  $user->password = bcrypt($request['password']);
        //  $user->plain = $request['password'];
    	 $user->status = 1;
         $user->category = 'sales';

    	 if ($user->save()) {
    	 	$sales = new UserInfo();
            $sales->user_id = $user->id;
    	 	$sales->name = $request['sales_name'];
    	 	$sales->email_address = $request['email'];
            // $sales->contact_number = $request['contact_number'];
            // $sales->tel_number = $request['tel_number'];
            // $sales->address = $request['address'];
               
            // $sales->user_country_name = $request['user_country_name'];
            // $sales->user_country_id = $request['user_country_id'];
            // $sales->user_state_name = $request['user_state_name'];
            // $sales->user_state_id = $request['user_state_id'];
            // $sales->user_city_name = $request['user_city_name'];
            // $sales->user_city_id = $request['user_city_id'];

            // $user_skype= $request['sales_skype'];
            // $user_wechat = $request['sales_wechat'];
            // $user_whatsapp = $request['sales_whatsapp'];
            // $user_qqmail = $request['sales_qqmail'];

            // if($user_skype==""){ $user_skype="N/A"; }
            // if($user_wechat==""){ $user_wechat="N/A"; }
            // if($user_whatsapp==""){ $user_whatsapp="N/A"; }
            // if($user_qqmail==""){ $user_qqmail="N/A";}

            // $sales->user_skype = $user_skype;
            // $sales->user_wechat = $user_wechat;
            // $sales->user_whatsapp = $user_whatsapp;
            // $sales->user_qqmail = $user_qqmail;

            $sales->designation = 'sales';
    	 	if ($sales->save()) {
    	 		Session::flash('success','You have successfully created a new sales user');
    	 		return redirect()->route('sales-manager');
    	 	}
    	 }

    }

    public function getOneSales($id){
        $sales = UserInfo::where('user_id',$id)->first();
        $user = User::where('email',$sales->email_address)->first();
        return response()->json([
            'sales_id' => $sales->id,
            'sales_name' => $sales->name,
            'sales_email' => $sales->email_address,
            'contact_number' => $sales->contact_number,
            'tel_number' => $sales->tel_number,
            'address' => $sales->address,
            'username' => $user->username,
            

            'user_skype' => $sales->user_skype,
            'user_wechat' => $sales->user_wechat,
            'user_whatsapp' => $sales->user_whatsapp,
            'user_qqmail' => $sales->user_qqmail,

            'user_country_name' => $sales->user_country_name,
            'user_country_id' => $sales->user_country_id,
            'user_state_name' => $sales->user_state_name,
            'user_state_id' => $sales->user_state_id,
            'user_city_name' => $sales->user_city_name,
            'user_city_id' => $sales->user_city_id

        ]);
    }

    public function getAllSales(){
        $sales = UserInfo::where('designation','sales')->where('status',0)->orderBy('name','asc')->get();
        return response()->json([
            'sales' => $sales
        ]);
    }


    public function updateSales(Request $request){
         $this->validate($request,array(
            'sales_name' => 'required',
            'email' => 'required',
        ));
        
        $sales = UserInfo::find($request['sales_id']);
        $user2 = User::find($sales->user_id);
        $user = User::where('email',$sales->email_address)->first();

        $user2->username=$request['sales_name'];
        
        $sales->name = $request['sales_name'];
        $sales->email_address = $request['email'];
        // $sales->contact_number = $request['contact_number'];
        // $sales->tel_number = $request['update_tel_number'];
        
        /* $sales->address = $request['address']; */
        // $sales->address = $request['update_sales_city'] .' '. $request['update_sales_state'] .' '. $request['update_sales_country_name'];
        
        // $sales->user_skype = $request['update_skype'];
        // $sales->user_wechat = $request['update_wechat'];
        // $sales->user_whatsapp = $request['update_whatsapp'];
        // $sales->user_qqmail = $request['update_qqmail'];
        // $sales->user_country_name = $request['update_sales_country_name'];
        // $sales->user_country_id = $request['update_sales_country'];
        // $sales->user_state_name = $request['update_sales_state'];
        // $sales->user_state_id = $request['update_sales_state_id'];
        // $sales->user_city_name = $request['update_sales_city'];
        // $sales->user_city_id = $request['update_sales_city'];

        // $sales->user_skype = $request['update_skype'];
        // $sales->user_wechat = $request['update_wechat'];
        // $sales->user_whatsapp = $request['update_whatsapp'];
        // $sales->user_qqmail = $request['update_qqmail'];

         if ($sales->update() && $user2->update()) {
            $user->email = $request['email'];
            if ($user->update()) {
                Session::flash('success','You have successfully updated the user details.');
                return redirect()->route('sales-manager');
            }
         }

    }


    public function deleteSales(Request $request){
        $sales = UserInfo::find($request['sales_id']);
        $sales->status=2;//delete status
        if($sales->save()){
            Session::flash('error', 'Sales details has been deleted from the database!');
            return redirect()->route('sales-manager')->with('alert', 'Deleted!');
        }
    }



}
