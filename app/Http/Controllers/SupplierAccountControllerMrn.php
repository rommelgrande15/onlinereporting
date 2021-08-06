<?php

namespace App\Http\Controllers;
use App\User;
use App\UserInfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DB;
use App\FactoryData;
use App\FactoryContact;
use App\FctoryContact;
use App\Country;
use App\Factory;
use App\Client;
use App\ClientCost;
use App\Supplier;
use App\SupplierContact;
use App\SubAccountPrivelege;
use App\Inspection;
use App\Product;
use App\SavedProductCategories;
use App\Category;
use App\SubCategory;
use App\ClientContact;
use App\ClientAqlDetail;
use App\ClientAqlMinor;
use App\ClientAqlMajor;
use App\InspectorCost;
use App\PSIProduct;
use App\Report;
use App\Attachment;
use Mail;
use App\LogActivity;
use Carbon\Carbon;
use App\SupplierData;
use App\productphotos;
use App\SavedProductSubCategories;


use function GuzzleHttp\json_encode;

use Illuminate\Http\Request;

class SupplierAccountControllerMrn extends Controller
{
    public function getDashboardPanelSupplier(Request $request){
        $g = User::select('group_id')->where('id',Auth::id())->first();
        $supplierInfo = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        if(empty($g->group_id)){
            $client_id = Auth::id();
        } else {
            $client_id = $g->group_id;
        }
        $user = User::where('id',$client_id)->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        return view('pages.supplier.dashboard.index-dev',compact('user_info','user','supplierInfo','supplierData'));   
    }

    //Added By Rommel --- April 08,2021 ----//
    public function getSupplierStatDashboard(Request $request){
        if(!Auth::id()){
			return redirect()->route('login');
		}
        //$date = date('m');
        //$date = "12";
        $now = Carbon::now();
        //->whereBetween('inspection_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
        $date = $now->month;
        $start_date = $request['start_date'];
        $end_date = $request['end_date'];
        $supplier_id = $request['supplier_name_sup'];
        
            
        //$date = 04;
        
         $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'cli' => 'Container Loading Inspection',
                    'pls' => 'Setting Up Production Lines',
                    'cbpi' => 'CBPI - No Serial',
                    'cbpi_serial' => 'CBPI - with Serial',
                    'cbpi_isce' => 'CBPI - ISCE',
                    'site_visit' => 'Site Visit',
                    'SPK' => 'SPK',
                    'FRI' => 'FRI',
                    'physical' => 'Factory Audit',
				'detail' => 'Detail Audit',
                'social' => 'Social Audit',
                'st' => 'Sample Test'
                    
                ];
        
        $services_client = [
            'iqi'=> 'Incoming Quality Inspection',
            'dupro'=> 'During Production Inspection',
            'psi'=> 'Pre Shipment Inspection',
            'cbpi' => 'CBPI - No Serial',
            'cli'=> 'Container Loading Inspection',
            'physical' => 'Factory Audit',
			'detail' => 'Detail Audit',
            'social' => 'Social Audit',
            'st' => 'Sample Test'
        ];
        
        
        $user_info = UserInfo::where('user_id',Auth::id())->first();

