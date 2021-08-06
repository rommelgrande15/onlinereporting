<?php

namespace App\Http\Controllers;

use App\Answer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\InspectionPhotos;
use App\Checklist;
use App\Supplier;
use App\Cargo;
use App\Loading;
use App\DetailedPhoto;
use App\DetailedProduct;
use App\DetailedProductQty;
use App\Observation;
use App\DetailedPhotoDescription;
use App\InspectionInfo;
use App\Serial;
use App\ReportUpdate;
use App\Geolocation;
use App\Inspection;
use App\Report;
use App\Template;
use Mail;
use App\productPhoto;

class ReportsController extends Controller
{
    public function sendChecklist(Request $request){
            set_time_limit(0);          
            $file = $request->file('file');
            //set a unique file name
            $filename = $file->getClientOriginalName();

            // //move the files to the correct folder
            if($file->move('images/reports/'. $request->input('report_no').'/checklist', $filename)){
                //save details to db
                $photo = Checklist::where('report_number', $request->input('report_no'))->first();
                if (!$photo) {
                   $photo= new Checklist();
                   $photo->report_number = $request->input('report_no');
                }            
                $photo->image_path = $filename;
                
                if ($photo->save()) {
                    return response()->json([
                        'message'=>'OK',
                    ],200);
                }else{
                    return response()->json([
                        'message'=>'Error saving checklist photo. This might be a server issue. Please resend the report!',
                    ],500);
                }
            }else{
                return response()->json([
                        'message'=>'Error sending checklist photo. This might be a server issue. Please resend the report!',
                ],500);
            }
    }


    public function sendSupplier(Request $request){
        set_time_limit(0);
        $file = $request->file('file');
        //set a unique file name
        $filename = $file->getClientOriginalName();

        // //move the files to the correct folder
        if ($file->move('images/reports/'. $request->input('report_no').'/supplier', $filename)) {
           $column = $request->input('label');
    
            $photo = Supplier::where('report_number', $request->input('report_no'))->first();
            if (!$photo) {
                $photo = new Supplier();
                $photo->report_number = $request->input('report_no');
            }
            $photo->$column = $filename;
            if ($photo->save()) {
                return response()->json([
                    'message'=>'OK'
                ],200);
            }else{
                return response()->json([
                    'message'=>'Error saving supplier overview photos. Please resend the report!'
                ],500);
            }
        }else{
            return response()->json([
                'message'=>'Error uploading supplier overview photos. Please resend the report!'
            ],500);
        }
        
        

    } 

    public function sendCargoInputs(Request $request){
        
        set_time_limit(0);

        $cargo = Cargo::where('report_number',$request->input('report_number'))->first();
        if (!$cargo) {
            $cargo = new Cargo();
            $cargo->report_number = $request->input('report_number');
        }
        $cargo->inspector_arrival_time = $request->input('inspector_arrival_time');
        $cargo->cargo_ready_time = $request->input('cargo_ready_time');
        $cargo->container_arrival_time = $request->input('container_arrival_time');
        $cargo->loading_started = $request->input('loading_started');
        $cargo->inspection_finished = $request->input('inspection_finished');
        $cargo->loading_facility_cooperation = $request->input('loading_facility_cooperation');
        $cargo->container_number = $request->input('container_number');
        $cargo->shipping_seal_number = $request->input('shipping_seal_number');
        $cargo->sera_seal_number = $request->input('sera_seal_number');
        $cargo->container_size = $request->input('container_size');
        $cargo->container_status = $request->input('container_status');

        if($request->input('front_Door')=='N/A'){
            $cargo->loading_area = $request->input('front_Door');
        }

        if($request->input('back_Door')=='N/A'){
            $cargo->front_doors = $request->input('back_Door');
        }

        if($request->input('left_Door')=='N/A'){
            $cargo->left_side = $request->input('left_Door');
        }

        if ($request->input('container_status') == 'good') {
            $cargo->container_damage_1 = null;
            $cargo->container_damage_2 = null;
        }
        $cargo->holes = $request->input('holes');
        if ($request->input('holes') == 'no') {
            $cargo->cargo_holes = null;
        }
        $cargo->dents = $request->input('dents');
        if ($request->input('dents') == 'no') {
           $cargo->cargo_dents = null;
        }
        $cargo->floor_condition = $request->input('floor_condition');
        $cargo->doors_condition = $request->input('doors_condition');
        $cargo->light_proof = $request->input('light_proof');
        $cargo->palletized_cargo = $request->input('palletized_cargo');
        if ($request->input('palletized_cargo') == 'no') {
           $cargo->pallet_material = null;
           $cargo->fumigation_stamp = null;
        }

        $cargo->specify_pallet_material = $request->input('specify_pallet_material');
        $cargo->number_of_pallets_loaded = $request->input('number_of_pallets_loaded');
        $cargo->from_pallet_number = $request->input('from_pallet_number');
        $cargo->to_pallet_number = $request->input('to_pallet_number');
       
        if ( $cargo->save()) {
            return response()->json([
                'message'=>'OK'
            ]);
        }else{
            return response()->json([
                'message'=>'Error saving cargo information. Please resend the report!'
            ],500);
        }
        

    }

   


