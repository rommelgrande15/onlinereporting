<?php
   
namespace App\Http\Controllers;
   
use App\Event;
use App\Inspection;
use App\User;
use App\UserInfo;
use App\SubAccountPrivelege;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
   
class InspectionCalendarController extends Controller
{
 
    public function index()
    {
        if(request()->ajax()) 
        {
 
         $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
         $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
 
         $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
         return Response::json($data);
        }
        return view('fullcalendar.fullcalendar');
    }

    public function calendarInspection()
    {
        if(request()->ajax()) 
        {
 
         $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
         $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
 
         $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end']);
         return Response::json($data);
        }

        if(!Auth::id()){
			return redirect()->route('login');
		}
         //Sub Account
         $sub_acc="no";
         	$privelege="";
        $g = User::select('group_id')->where('id',Auth::id())->first();
        if(empty($g->group_id)){
            $client_id = Auth::id();
            $privelege="";
        } else {
            $client_id = $g->group_id;
            $sub_acc="yes";
		    $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
        }
        
		$role = User::where('id',Auth::id())->first();
		$user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',$client_id)->first();		

        $ccode = DB::table('clients')->where('user_id',Auth::id())->first();
       $new_post_client = Inspection::where('inspection_type',null)
                                    ->where('inspection_status','Client Pending')
                                    ->where('supplier_book','true')
                                    ->where('client_id',$ccode->client_code)
                                    ->count();
		//return view('pages.client.reportsPage.index',compact('inspections','user_info','user'));   

        return view('pages.client.reportsPage.calendar',compact('user_info','user','sub_acc','privelege','new_post_client'));   
    }
    
   
    public function create(Request $request)
    {  
        $insertArr = [ 'title' => $request->title,
                       'start' => $request->start,
                       'end' => $request->end
                    ];
        $event = Event::insert($insertArr);   
        return Response::json($event);
    }
     
 
    public function update(Request $request)
    {   
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Event::where($where)->update($updateArr);
 
        return Response::json($event);
    } 
 
 
    public function destroy(Request $request)
    {
        $event = Event::where('id',$request->id)->delete();
   
        return Response::json($event);
    }    

    public function loadData(){
        $result_data=array();
        //$inspection_data=Inspection::select('id','service','inspection_date','inspection_date_to')->get();
        $inspection_data = DB::table('inspections')
    		->join('factories', 'factories.id', '=', 'inspections.factory')
    		->select('inspections.id','inspections.service','inspections.inspection_date','inspections.inspection_date_to','inspections.inspection_date_to','factories.factory_name')
    		->get();
        foreach($inspection_data as $data){
            $ins_date_to="";
            if(empty($data->inspection_date_to) || $data->inspection_date_to==''){
                $ins_date_to=$data->inspection_date;
            }
            $service=strtoupper($data->service);
            $title=$service." (".$data->factory_name.")";
            $result_data[]=array( 'id'=> $data->id,
            'title'   =>  $title,
            'start'   =>  $data->inspection_date,
            'end'   =>  $ins_date_to);
        }

        return Response::json($result_data);
    }

    public function loadClienInspectionData(){
         //Sub Account
        $g = User::select('group_id')->where('id',Auth::id())->first();
        if(empty($g->group_id)){
            $client_id = Auth::id();
        } else {
            $client_id = $g->group_id;
        }
        $auth_id = $client_id;
        $user_code="";
        $user = User::select('client_code')->where('id',$auth_id)->first();
        
        if(!empty($user)){
            $user_code=$user->client_code;
        }
        $result_data=array();
        $inspection_data = DB::table('inspections')
    		->join('factories', 'factories.id', '=', 'inspections.factory')
            ->select('inspections.id','inspections.service','inspections.inspection_date','inspections.inspection_date_to','inspections.inspection_date_to','inspections.client_project_number','factories.factory_name')
            ->where('inspections.client_id',$user_code)
    		->get();
        foreach($inspection_data as $data){
            $ins_date_to=$data->inspection_date_to;
            if(empty($data->inspection_date_to) || $data->inspection_date_to==''){
                $ins_date_to=$data->inspection_date;
            }
            $service=strtoupper($data->service);
            $title=$service." (".$data->factory_name.")";
            $result_data[]=array('id'=> $data->id,
            'title'   =>  $title,
            'start'   =>  $data->inspection_date,
            'end'   =>  $ins_date_to,
            'service'   =>  $data->service,
            'ins_date'   =>  $data->inspection_date,
            'report_no'   =>  $data->client_project_number);
        }
        
        return Response::json($result_data);
    }


