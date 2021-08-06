<?php

namespace App\Http\Controllers;


use Dompdf\Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Inspection;

use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Array_;
use Session;
use Mail;
use Symfony\Component\DomCrawler\Crawler;

class TesterController extends Controller
{
    public function testOnly(){
        $id = 'CA';
        date_default_timezone_set("Asia/Bangkok");
        //return date('Y');
        $year = date('Y');
        $month = date('m');
        $month_now = $year .'-'. $month;
        $Inspection = Inspection::where('client_id',$id)->where('inspection_date','LIKE',"%{$month_now}%")->get();
        /* $Inspection = Inspection::where('client_id',$id)->whereYear('inspection_date', 'LIKE', date('Y'))->whereMonth('inspection_date', 'LIKE', date('m'))->get(); */
        //return $Inspection;
        //return $count = $Inspection->count();
        if($Inspection->count()==0){
            
        }else{
            $array_id = [];
            
            foreach($Inspection as $ins){
                $ins_year = date('Y',strtotime($ins->inspection_date));
                $ins_month = date('m',strtotime($ins->inspection_date));
                if($ins_year == $year && $ins_month == $month){
                    $explode_ref_num = explode("-", $ins->reference_number);
                    $get_num = $explode_ref_num[2];
                    array_push($array_id,$get_num);
                }
            }
            $max_id = max($array_id);
            return $max_id;
            $count = $max_id;
        }
        //return $count;
    }
}