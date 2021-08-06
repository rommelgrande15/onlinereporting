<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Factory;
use App\Product;
use App\InspectionProduct;
use App\InspectionPhotos;
use App\BookingSummary;
use App\CustRequirement;
use DB;
class BookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getBookings(){
        $service = [
                    "iqi"=>"Incoming Quality Inspection",
                    "psi"=>"Pre Shipment Inspection",
                    "cli"=>"Container Loading Inspection",
                    "dupro"=>"During Production Inspection",
                    "pls"=>"Setting Up Production Lines",
        ];
    	$company = Company::where('user_id',Auth::id())->first();
    	$bookings = DB::table('users')
    	->join('booking_summaries', 'booking_summaries.user_id', '=', 'users.id')
    	->join('factories','booking_summaries.factory_id','=','factories.id')
        ->select('booking_summaries.*','factories.factory_name')
    	->where('booking_summaries.user_id','=',Auth::id())->get();
    	return view('pages.bookings.index', compact('bookings','company','service'));
    }

    public function viewBooking($id){
        $company = Company::where('user_id', Auth::id())->first();
        $service = [
                    "iqi"=>"Incoming Quality Inspection",
                    "psi"=>"Pre Shipment Inspection",
                    "cli"=>"Container Loading Inspection",
                    "dupro"=>"During Production Inspection",
                    "pls"=>"Setting Up Production Lines",
        ];

        $booking = BookingSummary::find($id);
        $service_type = $service[$booking->service_type];
        $products = InspectionProduct::findMany(json_decode($booking->products));

        $product_array = [];
        foreach ($products as $product) {
            array_push($product_array, $product->product_id);
        };

        $product_array = json_encode($product_array);

        $productInfo = Product::findMany(json_decode($product_array));
        $photos = InspectionPhotos::findMany(json_decode($booking->photos));

        $factory = Factory::find($booking->factory_id);
        $crs = CustRequirement::where('user_id', Auth::id())->first();

        return view ('pages.bookings.show',compact('crs','productInfo','booking','products','photos','company','factory','service_type'));
        
    }

    public function deleteRequest(Request $request){
        $booking = BookingSummary::find($request['id']);
        $booking->booking_status = 'pending';
        $booking->update();
        return response()->json([
            'message'=>'OK'
        ],200);
    }

}
