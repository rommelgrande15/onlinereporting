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
use App\ClientContact;
use App\Report;
use App\Factory;
use App\FctoryContact;
use App\ReportUpload;
use App\ReportUploadFile;
use App\Role;
use App\User;
use App\Inspection;
use App\UserInfo;
use App\SubAccountPrivelege;
use DB;
use Session;
use Mail;
use ZipArchive;


class ReportsReviewerController extends Controller
{	
	private $reports_path;
	
	public function __construct() {
		$this->reports_path = public_path('reviewer-reports');
	
	} 

	public function getDashboardPanelReport($id){
		if(!Auth::id()){
			return redirect()->route('login');
		}
		
		$role = User::where('id',Auth::id())->first();
		
		if($role->category == 'reports_review'){
			$user_info = UserInfo::where('user_id',Auth::id())->first();
        	$user = User::where('id',Auth::id())->first();
        	$reviewers = UserInfo::select('id','name','email_address')
                ->where('designation','reports_review')
                ->where('email_address','!=','lovelaine@t-i-c.asia')
                ->where('email_address','!=','aljean@t-i-c.asia')
                //->where('email_address','!=','zen4emil@gmail.com')
                ->orderBy('name')
                ->get();
			return view('pages.reportsReviewer.index',compact('user_info','user','reviewers'));
		} else {
			return redirect()->route('login');
		}
		
	}
 
	//All Reports Server side
	public function allInspections(Request $request){
		
        $columns = array( 
			0 => 'client_book',
			1 => 'reference_number',
			2 => 'client_name',
			3 => 'Company_Name',
			4 => 'name',
			5 => 'inspection_status',
			6 => 'inspection_date',
			7 => 'id'
		);
  
		$totalData = DB::table('inspections')
		->leftJoin('user_infos', 'inspections.reviewed_by', '=', 'user_infos.user_id')
		->leftJoin('clients', 'clients.client_code', '=', 'inspections.client_id')
		->leftJoin('users', 'clients.client_code', '=', 'users.client_code')
		->select('inspections.id','inspections.client_book','inspections.client_id','inspections.inspection_status','inspections.reference_number','clients.client_name','clients.Company_Name','inspections.created_at','inspections.inspection_date','inspections.reviewed_by','user_infos.name')
        ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
		->get()
		->count();

        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value'))){
			$inspections = DB::table('inspections')
				->leftJoin('user_infos', 'inspections.reviewed_by', '=', 'user_infos.user_id')
				->leftJoin('clients', 'clients.client_code', '=', 'inspections.client_id')
				->leftJoin('users', 'clients.client_code', '=', 'users.client_code')
				->select('inspections.id','inspections.client_book','users.is_online','inspections.client_id','inspections.inspection_status','inspections.reference_number','clients.client_name','clients.Company_Name','inspections.created_at','inspections.inspection_date','inspections.reviewed_by','user_infos.name')
                ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

        } else {
            $search = $request->input('search.value');

			$inspections = DB::table('inspections')
				->leftJoin('user_infos', 'inspections.reviewed_by', '=', 'user_infos.user_id')
				->leftJoin('clients', 'clients.client_code', '=', 'inspections.client_id')
				->leftJoin('users', 'clients.client_code', '=', 'users.client_code')
				->select('inspections.id','inspections.client_book','users.is_online','inspections.client_id','inspections.inspection_status','inspections.reference_number','clients.client_name','clients.Company_Name','inspections.created_at','inspections.inspection_date','inspections.reviewed_by','user_infos.name')
                ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
                ->where(function($query) use ($search) {
                    $query->where('inspections.reference_number','LIKE',"%{$search}%")
                        ->orWhere('users.is_online', 'LIKE',"%{$search}%")
                        ->orWhere('clients.client_name', 'LIKE',"%{$search}%")
                        ->orWhere('clients.Company_Name', 'LIKE',"%{$search}%")
                        ->orWhere('user_infos.name', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.inspection_status', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.client_book', 'LIKE',"%{$search}%");
                })
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

			$totalFiltered = DB::table('inspections')
				->leftJoin('user_infos', 'inspections.reviewed_by', '=', 'user_infos.user_id')
				->leftJoin('clients', 'clients.client_code', '=', 'inspections.client_id')
				->leftJoin('users', 'clients.client_code', '=', 'users.client_code')
				->select('inspections.id','inspections.client_book','users.is_online','inspections.client_id','inspections.inspection_status','inspections.reference_number','clients.client_name','clients.Company_Name','inspections.created_at','inspections.inspection_date','inspections.reviewed_by','user_infos.name')
                ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
				->where(function($query) use ($search) {
                    $query->where('inspections.reference_number','LIKE',"%{$search}%")
                        ->orWhere('users.is_online', 'LIKE',"%{$search}%")
                        ->orWhere('clients.client_name', 'LIKE',"%{$search}%")
                        ->orWhere('clients.Company_Name', 'LIKE',"%{$search}%")
                        ->orWhere('user_infos.name', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.inspection_status', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.client_book', 'LIKE',"%{$search}%");
                })
				->get()
				->count();
		}
		
