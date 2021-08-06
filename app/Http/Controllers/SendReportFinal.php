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


class SendReportFinal extends Controller
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
           // $message->cc('gregor@t-i-c.asia');
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

    public function SendReportFinal($id){
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
        $sectionStyle=array( 'marginLeft'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5), 'marginRight'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5), 'marginTop'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.25), 'marginBottom'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.25),'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2),'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2));

 
    $section = $phpWord->addSection($sectionStyle);


        $header = $section->createHeader();
        if ($inpect_info->service == 'cbpi' || $inpect_info->service == 'cbpi_serial' ) {
             $header->addImage('images/sera.png',['marginTop' => 0]);
        }else{
             $header->addImage('images/isce.jpg',['marginTop' => 0]);
        }
        $footer = $section->createFooter();
        $footer->addPreserveText('{PAGE}');
        //create table styles
        $tableStyle = ['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 80];
        $headerStyle = ['bold' => true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];

        $tableCellNormal = ['valign' => 'center','color'=>'000000','size' => 12];
        $tableCellNormalJess = ['valign' => 'center','align' => 'center','color'=>'000000'];
        $tableCellNormal2 = ['valign' => 'center','color'=>'red'];// joe
        $labelStyle = ['bold'=>true,'align'=>'left','spaceAfter' => 0,'size' => 12]; //jesser
        $labelStyleCentered = ['bold'=>true,'align'=>'center','spaceAfter' => 0, 'size'=>12, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $cellStyle = ['align'=>'left','spaceAfter' => 0];
        $cellStyle2 = ['align'=>'center','spaceAfter' => 0,'color'=>'red'];
        $headercellStyle = ['gridSpan'=>'2','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyle4 = ['gridSpan'=>'4','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerTextStyle= ['bold'=>true,'color'=>'FFFFFF', 'size' => 12];
        $headerTextStyle2= ['bold'=>true,'color'=>'black']; // font color black
        $headerTextStyle3= ['Regular'=>true,'color'=>'black']; // font color black
        $headerTextStyleBlack= ['bold'=>true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'valign'=>'center'];
        $headerTextStyleBlackNotBold= ['color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 'valign'=>'center'];
        $serialHeaderTextStyle= ['bold'=>true,'color'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $removeCellBottomPadding = ['spaceAfter' => 0];
        $tableHeaderCellStyle =['gridSpan'=>'4','bgColor'=>'909090'];
        $tableHeaderCellStyleColumnName =['bgColor'=>'000000','align'=>'center','valign'=>'center','size' => 10];
        $tableHeaderCellStyleInfo =['gridSpan'=>'7','bgColor'=>'909090'];
        $tableHeaderCellStyleInfo2 =['gridSpan'=>'7','bgColor'=>'white']; //color white shadding
        //$imageCellDimensions = ['width'=>295,'height'=>250,'spaceAfter' => 0];

        $imageCellDimensions = ['width'=>295,'height'=>250,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center'];
        $imageCellDimensions350H = ['width'=>295,'height'=>350,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center'];
        
        $imageCellDimensionsNew = ['width'=>245,'height'=>200,'spaceAfter' => 0, 'align'=>'center', 'valign'=>'center'];
        
        //jesser
        $labelStyleSize = ['align'=>'left', 'valign' => 'center','size' => 12];
        $cellStyleBorder = ['align'=>'left', 'valign' => 'center', 'borderSize' => 1 ];
        $labelStyle3 = ['bold'=>true,'align'=>'left','spaceAfter' => 0, 'color' => 'ff0000','size' => 12];
        $cellStyleCenter = ['align'=>'center','spaceAfter' => 0];
        
        //create actual table for general information
        /* if ($inpect_info->service == 'cbpi' || $inpect_info->service == 'cbpi_serial' ) {
            $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => '266baf']);
        }else{
            $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => '1A5E8F']);
        } */

        $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => 'red']);

        $gen_table_cell_style=['align' => 'center','gridSpan'=>'3', 'borderLeftSize'=>0,'borderLeftColor'=>'ffffff'];
        $gen_table_cell_style2=['align' => 'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'ffffff'];
        $gen_txt_box_style=['width'=> 450,'height'=> 30,'borderSize'=> 1,'borderColor' => 'FF0000', 'align' => 'left'];

        /* 1. General Information	 */
        $gentable = $section->addTable('General Info Table');
        $gentable->addRow(50);
        $gentable->addCell(9500, ['gridSpan'=>'4'])->addText('CBPI REPORT', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        $gentable->addRow(50);
        $gentable->addCell(1500, ['align' => 'center'])->addText('Reference:', $labelStyle,$cellStyle);
        $gentable->addCell(8000, ['align' => 'center','gridSpan'=>'3'])->addText($inpect_info->reference_number, $tableCellNormal,$cellStyle);
        $gentable->addRow(50);
        $gentable->addCell(9500, $tableHeaderCellStyle)->addText('1. General Information', $headerTextStyle,$removeCellBottomPadding);
        $gentable->addRow(50);

       

        $gentable->addCell(500, ['align' => 'center','valign' => 'center','borderSize'=>1,'borderRightColor'=>'ffffff','borderBottomColor'=>'ffffff'])->addText('Date:', $tableCellNormal,$cellStyle);
        $gentable2 = $gentable->addCell(4000,['align' => 'left', 'borderLeftSize'=>0,'borderLeftColor'=>'ffffff','borderRightSize'=>0,'borderRightColor'=>'ffffff','borderBottomSize'=>1,'borderBottomColor'=>'ffffff']);
        $gentable2->addText('',['size' => 0,'lineHeight' =>0.0001]);
        $innerTable = $gentable2->addTable(['valign'=>'center','borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50]);
        $gentable2->addTextBreak();
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4000)->addText($inpect_info->inspection_date);
        
        $gentable->addCell(500, ['align' => 'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'ffffff', 'borderLeftSize'=>1,'borderLeftColor'=>'ffffff','borderBottomSize'=>1,'borderBottomColor'=>'ffffff'])->addText('Place of Inspection:',$tableCellNormal,$cellStyle);
        $gentable2 = $gentable->addCell(4500,['align' => 'center', 'borderLeftSize'=>1,'borderLeftColor'=>'ffffff','borderBottomSize'=>1,'borderBottomColor'=>'ffffff']);
        $gentable2->addText('',['size' => 0,'lineHeight' =>0.0001]);
        $innerTable = $gentable2->addTable(['valign'=>'center','borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50]);
        $gentable2->addTextBreak();
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(4500)->addText($inpect_info->factory_address);
        $gentable->addRow(50);
        
        $table_style = array(
            'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
            'width' => 100 * 50,
          );
          
        $cell = $gentable->addCell(9500, ['gridSpan'=>4,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);

        $innerTable = $cell->addTable(['valign'=>'center','borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50, 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
        'width' => 100 * 50]);
        
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(2000,['bgcolor'=>'white','align'=>'left','valign' => 'center','borderSize'=>1,'borderTopColor'=>'white','borderLeftColor'=>'white','borderBottomColor'=>'white'])->addText('Client Name',$tableCellNormal,$cellStyle);
        $innerTable->addCell(7500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($inpect_info->client_name,['align'=>'center'],['align'=>'center']);

        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(2000,['bgcolor'=>'white','align'=>'left','valign' => 'center','borderSize'=>1,'borderTopColor'=>'white','borderLeftColor'=>'white','borderBottomColor'=>'white'])->addText('Supplier Name',$tableCellNormal,$cellStyle);
        $innerTable->addCell(7500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($inpect_info->supplier_name,['align'=>'center'],['align'=>'center']);

        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(2000,['bgcolor'=>'white','align'=>'left','valign' => 'center','borderSize'=>1,'borderTopColor'=>'white','borderLeftColor'=>'white','borderBottomColor'=>'white'])->addText('Factory Name',$tableCellNormal,$cellStyle);
        $innerTable->addCell(7500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText($inpect_info->factory,['align'=>'center'],['align'=>'center']);

        
        $section->addTextBreak();



        /* 2. Product Information	*/
        /* $phpWord->addTableStyle('Product Information',  $tableStyle, ['bgColor' => 'FF0000', 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
        'width' => 100 * 50]); */
        $max_width_table_style=['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 80,'bgColor' => 'FF0000', 'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
        'width' => 100 * 50];
        $productInfoTable = $section->addTable($max_width_table_style);
        $productInfoTable->addRow(50);
        $productInfoTable->addCell(9500, ['gridSpan'=>'8','bgColor'=>'909090'])->addText('2. Product Information', $headerTextStyle,$removeCellBottomPadding);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Product Name:', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center', 'gridSpan'=>'2'])->addText('', $tableCellNormalJess,$cellStyle);
        $productInfoTable->addCell(4500, ['align' => 'center', 'gridSpan'=>'5'])->addText('Product', $labelStyle,$cellStyleCenter);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Invoice / PO Number', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','valign' => 'center','vMerge' => 'restart', 'gridSpan'=>'5'])->addText('Photo Of Product(s)', $labelStyle3,$cellStyleCenter);       
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('PL / Invoice Provided ', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText('YES or NO', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Total quantity ordered', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);        
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Pallets', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText('YES or NO', $tableCellNormalJess,$cellStyleCenter); 
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);      
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center','valign' => 'center','vMerge' => 'restart'])->addText('Inspected Sampling Size', $labelStyle,$cellStyle);
        $productInfoTable->addCell(1000, ['align' => 'center'])->addText('Packages', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(1000, ['align' => 'center'])->addText('Pieces', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center','vMerge' => 'continue']);
        $productInfoTable->addCell(1000, ['align' => 'center'])->addText('###', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(1000, ['align' => 'center'])->addText('###', $tableCellNormalJess,$cellStyleCenter);  
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);      
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Defects Found', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText('YES or NO', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);    
        $productInfoTable->addRow(50);

        $productInfoTable->addCell(3000, ['align' => 'center'])->addText('Total Qty. packages Loaded', $labelStyle,$cellStyle);
        $productInfoTable->addCell(2000, ['align' => 'center','gridSpan'=>'2'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfoTable->addCell(4500, ['align' => 'center','vMerge' => 'continue', 'gridSpan'=>'5']);
        
        $section->addTextBreak();


        /* 3. Important Remarks */
        $labelStyleRem = ['bold'=>true,'align'=>'left','spaceAfter' => 0, 'color' => 'ff0000'];
        //$phpWord->addTableStyle('Important Remarks',  $tableStyle, ['bgColor' => 'FF0000']);
        $impRemTable = $section->addTable($max_width_table_style);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, $tableHeaderCellStyle)->addText('3. Important Remarks', $headerTextStyle,$removeCellBottomPadding);
        $impRemTable->addRow(50);

        $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'ffffff','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText('1. ', $labelStyleRem,$cellStyle);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'ffffff','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText('2. ', $labelStyleRem,$cellStyle);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'ffffff','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText('3. ', $labelStyleRem,$cellStyle);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderBottomSize'=>1,'borderBottomColor'=>'ffffff','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText('4. ', $labelStyleRem,$cellStyle);
        $impRemTable->addRow(50);
        $impRemTable->addCell(9500, ['align' => 'center','gridSpan'=>'4','borderTopSize'=>1,'borderTopColor'=>'ffffff'])->addText('5. ', $labelStyleRem,$cellStyle);

        $section->addTextBreak(7);
        
        /* $headercellStyleContR = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'borderLeftColor'=>'white', 'borderTopColor'=>'white', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyleContL = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'align'=>'center', 'borderRightColor'=>'white', 'borderTopColor'=>'white', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER]; */

        $headercellStyleContR = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'borderLeftColor'=>'white', 'borderTopColor'=>'black', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyleContL = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'align'=>'center', 'borderRightColor'=>'white', 'borderTopColor'=>'black', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];


        $headercellStyleCont = ['gridSpan'=>'4','bgColor'=>'FFFFFFF', 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerTextStyleCont= ['align'=>'center','bold'=>true,'color'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $image_cell_border=['gridSpan'=>'2', 'align' => 'center', 'valign' => 'center']; 
        $removeCellBottomPaddingCont = ['spaceAfter' => 0, 'align' => 'center'];

        /* 4. Supplier Overview */
        //$phpWord->addTableStyle('Supplier Overview Table', $tableStyle, ['bgColor' => 'FF0000']);
        $supplierTable = $section->addTable($max_width_table_style);
        $supplierTable->addRow(50);
        $supplierTable->addCell(9500, $tableHeaderCellStyle)->addText('4. Supplier Overview', $headerTextStyle,$removeCellBottomPadding);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, $headercellStyleContL)->addText('Factory Location', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $supplierTable->addCell(4500, $headercellStyleContR)->addText('Factory Gate Picture', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_location,$imageCellDimensions);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->factory_gate, $imageCellDimensions);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, $headercellStyleContL)->addText('Warehouse', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $supplierTable->addCell(4500, $headercellStyleContR)->addText('Loading Area', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $supplierTable->addRow(50);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->warehouse,$imageCellDimensions);
        $supplierTable->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$supplier->report_number.'/supplier/'.$supplier->loading_area, $imageCellDimensions);
        
        $section->addPageBreak();

        /* 5. Cargo Information */
        //styles
        $labelStyleSize = ['align'=>'left', 'valign' => 'center','size' => 12];
        $cellStyleBorder = ['align'=>'left', 'valign' => 'center', 'borderSize' => 1 ];
        $headercellStyleJess = ['gridSpan'=>'2', 'color'=> 'white', 'bold'=> true,'size' => 12, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $tableHeaderCellStyleJess =['gridSpan'=>'4','bgcolor'=>'909090'];
        $cargoLabel =['spaceAfter' => 0, 'bold' => true, 'spacing' => 0, 'spaceBefore' => 0, 'size'=> 12];
        $cargoNotBoldLabel =['spaceAfter' => 0, 'spacing' => 0, 'spaceBefore' => 0, 'size'=> 12];
        $cell_style=['gridSpan'=>'2','bgcolor'=>'white'];
        $inner_table_style=['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 10, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER,'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
        'width' => 100 * 50];
        $cargo_text_style=['align' =>'center', 'valign' =>'center', 'size' => 12];
        
        $table = $section->addTable($max_width_table_style);
        $cargoTable = $table->addRow(50)->addCell(9500,$tableHeaderCellStyleJess);
        $cargoTable->addText('5. Cargo Information', $headercellStyleJess, $removeCellBottomPadding);

        $section->addTextBreak();
        $cargoTable = $table->addRow(50)->addCell(9500,['gridSpan'=>'4','bgcolor'=>'white']);
        $cargoTable->addText('',['size' => 1, 'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable( $inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Inspector Arrival Time:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->inspector_arrival_time, $cargo_text_style, ['align' =>'center']);
        //$section->addTextBreak();
        
        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Cargo ready Time:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->cargo_ready_time, $cargo_text_style , ['align' =>'center']);
        //$section->addTextBreak();

        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Container Arrival Time:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->container_arrival_time, $cargo_text_style, ['align' =>'center']);
        //$section->addTextBreak();

        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Loading Started:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->loading_started, $cargo_text_style, ['align' =>'center']);
        //$section->addTextBreak();

        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3000,$cell_style)->addText('Inspection Finished:',$cargoLabel);
        $innerTable->addCell(6500,$cell_style)->addText($cargo->inspection_finished, $cargo_text_style, ['align' =>'center']);
        //$section->addTextBreak();

        $cargoTable->addText('',['size' => 1,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);      
        $innerTable->addCell(4500,$cell_style)->addText('Loading Facility Cooperation:',$cargoLabel);
        $innerTable->addCell(1000,$cell_style)->addText('Good',['size'=> 12]);
        if($cargo->loading_facility_cooperation=="good"){
            $innerTable->addCell(500,$cell_style)->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(500,$cell_style)->addText('',$cargoLabel,['align'=>'center']);
        }       
        $innerTable->addCell(1000,$cell_style)->addText('Average',['size'=> 12]);
        if($cargo->loading_facility_cooperation=="average"){
            $innerTable->addCell(500,$cell_style)->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(500,$cell_style)->addText('',$cargoLabel,['align'=>'center']);
        }    
        $innerTable->addCell(1000,$cell_style)->addText('Bad',['size'=> 12]);
        if($cargo->loading_facility_cooperation=="bad"){
            $innerTable->addCell(1000,$cell_style)->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(1000,$cell_style)->addText('',$cargoLabel,['align'=>'center']);
        }
        
        //$section->addTextBreak();
        //$cargoTable->addTextBreak();

        $cargoTable = $table->addRow(50)->addCell(2375);
        $cargoTable->addText('Container Number', $cargoLabel);
        $cargoTable = $table->addCell(2375);
        $cargoTable->addText($cargo->container_number, $cargoNotBoldLabel);
        $cargoTable = $table->addCell(2375, ['gridspan' =>2]);
        $cargoTable->addText('', $cargoLabel);

        $cargoTable = $table->addRow(50)->addCell(2375);
        $cargoTable->addText('Shipping Seal No:', $cargoLabel);
        $cargoTable = $table->addCell(2375);
        $cargoTable->addText(ucwords($cargo->shipping_seal_number), $cargoNotBoldLabel);
        $cargoTable = $table->addCell(2375);
        $cargoTable->addText('SERA Seal No:', $cargoLabel);
        $cargoTable = $table->addCell(2375);
        $cargoTable->addText($cargo->sera_seal_number, $cargoNotBoldLabel);
        
        $top_border=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white'];
        $bot_border=['valign' => 'center','borderSize'=>1, 'borderBottomColor'=>'white'];      
        $left_border=['valign' => 'center','borderSize'=>1,'borderLeftColor'=>'white'];
        $right_border=['valign' => 'center','borderSize'=>1, 'borderRightColor'=>'white'];

        $left_right=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderRightColor'=>'white'];

        $left_right_bot=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderRightColor'=>'white','borderBottomColor'=>'white'];
        $left_right_top=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderRightColor'=>'white','borderTopColor'=>'white'];

        $top_bot_left=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderBottomColor'=>'white','borderLeftColor'=>'white'];
        $top_bot_right=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderBottomColor'=>'white','borderRightColor'=>'white'];

        $top_bot_right_left=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderBottomColor'=>'white','borderRightColor'=>'white', 'borderLeftColor'=>'white'];

        $right_bot=['valign' => 'center','borderSize'=>1, 'borderRightColor'=>'white', 'borderBottomColor'=>'white'];
        $right_top=['valign' => 'center','borderSize'=>1, 'borderRightColor'=>'white', 'borderTopColor'=>'white'];
        $left_bot=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderBottomColor'=>'white'];
        $left_top=['valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderTopColor'=>'white'];
        $top_bot=['valign' => 'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderBottomColor'=>'white'];

        $inner_table_style2=['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER,'unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
        'width' => 100 * 50];

        $cargoTable = $table->addRow(50)->addCell(3000, $right_bot);      
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]);
        $cargoTable->addText('Container Size:', $cargoLabel);
        $cargoTable = $table->addCell(6500, ['gridSpan'=>3,'valign' => 'center','borderSize'=>1, 'borderLeftColor'=>'white', 'borderBottomColor'=>'white']);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table 
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(1225,$cell_style , ['valign'=>'center'])->addText('20 ST');
        if($cargo->container_size=="20st"){
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }
        
        $innerTable->addCell(1225,$cell_style , ['valign'=>'center'])->addText('40 ST');       
        if($cargo->container_size=="40st"){
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('✓');
        }else{
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }

        $innerTable->addCell(1225,$cell_style , ['valign'=>'center'])->addText('40 HC');
        if($cargo->container_size=="40hc"){
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }
        
        $innerTable->addCell(1225,$cell_style , ['valign'=>'center'])->addText('45HC');
        if($cargo->container_size=="45hc"){
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(400,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }
            
        
        $cargoTable = $table->addRow(50)->addCell(3000, $right_top);      
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]);
        $cargoTable->addText('Container Status:', $cargoLabel);
        $cargoTable = $table->addCell(6500, ['gridspan' =>3,'borderLeftColor'=>'white', 'borderTopColor'=>'white', 'borderSize'=>1]);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);

        $innerTable->addCell(1250,$cell_style , ['valign'=>'center'])->addText('Good');
        if($cargo->container_status=="good"){
            $innerTable->addCell(416,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(416,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        } 
        
        $innerTable->addCell(1500,$cell_style , ['valign'=>'center'])->addText('Damaged');
        if($cargo->container_status=="damaged"){
            $innerTable->addCell(416,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(416,$cell_style , ['valign'=>'center'])->addText('');
        }
        
        $innerTable->addCell(2500,$cell_style , ['valign'=>'center'])->addText('Seriously Damaged');
        if($cargo->container_status=="seriously damaged"){
            $innerTable->addCell(418,$cell_style , ['valign'=>'center'])->addText('✓',$cargoLabel,['align'=>'center']);
        }else{
            $innerTable->addCell(418,$cell_style , ['valign'=>'center'])->addText('',$cargoLabel,['align'=>'center']);
        }

        function loopTextBreak($count,$tableName){
            for($i=0;$i<$count;$i++){
                $tableName->addTextBreak();
            }
        }

        

        
        //$cargoTable = $table->addRow(50)->addCell(9000, ['align' => 'center','gridSpan'=>'4']);
        //$cargoTable->addTextBreak();
        /* $cargoTable->addText('If Damaged, Please Specify', $labelStyle,$cellStyle); 
        if ($cargo->container_status == 'good') {
            $cargoTable = $table->addRow(50)->addCell(4500, ['gridSpan'=>'2'])->addText('N/A', $labelStyleCentered,$cellStyle);
            $cargoTable = $table->addCell(4500, ['gridSpan'=>'2'])->addText('N/A', $labelStyleCentered,$cellStyle);
        }else{
            $cargoTable = $table->addRow(50)->addCell(4500, ['gridSpan'=>'2'])->addImage($cargo_photo_1,$imageCellDimensions350H);
            $cargoTable = $table->addCell(4500, ['gridSpan'=>'2'])->addImage($cargo_photo_2,$imageCellDimensions350H);
            $cargoTable = $table->addRow(50)->addCell(4500, ['gridSpan'=>'2'])->addText();
            $cargoTable = $table->addCell(4500, ['gridSpan'=>'2'])->addText();
        }
        */

        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4]);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(50);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('If Damaged, Please Specify)',$labelStyle,$cellStyle);
        $innerTable->addRow(50);
        if($cargo->container_status == 'good'){
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addText('N/A');
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addText('N/A');
        }else{            
            /* $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.cargo_photo_1.'/cargo/'.$cargo->loading_area,$imageCellDimensions);
            $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors, $imageCellDimensions); */

            if($cargo->container_status_photos!=null && !empty($cargo->container_status_photos)){

                $container_status_photos=json_decode($cargo->container_status_photos);

                if(is_array($container_status_photos) && !empty($container_status_photos)){

                    foreach ($container_status_photos as $key => $container_status_photo) {
                        $_container_status_photo='images/reports/'.$cargo->report_number.'/cargo/'.$container_status_photo->image;
                        if($key%3==2){
                            $innerTable->addRow(50);
                        }

                        $c_s_photos=$innerTable->addCell(4750, ['gridSpan'=>'2']);
                        $textrun = $c_s_photos->addTextRun();
                        
                        if($container_status_photo->label!='Label Name' && !empty($container_status_photo->label)){
                            $textrun->addText($container_status_photo->label,['align'=>'center']);
                            $textrun->addTextBreak();
                        }
                        $textrun->addImage($_container_status_photo, $imageCellDimensions350H);
                    }
                }
            }
        }
        


        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderBottomColor'=>'white']);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(1550,$cell_style , ['valign'=>'center'])->addText('Holes:',$labelStyle,$cellStyle);
        $innerTable->addCell(850,$cell_style , ['valign'=>'center'])->addText('Yes');
        $cargo_holes_yes=""; 
        $cargo_holes_no=""; 
        if($cargo->holes=="yes"){
            $cargo_holes_yes="✓"; 
            $cargo_holes_no=""; 
        }else{
            $cargo_holes_yes=""; 
            $cargo_holes_no="✓"; 
        }

        $cargo_dents_yes=""; 
        $cargo_dents_no=""; 
        if($cargo->dents=="yes"){
            $cargo_dents_yes="✓"; 
            $cargo_dents_no=""; 
        }else{
            $cargo_dents_yes=""; 
            $cargo_dents_no="✓"; 
        }

       
        $innerTable->addCell(750,$cell_style , ['valign'=>'center'])->addText($cargo_holes_yes,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(850,$cell_style , ['valign'=>'center'])->addText('No'); 
        $innerTable->addCell(750,$cell_style , ['valign'=>'center'])->addText($cargo_holes_no,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1550,$cell_style , ['valign'=>'center'])->addText('Dents:',$labelStyle,$cellStyle);
        $innerTable->addCell(750,$cell_style , ['valign'=>'center'])->addText('Yes');
        $innerTable->addCell(850,$cell_style , ['valign'=>'center'])->addText($cargo_dents_yes,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(750,$cell_style , ['valign'=>'center'])->addText('No');
        $innerTable->addCell(850,$cell_style , ['valign'=>'center'])->addText($cargo_dents_no,$cargoLabel,['align'=>'center']);
        //$innerTable->addRow(2000);

     
        /* $textrun = $innerTable->addCell(4750,['gridSpan'=>'10','bgcolor'=>'white','valign'=>'center']);
        $textrun->addText('Image',['valign'=>'center','align'=>'center'],['valign'=>'center','align'=>'center']);
        $textrun->addTable($inner_table_style2);
        $textrun->addRow(1500);
        $textrun->addCell(4750,['gridSpan'=>'10','bgcolor'=>'white','valign'=>'center']);
        $textrun->addText('test',['valign'=>'center','align'=>'center'],['valign'=>'center','align'=>'center']); */
       // $textrun->addImage('images/tic.png', array( 'wrappingStyle' => 'inline', 'width' => 120, 'height' => 40, 'align'=>'center','spaceAfter'=>0)); 

        //$innerTable->addCell(4750,['gridSpan'=>'5','bgcolor'=>'white','valign'=>'center'])->addText('N/A'); 
        /* if ($cargo->holes == 'yes') {
           // $cargoHoles = $cargoTable->addCell(4500, ['gridSpan'=>'2']);
            //$cargoHoles->addText('Container Holes');
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
                             
                             $holes_coulmns=$cargoTable->addCell(4500, ['gridSpan'=>'2']);
                             $holes_txtrun=$holes_coulmns->addTextRun();
                                if($hole_photo->label!='Label Name' && !empty($hole_photo->label)){
                                     $holes_txtrun->addText($hole_photo->label);
                                     $holes_txtrun->addTextBreak();
                                }
                             $holes_txtrun->addImage($_hole_photo, $imageCellDimensions);
                        }
                    }
                   
                }

        }else{
           $innerTable->addCell(4750,['gridSpan'=>'10','bgcolor'=>'white','valign'=>'center'])->addText('N/A',['valign'=>'center','align'=>'center'],['valign'=>'center','align'=>'center']);
            $innerTable->addCell(4750,['gridSpan'=>'10','bgcolor'=>'white','valign'=>'center'])->addText('N/A',['valign'=>'center','align'=>'center'],['valign'=>'center','align'=>'center']);
        }  */

        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderBottomColor'=>'white', 'borderTopColor'=>'white']);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $flr_cond_good="";  // good
        $flr_cond_scr="";  // scratched
        $flr_cond_bro="";     // broken
        if($cargo->floor_condition=="good"){
            $flr_cond_good="✓"; 
            $flr_cond_scr="";  
            $flr_cond_bro="";  
        }else if($cargo->floor_condition=="broken"){
            $flr_cond_good=""; 
            $flr_cond_scr="✓";  
            $flr_cond_bro="";  
        }else{
            $flr_cond_good=""; 
            $flr_cond_scr="";  
            $flr_cond_bro="✓";  
        }
        $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Floors Condition:',$labelStyle,$cellStyle);
        $innerTable->addCell(1000,$cell_style , ['valign'=>'center'])->addText('Good'); 
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($flr_cond_good,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1000,$cell_style , ['valign'=>'center'])->addText('Scratched'); 
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($flr_cond_scr,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1000,$cell_style , ['valign'=>'center'])->addText('Broken');
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($flr_cond_bro,$cargoLabel,['align'=>'center']);

        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderBottomColor'=>'white', 'borderTopColor'=>'white']);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $door_cond_good="";  // good
        $door_cond_bad="";  // scratched
        if($cargo->doors_condition=="good"){
            $door_cond_good="✓";
            $door_cond_bad=""; 
        }else{
            $door_cond_good="";
            $door_cond_bad="✓"; 
        }
        $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Doors Condition:',$labelStyle,$cellStyle);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Good'); 
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($door_cond_good,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Bad'); 
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($door_cond_bad,$cargoLabel,['align'=>'center']);

        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderTopColor'=>'white']);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $lig_cond_good="";  // good
        $lig_cond_bad="";  // scratched
        if($cargo->light_proof=="good"){
            $lig_cond_good="✓";
            $lig_cond_bad=""; 
        }else{
            $lig_cond_good="";
            $lig_cond_bad="✓"; 
        }
        $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Light Proof:',$labelStyle,$cellStyle);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Good'); 
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($door_cond_good,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Bad'); 
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($door_cond_bad,$cargoLabel,['align'=>'center']);

        /* OUTSIDE CONTAINER PHOTO */
        

        /* $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'align'=>'center', 'borderSize'=>1]);
        $cargoTable->addText('OUTSIDE CONTAINER PHOTO',$labelStyleCentered,['align'=>'center']); 
        
       
        $cargoTable = $table->addRow(50)->addCell(4500, $headercellStyleContL);
        $cargoTable->addText('Container Front (Doors)', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable = $table->addCell(4500, $headercellStyleContR);
        $cargoTable->addText('Container Back Side', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable= $table->addRow(50)->addCell(4500,  $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->loading_area,$imageCellDimensions);
        $cargoTable= $table->addCell(4500,  $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors, $imageCellDimensions);
        
        $cargoTable = $table->addRow(50)->addCell(4500, $headercellStyleContL);
        $cargoTable->addText('Container Left Side ', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable = $table->addCell(4500, $headercellStyleContR);
        $cargoTable->addText('Container Right Side', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable= $table->addRow(50)->addCell(4500, $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->left_side,$imageCellDimensions);
        $cargoTable= $table->addCell(4500, $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->right_side, $imageCellDimensions);
         */


        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4]);
        $cargoTable->addText('',['size' => 0,'lineHeight' =>0.5]); //Nested Table
        $innerTable = $cargoTable->addTable($inner_table_style2);
        $innerTable->addRow(50);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('Front (Doors)', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center','borderSize'=>'1','borderLeftColor'=>'white','borderRightColor'=>'white','borderTopColor'=>'white'])->addText('Back', $headerTextStyleCont,$removeCellBottomPaddingCont); 
        $innerTable->addRow(50);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->loading_area,$imageCellDimensions);
        $innerTable->addCell(4750,['gridSpan'=>'2','bgColor'=>'white','valign'=>'center'])->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->front_doors, $imageCellDimensions);


        /* INSIDE CONTAINER PHOTO */
        
        $cargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'align'=>'center', 'borderSize'=>1]);
        //$cargoTable->addTextBreak();
        $cargoTable->addText('INSIDE CONTAINER PHOTO',$labelStyleCentered,['align'=>'center']); 
       
        $cargoTable = $table->addRow(50)->addCell(4500, $headercellStyleContL);
        $cargoTable->addText('Container floor and joint (inside)', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable = $table->addCell(4500, $headercellStyleContR);
        $cargoTable->addText('Container wall and joint (Inside)', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable= $table->addRow(50)->addCell(4500,  $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_floor_and_joint,$imageCellDimensions);
        $cargoTable= $table->addCell(4500,  $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_wall_and_joint, $imageCellDimensions);
        
        $cargoTable = $table->addRow(50)->addCell(4500, $headercellStyleContL);
        $cargoTable->addText('Container Ceiling (inside)', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable = $table->addCell(4500, $headercellStyleContR);
        $cargoTable->addText('Container Doors Closed (Inside)', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $cargoTable= $table->addRow(50)->addCell(4500, $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_ceiling,$imageCellDimensions);
        $cargoTable= $table->addCell(4500, $image_cell_border);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->container_doors_closed, $imageCellDimensions);
        
        $cargoTable = $table->addRow(50)->addCell(9500, $headercellStyleCont);
        //$cargoTable->addTextBreak();
        $cargoTable->addText('Equipment Interchange Receipt(EIR)', $headerTextStyleCont,['align'=>'center']);
        $cargoTable = $table->addRow(50)->addCell(9500, ['gridSpan'=>'4']);
        $cargoTable->addImage('images/reports/'.$cargo->report_number.'/cargo/'.$cargo->equipment_interchange_receipt,['width'=>600, 'height'=>520,'align'=>'center', 'valign'=>'center']);

        $section->addTextBreak();

        $table = $section->addTable($max_width_table_style);
       $palletizedCargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderBottomColor'=>'black', 'borderTopColor'=>'black']);
       $palletizedCargoTable->addText('',['size' => 0,'lineHeight' =>0.001]); //Nested Table
       $innerTable = $palletizedCargoTable->addTable($inner_table_style2);
       $innerTable->addRow(300,['exactHeight'=>true]);

       $pal_carg_yes="";  // good
       $pal_carg_no="";  // scratched
       if($cargo->palletized_cargo=="yes"){
           $pal_carg_yes="✓";
           $pal_carg_no=""; 
       }else{
           $pal_carg_yes="";
           $pal_carg_no="✓"; 
       }
       $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Palletized Cargo:',$labelStyle,$cellStyle);
       $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('Yes'); 
       $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($pal_carg_yes,$cargoLabel,['align'=>'center']);
       $innerTable->addCell(1750,$cell_style , ['valign'=>'center'])->addText('No'); 
       $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($pal_carg_no,$cargoLabel,['align'=>'center']);

       $palletizedCargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1, 'borderTopColor'=>'black']);
       $palletizedCargoTable->addText('',['size' => 0,'lineHeight' =>0.001]); //Nested Table
       $innerTable = $palletizedCargoTable->addTable($inner_table_style2);
       $innerTable->addRow(300,['exactHeight'=>true]);
       $innerTable->addCell(5000,$cell_style , ['valign'=>'center'])->addText('Specify the material of the Pallet:',$labelStyle,$cellStyle);
       $innerTable->addCell(4500,$cell_style , ['valign'=>'center'])->addText('N/A'); 

       $palletizedCargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1]);
       
       
       
       $palletizedCargoTable->addText('',['size' => 0,'lineHeight' =>0.001]); //Nested Table
       $innerTable = $palletizedCargoTable->addTable($inner_table_style2);
       $innerTable->addRow(300,['exactHeight'=>true]);
       $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderLeftColor'=>'white', 'borderRightColor'=>'white'])->addText('Pallet’s Material',$labelStyle,['align'=>'center']);
       $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center','borderSize'=>1, 'borderTopColor'=>'white', 'borderLeftColor'=>'white', 'borderRightColor'=>'white'])->addText('Fumigation’s Stamp',$labelStyle,['align'=>'center']); 
       //$innerTable->addRow(50);
       $innerTable->addRow(300,['exactHeight'=>true]);
       $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center'])->addText('N/A',$headerTextStyleCont,['align'=>'center']);
       $innerTable->addCell(4750,['gridSpan'=>2,'valign'=>'center'])->addText('N/A',$headerTextStyleCont,['align'=>'center']); 
       
       $palletizedCargoTable = $table->addRow(50)->addCell(9500, ['gridspan' =>4, 'borderSize'=>1]);
       $palletizedCargoTable->addText('',['size' => 0,'lineHeight' =>0.001]); //Nested Table
       $innerTable = $palletizedCargoTable->addTable($inner_table_style2);
       $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(3500,$cell_style , ['valign'=>'center'])->addText('Number of Pallets loaded:',$labelStyle,$cellStyle);
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($cargo->number_of_pallets_loaded, $cargoLabel,['align'=>'center']);
        $innerTable->addCell(2500,$cell_style , ['valign'=>'center'])->addText('From Pallet No:',$labelStyle,$cellStyle);
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($cargo->from_pallet_number,$cargoLabel,['align'=>'center']);
        $innerTable->addCell(2500,$cell_style , ['valign'=>'center'])->addText('To:',$labelStyle,$cellStyle);
        $innerTable->addCell(500,$cell_style , ['valign'=>'center'])->addText($cargo->to_pallet_number,$cargoLabel,['align'=>'center']);

        $section->addTextBreak();

        //joe 6-7

        /* 6. Product Detailed Information */
        //$phpWord->addTableStyle('Product Detailed Information', $tableStyle, ['bgColor' => 'FF0000']);
        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(9500, $tableHeaderCellStyleInfo)->addText('6. Product Detailed Information', $headerTextStyle,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(9500, $tableHeaderCellStyleInfo2)->addText('Total Quantity:	', $headerTextStyle2,$removeCellBottomPadding);
        $productInfo->addRow(50,['exactHeight'=>true]);
        $productInfo->addCell(9500,['gridSpan'=>'7'])->addText('');
        $productInfo->addRow(50);
        $productInfo->addCell(2000, $tableHeaderCellStyleColumnName)->addText('Invoice No.', $headerTextStyleBlackNotBold, $removeCellBottomPadding);
        $productInfo->addCell(500, $tableHeaderCellStyleColumnName)->addText('P.O.', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(500, $tableHeaderCellStyleColumnName)->addText('Model', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(2500, $tableHeaderCellStyleColumnName)->addText('Description', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(1250, $tableHeaderCellStyleColumnName)->addText('Packages (Cartons)', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(1500, $tableHeaderCellStyleColumnName)->addText('Pieces/Pairs', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
        $productInfo->addCell(1250, $tableHeaderCellStyleColumnName)->addText('Material', $headerTextStyleBlackNotBold,$removeCellBottomPadding);
       
        $total = 0;
        foreach ($product_detail as $p) {
            $productInfo->addRow(50);
            $productInfo->addCell(1350, ['align' => 'center','valign' => 'center','vMerge' => 'restart'])->addText($p->invoice_no, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->po_no, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->model_number, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->description, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->package_qty, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->pieces, $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText($p->material, $tableCellNormalJess,$cellStyleCenter);
            $total+= $p->package_qty;
        }

        for($i=0;$i<=9;$i++){
            $productInfo->addRow(50);
            $productInfo->addCell(1350, ['align' => 'center','vMerge' => 'continue'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
            $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        }
        $productInfo->addRow(50);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('Total', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormalJess,$cellStyleCenter);
    


        //$productInfo->addRow(50);
        /* $productInfo->addCell(1350, ['gridSpan'=>'4', 'align' => 'center'])->addText('Total', $tableCellNormal2,$cellStyle2);
        $productInfo->addCell(1350, ['align' => 'center'])->addText($total, $tableCellNormal2,$cellStyle2);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormal2,$cellStyle2);
        $productInfo->addCell(1350, ['align' => 'center'])->addText('', $tableCellNormal2,$cellStyle2); */


       /*  if ($inpect_info->service == 'cbpi_serial') {
            $section->addTextBreak();
            $phpWord->addTableStyle('Serial Numbers', $tableStyle, ['bgColor' => 'FFFFFF']);
            $serial_no = $section->addTable($max_width_table_style);
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

        } */

        
        $section->addTextBreak();

        //$phpWord->addTableStyle('If not, please specify:', $tableStyle, ['bgColor' => 'ffffff']);
        $productInfo2 = $section->addTable($max_width_table_style);
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
        /* 7. Observations */
       // $phpWord->addTableStyle('If not, please specify:', $tableStyle, ['bgColor' => 'ffffff']);
        $productInfo2 = $section->addTable($max_width_table_style);
        $productInfo2->addRow(50);
        $productInfo2->addCell(9500, ['gridSpan'=>'4', 'bgColor'=>'gray'])->addText('7. Observations', $headerTextStyle,$removeCellBottomPadding);
     /*    $cell = $productInfo2->addCell(9500, ['gridSpan'=>2,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderBottomColor'=>'black','borderBottomSize'=>1]);
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(50);
        $innerTable->addCell(9500, $tableHeaderCellStyleInfo)->addText('7. Observations', $headerTextStyle,$removeCellBottomPadding); */

        $productInfo2->addRow(50);
        $cell = $productInfo2->addCell(9500, ['gridSpan'=>4,'valign' => 'center','align' => 'left','borderTopSize'=>1,'borderTopColor'=>'white','borderBottomColor'=>'black','borderBottomSize'=>1]);
        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000', 'width'=>1000));
        
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(2000,['bgcolor'=>'white','align'=>'left','valign' => 'center'])->addText('Damaged Products:',['bold' => true]);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('Yes',['align'=>'center'],['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText(' ',['align'=>'center'],['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('No',['align'=>'center'],['align'=>'center']);
        $innerTable->addCell(500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText(' ',['align'=>'center'],['align'=>'center']);

        
        $cell->addTextBreak();
        $innerTable = $cell->addTable($max_width_table_style);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(9500,['bgcolor'=>'white','align'=>'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1,'borderLeftSize'=>1,'borderBottomColor'=>'white','borderTopColor'=>'white','borderTopSize'=>1,'borderLeftColor'=>'white','borderLeftSize'=>1])->addText('If yes, please specify:',['bold' => true]);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(9500,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText('');

        $cell->addTextBreak();
        $innerTable = $cell->addTable(array('borderSize' => 1, 'borderColor' => '000000','unit' => \PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT,
        'width' => 100 * 50,'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1,'borderLeftSize'=>1,'borderBottomColor'=>'white','borderTopColor'=>'white','borderTopSize'=>1,'borderLeftColor'=>'white','borderLeftSize'=>1])->addText('Other Observations: ',['bold' => true]);
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center'])->addText(' ');
        $innerTable->addRow(300,['exactHeight'=>true]);
        $innerTable->addCell(8800,['bgcolor'=>'white','align'=>'center','valign' => 'center','bgcolor'=>'white','align'=>'center','valign' => 'center','borderRightSize'=>1,'borderRightColor'=>'white','borderBottomColor'=>'white','borderBottomSize'=>1,'borderLeftSize'=>1,'borderBottomColor'=>'white','borderTopColor'=>'white','borderTopSize'=>1,'borderLeftColor'=>'white','borderLeftSize'=>1])->addText(' ');
      
        /* 8. Loading Pictures */
        $section->addPageBreak();
        //$phpWord->addTableStyle('Loading Pictures', $tableStyle, ['bgColor' => 'gray']);
        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(9500, ['gridSpan'=>'4', 'bgColor'=>'gray'])->addText('8. Loading Pictures', $headerTextStyle,$removeCellBottomPadding);
        //$productInfo->addCell(9500, ['gridSpan'=>'4'])->addText('8. Loading Pictures', $headerTextStyle,$removeCellBottomPadding);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2','align' => 'center','bgColor' => 'white'])->addText('Container:', $labelStyle);
        $productInfo->addCell(4750, ['gridSpan'=>'2','align' => 'center','bgColor' => 'white'])->addText($cargo->container_number, $labelStyle);
        //$productInfo->addRow(50);

        $headercellStyleContFull = ['gridSpan'=>'2','bgColor'=>'FFFFFFF', 'borderSize'=>1,'borderLeftColor'=>'white', 'borderRightColor'=>'white', 'borderTopColor'=>'white', 'borderBottomColor'=>'white','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];

        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Container Number Photo', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Empty Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_number_photo, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->empty_container,$imageCellDimensions);
        
        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('25% Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Half Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->quarter_loaded_container, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->half_loaded_container,$imageCellDimensions);

  /*       $productInfo->addCell(4750, $headercellStyleContFull)->addText('25% Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Half Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->quarter_loaded_container, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->half_loaded_container,$imageCellDimensions); */

        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('75% Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Full Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->threefourth_loaded_container, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->full_loaded_container,$imageCellDimensions);

      /*   $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContL)->addText('75% Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContR)->addText('Full Loaded Container', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->threefourth_loaded_container, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->full_loaded_container,$imageCellDimensions); */

        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Container Closed Seals', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Shipping Seal Number', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number,$imageCellDimensions);


        /* $productInfo->addRow(50);        
        $productInfo->addCell(4750, $headercellStyleContL)->addText('Container Closed Seals', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContR)->addText('Shipping Seal Number', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->container_closed_seals, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->shipping_seal_number,$imageCellDimensions); */

        $section->addTextBreak();

        $productInfo = $section->addTable($max_width_table_style);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Shipping Seal number', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContFull)->addText('Warehouse', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->sera_seal_number, $imageCellDimensions);
        $productInfo->addCell(4750, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->warehouse,$imageCellDimensions);


       /*  $productInfo->addRow(50);
        $productInfo->addCell(4750, $headercellStyleContL)->addText('Shipping Seal number', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addCell(4750, $headercellStyleContR)->addText('Warehouse', $headerTextStyleCont,$removeCellBottomPaddingCont);
        $productInfo->addRow(50);
        
        $productInfo->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->sera_seal_number, $imageCellDimensions);
        $productInfo->addCell(4500, ['gridSpan'=>'2'])->addImage('images/reports/'.$loadings->report_number.'/loading/'.$loadings->warehouse,$imageCellDimensions); */
        
        $section->addTextBreak();



        //create table for 9. detailed product pictures
        //$phpWord->addTableStyle('Detailed Photos', $tableStyle, ['bgColor' => 'FF0000']);
        $detailed_photos = $section->addTable($max_width_table_style);
        $detailed_photos->addRow(50);
        $detailed_photos->addCell(9500, $tableHeaderCellStyle)->addText('9. Detailed Pictures', $headerTextStyle,$removeCellBottomPadding);

        $photos = DetailedPhoto::distinct()->select('photo_count')->where('report_number',$inpect_info->reference_number)->orderBy('photo_count', 'asc')->groupBy('photo_count')->get();


        foreach ($photos as $key => $value) {
            $images = DetailedPhoto::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->orderByRaw('cast(SUBSTRING_INDEX(SUBSTRING_INDEX(image_data, "-", -2), "-", 1) as unsigned) ASC')->get();
           $descr = DetailedPhotoDescription::where('report_number',$inpect_info->reference_number)->where('photo_count',$value->photo_count)->first();

            $length = count($images);
            $section->addTextBreak();
            //$phpWord->addTableStyle($descr->product_description, $tableStyle, ['bgColor' => 'FFFFFF']);
            //$key = $section->addTable($descr->product_description);
            $key = $section->addTable($max_width_table_style);
            $key->addRow(50);
            $key->addCell(9500, ['gridSpan'=>'8','align' => 'center'])->addText('Description: '. $descr->product_description, $labelStyle,$cellStyle);
            foreach ($images as $k => $image) {
                if ($k % 2 === 0) {
                    $key->addRow(50);   
                    //$productInfo->addCell(4750, $headercellStyleContL)->addText('Container Closed Seals', $headerTextStyleCont,$removeCellBottomPaddingCont);
                    //$productInfo->addCell(4750, $headercellStyleContR)->addText('Shipping Seal Number', $headerTextStyleCont,$removeCellBottomPaddingCont);

                    $headercellStyleContFullSpanFour = ['gridSpan'=>'4','bgColor'=>'FFFFFFF', 'borderSize'=>1,'borderLeftColor'=>'white', 'borderTopColor'=>'white','borderRightColor'=>'white'];
                    if ($k < $length) {
                        $key->addCell(4750, $headercellStyleContFullSpanFour)->addText($images[$k]->photo_label, $headerTextStyleCont,$removeCellBottomPaddingCont);
                    }
                    if ($k+1 < $length) {
                       $key->addCell(4750, $headercellStyleContFullSpanFour)->addText($images[$k+1]->photo_label, $headerTextStyleCont,$removeCellBottomPaddingCont);
                    }

                    $key->addRow(50);
                    if ($k < $length) {
                         $key->addCell(4750, ['gridSpan'=>'4','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k]->photo_count.'/'.$images[$k]->image_data, $imageCellDimensionsNew);
                    }
                    if ($k+1 < $length) {
                       $key->addCell(4750, ['gridSpan'=>'4','align'=>'center'])->addImage('images/reports/'.$loadings->report_number.'/detailedPhoto/'.$images[$k+1]->photo_count.'/'.$images[$k+1]->image_data,$imageCellDimensionsNew);
                    }
                }
            };

        }

        $section->addPageBreak();

        //create table for inspection checklist
        //$phpWord->addTableStyle('Checklist Table', $tableStyle, ['bgColor' => 'FF0000']);
        $checklistTable = $section->addTable($max_width_table_style);
        $checklistTable->addRow(50);
        $checklistTable->addCell(9500, $tableHeaderCellStyle)->addText('10. Inspection Checklist', $headerTextStyle,$removeCellBottomPadding);
        $checklistTable->addRow(50);
        $checklistTable->addCell(9500, ['gridSpan'=>'4','spaceAfter' => 0,'cellMargin'=> 0,'spacing' => 0])->addImage('images/reports/'.$checklist->report_number.'/checklist/'.$checklist->image_path,['width'=>600,'height'=>600,'cellMargin'=>0,'spaceAfter' => 0, 'spacing' => 0,'align'=>'center','valign'=>'center']);
        


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
