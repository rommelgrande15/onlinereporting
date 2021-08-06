<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Client;
use App\SubAccountPrivelege;
use DB;
use App\UserInfo;
use App\Supplier;
use App\SupplierData;
use App\SupplierContact;
use App\ClientContact;
use Session;
use Mail;
use App\Inspection;
class AccountsManagementController extends Controller
{
   	public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAccounts(){
    	$role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        if($user_info->designation == 'booking' || $user_info->designation == 'admin'  || $user_info->designation == 'super_admin'){
            $accounts = DB::table('user_infos')
                    ->join('users','users.id','=','user_infos.user_id')
                    ->select('users.id','users.email','users.username','users.id','user_infos.contact_number','user_infos.id as user_info_id', 'user_infos.name','user_infos.designation','user_infos.created_at')
                    ->whereNotIn('designation',['inspector'])
                    ->get();
            $designation = [
                'reports_review'=>'Reports Review',
                'administrator' => 'Administrator',
                'super_admin' => 'Super Admin',
                'sales' => 'Sales',
                'booking' => 'Booking',
                'factory' => 'Factory',
                'client' => 'Client',
                'supplier' => 'Supplier'
            ];

            $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
    	   return view('pages.admin.accounts.index',compact('accounts','role','user_info','designation','new_client_count'));
        } else {
            return redirect()->route('client-accounts');
        } 
    	
    }

    public function postNewAccount(Request $request){

    /* 	 $this->validate($request,array(
    	 	'username' => 'required|unique:users',
           	'email' => 'required|email|unique:users',
			'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6',
			'account_name' => 'required',
			'contact_number' => 'required',
			'designation' => 'required'
        ));
 */
		$user = new User();
		$user->username = $request['username'];
		$user->email = $request['email'];
		$user->password = bcrypt($request['password']);
		$user->plain = $request['password'];
		$user->status = 1;
		if($request['designation'] == 'reports_review'){
			$user->category = 'reports_review';
		}

    	 if ($user->save()) {
    	 	$inspector = new UserInfo();
            $inspector->user_id = $user->id;
    	 	$inspector->name = $request['inspector_name'];
    	 	$inspector->email_address = $request['email'];
    	 	$inspector->contact_number = $request['contact_number'];
    	 	$inspector->name = $request['account_name'];
			 
            $inspector->designation = $request['designation'];
           $GroupSection = $request['GroupSection'];
            if($GroupSection=="Others"){
                $inspector->groupDesignation = $request['groupInputdata'];

            }else{
                $inspector->groupDesignation = $request['GroupSection'];
            }
            $inspector->address = "N/A";
    	 	if ($inspector->save()) {
    	 		Session::flash('success','You have successfully created a new user');
    	 		return redirect()->route('accounts');
    	 	}
    	 }
    }

    public function getOneAccount($id){
        $account = UserInfo::where('user_id',$id)->first();
        $user = User::where('id',$account->id)->first();
        $cccode = DB::table('clients')->where('user_id',Auth::id())->first();
        $clientCode = $cccode->client_code;
        $supplierData = SupplierData::where('user_id',$id)->first();
        $clientContacts = ClientContact::where('id',$supplierData->supplier_client_contact_id)->first();
        $supplierContactData = DB::table('supplier_contacts')
                    ->where('supplier_id', $supplierData->supplier_id)
                    ->where('client_code',$clientCode)
                    ->get();
            return response()->json([
                'account' => $account,
                'user' => $user,
                'supplierData'=>$supplierData,
                'clientContacts'=>$clientContacts,
                'supplierContactData'=>$supplierContactData,
                'clientCode' => $clientCode,
            ]);
    }

    public function getOneAccountDetail($id){
        $account = UserInfo::find($id);
        $user = User::where('id',$account->user_id)->first();
        $supplierData = DB::table('supplier_datas')->where('user_id', $user->id)->first();
        $supplier = DB::table('suppliers')->where('id', $supplierData->supplier_id)->first();
        $supplierClientContact = ClientContact::where('id', $supplierData->supplier_client_contact_id)->get();
        $supplierContact = SupplierContact::where('id', $supplierData->supplier_contact_id)->get();
        return response()->json([
            'supplier' => $supplier,
            'supplierClientContact' => $supplierClientContact,   
            'supplierContact' => $supplierContact,         
        ]);
    }