    public function calendarBookingInspection()
    {
		$role = User::where('id',Auth::id())->first();
		$user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();		
        $new_client_count = DB::table('clients')
            ->join('users','users.client_code','=','clients.client_code')
            ->select('clients.*','users.status')
			->where('clients.client_code',['000'])
			->where('users.status','2')
			->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();
        return view('pages.admin.inspec-calendar.calendar',compact('user_info','user','role','new_client_count','new_post_client','new_post_client_sera'));   
    }
    public function loadInspectionData(){
        $result_data=array();
        $inspection_data = DB::table('inspections')
            ->join('factories', 'factories.id', '=', 'inspections.factory')
            ->join('clients', 'clients.client_code', '=', 'inspections.client_id')
            ->join('user_infos', 'user_infos.user_id', '=', 'inspections.created_by')
            ->select('inspections.id','inspections.service','inspections.inspection_date','inspections.inspection_date_to','inspections.client_project_number','factories.factory_name','clients.client_name','user_infos.name')
    		->get();
        foreach($inspection_data as $data){
            $ins_date_to=$data->inspection_date_to;
            if(empty($data->inspection_date_to) || $data->inspection_date_to==''){
                $ins_date_to=$data->inspection_date;
            }
            $service=strtoupper($data->service);
            $title=$service." (".$data->factory_name.")";
            $result_data[]=array('id'=> $data->id,
            'title'   =>  $title,
            'start'   =>  $data->inspection_date,
            'end'   =>  $ins_date_to,
            'service'   =>  $data->service,
            'report_no'   =>  $data->client_project_number,
            'client'   =>  $data->client_name,
            'book_mngr'   =>  $data->name,
            'ins_date'   =>  $data->inspection_date);
        }
        
        return Response::json($result_data);
    }

    // added by migz 04-08-2021
    public function calendarSupplierInspection()
    {
        $supplierInfo = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
		$role = User::where('id',Auth::id())->first();
        //return $role;
		$user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();		
        $new_client_count = DB::table('clients')
            ->join('users','users.client_code','=','clients.client_code')
            ->select('clients.*','users.status')
			->where('clients.client_code',['000'])
			->where('users.status','2')
			->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();
        return view('pages.supplier.inspec-calendar.calendar',compact('user_info','user','role','new_client_count','new_post_client','new_post_client_sera','supplierInfo','supplierData'));   
    }
    // added by migz 04-08-2021
    public function loadSupplierInspectionData(){
        $supplierInfo = DB::table('supplier_datas')
                        ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                        ->select('*','suppliers.id as supplierId')
                        ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $result_data=array();
        $inspection_data = DB::table('inspections')
            ->join('factories', 'factories.id', '=', 'inspections.factory')
            ->join('clients', 'clients.client_code', '=', 'inspections.client_id')
            ->join('user_infos', 'user_infos.user_id', '=', 'inspections.created_by')
            ->where('inspections.client_book_id',Auth::id())
            ->select('inspections.id','inspections.service','inspections.inspection_date','inspections.inspection_date_to','inspections.client_project_number','factories.factory_name','clients.client_name','user_infos.name')
    		->get();
        foreach($inspection_data as $data){
            $ins_date_to=$data->inspection_date_to;
            if(empty($data->inspection_date_to) || $data->inspection_date_to==''){
                $ins_date_to=$data->inspection_date;
            }
            $service=strtoupper($data->service);
            $title=$service." (".$data->factory_name.")";
            $result_data[]=array('id'=> $data->id,
            'title'   =>  $title,
            'start'   =>  $data->inspection_date,
            'end'   =>  $ins_date_to,
            'service'   =>  $data->service,
            'report_no'   =>  $data->client_project_number,
            'client'   =>  $data->client_name,
            'book_mngr'   =>  $data->name,
            'ins_date'   =>  $data->inspection_date);
        }
        
        return Response::json($result_data);
    }
 
 
}