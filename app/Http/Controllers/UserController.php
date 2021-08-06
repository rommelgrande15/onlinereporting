<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserInfo;
use App\Role;
use App\Company;
use App\Client;
use App\Factory;
use App\Country;
use App\CustRequirement;
use App\BookingSummary;
use Session;
use Mail;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',['except' => ['postLogin','testMail']]);
    }

    public function getLoginIndex(){
    	return view('pages.login.index');
    }
    
    
    //Resend Email Activation
     public function resendActivationCode(){
    	return view('pages.forgot-password.resend_email');
    }
    
    //Resend Email Activation Submit
    public function resendActivationCodeSubmit(Request $request){
        $email=$request['email'];
        if(!$email)
        {
            Session::flash('error','Please check you email!');
            return redirect()->route('login');
        }

        $user = User::where('email',$email)
            ->where('status',0)
            ->orWhere('username',$email)
            ->first();
        //user type
        $user_type=null;
        if($user){
            $user_type=$user->user_type;
        } else {
            $msg_subject='Resend Email Activation - TIC Online Booking';
        }
        if($user_type=='tic_sera'){
            $com_name = "TIC-SERA";
            $msg_subject='Resend Email Activation - TIC-SERA Online Booking';
        } else {
            $com_name = "The Inspection Company";
            $msg_subject='Resend Email Activation - TIC Online Booking';
        }

        if(!$user){
            Session::flash('error','Invalid Email provided! Please check you email!');
            return redirect()->route('login');
        } else {
			$user_info = UserInfo::where('user_id',$user->id)->first();
			$email = $user->email;
            if($user->confirmation_code == NULL){
                $user->confirmation_code = str_random(35);
            }
        	
        	if($user->save()){
				$data = [
					'email' =>  $email,
                    'name' => $user_info->name,
                    'user_type' => $user_type,
                    'code' => $user->confirmation_code,
                    'com_name' => $com_name,
                    'msg_subject' => $msg_subject
				];

                try {
                    Mail::send('email.verify',$data, function($message) use ($data){
						$message->to($data['email']);
						$message->bcc('it-support@t-i-c.asia','IT Support');
						//$message->cc('gregor@t-i-c.asia','Gregor'); 
						//$message->cc('booking@t-i-c.asia','Booking'); 
                        $message->subject($data['msg_subject']);
                    });

                    Session::flash('success','Email sent, Please check your email to activate your account');
                    if($user_type=='tic_sera'){
                        return redirect()->route('create-account-tic-sera');
                    }else{
                        return redirect()->route('login');
                    }
                    
                } catch (Exception $e) {
                    return response()->json([
                        'message' => $e->getMessage()
                    ]);
                }	
			}
		}
    }

    public function send_Mail(Request $request){

        $name=$request['name'];
        $email=$request['email'];
       

        $data = ['name' => $name,"email"=>$email];

        Mail::send('email.FileManagerEmail',$data, function($message) use ($data){
            $message->to('it-support@t-i-c.asia');
            $message->cc('lacaprommel11@gmail.com');
            $message->cc('irincomanuel@gmail.com');
            $message->subject('Request for IOS APP of ' . $data['name']);
        });

        if (count(Mail::failures()) > 0) {
            return response()->json([
                'Error'=>'There was an error sending your mail'
            ],500);
        }else{
            return response()->json([
                'message'=>'OK'
            ],200);
        }
    }

    public function postLogin(Request $request){
        $user = User::where('email', $request['username'])->orWhere('username',$request['username'])->first();
        //check if user exists
        if (!$user) {
            Session::flash('error','Incorrect email/password. Please login again!');
            return redirect()->route('login');
        }

        if ($user->status == 1) {
            if (Auth::attempt(['username'=>$request['username'],'password' =>$request['password'] ]) || Auth::attempt(['email'=>$request['username'],'password' =>$request['password'] ])) {
                            return redirect()->route('dashboard');
            }else{
                Session::flash('error','Incorrect email/password. Please login again!');
                return redirect()->route('login');
            }
        }else{
            Session::flash('error',"Your account is not yet activated! Please contact us using our feedback form to resend your account activation code");
            return redirect()->route('login');
        }
    }

    public function getRegister(){
        $countries = Country::pluck('nicename','phonecode');
        return view('pages.register.index',compact('countries'));
    }

    public function postUserSignUp(Request $request){
    	$validator = $this->validate($request,array(
    	 	'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'client_code' => 'required|unique:users',
    		'password' => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6',
            'company_name'=>'required',
            'company_website'=>'required',
            'company_email'=>'required',
            'company_address'=>'required',
            'invoice_address'=>'required',
            'country'=>'required',
            'company_city'=>'required',
            'company_zip'=>'required',
			'full_name' => 'required|max:25',
			'position'=>'required',
			'phone_number'=>'required|max:15'
        ));

        // if ($validator->fails())
        //  {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

    	$role_client = Role::where('name','client')->first();
        $confirmation_code = str_random(35);

    	$user = new User();	
    	$user->email = $request['email'];
        $user->client_code = $request['client_code'];
    	$user->username = $request['username'];
    	$user->password = bcrypt($request['password']);
        $user->confirmation_code = $confirmation_code;
        $user->status = 0;
        $user->save();
 
        $company = new Company();
        $company->user_id = $user->id;
        $company->company_name = $request['company_name'];
    	$company->company_website = $request['company_website'];
    	$company->company_email = $request['company_email'];
        $company->company_address = $request['company_address'];
        $company->invoice_address = $request['invoice_address'];
        $company->country_code = $request['country'];
        $company->company_city = $request['company_city'];
        $company->company_zip = $request['company_zip'];
        $company->full_name = $request['full_name'];
        $company->position = $request['position'];
        $company->phone_number = $request['phone_number'];
        $company->save();

        $user->roles()->attach($role_client);

        $cr = new CustRequirement();
        $cr->user_id = $user->id;
        $cr->no_key_component = 1;
        $cr->no_serial_number = 1;
        $cr->no_rating_label = 1;
        $cr->no_removable_sticker_product = 1;
        $cr->missing_logo_product = 1;
        $cr->no_removable_sticker_carton = 1;
        $cr->no_imp_exp_info = 1;
        $cr->packing_not_finished = 1;
        $cr->production_not_finished = 1;
        $cr->report_requirement_1 = 'CE';
        $cr->report_requirement_2 = 'CE';
        $cr->report_requirement_3 = 'CE';

        $cr->double_sampling = 0;
        $cr->seal_every_product = 0;
        $cr->seal_opened_carton = 0;
        $cr->seal_on_whole_quantity = 0;
        $cr->tic_own_report = 'TIC';
        $cr->tic_chop = 0;

        $cr->temperature_test = 0;
        $cr->humidity_test = 0;
        $cr->temp_rise_test = 0;
        $cr->noise_test = 0;
        $cr->special_requirements = 'n/a';

        $cr->instructions = 'n/a';
        $cr->blister_packing = 1;
        $cr->carton_packing = 1;
        $cr->tape = 'PT';

        $cr->additional_requirements = 'n/a';

        if ($cr->save()) {

            $client = new Client();
            $client->client_code = $request['client_code'];
            $client->client_name = $request['company_name'];
            $client->contact_person = $request['full_name'];
            $client->contact_number = $request['phone_number'];
            $client->email_address = $request['email'];

            if ($client->save()) {
                $data = ['email' =>  $request['email'],'confirmation_code' => $confirmation_code];

                try {
                    Mail::send('email.verify',$data, function($message) use ($data){
                        $message->to($data['email']);
                        $message->subject('Activate Your Account');
                    });

                    Session::flash('success','Successfully Created new Account. Please check your email for the steps in activating your account');
                    return redirect()->route('register');
                } catch (Exception $e) {
                    return response()->json([
                        'message' => $e->getMessage()
                    ]);
                } 
            }

           
        }               
    }

    public function activateUser($confirmation_code){
        if(!$confirmation_code)
        {
            Session::flash('error','Invalid Confirmation code provided! Please check you email!');
            return redirect()->route('login');
        }

        $user = User::where('confirmation_code',$confirmation_code)->first();
        //user type
        $user_type=null;
        if($user){
            $user_type=$user->user_type;
        }
        if($user_type=='tic_sera'){
            $msg_subject='Account Activated - TIC-SERA Online Booking';
        }

        if(!$user){
            Session::flash('error','Invalid Confirmation code provided! Please check you email!');
            return redirect()->route('login');
        } else {
			$user_info = UserInfo::where('user_id',$user->id)->first();
			$email = $user->email;
			$user->status = 2;
        	$user->confirmation_code = null;
        	if($user->save()){
				$data = [
					'email' =>  $email,
                    'name' => $user_info->name,
                    'user_type' => $user_type
				];

                try {
                    Mail::send('email.after_activation',$data, function($message) use ($data){
						$message->to($data['email']);
						$message->bcc('it-support@t-i-c.asia','IT Support');
						$message->bcc('gregor@t-i-c.asia','Gregor'); 
						$message->bcc('booking@t-i-c.asia','Booking'); 
                        $message->subject('Email Confirmation - The Inspection Company Online Booking');
                    });

                    Session::flash('success','You have activated your account! Please wait, our team is now checking and evaluating your account');
                    if($user_type=='tic_sera'){
                        return redirect()->route('create-account-tic-sera');
                    }else{
                        return redirect()->route('login');
                    }
                    
                } catch (Exception $e) {
                    return response()->json([
                        'message' => $e->getMessage()
                    ]);
                }	
			}
		}
    }

    public function testMail(){
        $booking = BookingSummary::find(1);
        $user = User::find(Auth::id());
        $factory = Factory::find(1);
        $company = Company::where('user_id',Auth::id())->first();
        $service = [
                    "iqi"=>"Incoming Quality Inspection",
                    "psi"=>"Pre Shipment Inspection",
                    "cli"=>"Container Loading Inspection",
                    "dupro"=>"During Production Inspection",
                    "pls"=>"Setting Up Production Lines",
        ];
        $service_type = $service[$booking->service_type];

        $data = ['email' =>  $user->email,'booking_id' => 1, 'full_name' => $company->full_name, 'factory'=>$factory, 'booking'=>$booking,'service'=>$service_type];
        Mail::send('email.booking',$data, function($message) use ($data){
            $message->to($data['email']);
            $message->subject('Booking Details');
        });
    }
	
	public function checkusername(Request $request)
	{
		$user = $request->user;
		$usercheck = DB::table('user')->where('username',$user)->count();
		if($usercheck > 0)
		{
			echo "Email Already In Use.";
		}
	}


    
}