    public function updateAccount(Request $request){
         $this->validate($request,array(
            'inspector_name' => 'required',
            'contact_number' => 'required',
            'designation' => 'required',
        ));

        $inspector = UserInfo::find($request['account_id']);
        $user = User::where('email',$inspector->email_address)->first();
        
        $inspector->name = $request['inspector_name'];
        $inspector->email_address = $request['email'];
        $inspector->contact_number = $request['contact_number'];
        $inspector->designation = $request['designation'];

         if ($inspector->update()) {
			 $user->email = $request['email'];
			 if($request['designation'] == 'reports_review'){
				 $user->category = 'reports_review';
			 } else {
				 $user->category = 'client';
			 }
            if ($user->update()) {
                Session::flash('success','Account details has been successfully updated!');
                return redirect()->route('accounts');
            }
         }

    }

     public function deleteAccount(Request $request){
        $account = UserInfo::find($request['account']);
        $user = User::where('email',$account->email_address)->first();
        if ($account->delete()) {
            $user->delete();
            Session::flash('error', 'Account details has been deleted from the database!');
            return redirect()->route('accounts');
        }
    }
    
    /* =====================================Client Account Management===================================== */
    
    public function getClientAccounts(){
        $sub_acc="no";
        $privelege="";
    	$role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
    	$accounts = DB::table('user_infos')
                    ->join('users','users.id','=','user_infos.user_id')
                    ->select('users.id','users.email','users.username','users.id','user_infos.contact_number','user_infos.id as user_info_id', 'user_infos.name','user_infos.designation','user_infos.created_at')
                    ->whereNotIn('designation',['inspector'])
                    ->where('group_id',Auth::id())
                    ->get();
        $ccode = DB::table('clients')->where('user_id',Auth::id())->first();
        $new_post_client = Inspection::where('inspection_type',null)
                                    ->where('inspection_status','Client Pending')
                                    ->where('supplier_book','true')
                                    // ->where('client_id',$code->client_code)
                                    ->count();
        if($role->group_id=="" || $role->group_id==null){
            return view('pages.client.accounts.index',compact('accounts','role','user_info','sub_acc','privelege','new_post_client'));
        }else{
            
        }
    }

    public function getSupplierAccounts(){
        $sub_acc="no";
        $privelege="";
    	$role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $clients = DB::table('clients')->where('client_code', $role->client_code)->first();
        
        $clientsData = DB::table('client_contacts')
                ->where('client_code', $role->client_code)->get();
        $supplierData = DB::table('suppliers')
                ->where('client_code', $role->client_code)
                ->where('supplier_status','!=',2)->get();
    	$accounts = DB::table('user_infos')
                    ->join('users','users.id','=','user_infos.user_id')
                    ->select('users.id','users.email','users.username','users.id','user_infos.contact_number','user_infos.id as user_info_id', 'user_infos.name','user_infos.designation','user_infos.created_at')
                    ->where('designation','supplier')
                    ->where('users.status','!=',2)
                    ->where('group_id',$clients->id)
                    ->get();
        $ccode = DB::table('clients')->where('user_id',Auth::id())->first();
        $new_post_client = Inspection::where('inspection_type',null)
                                    ->where('inspection_status','Client Pending')
                                    ->where('supplier_book','true')
                                    ->where('client_id',$ccode->client_code)
                                    ->count();
        if($role->group_id=="" || $role->group_id==null){
            return view('pages.client.accounts.index-supplier',compact('accounts','role','user_info','sub_acc','privelege','supplierData','clientsData','new_post_client'));
        }else{
            
        }
    }

    public function getSubAccountHistory(){
        $sub_acc="no";
        $privelege="";
    	$role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
    	$accounts = DB::table('user_infos')
                    ->join('users','users.id','=','user_infos.user_id')
                    ->select('users.id','users.email','users.username','users.id','user_infos.contact_number','user_infos.id as user_info_id', 'user_infos.name','user_infos.designation','user_infos.created_at')
                    ->whereNotIn('designation',['inspector'])
                    ->where('group_id',Auth::id())
                    ->get();
    	return view('pages.client.accounts.history',compact('accounts','role','user_info','sub_acc','privelege'));
    }

