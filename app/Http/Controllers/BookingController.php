<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \PDF;
use App\Company;
use App\Factory;
use App\Product;
use App\InspectionProduct;
use App\InspectionPhotos;
use App\BookingSummary;
use App\CustRequirement;

class BookingController extends Controller
{
    public function getIndex($id){
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

        $pdf = \PDF::loadView('pdf.booking',compact('crs','productInfo','booking','products','photos','company','factory','service_type'));
            return $pdf->stream('booking.pdf');
    }

    public function downloadSheet($id){
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

        $pdf = \PDF::loadView('pdf.booking',compact('crs','productInfo','booking','products','photos','company','factory','service_type'));
            return $pdf->download('booking.pdf');
    }
}
