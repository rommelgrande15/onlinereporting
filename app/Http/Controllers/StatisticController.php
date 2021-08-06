<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\UserInfo;
use Carbon\Carbon;
use App\Inspection;
use App\Client;


class StatisticController extends Controller
{
    public function index($type)
    {
        if(!Auth::id()){
            return redirect()->route('login');
        
        }
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        
        if($user_info->designation != 'client'){
            return redirect()->route('login');
        }
        
        if($user_info->category == 'supplier'){
            return back();
        }
        
        
        $ccode = DB::table('clients')->where('user_id',Auth::id())->first();
        $new_post_client = Inspection::where('inspection_type',null)
            ->where('inspection_status','Client Pending')
            ->where('supplier_book','true')
            ->where('client_id',$ccode->client_code)
            ->count();
        
        if($type == 'kpi'){
            return view('pages.client.stats.index', compact('user_info','type','new_post_client'));
        } else if($type == 'cost'){
            return view('pages.client.stats.cost', compact('user_info','type','new_post_client'));
        } else if($type == 'factories'){
            return view('pages.client.stats.factories', compact('user_info','type','new_post_client'));
        } else if($type == 'suppliers'){
            return view('pages.client.stats.suppliers', compact('user_info','type','new_post_client'));
        } else if($type == 'countries'){
            return view('pages.client.stats.countries', compact('user_info','type','new_post_client'));
        } else if($type == 'countries2'){
            return view('pages.client.stats.countries2', compact('user_info','type','new_post_client'));
        } else if($type == 'products'){
            return view('pages.client.stats.products', compact('user_info','type','new_post_client'));
        }  else {
             return back();
        }
        
    }