    public function saveCargoPhotos(Request $request){
            set_time_limit(0);
            $photo = Cargo::where('report_number', $request->input('report_no'))->first();
            $column = $request->input('label');
            if (!$photo) {
                $photo = new Cargo();
                $photo->report_number = $request->input('report_no');
            }

            $photo->$column = $request->input('value');
            if ($photo->save()) {
                return response()->json([
                    'message'=>'OK'
                ]);
            }else{
                return response()->json([
                    'message'=>'Error saving cargo photos. Please resend the report!'
                ],500);
            }
    }


    public function uploadMultipleCargoPhotos(Request $request){
        set_time_limit(0);
        $file = $request->file('file');
        //set a unique file name
        $filename = $file->getClientOriginalName();
            
        $destination='images/reports/'. $request->input('report_no').'/cargo';
        // //move the files to the correct folder
        if ($file->move($destination, $filename)) {

            return response()->json([
                    'message'=>'OK',
                    'filename'=> $filename,
                    "destination"=>$destination
                ]);
        }else{

            return response()->json([
                    'message'=>'Error uploading cargo photos. Please resend the report!',
                    'filename'=> $filename,
                    "destination"=>$destination
            ],500);
        }
    }


    public function sendCargoPhotos(Request $request){
        set_time_limit(0);
        $file = $request->file('file');
        //set a unique file name
        $filename = $file->getClientOriginalName();
        
        // //move the files to the correct folder
        if ($file->move('images/reports/'. $request->input('report_no').'/cargo', $filename)) {
            $column = $request->input('label');
        
            $photo = Cargo::where('report_number', $request->input('report_no'))->first();
            if (!$photo) {
                $photo = new Cargo();
                $photo->report_number = $request->input('report_no');
            }
            $photo->$column = $filename;
            if ($photo->save()) {
                return response()->json([
                    'message'=>'OK'
                ]);
            }else{
                return response()->json([
                    'message'=>'Error saving cargo photos. Please resend the report!'
                ],500);
            }
        }else{
            return response()->json([
                    'message'=>'Error uploading cargo photos. Please resend the report!'
            ],500);
        }
    } 


