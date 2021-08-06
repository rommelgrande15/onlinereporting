<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\User;
use App\UserInfo;
use App\Country;
use App\Company;
use App\Factory;
use App\Product;
use Carbon\Carbon;
use App\InspectionProduct;
use App\InspectionPhotos;
use App\BookingSummary;
use Mail;
use URL;
use Session;


class InspectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex(){

    	$company = Company::where('user_id',Auth::id())->first();
    	$countries = Country::pluck('nicename','iso');
    	$factories = Factory::where('user_id',Auth::id())->pluck('factory_name','id');
        $products = Product::where('user_id',Auth::id())->pluck('product_name','id');
    	return view('pages.inspection.index',compact('countries','company','factories','products'));
    }

    public function uploadPhoto(Request $request){
        $company = Company::where('user_id',Auth::id());
        $product_ids = $request['product_name'];
        $qty = $request['qty'];
        $gen_inspection_level = $request['gen_inspection_level'];
        $gen_sample_size = $request['gen_sample_size'];
        $special_inspection_level = $request['special_inspection_level'];
        $special_sample_size = $request['special_sample_size'];
        $minor = $request['minor'];
        $major = $request['major'];
        $crit = $request['crit'];
        $functional = $request['functional'];

        $count_product =  count($product_ids);

        $product_array = [];
        $photo_array = [];

        for ($i=0; $i < $count_product; $i++) { 
            $product[$i] = new InspectionProduct();
            $product[$i]->product_id = $product_ids[$i];
            $product[$i]->qty = $qty[$i];
            $product[$i]->gen_inspection_level = $gen_inspection_level[$i];
            $product[$i]->gen_sample_size = $gen_sample_size[$i];
            $product[$i]->special_inspection_level = $special_inspection_level[$i];
            $product[$i]->special_sample_size = $special_sample_size[$i];
            $product[$i]->minor = $minor[$i];
            $product[$i]->major = $major[$i];
            $product[$i]->critical = $crit[$i];
            $product[$i]->functional = $functional[$i];
            $product[$i]->save();

            $product_array[] = $product[$i]->product_id; // array of product IDs
        }
        
        if (empty($request['change_inspection_schedule'])) {
            $change_inspection_schedule = 0;
        }else{
            $change_inspection_schedule = $request['change_inspection_schedule'];
        }
        $booking = new BookingSummary();
        $booking->user_id = Auth::id();
        $booking->service_type = $request['service_type'];
        $booking->reference_number = $request['reference_number'];
        $booking->inspection_date = $request['inspection_date'];
        $booking->change_date = $request['change_date'];
        $booking->shipment_date = $request['shipment_date'];
        $booking->factory_id = $request['factory_name'];
        $booking->products = json_encode($product_array);
        $booking->photos = 'NULL';
        $booking->reference_sample = $request['reference_sample'];
        $booking->courier = $request['courier'];
        $booking->tracking_number = $request['tracking_number'];
        $booking->change_inspection_schedule = $change_inspection_schedule;
        $booking->more_info = $request['more_info'];
        $booking->manday = $request['manday'];
        $booking->booking_status = 'booked';
        $booking->save();


    	foreach ($request->file('file') as $file) {
    		//set a unique file name
	    	$filename = uniqid().'.'.$file->getClientOriginalExtension();

	    	//move the files to the correct folder
	    	$file->move('images/booking/'. $booking->id, $filename);

	    	//save details to db
	    	$photo= new InspectionPhotos();
	    	$photo->inspection_id = $booking->id;
	    	$photo->photo_path = $filename;
	    	$photo->save();
            $photo_array[] = $photo->id;
    	}

        $insertBooking = BookingSummary::find($booking->id);
        $insertBooking->photos = json_encode($photo_array);
        $insertBooking->update();

        $booking = BookingSummary::find($booking->id);
        $user = User::find(Auth::id());
        $factory = Factory::find($request['factory_name']);
        $company = Company::where('user_id',Auth::id())->first();
        $service = [
                    "iqi"=>"Incoming Quality Inspection",
                    "psi"=>"Pre Shipment Inspection",
                    "cli"=>"Container Loading Inspection",
                    "dupro"=>"During Production Inspection",
                    "pls"=>"Setting Up Production Lines",
        ];
        $service_type = $service[$booking->service_type];

        $data = ['email' =>  $user->email,'booking_id' => 1, 'full_name' => $company->full_name, 'factory'=>$factory, 'booking'=>$booking,'service'=>$service_type];
        Mail::send('email.booking',$data, function($message) use ($data){
            $message->to($data['email']);
            $message->subject('Booking Details');
        });

        return response()->json([
            'message'=>'OK',
            'id'=>$booking->id
        ]);        
    	
    }
    
    public function getInspectionSummary(Request $request){
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);
        $user_info = UserInfo::where('user_id',Auth::id())->first(); 
        $interval = $request['interval'];
        
        $inspections = DB::table('all_inspections')
                    ->join('factories', 'all_inspections.factory', '=', 'factories.id')
                    ->join('user_infos', 'all_inspections.created_by', '=', 'user_infos.id')
                    ->select('all_inspections.service','all_inspections.user_created_by',DB::raw("COUNT(all_inspections.id) as total"),'factories.factory_country_name')
                    //->whereNull('client_book_id')
                    ->where('designation','!=','client')
                    ->whereDate('all_inspections.inspection_date', Carbon::today())
                    //->where('all_inspections.inspection_date', Carbon::today())
                    ->groupBy('all_inspections.service','factories.factory_country_name','all_inspections.user_created_by')
                    ->get();
        
        if($interval){
            if($interval == 'daily'){
                $inspections = DB::table('all_inspections')
                    ->join('factories', 'all_inspections.factory', '=', 'factories.id')
                    ->join('user_infos', 'all_inspections.created_by', '=', 'user_infos.id')
                    ->select('all_inspections.service','all_inspections.user_created_by',DB::raw("COUNT(all_inspections.id) as total"),'factories.factory_country_name')
                    //->whereNull('client_book_id')
                    ->where('designation','!=','client')
                    ->whereDate('inspection_date', Carbon::today())
                    ->groupBy('all_inspections.service','factories.factory_country_name','all_inspections.user_created_by')
                    ->get();
                
                /*$inspections = DB::table('all_inspections')->select('service','user_created_by',DB::raw("COUNT(id) as total"))->whereDate('inspection_date', Carbon::today())->groupBy('service')->get();*/
                $range_date = Carbon::today()->format('F d, Y');
            } else if($interval == 'weekly') {
                $inspections = DB::table('all_inspections')
                    ->join('factories', 'all_inspections.factory', '=', 'factories.id')
                    ->join('user_infos', 'all_inspections.created_by', '=', 'user_infos.id')
                    ->select('all_inspections.service','all_inspections.user_created_by',DB::raw("COUNT(all_inspections.id) as total"),'factories.factory_country_name')
                    //->whereNull('client_book_id')
                    ->where('designation','!=','client')
                    ->whereBetween('inspection_date', [Carbon::now()->startOfWeek(), Carbon::today()])
                    ->groupBy('all_inspections.service','factories.factory_country_name','all_inspections.user_created_by')
                    ->get();
    
                
                $range_date = Carbon::now()->startOfWeek()->format('F d, Y') . " - " . Carbon::today()->format('F d, Y');
            } else {
                //Yearly
                $inspections = DB::table('all_inspections')
                    ->join('factories', 'all_inspections.factory', '=', 'factories.id')
                    ->join('user_infos', 'all_inspections.created_by', '=', 'user_infos.id')
                    ->select('all_inspections.service','all_inspections.user_created_by',DB::raw("COUNT(all_inspections.id) as total"),'factories.factory_country_name')
                    //->whereNull('client_book_id')
                    ->where('designation','!=','client')
                    //->whereBetween('inspection_date', [Carbon::now()->startOfWeek(), Carbon::today()])
                    //->whereBetween('inspection_date', "2020-01-01", "2020-12-31")
                    //->groupBy('all_inspections.service','factories.factory_country_name','all_inspections.user_created_by')
                    ->groupBy(DB::raw('YEAR(inspection_date)'), DB::raw('MONTH(inspection_date)'))
                    ->get();
    
                
                //$range_date = Carbon::now()->startOfWeek()->format('F d, Y') . " - " . Carbon::today()->format('F d, Y');
                $range_date =  "2020-01-01 - 2020-12-31";
            }
            
            $data = ['services' => $inspections, 'interval' => $interval, 'range' => $range_date];
            
            if($interval == 'yearly'){
                Mail::send('email.inspection_summary',$data, function($message) use ($data){
                    //$message->cc('emil@t-i-c.asia','Emil Tamayo');
                    $message->cc('zen4emil@gmail.com','Emil Tamayo');
                    $message->subject(ucfirst($data['interval']) . ' Inspection Summary | ' . $data['range']);
                });
            } else {
                Mail::send('email.inspection_summary',$data, function($message) use ($data){
                    // $message->to('gregor@t-i-c.asia','Gregor Vöge');
                    // $message->to('gregor.voege@web.de','Gregor Vöge');
                    $message->to('miguelbuojr@gmail.com','Miguel Buo Jr');
                    $message->cc('it-support@t-i-c.asia','IT Support');
                    $message->subject(ucfirst($data['interval']) . ' Inspection Summary | ' . $data['range']);
                });
            }
            
            return response()->json([
                'services' => $inspections
            ]); 
        }
        return view('pages.admin.inspection-summary.index',compact('user_info','inspections'));
    }
    
    
    public function send_inspection_summary($interval){
        Carbon::setWeekStartsAt(Carbon::MONDAY);
        Carbon::setWeekEndsAt(Carbon::SUNDAY);

            if($interval == 'daily'){
                $inspections = DB::table('all_inspections')
                    ->join('factories', 'all_inspections.factory', '=', 'factories.id')
                    ->select('all_inspections.service','all_inspections.user_created_by',DB::raw("COUNT(all_inspections.id) as total"),'factories.factory_country_name')
                    ->whereDate('inspection_date', Carbon::today())
                    ->groupBy('all_inspections.service','factories.factory_country_name','all_inspections.user_created_by')
                    ->get();
                
                /*$inspections = DB::table('all_inspections')->select('service','user_created_by',DB::raw("COUNT(id) as total"))->whereDate('inspection_date', Carbon::today())->groupBy('service')->get();*/
                $range_date = Carbon::today()->format('F d, Y');
            } else if('weekly') {
                $inspections = DB::table('all_inspections')
                    ->join('factories', 'all_inspections.factory', '=', 'factories.id')
                    ->select('all_inspections.service','all_inspections.user_created_by',DB::raw("COUNT(all_inspections.id) as total"),'factories.factory_country_name')
                    ->whereBetween('inspection_date', [Carbon::now()->startOfWeek(), Carbon::today()])
                    ->groupBy('all_inspections.service','factories.factory_country_name','all_inspections.user_created_by')
                    ->get();
                
                //$inspections = DB::table('inspection_lists')->select('service',DB::raw("COUNT(id) as total"))->whereBetween('inspection_date', [Carbon::now()->startOfWeek(), Carbon::today()])->groupBy('service')->get();
                
                $range_date = Carbon::now()->startOfWeek()->format('F d, Y') . " - " . Carbon::today()->format('F d, Y');
            }
            
            $data = ['services' => $inspections, 'interval' => $interval, 'range' => $range_date];
            Mail::send('email.inspection_summary',$data, function($message) use ($data){
                //$message->to('gregor@t-i-c.asia','Gregor Vöge');
                //$message->to('gregor.voege@web.de','Gregor Vöge');
                $message->cc('it-support@t-i-c.asia','IT Support');
                $message->subject('Automatic ' .ucfirst($data['interval']) . ' Inspection Summary | ' . $data['range']);
            });
            
/*            return response()->json([
                'services' => $inspections
            ]); */
        
    }
}
