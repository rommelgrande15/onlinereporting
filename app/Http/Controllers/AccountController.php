<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Company;
use App\Country;
use App\User;
use Session;
use Mail;
use Hash;

class AccountController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth',['except' => ['getLogout']]);
    }

    public function getDashboard(){
        $company = Company::where('user_id',Auth::id())->first();
    	return view('pages.dashboard.index',compact('company'));
    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('login');
    }
    public function getLogoutTicSera(){
        Auth::logout();
        return redirect()->route('tic-sera-login');
    }

    public function getProfile(){
        $countries = Country::pluck('nicename','phonecode');
        $company = Company::where('user_id',Auth::id())->first();
        $user = User::where('id', Auth::id())->first();
        return view('pages.profile.index',compact('company','countries','user'));
    }

    public function updateProfile(Request $request){
        $company = Company::where('user_id',Auth::id())->first();
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
        $company->update();
        Session::flash('success',"You have sucessfully updated your profile!");
        return redirect()->route('dashboard');
    }

    public function accountSettings(){
         $company = Company::where('user_id',Auth::id())->first();
        $user = User::find(Auth::id());
        return view('pages.settings.index',compact('user','company'));
    }
    public function changeEmail(Request $request){

        $confirmation_code = str_random(35);
        $user = User::find(Auth::id());
        $user->email = $request['new_email'];
        $user->status = 0;
        $user->confirmation_code = $confirmation_code;
        $user->update();

        $data = ['email' =>  $request['new_email'],'confirmation_code' => $confirmation_code];
        Mail::send('email.verify',$data, function($message) use ($data){
            $message->to($data['email']);
            $message->subject('Email Changed! Activate Your Account');
        });

        Auth::logout();
        return redirect()->route('login');
    }

    public function changePassword(Request $request){
        $this->validate($request,array(
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ));
        $user = User::find(Auth::id());
        $new_password = $request['password'];
        if (Hash::check($request['old_password'], $user->getAuthPassWord())) {
            $user = User::find(Auth::id());
            $user->password = bcrypt($new_password);
            $user->update();
            Auth::logout();
            return redirect()->route('login');
        }else{
            Session::flash('error',"You have entered a wrong password!");
            return redirect()->route('settings');
        }

    }

    public function changeUsername(Request $request){
        $user = User::find(Auth::id());
        $user->username = $request['username'];
        $user->update();
        Session::flash('success',"You have successfully changed your username!");
        return redirect()->route('settings');

    }
}