    public function productInformation(Request $request){
        
        set_time_limit(0);


        $productPhoto = productPhoto::where('report_number',$request->input('report_number'))->first();
        if (!$productPhoto) {
            $productPhoto = new productPhoto();
            $productPhoto->report_number = $request->input('report_number');
        }
        $productPhoto->Product_Name = $request->input('Product_Name');
        $productPhoto->Invoice_PO_Number = $request->input('Invoice_PO_Number');
        $productPhoto->PL_Invoice_Provided = $request->input('PL_Invoice_Provided');
        $productPhoto->Total_quantity_ordered  = $request->input('Total_quantity_ordered');
        $productPhoto->Pallets = $request->input('Pallets');
        $productPhoto->Packages = $request->input('Packages');
        $productPhoto->Pieces = $request->input('Pieces');
        $productPhoto->Defects_Found = $request->input('Defects_Found');
        $productPhoto->Total_Qty_packages_Loaded = $request->input('Total_Qty_packages_Loaded');
        $productPhoto->Product_Photo = $request->input('photos.productPhoto');
        
       
        if ( $productPhoto->save()) {
            return response()->json([
                'message'=>'OK'
            ]);
        }else{
            return response()->json([
                'message'=>'Error saving Product Photo information. Please resend the report!'
            ],500);
        }
        


    }

    public function remarks(Request $request){
        
        set_time_limit(0);
       // return  $request;
   //    return   $request->input('report_number');
   
        $productPhoto = productPhoto::where('report_number',$request->input('report_number'))->first();
        if (!$productPhoto) {
            $productPhoto = new productPhoto();
            $productPhoto->report_number = $request->input('report_number');
        }
        $productPhoto->remarks = $request->input('remarks');
        
        
       
        if ( $productPhoto->save()) {
            return response()->json([
                'message'=>'OK'
            ]);
        }else{
            return response()->json([
                'message'=>'Error saving Product Photo information. Please resend the report!'
            ],500);
        }
        


    }

    public function productPhotoData(Request $request){
        set_time_limit(0);
        $file = $request->file('file');
        //set a unique file name
        $filename = $file->getClientOriginalName();
        
        // //move the files to the correct folder
        if ($file->move('images/reports/'. $request->input('report_no').'/productPhotoData', $filename)) {

                return response()->json([
                    'message'=>'OK'
                ]);

          
        }else{
            return response()->json([
                    'message'=>'Error uploading cargo photos. Please resend the report!'
            ],500);
        }
    }

    public function sendLoading(Request $request){
        set_time_limit(0);
        $file = $request->file('file');
        //set a unique file name
        $filename = $file->getClientOriginalName();

        // //move the files to the correct folder
        if ($file->move('images/reports/'. $request->input('report_no').'/loading', $filename)) {
            $column = $request->input('label');
        
            $load = Loading::where('report_number', $request->input('report_no'))->first();
            if (!$load) {
                $load = new Loading();
                $load->report_number = $request->input('report_no');
            }
            $load->$column = $filename;
            if ($load->save()) {
                 return response()->json([
                    'message' => 'OK'
                ],200);
            }else{
                return response()->json([
                    'message'=>'Error saving loading details. Please resend the report!'
                ],500);
            }
        }else{
            return response()->json([
                    'message'=>'Error uploading loading photos. Please resend the report!'
            ],500);
        }
        
       
    } 

    public function sendDetailedPhoto(Request $request){
        set_time_limit(0);
        $file = $request->file('file');
        //set a unique file name
        $filename = $file->getClientOriginalName();

        // //move the files to the correct folder
        if ($file->move('images/reports/'. $request->input('report_no').'/detailedPhoto'.'/'.$request->input('photo_count').'/', $filename)) {
            $detailed = new DetailedPhoto();
            $detailed->report_number = $request->input('report_no');
            $detailed->photo_count = $request->input('photo_count');
            $detailed->photo_label = $request->input('photo_label');
            $detailed->image_data = $filename;

            if ($detailed->save()) {
                return response()->json([
                    'message' => 'OK'
                ],200);
            }else{
                return response()->json([
                    'message' => 'Error saving detailed photos. Please resend the report!'
                ],500);
            }
        }else{
            return response()->json([
                   'message' => 'Error uploading detailed photos. Please resend the report!'
            ],500);
        }

        
        
    }

