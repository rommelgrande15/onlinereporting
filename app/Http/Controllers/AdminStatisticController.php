<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\UserInfo;
use Carbon\Carbon;
use App\Inspection;
use App\Client;


class AdminStatisticController extends Controller
{
    public function index($type)
    {
        if(!Auth::id()){
            return redirect()->route('login');
        }
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        
        if($user_info->designation == 'super_admin' || $user_info->designation == 'booking'){
            return $this->goTo($type, $user_info);
        } else {
            return redirect()->route('login');
        }
        
    }
    
    private function goTo($type, $user_info)
    {
        $types = ['jobs', 'reports', 'inspectors', 'booking-team', 'booking-team-dev'];
        if(in_array($type, $types)) {
            return view("pages.admin.stats.$type", compact('user_info','type'));
        } else {
            return back();
        }
    }

    public function show(Request $request) {
        
		$now = Carbon::now();
        $type = $request->type;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $select_month = $request->month;
		$money = '';
        $now = Carbon::now();
        $user_id = Auth::id();
		$daily = [];
        $i = 1;
        $total_counts = 0;
        
		if($start_date){
			$date = new Carbon($start_date);
		} else if($select_month){
			$date = new Carbon("2021-$select_month-01");
		} else {
			//$ranges = array('January','February','March','April','May','June','July','August','September','October','November','December');
			$date = $now;
		}
		
		for($max=$date->daysInMonth; $i<=$max; $i++){
            $daily[] = $i;
        }
		
        $ranges = $daily;
        $data = [];
        $currency = '';  
        $total_manday = $total_counts = $total_cost = 0;

        foreach($ranges as $range){
            $month = date("m", strtotime($date));
            $year = date("Y", strtotime($date));
            $month_name = date("M", strtotime($date));
            $nrange = $range;
            
            if($type == 'jobs'){
                $client_code = $request->client;
                if($client_code){
                    $count_inspections = DB::table('inspections')
                    ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
                    ->where('inspections.client_id', $client_code)
                    ->where('inspections.inspection_date','<=', $now)
					->whereMonth('inspections.inspection_date', $month)
					->whereDay('inspections.inspection_date', $nrange)
					->whereYear('inspections.inspection_date', $year)
                    ->count('id');
                } else {
                    $count_inspections = DB::table('inspections')
                    ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
                    ->where('inspections.inspection_date','<=', $now)
					->whereMonth('inspections.inspection_date', $month)
					->whereDay('inspections.inspection_date', $nrange)
					->whereYear('inspections.inspection_date', $year)
                    ->count('id');
                }
                
                $data[] = ([
					'count' => $count_inspections,
					'ranges' => "$month_name $range",
					'year' => "$year",
				]);
            } else if($type == 'reports'){
                $count_reports = DB::table('reports')
                    ->leftJoin('inspections','reports.inspection_id','inspections.id')
                    ->select('id')
                    ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
					->where('inspections.inspection_date','<=', $now)
					->whereMonth('inspections.inspection_date', $month)
					->whereDay('inspections.inspection_date', $nrange)
					->whereYear('inspections.inspection_date', $year)
					->count('inspections.id');
                $data[] = ([
					'count' => $count_reports,
					'ranges' => "$month_name $range",
					'year' => "$year",
				]);
            } else if($type == 'inspectors'){
                $inspections = DB::table('inspections')
                    ->select('inspections.id','inspections.manday')
                    ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
                    ->where('inspections.inspection_date','<=', $now)
					->whereMonth('inspections.inspection_date', $month)
					->whereDay('inspections.inspection_date', $nrange)
					->whereYear('inspections.inspection_date', $year)
					->get();
                $jobs = $inspections->count('id');
                $manday = $inspections->sum('manday');
                
                
                $data[] = ([
					'count' => $jobs,
					'manday' => $manday,
					'ranges' => "$month_name $range",
					'year' => "$year",
				]);
            } else if($type == 'booking-team'){
                $inspections = DB::table('inspections')
                    ->select(DB::raw('COUNT(inspections.id) as count'),'inspections.id','inspections.manday','user_infos.name')
                    ->join('user_infos','inspections.created_by','user_infos.user_id')
                    ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
                    ->where('user_infos.designation','booking')
                    ->where('inspections.inspection_date','<=', $now)
					->whereMonth('inspections.inspection_date', $month)
					->whereDay('inspections.inspection_date', $nrange)
					->whereYear('inspections.inspection_date', $year)
                    ->groupBy('user_infos.name')
					->get();
                $jobs = $inspections->count('id');
                $manday = $inspections->sum('manday');
                
                
                $data[] = ([
					'data' => $inspections,
					'manday' => $manday,
					'ranges' => "$month_name $range",
					'year' => "$year",
				]);
            }
        }
        
        
        
        if($type=='booking-team-dev'){
            $inspections = DB::table('inspections')
                    ->select(DB::raw('COUNT(inspections.id) as counts'),'inspections.id','inspections.manday','user_infos.name')
                    ->join('user_infos','inspections.created_by','user_infos.user_id')
                    ->whereIn('inspections.inspection_status',['Released','Report Released','Shipment Accepted','Shipment Rejected'])
                    ->where('user_infos.designation','booking')
                    ->where('inspections.inspection_date','<=', $now)
					->whereMonth('inspections.inspection_date', $month)
					->whereYear('inspections.inspection_date', $year)
                    ->groupBy('user_infos.name')
					->get();

                foreach($inspections AS $inspection){
                    $total_counts = $total_counts + $inspection->counts;
                }
                
                $data = $inspections;
        }
            
        return response()->json([
            'data' => $data,
            'total_counts' => $total_counts,
            'currency' => strtoupper($currency),
            'month' => $date->format('F'),
            'month_no' => $date->format('m'),
        ]);
    }
    
    
    //Client Selection
    public function clientSelection(Request $request){
      $search = $request->search;

      if($search == ''){
         $clients = UserInfo::orderby('name','asc')
             ->select('client_code','name','email_address')
             ->where('client_code','!=',000)
             ->where('designation','client')
             ->get();
      }else{
         $clients = UserInfo::orderby('name','asc')
             ->select('client_code','name','email_address')
             ->where('client_code','!=',000)
             ->where('designation','client')
             ->where('name', 'like', '%' .$search . '%')
             ->orWhere('email_address', 'like', '%' .$search . '%')
             ->get();
      }

      $response = array();
      foreach($clients as $client){
          $response[] = array(
              "id" => $client->client_code,
              "text" => "$client->name ($client->email_address)"
          );
      }

      return response()->json($response);
   }

}
