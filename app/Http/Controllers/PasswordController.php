<?php
namespace App\Http\Controllers;
use App\Template;
use Dompdf\Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use App\Client;
use App\ClientCode;
use App\Report;
use App\Factory;
use App\FctoryContact;
use App\ReportUpload;
use App\ReportUploadFile;
use App\Role;
use App\User;
use App\Inspection;
use App\UserInfo;
use DB;
use Session;
use Mail;
use ZipArchive;


class PasswordController extends Controller
{
	
	public function getForgot(){
    	//$roles = Role::orderBy('id','desc')->take(4)->pluck('name','id');
    	return view('pages.forgot-password.index');
    }
    
    //Forgot Password for Sera
    public function getForgotSera(){
    	//$roles = Role::orderBy('id','desc')->take(4)->pluck('name','id');
    	return view('pages.forgot-password.index');
    }
	
	//Reset Form
	public function getResetPassword($reset_code){
		$user = User::where('password_reset',$reset_code)->first();
    	//$roles = Role::orderBy('id','desc')->take(4)->pluck('name','id');
		if($user){
			$user_info = UserInfo::where('user_id',$user->id)->first();
			return view('pages.forgot-password.reset_password',compact('user_info','user','reset_code'));
		} else {
			//$reset_code->session()->flash('status', 'Reset code invalid.');
			return redirect('forgot-password');
		}
    	
    }
	//Reset Form Submit TIC
	public function postResetPassword(Request $request){
        $company_name = "The Inspection Company";
        $route = redirect()->route('login');

        
		$email_address = $request['email'];
		$reset_code = $request['reset_code'];
		$user = User::where('password_reset',$reset_code)
			->where('email',$email_address)
			->first();
		if($user){
			$user_info = UserInfo::where('user_id',$user->id)->first();
			$email_address = $user->email;
			$user_password = $request['password'];
			$user_confirm_password = $request['repeat_password'];
			if($user_password == $user_confirm_password){
				if(!empty($user_password) || $user_password!=""){
					$user->password = bcrypt($user_password);
					$user->plain = $user_password;
					if($user->update()) {
						$user->password_reset = NULL;
						if($user->update()){
							$data = ['email' => $email_address,
									 'client_name' => $user_info->name,
									 'company_name' => $company_name
									];
							Mail::send('email.password_changed',$data, function($message) use ($data){
                                $message->from('postmaster@t-i-c.asia',$data['company_name']);
								$message->to($data['email'],$data['client_name']);      
								$message->subject('Password Changed (' . $data['email'] . ') - ' . $data['company_name']);
							});            
							if (count(Mail::failures()) > 0) {
								$request->session()->flash('status', 'Email Failed or not Valid');
								return $route;
							} else {
								$request->session()->flash('status', 'Password Reset Successfully');
								return $route;
							}
						}
					}
				}
			} else {
				$request->session()->flash('status', 'Password Not Match');
				return view('pages.forgot-password.reset_password',compact('user_info','user','reset_code'));
			}
		} else {
			$request->session()->flash('status', 'Account not found!');
			return view('pages.forgot-password.reset_password',compact('user_info','user','reset_code'));
		}
    	
    }
    
    //Reset Form Submit TIC_SERA
	public function postResetPasswordSera(Request $request){
        $company_name = "TIC-SERA";
        $route = redirect()->route('tic-sera-login');
		$email_address = $request['email'];
		$reset_code = $request['reset_code'];
		$user = User::where('password_reset',$reset_code)
			->where('email',$email_address)
			->first();
		if($user){
			$user_info = UserInfo::where('user_id',$user->id)->first();
			$email_address = $user->email;
			$user_password = $request['password'];
			$user_confirm_password = $request['repeat_password'];
			if($user_password == $user_confirm_password){
				if(!empty($user_password) || $user_password!=""){
					$user->password = bcrypt($user_password);
					$user->plain = $user_password;
					if($user->update()) {
						$user->password_reset = NULL;
						if($user->update()){
							$data = ['email' => $email_address,
									 'client_name' => $user_info->name,
									 'company_name' => $company_name
									];
							Mail::send('email.password_changed',$data, function($message) use ($data){
                                $message->from('postmaster@t-i-c.asia',$data['company_name']);
								$message->to($data['email'],$data['client_name']);
								$message->subject('Password Changed (' . $data['email'] . ') - ' . $data['company_name']);
							});            
							if (count(Mail::failures()) > 0) {
								$request->session()->flash('status', 'Email Failed or not Valid');
								return $route;
							} else {
								$request->session()->flash('status', 'Password Reset Successfully');
								return $route;
							}
						}
					}
				}
			} else {
				$request->session()->flash('status', 'Password Not Match');
				return view('pages.forgot-password.reset_password',compact('user_info','user','reset_code'));
			}
		} else {
			$request->session()->flash('status', 'Account not found!');
			return view('pages.forgot-password.reset_password',compact('user_info','user','reset_code'));
		}
    	
    }
	
	public function postForgot(Request $request) {
        if(url()->current() == 'https://tic-service.company/forgot-password_click-tic-sera'){
            $company_name = "TIC-SERA";
            $route = redirect()->route('tic-sera-login');
            $route_forgot = redirect()->route('forgotSera');
        } else {
            $company_name = "The Inspection Company";
            $route = redirect()->route('login');
            $route_forgot = redirect()->route('forgot');
        }
        
		$email = $request['email'];
		$user = User::where('email',$email)
			->orWhere('username', $email)
			->first();
		if($user){
			$user_info = UserInfo::where('user_id',$user->id)->first();
			$email_address = $user->email;
			$password_reset = uniqid();
			$user->password_reset = $password_reset;
			$user->update();
			$data = ['email' => $email_address,
					 'password_reset' => $password_reset,
					 'client_name' => $user_info->name,		 
					 'company_name' => $company_name	 
				];
				Mail::send('email.password_reset',$data, function($message) use ($data){
                    $message->from('postmaster@t-i-c.asia',$data['company_name']);
					$message->to($data['email'],$data['client_name']);     
					$message->subject('Password Reset - (' . $data['email'] . ') - ' . $data['company_name']);
				});            
				if (count(Mail::failures()) > 0) {
					$request->session()->flash('status', 'Email Failed or not Valid');
					return $route_forgot;
				} else {
					$request->session()->flash('status', 'Reset code sent. Check your Email or Spam Email');
                    return $route;
				}
		} else {
			$request->session()->flash('status', 'Account not found!');
			return $route_forgot;
		}

	}
	
// End PasswordController
}
