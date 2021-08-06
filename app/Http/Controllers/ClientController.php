<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Client;
use Carbon\Carbon;
use App\PSIProduct;
use App\User;
use App\Factory;
use App\Supplier;
use App\UserInfo;
use App\ClientContact;
use App\Inspection;
use App\SubAccountPrivelege;
use Illuminate\Support\Facades\DB;
use Session;
use Mail;

class ClientController extends Controller {
    
    public function getClientSupplier(Request $request){
      $supplier_id = $request['supplier'];

      $supplier = DB::table('suppliers')
                    ->join('supplier_contacts','supplier_contacts.supplier_id','=','suppliers.id')
                    ->join('countries','countries.id','=','suppliers.supplier_country')
                    ->where('suppliers.id',$supplier_id)
                    ->get();
        return  $supplier;
    }
    public function getStatDashboard(Request $request){
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
        $supplier_id = $request['supplier'];
        
            
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

        if($user_info->designation == 'client'){
            $group = User::select('group_id')->where('id',Auth::id())->first();
            $role="";
            $cancelled="";
            $sub_acc="no";
         	$privelege="";
            if(!empty($group->group_id)){
                //return 'dev';
                $role = User::where('id',$group->group_id)->first(); 
                $sub_acc="yes";
		        $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
            } else {            
                $role = User::where('id',Auth::id())->first();
                $sub_acc="no";
            }

            //$role = User::where('id',$group->group_id)->first();
            
            //return $role->client_code;
            $clients = Client::where('client_code','!=','000')->orderBy('id','desc')->get();
            $new_client_count = DB::table('clients')->join('users','users.id','=','clients.user_id')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
            $ccode = DB::table('clients')->where('user_id',Auth::id())->first();
           $new_post_client = Inspection::where('inspection_type',null)
                                    ->where('inspection_status','Client Pending')
                                    ->where('supplier_book','true')
                                    ->where('client_id',$ccode->client_code)
                                    ->count();
            
            $factories = Factory::where('client_code',$role->client_code)->select('id','factory_name')->orderBy('factory_name','desc')->get();
            $suppliers = Supplier::where('client_code',$role->client_code)->select('id','supplier_name','supplier_number')->groupBy('supplier_number')->orderBy('supplier_number','desc')->get();
        
            if($start_date || $supplier_id){
                if($supplier_id && empty($start_date)){
                    $inspection_count = Inspection::where('client_id',$role->client_code)
                    ->where('supplier_id',$supplier_id)
                    ->where('inspection_status','!=','Deleted')
                    ->get()
                    ->count();
                    
                    $inspection_accepted = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Shipment Accepted')
                        ->get()
                        ->count();
                    
                    $inspection_rejected = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Shipment Rejected')
                        ->get()
                        ->count();
                    
                    $inspection_released = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Released')
                        ->get()
                        ->count();
                    
                    $inspection_report_released = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Report Released')
                        ->get()
                        ->count();
                    
                    $inspection_hold = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Hold')
                        ->get()
                        ->count();
                    
                    $inspection_cancelled = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Cancelled')
                        ->get()
                        ->count();
                    
                    $inspection_pending = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Pending')
                        ->get()
                        ->count();
					
					
                    $inspection_client_pending = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Client Pending')
                        ->get()
                        ->count();
                    
                    $inspection_client_pass = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('report_status','Pass')
                        ->get()
                        ->count();
                    
                    $inspection_client_failed = Inspection::where('client_id',$role->client_code)
                        ->where('supplier_id',$supplier_id)
                        ->where('report_status','Failed')
                        ->get()
                        ->count();
                    
                } else if($start_date && empty($supplier_id)){
                    $inspection_count = Inspection::where('client_id',$role->client_code)
                        ->where('inspection_status','!=','Deleted')
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->get()
                        ->count();
                    $inspection_accepted = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Shipment Accepted')
                        ->get()
                        ->count();
                    
                    $inspection_rejected = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Shipment Rejected')
                        ->get()
                        ->count();
                    
                    $inspection_released = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Released')
                        ->get()
                        ->count();
                    
                    $inspection_report_released = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Report Released')
                        ->get()
                        ->count();
                    
                    
                    $inspection_hold = Inspection::where('client_id',$role->client_code)
                        ->where('inspection_status','Hold')
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->get()
                        ->count();
                    
                    $inspection_cancelled = Inspection::where('client_id',$role->client_code)
                        ->where('inspection_status','Cancelled')
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->get()
                        ->count();
                    
                    $inspection_pending = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Pending')
                        ->get()->count();
                    
                    $inspection_client_pending = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('inspection_status','Client Pending')
                        ->get()
                        ->count();
					
					$inspection_client_pass = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('report_status','Pass')
                        ->get()
                        ->count();
                    
					$inspection_client_failed = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('report_status','Failed')
                        ->get()
                        ->count();
					
                } else if($start_date && $supplier_id){
                    $inspection_count = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','!=','Deleted')
                        ->get()
                        ->count();
                    
                    $inspection_accepted = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Shipment Accepted')
                        ->get()
                        ->count();
                    
                    $inspection_rejected = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('supplier_id',$supplier_id)
                        ->where('inspection_status','Shipment Rejected')
                        ->get()
                        ->count();
                    
                    
                    
                    $inspection_released = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('supplier_id',$supplier_id)
                        ->where(function($query){
                        $query->where('inspection_status', 'Released')
                            ->orWhere('inspection_status', 'Report Released');
                        })
                        ->get()
                        ->count();
                    
                    $inspection_cancelled = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where(function($query){
                        $query->where('inspection_status', 'Hold')
                            ->orWhere('inspection_status', 'Cancelled');
                        })
                        ->get()
                        ->count();
                    
                    $inspection_pending = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('supplier_id',$supplier_id)
                        ->where(function($query){
                            $query->where('inspection_status', 'Pending')
                            ->orWhere('inspection_status', 'Client Pending');
                        })
                        ->get()->count();

					
					$inspection_client_pass = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('supplier_id',$supplier_id)
                        ->where('report_status','Pass')
                        ->get()
                        ->count();
					
					$inspection_client_failed = Inspection::where('client_id',$role->client_code)
                        ->whereBetween('inspection_date', [$start_date, $end_date])
                        ->where('supplier_id',$supplier_id)
                        ->where('report_status','Failed')
                        ->get()
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
                    ->where('client_id',$role->client_code)
                    //->whereMonth('created_at', $date)
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->get();

            
           
                
                

                $test = response()->json($inspections_chart);
                
                $released = $inspection_released;
                $cancelled = $inspection_cancelled;
                $pending = $inspection_pending;
                
                return response()->json([
                    'inspection_count' => $inspection_count,
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
                    ->where('client_id',$role->client_code)
                    //->whereMonth('created_at', $date)
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->get();
           
        
                $inspection_count = Inspection::where('client_id',$role->client_code)
                    ->whereBetween('inspection_date', [$start_date, $end_date])
                    ->where('inspection_status','!=','Deleted')
                    ->get()
                    ->count();
                $inspection_accepted = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Shipment Accepted')->get()->count();
                $inspection_rejected = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Shipment Rejected')->get()->count();
                
                $inspection_released = Inspection::where('client_id',$role->client_code)
                    ->whereBetween('inspection_date', [$start_date, $end_date])
                    ->where(function($query){
                        $query->where('inspection_status', 'Released')
                            ->orWhere('inspection_status', 'Report Released');
                    })
                    ->get()
                    ->count();
                
                $inspection_hold = Inspection::where('client_id',$role->client_code)
                    ->whereBetween('inspection_date', [$start_date, $end_date])
                    ->where(function($query){
                        $query->where('inspection_status', 'Hold')
                            ->orWhere('inspection_status', 'Cancelled');
                    })
                    ->get()
                    ->count();

                
                $inspection_pending = Inspection::where('client_id',$role->client_code)
                    ->whereBetween('inspection_date', [$start_date, $end_date])
                    ->where(function($query){
                        $query->where('inspection_status', 'Pending')
                            ->orWhere('inspection_status', 'Client Pending');
                    })
                    ->get()
                    ->count();
				
				
                $inspection_client_pass = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('report_status','Pass')->get()->count();
                $inspection_client_failed = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('report_status','Failed')->get()->count();
				
                
                $psiproduct = PSIProduct::all();
                $test = response()->json($inspections_chart);
                
                $released = $inspection_released;
                $cancelled = $inspection_hold;
                $pending = $inspection_pending;
                
            }
        
            return view('pages.client.statsDashboard.index',compact('clients','role','user_info','new_client_count','new_post_client','inspection_count','inspection_accepted','inspection_rejected','inspection_released','inspection_hold','inspection_pending','released','cancelled','pending','inspection_client_pass','inspection_client_failed','inspections','psiproduct','services','services_client','inspections_chart','test','sub_acc','privelege','factories','suppliers'));
            
        } else {
            return redirect()->route('login');
        }
    }
    
    public function stats(){
		if(!Auth::id()){ return redirect()->route('login'); }
		
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        return view('pages.client.stats.index', compact('user_info'));
    }
	
	public function statsDev(){
		if(!Auth::id()){ return redirect()->route('login'); }
		
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        return view('pages.client.stats.index-dev', compact('user_info'));
    }
    
    public function statsData(Request $request){
        $now = Carbon::now();
		
		
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $select_month = $request->month;
        
        $user_id = Auth::id();
        
        $user_info = DB::table('users')->select('client_code')->where('id',$user_id)->first();

		$daily = [];
        $i = 1;
		if($start_date){
			$date = new Carbon($start_date);
		} else if($select_month){
			$date = new Carbon("2021-$select_month-01");
		} else {
			//$ranges = array('January','February','March','April','May','June','July','August','September','October','November','December');
			$date = Carbon::now();
		}
		
		for($max=$date->daysInMonth; $i<=$max; $i++){
            $daily[] = $i;
        }
		
        $ranges = $daily;
        $data = [];
        
        foreach($ranges as $range){
			$month = date("m", strtotime($date));
			$year = date("Y", strtotime($date));
			$month_name = date("M", strtotime($date));
			$nrange = $range;
            
            $reports = DB::table('report_uploads')
				->select('report_uploads.report_status')
				->leftJoin('inspections','report_uploads.inspection_id','=','inspections.id')
                ->where('report_uploads.client_code', $user_info->client_code)
                ->whereMonth('inspections.inspection_date', $month)
                ->whereDay('inspections.inspection_date', $nrange)
                ->whereYear('inspections.inspection_date', $year)
				//->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
                ->get();
            
            $all = $reports->count();
            $passed = $reports->where('report_status','Passed')->count();
            $failed = $reports->where('report_status','Failed')->count();
            $pending = $reports->where('report_status','Pending')->count();
            
			
			$data[] = ([
				'all' => $all,
                'passed' => $passed,
                'failed' => $failed,
                'pending' => $pending,
                'ranges' => "$month_name $range",
                'year' => "$year",
			]);
		}
		return response()->json([
			'data' => $data,
			'month' => $date->format('F')
		]);
    }
	
    
    public function getCharts($type){
		$today = Carbon::now()->isoFormat('YYYY-MM-DD hh:mm:ss');
		
		$months = array('January','February','March','April','May','June','July','August','September','October','November','December');
		
		$data = [];
		foreach($months as $month){
			$nmonth = date("m", strtotime($month));
            
                $active = DB::table('advertisements')->selectRaw('count(*) data')
                    ->where('status', 1)
                    ->whereMonth('start_date', $nmonth)
                    ->where('end_date','>', $today)
                    ->first();
		
                $inactive = DB::table('advertisements')->selectRaw('count(*) data')
                    ->whereMonth('start_date', $nmonth)          
					->where(function($query) use ($today) {
						$query->orWhere('status', 0)
							->orWhere('end_date','<', $today);
                	})
                    ->first();
			
			$data[] = ([
				'month' => $month,
				'active' => $active->data,
				'inactive' => $inactive->data,
			]);
		}
		return response()->json([
			'data' => $data
		]);
	}

    public function getStatDashboardTICSERA(Request $request){
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
        $supplier_id = $request['supplier'];
        
            
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

        if($user_info->designation == 'client'){
            $group = User::select('group_id')->where('id',Auth::id())->first();
            $role="";
            $cancelled="";
            $sub_acc="no";
         	$privelege="";
            if(!empty($group->group_id)){
                //return 'dev';
                $role = User::where('id',$group->group_id)->first(); 
                $sub_acc="yes";
		        $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
            } else {            
                $role = User::where('id',Auth::id())->first();
                $sub_acc="no";
            }

            //$role = User::where('id',$group->group_id)->first();
            
            //return $role->client_code;
            $clients = Client::where('client_code','!=','000')->orderBy('id','desc')->get();
            $new_client_count = DB::table('clients')->join('users','users.id','=','clients.user_id')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
            $ccode = DB::table('clients')->where('user_id',Auth::id())->first();
           $new_post_client = Inspection::where('inspection_type',null)
                                    ->where('inspection_status','Client Pending')
                                    ->where('supplier_book','true')
                                    ->where('client_id',$ccode->client_code)
                                    ->count();
            
            $factories = Factory::where('client_code',$role->client_code)->select('id','factory_name')->orderBy('factory_name','desc')->get();
            $suppliers = Supplier::where('client_code',$role->client_code)->select('id','supplier_name','supplier_number')->groupBy('supplier_number')->orderBy('supplier_number','desc')->get();
        
            if($start_date || $supplier_id){
                if($supplier_id && empty($start_date)){
                    $inspection_count = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->get()->count();
                    $inspection_accepted = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('inspection_status','Shipment Accepted')->get()->count();
                    $inspection_rejected = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('inspection_status','Shipment Rejected')->get()->count();
                    $inspection_released = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('inspection_status','Released')->get()->count();
                    $inspection_report_released = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('inspection_status','Report Released')->get()->count();
                    $inspection_hold = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('inspection_status','Hold')->get()->count();
                    $inspection_cancelled = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('inspection_status','Cancelled')->get()->count();
                    $inspection_pending = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('inspection_status','Pending')->get()->count();
					
					
                    $inspection_client_pending = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('inspection_status','Client Pending')->get()->count();
                    $inspection_client_pass = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('report_status','Pass')->get()->count();
                    $inspection_client_failed = Inspection::where('client_id',$role->client_code)->where('supplier_id',$supplier_id)->where('report_status','Failed')->get()->count();
                    
                } else if($start_date && empty($supplier_id)){
                    $inspection_count = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->get()->count();
                    $inspection_accepted = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Shipment Accepted')->get()->count();
                    $inspection_rejected = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Shipment Rejected')->get()->count();
                    $inspection_released = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Released')->get()->count();
                    $inspection_report_released = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Report Released')->get()->count();
                    
                    
                    $inspection_hold = Inspection::where('client_id',$role->client_code)->where('inspection_status','Hold')->whereBetween('inspection_date', [$start_date, $end_date])->get()->count();
                    $inspection_cancelled = Inspection::where('client_id',$role->client_code)->where('inspection_status','Cancelled')->whereBetween('inspection_date', [$start_date, $end_date])->get()->count();
                    
                    $inspection_pending = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Pending')->get()->count();
                    
                    $inspection_client_pending = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Client Pending')->get()->count();
					
					$inspection_client_pass = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('report_status','Pass')->get()->count();
					$inspection_client_failed = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('report_status','Failed')->get()->count();
					
                } else if($start_date && $supplier_id){
                    $inspection_count = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->get()->count();
                    $inspection_accepted = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->where('inspection_status','Shipment Accepted')->get()->count();
                    $inspection_rejected = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->where('inspection_status','Shipment Rejected')->get()->count();
                    $inspection_released = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->where('inspection_status','Released')->get()->count();
                    $inspection_report_released = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->where('inspection_status','Report Released')->get()->count();
                    $inspection_hold = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->where('inspection_status','Hold')->get()->count();
                    $inspection_cancelled = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Cancelled')->get()->count();
                    $inspection_pending = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->where('inspection_status','Pending')->get()->count();
					
					
                    $inspection_client_pending = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->where('inspection_status','Client Pending')->get()->count();
					
					$inspection_client_pass = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->where('report_status','Pass')->get()->count();
					
					$inspection_client_failed = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('supplier_id',$supplier_id)->where('report_status','Failed')->get()->count();
                }
                
                $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('inspections.client_id',$role->client_code)
                    ->where('inspections.inspection_status','!=','Deleted')
                    ->whereBetween('inspections.inspection_date', [$start_date, $end_date])
                    ->orderBy('inspections.created_at', 'desc')
                    ->get();
            
                $inspections_chart = DB::table('inspections')
                    ->select(DB::raw('count(id) as `count`'),DB::raw('month(created_at) as month'))
                    ->where('client_id',$role->client_code)
                    //->whereMonth('created_at', $date)
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->get();

            
           
                
                
                $psiproduct = PSIProduct::all();
                $test = response()->json($inspections_chart);
                
                $released = $inspection_released + $inspection_report_released;
                $cancelled = $inspection_hold + $inspection_cancelled;
                $pending = $inspection_pending + $inspection_client_pending;
                
                return response()->json([
                    'inspection_count' => $inspection_count,
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
                    ->where('inspections.client_id',$role->client_code)
                    ->where('inspections.inspection_status','!=','Deleted')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->limit(10)
                    ->get();
            
                $inspections_chart = DB::table('inspections')
                    ->select(DB::raw('count(id) as `count`'),DB::raw('month(created_at) as month'))
                    ->where('client_id',$role->client_code)
                    //->whereMonth('created_at', $date)
                    ->groupBy(DB::raw('MONTH(created_at)'))
                    ->get();
           
        
                $inspection_count = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->get()->count();
                $inspection_accepted = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Shipment Accepted')->get()->count();
                $inspection_rejected = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Shipment Rejected')->get()->count();
                $inspection_released = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Released')->get()->count();
                $inspection_report_released = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Report Released')->get()->count();
                
                $inspection_hold = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Hold')->get()->count();
                $inspection_cancelled = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Cancelled')->get()->count();
                
                $inspection_pending = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Pending')->get()->count();
				
                $inspection_client_pending = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('inspection_status','Client Pending')->get()->count();
				
                $inspection_client_pass = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('report_status','Pass')->get()->count();
                $inspection_client_failed = Inspection::where('client_id',$role->client_code)->whereBetween('inspection_date', [$start_date, $end_date])->where('report_status','Failed')->get()->count();
				
                
                $psiproduct = PSIProduct::all();
                $test = response()->json($inspections_chart);
                
                $released = $inspection_released + $inspection_report_released;
                $cancelled = $inspection_hold + $inspection_cancelled;
                $pending = $inspection_pending + $inspection_client_pending;
                
            }
        
            return view('pages.client.statsDashboard.index',compact('clients','role','user_info','new_client_count','new_post_client','inspection_count','inspection_accepted','inspection_rejected','inspection_released','inspection_hold','inspection_pending','released','cancelled','pending','inspection_client_pass','inspection_client_failed','inspections','psiproduct','services','services_client','inspections_chart','test','sub_acc','privelege','factories','suppliers'));
            
        } else {
            return redirect()->route('login');
        }
    }
    
    public function getClients(){
        $role = User::where('id',Auth::id())->first();
        // $clients = Client::where('client_code','!=','000')->orderBy('id','desc')->get();
        $new_client_count = DB::table('clients')->join('users','users.id','=','clients.user_id')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $ccode = DB::table('clients')->where('user_id',Auth::id())->first();
       $new_post_client = Inspection::where('inspection_type',null)
                                    ->where('inspection_status','Client Pending')
                                    // ->where('supplier_book','true')
                                    // ->where('client_id',$ccode->client_code)
                                    ->count();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $clients = DB::table('clients')
        ->leftJoin('users','users.client_code','=','clients.client_code')        
        ->select('clients.*','users.is_online')
        ->where('clients.client_code','!=','000')
        ->orderBy('clients.id','desc')->get();
        $sales = UserInfo::where('designation','sales')->where('status',0)->orderBy('name','asc')->get();
        // $sales_manager = UserInfo::where('designation','sales')->where('status',0)->where('user_id',$request['sales_manager'])->first();
    	return view('pages.admin.clients.index',compact('clients','role','user_info','new_client_count','new_post_client','sales'));
        
    }


    public function getNewClients(){
        $role = User::where('id',Auth::id())->first();
		
		
		$clients = DB::table('clients')
            //->join('clients','clients.client_code','=','users.client_code')
            ->join('users','users.id','=','clients.user_id')
            ->select('clients.*','users.status','users.is_online')
			->where('clients.client_code',['000'])
			->where('users.status','2')
			->orderBy('clients.id','desc')
            ->get();
		
		$new_client_count = DB::table('clients')
            ->join('users','users.id','=','clients.user_id')
            ->select('clients.*','users.status')
			->where('clients.client_code',['000'])
			->where('users.status','2')
			->count();
		
        //$clients = Client::orderBy('id','desc')->get();
        //$clients = Client::where('client_code',['000'])->get();
        //$new_client_count = Client::where('client_code','000')->count();
		
        $ccode = DB::table('clients')->where('user_id',Auth::id())->first();
       $new_post_client = Inspection::where('inspection_type',null)
                                    ->where('inspection_status','Client Pending')
                                    // ->where('supplier_book','true')
                                    // ->where('client_id',$ccode->client_code)
                                    ->count();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $sales = UserInfo::where('designation','sales')->where('status',0)->orderBy('name','asc')->get();
    	return view('pages.admin.newclients.index',compact('clients','role','user_info','new_client_count','new_post_client','sales'));
    }


    public function getOneClient($id){

        $client = Client::where('id',$id)->first();

        $sales_name = UserInfo::where('id',$client->sales_id)->first();

        if($client->sales_id == 0 || $client->sales_id == '' || $client->sales_id == null){
            $s_name = 'no data';
        }else{
            $s_name = $sales_name->name;
        }

        $sales = UserInfo::where('designation','sales')->where('status',0)->orderBy('name','asc')->get();

        
        $client_online = User::select('is_online')->where('client_code',$client->client_code)->first();
        
        if($client_online){
            $is_online = $client_online->is_online;
        } else {
            $is_online = 0;
        }
        
        
        
        $clientCOdeCount =0;
        $clientCOdeCount=$client->client_code;

        $count = ClientContact::where('client_code','=',$clientCOdeCount)->count();
        if($count>0){
            $ClientContact = ClientContact::where('client_code',$client->client_code)->first();
            $ClientContactList = ClientContact::where('client_code',$client->client_code)->whereNotIn('client_contact_status',[1,2])->get();
            return response()->json([
                'client_id' => $client->id,
                'is_online' => $is_online,
                'client_name' => $client->client_name,
                'client_code' => $client->client_code,
                'client_username' => $client->username,
                'client_password' => $client->string_password,
                'client_email' => $client->email,
                'Company_Name' => $client->Company_Name,
                'Company_Email' => $client->Company_Email,
                'Company_Website' => $client->Company_Website,
                'Company_Address' => $client->Company_Address,
                'Phone_number' => $client->Phone_number,
                'company_country_id' => $client->company_country_id,
                'company_state_id' => $client->company_state_id,
                'company_city_id' => $client->company_city_id,
                'company_country_name' => $client->company_country_name,
                'company_state_name' => $client->company_state_name,
                'company_city_name' => $client->company_city_name,
                'company_bldg_num' => $client->company_bldg_num,
                'street_number' => $client->company_street_num,
                'house_number' => $client->company_house_num,
                'zip_code' => $client->company_zip_code,
                'company_invoice_country_name' => $client->company_invoice_country_name,
                'company_invoice_state_name' => $client->company_invoice_state_name,
                'company_invoice_city_name' => $client->company_invoice_city_name,
                'company_invoice_country_id' => $client->company_invoice_country_id,
                'company_inv_bldg_num' => $client->company_inv_bldg_num,
                'company_invoice_state_id' => $client->company_invoice_state_id,
                'company_invoice_city_id' => $client->company_invoice_city_id,
                'company_inv_street_num' => $client->company_inv_street_num,
                'company_inv_house_num' => $client->company_inv_house_num,
                'company_inv_zip_code' => $client->company_inv_zip_code,
                'payment_term' => $client->payment_term,
                'special_term' => $client->special_term,
                'sales_id' => $client->sales_id, //06-11-2021
                'sales' => $sales,
                'sales_name' => $s_name,
                'related_by' => $client->related_by, //06-28-2021
                'others' => $client->others,
                'user_id' => $client->user_id,
                'client_contact_list' => $ClientContactList,
                'contact_client_id' => $ClientContact->id,
                'contact_person' => $ClientContact->contact_person,
                'contact_number' => $ClientContact->contact_number,
                'email_address' => $ClientContact->email_address,
    
               /*  'contact_person' => $client->contact_person,
                'email_address' => $client->email_address,
                'contact_number' => $client->contact_number, */
            ]);
        }else{

            return response()->json([
                'client_id' => $client->id,
                'is_online' => $is_online,
                'client_name' => $client->client_name,
                'client_code' => $client->client_code,
                'client_username' => $client->username,
                'client_password' => $client->string_password,
                'client_email' => $client->email,
                'Company_Name' => $client->Company_Name,
                'Company_Email' => $client->Company_Email,
                'Company_Website' => $client->Company_Website,
                'Company_Address' => $client->Company_Address,
                'Phone_number' => $client->Phone_number,
                'company_country_id' => $client->company_country_id,
                'company_state_id' => $client->company_state_id,
                'company_city_id' => $client->company_city_id,
                'company_country_name' => $client->company_invoice_country_name,
                'company_state_name' => $client->company_state_name,
                'company_city_name' => $client->company_city_name,
                'company_bldg_num' => $client->company_bldg_num,
                'street_number' => $client->company_street_num,
                'house_number' => $client->company_house_num,
                'zip_code' => $client->company_zip_code,
                'company_invoice_country_name' => $client->company_invoice_country_name,
                'company_invoice_state_name' => $client->company_invoice_state_name,
                'company_invoice_city_name' => $client->company_invoice_city_name,
                'company_invoice_country_id' => $client->company_invoice_country_id,
                'company_inv_bldg_num' => $client->company_inv_bldg_num,
                'company_invoice_state_id' => $client->company_invoice_state_id,
                'company_invoice_city_id' => $client->company_invoice_city_id,
                'company_inv_street_num' => $client->company_inv_street_num,
                'company_inv_house_num' => $client->company_inv_house_num,
                'company_inv_zip_code' => $client->company_inv_zip_code,
                'payment_term' => $client->payment_term,
                'special_term' => $client->special_term,
                'sales_id' => $client->sales_id, //06-11-2021
                'sales' => $sales,
                'sales_name' => $s_name,
                'related_by' => $client->related_by, //06-28-2021
                'others' => $client->others,
                   
               /*  'contact_person' => $client->contact_person,
                'email_address' => $client->email_address,
                'contact_number' => $client->contact_number, */
            ]);
        }
        
        //$contacts = FactoryContact::where('factory_id',$id)->get();

    	
    }

    public function addNewClient(Request $request){

        $this->validate($request,array(
            'client_code' => 'required|unique:clients',
        ));

        $client = new Client();
        $client->client_code = $request['client_code'];
        $client->client_name = $request['client_name'];
        /* $client->client_name = $request['client_name'];
        $client->username = $request['client_un'];
        $client->password = bcrypt($request['client_pass']);
        $client->string_password = $request['client_pass'];
        $client->email = $request['client_email']; */
        $client->Company_Name = $request['Company_Name'];
        /* $client->Company_Website = $request['Company_Website']; */
        $client->Company_Email = $request['Company_Email'];
        $client->Company_Address = $request['company_city_name'].' '. $request['company_state_name'] .' '. $request['company_country_name'];
        $client->company_country_name = $request['company_country_name'];
        $client->company_state_name = $request['company_state_name'];
        $client->company_city_name = $request['company_city_name'];
        $client->company_country_id = $request['company_country_id'];
        $client->company_state_id = $request['company_state_id'];
        $client->company_city_id = $request['company_city_id'];

        $client->company_bldg_num = $request['company_bldg_num'];
        
        $client->company_street_num = $request['street_number'];
        $client->company_house_num = $request['house_number'];
        $client->company_zip_code = $request['zip_code'];

        $client->company_inv_bldg_num = $request['company_inv_bldg_num'];
        $client->company_invoice_country_name = $request['company_invoice_country_name'];
        $client->company_invoice_state_name = $request['company_invoice_state_name'];
        $client->company_invoice_city_name = $request['company_invoice_city_name'];
        $client->company_invoice_country_id = $request['company_invoice_country_id'];
        $client->company_invoice_state_id = $request['company_invoice_state_id'];
        $client->company_invoice_city_id = $request['company_invoice_city_id'];
        $client->company_inv_street_num = $request['inv_street_number'];
        $client->company_inv_house_num = $request['inv_house_number'];
        $client->company_inv_zip_code = $request['inv_zip_code'];

        $client->Phone_number = $request['Phone_number'];
        $client->payment_term = $request['payment_terms'];
        $client->special_term = $request['special_terms'];
        $client->sales_id = $request['sales_manager']; //06-11-2021
        $client->related_by = $request['related_by'];
        $client->others = $request['others'];
        if ($client->save()) {
            Session::flash('success', 'You have successfuly added new client!');
            return redirect()->route('clients');
        }
    }

    public function addNewClientAJAX(Request $request){

        $this->validate($request,array(
            'client_code' => 'required|unique:clients',
        ));

        $client = new Client();
        $client->client_code = $request['client_code'];
        $client->client_name = $request['client_name'];

        if ($client->save()) {
            return response()->json([
                'client' => $client
            ]);
        }
    }

    public function deleteClient(Request $request){
    	/* $client = Client::find($request['client_id']);

    	if ($client->delete()) {
    		Session::flash('error', 'Client details has been deleted from the database!');
    		return redirect()->route('clients');
        } */
        
        $client = Client::find($request['client_id']);
        $client->client_status=2;
    	if ($client->save()) {
    		Session::flash('error', 'Client details has been deleted from the database!');
    		return redirect()->route('clients');
    	}
    }

    public function getallData(){
        //return "ok";
        $client = ClientContact::all();
        return response()->json([
            'clientContact' => $client
        ]);
        //return compact('clients');
    }



    public function updateNewClient(Request $request){
        //joemanuel
    	$clientCodeDataEntry = $request['client_code'];
    	$online_client = $request['online_client'];
        $count = Client::where('client_code','=',$clientCodeDataEntry)->count();
        $user_type=null;
        $msg_subject='Account Activated - TIC Online Booking';
        if($count<=0){
            $Clientdata = Client::where('id',$request['client_id'])->first();
            $users = User::where('id',$request['client_id'])->first();
            $client = Client::find($request['client_id']);

            $get_user_type = User::where('id',$client->user_id)->first();
            //user type
            if($get_user_type){
                $user_type=$get_user_type->user_type;
                if($user_type=='tic_sera'){
                    $msg_subject='Account Activated - TIC-SERA Online Booking';
                }
            }
            
            

            //$client_max_id = Client::max('id');
            $get_comp_name=$Clientdata->Company_Name;
            $first_character = substr($get_comp_name, 0, 1);
            $new_client_code=strtoupper($first_character)."".$request['client_id'];
            $clientcode=$new_client_code;

            $client->client_code = $clientcode;
            $client->payment_term = $request['payment_term'];
            $client->special_term = $request['special_terms'];
            $client->sales_id = $request['sales_manager'];
            $client->related_by = $request['related_by'];
            $client->others = $request['others'];

           
        
		$email=$Clientdata->Company_Email;
		$users_info = UserInfo::where('email_address',$email)->first();
        //$clientcode=$request['client_code'];
        
        DB::table('users')
            ->where('username', $email)
            ->update(['client_code' => $clientcode,'is_online' => $online_client]);

		DB::table('users')
			->where('username', $email)
            ->update(['status' => 1]);
            
            DB::table('user_infos')
			->where('email_address', $email)
			->update(['client_code' => $clientcode]);
            

		$client_name = $client->client_name;
		$email = $Clientdata->Company_Email;
		
    	if ($client->update()) {
			$user_gender = $users_info->user_gender;
			if($user_gender == 0){
				$gender_label = "Ms.";
			} else if($user_gender == 1) {
				$gender_label = "Mr.";
			} else if($user_gender == 2) {
				$gender_label = "Mrs.";
			}

            $data = ['email_address' => $email,
                    'full_name' => $client_name,
                    'user_gender' => $gender_label,
                    'user_type' => $user_type,
                    'msg_subject' => $msg_subject
                ];
                Mail::send('email.new_client_update_email',$data, function($message) use ($data){
                    $message->to($data['email_address']);
                    $message->bcc('it-support@t-i-c.asia');
                    $message->bcc('gregor@t-i-c.asia');             
                    $message->subject($data['msg_subject']);                                              
                });               

            if (count(Mail::failures()) > 0) {
                return response()->json([
                    'message' => 'error',
                ],500);
            }else{                     
                Session::flash('success', 'You have successfuly updated client code!');
                return redirect()->route('clients');
            }


    	
    	}
    }else{

        return response()->json([
            'message' => 'dupticateCode',
        ]);
    }
    }

    public function rejectClient(Request $request){
    	$client_id =$request['client_id'];
        $client_email =$request['client_email'];
        $delete_client=Client::where('id',$client_id);
        $delete_user=User::where('email',$client_email);
        $delete_user_info=UserInfo::where('email_address',$client_email);
        if($delete_client->delete() && $delete_user->delete() && $delete_user_info->delete()){
            
        }else{
            return response()->json([
                'message' => 'error',
            ],500);
        }
    }


    public function updateClient(Request $request){
    	$client = Client::find($request['client_id']);
    	$client->client_code = $request['client_code'];
        $client->client_name = $request['client_name'];
        $client->Company_Name = $request['Company_Name'];
        $client->Company_Email = $request['Company_Email'];
        $client->Phone_number = $request['Phone_number'];
        $client->payment_term = $request['payment_term'];
        $client->sales_id = $request['sales_manager']; //06-11-2021
        $client->related_by = $request['related_by']; //06-28-2021
        $client->others = $request['others'];

        $client->company_country_id = $request['company_country_id'];
        $client->company_state_id = $request['company_state_id'];
        $client->company_city_id = $request['company_city_id'];
        $client->company_country_name = $request['company_country_name'];
        $client->company_state_name = $request['company_state_name'];
        $client->company_city_name = $request['company_city_name'];

        $client->company_bldg_num = $request['update_bldg_number'];
        $client->company_inv_bldg_num = $request['update_inv_bldg_number'];


        $client->company_street_num = $request['street_number'];
        $client->company_house_num = $request['house_number'];
        $client->company_zip_code = $request['zip_code'];
        $client->company_invoice_country_id = $request['company_invoice_country_id'];
        $client->company_invoice_state_id = $request['company_invoice_state_id'];
        $client->company_invoice_city_id = $request['company_invoice_city_id'];
        $client->company_invoice_country_name = $request['company_invoice_country_name'];
        $client->company_invoice_state_name = $request['company_invoice_state_name'];
        $client->company_invoice_city_name = $request['company_invoice_city_name'];

        $client->company_inv_street_num = $request['update_inv_street_number'];
        $client->company_inv_house_num = $request['update_inv_house_number'];
        $client->company_inv_zip_code = $request['update_inv_zip_code'];
        
        $user = User::where('client_code',$client->client_code)->first();
        $user->is_online =  $request['online_client'];
        $user->save();


    	if ($client->update()) {
    		Session::flash('success', 'You have successfuly updated client details!');
    		return redirect()->route('clients');
    	}
    }

    public function getClientContacts($id){
        $clients = Client::orderBy('id','desc')->get();
        $client = Client::where('client_code',$id)->first();
        $contacts = ClientContact::where('client_code',$id)->get();
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        return view('pages.admin.clients.clientcontact',compact('contacts','role','user_info','client','clients'));
    }

    public function addNewContact(Request $request){
       /*  $this->validate($request,array(
            'client_code' => 'required',
            'contact_person' => 'required',
            'contact_person_email' =>'required',
            'contact_person_number' => 'required'
        ));
 */
        $c_person = $request['contact_person'];
        $cc=$request['client_code'];
        foreach ($c_person as $i => $value) {

            $client[$i] = new ClientContact();
            $client[$i]->client_code = $request['client_code'];
            $client[$i]->contact_person = $request['contact_person'][$i];
            $client[$i]->email_address = $request['contact_person_email'][$i];
            $client[$i]->contact_number = $request['contact_person_number'][$i];
            $client[$i]->tel_number = $request['contact_person_tel_number'][$i];


            $client_skype= $request['client_skype'][$i];
            $client_wechat = $request['client_wechat'][$i];
            $client_whatsapp = $request['client_whatsapp'][$i];
            $client_qqmail = $request['client_qqmail'][$i];

            if($client_skype==""){ $client_skype="N/A"; }
            if($client_wechat==""){ $client_wechat="N/A"; }
            if($client_whatsapp==""){ $client_whatsapp="N/A"; }
            if($client_qqmail==""){ $client_qqmail="N/A";}

            $client[$i]->client_skype = $client_skype;
            $client[$i]->client_wechat = $client_wechat;
            $client[$i]->client_whatsapp = $client_whatsapp;
            $client[$i]->client_qqmail = $client_qqmail;
            $client[$i]->client_contact_status = 0;
            $client[$i]->save();

        }
            Session::flash('success', 'You have successfuly added a new contact person!');
            return redirect()->route('clientcontacts',$cc);
       /*  $client = new ClientContact();
        $client->client_code = $request['client_code'];
        $client->contact_person = $request['contact_person'];
        $client->email_address = $request['contact_person_email'];
        $client->contact_number = $request['contact_person_number'];
        if ($client->save()) {
            Session::flash('success', 'You have successfuly added a new contact person!');
            return redirect()->route('clientcontacts',$client->client_code);
        } */

    }

    public function getOneContact($id){
            $contact = ClientContact::where('id',$id)->first();
            return response()->json([
                'id' => $contact->id,
                'client_code' => $contact->client_code,
                'contact_person' => $contact->contact_person,
                'email_address' => $contact->email_address,
                'contact_number' => $contact->contact_number,
            ]);
    }

    public function updateContact(Request $request){
        $this->validate($request,array(
            'contact_person' => 'required',
            'contact_person_email' =>'required',
            'contact_person_number' => 'required'
        ));

        $contact_id = $request['contact_id'];
        $client_code = $request['client_code'];

        foreach ($contact_id as $i => $value) {
            $client[$i] = ClientContact::where('id',$request['contact_id'][$i])->first();
            $client[$i]->contact_person = $request['contact_person'][$i];
            $client[$i]->email_address = $request['contact_person_email'][$i];
            $client[$i]->contact_number = $request['contact_person_number'][$i];
            $client[$i]->tel_number = $request['contact_person_tel_number'][$i];

            $client[$i]->client_skype = $request['client_skype'][$i];
            $client[$i]->client_wechat = $request['client_wechat'][$i];
            $client[$i]->client_whatsapp = $request['client_whatsapp'][$i];
            $client[$i]->client_qqmail = $request['client_qqmail'][$i];
            $client[$i]->save();
        }
        Session::flash('success', 'You have successfuly updated contact person details!');
        return redirect()->route('clientcontacts',$client_code);

    }

    public function deleteContact(Request $request){
        /* $contact = ClientContact::find($request['contact_id']);

        if ($contact->delete()) {
            Session::flash('error', 'Contact person has been deleted from the database!');
            return $request['contact_id'];
        } */

        $contact = ClientContact::find($request['contact_id']);
        $contact->client_contact_status=2;
        if ($contact->save()) {
            Session::flash('error', 'Contact person has been deleted from the database!');
            return $request['contact_id'];
        }
    }

    public function getNewDashboard(){
        $services = ['iqi'=>'Incoming Quality Inspection',
            'dupro' => 'During Production Inspection',
            'psi' => 'Pre Shipment Inspection',
            'cli' => 'Container Loading Inspection',
            'pls' => 'Setting Up Production Lines',
            'cbpi' => 'CBPI - No Serial',
            'cbpi_serial' => 'CBPI - with Serial',
            'cbpi_isce' => 'CBPI - ISCE',
        ];

        $user_info = Client::where('id',Auth::id())->first();

        $inspections = DB::table('inspections')
            ->join('clients','clients.client_code','=','inspections.client_id')
            ->join('reports','inspections.id', '=', 'reports.inspection_id')
            ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date')
            ->get();

        return view('pages.client.index',compact('user_info','inspections','services'));
    }

    public function clientLogout(){
        Auth::guard('client')->logout();
        return redirect()->route('login');
    }
}
