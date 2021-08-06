<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inspector;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserInfo;
use App\Client;
use App\Inspection;
use Session;
use DB;
 
class InspectorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getInspectors(){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
    	$inspectors = DB::table('user_infos')
                    ->join('users','users.id','=','user_infos.user_id')
                    ->select('users.id','users.email','users.username','users.id','user_infos.contact_number','user_infos.id as user_info_id', 'user_infos.name','user_infos.address','user_infos.created_at as user_info_created') 
                    ->where('designation','inspector')
                    ->where('user_infos.status',0)
                    ->get();
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_status','Client Pending')->count();
    	return view('pages.admin.inspectors.index',compact('inspectors','role','user_info','new_client_count','new_post_client'));
    }

    public function getInspectorsData(Request $request){
        
        $users = DB::table('user_infos')
                ->where('email_address',$request['email'])
                ->get();
                 echo $users;
        /* return view($users['email_address']); */
    }

    public function getInspectorsDataNew(Request $request){
        
        $users = DB::table('user_infos')
                ->where('email_address',$request['email'])
                ->get();
                 echo $users;
        /* return view($users['email_address']); */
    }


    public function getInspectorsUsernameData(Request $request){
        
        $users = DB::table('users')
                ->where('username',$request['username'])
                ->get();
                 echo $users;
        /* return view($users['email_address']); */
    }

    public function getInspectorsUsernameDataNew(Request $request){
        
        $users = DB::table('users')
                ->where('username',$request['username'])
                ->get();
                 echo $users;
        /* return view($users['email_address']); */
    }

    public function postNewInspector(Request $request){
     
 /*    	 $this->validate($request,array(
    	 	'username' => 'required|unique:users',
           	'email' => 'required|email|unique:users',
			'password' => 'required',
			'password_confirmation' => 'required',
			'inspector_name' => 'required',
			'contact_number' => 'required',
           'address' => 'required',
        )); */

         $user = new User();
         
    	 $user->username = $request['username'];
    	 $user->email = $request['email'];
         $user->password = bcrypt($request['password']);
         $user->plain = $request['password'];
    	 $user->status = 1;

    	 if ($user->save()) {
    	 	$inspector = new UserInfo();
            $inspector->user_id = $user->id;
    	 	$inspector->name = $request['inspector_name'];
    	 	$inspector->email_address = $request['email'];
            $inspector->contact_number = $request['contact_number'];
            $inspector->tel_number = $request['tel_number'];
            $inspector->address = $request['address'];
               
            $inspector->user_country_name = $request['user_country_name'];
            $inspector->user_country_id = $request['user_country_id'];
            $inspector->user_state_name = $request['user_state_name'];
            $inspector->user_state_id = $request['user_state_id'];
            $inspector->user_city_name = $request['user_city_name'];
            $inspector->user_city_id = $request['user_city_id'];

            $user_skype= $request['inspector_skype'];
            $user_wechat = $request['inspector_wechat'];
            $user_whatsapp = $request['inspector_whatsapp'];
            $user_qqmail = $request['inspector_qqmail'];

            if($user_skype==""){ $user_skype="N/A"; }
            if($user_wechat==""){ $user_wechat="N/A"; }
            if($user_whatsapp==""){ $user_whatsapp="N/A"; }
            if($user_qqmail==""){ $user_qqmail="N/A";}

            $inspector->user_skype = $user_skype;
            $inspector->user_wechat = $user_wechat;
            $inspector->user_whatsapp = $user_whatsapp;
            $inspector->user_qqmail = $user_qqmail;

            $inspector->designation = 'inspector';
    	 	if ($inspector->save()) {
    	 		Session::flash('success','You have successfully created a new inspector user');
    	 		return redirect()->route('inspectors');
    	 	}
    	 }

    }

    public function getOneInspector($id){
        $inspector = UserInfo::where('user_id',$id)->first();
        $user = User::where('email',$inspector->email_address)->first();
        return response()->json([
            'inspector_id' => $inspector->id,
            'inspector_name' => $inspector->name,
            'inspector_email' => $inspector->email_address,
            'contact_number' => $inspector->contact_number,
            'tel_number' => $inspector->tel_number,
            'address' => $inspector->address,
            'username' => $user->username,
            

            'user_skype' => $inspector->user_skype,
            'user_wechat' => $inspector->user_wechat,
            'user_whatsapp' => $inspector->user_whatsapp,
            'user_qqmail' => $inspector->user_qqmail,

            'user_country_name' => $inspector->user_country_name,
            'user_country_id' => $inspector->user_country_id,
            'user_state_name' => $inspector->user_state_name,
            'user_state_id' => $inspector->user_state_id,
            'user_city_name' => $inspector->user_city_name,
            'user_city_id' => $inspector->user_city_id

        ]);
    }

    public function getAllInspector(){
        $inspectors = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->get();
        return response()->json([
            'inspectors' => $inspectors
        ]);
    }


    public function updateInspector(Request $request){
         $this->validate($request,array(
            'inspector_name' => 'required',
            'contact_number' => 'required',
        ));
        $usernamevalidator=null;
        $usernameData=$request['update_username'];;
        $usernamevalidator=User::where('username',$usernameData)->first();
        $inspector = UserInfo::find($request['inspector_id']);
        $user2 = User::find($inspector->user_id);
        $user = User::where('email',$inspector->email_address)->first();

         if($usernamevalidator !=null && $inspector->user_id !=$usernamevalidator->id){

            return "already";
        } 
        $user2->username=$request['update_username'];
        
        $inspector->name = $request['inspector_name'];
        $inspector->email_address = $request['email'];
        $inspector->contact_number = $request['contact_number'];
        $inspector->tel_number = $request['update_tel_number'];
        
        /* $inspector->address = $request['address']; */
        $inspector->address = $request['update_inspector_city'] .' '. $request['update_inspector_state'] .' '. $request['update_inspector_country_name'];
        
        $inspector->user_skype = $request['update_skype'];
        $inspector->user_wechat = $request['update_wechat'];
        $inspector->user_whatsapp = $request['update_whatsapp'];
        $inspector->user_qqmail = $request['update_qqmail'];
        $inspector->user_country_name = $request['update_inspector_country_name'];
        $inspector->user_country_id = $request['update_inspector_country'];
        $inspector->user_state_name = $request['update_inspector_state'];
        $inspector->user_state_id = $request['update_inspector_state_id'];
        $inspector->user_city_name = $request['update_inspector_city'];
        $inspector->user_city_id = $request['update_inspector_city'];

        $inspector->user_skype = $request['update_skype'];
        $inspector->user_wechat = $request['update_wechat'];
        $inspector->user_whatsapp = $request['update_whatsapp'];
        $inspector->user_qqmail = $request['update_qqmail'];

         if ($inspector->update() && $user2->update()) {
            $user->email = $request['email'];
            if ($user->update()) {
                Session::flash('success','You have successfully updated the user details.');
                return redirect()->route('inspectors');
            }
         }

    }


    public function deleteInspector(Request $request){
        /* $inspector = UserInfo::find($request['inspector_id']);
        $user = User::where('email',$inspector->email_address)->first();
        if ($inspector->delete()) {
            $user->delete();
            Session::flash('error', 'Inspector details has been deleted from the database!');
            return redirect()->route('inspectors');
        } */


        $inspector = UserInfo::find($request['inspector_id']);
        $inspector->status=2;//delete status
        if($inspector->save()){
            Session::flash('error', 'Inspector details has been deleted from the database!');
            return redirect()->route('inspectors')->with('alert', 'Deleted!');
        }
    }



}