        if($user_info->designation == 'supplier'){
            $supplierInfo = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',Auth::id())->first();
            $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
            $group = User::select('group_id')->where('id',Auth::id())->first();
            $role="";
            $cancelled="";
            $sub_acc="no";
         	$privelege="";
            if(!empty($group->group_id)){
                //return 'dev';
                $role = Supplier::where('id',$supplierData->id)->first(); 
                $sub_acc="yes";
		        $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
            } else {            
                $role = Supplier::where('id',$supplierData->id())->first();
                $sub_acc="no";
            }

            //$role = User::where('id',$group->group_id)->first();
            
            //return $role->client_code;
            $clients = Client::where('client_code','!=','000')->orderBy('id','desc')->get();
            $new_client_count = DB::table('clients')->join('users','users.id','=','clients.user_id')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
            $new_post_client = Inspection::where('inspection_status','Client Pending')->count();
            
            $factories = Factory::where('client_code',$role->client_code)->select('id','factory_name')->orderBy('factory_name','desc')->get();
            $supplierInfo = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',Auth::id())->first();
            $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
            //$suppliers = Supplier::where('client_code',$role->client_code)->select('id','supplier_name','supplier_number')->groupBy('supplier_number')->orderBy('supplier_number','desc')->get();
            $suppliers = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
            //$supplier_id = $supplierData->id;

            if($start_date || $supplier_id){
                if($supplier_id && empty($start_date)){
                    $inspection_count = Inspection::where('supplier_id',$supplierData->id)
                    ->where('inspection_status','!=','Deleted')
                    ->get()
                    ->count();
					
					$inspection_uploaded = DB::table('report_uploads')
					->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('inspections.supplier_id',$supplier_id)
						->where('inspections.inspection_status','!=','Deleted')
					//->whereBetween('inspections.inspection_date', [$start_date, $end_date])
					->distinct('report_uploads.reference_no')
					->count('report_uploads.reference_no');
                    
                    $inspection_accepted = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Shipment Accepted')
                        ->get()
                        ->count();
                    
                    $inspection_rejected = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Shipment Rejected')
                        ->get()
                        ->count();
                    
                    $inspection_released = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Released')
                        ->get()
                        ->count();
                    
                    $inspection_report_released = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Report Released')
                        ->get()
                        ->count();
                    
                    $inspection_hold = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Hold')
                        ->get()
                        ->count();
                    
                    $inspection_cancelled = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Cancelled')
                        ->get()
                        ->count();
                    
                    $inspection_pending = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Pending')
                        ->get()
                        ->count();
					
					
                    $inspection_pending = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('report_uploads.report_status','Pending')
						->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
						//->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						->where('inspections.supplier_id',$supplierData->id)
						->count();
				
					$inspection_client_pass = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('report_uploads.report_status','Passed')
						->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
						//->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						->where('inspections.supplier_id',$supplierData->id)
						->count();
				
					$inspection_client_failed = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('report_uploads.report_status','Failed')
						->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
						//->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						->where('inspections.supplier_id',$supplierData->id)
						->count();
                    
                } else if($start_date && empty($supplier_id)){
                    $inspection_count = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','!=','Deleted')
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->get()
                        ->count();
					
					$inspection_uploaded = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						//->where('inspections.supplier_id',$supplier_id)
						->where('inspections.inspection_status','!=','Deleted')
						->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						->distinct('report_uploads.reference_no')
						->count('report_uploads.reference_no');
					
                    $inspection_accepted = Inspection::where('supplier_id',$supplierData->id)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Shipment Accepted')
                        ->get()
                        ->count();
                    
                    $inspection_rejected = Inspection::where('supplier_id',$supplierData->id)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Shipment Rejected')
                        ->get()
                        ->count();
                    
                    $inspection_released = Inspection::where('supplier_id',$supplierData->id)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Released')
                        ->get()
                        ->count();
                    
                    $inspection_report_released = Inspection::where('supplier_id',$supplierData->id)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Report Released')
                        ->get()
                        ->count();
                    
                    
                    $inspection_hold = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Hold')
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->get()
                        ->count();
                    
                    $inspection_cancelled = Inspection::where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Cancelled')
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->get()
                        ->count();
                    
                    $inspection_pending = Inspection::where('supplier_id',$supplierData->id)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Pending')
                        ->get()->count();
					
					$inspection_pending = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('report_uploads.report_status','Pending')
						->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
						->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						//->where('inspections.supplier_id',$supplier_id)
						->count();
				
					$inspection_client_pass = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('report_uploads.report_status','Passed')
						->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
						->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						//->where('inspections.supplier_id',$supplier_id)
						->count();
				
					$inspection_client_failed = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('report_uploads.report_status','Failed')
						->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
						->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						//->where('inspections.supplier_id',$supplier_id)
						->count();
					//End
                    
					
                } else if($start_date && $supplier_id){
                    $inspection_count = Inspection::whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('supplier_id',$supplierData->id)
                        ->where('inspection_status','!=','Deleted')
                        ->get()
                        ->count();
					
					$inspection_uploaded = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						->where('report_uploads.client_code', $role->client_code)
						->where('inspections.supplier_id',$supplierData->id)
						->where('inspections.inspection_status','!=','Deleted')
						->distinct('report_uploads.reference_no')
						->count('report_uploads.reference_no');
                    
                    $inspection_accepted = Inspection::where('supplier_id',$supplierData->id)
                        ->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Shipment Accepted')
                        ->get()
                        ->count();
                    
                    $inspection_rejected = Inspection::whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('supplier_id',$supplierData->id)
                        ->where('inspection_status','Shipment Rejected')
                        ->get()
                        ->count();
                    
                    $inspection_released = Inspection::whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('supplier_id',$supplierData->id)
                        ->where(function($query){
                        $query->where('inspection_status', 'Released')
                            ->orWhere('inspection_status', 'Report Released');
                        })
                        ->get()
                        ->count();
                    
                    $inspection_cancelled = Inspection::where('supplier_id',$supplierData->id)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where(function($query){
                        $query->where('inspection_status', 'Hold')
                            ->orWhere('inspection_status', 'Cancelled');
                        })
                        ->get()
                        ->count();
					
					
					$inspection_pending = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('report_uploads.report_status','Pending')
						->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
						->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						->where('inspections.supplier_id',$supplierData->id)
						->count();
				
					$inspection_client_pass = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('report_uploads.report_status','Passed')
						->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
						->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						->where('inspections.supplier_id',$supplierData->id)
						->count();
				
					$inspection_client_failed = DB::table('report_uploads')
						->join('inspections','report_uploads.inspection_id','=','inspections.id')
						->where('report_uploads.client_code', $role->client_code)
						->where('report_uploads.report_status','Failed')
						->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
						->whereBetween('inspections.inspection_date', [$start_date, $end_date])
						->where('inspections.supplier_id',$supplierData->id)
						->count();

                }
                
                $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('clients.client_code',$role->client_code)
                    ->where('inspections.inspection_status','!=','Deleted')
                    ->whereBetween('inspections.inspection_date', [$start_date, $end_date])
                    ->orderBy('inspections.created_at', 'desc')
                    ->get();
            
                $inspections_chart = DB::table('inspections')
                    ->select(DB::raw('count(id) as `count`'),DB::raw('month(created_at) as month'))
                    ->where('supplier_id',$supplierData->id)
                    //->whereMonth('created_at', $date)
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->get();

                $test = response()->json($inspections_chart);
                
                $released = $inspection_released;
                $cancelled = $inspection_cancelled;
                $pending = $inspection_pending;
                
                return response()->json([
                    'inspection_count' => $inspection_count,
                    'inspection_uploaded' => $inspection_uploaded,
                    'inspection_accepted' => $inspection_accepted,
                    'inspection_rejected' => $inspection_rejected,
                    'released' => $released,
                    'cancelled' => $cancelled,
                    'pending' => $pending,
                    'pass' => $inspection_client_pass,
                    'failed' => $inspection_client_failed,
                ]);
                
            } else {
                $start_date = Carbon::now()->startOfMonth();
                $end_date = Carbon::now()->endOfMonth();
                //->whereBetween('inspection_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])
                $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('clients.client_code',$role->client_code)
                    ->where('inspections.inspection_status','!=','Deleted')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->limit(10)
                    ->get();
            
                $inspections_chart = DB::table('inspections')
                    ->select(DB::raw('count(id) as `count`'),DB::raw('month(created_at) as month'))
                    ->where('supplier_id',$supplierData->id)
                    //->whereMonth('created_at', $date)
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->get();
           
        
                $inspection_count = Inspection::where('supplier_id',$supplierData->id)
                    ->whereBetween('inspection_date', [$start_date, $end_date])
                    ->where('inspection_status','!=','Deleted')
                    ->get()
                    ->count();
				
				$inspection_uploaded = DB::table('report_uploads')
					->join('inspections','report_uploads.inspection_id','=','inspections.id')
					->where('report_uploads.client_code', $role->client_code)
					->whereBetween('inspections.inspection_date', [$start_date, $end_date])
					->distinct('report_uploads.reference_no')
					->count('report_uploads.reference_no');
				
                $inspection_accepted = Inspection::where('supplier_id',$supplierData->id)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Shipment Accepted')->get()->count();
                $inspection_rejected = Inspection::where('supplier_id',$supplierData->id)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Shipment Rejected')->get()->count();
                
                $inspection_released = Inspection::where('supplier_id',$supplierData->id)
                    ->whereBetween('inspection_date', [$start_date, $end_date])
                    ->where(function($query){
                        $query->where('inspection_status', 'Released')
                            ->orWhere('inspection_status', 'Report Released');
                    })
                    ->get()
                    ->count();
                
                $inspection_hold = Inspection::where('supplier_id',$supplierData->id)
                    ->whereBetween('inspection_date', [$start_date, $end_date])
                    ->where(function($query){
                        $query->where('inspection_status', 'Hold')
                            ->orWhere('inspection_status', 'Cancelled');
                    })
                    ->get()
                    ->count();

    
				
				$inspection_pending = DB::table('report_uploads')
					->join('inspections','report_uploads.inspection_id','=','inspections.id')
					->where('report_uploads.client_code', $role->client_code)
					->whereBetween('inspections.inspection_date', [$start_date, $end_date])
					->where('report_uploads.report_status','Pending')
					->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
					->count();
				
				
			
				
				$inspection_client_pass = DB::table('report_uploads')
					->join('inspections','report_uploads.inspection_id','=','inspections.id')
					->where('report_uploads.client_code', $role->client_code)
					->whereBetween('inspections.inspection_date', [$start_date, $end_date])
					->where('report_uploads.report_status','Passed')
					->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
					->count();
				
				$inspection_client_failed = DB::table('report_uploads')
					->join('inspections','report_uploads.inspection_id','=','inspections.id')
					->where('report_uploads.client_code', $role->client_code)
					->whereBetween('inspections.inspection_date', [$start_date, $end_date])
					->where('report_uploads.report_status','Failed')
					->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
					->count();
				
				/*$inspection_client_failed = DB::table('report_uploads')
					//->select('report_uploads.reference_no')
					->join('inspections','report_uploads.inspection_id','=','inspections.id')
					->where('report_uploads.client_code', $role->client_code)
					->whereBetween('inspections.inspection_date', [$start_date, $end_date])
					->where('report_uploads.report_status','Failed')
					//->distinct('report_uploads.reference_no')
					->groupBy('report_uploads.reference_no')
					//->sortBy('report_uploads.created_at','ASC')
					->count();*/
				
				
               /* $inspection_client_pass = Inspection::where('client_id',$role->client_code)
					->whereBetween('inspection_date', [$start_date, $end_date])
					->where('report_status','Pass')
					->get()
					->count();
				
                $inspection_client_failed = Inspection::where('client_id',$role->client_code)
					->whereBetween('inspection_date', [$start_date, $end_date])
					->where('report_status','Failed')
					->get()
					->count();*/
				
                
                $psiproduct = PSIProduct::all();
                $test = response()->json($inspections_chart);
                
                $released = $inspection_released;
                $cancelled = $inspection_hold;
                $pending = $inspection_pending;
                
            }
        
            return view('pages.supplier.supplierStatsDashboard.index',compact('clients','role','user_info','new_client_count','new_post_client','inspection_count','inspection_uploaded','inspection_accepted','inspection_rejected','inspection_released','inspection_hold','inspection_pending','released','cancelled','pending','inspection_client_pass','inspection_client_failed','inspections','psiproduct','services','services_client','inspections_chart','test','sub_acc','privelege','factories','suppliers','supplierData','supplierInfo'));
            
        } else {
            return redirect()->route('login');
        }
    }

    //migz supplier My orders dashboard
    public function getDashboardPanelSupplierOrders(Request $request){
        $supplier_book = $request->supplier_book;
        
        if($supplier_book = true ){
            $columns = array(
                0 =>'client_project_number', 
                1 =>'service',
                2 =>'factory_name',
                3 => 'product_name',
                4 => 'model_no',
                5 => 'manday',
                6 => 'po_no',
                7 => 'inspection_status',
                8 => 'created_at',
                9 => 'view_edit',
                10 => 'edit_cancel',
           ); 
        } else{
            $supplier_book = null;
            $columns = array(
                0 =>'client_project_number', 
                1 =>'service',
                2 => 'factory_name',
                3 => 'product_name',
                4 => 'model_no',
                5 => 'manday',
                6 => 'po_no',
                7 => 'inspection_status',
                8 => 'created_at',
                9 => 'view_edit'
           ); 
        }
        
        $g = User::select('id')->where('id',Auth::id())->first();
       // return Auth::id();
        if(empty($g->id)){
            $client_id = Auth::id();
            $sub_acc="no";
        } else {
            $client_id = $g->id;
            $sub_acc="yes";
            $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
        }
      

        $edit_order="";
        $copy_order="";
        $cancel_order="";
        $delete_order="";

        if($sub_acc=='yes' && !empty($privelege)){
            $edit_order = $privelege->edit_order;
            $copy_order = $privelege->copy_order;
            $cancel_order = $privelege->cancel_order;
            $delete_order = $privelege->delete_order;
        }

        $user = User::select('user_type')->find($client_id);

        $totalData = DB::table('inspections')
            ->where('client_book_id',Auth::id())  // = 252 Gregor Voege
            ->where('supplier_book',"true") 
            ->where('inspection_status', '!=', "Deleted")
            ->count();

        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        
        if(empty($request->input('search.value')))
        {            
        
        $inspections = DB::table('inspections')
            ->join('factories', 'factories.id', '=', 'inspections.factory')
            ->leftJoin('p_s_i_products', 'p_s_i_products.inspection_id', '=', 'inspections.id')
            ->leftJoin('reports', 'reports.inspection_id', '=', 'inspections.id')
            ->select(DB::raw('group_concat(p_s_i_products.product_name) as pname, group_concat(p_s_i_products.model_no) as pmodel,group_concat(p_s_i_products.po_no) as pno'),
                            'inspections.*','reports.report_no', 'factories.factory_name','inspections.manday','inspections.inspection_status', 'inspections.created_at', 
                            'inspections.service' )
            ->where('client_book_id',Auth::id())
            ->where('supplier_book', "true")
            ->where('inspection_status', '!=', "Deleted")
            ->groupBy(DB::raw('inspections.id'))
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $inspections =  DB::table('inspections')
                ->join('factories', 'factories.id', '=', 'inspections.factory')
                ->leftJoin('p_s_i_products', 'p_s_i_products.inspection_id', '=', 'inspections.id')
                ->leftJoin('reports', 'reports.inspection_id', '=', 'inspections.id')
                ->select(DB::raw('group_concat(p_s_i_products.product_name) as pname, group_concat(p_s_i_products.model_no) as pmodel,group_concat(p_s_i_products.po_no) as pno'),
                            'inspections.*','reports.report_no', 'factories.factory_name','inspections.manday','inspections.inspection_status', 'inspections.created_at', 
                            'inspections.service' )
                ->where('client_book_id',Auth::id())
                ->where('supplier_book',"true")
                ->where('inspection_status', '!=', "Deleted")
                ->where(function($query) use ($search) {
                    $query->where('reports.report_no','LIKE',"%{$search}%")
                        ->orWhere('inspections.service', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.client_project_number', 'LIKE',"%{$search}%")
                        ->orWhere('factories.factory_name', 'LIKE',"%{$search}%")
                        ->orWhere('p_s_i_products.product_name', 'LIKE',"%{$search}%")
                        ->orWhere('p_s_i_products.model_no', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.manday', 'LIKE',"%{$search}%")
                        ->orWhere('p_s_i_products.po_no', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.inspection_status', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.created_at', 'LIKE',"%{$search}%");
                })
                ->groupBy(DB::raw('inspections.id'))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

                $inspection_temp = DB::table('inspections')
                ->join('factories', 'factories.id', '=', 'inspections.factory')
                ->leftJoin('p_s_i_products', 'p_s_i_products.inspection_id', '=', 'inspections.id')
                ->leftJoin('reports', 'reports.inspection_id', '=', 'inspections.id')
                ->select(DB::raw('group_concat(p_s_i_products.product_name) as pname, group_concat(p_s_i_products.model_no) as pmodel,group_concat(p_s_i_products.po_no) as pno'),
                            'inspections.*','reports.report_no', 'factories.factory_name','inspections.manday','inspections.inspection_status', 'inspections.created_at', 
                            'inspections.service' )
                ->where('client_book_id',Auth::id())
                ->where('supplier_book',"true")
                ->where('inspection_status', '!=', "Deleted")
                ->where(function($query) use ($search) {
                    $query
                    ->where('reports.report_no','LIKE',"%{$search}%")
                        ->orWhere('inspections.service', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.client_project_number', 'LIKE',"%{$search}%")
                        ->orWhere('factories.factory_name', 'LIKE',"%{$search}%")
                        ->orWhere('p_s_i_products.product_name', 'LIKE',"%{$search}%")
                        ->orWhere('p_s_i_products.model_no', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.manday', 'LIKE',"%{$search}%")
                        ->orWhere('p_s_i_products.po_no', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.inspection_status', 'LIKE',"%{$search}%")
                        ->orWhere('inspections.created_at', 'LIKE',"%{$search}%");
                })
                ->groupBy(DB::raw('inspections.id'))               
                ->orderBy($order,$dir) 
                ->get();
                $totalFiltered = count($inspection_temp);
        }
        $data = array();
        
        if(!empty($inspections))
        {
            foreach ($inspections as $inspection)
            {
                if($inspection->inspection_status=="Client Pending"){
                    $inspection_status = "<span class='text-primary'>Waiting for approval</span>";
                } else if($inspection->inspection_status=='Cancelled'){
                    $inspection_status = "<span class='text-danger'>Cancelled</span>";
                } else if($inspection->inspection_status=='Released'){
                    $inspection_status = "<span class='text-success'>Approved</span>";
                } else if($inspection->inspection_status=='Shipment Accepted'){
                    $inspection_status = "<span class='text-success'>Shipment Accepted</span>";
                } else if($inspection->inspection_status=='Report Released'){
                    $inspection_status = "<span class='text-success'>Report Released</span>";
                } else if($inspection->inspection_status=='Shipment Rejected'){
                    $inspection_status = "<span class='text-danger'>Shipment Rejected</span>";
                } else if($inspection->inspection_status=='Hold' ){
                    $inspection_status = "<span class='text-danger'>Hold / Under Review</span>";
                }				
                
                if($inspection->inspection_status=='Client Pending'){
                    $track = "<li><a style='cursor: not-allowed;'>Track</a></li>";
                } else {
                    if($user->user_type == 'tic_sera'){
                    $track = "<li><a href='".route('track-inspection-tic-sera', $inspection->id)."'>Track</a></li>";
                    } else {
                        $track = "<li><a href='".route('supplier-track-inspection', $inspection->id)."'>Track</a></li>";
                    }
                    
                }
                if(empty($supplier_book)){
                    $track_view = "<a class='btn btn-warning btn-xs btn-block btn_view_project' data-id='$inspection->id'>View</a>";
                } else {
                    $track_view = "<a class='btn btn-warning btn-xs btn_view_project' data-id='$inspection->id' title='View Details'><i class='fa fa-eye'></i>View</a>";
                }
                
                
                if($inspection->service=="cbpi" || $inspection->service=="cbpi_serial" || $inspection->service=="cbpi_isce" || $inspection->service=="cli" || $inspection->service=="site_visit" || $inspection->service == 'physical' || $inspection->service == 'detail' || $inspection->service == 'social'){
                    $product = "No product";
                    $model_no = "No Model";
                    $po_no = "No PO";
                    if($user->user_type == 'tic_sera'){
                        //For TIC-SERA
                        if($edit_order=="" || $edit_order=="yes"){
                            $edit_button = "<li><a href='".route('edit-project-supplier-cli-tic-sera',$inspection->id)."' title='Edit Order'><small>Edit</small></a></li>";
                        } else {
                            $edit_button = "<li class='disabled'><a href='#' title='Edit Order'><small>Edit</small></a></li>";
                        }
                        
                        if($copy_order=="" || $copy_order=="yes"){
                            $copy_button = "<li><a href='".route('copy-project-cli-tic-sera',$inspection->id)."' title='Repeat or Copy Order'><small>Repeat/Copy</small></a></li>";
                        } else {
                            $copy_button = "<li class='disabled'><a href='#' title='Repeat or Copy Order'><small>Repeat / Copy</small></a></li>";
                        }		
                    } else {
                        if($edit_order=="" || $edit_order=="yes"){
                            $edit_button = "<li><a href='".route('edit-project-supplier-cli',$inspection->id)."' title='Edit Order'><small>Edit</small></a></li>";
                        } else {
                            $edit_button = "<li class='disabled'><a href='#' title='Edit Order'><small>Edit</small></a></li>";
                        }
                        
                        if($copy_order=="" || $copy_order=="yes"){
                            $copy_button = "<li><a href='".route('copy-project-cli-supplier',$inspection->id)."' title='Repeat or Copy Order'><small>Repeat/Copy</small></a></li>";
                        } else {
                            $copy_button = "<li class='disabled'><a href='#' title='Repeat or Copy Order'><small>Repeat / Copy</small></a></li>";
                        }
                    }
                    
                } else {
                    $product = $inspection->pname;
                    $model_no = $inspection->pmodel;
                    $po_no = $inspection->pno;
                    
                    if($user->user_type == 'tic_sera'){
                        //For TIC-SERA
                        if($edit_order=="" || $edit_order=="yes"){
                            $edit_button = "<li><a href='".route('edit-project-supplier-tic-sera',$inspection->id)."' title='Edit Order'><small>Edit</small></a></li>";
                        } else {
                            $edit_button = "<li class='disabled'><a href='#' title='Edit Order'><small>Edit</small></a></li>";
                        }
                        
                        if($copy_order=="" || $copy_order=="yes"){
                            $copy_button = "<li><a href='".route('copy-project-tic-sera',$inspection->id)."' title='Repeat or Copy Order'><small>Repeat/Copy</small></a></li>";
                        } else {
                            $copy_button = "<li class='disabled'><a href='#' title='Repeat or Copy Order'><small>Repeat / Copy</small></a></li>";
                        }		
                    } else {
                        if($edit_order=="" || $edit_order=="yes"){
                            $edit_button = "<li><a href='".route('edit-project-supplier',$inspection->id)."' title='Edit Order'><small>Edit</small></a></li>";
                        } else {
                            $edit_button = "<li class='disabled'><a href='#' title='Edit Order'><small>Edit</small></a></li>";
                        }
                        
                        if($copy_order=="" || $copy_order=="yes"){
                            $copy_button = "<li><a href='".route('copy-project-supplier',$inspection->id)."' title='Repeat or Copy Order'><small>Repeat/Copy</small></a></li>";
                        } else {
                            $copy_button = "<li class='disabled'><a href='#' title='Repeat or Copy Order'><small>Repeat / Copy</small></a></li>";
                        }
                    }
                }
                
                if($inspection->inspection_status=='Cancelled' || $inspection->inspection_status=='Finished'){
                    $cancel_button = "<li class='disabled'><a><small>Cancel</small></a></li>";
                } else {
                    if($cancel_order=='' || $cancel_order=='yes'){
                        $cancel_button = "<li><a title='Cancel Order' data-id='$inspection->id' data-fac='$inspection->factory_name' data-date='$inspection->inspection_date' data-service='$inspection->service' class='btn_cancel'><small>Cancel</small></a></li>";
                    } else {
                        $cancel_button = "<li class='disabled'><a href='#' title='Cancel Order'><small>Cancel</small></a></li>";
                    }							
                }
                    
                
                if($delete_order=="" || $delete_order=="yes"){
                    $delete_button = "<li><a title='Delete Order' data-id='$inspection->id' data-fac='$inspection->factory_name' data-date='$inspection->inspection_date' data-service='$inspection->service' class='btn_delete'><small>Delete</small></a></li>";
                } else {
                    $delete_button = "<li class='disabled'><a href='#' title='Delete Order'><small>Delete</small></a></li>";
                    
                }							
                
                if($inspection->manday > 0){
                    $manday = $inspection->manday;
                } else {
                    $manday = "N/A";
                }

                $nestedData['client_project_number'] = $inspection->client_project_number;
                $nestedData['service'] =  $inspection->service;
                $nestedData['factory_name'] =  $inspection->factory_name;
                $nestedData['product_name'] = substr($product,0,30);
                $nestedData['model_no'] = substr($model_no,0,30);
                $nestedData['manday'] = $manday;
                $nestedData['po_no'] = substr($po_no,0,30);
                $nestedData['inspection_status'] = $inspection_status;
                //$nestedData['created_at'] = date('M j, Y',strtotime($inspection->created_at));
                $nestedData['created_at'] = substr($inspection->created_at,0,10);
                $nestedData['view_edit'] = $track_view;
                $edit_button_mrn = "<li><a href='".route('edit-project-supplier-mrn',$inspection->id)."' title='Edit Order'><small>Edit Multiple Order</small></a></li>";
                if($inspection->mrn_no != "" ){
                    if(!empty($supplier_book)){
                        $btn_group2 = "<div class='dropdown'><button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown' >Action<span class='caret'></span></button><ul class='dropdown-menu'>$edit_button_mrn $copy_button $cancel_button $delete_button</ul></div>";
                        $nestedData['edit_cancel'] = $btn_group2;
                    }
                }else{
                    if(!empty($supplier_book)){
                        $btn_group2 = "<div class='dropdown'><button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown' >Action<span class='caret'></span></button><ul class='dropdown-menu'>$edit_button $copy_button $cancel_button $delete_button</ul></div>";
                        $nestedData['edit_cancel'] = $btn_group2;
                    }
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

    public function getAccountDashboard(){
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();

        $supplierContactInfo = DB::table('supplier_contacts')
             ->where('supplier_contacts.supplier_id', $supplierInfo->supplierId)->get();
        
        $countries = Country::all();

        $user = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $client = $user->client_code;

        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $users = DB::table('users')->where('client_code',$supplierData->client_code)->first();
        $client_aql_details = DB::table('client_aql_details')->where('client_aql_details.client_id',$users->id)->first();

        //04-28-2021
        $supplierContactNew = DB::table('supplier_datas')
            ->join('client_contacts', 'client_contacts.id', '=', 'supplier_datas.supplier_client_contact_id')
            ->select('client_contacts.*')
            // ->where('supplier_datas.user_id',Auth::id())->get(); 
            ->where('supplier_datas.supplier_id',$supplierData->id)->get(); 

        return view('pages.supplier.accountsettings.index',compact('user_info','user','supplierInfo','supplierContactNew','supplierContactInfo','client_aql_details','client','supplierData','supplierInfo'));
        // return view('pages.factory.accountsettings.index',compact('user_info','user','factoryInfo','factoryContactInfo','client_aql_details','countries','client')); 
    }

    public function updateUserPasswordFact(Request $request){
		$user = User::where('id',Auth::id())->first();
		$user_password = $request['change_new_pass'];
		$user_confirm_password = $request['change_conf_pass'];
		if($user_password == $user_confirm_password){
			if(!empty($user_password) || $user_password!=""){
				$user->password = bcrypt($request['change_new_pass']);
       			$user->plain = $request['change_new_pass'];
				if ($user->update()) {
					return response()->json([
						'message' => 'ok',
					]);
       			}
			}
		} else {
			Session::flash('failed','Password Not Match');
		}
        return json_encode();
	}

    //Update Username or Fullname or Both on Account Settings
	public function updateUsernameFact(Request $request){
		$email=$request['change_username'];
        $count=0;
        $count = User::where('email','=',$email)
			->where('id', '!=', Auth::id())
			->count();
        if($count < 1){
			$user = User::where('id',Auth::id())->first();
			$user_info = UserInfo::where('user_id',Auth::id())->first();
			$user_info->name = $request['change_fullname'];
	
				$user->username = $request['change_username'];
				$user->email = $request['change_username'];
				if ($user->update()) {
					if($user_info->update()){
						return response()->json([
							'message' => 'ok',
						]);
					}
        		}
            }
            else{
                return response()->json([
                    'message' => 'dupticateEmail',
                ]);
            }
        }

    public function updateSupplierDetails(Request $request){
        $supplier = Supplier::where('client_code', $request->input('client_code')); 
        $data = array(
			'supplier_name' => $request->input('supplier_name'),
			'supplier_number' => $request->input('supplier_number'),
			'supplier_code' => $request->input('supplier_code'),
			'supplier_address' => $request->input('supplier_address'),
            'supplier_address_local' => $request->input('supplier_address_local'),
            'supplier_local_address' => $request->input('supplier_local_address'),
			'supplier_local_city' => $request->input('supplier_local_city'),
			'supplier_country' => $request->input('supplier_country'),
            'supplier_country_name' => $request->input('supplier_country_name'),
			'supplier_state' => $request->input('supplier_state'),
			'supplier_state_id' => $request->input('supplier_state_id'),
			'supplier_city' => $request->input('supplier_city'),
			'supplier_city_id' => $request->input('supplier_city_id'),
			'supplier_status' => $request->input('supplier_status')
		);
        if ($supplier->update($data)) {
            return response()->json([
                'supplier' => $supplier
            ],200);
        } 
    }


    //Add Supplier Contact Details
    public function supplierAddContact(Request $request){
        $supplier_contact = new SupplierContact();
        $supplier_contact->supplier_id = $request['supplier_id'];
        $supplier_contact->client_code = $request['client_code'];
        $supplier_contact->supplier_contact_person =  $request['supplier_person'];
		$supplier_contact->supplier_contact_number =  $request['supplier_person_number'];
        $supplier_contact->supplier_tel_number = $request['supplier_person_tel_number'];
		$supplier_contact->supplier_email =  $request['supplier_person_email'];
        $supplier_contact_skype= $request['supplier_skype'];
        $supplier_contact_wechat = $request['supplier_wechat'];
        $supplier_contact_whatsapp = $request['supplier_whatsapp'];
        $supplier_contact_qq = $request['supplier_qqmail'];
		
        if($supplier_contact_skype==""){$supplier_contact_skype="N/A";}
        if($supplier_contact_wechat==""){ $supplier_contact_wechat="N/A"; }
        if($supplier_contact_whatsapp==""){ $supplier_contact_whatsapp="N/A"; }
        if($supplier_contact_qq==""){ $supplier_contact_qq="N/A"; }
        $supplier_contact->supplier_contact_skype = $supplier_contact_skype;
        $supplier_contact->supplier_contact_wechat = $supplier_contact_wechat;
        $supplier_contact->supplier_contact_whatsapp = $supplier_contact_whatsapp;
        $supplier_contact->supplier_contact_qq = $supplier_contact_qq;
        if($supplier_contact->save()) {
            return response()->json([
                'supplier_contact' => $supplier_contact
            ],200);
        }
    }

    //Update Supplier Contact Details
    public function updateSupplierContactPerson(Request $request){
        $supplierContactDetails = SupplierContact::where('id', $request->input('supplier_contact_id'));
        //$client = Client::where('client_id', Auth::id());
        $data = array(
            'supplier_contact_person'=> $request->input('supplier_contact_person'),
            'supplier_contact_number'=> $request->input('supplier_contact_number'),
            'supplier_tel_number'=> $request->input('supplier_tel_number'),
            'supplier_email'=> $request->input('supplier_email'),
            'supplier_contact_skype'=> $request->input('supplier_contact_skype'),
            'supplier_contact_wechat'=> $request->input('supplier_contact_wechat'),
            'supplier_contact_whatsapp'=> $request->input('supplier_contact_whatsapp'),
            'supplier_contact_qq'=> $request->input('supplier_contact_qq'),
		);

        if ($supplierContactDetails->update($data)) {
            return response()->json([
                'supplierContactDetails' => $supplierContactDetails
            ],200);
        }
    }


    //Update Supplier Contact Person
    public function updateSupplyContactPerson(Request $request){
        $supplier_contact = SupplierContact::where('id', $request['id'])->get();
        //$client = Client::where('client_id', Auth::id());
            return response()->json([
                'supplier_contact' => $supplier_contact
            ]);
    }
    

    //Delete Contact Person
    public function deleteSupplierContactPerson(Request $request){
        $supplier_contact = SupplierContact::where('id', $request['id'])->get();
        return response()->json([
            'supplier_contact' => $supplier_contact
        ]);
    }

    //Delete Contact Person
    public function delete_SupplierContactPerson(Request $request){
		$supplier_contact = SupplierContact::where('id', $request['delete_suppliercontact_id'])->delete();
    }

    //Get supplier client name
    public function getSupplierClientName(){
        $user = User::where('id',Auth::id())->first();        
        $supplierData = DB::table('supplier_datas')->where('user_id', $user->id)->first();
        $supplier = DB::table('suppliers')->where('id', $supplierData->supplier_id)->first();
        $clientName = Client::where('client_code', $supplier->client_code)->get();
        return response()->json([
            'client_name' => $clientName            
        ]);
    }

    //Migz/ Supplier New Order Form
    public function getSupplierProjectForm(){
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

        $client1 = Client::where('id',$g->group_id)->first();
       
        $role = User::where('id',$client_id)->first();
        $client = UserInfo::where('id',$client_id)->first();
        $client_code = $client1->client_code;

        date_default_timezone_set('UTC');
        $year=date("y");
        $month=date("m");
        $Inspection = Inspection::where('client_id',$client_code)->get();
        $count = $Inspection->count();

        $get_count=$count+1;
		$set_count;
		if($get_count<=9){
			$set_count='0'.''.$get_count;
		}else{
			$set_count=$get_count; 
		}

        $ref_num=$client_code.'-'.$year.''.$month.'-'.$set_count;
       
        $countries = Country::all();
        $factories = Factory::where('factory_status','!=',2)->where('client_code',$client_code)->orderBy('factory_name', 'asc')->get();
        $suppliers = Supplier::where('supplier_status','!=',2)->where('client_code',$client_code)->orderBy('supplier_name', 'asc')->get();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $inspectors = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->pluck('name','user_id');

        $inspectors_two = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->get();

        $inspectors_new = DB::table('users')
                        ->join('user_infos','user_infos.user_id','=','users.id')
                        ->orderBy('user_infos.name','asc')
                        ->pluck('user_infos.name','users.id');


        $products = Product::orderBy('product_name', 'desc')->get();
        

        //client name

        $clientName = DB::table('clients')->where('id', $user->group_id)
                    ->select('*')
                    ->get(); 
        //client contacts
        $clientName1 = DB::table('clients')->where('id', $user->group_id)->first();
        $clientContact = DB::table('client_contacts')->where('client_code', $clientName1->client_code)
                    ->select('*')
                    ->get(); 

        //       return response()->json([
        //           'clientcontact' => $clientContact
        //       ]);

         //ADDED BY Rommel
         $supplierInfo = DB::table('supplier_datas')
         ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
         ->select('*','suppliers.id as supplierId')
         ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $clientContacts = DB::table('client_contacts')->where('client_code',$supplierData->client_code)->get();
        $supplierContacts = DB::table('supplier_contacts')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_contacts.supplier_id')
            ->where('supplier_id',$supplierInfo->supplier_id)->get();

        //04-28-2021
        $supplierContactNew = DB::table('supplier_datas')->where('user_id',Auth::id())->first(); 
    
        //05-10-2021
        $supplierClientContact = DB::table('client_contacts')->where('id',$supplierContactNew->supplier_client_contact_id)->first();
        $supplierContactName = DB::table('supplier_contacts')->where('id',$supplierContactNew->supplier_contact_id)->first();  

        $supplierFactories = DB::table('factories')
            ->join('suppliers', 'suppliers.id', '=', 'factories.supplier_id')
            ->select('*','factories.id as factoryId')
            ->where('supplier_id',$supplierInfo->supplier_id)->get();
        $factoryContacts = DB::table('fctory_contacts')
            ->join('factories', 'factories.id', '=', 'fctory_contacts.factory_id')
            ->where('supplier_id',$supplierInfo->supplier_id)->get();;
            
        //supplier contact

        $suppData = DB::table('supplier_datas')->where('user_id', $user->id)->first();
        $supplierContact = DB::table('supplier_contacts')->where('supplier_id', $suppData->supplier_id)
                    ->select('*')
                    ->get(); 
                    
        //get supplier factory
        $suppData1 = DB::table('supplier_datas')->where('user_id', $user->id)->first();
        $supplierContact1 = DB::table('supplier_contacts')->where('supplier_id', $suppData1->supplier_id)->first();
        $suppliers1 = DB::table('suppliers')->where('id', $supplierContact1->supplier_id)->first();
        $suppFactory = DB::table('factories')
                    ->where('supplier_id',$suppliers1->id)
                    ->where('factories.factory_status', 0)
                    ->select('*')
                    ->get(); 

        //get products
        $suppProducts = DB::table('products')->where('client_code', $clientName1->client_code)
                    ->where('supplier_id',$suppliers1->id)
                    ->where('status',0)
                    ->select('*')
                    ->get(); 



 //       return response()->json([
 //           'clientname' => $clientName
 //       ]);

    //    $supplierData1 = DB::table('supplier_datas')->where('user_id', $user->id)->first();
    //    $supplier1 = DB::table('suppliers')->where('id', $supplierData1->supplier_id)->first();
     //   $clientName1 = Client::where('client_code', $supplier1->client_code)->first();

        //product category    
        $p_category=array();

        $p_category=['Accessories / components'=>'Accessories / components'
        ,'Apparel'=>'Apparel'
        ,'Automotive Parts'=>'Automotive Parts'
        ,'Bag and case'=>'Bag and case'
        ,'Beauty / hairdressing and personal care appliance'=>'Beauty / hairdressing and personal care appliance'
        ,'Chemical Products'=>'Chemical Products'
        ,'Construction and Mechanical Products'=>'Construction and Mechanical Products'
        ,'Consumer Electronics'=>'Consumer Electronics'
        ,'Fans'=>'Fans'
        ,'Furniture'=>'Furniture'
        ,'Garden'=>'Garden'
        ,'Garment'=>'Garment'
        ,'Garment accessories'=>'Garment accessories'
        ,'Gifts and Promo Items'=>'Gifts and Promo Items'
        ,'Healthcare and Beauty'=>'Healthcare and Beauty'
        ,'Home Appliances'=>'Home Appliances'
        ,'Homeware'=>'Homeware'
        ,'Hometextile'=>'Hometextile'
        ,'Hotel Supplies'=>'Hotel Supplies'
        ,'Kitchen Appliances'=>'Kitchen Appliances'
        ,'Lighting'=>'Lighting'
        ,'Machinery Parts/Products'=>'Machinery Parts/Products'
        ,'Multimedia'=>'Multimedia'
        ,'Outdoor and Sports Products'=>'Outdoor and Sports Products'
        ,'Pet Products'=>'Pet Products'
        ,'Power tools'=>'Power tools'
        ,'Printing and Packaging'=>'Printing and Packaging'
        ,'Shoes'=>'Shoes'
        ,'Stationery and Luggage Products'=>'Stationery and Luggage Products'
        ,'Toys / Recreational Items'=>'Toys / Recreational Items'];
        $cat_arr=array();
        $p_categories  = SavedProductCategories::where('user_id',Auth::id())->get();
        foreach($p_categories as $cat){
            $p_category += [$cat->category => $cat->category];
        }
        ksort($p_category);
        $p_category += ['Others' => 'Others'];

		
		//Categories
        $categories = Category::orderBy('name', 'desc')->get()->pluck('id','name');
        $sub_categories = SubCategory::orderBy('name', 'desc')->get()->pluck('id','category_id','name');

         
        $client_contact = ClientContact::where('client_code',$client_code)->get();
        //$client_aql_detail = ClientAqlDetail::where('client_id',Auth::id())->first();
        $client_aql_minors_orig = ClientAqlMinor::all();
        $client_aql_majors_orig = ClientAqlMajor::all();

       
        $client_aql_detail = DB::table('users')
            ->join('clients','clients.id','=','users.group_id')
            ->join('client_aql_details','client_aql_details.client_id','=','clients.user_id')
            ->where('users.id',Auth::id())
            ->select('client_aql_details.*')
            ->get();
        //return $client_aql_detail;
		
        $client_aql_minors = $client_aql_minors_orig->pluck('aql','aql');
        $client_aql_majors = $client_aql_majors_orig->pluck('aql','aql');
        $normal=['I'=>'I','II'=>'II','III'=>'III'];
        $special=['S1'=>'S1','S2'=>'S2','S3'=>'S3','S4'=>'S4'];
        $aql_major = ['0.065'=>'0.065','0.1'=>'0.1','0.15'=>'0.15','0.25'=>'0.25','0.40'=>'0.40','1'=>'1','1.5'=>'1.5','2.5'=>'2.5','4'=>'4','6.5'=>'6.5','10'=>'10'];
        $units=['piece'=>'Piece/s','roll'=>'Roll/s','set'=>'Set/s','pair'=>'Pair/s','box'=>'Box/es'];
        
        $services=[];
        if($client_id==755){
            $services = [
                'iqi'=> 'Incoming Quality Inspection',
                'dupro'=> 'During Production Inspection',
                'psi'=> 'Pre Shipment Inspection',
                'cbpi' => 'CBPI - No Serial',
                'cli'=> 'Container Loading Inspection',
                'physical' => 'Factory Audit',
                'detail' => 'Detail Audit',
                'social' => 'Social Audit',
                'st' => 'Sample Test'
            ];
        }else{
            $services = [
                'iqi'=> 'Incoming Quality Inspection',
                'dupro'=> 'During Production Inspection',
                'psi'=> 'Pre Shipment Inspection',
                'cbpi' => 'CBPI - No Serial',
                'cli'=> 'Container Loading Inspection'
            ];
        }
        
        
        return view('pages.supplier.project.index_mrn', compact('role','user_info','inspectors','factories','countries','products','inspectors_new','inspectors_two',
        'client_id','client_code','ref_num','client_contact','client_aql_detail','client_aql_minors','client_aql_majors','normal','special','aql_major','user',
        'suppliers','units','categories','sub_categories','p_category','services','sub_acc','privelege', 'clientName', 'supplierContact', 'suppFactory',
         'suppProducts', 'clientContact','supplierInfo','supplierData', 'suppliers1','supplierContactNew','supplierClientContact','supplierContactName'));
    }

    public function postInspectionData(Request $request){
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $validator = Validator::make($request->all(), [
            'service' => 'required',
            'client_project_number' => 'required',
            'inspection_date' => 'required',
            'psi_shipment_date' => 'required',
            'client' => 'required',
            'contact_person' => 'required',
            'supplier' => 'required',
            'supplier_contact_person' => 'required',
            'factory' => 'required',
            'factory_contact_person' => 'required',
            'reference_number' => 'required'
        ]);

        
        if($validator->fails()) {
            return response()->json([
                'message' => 'Empty fields',
            ],500);
        }else{
            $new_data = json_decode($request['new_set_data'], true);
            //this is the foreach of new data i will comment this for your reference
            /* foreach($new_data as $items => $item){
                $report_number = $item['parent_report_number'];
                //this is for products
                $products = $item['products'];
                foreach($products as $product){
                    $product_id = $product['product_id'];
                }
            } */

            DB::beginTransaction();
            try {
                //get user type
                $auth_id=Auth::id();
                $user_data = User::where('id',Auth::id())->first();
                $user_type=null;
                if($user_data->user_type=='tic_sera'){
                    $user_type='tic_sera';
                }
                //error count
                $error_count_mail = 0;

                //start of for loop of reference number
                foreach($new_data as $items => $item){
                    //multiple reference number
                    $reference_number = $item['parent_report_number'];
                    //multiple products number
                    $multiple_products = $item['products'];

                    $inspection = new Inspection();
                    //inspection details
                    $inspection->client_id = $request['client'];
                    $inspection->contact_person = $request['contact_person'];
                    //factory details
                    $inspection->supplier_id = $supplierInfo->supplier_id;
                    $inspection->supplier_contact_id = $request['supplier_contact_person'];
                    //factory details
                    $inspection->factory = $request['factory'];
                    $inspection->factory_contact_person = $request['factory_contact_person'];
                    $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];
                    //inspection details
                    $inspection->inspector_id = 0;
                    $inspection->secondary_inspector_id = $request['second_inspector'];
                    $inspection->manday = $request['manday'];
                    $inspection->inspection_date = $request['inspection_date'];
                    $inspection->inspection_date_to = $request['inspection_date_to'];
                    $inspection->shipment_date = $request['psi_shipment_date'];
                    // $inspection->factory_change_date = $request['fac_change_date'];
                    $inspection->service = $request['service'];
                    $inspection->reference_number = $reference_number;
                    $inspection->mrn_no = $request['reference_number'];
                    $inspection->client_project_number = $request['client_project_number'];
                    $inspection->percentageFriSpk = $request['percentageSpkFri'];
                    $inspection->requirement = $request['requirement'];
                    $inspection->memo = $request['memo'];
                    $template=$request['template'];
                    if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}

                    $report_template=$request['report_template'];
                    if($report_template=="" || $report_template=='N/A'){$report_template=null;}
                    $inspection->word_template = $report_template;

                    $inspection->template_id = $template;
                    $inspection->project_type = $request['type_of_project'];

                    $inspection->inspection_type = $user_type;

                    $inspection->inspection_status = "Client Pending";
                    $inspection->client_book = "false";
                    $inspection->supplier_book = "true";
                    $inspection->client_book_id =  Auth::id();
                    $inspection->created_by =  Auth::id();

                    $email_po_number="";

                    if($request['invisible'] == "on"){
                        $inspection->Clientstatus = '1';
                    }

                    if ($inspection->save()) {
                        //$products = $request['product_id'];
                        $inserted_inspection_id=$inspection->id;

                        $clientCost = new ClientCost();
                        $clientCost->inspection_id =  $inspection->id;
                        $clientCost->currency =  'usd';
                        $clientCost->md_charges =  0;
                        $clientCost->travel_cost =  0;
                        $clientCost->hotel_cost =  0;
                        $clientCost->ot_cost =  0; 
                        $clientCost->save();

                        $inspectorCost = new InspectorCost();
                        $inspectorCost->inspection_id =  $inspection->id;
                        $inspectorCost->currency =  'usd';
                        $inspectorCost->md_charges =  0;
                        $inspectorCost->travel_cost =  0;
                        $inspectorCost->hotel_cost =  0;
                        $inspectorCost->ot_cost =  0; 
                        $inspectorCost->save();

                        $upload_file_name=array();
                        $prod_name=array();
                        $brand_arr=array();
                        $po_number_arr=array();
                        $model_no_arr=array();
                        $aql_qty_arr=array();
                        $aql_normal_level_arr=array();
                        $aql_special_level_arr=array();
                        $aql_major_arr=array();
                        $max_major_arr=array();
                        $aql_minor_arr=array();
                        $max_minor_arr=array();
                        $products_id=array();

                        /* foreach ($products as $i => $value) { */
                        foreach($multiple_products as $product){
                            $new_product = new PSIProduct();
                            $new_product->inspection_id = $inspection->id;
                            $new_product->product_id = $product['product_id'];
                            $new_product->mrn_no = $request['reference_number'];
                            $new_product->product_name = $product['product_name'];
                            $new_product->product_first_category = $product['product_category'];
                            $new_product->product_category = $product['product_sub_category'];
                            $new_product->brand = $product['brand'];
                            $new_product->po_no = $product['po_number'];
                            $new_product->model_no = $product['model_no'];
                            $new_product->additional_product_info = $product['addtnl_pinfo'];
                            $new_product->aql_qty = $product['aql_qty'];
                            $new_product->aql_qty_unit = $product['aql_qty_unit'];
                            $new_product->aql_normal_level = $product['aql_normal_level'];
                            $new_product->aql_special_level = $product['aql_special_level'];
                            $new_product->aql_major = $product['aql_major'];
                            $new_product->max_allowed_major = $product['max_major'];
                            $new_product->aql_minor = $product['aql_minor'];
                            $new_product->max_allowed_minor = $product['max_minor'];
                            $new_product->aql_normal_letter = $product['aql_normal_letter'];
                            $new_product->aql_normal_sampsize = $product['aql_normal_sampsize'];
                            $new_product->aql_special_letter = $product['aql_special_letter'];
                            $new_product->aql_special_sampsize = $product['aql_special_sampsize'];

                            $product_saved = Product::where('id',$product['product_id'])->first();
                            if(!empty($product_saved)){
                                $new_product->product_length = $product_saved->product_length;
                                $new_product->product_width = $product_saved->product_width;
                                $new_product->product_height = $product_saved->product_height;
                                $new_product->product_diameter = $product_saved->product_diameter;
                                $new_product->product_weight = $product_saved->product_weight;
                                $new_product->retail_length = $product_saved->retail_length;
                                $new_product->retail_width = $product_saved->retail_width;
                                $new_product->retail_height = $product_saved->retail_height;
                                $new_product->retail_diameter = $product_saved->retail_diameter;
                                $new_product->retail_weight = $product_saved->retail_weight;
                                $new_product->retail_box_qty = $product_saved->retail_box_qty;
                                $new_product->inner_length = $product_saved->inner_length;
                                $new_product->inner_width = $product_saved->inner_width;
                                $new_product->inner_height = $product_saved->inner_height;
                                $new_product->inner_diameter = $product_saved->inner_diameter;
                                $new_product->inner_weight = $product_saved->inner_weight;
                                $new_product->inner_box_qty = $product_saved->inner_box_qty;
                                $new_product->export_length = $product_saved->export_length;
                                $new_product->export_width = $product_saved->export_width;
                                $new_product->export_height = $product_saved->export_height;
                                $new_product->export_diameter = $product_saved->export_diameter;
                                $new_product->export_weight = $product_saved->export_weight;
                                $new_product->export_box_qty = $product_saved->export_box_qty;
                                $new_product->export_max_weight_carton = $product_saved->export_max_weight_carton;
                                $new_product->export_cbm = $product_saved->export_cbm; 
                                $new_product->grd = $product_saved->grd;
                                $new_product->item_description = $product_saved->item_description;
                                $new_product->additional_product_info = $product_saved->additional_product_info;
                            }
                            $new_product->save();

                            array_push($products_id,$product['product_id']);
                            array_push($prod_name,$product['product_name']);
                            array_push($brand_arr,$product['brand']);
                            array_push($po_number_arr,$product['po_number']);
                            array_push($model_no_arr,$product['model_no']);
                            array_push($aql_qty_arr,$product['aql_qty']);
                            array_push($aql_normal_level_arr,$product['aql_normal_level'].'/'.$product['aql_special_level']);
                            array_push($aql_special_level_arr,$product['aql_normal_sampsize'].'/'. $product['aql_special_sampsize']);
                            array_push($aql_major_arr,$product['aql_major']);
                            array_push($max_major_arr,$product['max_major']);
                            array_push($aql_minor_arr,$product['aql_minor']);
                            array_push($max_minor_arr,$product['max_minor']);

                            if( $email_po_number==''){
                                $email_po_number=$product['po_number'];
                            }else{
                                $email_po_number=$email_po_number.','.$product['po_number'];
                            }
                        }

                        //blank report details
                    
                        $service = [
                            'iqi' => 'Incoming Quality Inspection',
                            'dupro' => 'During Production Inspection',
                            'psi' => 'Pre Shipment Inspection',
                            'cli' => 'Container Loading Inspection',
                            'pls' => 'Setting up Production Lines',
                            'cbpi' => 'CBPI - No Serial',
                            'cbpi_serial' => 'CBPI - with Serial',
                            'cbpi_isce' => 'CBPI - ISCE',
                            'site_visit' => 'Site Visit',
                            'SPK' => 'SPK',
                            'FRI' => 'FRI',
                            'physical' => 'Factory Audit',
		    	    	    'detail' => 'Detail Audit',
                            'social' => 'Social Audit',
                            'st' => 'Sample Test'
                        ];
                        
                        if($request->file('file')){
                            foreach ($request->file('file') as $file) {
                                $filename = $file->getClientOriginalName();    
                                $filename=str_replace("#","_",$filename);                
                                //directory
                                $dir="images/project2/".$inserted_inspection_id."/";               
                                //move the files to the correct folder
                                if (!File::exists($dir)) {
                                    File::makeDirectory($dir);
                                }
                                $inserted_inspection_id2 = $inserted_inspection_id-1;
                                $dir2="images/project2/".$inserted_inspection_id2."/";  
                                if(File::exists($dir2.$filename)){
                                    $inserted_inspection_id1 = $inserted_inspection_id-1;
                                    $dir1="images/project2/".$inserted_inspection_id1."/";  
                                    $sourceFilePath= $dir1;
                                    $destinationPath= $dir;
                                    $success = File::copy($sourceFilePath.$filename,$destinationPath.$filename);
                                }
                                else{
                                    $file->move($dir,$filename);
                                }
                                //push file name in array
                                array_push($upload_file_name,$dir.$filename);  
                                //save details to db
                                $doc= new Attachment();
                                $doc->inspection_id = $inserted_inspection_id;
                                $doc->project_number = $reference_number;
                                $doc->file_name = $filename;
                                //$doc->file_size = $file->getSize();
                                $doc->file_size = 56716;
                                $doc->path = $dir.$filename;
                                $doc->save();
                            }
                        }
                        
                        $client = Client::where('client_code',$request['client'])->first();

                        $sales = DB::table('user_infos')->where('user_id',$client->sales_id)->first();
            
                        if($client->sales_id != 0 || $client->sales_id != '' || $client->sales_id != null){
                            $s_name = $sales->name;
                            $s_email = $sales->email_address;
                        }else{
                            $s_name = '';
                            $s_email = '';
                        }        
                    
                        $password = mt_rand(100000, 999999);
                        $report_no = $reference_number;

                        $report = new Report();
                        $report->inspection_id = $inspection->id;
                        $report->client_code = $client->client_code;
                        $report->service = $service[$request['service']];
                        $report->inspection_date = $request['inspection_date'];
                        $report->inspector_id=$request['inspector'];
                        $report->report_no = $report_no;
                        $report->password = $password;         
                        if ($report->save()) {
                            $client_info = UserInfo::find(Auth::id());
                            $psi_product_list = PSIProduct::where('inspection_id',$inserted_inspection_id)->get();
                            $factory = Factory::where('id',$request['factory'])->first();
                            $factory_cont = FctoryContact::where('id',$request['factory_contact_person'])->first();
                            $data = ['report_number' =>  $reference_number,
                                    'service'=>$service[$request['service']],
                                    'inspection_date'=>$request['inspection_date'],
                                    'inspection_date_to'=>$request['inspection_date_to'],
                                    'manday'=>$request['manday'],
                                    'client_number'=>$request['client_project_number'],
                                    'supplier_name'=>$request['supplier_name'],
                                    'c_name'=> $client->Company_Name,
                                    'company_email'=> $client->Company_Email,
                                    'email_po_number'=>$email_po_number,
                                    'psi_product_list'=>$psi_product_list,
                                    'factory'=>$factory,
                                    'factory_cont'=>$factory_cont,
                                    'file_passed'=>$upload_file_name,
                                    'products_id'=>$products_id,
                                    'client_email'=>$client_info->email_address,
                                    'dear_client'=>$client_info->name,
                                    'requirement'=>$request['requirement'],
                                    'memo'=>$request['memo'],
                                    'user_type'=>$user_type,
                                    'auth_id' => $auth_id,
                                    'sales_name' => $s_name,
                                    'sales_email' => $s_email,
                                    'sales_id' => $client->sales_id
                                ];
                                   

                                    Mail::send('email.book_from_client',$data, function($message) use ($data){

                                        if($data['client_email']){
                                            // $message->to($data['client_email'],$data['supplier_name']);
                                            // $message->cc($data['company_email'],$data['c_name']);
                                            $message->to('miguelbuojr@gmail.com');
                                        }else{
                                            // $message->to('booking@t-i-c.asia','Booking');
                                        }
                                        // $message->bcc('booking@t-i-c.asia','Booking');
                                        // $message->bcc('it-support@t-i-c.asia','IT Support');
                                        // $message->bcc('report@t-i-c.asia','Report');				
                                        // $message->bcc('gregor@t-i-c.asia','Gregor');      
                                        // $message->bcc('gregor.voege@web.de');
                                        // if($data['user_type']=='tic_sera'){
                                        //     $message->bcc('aarreola@sera.com.mx','Aarreola');    
                                        //     //$message->bcc('asiaop@sera.com.mx','Asiaop');    
                                        //     $message->bcc('coordination@sera.com.mx','Coordination');
                                        //     if($data['auth_id']=='904' || $data['auth_id']==904){
                                        //         $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                        //         $message->bcc('sera.asiaop@outlook.com','SeraAsiaop');
                                        //         $message->bcc('aarreola.sera@gmail.com','AarreolaSera');
                                        //     }  
                                        // }else{
                                        //     $message->bcc('1249484103@qq.com');                             
                                        //     $message->bcc('2891400188@qq.com');
                                        // }                   
                                        $message->subject("Supplier Booked - ".$data['service'] ." for " .$data['client_number']. " on " . $data['inspection_date']);         
                                    });
                                    if($client->sales_id != 0 || $client->sales_id != '' || $client->sales_id != null){    
                                        Mail::send('email.book_email_notice',$data, function($message) use ($data){
                                            
                                            $message->to($data['sales_email']);                                
        
                                            $message->subject("Supplier Booked - ".$data['service'] ." for " .$data['client_number']. " on " . $data['inspection_date']);          
                                        });
                                    }              
                                   
                                    $group = User::where('id',Auth::id())->first();
                                    if($group->group_id){
                                        $group_id = $group->group_id;
                                    } else {
                                        $group_id = "";
                                    }  
                                    // \LogActivity::addToLog('book',$inspection->id,'add',$group_id, 'Added New Inspection Reference Number: ' . $request['reference_number']);
                        }
                    }
                } //end of for loop of reference number

                DB::commit();
                return response()->json([
                    'message' => 'OK',
                ],200);

            } catch (Exception $e) {
                DB::rollback();
                 return response()->json([
                    'message'=>$e->getMessage()
                ],500);
            }
        }
    }

    //CBPI Post DAta
    public function postCBPISupplierData(Request $request){
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();

        $validator = Validator::make($request->all(), [
            'loading_service' => 'required',
            'loading_reference_number' => 'required',
            'client_project_number_cbpi' => 'required',
            'loading_inspection_date' => 'required',
            'loading_client' => 'required',
            'loading_contact_person' => 'required',
            'loading_supplier' => 'required',
            'loading_supplier_contact_person' => 'required',
            'loading_factory' => 'required',
            'loading_factory_contact_person' => 'required'    
        ]);
        if($validator->fails()) {
            return response()->json([
                'message' => 'Empty fields',
            ],500);
        }else{
            DB::beginTransaction();
            try{
                $auth_id=Auth::id();
                $user_data = User::where('id',Auth::id())->first();
                $user_type=null;
                if($user_data->user_type=='tic_sera'){
                    $user_type='tic_sera';
                }

                $inspection = new Inspection();
                //inspection details
                $inspection->service = $request['loading_service'];
                $inspection->reference_number = $request['loading_reference_number'];
                $inspection->client_project_number = $request['client_project_number_cbpi'];
                $inspection->inspection_date = $request['loading_inspection_date'];
                $inspection->inspection_date_to = $request['loading_inspection_date_to'];
                $inspection->shipment_date = $request['shipment_date'];
                $inspection->factory_change_date = $request['loading_fac_change_date'];
                $inspection->client_id = $request['loading_client'];
                $inspection->contact_person = $request['loading_contact_person'];
                //supplier details
                $inspection->supplier_id = $request['loading_supplier'];
                $inspection->supplier_name = $request['loading_supplier_name'];
                $inspection->supplier_contact_id = $request['loading_supplier_contact_person'];
                //factory details
                $inspection->factory = $request['loading_factory'];
                $inspection->factory_contact_person = $request['loading_factory_contact_person'];
                $inspection->factory_contact_person2 = $request['factory_contact_person2_cbpi'];

                $inspection->supplier_name = $supplierData->supplier_name;
            
                $inspection->requirement = $request['loading_requirements'];
                $inspection->memo = $request['memo'];
                $inspection->inspector_id = 0;
                $inspection->secondary_inspector_id = $request['second_inspector'];
                $inspection->manday = $request['manday'];

                $loading_template=$request['loading_template'];
                if($loading_template=="" || $request['project_type_cbpi']=="word_project" || $request['project_type_cbpi']=="esprit"){$loading_template=0;}

                $report_template=$request['loading_report_template'];
                if($report_template=="" || $report_template=='N/A'){$report_template=null;}
                $report_template=null;
                $inspection->word_template = $report_template;

                $inspection->template_id = $loading_template;
                $inspection->project_type = $request['project_type_cbpi'];

                $inspection->inspection_type = $user_type;

                $inspection->inspection_status = "Client Pending";
                $inspection->client_book = "false";
                $inspection->supplier_book = "true";
                $inspection->client_book_id =  Auth::id();
                $inspection->created_by =  Auth::id();


                if($request['loading_invisible'] == "on"){
                    $inspection->Clientstatus = '1';
                }
                
                if ($inspection->save()) {
                    $inserted_inspection_id=$inspection->id;
                    $clientCost = new ClientCost();
                    $clientCost->inspection_id =  $inspection->id;
                    $clientCost->currency =  'usd';
                    $clientCost->md_charges =  0;
                    $clientCost->travel_cost =  0;
                    $clientCost->hotel_cost =  0;
                    $clientCost->ot_cost =  0; 
                    $clientCost->save();

                    $inspectorCost = new InspectorCost();
                    $inspectorCost->inspection_id =  $inspection->id;
                    $inspectorCost->currency =  'usd';
                    $inspectorCost->md_charges =  0;
                    $inspectorCost->travel_cost =  0;
                    $inspectorCost->hotel_cost =  0;
                    $inspectorCost->ot_cost =  0; 
                    $inspectorCost->save();

                    $upload_file_name=array();
                    $service = [
                        'iqi' => 'Incoming Quality Inspection',
                        'dupro' => 'During Production Inspection',
                        'psi' => 'Pre Shipment Inspection',
                        'cli' => 'Container Loading Inspection',
                        'cbpi' => 'CBPI - No Serial',
                        'physical' => 'Factory Audit',
		        		'detail' => 'Detail Audit',
                        'social' => 'Social Audit',
                        'st' => 'Sample Test'
                    ];
                    
                    if($request->file('file')){
                        foreach ($request->file('file') as $file) {
                            //set a unique file name
                            //$filename = uniqid().'.'.$file->getClientOriginalExtension();

                            $filename = $file->getClientOriginalName();
                            $filename=str_replace("#","_",$filename);

                            $dir="images/project2/".$inserted_inspection_id."/";

                            //move the files to the correct folder
                            if (!File::exists($dir)) {
                                File::makeDirectory($dir);
                            }

                            //move the files to the correct folder
                            $file->move($dir,$filename);

                            //push file name in array
                            array_push($upload_file_name,$dir.$filename);

                            $doc= new Attachment();
                            $doc->inspection_id = $inserted_inspection_id;
                            $doc->project_number = $request['loading_reference_number'];
                            $doc->file_name = $filename;
                            $doc->file_size = 604238;
                            //$doc->file_size = 56716;
                            $doc->path = $dir.$filename;
                            $doc->save();
                        }
                    }
                    
                    $client = Client::where('client_code',$request['loading_client'])->first();
                
                    $password = mt_rand(100000, 999999);

                    $report = new Report();
                    $report->inspection_id = $inspection->id;
                    $report->client_code = $request['loading_client'];
                    $report->service = $request['loading_service'];
                    $report->inspection_date = $request['loading_inspection_date'];
                    $report->inspector_id = $request['loading_inspector'];
                    $report->report_no = $request['loading_reference_number'];
                    $report->password = $password;
                    $email_po_number="No PO #";
                    if ($report->save()) {
                        $client_info = UserInfo::find(Auth::id());
                        $factory = Factory::where('id',$request['loading_factory'])->first();
                        $factory_cont = FctoryContact::where('id',$request['loading_factory_contact_person'])->first();
                        $psi_product_list=null;
                        $data = ['report_number' =>  $request['loading_reference_number'],
                                'service'=>$service[$request['loading_service']],
                                'inspection_date'=>$request['loading_inspection_date'],
                                'inspection_date_to'=>$request['loading_inspection_date_to'],
                                'client_number'=>$request['client_project_number_cbpi'],
                                'c_name'=> $client->Company_Name,
                                'c_email'=> $client->Company_Email,
                                'email_po_number'=>$email_po_number,
                                'factory'=>$factory,
                                'factory_cont'=>$factory_cont,
                                'file_passed'=>$upload_file_name,
                                'psi_product_list'=>$psi_product_list,
                                'client_email'=>$client_info->email_address,
                                'dear_client'=>$client_info->name,
                                'requirement'=>$request['loading_requirements'],
                                'memo'=>$request['memo'],
                                'user_type'=>$user_type,
                                'auth_id' => $auth_id
                            ]; 
                            Mail::send('email.book_from_client',$data, function($message) use ($data){
                                
                                if($data['client_email']){
                                    $message->to($data['client_email'],$data['c_name']);
                                    $message->to($data['c_email'],$data['c_name']);
                                   //correct->checked
                                }else{
                                    $message->to('booking@t-i-c.asia','Booking');
                                }
                                $message->bcc('booking@t-i-c.asia','Booking');
                                $message->bcc('it-support@t-i-c.asia','IT Support');
		        				$message->bcc('report@t-i-c.asia','Report');
                                $message->bcc('gregor@t-i-c.asia','Gregor');
                                $message->bcc('gregor.voege@web.de');
                                if($data['user_type']=='tic_sera'){
                                    $message->bcc('aarreola@sera.com.mx','Aarreola');    
                                    $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                    $message->bcc('coordination@sera.com.mx','Coordination');    
                                    if($data['auth_id']=='904' || $data['auth_id']==904){
                                        $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                        $message->bcc('sera.asiaop@outlook.com','SeraAsiaop');
                                        $message->bcc('aarreola.sera@gmail.com','AarreolaSera');
                                    }
                                }else{
                                    $message->bcc('1249484103@qq.com');                             
                                    $message->bcc('2891400188@qq.com');
                                }
                                $message->subject("Supplier-".$data['client_number']);  
                                /* remove attachment 08/01/2020*/   
                                /* if($data['file_passed']){ 
                                    foreach ($data['file_passed'] as $file_name) {
                                        $message->attach($file_name);
                                    }     
                                }   */                                      
                            }); 
                         if (count(Mail::failures()) > 0) {
                             DB::rollback();
                             return response()->json([
                                 'message' => 'error',
                             ],500);        
                         }else{
                            DB::commit();
                            return response()->json([
                                'message' => 'OK',
                            ],200);
                        }
                        //CHECK THE EMAIL IF THERE IS A EMAIL ERROR ON THE MAIL SEND FUNCTIONS
                        // if( count(Mail::failures()) > 0 ) {

                        //     echo "There was one or more failures. They were: <br />";
                         
                        //     foreach(Mail::failures() as $email_address) {
                        //         echo " - $email_address <br />";
                        //      }
                         
                        //  } else {
                        //      return ("No errors, all sent successfully!");
                        //  }
                    }
                }
            }catch (Exception $e) {
                DB::rollback();
                 return response()->json([
                    'message'=>$e->getMessage()
                ],500);
            }
        }
    }




    public function getInspectionLoadingProjectFormEditSupplier($id){
        $sub_acc="no";
        $privelege="";
        $client_id="";
        $g = User::select('group_id')->where('id',Auth::id())->first();
        if(empty($g->group_id)){
            $client_id = Auth::id();
            $sub_acc="no";
        } else {
            $client_id = $g->group_id;
            $sub_acc="yes";
            $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
        }

        $client_id=Auth::id();
        $role = User::where('id',$client_id)->first();
        $client = UserInfo::where('id',$client_id)->first();
        $client_code=$client->client_code;
        $inspection = Inspection::where('id',$id)->first();
        

        //SUPPLIER DATA
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $users = DB::table('users')->where('client_code',$supplierData->client_code)->first();
        
        //factory       
        $get_factory = Factory::where('id',$inspection->factory)->first();
        $get_fc = FctoryContact::where('id',$inspection->factory_contact_person)->first();
        $factory_list = Factory::where('client_code',$users->client_code)->orderBy('factory_name','asc')->pluck('factory_name','id');
        $factory_con_list = FctoryContact::where('factory_id',$inspection->factory)->orderBy('factory_contact_person','asc')->pluck('factory_contact_person','id');
        //suppplier
        $supplier_list = Supplier::where('supplier_status','!=',2)->where('client_code',$client_code)->orderBy('supplier_name', 'asc')->pluck('supplier_name','id');
        $supplier_info = Supplier::where('id',$inspection->supplier_id)->first();
        $supplier_con_list = SupplierContact::where('supplier_id',$inspection->supplier_id)->orderBy('supplier_contact_person','asc')->pluck('supplier_contact_person','id');
        $supplier_con_info = SupplierContact::where('id',$inspection->supplier_contact_id)->first();
        //user
        $user_info = UserInfo::where('user_id',$client_id)->first();
        $user = User::where('id',Auth::id())->first();

        

        $suppData1 = DB::table('supplier_datas')->where('user_id', $user->id)->first();
        $supplierContact1 = DB::table('supplier_contacts')->where('supplier_id', $suppData1->supplier_id)->first();
        $suppliers1 = DB::table('suppliers')->where('id', $supplierContact1->supplier_id)->first();
        $suppFactory = DB::table('factories')->where('client_code', $suppliers1->client_code)
                    ->select('*')
                    ->get(); 

        
        
        //other
        $client_contact = ClientContact::where('client_code',$users->client_code)->orderBy('contact_person','asc')->pluck('contact_person','id');
        $contact_info = ClientContact::where('id',$inspection->contact_person)->first();
        $get_cc = ClientContact::where('id',$inspection->contact_person)->first();

        //client contacts
        $clientName1 = DB::table('clients')->where('id', $user->group_id)->first();
        $clientContact = DB::table('client_contacts')->where('client_code', $users->client_code)
                    ->select('*')
                    ->get(); 


       

        return view('pages.supplier.edit-project.index_loading',compact('role','user_info','client_id','client_code','client_contact','inspection','get_factory','get_fc','factory_con_list','factory_list','get_cc','user','supplier_list','supplier_con_list','supplier_info','supplier_con_info','sub_acc','privelege','supplierData','supplierInfo','suppFactory','clientName1'));
    }


    public function editLoadingInspectionSupplier(Request $request){
        $validator = Validator::make($request->all(), [
            'edit_inspection_id' => 'required',
            'loading_client' => 'required',
            'loading_contact_person' => 'required', 
            'loading_supplier' => 'required',
            'loading_supplier_contact_person' => 'required',
            'loading_factory' => 'required',
            'loading_factory_contact_person' => 'required',
            'loading_inspection_date' => 'required',
            'shipment_date' => 'required',
            'loading_service' => 'required',
            'loading_reference_number' => 'required',
            'client_project_number_cbpi' => 'required',
        ]);
        $supplierInfo = DB::table('supplier_datas')
        ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
        ->select('*','suppliers.id as supplierId')
        ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        if($validator->fails()) {
            return response()->json([
                'message' => 'Empty fields',
            ],500);
        }else{
            DB::beginTransaction();
            try{
                $auth_id=Auth::id();
                //get user type
                $user_data = User::where('id',Auth::id())->first();
                $user_type=null;
                if($user_data->user_type=='tic_sera'){
                    $user_type='tic_sera';
                }

                $eid=$request['edit_inspection_id'];
                $inspection = Inspection::find($eid);
                //inspection details
                $inspection->service = $request['loading_service'];
                $inspection->reference_number = $request['loading_reference_number'];
                $inspection->client_project_number = $request['client_project_number_cbpi'];
                $inspection->inspection_date = $request['loading_inspection_date'];
                $inspection->inspection_date_to = $request['loading_inspection_date_to'];
                $inspection->shipment_date = $request['shipment_date'];
                $inspection->factory_change_date = $request['loading_fac_change_date'];
                $inspection->client_id = $request['loading_client'];
                $inspection->contact_person = $request['loading_contact_person'];
                //supplier details
                $inspection->supplier_id = $request['loading_supplier'];
                $inspection->supplier_name = $supplierData->supplier_name;
                $inspection->supplier_contact_id = $request['loading_supplier_contact_person'];
                //factory details
                $inspection->factory = $request['loading_factory'];
                $inspection->factory_contact_person = $request['loading_factory_contact_person'];
                $inspection->factory_contact_person2 = $request['factory_contact_person2_cbpi'];

                
            
                $inspection->requirement = $request['loading_requirements'];
                $inspection->memo = $request['memo'];
                $inspection->inspector_id = 0;
                $inspection->secondary_inspector_id = $request['second_inspector'];
                $inspection->manday = 1;

                $loading_template=$request['loading_template'];
                if($loading_template=="" || $request['project_type_cbpi']=="word_project" || $request['project_type_cbpi']=="esprit"){$loading_template=0;}

                $report_template=$request['loading_report_template'];
                if($report_template=="" || $report_template=='N/A'){$report_template=null;}
                $report_template=null;
                $inspection->word_template = $report_template;

                $inspection->template_id = $loading_template;
                $inspection->project_type = $request['project_type_cbpi'];



                $inspection->inspection_status = "Client Pending";
                $inspection->client_book = "false";
                $inspection->client_book_id =  Auth::id();
                $inspection->created_by =  Auth::id();


                if($request['loading_invisible'] == "on"){
                    $inspection->Clientstatus = '1';
                }

                if ($inspection->save()) {
                    $inserted_inspection_id=$eid;

                    $upload_file_name=array();
                    $service = [
                        'iqi' => 'Incoming Quality Inspection',
                        'dupro' => 'During Production Inspection',
                        'psi' => 'Pre Shipment Inspection',
                        'cli' => 'Container Loading Inspection',
                        'cbpi' => 'CBPI - No Serial',
                        'physical' => 'Factory Audit',
		        		'detail' => 'Detail Audit',
                        'social' => 'Social Audit',
                        'st' => 'Sample Test'
                    ];
                    $get_attachment=Attachment::where('inspection_id',$eid)->get();
                    if($get_attachment){
                        $edit_dir="images/project2/".$eid."/"; 
                        foreach ($get_attachment as $att) {                   
                            array_push($upload_file_name,$edit_dir.$att->file_name); 
                        }
                    }
                    if($request->file('file')){
                        foreach ($request->file('file') as $file) {
                            $filename = $file->getClientOriginalName();
                            $filename=str_replace("#","_",$filename);
                            $dir="images/project2/".$eid."/";
                            //move the files to the correct folder
                            if (!File::exists($dir)) {
                                File::makeDirectory($dir);
                            }
                            //move the files to the correct folder
                            $file->move($dir,$filename);
                            //push file name in array
                            array_push($upload_file_name,$dir.$filename);

                            //save details to db
                            $doc= new Attachment();
                            $doc->inspection_id = $eid;
                            $doc->project_number = $request['loading_reference_number'];
                            $doc->file_name = $filename;
                            $doc->file_size = 2123121;
                            $doc->path = $dir.$filename;
                            $doc->save();
                        }
                    }

                    $client = Client::where('client_code',$request['loading_client'])->first();
                
                    $password = mt_rand(100000, 999999);
                    $get_report = Report::where('inspection_id',$eid)->first();
                    $report = Report::find($get_report->id);
                    $report->inspection_id = $inspection->id;
                    $report->client_code = $request['loading_client'];
                    $report->service = $request['loading_service'];
                    $report->inspection_date = $request['loading_inspection_date'];
                    $report->inspector_id = $request['loading_inspector'];
                    $report->report_no = $request['loading_reference_number'];
                    $report->password = $password;
                    $email_po_number="No PO #";
                    if ($report->save()) {
                        $client_info = UserInfo::find(Auth::id());
                        $factory = Factory::where('id',$request['loading_factory'])->first();
                        $factory_cont = FctoryContact::where('id',$request['loading_factory_contact_person'])->first();
                        $psi_product_list=null;
                        $data = ['report_number' =>  $request['loading_reference_number'],
                                'service'=>$service[$request['loading_service']],
                                'inspection_date'=>$request['loading_inspection_date'],
                                'inspection_date_to'=>$request['loading_inspection_date_to'],
                                'client_number'=>$request['client_project_number_cbpi'],
                                'c_name'=> $client->Company_Name,
                                'c_email'=> $client->Company_Email,
                                'client_info'=>$client_info,
                                'email_po_number'=>$email_po_number,
                                'factory'=>$factory,
                                'factory_cont'=>$factory_cont,
                                'file_passed'=>$upload_file_name,
                                'psi_product_list'=>$psi_product_list,
                                'client_email'=>$client_info->email_address,
                                'dear_client'=>$client_info->name,
                                'requirement'=>$request['loading_requirements'],
                                'memo'=>$request['memo'],
                                'user_type'=>$user_type,
                                'auth_id' => $auth_id
                            ];
                            
                            Mail::send('email.edit_book_from_client',$data, function($message) use ($data){
                                
                                if($data['client_email']){
                                    $message->to($data['client_email'],$data['c_name']);
                                    $message->to($data['c_email'],$data['c_name']);
                                   //correct->checked
                                   
                                }else{
                                     $message->to('booking@t-i-c.asia','Booking');
                                }
                                // $message->bcc('booking@t-i-c.asia','Booking');
                                // $message->bcc('it-support@t-i-c.asia','IT Support');
		        				// $message->bcc('report@t-i-c.asia','Report');
                                // $message->bcc('gregor@t-i-c.asia','Gregor');
                                // $message->bcc('gregor.voege@web.de');
                                // if($data['user_type']=='tic_sera'){
                                //     $message->bcc('aarreola@sera.com.mx','Aarreola');    
                                //     $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                //     $message->bcc('coordination@sera.com.mx','Coordination');    
                                //     if($data['auth_id']=='904' || $data['auth_id']==904){
                                //         $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                //         $message->bcc('sera.asiaop@outlook.com','SeraAsiaop');
                                //         $message->bcc('aarreola.sera@gmail.com','AarreolaSera');
                                //     }
                                // }else{
                                //      $message->bcc('1249484103@qq.com');                             
                                //     $message->bcc('2891400188@qq.com');
                                // }
                                $message->subject("Supplier-".$data['client_number']);  
                                /* remove attachment 08/01/2020*/   
                                /* if($data['file_passed']){ 
                                    foreach ($data['file_passed'] as $file_name) {
                                        $message->attach($file_name);
                                    }     
                                }   */                                      
                            });              
                         if (count(Mail::failures()) > 0) {
                             DB::rollback();
                             return response()->json([
                                 'message' => 'error',
                             ],500);
                         return('success');         
                         }else{
                            DB::commit();
                            return response()->json([
                                'message' => 'OK',
                            ],200);
                        }
                    }
                }
            }catch (Exception $e) {
                DB::rollback();
                 return response()->json([
                    'message'=>$e->getMessage()
                ],500);
            }
        }
    }


    public function geClientContactListSupplier($id){
        $count=0;
        $count = ClientContact::where('client_code','=',$id)->count();
        if($count>0){
        $ClientContact = ClientContact::where('client_code',$id)->first();
        $ClientContactList = ClientContact::where('client_code',$id)->whereNotIn('client_contact_status',[1,2])->get();
        return response()->json([
            'client_contact_list' => $ClientContactList,
            'contact_client_id' => $ClientContact->id,
            'contact_person' => $ClientContact->contact_person,
            'contact_number' => $ClientContact->contact_number,
            'email_address' => $ClientContact->email_address
    	]);
        }else{
            return response()->json([
                'message' => 'Nodata',
            ]);

        }
        //$contacts = FctoryContact::where('factory_id',$id)->get();

    
    }
    public function getClientContactsSupplier($id){
        $contacts = ClientContact::where('client_code',$id)->get();
        return response()->json([
            'contacts' => $contacts
        ]);
    }

    public function clientSupplierAddNewContact(Request $request){
        $c_person = $request['contact_person'];
        $cc=$request['client_code'];
 
        $client = new ClientContact();
        $client->client_code = $request['client_code'];
        $client->contact_person = $request['contact_person'];
        $client->email_address = $request['contact_person_email'];
        $client->contact_number = $request['contact_person_number'];
        $client->tel_number = $request['contact_person_tel_number'];
        $client_skype= $request['client_skype'];
        $client_wechat = $request['client_wechat'];
        $client_whatsapp = $request['client_whatsapp'];
        $client_qqmail = $request['client_qqmail'];
        if($client_skype==""){ $client_skype="N/A"; }
        if($client_wechat==""){ $client_wechat="N/A"; }
        if($client_whatsapp==""){ $client_whatsapp="N/A"; }
        if($client_qqmail==""){ $client_qqmail="N/A";}
        $client->client_skype = $client_skype;
        $client->client_wechat = $client_wechat;
        $client->client_whatsapp = $client_whatsapp;
        $client->client_qqmail = $client_qqmail;
        $client->client_contact_status = 0;
        $client->save();
 
     }


     //Update Company Contact Detail
    public function clientSupplierUpdateContact(Request $request){
        $client_contact = ClientContact::where('id', $request->input('contact_id'));
        //$client = Client::where('client_id', Auth::id());
        $data = array(
			'contact_person' => $request->input('contact_person'),
			'contact_number' => $request->input('contact_person_number'),
			'tel_number' => $request->input('contact_person_tel_number'),
			'email_address' => $request->input('contact_person_email'),
			'client_skype' => $request->input('client_skype'),
			'client_wechat' => $request->input('client_wechat'),
			'client_whatsapp' => $request->input('client_whatsapp'),
			'report_notify' => $request->input('report_notify'),
			'client_qqmail' => $request->input('client_qqmail')
		);

        if ($client_contact->update($data)) {
            return response()->json([
                'client_contact' => $client_contact
            ],200);
        }
        
    }

    //Delete Inspection
	public function deletePSInspection($id){
        //return $id;
        $inspection = Inspection::find($id);
        $status="Deleted";
        $inspection->inspection_status = $status;
        if ($inspection->save()) {
            $group = User::where('id',Auth::id())->first();
            if($group->group_id){
                $group_id = $group->group_id;
            } else {
                $group_id = "";
            }
        }
    }

    //cancel PSI
    public function cancelPSInspection($id){
        $inspection = Inspection::find($id);
        $status="Cancelled";
        $inspection->inspection_status = $status;
        if ($inspection->save()) {
            $group = User::where('id',Auth::id())->first();
            if($group->group_id){
                $group_id = $group->group_id;
            } else {
                $group_id = "";
            }
            return response()->json([
                'message' => 'OK',
            ],200);
        }
    }
    //added by migz get psi details
    public function getPSInspectionDetails($id){
        $user_info = UserInfo::where('user_id',Auth::id())->first();
   
        $reference = Report::where('inspection_id',$id)->get();

        $inspection_new = DB::table('inspections')
                        ->where('id',$id)                    
                        ->first(); 

        $clients = Client::where('client_code',$inspection_new->client_id)->first();
        $factory = Factory::where('id',$inspection_new->factory)->first();
        $client_contact_list=array();
        $client_contact=explode(',',$inspection_new->contact_person);

        foreach($client_contact as $contact){
            $data = ClientContact::where('id',$contact)->first();
            array_push($client_contact_list,$data);
        }

        $factory_contact_list=array();
        $factory_contact=explode(',',$inspection_new->factory_contact_person2);
        foreach($factory_contact as $contact){
            $data = FctoryContact::where('id',$contact)->first();
            array_push($factory_contact_list,$data);
        }

        $factory_contact1 = FctoryContact::where('id',$inspection_new->factory_contact_person)->first();

        $psi_product = DB::table('p_s_i_products')
                    ->where('inspection_id',$id)
                    ->get(); 
        $products = DB::table('products')
                    ->get(); 
        $attachments =  DB::table('attachments')
                    ->where('inspection_id',$id) 
                    ->where('uploaded_by',null)                   
                    ->get(); 
        $supplier = [];
        $supplier_contacts = [];
        if(!empty($inspection_new)){
            $supplier = DB::table('suppliers')
                ->where('id',$inspection_new->supplier_id)                    
                ->get();
            $supplier_contacts =  DB::table('supplier_contacts')
            ->where('id',$inspection_new->supplier_contact_id)                    
            ->get();
        }

        return response()->json([
            'user_info' => $user_info,
            'inspection_new' => $inspection_new,
            'reference' => $reference,
            'clients'=> $clients,
            'attachments'=> $attachments,
            'client_contact_list'=>$client_contact_list,
            'factory'=>$factory,
            'factory_contact_list'=>$factory_contact_list,
            'factory_contact1'=>$factory_contact1,
            'psi_product'=>$psi_product,
            'products'=>$products,
            'supplier'=>$supplier,
            'supplier_contacts'=>$supplier_contacts
        ]);
    }
    //added by migz
    public function getSupplierTrackInspectionDashboard($id){
        $supplierInfo = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
            ->where('role_user.user_id',Auth::id())->first();
            
        $user_info = UserInfo::where('user_id',Auth::id())->first(); 
        $client_code=$user_info->client_code;
        $user = User::where('id',Auth::id())->first();
        $client = Client::where('client_code',$client_code)->first();
        $client_contact = ClientContact::where('client_code',$client_code)->get();

		return view('pages.supplier.trackInspection.index',compact('role','user_info','client_code','client','client_contact','user','id','supplierInfo','supplierData'));    	
    }

    //Rommel 03-30-2021//
    public function deleteSupplierAttachments(Request $request){
  
        $mrn_inspection_id = $request['mrn_inspection_id'];

        foreach($mrn_inspection_id as $mrn_id){
            $fileName = $request->input('file_name');
            $image_path = public_path()."/images/project2/".$mrn_id.'/'.$fileName;  // Value is not URL but directory file path
            unlink($image_path); 
        }
        
        $cond=['file_name'=>$request['file_name']];
        $del_att=DB::table('attachments')
            ->whereIn('inspection_id',$mrn_inspection_id)
            ->where($cond)->delete();
    }

    public function getSupplierRequestForm(){
        $supplierInfo = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
    	$user_info = UserInfo::where('user_id',Auth::id())->first();
    	return view('pages.supplier.requestApp.index',compact('user_info','supplierInfo','supplierData'));
    }

    // IOS Request Submit
	public function SupplierSubmitRequestForm(Request $request){
		$email_address = $request['email'];
		$name = $request['name'];
		
		if(!empty($email_address) && !empty($name)){
			$data = ['email' => $email_address,
					 'name' => $name	 
					];
			Mail::send('email.request_IOS_app',$data, function($message) use ($data){
				$message->to('it-support@t-i-c.asia','IT Support');
				// $message->to('lacaprommel11@gmail.com','Rommel Lacap');
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
    ///save product new order 04-13-2021
    public function saveSupplierProductNew(Request $request){
        $user = User::where('id',Auth::id())->first();
        $suppData1 = DB::table('supplier_datas')->where('user_id', $user->id)->first();
        $supplierContact1 = DB::table('supplier_contacts')->where('supplier_id', $suppData1->supplier_id)->first();
        $suppliers1 = DB::table('suppliers')->where('id', $supplierContact1->supplier_id)->first();
        $this->validate($request,array(
            'client_code' =>'required',
            'product_name' =>'required',
            'product_category'=>'required',
            'product_unit'=>'required'
        ));
        $product = new Product();
        $product->client_code = $request['client_code'];
        $product->supplier_id = $suppliers1->id;
        $product->product_name = $request['product_name'];
        $product->product_category = $request['product_category'];
        $product->product_sub_category = $request['product_sub_category'];
        $product->product_unit = $request['product_unit'];
        $product->product_number = $request['product_number'];

        $po_no = $request['po_no'];
        $model_no = $request['model_no'];
        $brand = $request['brand'];
        $additional_product_info = $request['additional_product_info'];
        $item_description = $request['item_desc'];

        if($po_no==""){$po_no="N/A";}
        if($model_no==""){$model_no="N/A";}
        if($brand==""){$brand="N/A";}
        if($additional_product_info==""){$additional_product_info="N/A";}
        if($item_description==""){$item_description="N/A";}

        $product->product_length = $request['prod_length'];
        $product->product_width = $request['prod_width'];
        $product->product_height = $request['prod_height'];
        $product->product_diameter = $request['prod_diameter'];
        $product->product_weight = $request['prod_weight'];

        $product->retail_length = $request['retail_length'];
        $product->retail_width = $request['retail_width'];
        $product->retail_height = $request['retail_height'];
        $product->retail_diameter = $request['retail_diameter'];
        $product->retail_weight = $request['retail_weight'];

        $product->inner_length = $request['inner_length'];
        $product->inner_width = $request['inner_width'];
        $product->inner_height = $request['inner_height'];
        $product->inner_diameter = $request['inner_diameter'];
        $product->inner_weight = $request['inner_weight'];

        $product->export_length = $request['export_length'];
        $product->export_width = $request['export_width'];
        $product->export_height = $request['export_height'];
        $product->export_diameter = $request['export_diameter'];
        $product->export_weight = $request['export_weight'];
        $product->export_max_weight_carton = $request['export_max_weight'];
        
        $product->grd = $request['grd'];

        $product->po_no = $po_no;
        $product->model_no = $model_no;
        $product->brand = $brand;
        $product->additional_product_info = $additional_product_info;
        $product->item_description = $item_description;
        $product->save();
        
        $group = User::where('id',Auth::id())->first();
        if($group->group_id){
            $group_id = $group->group_id;
        } else {
            $group_id = "";
        }
        // \LogActivity::addToLog('product',$product->id,'add',$group_id, 'Added new product: ' . $request['product_name']);
       
        
        $clientcodedata=$request['client_code'];
       
        $userId = Product::where('client_code', $clientcodedata)->max('id');
        

            DB::table('product_photos')
            ->where('user_id', $clientcodedata)
            ->where('product_id', 0)
            ->update(['product_id' => $userId]);

        if ($product->save()) {
            return response()->json([
                'product_id' => $product->id
            ],200);
        }
    }
    //migz get supplier product 04-13-2021
    public function getProductNew(Request $request){
        $product = Product::where('id',$request['product_id'])->first();
            return response()->json([ 
                'product' => $product
            ],200);
    }
    //get supplier product by code and id 04-13-2021
    public function getSupplierProductByCode($id){
        $user = User::where('id',Auth::id())->first();
        $suppData1 = DB::table('supplier_datas')->where('user_id', $user->id)->first();
        $supplierContact1 = DB::table('supplier_contacts')->where('supplier_id', $suppData1->supplier_id)->first();
        $suppliers1 = DB::table('suppliers')->where('id', $supplierContact1->supplier_id)->first();
        $products = Product::where('client_code',$id)
                            ->where('status',0)
                            ->where('supplier_id',$suppliers1->id)
                            ->orderBy('product_name', 'asc')->get();
        return response()->json([
            'products' => $products
        ]);
    }

    //added by rommel april 14, 2021 //
    public function getSupplierProductDashboard(){
        $services_client = [
            'iqi'=> 'Incoming Quality Inspection',
            'dupro'=> 'During Production Inspection',
            'psi'=> 'Pre Shipment Inspection',
            'cli'=> 'Container Loading Inspection',
            'cbpi' => 'CBPI - No Serial',
            'physical' => 'Factory Audit',
			'detail' => 'Detail Audit',
            'social' => 'Social Audit',
            'st' => 'Sample Test'
        ];

        $role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
            ->where('role_user.user_id',Auth::id())->first();
        
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
        $supplierInfo = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $client_code = $supplierData->client_code;

        $products = Product::where('client_code',$client_code)
                            ->where('supplier_id',$supplierData->id)
                            ->where('status',0)
                    ->get();

                    //product category    
        $p_category=array();

        $p_category=['Accessories / components'=>'Accessories / components'
        ,'Apparel'=>'Apparel'
        ,'Automotive Parts'=>'Automotive Parts'
        ,'Bag and case'=>'Bag and case'
        ,'Beauty / hairdressing and personal care appliance'=>'Beauty / hairdressing and personal care appliance'
        ,'Chemical Products'=>'Chemical Products'
        ,'Construction and Mechanical Products'=>'Construction and Mechanical Products'
        ,'Consumer Electronics'=>'Consumer Electronics'
        ,'Fans'=>'Fans'
        ,'Furniture'=>'Furniture'
        ,'Garden'=>'Garden'
        ,'Garment'=>'Garment'
        ,'Garment accessories'=>'Garment accessories'
        ,'Gifts and Promo Items'=>'Gifts and Promo Items'
        ,'Healthcare and Beauty'=>'Healthcare and Beauty'
        ,'Home Appliances'=>'Home Appliances'
        ,'Homeware'=>'Homeware'
        ,'Hometextile'=>'Hometextile'
        ,'Hotel Supplies'=>'Hotel Supplies'
        ,'Kitchen Appliances'=>'Kitchen Appliances'
        ,'Lighting'=>'Lighting'
        ,'Machinery Parts/Products'=>'Machinery Parts/Products'
        ,'Multimedia'=>'Multimedia'
        ,'Outdoor and Sports Products'=>'Outdoor and Sports Products'
        ,'Pet Products'=>'Pet Products'
        ,'Power tools'=>'Power tools'
        ,'Printing and Packaging'=>'Printing and Packaging'
        ,'Shoes'=>'Shoes'
        ,'Stationery and Luggage Products'=>'Stationery and Luggage Products'
        ,'Toys / Recreational Items'=>'Toys / Recreational Items'];
        $cat_arr=array();
        $p_categories  = SavedProductCategories::where('user_id',Auth::id())->get();
        foreach($p_categories as $cat){
            $p_category += [$cat->category => $cat->category];
        }
        ksort($p_category);
        $p_category += ['Others' => 'Others'];

        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();

		return view('pages.supplier.product.index',compact('role','user_info','client_code','products','user','p_category','sub_acc','privelege','new_post_client','new_post_client_sera','supplierData','supplierInfo'));    	
    }

    public function saveSupplierProduct(Request $request){
        DB::beginTransaction();
        $supplierInfo = DB::table('supplier_datas')
        ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
        ->select('*','suppliers.id as supplierId')
        ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $client_code = $supplierData->client_code;
        try {
            $this->validate($request,array(
                'client_code' =>'required',
                'product_name' =>'required',
                'product_category'=>'required',
                'product_unit'=>'required'
            ));
            $product = new Product();
            $product->client_code = $request['client_code'];
            $product->supplier_id = $supplierData->id;
            $product->product_name = $request['product_name'];
            $product->product_category = $request['product_category'];
            $product->product_sub_category = $request['product_sub_category'];
            $product->product_unit = $request['product_unit'];
            $product->product_number = $request['product_number'];

            $po_no = $request['po_no'];
            $model_no = $request['model_no'];
            $supplier_item_no = $request['supplier_item_no'];
            $brand = $request['brand'];
            $additional_product_info = $request['additional_product_info'];

            $product->product_length = $request['prod_length'];
            $product->product_width = $request['prod_width'];
            $product->product_height = $request['prod_height'];
            $product->product_diameter = $request['prod_diameter'];
            $product->product_weight = $request['prod_weight'];

            $product->retail_length = $request['retail_length'];
            $product->retail_width = $request['retail_width'];
            $product->retail_height = $request['retail_height'];
            $product->retail_diameter = $request['retail_diameter'];
            $product->retail_weight = $request['retail_weight'];
            $product->retail_box_qty = $request['retail_box_qty'];

            $product->inner_length = $request['inner_length'];
            $product->inner_width = $request['inner_width'];
            $product->inner_height = $request['inner_height'];
            $product->inner_diameter = $request['inner_diameter'];
            $product->inner_weight = $request['inner_weight'];
            $product->inner_box_qty = $request['inner_box_qty'];

            $product->export_length = $request['export_length'];
            $product->export_width = $request['export_width'];
            $product->export_height = $request['export_height'];
            $product->export_diameter = $request['export_diameter'];
            $product->export_weight = $request['export_weight'];
            $product->export_box_qty = $request['export_box_qty'];
            $product->export_max_weight_carton = $request['export_max_weight'];
            $product->export_cbm = $request['export_cbm'];

            $product->grd = $request['grd'];
            $product->item_description = $request['item_desc'];

            if($po_no==""){$po_no="N/A";}
            if($model_no==""){$model_no="N/A";}
            if($brand==""){$brand="N/A";}
            if($additional_product_info==""){$additional_product_info="N/A";}


            $product->po_no = $po_no;
            $product->model_no = $model_no;
            $product->supplier_item_no = $supplier_item_no;
            $product->brand = $brand;
            $product->additional_product_info = $additional_product_info;

            $product->save();
            $group = User::where('id',Auth::id())->first();
            if($group->group_id){
                $group_id = $group->group_id;
            } else {
                $group_id = "";
            }
            //\LogActivity::addToLog('product',$product->id,'add',$group_id, 'Added new product: ' . $request['product_name']);
            /* if ($product->save()) {
                return response()->json([
                    'product' => $product
                ],200);
            } */
            
            $clientcodedata=$client_code;
        
            $userId = Product::where('client_code', $clientcodedata)->max('id');

            
                DB::table('product_photos')
                ->where('user_id', $clientcodedata)
                ->where('product_id', 0)
                ->update(['product_id' => $userId]);

                DB::commit();
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function updateSupplierProduct(Request $request){
        DB::beginTransaction();
        try {
            $product = Product::find($request['product_id']);
            $product->product_name = $request['product_name'];
            $product->product_category = $request['product_category'];
            $product->product_sub_category = $request['product_sub_category'];
            $product->product_unit = $request['product_unit'];
            $product->product_number = $request['product_number'];
            
            $po_no = $request['po_no'];
            $model_no = $request['model_no'];
            $supplier_item_no = $request['supplier_item_no'];
            $brand = $request['brand'];
            $additional_product_info = $request['additional_product_info'];
            $item_description = $request['item_desc'];

            if($po_no==""){$po_no="N/A";}
            if($model_no==""){$model_no="N/A";}
            if($brand==""){$brand="N/A";}
            if($additional_product_info==""){$additional_product_info="N/A";}
            if($item_description==""){$item_description="N/A";}

            $product->product_length = $request['prod_length'];
            $product->product_width = $request['prod_width'];
            $product->product_height = $request['prod_height'];
            $product->product_diameter = $request['prod_diameter'];
            $product->product_weight = $request['prod_weight'];

            $product->retail_length = $request['retail_length'];
            $product->retail_width = $request['retail_width'];
            $product->retail_height = $request['retail_height'];
            $product->retail_diameter = $request['retail_diameter'];
            $product->retail_weight = $request['retail_weight'];
            $product->retail_box_qty = $request['retail_box_qty'];

            $product->inner_length = $request['inner_length'];
            $product->inner_width = $request['inner_width'];
            $product->inner_height = $request['inner_height'];
            $product->inner_diameter = $request['inner_diameter'];
            $product->inner_weight = $request['inner_weight'];
            $product->inner_box_qty = $request['inner_box_qty'];

            $product->export_length = $request['export_length'];
            $product->export_width = $request['export_width'];
            $product->export_height = $request['export_height'];
            $product->export_diameter = $request['export_diameter'];
            $product->export_weight = $request['export_weight'];
            $product->export_box_qty = $request['export_box_qty'];
            $product->export_max_weight_carton = $request['export_max_weight'];
            $product->export_cbm = $request['export_cbm'];
            
            $product->grd = $request['grd'];

            $product->po_no = $po_no;
            $product->model_no = $model_no;
            $product->supplier_item_no = $supplier_item_no;
            $product->brand = $brand;
            $product->additional_product_info = $additional_product_info;
            $product->item_description = $item_description;

            $product->save();
            $group = User::where('id',Auth::id())->first();
            if($group->group_id){
                $group_id = $group->group_id;
            } else {
                $group_id = "";
            }
            //pending inspection based on product
            $get_pending_inspection = DB::table('p_s_i_products')
                ->join('inspections', 'inspections.id', '=', 'p_s_i_products.inspection_id')
                ->select('inspections.id AS inspection_id','inspections.client_book','inspections.inspection_status','p_s_i_products.id AS psi_product_id')
                ->where('p_s_i_products.product_id',$request['product_id'])
                ->where(function($query){
                    $query->where('inspections.inspection_status','Client Pending')
                        ->orWhere('inspections.inspection_status','Pending')
                        ->orWhere('inspections.inspection_status','Hold');
                })
                ->get();
            if(!empty($get_pending_inspection)){
                foreach($get_pending_inspection as $gpi){
                    //updated psi product
                    $update_psi_product = PSIProduct::find($gpi->psi_product_id);
                    $update_psi_product->product_name = $request['product_name'];
                    $update_psi_product->product_category = $request['product_category'];
                    $update_psi_product->product_sub_category = $request['product_sub_category'];
                    $update_psi_product->product_unit = $request['product_unit'];
                    $update_psi_product->product_number = $request['product_number'];
                    $update_psi_product->product_length = $request['prod_length'];
                    $update_psi_product->product_width = $request['prod_width'];
                    $update_psi_product->product_height = $request['prod_height'];
                    $update_psi_product->product_diameter = $request['prod_diameter'];
                    $update_psi_product->product_weight = $request['prod_weight'];
                    $update_psi_product->retail_length = $request['retail_length'];
                    $update_psi_product->retail_width = $request['retail_width'];
                    $update_psi_product->retail_height = $request['retail_height'];
                    $update_psi_product->retail_diameter = $request['retail_diameter'];
                    $update_psi_product->retail_weight = $request['retail_weight'];
                    $update_psi_product->retail_box_qty = $request['retail_box_qty'];
                    $update_psi_product->inner_length = $request['inner_length'];
                    $update_psi_product->inner_width = $request['inner_width'];
                    $update_psi_product->inner_height = $request['inner_height'];
                    $update_psi_product->inner_diameter = $request['inner_diameter'];
                    $update_psi_product->inner_weight = $request['inner_weight'];
                    $update_psi_product->inner_box_qty = $request['inner_box_qty'];
                    $update_psi_product->export_length = $request['export_length'];
                    $update_psi_product->export_width = $request['export_width'];
                    $update_psi_product->export_height = $request['export_height'];
                    $update_psi_product->export_diameter = $request['export_diameter'];
                    $update_psi_product->export_weight = $request['export_weight'];
                    $update_psi_product->export_box_qty = $request['export_box_qty'];
                    $update_psi_product->export_max_weight_carton = $request['export_max_weight'];
                    $update_psi_product->export_cbm = $request['export_cbm'];
                    $update_psi_product->grd = $request['grd'];
                    $update_psi_product->po_no = $po_no;
                    $update_psi_product->model_no = $model_no;
                    $update_psi_product->supplier_item_no = $supplier_item_no;
                    $update_psi_product->brand = $brand;
                    $update_psi_product->additional_product_info = $additional_product_info;
                    $update_psi_product->item_description = $item_description;
                    $update_psi_product->save();
                }
            }

            //log
            //\LogActivity::addToLog('product',$product->id,'edit',$group_id, 'Updated product: ' . $request['product_name']);
            //LogActivity::addToLog('product',$product->id,'edit', 'Test Subject');
            /*  if ($product->save()) {
                return response()->json([
                    'product' => $product
                ],200);
            } */
            $clientcodedata=$request['client_code'];
            $userId=$request['product_id'];
            DB::table('product_photos')
            ->where('user_id', $clientcodedata)
            ->where('product_id', 0)
            ->update(['product_id' => $userId]);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function copySupplierProduct(Request $request){
        DB::beginTransaction();
            $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
            $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
            try {
                $productId;
                $product = new Product();
                $product->client_code = $request['client_code'];
                $product->supplier_id = $supplierData->id;
                $product->product_name = $request['product_name'];
                $product->product_category = $request['product_category'];
                $product->product_sub_category = $request['product_sub_category'];
                $product->product_unit = $request['product_unit'];
                $product->product_number = $request['product_number'];

                $po_no = $request['po_no'];
                $model_no = $request['model_no'];
                $supplier_item_no = $request['supplier_item_no'];
                $brand = $request['brand'];
                $additional_product_info = $request['additional_product_info'];

                if($po_no==""){$po_no="N/A";}
                if($model_no==""){$model_no="N/A";}
                if($brand==""){$brand="N/A";}
                if($additional_product_info==""){$additional_product_info="N/A";}
                $product->product_length = $request['prod_length'];
                $product->product_width = $request['prod_width'];
                $product->product_height = $request['prod_height'];
                $product->product_diameter = $request['prod_diameter'];
                $product->product_weight = $request['prod_weight'];

                $product->retail_length = $request['retail_length'];
                $product->retail_width = $request['retail_width'];
                $product->retail_height = $request['retail_height'];
                $product->retail_diameter = $request['retail_diameter'];
                $product->retail_weight = $request['retail_weight'];
                $product->retail_box_qty = $request['retail_box_qty'];

                $product->inner_length = $request['inner_length'];
                $product->inner_width = $request['inner_width'];
                $product->inner_height = $request['inner_height'];
                $product->inner_diameter = $request['inner_diameter'];
                $product->inner_weight = $request['inner_weight'];
                $product->inner_box_qty = $request['inner_box_qty'];

                $product->export_length = $request['export_length'];
                $product->export_width = $request['export_width'];
                $product->export_height = $request['export_height'];
                $product->export_diameter = $request['export_diameter'];
                $product->export_weight = $request['export_weight'];
                $product->export_box_qty = $request['export_box_qty'];
                $product->export_max_weight_carton = $request['export_max_weight'];
                $product->export_cbm = $request['export_cbm'];
        
                $product->grd = $request['grd'];
                $product->item_description = $request['item_desc'];

                $product->po_no = $po_no;
                $product->model_no = $model_no;
                $product->supplier_item_no = $supplier_item_no;
                $product->brand = $brand;
                $product->additional_product_info = $additional_product_info;
                $product->save();

                $clientcodedata=$request['client_code'];
       
                $productId = Product::where('client_code', $clientcodedata)->max('id');
        

                $id= $request['product_id'];

                $product=DB::table('product_photos')
                    ->where('product_id', $id)->get();
                $pieces; 
                foreach ($product as  $value) {
                    $tempDir ='js/dropzone/'.$value->file_path;
                    $tmpFileName=$value->file_name;
                
                    $photo_category='PS';
                    $user_id='GVG';    
                    $pieces = explode(".", $tmpFileName);
                    $tmp1=$pieces[0];
                
                
                    $file_copy=$tempDir.''.$tmpFileName;
                    $new_dir=$tempDir;
                    if (!File::exists($new_dir)) {
                        File::makeDirectory($new_dir);
                    }

                    File::copy($file_copy,$new_dir.''.$pieces[0].'-TIC-copy('.$productId.').'.''.$pieces[1]);

                    $newFilenameTmp=$pieces[0].'-TIC-copy('.$productId.').'.''.$pieces[1];
                    $productSave = new productphotos();
                    $productSave->user_id=$value->user_id;
                    $productSave->product_id=$productId;
                    $productSave->file_name=$newFilenameTmp;
                    $productSave->file_path=$value->file_path;
                    $productSave->file_type=$value->file_type;
                    $productSave->photo_category=$value->photo_category;
                    $productSave->file_size=$value->file_size;
                    $productSave->save();
                }   
                DB::table('product_photos')
                ->where('user_id', $clientcodedata)
                ->where('product_id', 0)
                ->update(['product_id' => $productId]);
                // return count($a);
                DB::commit();
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
        
    }

    public function deleteSupplierProduct(Request $request){
        $product = Product::find($request['id']);
        $product->status = 2;
        if ($product->save()) {
            $group = User::where('id',Auth::id())->first();
            if($group->group_id){
                $group_id = $group->group_id;
            } else {
                $group_id = "";
            }
        }
    }

    public function saveSupplierNewProductCategory(Request $request){
        if($request['req']=='save_category'){
            $new_category = new SavedProductCategories();
            $new_category->user_id = $request['user_id'];
            $new_category->category = $request['category'];
            if ($new_category->save()) {
                $new_sub_category = new SavedProductSubCategories();
                $new_sub_category->user_id = $request['user_id'];
                $new_sub_category->category_id = $new_category->id;
                $new_sub_category->category = $request['category'];
                $new_sub_category->sub_category = $request['sub_category'];
                if ($new_sub_category->save()) {
                    return response()->json([
                        'id' => $new_category->id,
                    ]);
                }
            }
        }else{
            $new_sub_category = new SavedProductSubCategories();
            $new_sub_category->user_id = $request['user_id'];
            $new_sub_category->category_id = 0;
            $new_sub_category->category = $request['category'];
            $new_sub_category->sub_category = $request['sub_category'];
            if ($new_sub_category->save()) {
                return response()->json([
                    'message' => 'ok',
                ]);
            }
        }
    }

    public function getSupplierSavedProductSubCategory(Request $request){
        $auth_id=Auth::id();
        $id=$request['id'];
        $pcid  = Category::where('name',$id)->first();
        $orig_sub_categories="";
        if($pcid){
            $orig_sub_categories  = SubCategory::where('category_id',$pcid->id)->get();
        }
        
        $saved_sub_categories  = SavedProductSubCategories::where('category',$id)->where('user_id',$auth_id)->get();
        return response()->json([
            'sub_categories' => $saved_sub_categories,
            'orig_sub_categories' => $orig_sub_categories
        ]);
    }

    public function getSupplierSavedProductCategory($id){
        $p_categories  = SavedProductCategories::where('user_id',$id)->get();
        return response()->json([
            'categories' => $p_categories
        ]);
    }

    //Added By Rommel April 15, 2021 //
    public function getDashboardSupplierReports(){
        $supplierInfo = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
         $role = User::where('id',Auth::id())->first();
         
         if($role->category == 'supplier'){
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
             $user = User::where('id',$supplierData->id)->first();
             
             $inspections = DB::table('inspections')
                 ->select('inspections.id','inspections.client_id','inspections.reference_number','inspections.client_project_number','inspections.inspection_status','inspections.created_at','inspections.updated_at','inspections.service')
                 ->where('inspections.supplier_id',$supplierData->id)
                 ->where('inspections.inspection_status','!=','Deleted')
                 ->get();
             
             return view('pages.supplier.reportsPage.index',compact('inspections','user_info','user','sub_acc','privelege','supplierData','supplierInfo'));   
         } else {
             return redirect()->route('supplier-reports');
         }
     }
     public function getPrivilegesSupplier(){
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $supplierInfo = DB::table('supplier_datas')
        ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
        ->select('*','suppliers.id as supplierId')
        ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();

        return view ('new-partials.supplier._leftbar',compact('supplierInfo','supplierData','user_info'));
     }

     public function getOneAccountEmail($id){
        $account = UserInfo::where('user_id',$id)->first();
        $user = User::where('email',$account->email_address)->first();
        $supplierInfo = SupplierData::where('user_id',$account->id)->first();
        $supplierInformation = DB::table('supplier_datas')
                            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
                            ->select('*','suppliers.id as supplierId')
                            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        return response()->json([
            'account' => $account,
            'user' => $user,
            'supplierInfo' => $supplierInfo,
            'supplierInformation' => $supplierInformation,
            'supplierData' => $supplierData,
        ]);
    }

    //Added By Rommel April 16, 2021 //
    public function updateSupplierAccountEmail(Request $request){
       $supplierInformation = SupplierData::find($request['id_email']);
       $supplierInformation->email_reciever = $request['email_reciever'];
       $supplierInformation->no_email = $request['no_email'];
       $supplierInformation->update();
   }

   public function updateSupplierAccountAccess(Request $request){
    $supplierInformation = SupplierData::find($request['id_access']);
    $supplierInformation->report_access = $request['report_access_update'];
    $supplierInformation->update();
    }

    public function updateSupplierAccountNoEmail(Request $request){
        $supplierInformation = SupplierData::find($request['id_noemail']);
        $supplierInformation->email_reciever = $request['email_reciever'];
        $supplierInformation->no_email = $request['no_email'];
        $supplierInformation->update();
    }

    //ADDED BY ROMMEL
    public function getOneProductSupplier($id){
        $products = Product::where('id',$id)->where('status',0)->get();   
        return response()->json([
            'products' => $products,
        ]);
    }
    //04/28/2021
    public function getOneSupplierContactClient($id){
        $supplier = Supplier::find($id);
        $contacts = ClientContact::where('client_code',$supplier->client_code)->where('client_contact_status',0)->get();   
        return response()->json([
            'supplier' => $supplier,
            'contacts' => $contacts,
        ]);
    }

    public function getOneSupplierClientContact($id){
        $contacts = ClientContact::where('id',$id)->first();  
            if(User::select('email')->where('email',$contacts->email_address)->first()){
                //return response()->json("Email Address Already registered",400);
                return response()->json([
                    'message' => "Email Address Already Registred As A User, Please Edit Email Address Of Client Contact or Add New Contact Client Contact Person"
                ],400);
            }else{
                return response()->json([
                    'contacts' => $contacts,
                ]);
            }
    }

    public function getOneSupplierClientContactUpdate($id){
        $contacts = ClientContact::where('id',$id)->first();  
            if(User::select('email')->where('email',$contacts->email_address)->first()){
                //return response()->json("Email Address Already registered",400);
                return response()->json([
                    'message' => "Email Address Already Registred As A User, Please Edit Email Address Of Client Contact or Add New Contact Client Contact Person"
                ],400);
            }else{
                return response()->json([
                    'contacts' => $contacts,
                ]);
        }
    }

}