    public function sendDetailedProduct(Request $request){
        set_time_limit(0);
        $product = DetailedProduct::where('report_number',$request->input('report_no'))->where('product_count',$request->input('product_count'))->first();

        if (!$product) {
            $product = new DetailedProduct();
            $product->report_number = $request->input('report_no');
        }
        
        $product->product_count = $request->input('product_count');
        $product->invoice_no = $request->input('invoice_no');
        $product->po_no = $request->input('po_no');
        $product->model_number = $request->input('model_number');
        $product->description = $request->input('description');
        $product->package_qty = $request->input('package_qty');
        $product->pieces = $request->input('pieces');
        $product->material = $request->input('material');

        if ($product->save()) {
           return response()->json([
                'message' => 'OK'
            ],200);
        }else{
            return response()->json([
                'message' => 'Error sending product details. Please resend the report!'
            ],500);
        }
    }

    public function sendProductQty(Request $request){
        set_time_limit(0);
        $product = DetailedProductQty::where('report_number', $request->input('report_no'))->first();
        if (!$product) {
             $product = new DetailedProductQty();
             $product->report_number = $request->input('report_no');
        }
        $product->match = $request->input('match');
        $product->boxes_opened_photos = $request->input('boxes_opened_photos');
        $product->boxes_opened_revision = $request->input('boxes_opened_revision');
        $product->total_boxes_opened = $request->input('total_boxes_opened');

        if ($product->save()) {
           return response()->json([
                'message' => 'OK'
            ],200);
        }else{
            return response()->json([
                'message' => 'Error submitting product details. Please resend the report!'
            ],500);
        }
    }

    public function sendObservation(Request $request){
            set_time_limit(0);
            if ($request->file('file')) {
                $file = $request->file('file');
                //set a unique file name
                $filename = $file->getClientOriginalName();
                // //move the files to the correct folder
                if (!$file->move('images/reports/'. $request->input('report_no').'/observation', $filename)) {
                    return response()->json([
                        'message'=>'Error submitting observation details. Please resend the report!'
                    ],500);
                }                
            }else{
                $filename = null;
            }
          

            //save details to db
            $photo= Observation::where('report_number',$request->input('report_no'))->first();
            if (!$photo) {
                $photo= new Observation();
                $photo->report_number = $request->input('report_no');
            }
            $photo->damaged_products = $request->input('damaged_products');
            $photo->damaged_product_photo = $filename;
            $photo->other_obsetvations = $request->input('other_observations');
            $photo->save();

            if ($photo->save()) {
                return response()->json([
                    'message'=>'OK',
                ],200);
            }else{
                return response()->json([
                    'message'=>'Error submitting observation details. Please resend the report!'
                ],500);
            }
    }

    public function sendObservationNo(Request $request){
            set_time_limit(0);
            $photo= Observation::where('report_number',$request->input('report_no'))->first();
            if (!$photo) {
                $photo= new Observation();
                $photo->report_number = $request->input('report_no');
            }
            $photo->damaged_products = $request->input('damaged_products');
            $photo->damaged_product_photo = null;
            $photo->other_obsetvations = $request->input('other_observations');
            $photo->save();

            if ($photo->save()) {
                return response()->json([
                    'message'=>'OK',
                ],200);
            }else{
                return response()->json([
                    'message'=>'Error submitting observation details. Please resend the report'
                ],500);
            }
    }


    public function sendPhotoDescription(Request $request){
        set_time_limit(0);
        $desc = DetailedPhotoDescription::where('report_number',$request->input('report_no'))->where('photo_count',$request->input('photo_count'))->first();
        if (!$desc) {
            $desc = new DetailedPhotoDescription();
            $desc->report_number = $request->input('report_no');
        }
        $desc->photo_count = $request->input('photo_count');
        $desc->product_description = $request->input('product_description');
        if ($desc->save()) {
            return response()->json([
                'message'=>'OK'
            ],200);
        }else{
            return response()->json([
                'message'=>'Error submitting photo. Please resend the report!'
            ],500);
        }
    }

