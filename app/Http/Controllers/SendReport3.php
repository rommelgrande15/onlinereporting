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
use Mail;
use File;
use DB;
use \PhpOffice\PhpWord\PhpWord;


class SendReport3 extends Controller
{
    public function sendMail(Request $request){
		$data = ['report_number' =>  $request->input('report_no')];
        Mail::send('email.report',$data, function($message) use ($data){
            $message->to('rommel@t-i-c.asia');
            $message->cc('gregor@t-i-c.asia');
        
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

    public function reportsA3($id){
    	$inpect_info = Inspection::where('reference_number',$id)->first();
    	$checklist = Checklist::where('report_number',$id)->first();
    	$supplier = Supplier::where('report_number',$id)->first();
    	$cargo = Cargo::where('report_number',$id)->first();
        if ($cargo->container_status == 'good' ) {
            $cargo_photo_1 = 'images/placeholder.png';
            $cargo_photo_2 = 'images/placeholder.png';
        }else{
            $cargo_photo_1 = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_damage_1;
            $cargo_photo_2 = 'images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_damage_2;
        }

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
        $tableStyle = ['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerStyle = ['bold' => true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];

        $tableCellNormal = ['valign' => 'center','color'=>'000000'];
        $tableCellNormal2 = ['valign' => 'center','color'=>'red'];// joe
        
        $labelStyle = ['bold'=>true,'align'=>'left','spaceAfter' => 0];
        $labelStyleCentered = ['bold'=>true,'align'=>'center','spaceAfter' => 0, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $cellStyle = ['align'=>'left','spaceAfter' => 0];
        $cellStyle2 = ['align'=>'center','spaceAfter' => 0,'color'=>'red'];
        $headercellStyle = ['gridSpan'=>'2','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyle4 = ['gridSpan'=>'4','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerTextStyle= ['bold'=>true,'color'=>'FFFFFF'];
        $headerTextStyle2= ['bold'=>true,'color'=>'black']; // font color black
        $headerTextStyle3= ['Regular'=>true,'color'=>'black']; // font color black
        $headerTextStyleBlack= ['bold'=>true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $serialHeaderTextStyle= ['bold'=>true,'color'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $removeCellBottomPadding = ['spaceAfter' => 0];
        $tableHeaderCellStyle =['gridSpan'=>'4','bgColor'=>'909090'];
        $tableHeaderCellStyleColumnName =['bgColor'=>'000000'];
        $tableHeaderCellStyleInfo =['gridSpan'=>'7','bgColor'=>'909090'];
        $tableHeaderCellStyleInfo2 =['gridSpan'=>'7','bgColor'=>'white']; //color white shadding
        $imageCellDimensions = ['width'=>295,'height'=>250,'spaceAfter' => 0];
        $imageCellDimensions350H = ['width'=>295,'height'=>350,'spaceAfter' => 0];
        
        
        //create actual table for general information
        if ($inpect_info->service == 'cbpi' || $inpect_info->service == 'cbpi_serial' ) {
            $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => 'FF0000']);
        }else{
            $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => '1A5E8F']);
        }
      /* 
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
        $cargoTable->addCell(9500, $tableHeaderCellStyle)->addText('4. Cargo Information', $headerTextStyle,$removeCellBottomPadding);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Inspector Arrival Time:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->inspector_arrival_time, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Cargo Ready Time:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->cargo_ready_time, $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Container Arrival Time:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->container_arrival_time, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Loading Started:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->loading_started, $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Inspection Finished:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->inspection_finished, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Loading Facility Cooperation:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->loading_facility_cooperation), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Container Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->container_number, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Shipping Seal Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->shipping_seal_number), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('SERA Seal Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->sera_seal_number, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Container Size:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(strtoupper($cargo->container_size), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(2500, ['gridSpan'=>'1','align' => 'center'])->addText('Container Status:', $labelStyle,$cellStyle);
        $cargoTable->addCell(7000, ['gridSpan'=>'3','align' => 'center'])->addText(ucwords($cargo->container_status), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(9000, ['align' => 'center','gridSpan'=>'4'])->addText('If Damaged, Please Specify', $labelStyle,$cellStyle);
        $cargoTable->addRow(50);
        if ($cargo->container_status == 'good') {
            $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addText('N/A', $labelStyleCentered,$cellStyle);
            $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addText('N/A', $labelStyleCentered,$cellStyle);
        }else{
            $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage($cargo_photo_1,$imageCellDimensions350H);
            $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage($cargo_photo_2,$imageCellDimensions350H);
        }
       
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Holes:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->holes), $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Dents:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->dents), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        if ($cargo->holes == 'yes') {
            $cargoHoles = $cargoTable->addCell(4500, ['gridSpan'=>'2']);
            $cargoHoles->addText('Container Holes');
            $cargoHoles->addImage($cargo_holes,$imageCellDimensions);
        }else{
            $cargoTable->addCell(4500, ['gridSpan'=>'2','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER])->addText('N/A', $labelStyleCentered,$cellStyle);
        }

        if ($cargo->dents == 'yes') {
            $cargoDents = $cargoTable->addCell(4500, ['gridSpan'=>'2']);
            $cargoDents->addText('Container Dents');
            $cargoDents->addImage($cargo_dents, $imageCellDimensions);
        }else{
            $cargoTable->addCell(4500, ['gridSpan'=>'2','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER])->addText('N/A', $labelStyleCentered,$cellStyle);
        }
        
      

        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Floor Condition:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->floor_condition), $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Doors Condition', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText(ucwords($cargo->doors_condition), $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(2500, ['gridSpan'=>'1','align' => 'center'])->addText('Light Proof:', $labelStyle,$cellStyle);
        $cargoTable->addCell(7000, ['gridSpan'=>'3','align' => 'center'])->addText(ucwords($cargo->light_proof), $tableCellNormal,$cellStyle);
        $section->addTextBreak();

        $cargoTable->addRow(50);
        $cargoTable->addCell(4500, $headercellStyle)->addText('Front(Doors)', $headerTextStyleBlack,$removeCellBottomPadding);
        $cargoTable->addCell(4500, $headercellStyle)->addText('Back', $headerTextStyleBlack,$removeCellBottomPadding);
        $cargoTable->addRow(50);
        $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->loading_area,$imageCellDimensions);
        $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors, $imageCellDimensions);
        $cargoTable->addRow(50);
        $cargoTable->addCell(4500, $headercellStyle)->addText('Left Side', $headerTextStyleBlack,$removeCellBottomPadding);
        $cargoTable->addCell(4500, $headercellStyle)->addText('Right Side', $headerTextStyleBlack,$removeCellBottomPadding);
        $cargoTable->addRow(50);
        $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->left_side,$imageCellDimensions);
        $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->right_side, $imageCellDimensions);
        $cargoTable->addRow(50);
        $cargoTable->addCell(4500, $headercellStyle)->addText('Container Floor and Joint(inside)', $headerTextStyleBlack,$removeCellBottomPadding);
        $cargoTable->addCell(4500, $headercellStyle)->addText('Container Wall and Joint(inside)', $headerTextStyleBlack,$removeCellBottomPadding);
        $cargoTable->addRow(50);
        $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_floor_and_joint,$imageCellDimensions);
        $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_wall_and_joint, $imageCellDimensions);
        $cargoTable->addRow(50);
        $cargoTable->addCell(4500, $headercellStyle)->addText('Container Ceiling(inside)', $headerTextStyleBlack,$removeCellBottomPadding);
        $cargoTable->addCell(4500, $headercellStyle)->addText('Container Doors Closed(inside)', $headerTextStyleBlack,$removeCellBottomPadding);
        $cargoTable->addRow(50);
        $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_ceiling,$imageCellDimensions);
        $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_doors_closed, $imageCellDimensions);
        $cargoTable->addRow(50);
        $cargoTable->addCell(9500, $headercellStyle4)->addText('Equipment Interchange Receipt(EIR)', $headerTextStyleBlack,$removeCellBottomPadding);
        $cargoTable->addRow(50);
        $cargoTable->addCell(9500, ['gridSpan'=>'4'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->equipment_interchange_receipt,['width'=>600, 'height'=>520]);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Palletized Cargo', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->palletized_cargo, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Specify Pallet Material:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->specify_pallet_material, $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);

        if ($cargo->pallet_material == null) {
            $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addText('N/A', $labelStyleCentered,$cellStyle);
        }else{
            
            $cargoPallet = $cargoTable->addCell(4500, ['gridSpan'=>'2','align'=>'center']);
            $cargoPallet->addtext('Pallet Material');
            $cargoPallet->addImage($pallet_material,$imageCellDimensions);
        }

        if ($cargo->pallet_material == null) {
            $cargoTable->addCell(4500, ['gridSpan'=>'2'])->addText('N/A', $labelStyleCentered,$cellStyle);
        }else{
            
            $cargoStamp = $cargoTable->addCell(4500, ['gridSpan'=>'2']);
            $cargoStamp->addText('Fumigation Stamp');
            $cargoStamp->addImage($fumigation_stamp, $imageCellDimensions);
        }
        
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('Number of Pallets Loaded', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->number_of_pallets_loaded, $tableCellNormal,$cellStyle);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('From Pallet Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->from_pallet_number, $tableCellNormal,$cellStyle);
        $cargoTable->addRow(50);
        $cargoTable->addCell(3000, ['align' => 'center'])->addText('To Pallet Number:', $labelStyle,$cellStyle);
        $cargoTable->addCell(1750, ['align' => 'center'])->addText($cargo->to_pallet_number, $tableCellNormal,$cellStyle);

        $section->addTextBreak(); */

        //Product detailed Info table
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();
        $phpWord->addTableStyle('Detailed Product Information', $tableStyle, ['bgColor' => 'FF0000']);
        $productInfo = $section->addTable('Detailed Product Information');
        $productInfo->addRow(50);
        $productInfo->addCell(9500, $tableHeaderCellStyleInfo)->addText('6. Detailed Product Information', $headerTextStyle,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(9500, $tableHeaderCellStyleInfo2)->addText('Total Quantity Loaded:	', $headerTextStyle2,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Lot No.', $headerTextStyleBlack, $removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('P.O.', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Model', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Description', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Packages (Pallets)', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(1350, $tableHeaderCellStyleColumnName)->addText('Pieces (Drums)', $headerTextStyleBlack,$removeCellBottomPadding);
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
        $productInfo->addCell(1350, ['gridSpan'=>'4', 'align' => 'center'])->addText('Total', $tableCellNormal2,$cellStyle2);
        $productInfo->addCell(1350, ['align' => 'center'])->addText($total, $tableCellNormal2,$cellStyle2);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormal2,$cellStyle2);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormal2,$cellStyle2);


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

        $phpWord->addTableStyle('If not, please specify:', $tableStyle, ['bgColor' => 'ffffff']);
        $productInfo2 = $section->addTable('If not, please specify:',array( 'afterSpacing' => 0, 'Spacing'=> 0));
        $productInfo2->addRow(50);
        $productInfo2->addCell(7500, ['align' => 'left','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1])->addText('Does the quantity and characteristics of the items from the packing list match exactly with the inspected items?',['size'=>12]);
        $cell = $productInfo2->addCell(2000, ['valign' => 'center','align' => 'left','borderLeftSize'=>1,'borderLeftColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1]);
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>800, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(50);
        $innerTable->addCell(500,['bgcolor'=>'white'])->addText('Yes');
        $innerTable->addCell(500,['bgcolor'=>'white']);
        $innerTable->addCell(500,['bgcolor'=>'white'])->addText('No');
        $innerTable->addCell(500,['bgcolor'=>'white']);
        
        $productInfo2->addRow(50);
        $productInfo2->addCell(9500,['gridSpan'=>2,'borderTopColor'=>'white','borderBottomColor'=>'white','bgcolor'=>'white','borderTopSize'=>1,'borderBottomSize'=>1,'valign' => 'bottom','spaceAfter'=>0])->addText('If not, please specify:',['size'=>12,'bold' => true,'valign' => 'bottom','spaceAfter'=>0,'lineHeight' => 1]);
        $productInfo2->addRow(50);
        $cell = $productInfo2->addCell(9500, ['gridSpan'=>2,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(50);
        $innerTable->addCell(9500,['bgcolor'=>'white'])->addText('Yes');

        $productInfo2->addRow(50);
        $cell = $productInfo2->addCell(9500, ['gridSpan'=>2,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);
        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000));
        /* $innerTable->addRow(50,['align'=>'left']); */
        
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4000,['bgcolor'=>'white','align'=>'left','valign' => 'center'])->addText('Total number of packages opened:');
        $innerTable->addCell(1500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('0',['align'=>'center'],['align'=>'center']);
       
        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4000,['bgcolor'=>'white','align'=>'left','valign' => 'center'])->addText('Total number of packages inspected:');
        $innerTable->addCell(1500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('0',['align'=>'center'],['align'=>'center']);

        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4000,['bgcolor'=>'white','align'=>'left','valign' => 'center'])->addText('Total number or SERA Stickers used:');
        $innerTable->addCell(1500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('0',['align'=>'center'],['align'=>'center']);

        
        
        $section->addTextBreak();
        $section->addTextBreak();
        $section->addTextBreak();

        $phpWord->addTableStyle('If not, please specify:', $tableStyle, ['bgColor' => 'ffffff']);
        $productInfo2 = $section->addTable('If not, please specify:',array( 'afterSpacing' => 0, 'Spacing'=> 0));
        $productInfo2->addRow(50);
        $cell = $productInfo2->addCell(9500, ['gridSpan'=>2,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(50);
        $innerTable->addCell(9500, $tableHeaderCellStyleInfo)->addText('7. Observations', $headerTextStyle,$removeCellBottomPadding);

        $productInfo2->addRow(50);
        $cell = $productInfo2->addCell(9500, ['gridSpan'=>2,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);
        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000));
        /* $innerTable->addRow(50,['align'=>'left']); */
        
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(2000,['bgcolor'=>'white','align'=>'left','valign' => 'center'])->addText('Damaged Products:',['bold' => true]);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('Yes',['align'=>'center'],['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText(' ',['align'=>'center'],['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('No',['align'=>'center'],['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText(' ',['align'=>'center'],['align'=>'center']);

        
        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000,'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1,'borderLeftSize'=>1,'borderBottomColor'=>'white','borderTopColor'=>'white','borderTopSize'=>1,'borderLeftColor'=>'white','borderLeftSize'=>1])->addText('If yes, please specify:',['bold' => true]);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('');

        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000,'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1,'borderLeftSize'=>1,'borderBottomColor'=>'white','borderTopColor'=>'white','borderTopSize'=>1,'borderLeftColor'=>'white','borderLeftSize'=>1])->addText('Other Observations: ',['bold' => true]);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText(' ');
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center','bgcolor'=>'white','align'=>'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1,'borderLeftSize'=>1,'borderBottomColor'=>'white','borderTopColor'=>'white','borderTopSize'=>1,'borderLeftColor'=>'white','borderLeftSize'=>1])->addText(' ');
       
        
        $section->addTextBreak();
        $phpWord->addTableStyle('Loading Pictures', $tableStyle, ['bgColor' => 'gray']);
        $productInfo = $section->addTable('Loading Pictures');
        $productInfo->addRow(50);
        $productInfo->addCell(9500, ['gridSpan'=>'4'])->addText('8. Loading Pictures', $headerTextStyle,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(2500, ['gridSpan'=>'2','align' => 'center','bgColor' => 'white'])->addText('Container:', $labelStyle,$cellStyle);
        $productInfo->addCell(7000, ['gridSpan'=>'2','align' => 'center','bgColor' => 'white'])->addText($cargo->container_number, $labelStyle,$cellStyle);
        $productInfo->addRow(50);
        $productInfo->addCell(4500, $headercellStyle)->addText('Container Number Photo', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(4500, $headercellStyle)->addText('Empty Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_number_photo, $imageCellDimensions) */;
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->empty_container,$imageCellDimensions) */;

        $productInfo->addRow(50);
        $productInfo->addCell(4500, $headercellStyle)->addText('25% Loaded Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(4500, $headercellStyle)->addText('Half Loaded Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->quarter_loaded_container, $imageCellDimensions) */;
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->half_loaded_container,$imageCellDimensions) */;

        $productInfo->addRow(50);
        $productInfo->addCell(4500, $headercellStyle)->addText('75% Loaded Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(4500, $headercellStyle)->addText('Full Loaded Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->threefourth_loaded_container, $imageCellDimensions) */;
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->full_loaded_container,$imageCellDimensions) */;

        $productInfo->addRow(50);        
        $productInfo->addCell(4500, $headercellStyle)->addText('Container Closed Seals', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(4500, $headercellStyle)->addText('Shipping Seal Number', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addRow(50);
        
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals, $imageCellDimensions) */;
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number,$imageCellDimensions) */;

        $productInfo->addRow(50);
        $productInfo->addCell(4500, $headercellStyle)->addText('Shipping Seal number', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addCell(4500, $headercellStyle)->addText('Warehouse', $headerTextStyleBlack,$removeCellBottomPadding);
        $productInfo->addRow(50);
        
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->sera_seal_number, $imageCellDimensions) */;
        $productInfo->addCell(4500, ['gridSpan'=>'2'])/* ->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->warehouse,$imageCellDimensions) */;
        

        
/* 
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
        $observe->addCell(9500, ['gridSpan'=>'4','align' => 'center'])->addText($observation->other_observations, $labelStyle,$cellStyle);
        
        $section->addTextBreak();

        $phpWord->addTableStyle('Loading Pictures', $tableStyle, ['bgColor' => 'FF0000']);
        $loading = $section->addTable('Loading Pictures');
        $loading->addRow(50);
        $loading->addCell(9500, $tableHeaderCellStyleInfo)->addText('7. Loading Pictures', $headerTextStyle,$removeCellBottomPadding);
        $loading->addRow(50);
        $loading->addCell(2500, ['gridSpan'=>'2','align' => 'center'])->addText('Container:', $labelStyle,$cellStyle);
        $loading->addCell(7000, ['gridSpan'=>'2','align' => 'center'])->addText($cargo->container_number, $labelStyle,$cellStyle);
        $loading->addRow(50);
        $loading->addCell(4500, $headercellStyle)->addText('Container Number Photo', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addCell(4500, $headercellStyle)->addText('Empty Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addRow(50);
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_number_photo, $imageCellDimensions);
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->empty_container,$imageCellDimensions);

        $loading->addRow(50);
        $loading->addCell(4500, $headercellStyle)->addText('25% Loaded Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addCell(4500, $headercellStyle)->addText('Half Loaded Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addRow(50);
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->quarter_loaded_container, $imageCellDimensions);
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->half_loaded_container,$imageCellDimensions);

        $loading->addRow(50);
        $loading->addCell(4500, $headercellStyle)->addText('75% Loaded Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addCell(4500, $headercellStyle)->addText('Full Loaded Container', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addRow(50);
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->threefourth_loaded_container, $imageCellDimensions);
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->full_loaded_container,$imageCellDimensions);

        $loading->addRow(50);        
        $loading->addCell(4500, $headercellStyle)->addText('Container Closed Seals', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addCell(4500, $headercellStyle)->addText('Shipping Seal Number', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addRow(50);
        
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals, $imageCellDimensions);
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number,$imageCellDimensions);

        $loading->addRow(50);
        $loading->addCell(4500, $headercellStyle)->addText('Shipping Seal number', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addCell(4500, $headercellStyle)->addText('Warehouse', $headerTextStyleBlack,$removeCellBottomPadding);
        $loading->addRow(50);
        
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->sera_seal_number, $imageCellDimensions);
        $loading->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->warehouse,$imageCellDimensions);

      
        $section->addTextBreak();
        $phpWord->addTableStyle('Detailed Photos', $tableStyle, ['bgColor' => 'FF0000']);
        $detailed_photos = $section->addTable('Detailed Photos');
        $detailed_photos->addRow(50);
        $detailed_photos->addCell(9500, $tableHeaderCellStyle)->addText('8. Detailed Pictures', $headerTextStyle,$removeCellBottomPadding);

        $photos = DetailedPhoto::distinct()->select('photo_count')->where('report_number',$inpect_info->reference_number)->orderBy('photo_count', 'asc')->groupBy('photo_count')->get();

        foreach ($photos as $key => $value) {
            
            $images = DetailedPhoto::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->get();
            $descr = DetailedPhotoDescription::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->first();
            $length = count($images);
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

        }

 */




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
