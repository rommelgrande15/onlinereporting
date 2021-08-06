<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\UserInfo;
use Carbon\Carbon;


class StatisticController extends Controller
{
    public function index($type)
    {
        if(!Auth::id()){ return redirect()->route('login'); }
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        
        return view('pages.client.stats.index', compact('user_info','type'));
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
					'ranges' => "$month_name $range",
					'year' => "$year",
				]);
                
                $passed = $failed = $pending = [] ;
				
				/*$data_sets = ([
					'label' => (['Passed', 'Failed', 'Pending']),
					'backgroundColor' => (['#3498db', '#e74c3c', '#bdc3c7']),
					'data' => ([[], [], []])
				]);*/
				
				
				
				/*$data_sets = ([
					'label' => $labels,
					'backgroundColor' => $colors,
					'data' => ([[], [], []])
				]);*/
				
			} else if($type == 'cost'){
				$money = DB::table('client_costs')
					->select('currency')
					->leftJoin('inspections','client_costs.inspection_id','=','inspections.id')
					->where('inspections.client_id', $user_info->client_code)
					->first();
				
				$costs = DB::table('client_costs')
					->select('client_costs.md_charges','client_costs.travel_cost','client_costs.hotel_cost','client_costs.ot_cost','client_costs.currency AS curr')
					->leftJoin('inspections','client_costs.inspection_id','=','inspections.id')
					->where('inspections.client_id', $user_info->client_code)
					->whereMonth('inspections.inspection_date', $month)
					->whereDay('inspections.inspection_date', $nrange)
					->whereYear('inspections.inspection_date', $year)
					//->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
					->get();
            
				$total_cost = $costs->sum('md_charges','travel_cost','hotel_cost','ot_cost');
				$data[] = ([
					'cost' => $total_cost,
					'ranges' => "$month_name $range",
					'year' => "$year",
				]);
				
				$data_sets = ([
					'label' => (['Cost']),
					'backgroundColor' => (['#3498db']),
					'data' => ([[]])
				]);
			} else if($type == 'factories'){
				
				$factories = DB::table('factories')
					//->select('report_uploads.report_status')
					->leftJoin('inspections','factories.id','=','inspections.factory')
					->where('inspections.client_id', $user_info->client_code)
					->whereMonth('inspections.inspection_date', $month)
					->whereDay('inspections.inspection_date', $nrange)
					->whereYear('inspections.inspection_date', $year)
					//->whereRaw('report_uploads.id IN(SELECT MAX(id) FROM report_uploads GROUP BY reference_no)')
					->get();
            
				$all = $factories->count();
				$data[] = ([
					'all' => $all,
					'ranges' => "$month_name $range",
					'year' => "$year",
				]);
                
                $passed = $failed = $pending = [] ;
            }
		}
		
		if($type == 'kpi'){
			$labels = array('Passed', 'Failed', 'Pending');
			$colors = array('#3498db', '#e74c3c', '#bdc3c7');

				if($labels[$i] == "Passed"){
					$passed[] = $passed;
				} else if ($labels[$i] == "Failed"){
					$failed[] = $failed;
				} else {
					$pending[] = $pending;
				}
				
				$data_sets[] = ([
					'backgroundColor' => $colors[$i],
					'label' => $labels[$i],
					'passed' => $passed,
					'failed' => $failed,
					'pending' => $pending
				]);

		}
		
		return response()->json([
			'data_sets' => $data_sets,
			'type' => $type,
			'data' => $data,
			'month' => $date->format('F'),
			'currency' => $money
		]);
    }

}
