<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Inspection;
use App\Serial;
use App\UserInfo;
use Mail;
use File;
use DB;
use \PhpOffice\PhpWord\PhpWord;
use ZipArchive;
use URL;

class SendReportTest extends Controller
{
    public function sendMail(Request $request){
        
        $inspector_id=$request->input('inspector_id');
        $inspector = UserInfo::where("user_id",$inspector_id)->first();
        $inspector_name="Inspector Name";
        if($inspector){
            $inspector_name=$inspector->name;
        }

		$data = ['report_number' =>  $request->input('report_no'),"inspector_name"=>$inspector_name];

        Mail::send('email.report',$data, function($message) use ($data){
            $message->to('rommel@t-i-c.asia');
            //$message->to('rommel@t-i-c.asia');
            $message->cc('gregor@t-i-c.asia');
            $message->cc('manuel@t-i-c.asia');
            $message->cc('jesser@t-i-c.asia');
            //$message->to('ajay@etelligens.in');
            //$message->cc('ajaykr089@gmail.com');
            $message->subject('Inspection Report for ' . $data['report_number']);
        });
        
        if (count(Mail::failures()) > 0) {
            return response()->json([
            	'Error'=>'There was an error sending your mail'
            ],500);
        }else{
        	return response()->json([
            	'message'=>'OK'
            ],200);
        }
    }

    public function downloadzip($id){

        $zip = new ZipArchive;
        
        $zip_name = $id . ".zip";
        
        $zip_path='images/reports/' .$id. '/'.$zip_name;
        $zip_url = URL::asset($zip_path);
       
        @unlink($zip_path);
        

        $zres = $zip->open($zip_path, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

        if ($zres === TRUE) {
            $inpect_info = Inspection::where('reference_number',$id)->first();
            $checklist = Checklist::where('report_number',$id)->first();
            $supplier = Supplier::where('report_number',$id)->first();
            $cargo = Cargo::where('report_number',$id)->first();
            if ($cargo->container_status == 'good' ) {
                //$zip->addFile('images/placeholder.png');
                //$zip->addFile('images/placeholder.png');
            }else{

                if($cargo->container_status_photos!=null && !empty($cargo->container_status_photos)){

                    $container_status_photos=json_decode($cargo->container_status_photos);

                    if(is_array($container_status_photos) && !empty($container_status_photos)){

                        foreach ($container_status_photos as $key => $container_status_photo) {
                              $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$container_status_photo->image);   
                        }
                    }
                }
            }

            if ($cargo->holes == 'yes') {
                //$cargo_holes = 'images/placeholder.png';
                if($cargo->hole_photos!=null && !empty($cargo->hole_photos)){
                    $hole_photos=json_decode($cargo->hole_photos);
                    if(is_array($hole_photos) && !empty($hole_photos)){
                        foreach ($hole_photos as $key => $hole_photo) {
                             $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$hole_photo->image);
                        }
                    }
                   
                }
            }

            if ($cargo->dents == 'yes') {
                //$cargo_dents = 'images/placeholder.png';
                if($cargo->dent_photos!=null && !empty($cargo->dent_photos)){
                    $dent_photos=json_decode($cargo->dent_photos);
                    if(is_array($dent_photos) && !empty($dent_photos)){
                        foreach ($dent_photos as $key => $dent_photo) {
                            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$dent_photo->image);
                        }
                    }
                }
                
            }

