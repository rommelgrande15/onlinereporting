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
use App\ClientAttachment;
use App\Role;
use App\User;
use App\UserInfo;
use App\Inspection;
use DB;
use Session;
use Mail;
use ZipArchive;


class ClientAttachmentController extends Controller
{	
	//Get the client reports on the Client side
	public function AddAttachmentPage($id){
		$inspect_id=$id;
		if(!Auth::id()){
			return redirect()->route('login');
		}
		$role = User::where('id',Auth::id())->first();	 
		if($role->category == 'client'){
			$user_info = UserInfo::where('user_id',Auth::id())->first();
			$user = User::where('id',Auth::id())->first();		 
			return view('pages.client.reportsPage.add_attachment',compact('user_info','user','inspect_id'));   
		} else {
		 	return redirect()->route('login');
		}
	 }

	 public function AddAttachment(Request $request){
		$auth_id=Auth::id();
		$inspect_id=$request['inspect_id'];
		$inspection = Inspection::where('id',$inspect_id)->first();
		$ref_num="";
		if(!empty($inspection)){
			$ref_num=$inspection->reference_number;
		}
		if($request->file('file')){
			try {
				foreach ($request->file('file') as $file) {
					$filename = $file->getClientOriginalName();
					$filename=str_replace("#","_",$filename);		
					//directory
					$dir="images/project2/".$inspect_id."/";				
					//move the files to the correct folder
					if (!File::exists($dir)) {
						File::makeDirectory($dir, 0777, true, true);
					}
				
					//save details to db
					$doc= new ClientAttachment();
					$doc->inspection_id = $inspect_id;
					$doc->project_number = $ref_num;
					$doc->file_name = $filename;
					$doc->file_size = $file->getSize();
					$doc->path = $dir.$filename;
					$doc->uploaded_by = $auth_id;
					$doc->save();
				
					$file->move($dir,$filename);
				}
				return response()->json([
					'message' => 'OK',
				],200);
			} catch (Exception $e) {
				return response()->json([
				   'message'=>$e->getMessage()
			   ],500);
	   		}
			
		}
	 }

	public function removeAttachment($id){
		$get_file = ClientAttachment::find($id);
		$file_name="";
		if(!empty($get_file)){
			$file_name=$get_file->path;
			$delete_file = ClientAttachment::find($id);
			if($delete_file->delete()){
				unlink($file_name);
				return response()->json([
					'message' => 'OK',
				],200);
			}else{
				return response()->json([
					'message'=>'Something went wrong. Please try again later'
				],500);
			}
		}
	}
}
