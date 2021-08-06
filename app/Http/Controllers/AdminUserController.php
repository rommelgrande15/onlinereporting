<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\User;
use App\UserInfo;
use App\Role;
use DB;
use Session;

class AdminUserController extends Controller
{
    public function getLogin(){
    	$roles = Role::orderBy('id','desc')->take(4)->pluck('name','id');
    	return view('pages.admin.login.index',compact('roles'));
    }
    public function getLogin2(){
    	return view('pages.admin.login.index');
    }
    

    public function postLoginAdmin(Request $request){
        $user = User::where('email', $request['username'])->orWhere('username',$request['username'])->first();

        //check if user exists
        if ($user == null) {
            //check if client
            $client = Client::where('email', $request['username'])->orWhere('username', $request['username'])->first();

            if($client == null){
                //return URL::current();
                Session::flash('error','Incorrect email/password. Please login again!');
                if(strpos($request->url(), 'tic-sera') != false){
                    return redirect()->route('tic-sera-login');
                }else{
                    return redirect()->route('login');
                }
                
                //return redirect()->route('login');
            } else {
                /* if (Auth::guard('client')->attempt(['email' => $client['email'], 'password' => $request['password']])) {
                    return redirect()->intended(route('client.dashboard'));
                } */
            }
        } else {
            if ($user->status == 1) {
                /* if (Auth::attempt(['username'=>$request['username'],'password' =>$request['password'] ]) || Auth::attempt(['email'=>$request['username'],'password' =>$request['password'] ])) {
                    return redirect()->route('panel',$user);
                }else{
                    Session::flash('error','Incorrect email/password. Please login again!');
                    return redirect()->route('login');
                } */
                if (Auth::attempt(['username'=>$request['username'],'password' =>$request['password'] ]) || Auth::attempt(['email'=>$request['username'],'password' =>$request['password'] ])) {              
                    $user_info = UserInfo::where('user_id',  $user->id)->first();
                    if($user_info->designation=='client'){
                        if($user->levelState==0){                          
                            if($user->user_type=='tic_sera' || strpos($request->url(), 'tic-sera') != false){
                                return redirect()->route('account-settings-new-tic-sera');
                            }else{
                                return redirect()->route('account-settings-new');
                            }
                        }else{
                            if($user->user_type=='tic_sera' || strpos($request->url(), 'tic-sera') != false){
                                return redirect()->route('panel-client-tic-sera',$user);
                            }else{
                                return redirect()->route('panel-client',$user);
                            }
                            
                        }
					}else if($user_info->designation=='reports_review'){
                        return redirect()->route('reports-reviewer',$user);
                    }else if($user_info->designation=='supplier'){
                        return redirect()->route('panel-supplier',$user);
                    }else if($user_info->designation=='inspector'){
                        return redirect()->route('inspector-reviewer',$user);
                        // Session::flash('error','Inspector Dont need this. Please login again!');
                        // if(strpos($request->url(), 'tic-sera') != false){
                        //     return redirect()->route('tic-sera-login');
                        // }else{
                        //     return redirect()->route('login');
                        // }
                    }else{
                        return redirect()->route('panel',$user);
                    }
                }else{
                    Session::flash('error','Incorrect email/password. Please login again!');
                    if($user->user_type=='tic_sera' || strpos($request->url(), 'tic-sera') != false){
                        return redirect()->route('tic-sera-login');
                    }else{
                        return redirect()->route('login');
                    }
                    
                }
            } else if($user->status == 0){
                Session::flash('error','Please wait, our team is now checking and evaluating your account');
                if($user->user_type=='tic_sera' || strpos($request->url(), 'tic-sera') != false){
                    return redirect()->route('tic-sera-login');
                }else{
                    return redirect()->route('login');
                }
				//return redirect()->route('login');
			}else if($user->status == 2 && $user->category == 'supplier'){
                Session::flash('error','Your account was Deleted!');
                if($user->user_type=='tic_sera' || strpos($request->url(), 'tic-sera') != false){
                    return redirect()->route('tic-sera-login');
                }else{
                    return redirect()->route('login');
                }
				//return redirect()->route('login');
			}else{
                Session::flash('error',"Your account is not yet activated! Please contact us using our feedback form to resend your account activation code");
                //return redirect()->route('login');
                if($user->user_type=='tic_sera' || strpos($request->url(), 'tic-sera') != false){
                    return redirect()->route('tic-sera-login');
                }else{
                    return redirect()->route('login');
                }
            }
        }
        Session::flash('error','Incorrect email/password. Please login again!');
        //return redirect()->route('login');
        if($user->user_type=='tic_sera' || strpos($request->url(), 'tic-sera') != false){
            return redirect()->route('tic-sera-login');
        }else{
            return redirect()->route('login');
        }
    }
}
