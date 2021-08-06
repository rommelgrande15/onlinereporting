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


class EmailController extends Controller
{
	
	public function getRequestForm(){
    	$user_info = UserInfo::where('user_id',Auth::id())->first();
    	return view('pages.client.requestApp.index',compact('user_info'));
    }
	
	// IOS Request Submit
	public function SubmitRequestForm(Request $request){
		$email_address = $request['email'];
		$name = $request['name'];
		
		if(!empty($email_address) && !empty($name)){
			$data = ['email' => $email_address,
					 'name' => $name	 
					];
			Mail::send('email.request_IOS_app',$data, function($message) use ($data){
				$message->to('it-support@t-i-c.asia','IT Support');
				$message->to('lacaprommel11@gmail.com','Rommel Lacap');
				$message->subject('Booking IOS App Requested - The Inspection Company');
			});            
			if (count(Mail::failures()) > 0) {
				$request->session()->flash('status', 'Email Failed or not Valid');
				return redirect()->route('request-app');
			} else {
				$request->session()->flash('status', 'Booking App Requested');
				return redirect()->route('request-app');
			}
		} else {
			$request->session()->flash('status', 'Email and Name Required!');
			return redirect()->route('request-app');
		}
    }
	
// End EmailController
}