            if ($cargo->pallet_material == null) {
                $pallet_material = 'images/placeholder.png';
            }else{
                $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->pallet_material);
               
            }

            if ($cargo->fumigation_stamp == null) {
                $fumigation_stamp = 'images/placeholder.png';
            }else{
                $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->fumigation_stamp);  
            }


            $product_detail = DetailedProduct::where('report_number',$id)->get();
            $product_info = DetailedProductQty::where('report_number',$id)->first();
            $observation = Observation::where('report_number',$id)->first();
            if ($inpect_info->service == 'cbpi_serial') {
                $serials = Serial::where('report_number',$id)->get();
            }
            
            if (!empty($observation->damaged_product_photo)) {
                $zip->addFile('images/reports/'.$cargo->report_number.'/observation/'.$observation->damaged_product_photo);
            }

            $loadings = Loading::where('report_number',$id)->first();

            $desc = DetailedPhotoDescription::where('report_number',$id)->orderBy('photo_count', 'asc')->get();

            $zip->addFile('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_location);
            $zip->addFile('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_gate);
        
            $zip->addFile('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->warehouse);
            $zip->addFile('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->loading_area);
            
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->loading_area);
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors);
            
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->left_side);
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->right_side);
            
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_floor_and_joint);
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_wall_and_joint);

            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_ceiling);
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_doors_closed);
            
            $zip->addFile('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->equipment_interchange_receipt);

            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_number_photo);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->empty_container);


            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->quarter_loaded_container);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->half_loaded_container);


            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->threefourth_loaded_container);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->full_loaded_container);

            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number);

            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number);


            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number);


            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->sera_seal_number);
            $zip->addFile('images/reports/'.$loadings->report_number.'/loading/'.$loadings->warehouse);


            $photos = DetailedPhoto::distinct()->select('photo_count')->where('report_number',$inpect_info->reference_number)->orderBy('photo_count', 'asc')->groupBy('photo_count')->get();

            foreach ($photos as $key => $value) {
            
                $images = DetailedPhoto::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->get();
                $descr = DetailedPhotoDescription::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->first();
                $length = count($images);
                
                foreach ($images as $k => $image) {
                    if ($k % 2 === 0) {
                        
                            if ($k < $length) {
                                 $zip->addFile('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k]->photo_count.'/'.$images[$k]->image_data);
                            }
                            if ($k+1 < $length) {
                               $zip->addFile('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k+1]->photo_count.'/'.$images[$k+1]->image_data);
                            }
                        }
                };

            }

        }

        $zip->close();

        /*header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$zip_name");
        header("Content-length: " . filesize($zip_path));
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        ob_clean();
        flush();*/
        return redirect($zip_url);
        //readfile($zip_path);
    }


    public function loadingReportTest($id){
        
    	$inpect_info = Inspection::where('reference_number',$id)->first();
    	$checklist = Checklist::where('report_number',$id)->first();
    	$supplier = Supplier::where('report_number',$id)->first();
    	$cargo = Cargo::where('report_number',$id)->first();
        
        /*if ($cargo->container_status == 'good' ) {
            $cargo_photo_1 = 'images/placeholder.png';
            $cargo_photo_2 = 'images/placeholder.png';
        }else{
            $cargo_photo_1 = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_damage_1;
            $cargo_photo_2 = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_damage_2;
        }*/

        if ($cargo->cargo_holes == null) {
            $cargo_holes = 'images/placeholder.png';
        }else{
            $cargo_holes = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->cargo_holes;
        }

        if ($cargo->cargo_dents == null) {
            $cargo_dents = 'images/placeholder.png';
        }else{
            $cargo_dents = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->cargo_dents;
        }

        if ($cargo->pallet_material == null) {
            $pallet_material = 'images/placeholder.png';
        }else{
            $pallet_material =  'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->pallet_material;
           
        }

        if ($cargo->fumigation_stamp == null) {
            $fumigation_stamp = 'images/placeholder.png';
        }else{
            $fumigation_stamp =  'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->fumigation_stamp;  
        }


    	$product_detail = DetailedProduct::where('report_number',$id)->get();
    	$product_info = DetailedProductQty::where('report_number',$id)->first();
    	$observation = Observation::where('report_number',$id)->first();

        //var_dump($observation->other_obsetvations);

        //exit();

        if ($inpect_info->service == 'cbpi_serial') {
            $serials = Serial::where('report_number',$id)->get();
        }
        
        if (!empty($observation->damaged_product_photo)) {
            $observation_product_photo = 'images/reports/'.$cargo->report_number.'/observation/'.$observation->damaged_product_photo;
        }else{
            $observation_product_photo = 'images/placeholder.png';
        }
    	$loadings = Loading::where('report_number',$id)->first();

    	$desc = DetailedPhotoDescription::where('report_number',$id)->orderBy('photo_count', 'asc')->get();
        
        $phpWord  = new PHPWord();
        /* Note: any element you append to a document must reside inside of a Section. */

         // Adding an empty Section to the document...
        $section = $phpWord->addSection();
        $header = $section->createHeader();
        if ($inpect_info->service == 'cbpi' || $inpect_info->service == 'cbpi_serial' ) {
             $header->addImage('images/sera.png');
        }else{
             $header->addImage('images/isce.jpg');
        }
        $footer = $section->createFooter();
        $footer->addPreserveText('{PAGE}');
        //create table styles
        $tableStyle = ['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 80, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerStyle = ['bold' => true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];

        $tableCellNormal = ['valign' => 'center','color'=>'000000'];
        $labelStyle = ['bold'=>true,'align'=>'left','spaceAfter' => 0];
        $labelStyleCentered = ['bold'=>true,'align'=>'center','spaceAfter' => 0, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $cellStyle = ['align'=>'left','spaceAfter' => 0];
        $headercellStyle = ['gridSpan'=>'2','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyle4 = ['gridSpan'=>'4','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerTextStyle= ['bold'=>true,'color'=>'FFFFFF'];
        $headerTextStyleBlack= ['bold'=>true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $serialHeaderTextStyle= ['bold'=>true,'color'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $removeCellBottomPadding = ['spaceAfter' => 0];
        $tableHeaderCellStyle =['gridSpan'=>'4','bgColor'=>'909090'];
        
        $tableHeaderCellStyleColumnName =['bgColor'=>'000000'];
        $tableHeaderCellStyleInfo =['gridSpan'=>'7','bgColor'=>'909090'];
        $imageCellDimensions = ['width'=>295,'height'=>250,'spaceAfter' => 0];
        $imageCellDimensions350H = ['width'=>295,'height'=>350,'spaceAfter' => 0];

        /* jesser */
        $imageCellDimensionsThreeCol = ['width'=>196,'height'=>200,'spaceAfter' => 0]; 
      // $imageCellDimensionsThreeCol = ['width'=>295,'height'=>250,'spaceAfter' => 0]; 
        $headerNewCellStyle = ['gridSpan'=>'2','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyleSix = ['gridSpan'=>'6','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $tableHeaderCellStyleSixGrid =['gridSpan'=>'6','bgColor'=>'909090'];
        $removeCellBottomPaddingCenter = ['spaceAfter' => 0, 'align'=>'center'];

        //create actual table for general information
        if ($inpect_info->service == 'cbpi' || $inpect_info->service == 'cbpi_serial' ) {
            $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => 'FF0000']);
        }else{
            $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => '1A5E8F']);
        }
      
        $gentable = $section->addTable('General Info Table');
        $gentable->addRow(50);
        $gentable->addCell(9500, ['gridSpan'=>'4'])->addText('CBPI REPORT', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        $gentable->addRow(50);
        $gentable->addCell(1500, ['align' => 'center'])->addText('Reference:', $labelStyle,$cellStyle);
        $gentable->addCell(8000, ['align' => 'center','gridSpan'=>'3'])->addText($inpect_info->reference_number, $tableCellNormal,$cellStyle);
        $gentable->addRow(50);
        $gentable->addCell(9500, $tableHeaderCellStyle)->addText('1. General Information', $headerTextStyle,$removeCellBottomPadding);
        $gentable->addRow(50);
        $gentable->addCell(1500, ['align' => 'center'])->addText('Date:', $labelStyle,$cellStyle);
        $gentable->addCell(3000, ['align' => 'center'])->addText($inpect_info->inspection_date, $tableCellNormal,$cellStyle);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Place of Inspection:', $labelStyle,$cellStyle);
        $gentable->addCell(3000, ['align' => 'center'])->addText($inpect_info->factory_address, $tableCellNormal,$cellStyle);
        $gentable->addRow(50);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Client Name:', $tableCellNormal,$cellStyle);
        $gentable->addCell(7500, ['align' => 'center','gridSpan'=>'3'])->addText($inpect_info->client_name, $tableCellNormal,$cellStyle);
        $gentable->addRow(50);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Supplier Name:', $tableCellNormal,$cellStyle);
        $gentable->addCell(7500, ['align' => 'center','gridSpan'=>'3'])->addText($inpect_info->supplier_name, $tableCellNormal,$cellStyle);
        $gentable->addRow(50);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Factory Name:', $tableCellNormal,$cellStyle);
        $gentable->addCell(7500, ['align' => 'center','gridSpan'=>'3'])->addText($inpect_info->factory, $tableCellNormal,$cellStyle);
        $section->addTextBreak();

        //create table for inspection checklist
        $phpWord->addTableStyle('Checklist Table', $tableStyle, ['bgColor' => 'FF0000']);
        $checklistTable = $section->addTable('Checklist Table');
        $gentable->addRow(50);
        $gentable->addCell(9500, $tableHeaderCellStyle)->addText('2. Inspection Checklist', $headerTextStyle,$removeCellBottomPadding);
        $gentable->addRow(50);
        $gentable->addCell(9500, ['gridSpan'=>'4','spaceAfter' => 0,'cellMargin'=> 0,'spacing' => 0])->addImage('images/reports/'.$checklist->report_number.'/checklist/'.$checklist->image_path,['width'=>600,'height'=>600,'cellMargin'=>0,'spaceAfter' => 0, 'spacing' => 0]);
        

        //create table for supplier overview
        $phpWord->addTableStyle('Supplier Overview Table', $tableStyle, ['bgColor' => 'FF0000']);
        $supplierTable = $section->addTable('Supplier Overview Table');
        $supplierTable->addRow(50);
        $supplierTable->addCell(9500, $tableHeaderCellStyle)->addText('3. Supplier Overview', $headerTextStyle,$removeCellBottomPadding);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, $headercellStyle)->addText('Factory Location', $headerTextStyleBlack,$removeCellBottomPadding);
        $supplierTable->addCell(4500, $headercellStyle)->addText('Factory Gate Picture', $headerTextStyleBlack,$removeCellBottomPadding);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_location,$imageCellDimensions);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_gate, $imageCellDimensions);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, $headercellStyle)->addText('Warehouse', $headerTextStyleBlack,$removeCellBottomPadding);
        $supplierTable->addCell(4500, $headercellStyle)->addText('Loading Area', $headerTextStyleBlack,$removeCellBottomPadding);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->warehouse,$imageCellDimensions);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->loading_area, $imageCellDimensions);
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();

        //create table for cargo info
        $phpWord->addTableStyle('Cargo Information Table', $tableStyle, ['bgColor' => 'FF0000']);
        $cargoTable = $section->addTable('Cargo Information Table');
        $cargoTable->addRow(50);
        $cargoTable->addCell(9500, $tableHeaderCellStyleSixGrid)->addText('4. Cargo Information', $headerTextStyle,$removeCellBottomPadding);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Inspector Arrival Time:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->inspector_arrival_time, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Cargo Ready Time:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->cargo_ready_time, $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Container Arrival Time:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->container_arrival_time, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Loading Started:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->loading_started, $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Inspection Finished:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->inspection_finished, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Loading Facility Cooperation:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->loading_facility_cooperation), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Container Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->container_number, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Shipping Seal Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->shipping_seal_number), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('SERA Seal Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->sera_seal_number, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Container Size:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(strtoupper($cargo->container_size), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(2500, ['gridSpan'=>'2','align' => 'center'])->addText('Container Status:', $labelStyle,$cellStyle);
        $cargoTable->addCell(7000, ['gridSpan'=>'4','align' => 'center'])->addText(ucwords($cargo->container_status), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(9000, ['align' => 'center','gridSpan'=>'6'])->addText('If Damaged, Please Specify', $labelStyle,$cellStyle);
        $cargoTable->addRow(50);
        if ($cargo->container_status == 'good') {
            $cargoTable->addCell(4500, ['gridSpan'=>'3'])->addText('N/A', $labelStyleCentered,$cellStyle);
            $cargoTable->addCell(4500, ['gridSpan'=>'3'])->addText('N/A', $labelStyleCentered,$cellStyle);
        }else{

            if($cargo->container_status_photos!=null && !empty($cargo->container_status_photos)){

                $container_status_photos=json_decode($cargo->container_status_photos);

                if(is_array($container_status_photos) && !empty($container_status_photos)){

                    foreach ($container_status_photos as $key => $container_status_photo) {
                        $_container_status_photo='images/reports/'.$cargo->report_number.'/cargo/'.$container_status_photo->image;
                        if($key%3==2){
                            $cargoTable->addRow(50);
                        }
                        $cargoTable->addCell(4500, ['gridSpan'=>'3'])->addImage($_container_status_photo, $imageCellDimensions350H);
                    }
                }
            }
        }
       
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Holes:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->holes), $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Dents:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->dents), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);

        if ($cargo->holes == 'yes') {
            $cargoHoles = $cargoTable->addCell(4500, ['gridSpan'=>'3']);
            $cargoHoles->addText('Container Holes');
            //$cargoHoles->addImage($cargo_holes,$imageCellDimensions);

            if($cargo->hole_photos!=null && !empty($cargo->hole_photos)){
                    $hole_photos=json_decode($cargo->hole_photos);
                    if(is_array($hole_photos) && !empty($hole_photos)){
                        $cargoTable->addRow(50);
                        foreach ($hole_photos as $key => $hole_photo) {
                             $_hole_photo='images/reports/'.$cargo->report_number.'/cargo/'.$hole_photo->image;
                             //$cargoHoles->addImage($_hole_photo,$imageCellDimensions);
                             if($key%3==2){
                                 $cargoTable->addRow(50);
                             }
                             $cargoTable->addCell(4500, ['gridSpan'=>'3'])->addImage($_hole_photo, $imageCellDimensions);

                        }
                    }
                   
                }

        }else{
            $cargoTable->addCell(4500, ['gridSpan'=>'3','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER])->addText('N/A', $labelStyleCentered,$cellStyle);
        }

        if ($cargo->dents == 'yes') {
            
           

            $cargoDents = $cargoTable->addCell(4500, ['gridSpan'=>'3']);
            $cargoDents->addText('Container Dents');
            //$cargoDents->addImage($cargo_dents, $imageCellDimensions);

            if($cargo->dent_photos!=null && !empty($cargo->dent_photos)){
                $dent_photos=json_decode($cargo->dent_photos);
                if(is_array($dent_photos) && !empty($dent_photos)){
                    $cargoTable->addRow(50);
                    foreach ($dent_photos as $key => $dent_photo) {
                        $_dent_photo='images/reports/'.$cargo->report_number.'/cargo/'.$dent_photo->image;
                        
                        if($key%3==2){
                            $cargoTable->addRow(50);
                        }

                        $cargoTable->addCell(4500, ['gridSpan'=>'3'])->addImage($_dent_photo, $imageCellDimensions);
                    }
                }
            }

        }else{
            $cargoTable->addCell(4500, ['gridSpan'=>'3','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER])->addText('N/A', $labelStyleCentered,$cellStyle);
        }
        
      

        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Floor Condition:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->floor_condition), $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Doors Condition', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->doors_condition), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(2500, ['gridSpan'=>'2','align' => 'center'])->addText('Light Proof:', $labelStyle,$cellStyle);
        $cargoTable->addCell(7000, ['gridSpan'=>'4','align' => 'center'])->addText(ucwords($cargo->light_proof), $tableCellNormal,$cellStyle);
        $section->addTextBreak();
        $cargoTable->addRow(50);
        $cargoTable->addCell(3166, $headerNewCellStyle)->addText('Front(Doors)', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $cargoTable->addCell(3166, $headerNewCellStyle)->addText('Back', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $cargoTable->addCell(3166,  $headerNewCellStyle)->addText('Left Side', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3166,['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->loading_area,$imageCellDimensionsThreeCol);
        $cargoTable->addCell(3166,['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors, $imageCellDimensionsThreeCol);
        $cargoTable->addCell(3166,['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->left_side,$imageCellDimensionsThreeCol);
        $cargoTable->addRow(50);
       
        $cargoTable->addCell(3166, $headerNewCellStyle)->addText('Right Side', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $cargoTable->addCell(3166, $headerNewCellStyle)->addText('Container Floor and Joint(inside)', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $cargoTable->addCell(3166, $headerNewCellStyle)->addText('Container Wall and Joint(inside)', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $cargoTable->addRow(50);
        
        $cargoTable->addCell(3166,['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->right_side, $imageCellDimensionsThreeCol);
        $cargoTable->addCell(3166,['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_floor_and_joint,$imageCellDimensionsThreeCol);
        $cargoTable->addCell(3166,['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_wall_and_joint, $imageCellDimensionsThreeCol);
        $cargoTable->addRow(50);
        
        $cargoTable->addCell(3166, $headerNewCellStyle)->addText('Container Ceiling(inside)', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $cargoTable->addCell(3166, $headerNewCellStyle)->addText('Container Doors Closed(inside)', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $cargoTable->addCell(3166, $headerNewCellStyle)->addText('Equipment Interchange Receipt(EIR)', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3166,['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_ceiling,$imageCellDimensionsThreeCol);
        $cargoTable->addCell(3166,['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_doors_closed, $imageCellDimensionsThreeCol);
        $cargoTable->addCell(3166,['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->equipment_interchange_receipt,$imageCellDimensionsThreeCol);
        $cargoTable->addRow(50);
        

        
   


        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Palletized Cargo', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->palletized_cargo, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Specify Pallet Material:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->specify_pallet_material, $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);

        if ($cargo->pallet_material == null) {
            $cargoTable->addCell(4500, ['gridSpan'=>'3'])->addText('N/A', $labelStyleCentered,$cellStyle);
        }else{
            
            $cargoPallet = $cargoTable->addCell(4500, ['gridSpan'=>'3','align'=>'center']);
            $cargoPallet->addtext('Pallet Material');
            $cargoPallet->addImage($pallet_material,$imageCellDimensions);
        }

        if ($cargo->pallet_material == null) {
            $cargoTable->addCell(4500, ['gridSpan'=>'3'])->addText('N/A', $labelStyleCentered,$cellStyle);
        }else{
            
            $cargoStamp = $cargoTable->addCell(4500, ['gridSpan'=>'3']);
            $cargoStamp->addText('Fumigation Stamp');
            $cargoStamp->addImage($fumigation_stamp, $imageCellDimensions);
        }
        
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('Number of Pallets Loaded', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->number_of_pallets_loaded, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('From Pallet Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->from_pallet_number, $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center','gridSpan'=>'2'])->addText('To Pallet Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center','gridSpan'=>'4'])->addText($cargo->to_pallet_number, $tableCellNormal,$cellStyle);

        $section->addTextBreak();

        //Product detailed Info table
        $phpWord->addTableStyle('Detailed Product Information', $tableStyle, ['bgColor' => 'FF0000']);
        $productInfo = $section->addTable('Detailed Product Information');
        $productInfo->addRow(50);
        $productInfo->addCell(9500, $tableHeaderCellStyleInfo)->addText('5. Detailed Product Information', $headerTextStyle,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Invoice No.', $headerTextStyleBlack, $removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('P.O.', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Model', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Description', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Packages', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Pieces/Pairs', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Material', $headerTextStyleBlack,$removeCellBottomPadding);
       
        $total = 0;
        foreach ($product_detail as $p) {
            $productInfo->addRow(50);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->invoice_no, $tableCellNormal,$cellStyle);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->po_no, $tableCellNormal,$cellStyle);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->model_number, $tableCellNormal,$cellStyle);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->description, $tableCellNormal,$cellStyle);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->package_qty, $tableCellNormal,$cellStyle);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->pieces, $tableCellNormal,$cellStyle);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->material, $tableCellNormal,$cellStyle);
            $total+= $p->package_qty;
        }
        $productInfo->addRow(50);
        $productInfo->addCell(1350, ['gridSpan'=>'4', 'align' => 'center'])->addText('Total', $tableCellNormal,$cellStyle);
        $productInfo->addCell(1350, ['align' => 'center'])->addText($total, $tableCellNormal,$cellStyle);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormal,$cellStyle);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormal,$cellStyle);


        if ($inpect_info->service == 'cbpi_serial') {
            $section->addTextBreak();
            $phpWord->addTableStyle('Serial Numbers', $tableStyle, ['bgColor' => 'FFFFFF']);
            $serial_no = $section->addTable('Serial Numbers');
            $serial_no->addRow(50);
            $serial_no->addCell(3500, ['align' => 'center'])->addText('Item Name', $serialHeaderTextStyle,$cellStyle);
            $serial_no->addCell(3000, ['align' => 'center'])->addText('Serial Number', $serialHeaderTextStyle,$cellStyle);
            $serial_no->addCell(3000, ['align' => 'center'])->addText('Carton Size', $serialHeaderTextStyle,$cellStyle);

            foreach ($serials as $s) {
                $serial_no->addRow(50);
                $serial_no->addCell(3500, ['align' => 'center'])->addText($s->item_name, $tableCellNormal,$cellStyle);
                $serial_no->addCell(3000, ['align' => 'center'])->addText($s->serial_number, $tableCellNormal,$cellStyle);
                $serial_no->addCell(3000, ['align' => 'center'])->addText($s->carton_size, $tableCellNormal,$cellStyle);
            }

        }
      

        $section->addTextBreak();

        $phpWord->addTableStyle('Detailed Product Additional Information', $tableStyle, ['bgColor' => 'FFFFFF']);
        $productMoreInfo = $section->addTable('Detailed Product Additional Information');
        $productMoreInfo->addRow(50);
        $productMoreInfo->addCell(8500, ['align' => 'center'])->addText('Does the quantity and characteristics of the items from the packing list match exactly with the inspected items?', $labelStyle,$cellStyle);
        $productMoreInfo->addCell(1000, ['align' => 'center'])->addText($product_info->match, $labelStyle,$cellStyle);
        $productMoreInfo->addRow(50);
        $productMoreInfo->addCell(9500, ['gridSpan'=>'2','align' => 'center'])->addText('If not, please specify', $labelStyle,$cellStyle);
        $productMoreInfo->addRow(50);
        $productMoreInfo->addCell(9500, ['gridSpan'=>'2','align' => 'center'])->addText('', $tableCellNormal,$cellStyle);
        $productMoreInfo->addRow(50);
        $productMoreInfo->addCell(8500, ['align' => 'center'])->addText('No. of boxes opened for photos:', $labelStyle,$cellStyle);
        $productMoreInfo->addCell(1000, ['align' => 'center'])->addText($product_info->boxes_opened_photos, $tableCellNormal,$cellStyle);
        $productMoreInfo->addRow(50);
        $productMoreInfo->addCell(8500, ['align' => 'center'])->addText('No. of boxes opened for photos:', $labelStyle,$cellStyle);
        $productMoreInfo->addCell(1000, ['align' => 'center'])->addText($product_info->boxes_opened_revision, $tableCellNormal,$cellStyle);
        $productMoreInfo->addRow(50);
        $productMoreInfo->addCell(8500, ['align' => 'center'])->addText('Total of boxes opened during the inspection:', $labelStyle,$cellStyle);
        $productMoreInfo->addCell(1000, ['align' => 'center'])->addText($product_info->boxes_opened_photos + $product_info->boxes_opened_revision, $tableCellNormal,$cellStyle);

        $section->addTextBreak();

        $phpWord->addTableStyle('Observation', $tableStyle, ['bgColor' => 'FF0000']);
        $observe = $section->addTable('Observation');
        $observe->addRow(50);
        $observe->addCell(9500, $tableHeaderCellStyle)->addText('6. Observation', $headerTextStyle,$removeCellBottomPadding);
        $observe->addRow(50);
        $observe->addCell(8500, ['gridSpan'=>'2','align' => 'center'])->addText('Damaged Products:', $labelStyle,$cellStyle);
        $observe->addCell(1000, ['gridSpan'=>'2','align' => 'center'])->addText($observation->damaged_products, $labelStyle,$cellStyle);
        $observe->addRow(50);
        $observe->addCell(9500, ['gridSpan'=>'4','align' => 'center'])->addText('If not, please specify', $labelStyle,$cellStyle);
        $observe->addRow(50);
            if ($observation->damaged_products == 'no') {
                $observe->addCell(4500, ['gridSpan'=>'4'])->addText('N/A', $labelStyleCentered,$cellStyle);
            }else{
                $observe->addCell(9500, ['gridSpan'=>'4'])->addImage($observation_product_photo,['width'=>600, 'height'=>600]);
            }
        
        $observe->addRow(50);
        $observe->addCell(9500, ['gridSpan'=>'4','align' => 'center'])->addText('Other Observations:', $labelStyle,$cellStyle);
        $observe->addRow(50);
        $observe->addCell(9500, ['gridSpan'=>'4','align' => 'center'])->addText($observation->other_obsetvations, $labelStyle,$cellStyle);
        
        $section->addTextBreak();

        $phpWord->addTableStyle('Loading Pictures', $tableStyle, ['bgColor' => 'FF0000']);
        $loading = $section->addTable('Loading Pictures');
        $loading->addRow(50);
        $loading->addCell(9500, $tableHeaderCellStyleSixGrid)->addText('7. Loading Pictures', $headerTextStyle,$removeCellBottomPadding);
        $loading->addRow(50);
        $loading->addCell(2500, ['gridSpan'=>'3','align' => 'center'])->addText('Container:', $labelStyle,$cellStyle);
        $loading->addCell(7000, ['gridSpan'=>'3','align' => 'center'])->addText($cargo->container_number, $labelStyle,$cellStyle);
        $loading->addRow(50);

        $loading->addCell(3166, $headerNewCellStyle)->addText('Container Number Photo', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $loading->addCell(3166, $headerNewCellStyle)->addText('Empty Container', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $loading->addCell(3166, $headerNewCellStyle)->addText('25% Loaded Container', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $loading->addRow(50);
        $loading->addCell(3166, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_number_photo, $imageCellDimensionsThreeCol);
        $loading->addCell(3166, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->empty_container,$imageCellDimensionsThreeCol);
        $loading->addCell(3166, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->quarter_loaded_container, $imageCellDimensionsThreeCol);
        $loading->addRow(50);
        
        $loading->addCell(3166, $headerNewCellStyle)->addText('Half Loaded Container', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $loading->addCell(3166, $headerNewCellStyle)->addText('75% Loaded Container', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $loading->addCell(3166, $headerNewCellStyle)->addText('Full Loaded Container', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $loading->addRow(50);
        $loading->addCell(3166, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->half_loaded_container,$imageCellDimensionsThreeCol);
        $loading->addCell(3166, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->threefourth_loaded_container, $imageCellDimensionsThreeCol);
        $loading->addCell(3166, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->full_loaded_container,$imageCellDimensionsThreeCol);      
        $loading->addRow(50);

            
        $loading->addCell(3166, $headerNewCellStyle)->addText('Container Closed Seals', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $loading->addCell(3166, $headerNewCellStyle)->addText('Shipping Seal Number', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $loading->addCell(3166, $headerNewCellStyle)->addText('SERA Seal number', $headerTextStyleBlack,$removeCellBottomPaddingCenter);
        $loading->addRow(50);      
        $loading->addCell(3166, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals, $imageCellDimensionsThreeCol);
        $loading->addCell(3166, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number,$imageCellDimensionsThreeCol);
        $loading->addCell(3166, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->sera_seal_number, $imageCellDimensionsThreeCol);
        $loading->addRow(50);
        
        $loading->addCell(4500, $headercellStyleSix)->addText('Warehouse', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addRow(50);        
        $loading->addCell(9500, ['gridSpan'=>'6'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->warehouse,['width'=>600, 'height'=>520]);

      
        $section->addTextBreak();
        $phpWord->addTableStyle('Detailed Photos', $tableStyle, ['bgColor' => 'FF0000']);
        $detailed_photos = $section->addTable('Detailed Photos');
        $detailed_photos->addRow(50);
        $detailed_photos->addCell(9500, $tableHeaderCellStyle)->addText('8. Detailed Pictures', $headerTextStyle,$removeCellBottomPadding);

        $photos = DetailedPhoto::distinct()->select('photo_count')->where('report_number',$inpect_info->reference_number)->orderBy('photo_count', 'asc')->groupBy('photo_count')->get();


        foreach ($photos as $key => $value) {
            $images = DetailedPhoto::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->orderByRaw('cast(SUBSTRING_INDEX(SUBSTRING_INDEX(image_data, "-", -2), "-", 1) as unsigned) ASC')->get();
           $descr = DetailedPhotoDescription::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->first();

            $length = count($images);
            //$section->addTextBreak();
            $phpWord->addTableStyle($descr->product_description, $tableStyle, ['bgColor' => 'FFFFFF']);
            $key = $section->addTable($descr->product_description);
            $key->addRow(50);
            $key->addCell(9500, ['gridSpan'=>'6','align' => 'center'])->addText($descr->product_description, $labelStyle,$cellStyle);

            foreach ($images as $k => $image) {
                if ($k % 3 === 0) {
                    $key->addRow(50);   
                    if ($k < $length) {
                        $key->addCell(3166, $headerNewCellStyle)->addText($images[$k]->photo_label, $headerTextStyleBlack,$removeCellBottomPaddingCenter);
                    }
                    if ($k+1 < $length) {
                       $key->addCell(3166, $headerNewCellStyle)->addText($images[$k+1]->photo_label, $headerTextStyleBlack,$removeCellBottomPaddingCenter);
                    }
                    if ($k+2 < $length) {
                        $key->addCell(3166, $headerNewCellStyle)->addText($images[$k+2]->photo_label, $headerTextStyleBlack,$removeCellBottomPaddingCenter);
                     }
                    
                    $key->addRow(50);
                    if ($k < $length) {
                         $key->addCell(3166, ['gridSpan'=>'2','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k]->photo_count.'/'.$images[$k]->image_data, $imageCellDimensionsThreeCol );
                    }
                    if ($k+1 < $length) {
                       $key->addCell(3166, ['gridSpan'=>'2','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k+1]->photo_count.'/'.$images[$k+1]->image_data,$imageCellDimensionsThreeCol );
                    }
                    if ($k+2 < $length) {
                        $key->addCell(3166, ['gridSpan'=>'2','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k+2]->photo_count.'/'.$images[$k+2]->image_data,$imageCellDimensionsThreeCol );
                     }
                    
                }
            }

        }


        /*foreach ($photos as $key => $value) {
            
            $_images = DetailedPhoto::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->orderByRaw('cast(SUBSTRING_INDEX(SUBSTRING_INDEX(image_data, "-", -2), "-", 1) as unsigned) ASC')->get();

           $descr = DetailedPhotoDescription::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->first();

            $length = count($_images);
            $section->addTextBreak();
            $phpWord->addTableStyle($descr->product_description, $tableStyle, ['bgColor' => 'FFFFFF']);
            $key = $section->addTable($descr->product_description);
            $key->addRow(50);
            $key->addCell(9500, ['gridSpan'=>'4','align' => 'center'])->addText($descr->product_description, $labelStyle,$cellStyle);
            foreach ($images as $k => $image) {
                if ($k % 2 === 0) {
                    $key->addRow(50);   
                    if ($k < $length) {
                        $key->addCell(4500, $headercellStyle)->addText($images[$k]->photo_label, $headerTextStyleBlack,$removeCellBottomPadding);
                    }
                    if ($k+1 < $length) {
                       $key->addCell(4500, $headercellStyle)->addText($images[$k+1]->photo_label, $headerTextStyleBlack,$removeCellBottomPadding);
                    }

                    $key->addRow(50);
                    if ($k < $length) {
                         $key->addCell(4500, ['gridSpan'=>'2','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k]->photo_count.'/'.$images[$k]->image_data, $imageCellDimensions);
                    }
                    if ($k+1 < $length) {
                       $key->addCell(4500, ['gridSpan'=>'2','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k+1]->photo_count.'/'.$images[$k+1]->image_data,$imageCellDimensions);
                    }
                    }
            };
            echo "<br/>------------------------------------------------------------------------------------------------------<br/>";
            $new_images=array_chunk($_images->toArray(),2);

            foreach ($new_images as $k => $images) {

                foreach ($images as $dd => $image) {
                    
                    echo $image['photo_label'];
                    echo $image['image_data'];

                    //$key->addCell(4500, $headercellStyle)->addText($image['photo_label'], $headerTextStyleBlack,$removeCellBottomPadding);
                    //$key->addCell(4500, ['gridSpan'=>'2','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$image['photo_count'].'/'.$image['image_data'], $imageCellDimensions);
                }

                echo "<br/>------------------------------------------------------------------------------------------------------<br/>";

                //$key->addRow(50);

            }

        }


        exit();*/



        $file = $inpect_info->reference_number.'.docx';
        // Saving the document as HTML file...
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');

    }

    public function testCount()
    {   
        $photos = DetailedPhoto::distinct()->select('photo_count')->where('report_number','SR12345')->orderBy('photo_count', 'asc')->groupBy('photo_count')->get();
        $images = DetailedPhoto::where('report_number','SR12345')->where('photo_count',0)->get();
        $length = count($images);

        return response()->json([
            'photo'=> $photos,
            'images'=> $images,
            'length'=>$length
        ]);
    }
}