    public function postSupplierNewAccount(Request $request){
        DB::beginTransaction();
        try {
            
            $suppliers = DB::table('suppliers')->where('id', $request['supplier_id'])->first();
            $clients = DB::table('clients')->where('client_code', $suppliers->client_code)->first();
            $username = User::select('email','username')->first();
            $user = new User();
            $user->group_id = Auth::id();
            if(User::select('username')->where('username',$request['username'])->first()){
                return response()->json([
                    'message' => "Username Already registered"
                ],400);
            } else {
                $user->username = $request['username'];
            }

            if(User::select('email')->where('email',$request['email'])->first()){
                //return response()->json("Email Address Already registered",400);
                return response()->json([
                    'message' => "Email Address Already registered"
                ],400);
            } else {
                $user->email = $request['email'];
            }
            $user->group_id = $clients->id;
            $user->password = bcrypt($request['password']);
            $user->plain = $request['password'];
            $user->category = 'supplier';
            $user->levelState = 1;
            $user->status = 1;

            if ($user->save()) {
                 $UserInfo = new UserInfo();
                 $UserInfo->user_id = $user->id;
                 $UserInfo->email_address = $request['email'];
                 $UserInfo->contact_number = $request['contact_number'];
                 $UserInfo->name = $request['account_name'];
                 $UserInfo->designation = 'supplier';
                 $UserInfo->address = "N/A";
                 if ($UserInfo->save()) {
                    
                    $SupplierData = new SupplierData();
                    $SupplierData->user_id=$user->id;
                    $SupplierData->supplier_id=$request['supplier_id'];
                    $SupplierData->supplier_client_contact_id=$request['supplier_client_contact_id'];
                    $SupplierData->supplier_contact_id=$request['supplier_contact_id'];
                    $SupplierData->email_receiver=$request['email_reciever'];
                    $SupplierData->report_access=$request['report_access'];
                    $SupplierData->no_email=$request['no_email'];
                    $SupplierData->save();

                    $privelege = new SubAccountPrivelege();
                    $privelege->user_id=$user->id;
                    $privelege->save();
                 }
                $supplierContactName = SupplierContact::where('id',$request['supplier_contact_id'])->first();
                $supplierContactClientName = ClientContact::where('id',$request['supplier_client_contact_id'])->first();
            }
            $data = ['client_rep_email' =>  ['rommel.grande071517@gmail.com'],
                    'username' =>  $request['username'],
                    'email' => $request['email'],
                    'password' => $request['password'],
                    'contact_number' => $request['contact_number'],
                    'account_name' => $request['account_name'],
                    'client_name' =>  $clients->client_name,
                    'supplier_contact_person' =>  $supplierContactName->supplier_contact_person,
                    'supplier_contact_number' =>  $supplierContactName->supplier_contact_number,
                    'contact_name' =>  $supplierContactClientName->contact_person,
                    'contact_number_client' =>  $supplierContactClientName->contact_number,
					];
                Mail::send('email.new_supplier_informations_client_contacts',$data, function($message) use ($data){
                    $message->to($data['client_rep_email']);
                    // $message->cc('it-support@t-i-c.asia','IT Support');
                    // $message->subject('Supplier Credential');                                                
                });     
                if (count(Mail::failures()) > 0) {
                    DB::rollback();
                    return response()->json([
                        'message' => 'error',
                    ],500);
                }else{      
                    DB::commit();     
                    return response()->json([
                        'message' => 'ok',
                    ]);
                    //return view('pages.client.trackInspection.index'
                    //return redirect()->route('administrator');
                }  
        } catch (Exception $e) {
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function postClientNewAccount(Request $request){
        DB::beginTransaction();
        try {
            return $request;
            $username = User::select('email','username')->first();
		    $user = new User();
		    $user->group_id = Auth::id();
            if(User::select('username')->where('username',$request['username'])->first()){
                return response()->json([
					'message' => "Username Already registered"
				],400);
            } else {
                $user->username = $request['username'];
            }

            if(User::select('email')->where('email',$request['email'])->first()){
                //return response()->json("Email Address Already registered",400);
				return response()->json([
					'message' => "Email Address Already registered"
				],400);
            } else {
                $user->email = $request['email'];
            }

		    $user->password = bcrypt($request['password']);
		    $user->plain = $request['password'];
            $user->category = 'client';
		    $user->levelState = 1;
		    $user->status = 1;

    	    if ($user->save()) {
    	     	$inspector = new UserInfo();
                $inspector->user_id = $user->id;
    	     	$inspector->name = $request['inspector_name'];
    	     	$inspector->email_address = $request['email'];
    	     	$inspector->contact_number = $request['contact_number'];
    	     	$inspector->name = $request['account_name'];
            
                $inspector->designation = 'client';
                $inspector->address = "N/A";
    	     	if ($inspector->save()) {
                    
                    $privelege = new SubAccountPrivelege();
                    $privelege->user_id=$user->id;
                    $privelege->save();

                    DB::commit();
                    Session::flash('success','You have successfully created a new user');
                    if($request['site_url']=='tic-sera'){
                        return redirect()->route('sub-accounts-tic-sera');
                    }else{
                        return redirect()->route('sub-accounts');
                    }
    	     		
    	     	}
            }
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function postFactoryNewAccount(Request $request){
        DB::beginTransaction();
        try {
            $username = User::select('email','username')->first();
		    $user = new User();
		    $user->group_id = Auth::id();
            if(User::select('username')->where('username',$request['username'])->first()){
                return response()->json([
					'message' => "Username Already registered"
				],400);
            } else {
                $user->username = $request['username'];
            }

            if(User::select('email')->where('email',$request['email'])->first()){
                //return response()->json("Email Address Already registered",400);
				return response()->json([
					'message' => "Email Address Already registered"
				],400);
            } else {
                $user->email = $request['email'];
            }

		    $user->password = bcrypt($request['password']);
		    $user->plain = $request['password'];
            $user->category = 'factory';
		    $user->levelState = 1;
		    $user->status = 1;

    	    if ($user->save()) {
    	     	$factory = new UserInfo();
                $factory->user_id = $user->id;
    	     	$factory->name = $request['inspector_name'];
    	     	$factory->email_address = $request['email'];
    	     	$factory->contact_number = $request['contact_number'];
    	     	$factory->name = $request['account_name'];
            
                $factory->designation = 'factory';
                $factory->address = "N/A";
    	     	if ($factory->save()) {
                    
                    $privelege = new SubAccountPrivelege();
                    $privelege->user_id=$user->id;
                    $privelege->save();

                    DB::commit();
                    Session::flash('success','You have successfully created a new user');
                    if($request['site_url']=='tic-sera'){
                        return redirect()->route('sub-accounts-tic-sera');
                    }else{
                        return redirect()->route('sub-accounts');
                    }
    	     		
    	     	}
            }
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function getClientOneAccount($id){
        $account = UserInfo::where('user_id',$id)->first();
        $user = User::where('email',$account->email_address)->first();
        return response()->json([
            'account' => $account,
            'user' => $user
        ]);
    }

    public function getPrivelege($id){
        $privelege = SubAccountPrivelege::where('user_id',$id)->first();
        return response()->json([
            'privelege' => $privelege
        ]);
    }

    public function updatePrivelege(Request $request){
        DB::beginTransaction();
        try {
            $get_privelege = SubAccountPrivelege::where('user_id',$request['user_id'])->first();
            if(!empty($get_privelege)){
                $id=$get_privelege->id;
                $privelege = SubAccountPrivelege::find($id);
                $privelege->create_order = $request['create_order'];
                $privelege->edit_order = $request['edit_order'];
                $privelege->copy_order = $request['copy_order'];
                $privelege->cancel_order = $request['cancel_order'];
                $privelege->delete_order = $request['delete_order'];
                $privelege->create_supplier = $request['create_supplier'];
                $privelege->update_supplier = $request['update_supplier'];
                $privelege->delete_supplier = $request['delete_supplier'];
                $privelege->create_factory = $request['create_factory'];
                $privelege->update_factory = $request['update_factory'];
                $privelege->delete_factory = $request['delete_factory'];
                $privelege->create_product = $request['create_product'];
                $privelege->update_product = $request['update_product'];
                $privelege->delete_product = $request['delete_product'];
                $privelege->save();
                DB::commit();
                return response()->json([
                    'message'=>'ok'
                ],200);
            }else{
                
                $new_privelege = new SubAccountPrivelege();
                $new_privelege->user_id=$request['user_id'];
                $new_privelege->create_order = $request['create_order'];
                $new_privelege->edit_order = $request['edit_order'];
                $new_privelege->copy_order = $request['copy_order'];
                $new_privelege->cancel_order = $request['cancel_order'];
                $new_privelege->delete_order = $request['delete_order'];
                $new_privelege->create_supplier = $request['create_supplier'];
                $new_privelege->update_supplier = $request['update_supplier'];
                $new_privelege->delete_supplier = $request['delete_supplier'];
                $new_privelege->create_factory = $request['create_factory'];
                $new_privelege->update_factory = $request['update_factory'];
                $new_privelege->delete_factory = $request['delete_factory'];
                $new_privelege->create_product = $request['create_product'];
                $new_privelege->update_product = $request['update_product'];
                $new_privelege->delete_product = $request['delete_product'];
                $new_privelege->save();
                DB::commit();
                return response()->json([
                    'message'=>'ok'
                ],200);
            }
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }


   }
    public function updateClientAccount(Request $request){
         $this->validate($request,array(
            'inspector_name' => 'required',
            'contact_number' => 'required',
        ));
        
        $supplierInformation = SupplierData::where('user_id',$request['account_id'])->first();
        $inspector = UserInfo::find($request['account_id']);
        $user = User::where('email',$inspector->email_address)->first();

        $supplierInfo = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',$request['account_id'])->first();
        $userData = DB::table('users')->where('id',$supplierInfo->user_id)->first();


        if(User::select('email')->where('email',$request['email'])->first() === $request['email']){
            //return response()->json("Email Address Already registered",400);
            
            return response()->json([
                'message' => "Email Address Already registered"
            ],400);
        }else if($request['email'] === ''){
            return response()->json([
                'message' => "Please Select Supplier Contact Person To Fill The Email."
            ],400);
        }else if($userData->email === $request['email']){
            $user->email = $request['email'];
        }else{
            $user->email = $request['email'];
        }
        
        $inspector->name = $request['inspector_name'];
        $inspector->email_address = $request['email'];
        $inspector->contact_number = $request['contact_number'];

        
        $supplierInformation->supplier_client_contact_id = $request['supplier_client_contact_id'];
        $supplierInformation->supplier_contact_id = $request['supplier_contact_id'];
        $supplierContactName = SupplierContact::where('id',$request['supplier_contact_id'])->first();
        $supplierClientName = ClientContact::where('id',$request['supplier_client_contact_id'])->first();
        $user = User::where('id',$request['account_id'])->first();
        $user->email = $request['email'];
        $userInfo = UserInfo::where('user_id',$request['account_id'])->first();
        $userInfo->email_address = $request['email'];
         if ($inspector->update()) {
			 $user->email = $request['email'];
                if ($user->update()) {
                    if($supplierInformation->update()){
                        if($user->update()){
                            if($userInfo->update()){
                            $data = ['client_rep_email' =>  $request['email'],
                            'username' =>  $request['update_username'],
                            'email' => $request['email'],
                            'contact_number' => $request['contact_number'],
                            'account_name' => $request['inspector_name'],
                            'supplier_contact_person' =>  $supplierContactName->supplier_contact_person,
                            'supplier_contact_number' =>  $supplierContactName->supplier_contact_number,
                            'contact_name' =>  $supplierClientName->contact_person,
                            'contact_number_client' =>  $supplierClientName->contact_number
                            ];
                            Mail::send('email.update-new_supplier_informations',$data, function($message) use ($data){
                                $message->to($data['client_rep_email']);
                                $message->cc('it-support@t-i-c.asia','IT Support');
                                $message->subject('Updated Supplier  Credential');                                                
                            });  
                            Session::flash('success','Account details has been successfully updated!');
                            if($request['site_url']=='tic-sera'){
                                return redirect()->route('sub-accounts-tic-sera');
                            }else{
                                return redirect()->route('sub-accounts');
                            }
                        }
                    }
                }
            }
        }
    }

    public function deleteClientAccount(Request $request){
        $updated = DB::table('users')
            ->where('id', $request['account'])
            ->update(['status' => 2]);

        if($updated) {
            Session::flash('error', 'Account details has been deleted from the database!');
            if($request['site_url']=='tic-sera'){
                return redirect()->route('sub-accounts-tic-sera');
            }else{
                return redirect()->route('supplier-accounts');
            }
        }
        else {
        }
    }
    //DELETE ON LIVE WEBSITE
    // public function deleteClientAccount(Request $request){
    //     $account = UserInfo::find($request['account']);
    //     $user = User::where('email',$account->email_address)->first();
    //     if ($account->delete()) {
    //         $user->delete();
    //         Session::flash('error', 'Account details has been deleted from the database!');
    //         if($request['site_url']=='tic-sera'){
    //             return redirect()->route('sub-accounts-tic-sera');
    //         }else{
    //             return redirect()->route('sub-accounts');
    //         }
    //     }
    // }
}