    public function sendInspectionInfo(Request $request){
        set_time_limit(0);
        DetailedPhoto::where('report_number',$request->input('report_no'))->delete();
        DetailedProduct::where('report_number',$request->input('report_no'))->delete();
        
        $info = InspectionInfo::where('report_number',$request->input('report_no'))->first();
        if (!$info) {
            $info = new InspectionInfo();
            $info->report_number = $request->input('report_no');
        }
        $info->inspection_date = $request->input('inspection_date');
        $info->factory_address = $request->input('factory_address');
        $info->client_name = $request->input('client');
        $info->supplier_name = $request->input('supplier_name');
        $info->contact_person = $request->input('contact_person');
        $info->contact_number = $request->input('contact_number');

        if ($info->save()) {
            return response()->json([
                'message'=>'OK'
            ],200);
        }else{
            return response()->json([
                'error'=>'Internal Server Error. Please resend the report!'
            ],500);
        }
    }


    public function sendSerialnumbers(Request $request){      
        set_time_limit(0);
        $serial = Serial::where('report_number',$request->input('report_no'))->where('item_count',$request->input('item_count'))->first();

        if (!$serial) {
            $serial = new Serial();
            $serial->report_number = $request->input('report_no');
        }  
        $serial->item_count = $request->input('item_count');
        $serial->item_name = $request->input('item_name');
        $serial->serial_number = $request->input('serial_number');
        $serial->carton_size = $request->input('carton_size');

        if ($serial->save()) {
            return response()->json([
                'message'=>'OK'
            ],200);
        }else{
            return response()->json([
                'error'=>'Internal Server Error. Please resend the report!'
            ],500);
        }
    }

    public function reportSending(Request $request){
        //if (Storage::exists("images/reports/{$request->input('report_no')}")){
            //Storage::deleteDirectory("images/reports/{$request->input('report_no')}");
        //}

        return response()->json('OK', 200);
    }

    public function reportAnswers(Request $request){
        $answer = new Answer();

        $answer->report_id = $request->input('report_id');
        $ans = json_decode(htmlspecialchars(json_encode($request->input('data'), JSON_UNESCAPED_UNICODE), ENT_NOQUOTES));
		if(is_array($ans))
			$ans = json_encode($ans);
		$answer->answers = $ans;
        $answer->download_date = Carbon::createFromTimestamp($request->input('download_date')/1000);


        return $answer->save()?response()->json('OK',200):response()->json('Internal Server Error. Please resend the report!',500);
    }

    public function reportPhotos(Request $request){
        set_time_limit(0);

        if ($request->hasFile('file')) {

            $report_id = trim(strtoupper($request->input('report_id')));

            $dirname = "images/reports/{$report_id}/" . clean_section($request->input('section'));

            $file = $request->file('file');

            $filename = clean_label($request->input('label')) . '-' . $file->getClientOriginalName();
			

            return $file->move($dirname, $filename)? response()->json('OK', 200) : response()->json('Error uploading photos. Please resend the report!', 500);
        }

        return response()->json('No photo uploaded. Please resend the report!', 501);
    }
	
	public function getListPhotos(Request $request)
	{
		if($request->has('report')){
			$base_path = 'images/reports/' . $request->input('report');
			if(is_dir($base_path)) return list_all_files($base_path);
		}
		
		return [];
	}
	
	public function createErrorLog(Request $request) {
		$filename = 'logs/error-' . date('Y-m-d') . '.log';
		Storage::append($filename, json_encode($request->log));
	}
	
	public function geoReporting(Request $request){

		if($request->exists('geolocation')){
			$inspection_id = $request->input('report_id');
			$failed = false;
			$gs = $request->input('geolocation');
			if(is_string($gs)){
				$gs = json_decode($gs,true);
			}
			foreach($gs as $g){
				$geo = new Geolocation();
				$geo->inspection_id = $inspection_id;
				$geo->latitude = $g['latitude'];
				$geo->longitude = $g['longitude'];
				$geo->timestamp = $g['timestamp'];
				
				if(!$geo->save()) $failed = true;					
			}
			if($failed)
				return response()->json('failed', 500);
			else
				return response()->json('success', 200);
		}
		
		return response()->json('failed', 500);
	}
	