    public function show(Request $request)
    {
		$now = Carbon::now();
		
		
        $type = $request->type;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $select_month = $request->month;
		$money = '';
        
        $user_id = Auth::id();
        
        $user_info = DB::table('users')->select('client_code')->where('id',$user_id)->first();

		$daily = [];
        $i = 1;
		if($start_date){
			$date = new Carbon($start_date);
		} else if($select_month){
			$date = new Carbon("2021-$select_month-01");
		} else {
			$date = Carbon::now();
		}
		
		for($max=$date->daysInMonth; $i<=$max; $i++){
            $daily[] = $i;
        }
		
        $ranges = $daily;
        $data = [];
        $data_sets = [];
        $dta = [];
		
		
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
        $currency = '';  
        $total_manday = 0;

        foreach($ranges as $range){
            $month = date("m", strtotime($date));
            $year = date("Y", strtotime($date));
            $month_name = date("M", strtotime($date));
            $nrange = $range;
            
            if($type == 'kpi'){
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
            } else if($type == 'cost'){
                $money = DB::table('client_costs')
					->select('currency')
					->leftJoin('inspections','client_costs.inspection_id','=','inspections.id')
					->where('inspections.client_id', $user_info->client_code)
					->first();
                $currency = $money->currency;
                
				$costs = DB::table('client_costs')
					->select(DB::raw('inspections.manday * client_costs.md_charges AS total_cost'), DB::raw('SUM(inspections.manday) AS total_manday'), 'inspections.inspection_status', 'inspections.manday', 'client_costs.md_charges', 'client_costs.travel_cost', 'client_costs.hotel_cost', 'client_costs.ot_cost', 'client_costs.other_cost_value')
					->leftJoin('inspections','client_costs.inspection_id','=','inspections.id')
					->where('inspections.client_id', $user_info->client_code)
					->whereNotIn('inspections.inspection_status',['Cancelled','Deleted','Hold','Client Pending'])
					->whereMonth('inspections.inspection_date', $month)
					->whereDay('inspections.inspection_date', $nrange)
					->whereYear('inspections.inspection_date', $year)
					->where('client_costs.md_charges', '>', 0)
					//->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
					->get();
                
                foreach($costs as $cost){
                    $total_manday = $total_manday + $cost->manday;
                }

				$data[] = ([
					'cost' => $costs->sum('total_cost'),
					'manday' => $costs->sum('manday'),
					'ranges' => "$month_name $range",
					'year' => "$year",
				]);
            } else if($type == 'products'){
                //Products Statistics
                $money = DB::table('client_costs')
					->select('currency')
					->leftJoin('inspections','client_costs.inspection_id','=','inspections.id')
					->where('inspections.client_id', $user_info->client_code)
					->first();
                if($money){
                    $currency = $money->currency;
                }

                $products = DB::table('p_s_i_products')
				    ->select('inspections.id','client_costs.md_charges', 'client_costs.travel_cost', 'client_costs.hotel_cost', 'client_costs.travel_cost', 'client_costs.ot_cost', 'client_costs.other_cost_value', 'p_s_i_products.aql_qty', 
                             DB::raw('inspections.manday as manday'), 
                             DB::raw('SUM(p_s_i_products.aql_qty) as qty'),
                             DB::raw('SUM(client_costs.md_charges) as md_charges'),
                             DB::raw('SUM(client_costs.travel_cost) as travel_cost'),
                             DB::raw('SUM(client_costs.hotel_cost)  as hotel_cost'),
                             DB::raw('SUM(client_costs.travel_cost) as travel_cost'),
                             DB::raw('SUM(client_costs.ot_cost) as ot_cost'),
                             DB::raw('SUM(client_costs.other_cost_value)  as other_cost_value'),
                             'p_s_i_products.product_name')
					->join('inspections','p_s_i_products.inspection_id', '=', 'inspections.id')
					->join('client_costs','client_costs.inspection_id','=','inspections.id')
					//->join('suppliers','factories.supplier_id','=','suppliers.id')
					->where('inspections.client_id', $user_info->client_code)
					->whereMonth('inspections.inspection_date', $month)
					->whereDay('inspections.inspection_date', $nrange)
					->whereYear('inspections.inspection_date', $year)
                    ->groupBy('p_s_i_products.product_name')
					->get();

                $data[] = ([
					'counts' => $products->sum('aql_qty'),
					'cost' => $products->sum('md_charges', 'travel_cost', 'hotel_cost', 'travel_cost', 'ot_cost', 'other_cost_value'),
					'manday' => $products->sum('manday'),
					'ranges' => "$month_name $range",
					'year' => "$year",
				]);
            }
        }
            
            $total_counts = 0;
            $total_cost = 0;
            
            //Countries Statistics
            if($type == 'countries' || $type=='countries-dev'){
    	
                $countries = DB::table('factories')
                    ->select(DB::raw('COUNT(inspections.id) as counts'), 'factories.factory_country_name AS country', 'inspections.reference_number')
                    ->join('inspections','factories.id','=','inspections.factory')
                    ->where('inspections.client_id', $user_info->client_code)
                    ->whereMonth('inspections.inspection_date', $month)
                    ->whereYear('inspections.inspection_date', $year)
                    ->groupBy('factories.factory_country')
                    ->get();

                foreach($countries AS $country){
                    $total_counts = $total_counts + $country->counts;
                }
                
                $data = $countries;
            }
            
            //Factories Statistics
            if($type == 'factories'){
                $factory_datas = [];
                
                $factories = DB::table('inspections')
				    ->select(DB::raw('COUNT(inspections.id) as counts'), DB::raw('SUM(inspections.manday)  as manday'), 'factories.factory_name as name','suppliers.supplier_name')
					->join('factories','inspections.factory','factories.id')
                    ->join('suppliers','factories.supplier_id','suppliers.id')
					->where('inspections.client_id', $user_info->client_code)
					->whereMonth('inspections.inspection_date', $month)
					->whereYear('inspections.inspection_date', $year)
                    //->groupBy('factories.factory_name')
                    ->groupBy('factories.id')
					->get();
                
                foreach($factories AS $factory){
                    $total_counts = $total_counts + $factory->counts;
                    
                    if($factory->name == '-' || $factory->name == NULL ){
                        $factory_name = $factory->supplier_name;
                    } else {
                        $factory_name = $factory->name;
                    }
                    $factory_datas[] = ([
                        'manday' => $factory->manday,
                        'name' => $factory_name,
                    ]);
                }

                $data = $factory_datas;
                //$data = $factory_datas;
            }
            
            //Suppliers Statistics
            if($type == 'suppliers'){
                $suppliers = DB::table('inspections')
				    ->select(DB::raw('COUNT(inspections.id) as counts'), DB::raw('SUM(inspections.manday) as manday'),'factories.factory_name','suppliers.supplier_name')
					->join('factories','inspections.factory','factories.id')
					->join('suppliers','factories.supplier_id','suppliers.id')
					->where('inspections.client_id', $user_info->client_code)
					->whereMonth('inspections.inspection_date', $month)
					->whereYear('inspections.inspection_date', $year)
                    ->where('factories.supplier_id','>',0)
                    //->groupBy('factories.factory_name')
                    ->groupBy('suppliers.supplier_name')
					->get();

                foreach($suppliers AS $supplier){
                    $total_counts = $total_counts + $supplier->counts;
                }
                
                $data = $suppliers;
            }
    
            if($type == 'cost' || $type == 'cost-dev'){
                return response()->json([
                    'currency' => strtoupper($currency),
                    'data' => $data,
                    'total_manday' => $total_manday,
                    'month' => $date->format('F')
                ]);
            } else {
                return response()->json([
                    'data' => $data,
                    'total_counts' => $total_counts,
                    'currency' => strtoupper($currency),
                    'month' => $date->format('F'),
                    'month_no' => $date->format('m'),
                ]);
            }
            
		

    }

}
