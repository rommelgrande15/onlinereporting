<?php

namespace App\Http\Controllers;

use App\Template;
use Dompdf\Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Client;
use App\Role;
use App\User;
use App\UserInfo;
use App\Inspection;
use App\Report;
use App\Factory;
use App\Country;
use App\Product;
use App\ClientContact;
use App\FctoryContact;
use App\Attachment;
use App\PSIProduct;
use App\InspectorAddress;
use App\Supplier;
use App\SupplierContact;
use App\ClientCost;
use App\InspectorCost;
use App\SavedProductCategories;
use App\SavedProductSubCategories;

use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Array_;
use Session;
use Mail;
use Symfony\Component\DomCrawler\Crawler;


class ReferenceNumberController extends Controller
{

    public function getReferenceNumber($id, $inspect_date){
        date_default_timezone_set("Asia/Shanghai");
        
        $year = date('Y',strtotime($inspect_date));
        $month = date('m',strtotime($inspect_date));
        $month_now = $year .'-'. $month;
        $Inspection = Inspection::where('client_id',$id)->where('inspection_date','LIKE',"%{$month_now}%")->get();
        $count = $Inspection->count();
        $new_ref_num = '';
        /* code add ref number */
        $count++;
        $year_format = date('y',strtotime($inspect_date));
        $add_trail_zero = sprintf("%02d",$count);
        $new_ref_num = $id.'-'.$year_format.$month.'-'.$add_trail_zero;
        //remove space if any
        $new_ref_num = preg_replace('/\s+/', '', $new_ref_num);
        /* end */
        
        //counter
        $check_counter = 0;
        while($check_counter == 0){
            $check_inspection = Inspection::where('reference_number',$new_ref_num)->count();
            if($check_inspection == 0){
                $check_counter = 1;
            }else{
                $count++;
                $year_format = date('y',strtotime($inspect_date));
                $add_trail_zero = sprintf("%02d",$count);
                $new_ref_num = $id.'-'.$year_format.$month.'-'.$add_trail_zero;
                //remove space if any
                $new_ref_num = preg_replace('/\s+/', '', $new_ref_num);
            }
        }


        return response()->json([
            'ref_num' => $new_ref_num
        ]);
    }
}