		$data = array();
		if(!empty($inspections)){
			foreach ($inspections as $inspection){
                if($inspection->is_online == 1){
                    $online = "<span class='text-success' data-toggle='tooltip' data-placement='top' title='Online'><i class='fa fa-circle center'></i></span>";
                } else {
                    $online = "<span class='text-danger' data-toggle='tooltip' data-placement='top' title='Offline'><i class='fa fa-circle center'></i></span>";
                }
                
                $nestedData['client_book'] = $online;
                $nestedData['reference_number'] = $inspection->reference_number;
                $nestedData['client_name'] = $inspection->client_name;
                $nestedData['Company_Name'] = $inspection->Company_Name;
                $nestedData['name'] = $inspection->name;
                $nestedData['inspection_status'] = ucfirst($inspection->inspection_status);
                $nestedData['status'] = $inspection->inspection_status;
				//$nestedData['created_at'] = $inspection->created_at;
				$nestedData['inspection_date'] = $inspection->inspection_date;
				if($inspection->inspection_status!= "Hold" && $inspection->inspection_status!="Cancelled"){
					//if(Auth::id() == 728 || Auth::id() == 809){
						$nestedData['options'] = "
						<a class='btn btn-xs btn-primary btn_view' data-id='$inspection->id' data-ref_no='$inspection->reference_number' data-toggle='tooltip' title='Download Report'><i class='fa fa-cloud'> Download</i></a>
						<a class='btn btn-xs btn-success' id='btn_select' data-id='$inspection->id' data-ref_no='$inspection->reference_number' data-toggle='tooltip' title='Upload Report'><i class='fa fa-upload'></i> Upload</a>
						<a class='btn btn-xs btn-info btn_assign' data-id='$inspection->id' data-ref_no='$inspection->reference_number' data-toggle='tooltip' title='Assign Reviewer'><i class='fa fa-book'> Assign</i></a>
						";
					/*} else {
						$nestedData['options'] = "
                        <a class='btn btn-xs btn-info btn_assign' data-id='$inspection->id' data-ref_no='$inspection->reference_number' data-toggle='tooltip' title='Assign Reviewer'><i class='fa fa-book'> Assign</i></a>
                        <a class='btn btn-xs btn-primary btn_view' data-id='$inspection->id' data-ref_no='$inspection->reference_number' data-toggle='tooltip' title='Download Report'><i class='fa fa-cloud'> Download</i></a>";
					}*/
				} else {
					$nestedData['options'] = "";
				}
				
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }
	
	public function getDashboardPanelReport_NoMail($id){
		if(!Auth::id()){
			return redirect()->route('login');
		}
		
		$role = User::where('id',Auth::id())->first();
		
		if($role->category == 'reports_review'){
			$user_info = UserInfo::where('user_id',Auth::id())->first();
        	$user = User::where('id',Auth::id())->first();
        	$reviewers = UserInfo::select('id','name','email_address')->where('designation','reports_review')->orderBy('name')->get();
			
			return view('pages.reportsReviewer.index_noMail',compact('user_info','user','reviewers'));
		} else {
			return redirect()->route('login');
		}
		
	}
	
	public function getDashboardPanelMyReport(){
		if(!Auth::id()){
			return redirect()->route('login');
		}
		
		$role = User::where('id',Auth::id())->first();
		
		if($role->category == 'reports_review'){
			$user_info = UserInfo::where('user_id',Auth::id())->first();
        	$user = User::where('id',Auth::id())->first();
			//$date = \Carbon\Carbon::today()->subDays(30);
			
			$inspections = DB::table('inspections')
				->join('clients', 'inspections.client_id', '=', 'clients.client_code')
				->select('inspections.id','inspections.client_id','inspections.inspection_status','inspections.reference_number','clients.client_name','clients.Company_Name','reviewed_by','inspections.created_at','inspections.inspection_date')
				->where('inspections.reviewed_by',Auth::id())
				->limit(200)
				->latest()
				->get();
			
			return view('pages.reportsReviewer.my_reports',compact('inspections','user_info','user'));   
		} else {
			return redirect()->route('login');
		}
		
	}
    
    //All Reports Server side
	public function getmyInspections(Request $request){
		
        $columns = array( 
			0 => 'client_book',
			1 => 'reference_number',
			2 => 'client_name',
			3 => 'Company_Name',
			4 => 'name',
			5 => 'inspection_status',
			6 => 'inspection_date',
			7 => 'id'
		);
  
		$totalData = DB::table('inspections')
		->leftJoin('user_infos', 'inspections.reviewed_by', '=', 'user_infos.user_id')
		->leftJoin('clients', 'clients.client_code', '=', 'inspections.client_id')
		->leftJoin('users', 'clients.client_code', '=', 'users.client_code')
		->select('inspections.id','inspections.client_book','inspections.client_id','inspections.inspection_status','inspections.reference_number','clients.client_name','clients.Company_Name','inspections.created_at','inspections.inspection_date','inspections.reviewed_by','user_infos.name')
        ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
        ->where('inspections.reviewed_by',Auth::id())
		->get()
		->count();

        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
		$dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value'))){
			$inspections = DB::table('inspections')
				->leftJoin('user_infos', 'inspections.reviewed_by', '=', 'user_infos.user_id')
				->leftJoin('clients', 'clients.client_code', '=', 'inspections.client_id')
				->leftJoin('users', 'clients.client_code', '=', 'users.client_code')
				->select('inspections.id','inspections.client_book','users.is_online','inspections.client_id','inspections.inspection_status','inspections.reference_number','clients.client_name','clients.Company_Name','inspections.created_at','inspections.inspection_date','inspections.reviewed_by','user_infos.name')
                ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
                ->where('inspections.reviewed_by',Auth::id())
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

        } else {
            $search = $request->input('search.value');

			$inspections = DB::table('inspections')
				->leftJoin('user_infos', 'inspections.reviewed_by', '=', 'user_infos.user_id')
				->leftJoin('clients', 'clients.client_code', '=', 'inspections.client_id')
				->leftJoin('users', 'clients.client_code', '=', 'users.client_code')
				->select('inspections.id','inspections.client_book','users.is_online','inspections.client_id','inspections.inspection_status','inspections.reference_number','clients.client_name','clients.Company_Name','inspections.created_at','inspections.inspection_date','inspections.reviewed_by','user_infos.name')
                ->where('inspections.reviewed_by',Auth::id())
                ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
                ->where(function($query) use ($search) {
                    $query->where('inspections.reference_number','LIKE',"%{$search}%")
                        ->orWhere('users.is_online', 'LIKE',"%{$search}%")
                        ->orWhere('clients.client_name', 'LIKE',"%{$search}%")
                        ->orWhere('clients.Company_Name', 'LIKE',"%{$search}%")
                        ->orWhere('user_infos.name', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.inspection_status', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.client_book', 'LIKE',"%{$search}%");
                })
				->offset($start)
				->limit($limit)
				->orderBy($order,$dir)
				->get();

			$totalFiltered = DB::table('inspections')
				->leftJoin('user_infos', 'inspections.reviewed_by', '=', 'user_infos.user_id')
				->leftJoin('clients', 'clients.client_code', '=', 'inspections.client_id')
				->leftJoin('users', 'clients.client_code', '=', 'users.client_code')
				->select('inspections.id','inspections.client_book','users.is_online','inspections.client_id','inspections.inspection_status','inspections.reference_number','clients.client_name','clients.Company_Name','inspections.created_at','inspections.inspection_date','inspections.reviewed_by','user_infos.name')
                ->where('inspections.reviewed_by',Auth::id())
                ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
				->where(function($query) use ($search) {
                    $query->where('inspections.reference_number','LIKE',"%{$search}%")
                        ->orWhere('users.is_online', 'LIKE',"%{$search}%")
                        ->orWhere('clients.client_name', 'LIKE',"%{$search}%")
                        ->orWhere('clients.Company_Name', 'LIKE',"%{$search}%")
                        ->orWhere('user_infos.name', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.inspection_status', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.client_book', 'LIKE',"%{$search}%");
                })
				->get()
				->count();
		}
		
		$data = array();
		if(!empty($inspections)){
			foreach ($inspections as $inspection){
                if($inspection->is_online == 1){
                    $online = "<span class='text-success' data-toggle='tooltip' data-placement='top' title='Online'><i class='fa fa-circle'> ( Online Client )</i></span>";
                } else {
                    $online = "<span class='text-danger' data-toggle='tooltip' data-placement='top' title='Offline'><i class='fa fa-circle'>  - ( Offline Client )</i></span>";
                }
                
                $nestedData['client_book'] = $online;
                $nestedData['reference_number'] = $inspection->reference_number;
                $nestedData['client_name'] = $inspection->client_name;
                $nestedData['Company_Name'] = $inspection->Company_Name;
                $nestedData['name'] = $inspection->name;
                $nestedData['inspection_status'] = ucfirst($inspection->inspection_status);
                $nestedData['status'] = $inspection->inspection_status;
				//$nestedData['created_at'] = $inspection->created_at;
				$nestedData['inspection_date'] = $inspection->inspection_date;
				if($inspection->inspection_status!= "Hold" && $inspection->inspection_status!="Cancelled"){
						$nestedData['options'] = "
						<a class='btn btn-xs btn-primary btn_view' data-id='$inspection->id' data-ref_no='$inspection->reference_number' data-toggle='tooltip' title='Download Report'><i class='fa fa-cloud'> Download</i></a>
						<a class='btn btn-xs btn-success' id='btn_select' data-id='$inspection->id' data-ref_no='$inspection->reference_number' data-toggle='tooltip' title='Upload Report'><i class='fa fa-upload'></i> Upload</a>";
				} else {
					$nestedData['options'] = "";
				}
				
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
    }
	
	public function getClientReport($id){
        $inspection_new = DB::table('inspections')
            ->select('client_id','reference_number')
            ->where('id',$id)                    
            ->first(); 
        
        $clients = Client::select('client_name','Company_Email')
            ->where('client_code',$inspection_new->client_id)
            ->first();
        
        $client_contacts = DB::table('client_contacts')
            ->select('email_address')
            ->where('email_address', '!=', $clients->Company_Email)           
            ->where('client_code',$inspection_new->client_id)           
            ->where('report_notify',1)               
            ->get();
        
        $supplier_contacts = DB::table('supplier_contacts')
            ->select('supplier_contacts.supplier_email')
            ->leftJoin('supplier_datas','supplier_contacts.supplier_id','=','supplier_datas.supplier_id')
            ->leftJoin('inspections','supplier_datas.supplier_id','=','inspections.supplier_id')
            ->where('inspections.supplier_book', 'true')
            ->where('supplier_datas.email_reciever', 1)
            ->where('inspections.reference_number', $inspection_new->reference_number)
            ->get();

        return response()->json([
            'clients' => $clients,
            'client_contacts' => $client_contacts,
            'supplier_contacts' => $supplier_contacts,
        ]);
    }
	
	//Get the client reports on the Client side
	public function getDashboardClientReports(){
       if(!Auth::id()){
			return redirect()->route('login');
		}
		
		$role = User::where('id',Auth::id())->first();
		
		if($role->category == 'client'){
			 //Sub Account
			$sub_acc="no";
         	$privelege="";
            $g = User::select('group_id')->where('id',Auth::id())->first();
            if(empty($g->group_id)){
				$client_id = Auth::id();
				$sub_acc="no";
            } else {
				$client_id = $g->group_id;
				$sub_acc="yes";
				$privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
            }
            
			$user_info = UserInfo::where('user_id',Auth::id())->first();
        	$user = User::where('id',$client_id)->first();
			
			$inspections = DB::table('inspections')
				->join('clients', 'inspections.client_id', '=', 'clients.client_code')
				->select('inspections.id','inspections.client_id','inspections.reference_number','inspections.client_project_number','inspections.inspection_status','inspections.created_at','inspections.updated_at','inspections.service')
				->where('inspections.client_id',$user->client_code)
				->where('inspections.inspection_status','!=','Deleted')
				->get();

			$ccode = DB::table('clients')->where('user_id',Auth::id())->first();
			$new_post_client = Inspection::where('inspection_type',null)
											->where('inspection_status','Client Pending')
											->where('client_id',$ccode->client_code)
											->count();
			
			return view('pages.client.reportsPage.index',compact('inspections','user_info','user','sub_acc','privelege','new_post_client'));   
		} else {
			return redirect()->route('login');
		}
	}
	
	
	
	 public function store(Request $request) {
		 DB::beginTransaction();
		 try {
			 header('Content-Type: text/html; charset=utf-8');
			 
			 $req = $request['request'];
			 $id = $request['id'];
			 $inspection_id = $request['inspection_id'];
			 $report_status = $request['report_status'];
			 $company_email = $request['company_email'];
			 $recipient_email = $request['recipient_email'];
			 $recipient_mail = explode(';', $recipient_email);
			 if(empty($request['cc_email'])){
				 $cc_email = $cc_mail = "";
			 } else {
				 $cc_email = $request['cc_email'];
				 $cc_mail = explode(';', $cc_email);
			 }
			 $inspections = Inspection::where('id',$inspection_id)->first();
			 $client_id = $inspections->client_id;
			 $factory_id = $inspections->factory;
			 $factories = Factory::where('id',$factory_id)->first();
			 $fact_name = $factories->factory_name;
			 $clients = Client::where('client_code',$client_id)->first();
			 $reviewer = UserInfo::where('user_id',Auth::id())->first();
			 $reviewer_name = $reviewer->name;
			 $reviewer_email = $reviewer->email_address;
			 $client_name = $clients->client_name;
			 $inspection_date = $inspections->inspection_date;
		 
			 if($req == 2){
				 $uploaded_report = ReportUploadFile::where('name', $id)->first();
				 if (empty($uploaded_report)) {
					 return response()->json(['message' => 'Sorry file does not exist'], 400);
				 }
				 $file_path = $this->reports_path . '/' . $uploaded_report->name;
 
				 if (file_exists($file_path)) {
					 unlink($file_path);
				 }
 
				 if (!empty($uploaded_report)) {
					 $uploaded_report->delete();
				 }
 
				 return response()->json(['message' => 'File successfully delete'], 200);
			 }
		 
			 $upload_file_name=array();
			 foreach ($request->file('file') as $file) {
				 $save_name = $file->getClientOriginalName();
				 //Change Name of the file if there's a # sign
				 $save_name = str_replace('#','No.',$save_name);
				 $file->move($this->reports_path . '/' . $inspection_id . '/', $save_name);
				 $report_upload = new ReportUpload();
				 $report_upload->inspection_id = $inspection_id;
				 $report_upload->user_id = Auth::id();
				 $report_upload->client_code = $client_id;
				 $report_upload->reference_no = $inspections->reference_number;
				 $report_upload->client_email = $company_email;
				 $report_upload->client_cc_email = $recipient_email;
				 $report_upload->client_bcc_email = $cc_email;
				 $report_upload->report_file = $save_name;
				 $report_upload->report_file_size = $file->getSize();
				 array_push($upload_file_name,$this->reports_path . '/' . $inspection_id . '/'. $save_name);  
				 $report_upload->save();
			 }
		 
			 $inspections->inspection_status = "Report Released";
			 $inspections->report_status = $report_status;
			 $inspections->update();
			 $data = ['company_email' => $company_email,
					  'recipient_mail' => $recipient_mail,
					  'cc_mail' => $cc_mail,				 
					  'reference_no' => $inspections->reference_number,
					  'inspection_id' => $inspection_id,
					  'created_by' => $inspections->created_by,
					  'factory_name' => $fact_name,
					  'client_name' => $client_name,
					  'inspection_date' => date('F d, Y',strtotime($inspection_date)),
					  'reviewer_name' => $reviewer_name,
					  'reviewer_email' => $reviewer_email,
					  'report_file' => $upload_file_name,
					  'client_id' => $client_id,
					  'report_status' => $report_status
					 ];
			 Mail::send('email.send_report',$data, function($message) use ($data){
				 
				 
				 $message->to($data['company_email'],$data['client_name']);
				 
				 /*$client_contacts = ClientContact::where('client_code',$data['client_id'])->where('report_notify',1)->get();
				 
				 foreach($client_contacts as $client_contact){
					 $message->cc($client_contact->email_address,$client_contact->contact_person);
				 }*/
                 
				 $booking_team = UserInfo::select('name','email_address')->where('user_id',$data['created_by'])->first();
                 if(!empty($data['cc_mail'])){
					 foreach($data['cc_mail'] as $c_mail){
						 $message->cc($c_mail);
					 }
				 }
				 $message->cc($booking_team->email_address,$booking_team->name);
				 
				 
				 /*foreach($data['recipient_mail'] as $mail){
					 $message->to($mail);
				 } 
				 */
				 //$message->replyTo($data['reviewer_email'], $data['reviewer_name']);
				 $message->bcc('booking@t-i-c.asia','Booking');
				 $message->bcc('report@t-i-c.asia','Report');
				 $message->bcc('it-support@t-i-c.asia','IT Support');
				 $message->bcc('gregor@t-i-c.asia','Gregor Voege');

				 //$message->to($data['recipient_mail']);
				 //$message->cc($data['cc_email']);          
				 $message->subject('Inspection Report - (' . $data['reference_no'] . ')');
				 //$report_file=$this->reports_path . '/' . $data['save_name'];
				 /*if($data['report_file']){
					 foreach ($data['report_file'] as $file_name) {
						 $message->attach($file_name);
					 }     
				 }*/
				 //if($data['report_size'] <= 36700160){
				 //	$message->attach($data['report_file']);
				 //}
			 });
			 
			 if (count(Mail::failures()) > 0) {
				 DB::rollback();
				 return response()->json(['message' => 'Email Error',],500);
			 } else {
				 DB::commit();
				 return response()->json(['message' => 'Report Saved',],200);
			 }
		 }catch(\Throwable $e){
			 DB::rollback();
			 return response()->json(['message' => $e->getMessage(),],500);
		 }
    }
	
	/*public function store_nomail(Request $request) {
        $req = $request['request'];
        $id = $request['id'];
		$inspection_id = $request['inspection_id'];
		$company_email = $request['company_email'];
		 
        $inspections = Inspection::where('id',$inspection_id)->first();
		 
		$upload_file_name=array();
		foreach ($request->file('file') as $file) {
			$save_name = $file->getClientOriginalName();
			
			//Change Name of the file if there's a # sign
			$save_name = str_replace('#','No.',$save_name);
			$file->move($this->reports_path . '/' . $inspection_id . '/', $save_name);
			
			$report_upload = new ReportUpload();
			$report_upload->inspection_id = $inspection_id;
			$report_upload->user_id = Auth::id();
			$report_upload->client_code = $inspections->client_id;
			$report_upload->reference_no = $inspections->reference_number;
			$report_upload->client_email = $company_email;
			//$report_upload->client_cc_email = $recipient_email;
			//$report_upload->client_bcc_email = $cc_email;
			$report_upload->report_file = $save_name;
			$report_upload->report_file_size = $file->getSize();
			array_push($upload_file_name,$this->reports_path . '/' . $inspection_id . '/'. $save_name);  
			$report_upload->save();
		}
		return response()->json([
			'message' => 'Report Saved',
		],200);

    }*/
    
    //Emil 02-08-2020
    public function uploadReports(Request $request) {
        DB::beginTransaction();
        try {
            header('Content-Type: text/html; charset=utf-8');
        
            $inspection_id = $request['inspection_id'];
            $company_email = $request['company_email'];
                
            $reports = $request['reports']; //Reports File
            $ref_numbers = $request['ref_numbers'];
            $report_status = $request['status'];
            
            
            $inspection_id = $request['inspection_id'];

            $recipient_email = $request['recipient_email'];
            $recipient_mail = explode(';', $recipient_email);
            if(empty($request['cc_email'])){
				 $cc_email = $cc_mail = "";
            } else {
                $cc_email = $request['cc_email'];
                $cc_mail = explode(';', $cc_email);
            }
            $inspections = Inspection::where('id',$inspection_id)->first();
            $client_id = $inspections->client_id;
            $factory_id = $inspections->factory;
            $factories = Factory::where('id',$factory_id)->first();
            $fact_name = $factories->factory_name;
            $clients = Client::where('client_code',$client_id)->first();
            $reviewer = UserInfo::where('user_id',Auth::id())->first();
            $reviewer_name = $reviewer->name;
            $reviewer_email = $reviewer->email_address;
            $client_name = $clients->client_name;
            $inspection_date = $inspections->inspection_date;
             
            $total_file_size = 0;
             
            $uploaded_files = array();
            $uploaded_file_names = array();
            $referrence_numbers = array();
            $report_statuses = array();
            //foreach($reports as $report) {
            for ($i = 0 ; $i < count($reports); $i++) {
                $save_name = $reports[$i]->getClientOriginalName();
                
                //Change Name of the file if there's a # sign
                $save_name = str_replace('#','No.',$save_name);
                $reports[$i]->move($this->reports_path . '/' . $inspection_id . '/', $save_name);
                
                $report_upload = new ReportUpload();
                $report_upload->inspection_id = $inspection_id;
                $report_upload->user_id = Auth::id();
                $report_upload->client_code = $inspections->client_id;
                $report_upload->reference_no = $ref_numbers[$i];
                $report_upload->client_email = $company_email;
                $report_upload->report_file = $save_name;
                $report_upload->report_status = $report_status[$i];
                $report_upload->report_file_size = $reports[$i]->getSize();
                
                $total_file_size = $total_file_size + $reports[$i]->getSize();
                array_push($uploaded_files,$this->reports_path . '/' . $inspection_id . '/'. $save_name);
                array_push($referrence_numbers, $ref_numbers[$i]);
                array_push($uploaded_file_names, $save_name);
                array_push($report_statuses,$report_status[$i]);
                $report_upload->save();
            }
            
            $inspections->inspection_status = "Report Released";
            //$inspections->report_status = $report_status;
            $inspections->update();
            
            
            $data = ['company_email' => $company_email,
					  'recipient_mail' => $recipient_mail,
					  'cc_mail' => $cc_mail,				 
					  'reference_no' => $inspections->reference_number,
					  'sub_reference_no' => $referrence_numbers,
					  'inspection_id' => $inspection_id,
					  'created_by' => $inspections->created_by,
					  'factory_name' => $fact_name,
					  'client_name' => $client_name,
					  'inspection_date' => date('F d, Y',strtotime($inspection_date)),
					  'reviewer_name' => $reviewer_name,
					  'reviewer_email' => $reviewer_email,
					  'uploaded_files' => $uploaded_files,
					  'uploaded_file_name' => $uploaded_file_names,
					  'total_file_size' => $total_file_size,
					  'client_id' => $client_id,
					  'report_status' => $report_statuses
					 ];
            
            Mail::send('email.send_report_dev',$data, function($message) use ($data){
				 
				 
                $message->to($data['company_email'],$data['client_name']);
				 
				 /*$client_contacts = ClientContact::where('client_code',$data['client_id'])->where('report_notify',1)->get();
				 
				 foreach($client_contacts as $client_contact){
					 $message->cc($client_contact->email_address,$client_contact->contact_person);
				 }*/
                 
				 $booking_team = UserInfo::select('name','email_address')->where('user_id',$data['created_by'])->first();
                 if(!empty($data['cc_mail'])){
					 foreach($data['cc_mail'] as $c_mail){
						 $message->cc($c_mail);
					 }
				 }
				 $message->cc($booking_team->email_address,$booking_team->name);
				 
				 
				 /*foreach($data['recipient_mail'] as $mail){
					 $message->to($mail);
				 } 
				 */
				 $message->replyTo($data['reviewer_email'], $data['reviewer_name']);
				 $message->bcc('booking@t-i-c.asia','Booking');
				 $message->bcc('report@t-i-c.asia','Report');
				 $message->bcc('it-support@t-i-c.asia','IT Support');
				 $message->bcc('gregor@t-i-c.asia','Gregor Voege');
       
				 $message->subject('Inspection Report - (' . $data['reference_no'] . ')');
				 if($data['uploaded_files'] && $data['total_file_size'] <= 36700160){
					 foreach ($data['uploaded_files'] as $file_name) {
						 $message->attach($file_name);
					 }     
				 }
			 });
			 
			 if (count(Mail::failures()) > 0) {
				 DB::rollback();
				 return response()->json(['message' => 'Email Error',],500);
			 } else {
				 DB::commit();
				 return response()->json(['message' => 'Report Saved',],200);
             }
            
        } catch(\Throwable $e) {
			 DB::rollback();
			 return response()->json(['message' => $e->getMessage(),],500);
        }

    }
    
    
    public function store_nomail(Request $request) {
        DB::beginTransaction();
        try {
            header('Content-Type: text/html; charset=utf-8');
        
            $inspection_id = $request['inspection_id'];
            $company_email = $request['company_email'];
                
            $reports = $request['reports']; //Reports File
            $ref_numbers = $request['ref_numbers'];
            $report_status = $request['status'];
            
            
            $inspection_id = $request['inspection_id'];

            $recipient_email = $request['recipient_email'];
            $recipient_mail = explode(';', $recipient_email);
            if(empty($request['cc_email'])){
				 $cc_email = $cc_mail = "";
            } else {
                $cc_email = $request['cc_email'];
                $cc_mail = explode(';', $cc_email);
            }
            $inspections = Inspection::where('id',$inspection_id)->first();
            $client_id = $inspections->client_id;
            $factory_id = $inspections->factory;
            $factories = Factory::where('id',$factory_id)->first();
            $fact_name = $factories->factory_name;
            
            $clients = Client::where('client_code',$client_id)->first();
            $reviewer = UserInfo::where('user_id',Auth::id())->first();
            $reviewer_name = $reviewer->name;
            $reviewer_email = $reviewer->email_address;
            $client_name = $request['client_name'];
            $inspection_date = $inspections->inspection_date;
             
            $total_file_size = 0;
             
            $uploaded_files = array();
            $uploaded_file_names = array();
            $referrence_numbers = array();
            $report_statuses = array();
            //foreach($reports as $report) {
            for ($i = 0 ; $i < count($reports); $i++) {
                $save_name = $reports[$i]->getClientOriginalName();
                
                //Change Name of the file if there's a # sign
                $save_name = str_replace('#','No.',$save_name);
                $reports[$i]->move($this->reports_path . '/' . $inspection_id . '/', $save_name);
                
                $report_upload = new ReportUpload();
                $report_upload->inspection_id = $inspection_id;
                $report_upload->user_id = Auth::id();
                $report_upload->client_code = $inspections->client_id;
                $report_upload->reference_no = $ref_numbers[$i];
                $report_upload->client_email = $company_email;
                $report_upload->report_file = $save_name;
                $report_upload->report_status = $report_status[$i];
                $report_upload->report_file_size = $reports[$i]->getSize();
                
                $total_file_size = $total_file_size + $reports[$i]->getSize();
                array_push($uploaded_files,$this->reports_path . '/' . $inspection_id . '/'. $save_name);
                array_push($referrence_numbers, $ref_numbers[$i]);
                array_push($uploaded_file_names, $save_name);
                array_push($report_statuses,$report_status[$i]);
                $report_upload->save();
            }
            
            $inspections->inspection_status = "Report Released";
            //$inspections->report_status = $report_status;
            $inspections->update();
            
            
            $data = ['company_email' => $company_email,
					  'recipient_mail' => $recipient_mail,
					  'cc_mail' => $cc_mail,				 
					  'reference_no' => $inspections->reference_number,
					  'sub_reference_no' => $referrence_numbers,
					  'inspection_id' => $inspection_id,
					  'created_by' => $inspections->created_by,
					  'factory_name' => $fact_name,
					  'client_name' => $client_name,
					  'inspection_date' => date('F d, Y',strtotime($inspection_date)),
					  'reviewer_name' => $reviewer_name,
					  'reviewer_email' => $reviewer_email,
					  'uploaded_files' => $uploaded_files,
					  'uploaded_file_name' => $uploaded_file_names,
					  'total_file_size' => $total_file_size,
					  'client_id' => $client_id,
					  'report_status' => $report_statuses
					 ];
            
            Mail::send('email.send_report_dev',$data, function($message) use ($data){
				 
				 
                $message->to($data['company_email'],$data['client_name']);
				 
				 /*$client_contacts = ClientContact::where('client_code',$data['client_id'])->where('report_notify',1)->get();
				 
				 foreach($client_contacts as $client_contact){
					 $message->cc($client_contact->email_address,$client_contact->contact_person);
				 }*/
                 
				 $booking_team = UserInfo::select('name','email_address')->where('user_id',$data['created_by'])->first();
                 if(!empty($data['cc_mail'])){
					 foreach($data['cc_mail'] as $c_mail){
						 $message->cc($c_mail);
					 }
				 }
				 $message->cc($booking_team->email_address,$booking_team->name);
				 
				 
				 /*foreach($data['recipient_mail'] as $mail){
					 $message->to($mail);
				 } 
				 */
				 $message->replyTo($data['reviewer_email'], $data['reviewer_name']);
				 $message->bcc('booking@t-i-c.asia','Booking');
				 $message->bcc('report@t-i-c.asia','Report');
				 $message->bcc('it-support@t-i-c.asia','IT Support');
				 $message->bcc('gregor@t-i-c.asia','Gregor Voege');
       
				 $message->subject('Inspection Report - (' . $data['reference_no'] . ')');
				 if($data['uploaded_files'] && $data['total_file_size'] <= 36700160){
					 foreach ($data['uploaded_files'] as $file_name) {
						 $message->attach($file_name);
					 }     
				 }
			 });
			 
			 if (count(Mail::failures()) > 0) {
				 DB::rollback();
				 return response()->json(['message' => 'Email Error',],500);
			 } else {
				 DB::commit();
				 return response()->json(['message' => 'Report Saved',],200);
             }
            
        } catch(\Throwable $e) {
			 DB::rollback();
			 return response()->json(['message' => $e->getMessage(),],500);
        }

    }
	
	public function download_report($reference_no) {
		$report_upload = ReportUpload::where('reference_no',$reference_no)->first();
		
		$inspection_id = $report_upload->inspection_id;
		$ref_no = $report_upload->reference_no;
		$filename = $report_upload->report_file;
		$file_ext = \File::extension($filename);
		
		$file_path = public_path('reviewer-reports/' . $inspection_id . '/' .$filename);
		
    	return response()->download($file_path);
	}
	
	public function download_report_file($inspection_id, $filename) {
		$report_upload = ReportUpload::where('inspection_id',$inspection_id)->where('report_file',$filename)->first();
		
		$inspection_id = $report_upload->inspection_id;
		$filename = $report_upload->report_file;
		$file_ext = \File::extension($filename);
		 
		$file_path = $this->reports_path . '/' . $inspection_id . '/' .$filename;
		if(file_exists($file_path)){
			return response()->download($file_path);
		} else {
			return response()->json([
				'message' => 'Download Error',
			],500);
		}
	}
	
	public function download_report_zip($inspection_id) {
		$inspections = Inspection::where('id',$inspection_id)->first();
		
		$dirname = 'images/zip_report/';

        $zip = new ZipArchive;

        $zip_path= $dirname . '/' . $inspections->client_project_number . ".zip";
        $zip_url = URL::asset($zip_path);

        if (file_exists($zip_path))
			@unlink($zip_path);

        $zip->open($zip_path, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

        if (file_exists($this->reports_path . '/' . $inspection_id)){
            $files = File::allFiles($this->reports_path . '/' . $inspection_id);
            foreach ($files as $file){
				//$zip->addFile($file->getPathname());
				$file_info = pathinfo($file);
				//$relativePath = 'invoices/' . substr($filePath, strlen($path) + 1);
				$zip->addFile($file->getPathname(), $file_info['basename']);
            }
		}
		$zip->close();

        return redirect($zip_url);
	}
	
	//View Uploaded Reports
	public function view_uploaded_report(Request $request) {
		if(!empty($request)){
			$id = $request['id'];
			$report_uploads = DB::table('report_uploads')
				->join('user_infos', 'report_uploads.user_id', '=', 'user_infos.user_id')
				->select('report_uploads.*', 'user_infos.name')
				->where('report_uploads.inspection_id',$id)
				//->where('report_uploads.user_id',Auth::id())
				->latest()
				->get();
			return response()->json($report_uploads);
		} else {
			return 'asa';
		}
	}
	
	public function ajaxDatatable(){
		$inspections = Inspection::where('inspection_status','Released')->get();
        return response()->json([
            'inspections' => $inspections
        ]);
    }
	
	//UPDATE Reject or Accept Reviewer's Reports
    public function approve_rejectReport(Request $request){
		if(!empty($request)){
			header('Content-Type: text/html; charset=utf-8');
        	$inspection = Inspection::where('id', $request['inspection_id'])->first();
			
			
        	$client = Client::where('client_code', $inspection->client_id)->first();
			
			
			
			$factories = Factory::where('id',$inspection->factory)->first();
			
			$factory_name = $factories->factory_name;
			$factory_address = $factories->factory_address;
			
			//Factory Contact
			$factory_contact = FctoryContact::where('id', $inspection->factory_contact_person)->first();
			$factory_contact_person = $factory_contact->factory_contact_person;
			$factory_contact_number = $factory_contact->factory_contact_number;
			$factory_contact_email = $factory_contact->factory_email;
			
			$inspection_status = $request['status'];
			$report_comments = $request['comments'];
			if($inspection_status == 0){
				$inspection_status = "Shipment Rejected";
				$status_mail = "hold the shipment";
			} else if($inspection_status == 1){
				$inspection_status = "Shipment Accepted";
				$status_mail = "ship the shipment";
			}
			
			//Update Inspection Status
			$inspection->inspection_status = $inspection_status;
			$inspection->report_comments = $report_comments;
			
			if($inspection->update()){
				$data = ['factory_email' => $factory_contact_email,
						 'factory_person' => $factory_contact_person,
						 'factory_contact_number' => $factory_contact_number,
						 'factory_name' => $factory_name, 
						 'factory_address' => $factory_address,
						 'factory_contact' => $factory_contact,
						 'inspection_status' => $inspection_status,
						 'status_mail' => $status_mail,
						 'client_name' => $client->client_name,
						 'client_email' => $client->Company_Email,
						 'inspection_date' => $inspection->inspection_date . ' - ' . $inspection->inspection_date_to,
						 'report_comments' => $report_comments,
						 'reference_no' => $inspection->reference_number
				];
				Mail::send('email.Report_factory_status',$data, function($message) use ($data){
					$message->subject('Inspection Report - (' . $data['reference_no'] . ')');
					$message->to($data['factory_email'], ucwords($data['factory_person']));
					
					$message->cc($data['client_email'],$data['client_name']);
					$message->replyTo($data['client_email'],$data['client_name']);
					$message->bcc('gregor@t-i-c.asia','Gregor Voege');
					$message->bcc('it-support@t-i-c.asia','IT Support');

				});
				if (count(Mail::failures()) > 0) {
					return response()->json([
						'message' => 'Email Error',
					],500);
				}else{
					return response()->json([
						'message' => 'Report Saved',
					],200);
				}
			} else {
				return response()->json([
					'message' => 'Save Error',
				],500);
			}
			
		
		//End if empty request
		}
    }
	
	//UPDATE Assign Reviewer
    public function assign_reviewer(Request $request){
		if(!empty($request)){
			
			$inspection_id = $request['ins_id'];
			$reviewer_name = $request['reviewer_name'];
        	$inspection = Inspection::where('id', $inspection_id)->first();
			
			//Update Inspection Status
			$inspection->reviewed_by = $reviewer_name;
			
			if($inspection->update()){
				return response()->json([
					'message' => 'Report Assigned',
				],200);
			} else {
				return response()->json([
					'message' => 'Save Error',
				],500);
			}
		//End if empty request
		}
    }
	
	public function changeProfilePic(Request $request){
       if(!empty($request->file('file'))){
			 $profile = $request->file('file');
			 $profile_size = $profile->getSize();
		 }
		$save_name = $profile->getClientOriginalName();
		$user_info = UserInfo::where('user_id',Auth::id())->first();
		$user_info->photo = $save_name;
		$profile->move(public_path('profile-pics/') . Auth::id() . '/', $save_name);
		if($user_info->update()){
		 	return response()->json([
				'message' => 'updated',
			],200);
		}
	}

	
	public function view_profile($id, $filename) {
		$user_info = UserInfo::where('user_id',Auth::id())->where('photo',$filename)->first();
		$filename = $user_info->photo;
		return response()->file(public_path('profile-pics/' . Auth::id() . '/' . $filename));
	}
}