	public function reportStatus(Request $request){
		$inspection_id = $request->input('report_id');
		$section = $request->input('section');
		$check = ReportUpdate::where('inspection_id', $inspection_id)->where('section', $section)->first();
		if(NULL == $check){
			$report_update = new ReportUpdate();
			$report_update->inspection_id = $inspection_id;
			$report_update->section = $section;
			if($report_update->save())
				return response()->json('success', 200);
			else
				return response()->json('failed', 200);
		}
		return response()->json('duplicate', 200);
	}
	
	public function getGeoReporting(Request $request)
	{
		if($request->exists('id')){
			$geo = Geolocation::where('inspection_id', $request->input('id'))->orderBy('timestamp', 'Desc')->first();
			return response()->json($geo, 200);
		}
		return response()->json([ 'error' => 'inspection id not found' ], 200);
	}
	
	public function getReportStatus(Request $request)
	{
		if($request->exists('id')){
			$template_id = Inspection::select('template_id')->where('id', $request->input('id'))->first();
				if($template_id){
					$sections = Template::select('items')->where('id', $template_id->template_id)->first();
					if($sections){
						$end_time = $this->getReportEndTime($request);
						$sections = collect(json_decode($sections->items))->pluck('title');
						$report_status = collect(json_decode(ReportUpdate::select('section')->where('inspection_id', $request->input('id'))->get()))->pluck('section')->toArray();
						$render = $sections->map(function($section) use ($report_status, $end_time){
							if($end_time != 'Pending..'){
								return '<tr class="text-center"><td class="text-left">'. $section .'</td><td><button data-id="test" class="btn btn-success btn-xs btn-success" title="Delete Record"><i class="fa fa-check"></i> Completed </button></td></tr>'; 
							}
							
							if(in_array($section, $report_status)){
								return '<tr class="text-center"><td class="text-left">'. $section .'</td><td><button data-id="test" class="btn btn-success btn-xs btn-success" title="Delete Record"><i class="fa fa-check"></i> Completed </button></td></tr>';
							}
							
							return '<tr class="text-center"><td class="text-left">'. $section .'</td><td><button data-id="test" class="btn btn-danger btn-xs btn-danger" title="Delete Record"><i class="fa fa-times"></i> On-Going </button></td></tr>';
							
						});
						return response()->json($render, 200);
					}
				}
			return response()->json([ '<tr><td class="text-center" colspan="2">No Template for this inspection</td></tr>' ], 200);
		}
		return response()->json([ 'error' => 'inspection id not found' ], 200);
	}
	
	public function getReportStartTime(Request $request)
	{
		$start_time = 'Pending..';
		$end_time = $this->getReportEndTime($request);
		if($request->exists('id')){
			$geo = Geolocation::where('inspection_id', $request->input('id'))->orderBy('timestamp', 'Asc')->first();
			if($geo){
					$dt = Carbon::now('Asia/Hong_Kong');
					$dt->timestamp($geo->timestamp/1000);
					$start_time = $dt->toDayDateTimeString() . (' (Asia/Hong_Kong)');
				}
		}
		return $start_time;
	}
	
	public function getReportEndTime(Request $request)
	{
		$end_time = 'Pending..';
		if($request->exists('id')){
			$report = Report::select('id')->where('inspection_id', $request->input('id'))->first();
			if($report){
				$answer = Answer::where('report_id', $report->id)->orderBy('created_at', 'Asc')->first();
				if($answer) {
					$end_time = $answer->created_at->setTimezone('Asia/Hong_Kong')->addHours(8)->toDayDateTimeString() . (' (Asia/Hong_Kong)');
				}
			}
		}
		return $end_time;
	}
}
