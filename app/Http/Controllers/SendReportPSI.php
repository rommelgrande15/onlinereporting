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


class SendReportPSI extends Controller
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

    public function SendReportPSI($id){
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

        $section_style = array(
            'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2),
            'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2),
            'marginLeft'  => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.75),
            'marginRight' => \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.75),
            'marginTop'   => 0,
            'marginBottom'=> 0,
        );
       /*  $section_style=array('marginLeft' => 600, 'marginRight' => 600,
        'marginTop' => 600, 'marginBottom' => 600); */
        $section = $phpWord->addSection($section_style);

        //styles
        $tableStyle = ['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 80, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerStyle = ['bold' => true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];

        $tableCellNormal = ['valign' => 'center','color'=>'000000','size' => 12];
        $tableCellNormal2 = ['valign' => 'center','align' => 'center','color'=>'000000'];
        $labelStyle = ['bold'=>true,'align'=>'left','spaceAfter' => 0,'size' => 12]; //jesser
        $labelStyleCentered = ['bold'=>true,'align'=>'center','spaceAfter' => 0, 'size'=>12, 'alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $cellStyle = ['align'=>'left','spaceAfter' => 0];
        $headercellStyle = ['gridSpan'=>'2','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headercellStyle4 = ['gridSpan'=>'4','bgColor'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $headerTextStyle= ['bold'=>true,'color'=>'FFFFFF', 'size' => 12];
        $headerTextStyleBlack= ['bold'=>true,'color'=>'FFFFFF','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $serialHeaderTextStyle= ['bold'=>true,'color'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        $removeCellBottomPadding = ['spaceAfter' => 0];
        $tableHeaderCellStyle =['gridSpan'=>'4','bgColor'=>'909090'];
        $tableHeaderCellStyleColumnName =['bgColor'=>'000000'];
        $tableHeaderCellStyleInfo =['gridSpan'=>'7','bgColor'=>'909090'];
        $imageCellDimensions = ['width'=>295,'height'=>250,'spaceAfter' => 0];
        $imageCellDimensions350H = ['width'=>295,'height'=>350,'spaceAfter' => 0];
    
        $cell_style=['bold'=>true, 'align'=>'center', 'size'=>10,'bgcolor'=>'d9d9d9','spaceAfter' => 0];
        $cell_style_gray=['align'=>'left', 'size'=>10,'bgcolor'=>'d9d9d9','spaceAfter' => 0];
        $cell_style_gray_span=['gridSpan'=>2, 'align'=>'center', 'size'=>10,'bgcolor'=>'d9d9d9','spaceAfter' => 0];
        $cell_style_gray_span3=['gridSpan'=>3, 'align'=>'center', 'size'=>10,'bgcolor'=>'d9d9d9','spaceAfter' => 0];
        $cell_style_span=['gridSpan'=>2, 'align'=>'center', 'size'=>10,'bgcolor'=>'white','spaceAfter' => 0];
        $cell_style_span3=['gridSpan'=>3, 'align'=>'center', 'size'=>10,'bgcolor'=>'white','spaceAfter' => 0];
        $label_style=[ 'align'=>'center', 'size'=>10];
        $label_style_justify=[ 'align'=>'both', 'size'=>9];
        $label_style_bold=[ 'align'=>'center', 'size'=>10, 'bold'=>true];
        $label_style_left=[ 'align'=>'left', 'size'=>10];
        $label_style_left_bold=[ 'align'=>'left', 'size'=>10,'bold'=>true];
        $label_style_left_gray=['bgColor'=>'d9d9d9', 'align'=>'left', 'size'=>10];
        $label_style_big=[ 'align'=>'center', 'size'=>12];
        $label_style_red=[ 'align'=>'center', 'size'=>10,'color'=>'red'];
        $label_style_red_left=[ 'align'=>'left', 'size'=>10,'color'=>'red'];
        $label_style_red_big=[ 'align'=>'center', 'size'=>12,'color'=>'red'];
        $text_style=['align'=>'center', 'size'=>10,'color'=>'black','spaceAfter' => 0];
        $text_style_justify=['align'=>'both', 'size'=>9,'color'=>'black','spaceAfter' => 0];
        $text_style_bold=['align'=>'left', 'size'=>10,'color'=>'black','spaceAfter' => 0, 'bold'=>true];
        $text_style_center_bold=['align'=>'center', 'size'=>10,'color'=>'black','spaceAfter' => 0, 'bold'=>true];
        $text_style_left=['align'=>'left', 'size'=>10,'color'=>'black','spaceAfter' => 0];
        $text_style_big=['align'=>'center', 'size'=>12,'color'=>'black','spaceAfter' => 0];
        $text_style_red=['align'=>'center', 'size'=>10,'color'=>'red','spaceAfter' => 0];
        $text_style_red_left=['align'=>'left', 'size'=>10,'color'=>'red','spaceAfter' => 0];
        $text_style_red_big=['align'=>'center', 'size'=>12,'color'=>'red','spaceAfter' => 0];

        $head_cell_style=['bold'=>true, 'align'=>'center', 'size'=>11,'bgcolor'=>'d9d9d9'];
        $head_label_style=['bold'=>true, 'align'=>'center', 'size'=>11];
        $head_label_style2=['align'=>'center', 'size'=>11];
        $head_text_style=['bold'=>true, 'align'=>'center', 'size'=>11,'color'=>'black','spaceAfter' => 0];
        $head_image = ['width'=>150,'height'=>50,'spaceAfter' => 0];

        $vMergeReStart=['align' => 'center','valign' => 'center','vMerge' => 'restart'];
        $vMergeContinue=['align' => 'center','vMerge' => 'continue'];

        $foot_style=['lineHeight'=>1, 'align'=>'center'];
        $foot_label=['align'=>'center','bold'=>true, 'spaceAfter'=>0,'height'=>0];
        $center=['align'=>'center'];
        $center_space=['align'=>'center','spaceAfter'=>0];

        //header
        $header = $section->createHeader();
        $phpWord->addTableStyle('Table Header',  $tableStyle);
        $header_table = $header->addTable('Table Header');
        $header_table->addRow(50);
        
        $textrun = $header_table->addCell(1900, $vMergeReStart);
        $textrun->addText('The Inspection Company',['bold'=>true, 'align'=>'center', 'size'=>12,'spaceAfter' => 0, 'color'=>'ed7d31'],['align'=>'center']);
        $textrun->addImage('images/tic.png', array( 'wrappingStyle' => 'inline', 'width' => 120, 'height' => 40, 'align'=>'center','spaceAfter'=>0)); 
        
        $header_table->addCell(1900, $vMergeReStart)->addText('Detail Inspection Result',['size'=>'16','bold'=>true],['align'=>'center', 'spaceAfter'=>0]);
        $header_table->addCell(1900, $head_cell_style)->addText('Client:', $head_label_style , $head_text_style);
        $header_table->addCell(1900)->addText('', $head_label_style , $head_text_style);
        $header_table->addCell(1900, $head_cell_style)->addText('Inspection Result', $head_label_style , $head_text_style);
        $header_table->addRow(50);
        $header_table->addCell(null, $vMergeContinue);
        $header_table->addCell(null, $vMergeContinue);
        $header_table->addCell(1900, $head_cell_style)->addText('Report Date:', $head_label_style , $head_text_style);
        $header_table->addCell(1900)->addText('', $head_label_style , $head_text_style);
        $header_table->addCell(1900)->addText('FAIL / PASS / PENDING', $head_label_style2 , $head_text_style);
        $header_table->addRow(50);
        $header_table->addCell(null, $vMergeContinue);
        $header_table->addCell(null, $vMergeContinue);
        $header_table->addCell(1900, $head_cell_style)->addText('Report No.:', $head_label_style , $head_text_style);
        $header_table->addCell(1900)->addText('', $head_label_style , $head_text_style);
        $header_table->addCell(1900)->addPreserveText('Page {PAGE} of {NUMPAGES}', $head_label_style2 , $head_text_style); //
        $header->addTextBreak();
        //footer
        $footer = $section->createFooter();
        $textrun = $footer->addTextRun($foot_style);
        $textrun->addText('THE INSPECTION COMPANY Ltd.', $foot_label , $center);
        $textrun->addTextBreak();
        $textrun->addText('Level 12, Infinituz Plaza, 1999 Des Voeux Road Central, Sheung Wan, Hong Kong.',['align'=>'center'],$center);
        $textrun->addTextBreak();
        $textrun->addText('Tel: +852-3796 3305', $label_style_red_left , $text_style_left);
        $textrun->addTextBreak();
        $textrun->addText('info@the-inspection-company.com',['align'=>'center', 'color'=>'blue'],$center);


        //table for general information
        $phpWord->addTableStyle('General Info Table', $tableStyle, ['bgColor' => '909090']);
        $gentable = $section->addTable('General Info Table');
        $gentable->addRow(50);
        $gentable->addCell(9500, ['gridSpan'=>'5'])->addText('1. General Information', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Inspection Date', $label_style , $text_style);
        $gentable->addCell(2375,['gridSpan'=>2])->addText('', $label_style , $text_style);
        $gentable->addCell(2375, $cell_style)->addText('Service', $label_style , $text_style);
        $gentable->addCell(2375)->addText('', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Client', $label_style , $text_style);
        $gentable->addCell(2375,['gridSpan'=>2])->addText('', $label_style , $text_style);
        $gentable->addCell(2375, $cell_style)->addText('Contact', $label_style , $text_style);
        $gentable->addCell(2375)->addText('', $label_style , $text_style);
        $gentable->addRow(50);
        /* $gentable->addCell(2375, $cell_style)->addText('Address', $label_style , $text_style);
        $gentable->addCell(7125, ['gridSpan'=>4])->addText('',$label_style , $text_style);
        $gentable->addRow(50); */
        $gentable->addCell(2375, $cell_style)->addText('Factory', $label_style , $text_style);
        $gentable->addCell(2375,['gridSpan'=>2])->addText('', $label_style , $text_style);
        $gentable->addCell(2375, $cell_style)->addText('Contact', $label_style , $text_style);
        $gentable->addCell(2375)->addText('', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Address', $label_style , $text_style);
        $gentable->addCell(7125, ['gridSpan'=>4])->addText('', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Product', $label_style , $text_style);
        $gentable->addCell(2375,['gridSpan'=>2])->addText('', $label_style , $text_style);
        $gentable->addCell(2375, $cell_style)->addText('Brand', $label_style , $text_style);
        $gentable->addCell(2375)->addText('', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Model #', $label_style , $text_style);
        $gentable->addCell(2375,['gridSpan'=>2])->addText('', $label_style , $text_style);
        $gentable->addCell(2375, $cell_style)->addText('PO#', $label_style , $text_style);
        $gentable->addCell(2375)->addText('', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(3167, $cell_style)->addText('Front View Product', $label_style , $text_style);
        $gentable->addCell(3166, ['gridSpan'=>2,'bold'=>true, 'align'=>'center', 'size'=>10,'bgcolor'=>'d9d9d9','spaceAfter' => 0])->addText('Gift box/ Carton ', $label_style , $text_style);
        $gentable->addCell(3167, ['gridSpan'=>2,'bold'=>true, 'align'=>'center', 'size'=>10,'bgcolor'=>'d9d9d9','spaceAfter' => 0])->addText('Export Carton', $label_style , $text_style);
        $gentable->addRow(1500);
        $gentable->addCell(3167);
        $gentable->addCell(3166,['gridSpan'=>2], $label_style , $text_style);
        $gentable->addCell(3167,['gridSpan'=>2], $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(1900, $cell_style)->addText('PO Qty:', $label_style , $text_style);
        $gentable->addCell(1900)->addText('pcs', $label_style , $text_style);
        $gentable->addCell(1900, $cell_style)->addText('PO#', $label_style , $text_style);
        $gentable->addCell(1900)->addText('pcs', $label_style , $text_style);
        $gentable->addCell(1900)->addText('% ready', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Sample Level', $label_style , $text_style);
        $gentable->addCell(2375)->addText('II/S2', $label_style , $text_style);
        $gentable->addCell(2375, $cell_style)->addText('Sampling Size', $label_style , $text_style);
        $gentable->addCell(2375,['gridSpan'=>2])->addText('pcs / function test pcs', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Requirement', $label_style , $text_style);
        $gentable->addCell(7125, ['gridSpan'=>4])->addText('According to customer’s requirement', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Total Qty of Export Carton', $label_style , $text_style);
        $gentable->addCell(1000)->addText('ctns', $label_style , $text_style);
        $gentable->addCell(3750, $cell_style)->addText('Sampling  qty is  √ of export carton qty', $label_style , $text_style);
        $gentable->addCell(2375,['gridSpan'=>2])->addText('Carton No. from XX~XX', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Carton qty to pick samples', $label_style , $text_style);
        $gentable->addCell(1000)->addText('ctns', $label_style , $text_style);
        $gentable->addCell(3750, $cell_style)->addText('TIC Seal Sticker No. from … to …', $label_style , $text_style);
        $gentable->addCell(2375,['gridSpan'=>2])->addText('…… to ……', $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Selected carton No.', $label_style , $text_style);
        $gentable->addCell(7125, ['gridSpan'=>4], $label_style , $text_style);
        $gentable->addRow(50);
        $gentable->addCell(2375, $cell_style)->addText('Sealed carton No', $label_style , $text_style);
        $gentable->addCell(7125, ['gridSpan'=>4], $label_style , $text_style);

        $section->addPageBreak();

        //table for Inspection Summary Result
        $phpWord->addTableStyle('Inspection Summary Result', $tableStyle, ['bgColor' => '909090']);
        $isrtable = $section->addTable('Inspection Summary Result');
        $isrtable->addRow(50);
        $isrtable->addCell(9500, ['gridSpan'=>'6'])->addText('2. Inspection Summary Result', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        $isr_col_name1=array("Inspection item","Shipping QTY","CE Report / CDF","Color/Logo/Style","Marking/Type label","Product Spec/Function","Visual checking","Product Packing","Shipping mark","Export Carton","Serial Number","Measurement data","Compare with Sample");
        for($i=0;$i<13;$i++){
            $isrtable->addRow(50);
            $isrtable->addCell(2085)->addText($isr_col_name1[$i], $label_style , $text_style);
            if($i==0){
                $isrtable->addCell(500)->addText('OK', $label_style , $text_style); 
                $isrtable->addCell(500)->addText('NOK', $label_style , $text_style);
                $isrtable->addCell(800)->addText('Pending', $label_style , $text_style);
                $isrtable->addCell(500)->addText('N/A', $label_style , $text_style);
                $isrtable->addCell(5115)->addText('Remarks', $label_style , $text_style);
            }else if($i==1){
                $isrtable->addCell(500)->addText('OK', $label_style , $text_style); 
                $isrtable->addCell(500)->addText('NOK', $label_style , $text_style);
                $isrtable->addCell(800)->addText('Pending', $label_style , $text_style);
                $isrtable->addCell(500)->addText('N/A', $label_style , $text_style);
                $isrtable->addCell(5115)->addText('', $label_style , $text_style);
            }else{
                $isrtable->addCell(500)->addText('', $label_style , $text_style); 
                $isrtable->addCell(500)->addText('', $label_style , $text_style);
                $isrtable->addCell(800)->addText('', $label_style , $text_style);
                $isrtable->addCell(500)->addText('', $label_style , $text_style);
                if($i==9){
                    $isrtable->addCell(5115)->addText('Factory didn’t allow to do drop test--Pending', $label_style_red , $text_style_red);
                }else{
                    $isrtable->addCell(5115)->addText('', $label_style , $text_style);
                }              
            }           
        }  
        $isrtable->addRow(-50);
        $isrtable->addCell(9500, ['gridSpan'=>'6','bold'=>true, 'align'=>'center', 'size'=>10,'bgcolor'=>'d9d9d9','spaceAfter' => 0]);
        $isrtable->addRow(50);
        $isrtable->addCell(1583)->addText('', $label_style , $text_style); 
        $isrtable->addCell(1583)->addText('AQL', $label_style , $text_style);
        $isrtable->addCell(1583)->addText('Defective Found', $label_style , $text_style);
        $isrtable->addCell(1585)->addText('Max Allowed', $label_style , $text_style);
        $isrtable->addCell(1583,['gridSpan'=>2])->addText('Result', $label_style , $text_style);
        $isr_col1=array("Critical","Major","Minor","Function");
        $isr_col2=array("0","2.5","4.0","1.0");
        $isr_col3=array("0","X","X","X");
        $isr_col4=array("0","X","X","X");
        $isr_col_lbl_style=array($label_style,$label_style_red,$label_style_red,$label_style_red);
        $isr_col_txt_style=array($text_style,$text_style_red,$text_style_red,$text_style_red);
        for($i=0;$i<4;$i++){
            $isrtable->addRow(50);
            $isrtable->addCell(1583)->addText($isr_col1[$i], $label_style , $text_style); 
            $isrtable->addCell(1583)->addText($isr_col2[$i], $isr_col_lbl_style[$i], $isr_col_txt_style[$i]);
            $isrtable->addCell(1583)->addText($isr_col3[$i], $isr_col_lbl_style[$i], $isr_col_txt_style[$i]);
            $isrtable->addCell(1585)->addText($isr_col4[$i], $label_style , $text_style);
            $isrtable->addCell(1583,['gridSpan'=>2])->addText('Passed', $label_style , $text_style);    
        }     
        $isrtable->addRow(-50);
        $isrtable->addCell(9500, ['gridSpan'=>'6','bold'=>true, 'align'=>'center', 'size'=>10,'bgcolor'=>'d9d9d9','spaceAfter' => 0]);
        $isrtable->addRow(500);
        $isrtable->addCell(3166,['gridSpan'=>'2','valign'=>'center'])->addText('Inspection Result is', $label_style_big , $text_style_big); 
        $isrtable->addCell(3166,['gridSpan'=>'2','valign'=>'center'])->addText('FAIL/PASS/Pending', $label_style_big , $text_style_big);
        $isrtable->addCell(3168,['gridSpan'=>'2','valign'=>'center'])->addText('Refer to remark/Out of AQL', $label_style_red_big , $text_style_red_big);

        $section->addPageBreak();

        //table for Remarks and Additional Information
        $phpWord->addTableStyle('Remarks and Additional Information', $tableStyle, ['bgColor' => '909090']);
        $raitable = $section->addTable('Remarks and Additional Information');
        $raitable->addRow(50);
        $raitable->addCell(9500, ['gridSpan'=>'4'])->addText('3. Remarks and Additional Information', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        $raitable->addRow(50);
        $raitable->addCell(3500)->addText('Check item  ( x )', $label_style , $text_style);
        $raitable->addCell(2000)->addText('Good', $label_style , $text_style); 
        $raitable->addCell(2000)->addText('Average', $label_style , $text_style);
        $raitable->addCell(2000)->addText('Poor', $label_style , $text_style);
        $rai_col_name=array("Factory Condition","Warehouse Condition","Cooperative management","Performance or Internal QC","Condition of test equipment","Number of Employees");
        for($i=0;$i<6;$i++){
            $raitable->addRow(50);
            $raitable->addCell(3500)->addText($i+1 .". ". $rai_col_name[$i], $label_style_left , $text_style_left);
            $raitable->addCell(2000)->addText('', $label_style , $text_style); 
            $raitable->addCell(2000)->addText('', $label_style , $text_style);
            $raitable->addCell(2000)->addText('', $label_style , $text_style);
        }
        $raitable->addRow(50);
        $textrun = $raitable->addCell(9500, ['gridSpan'=>'4','valign'=>'center']);
        $textrun->addText('1.', $label_style_red_left , $text_style_red_left);
        $textrun->addText('2.', $label_style_red_left , $text_style_red_left);
        $textrun->addText('3.', $label_style_red_left , $text_style_red_left);

        $section->addTextBreak();

        //table for Defects/Failure
        $phpWord->addTableStyle('Defects / Failure', $tableStyle, ['bgColor' => '909090']);
        $dftable = $section->addTable('Defects / Failure');
        $dftable->addRow(50);
        $dftable->addCell(9500, ['gridSpan'=>'5'])->addText('4. Defects / Failure', $headerStyle,['align'=>'center','spaceAfter' => 0]);   
        for($i=1;$i<=10;$i++){
            $dftable->addRow(50);
            $dftable->addCell(3500,$cell_style_gray)->addText('Photo'.$i, $label_style_left_bold , $text_style_bold);
            $dftable->addCell(3000,$cell_style_gray)->addText('Defect Description', $label_style , $text_style_left);
            $dftable->addCell(1000,$cell_style_gray)->addText('Critical', $label_style , $text_style);
            $dftable->addCell(1000,$cell_style_gray)->addText('Major', $label_style , $text_style);
            $dftable->addCell(1000,$cell_style_gray)->addText('Minor', $label_style , $text_style);
            $dftable->addRow(600);
            $dftable->addCell(3500)->addText('', $label_style_left , $text_style_left);
            $dftable->addCell(3000)->addText('', $label_style , $text_style_left);
            $dftable->addCell(1000)->addText('0', $label_style_red , $text_style_red);
            $dftable->addCell(1000)->addText('0', $label_style_red , $text_style_red);
            $dftable->addCell(1000)->addText('0', $label_style_red , $text_style_red);
        }

        $section->addTextBreak();
        
        //table for Product Details
        $left_text_arr = array("Product view", "Product view", "Warning words on poly bag","Hangtag","Barcode","Product view","Product view","Product inside view","Size measurement");
        $right_text_arr = array("Air hole on poly bag", "Product view", "poly seal view","Hangtag","Product view","Product view","Product view","Size measurement ","Weight for product");
        $phpWord->addTableStyle('Product Details', $tableStyle, ['bgColor' => '909090']);
        $pdtable = $section->addTable('Product Details');       
        $pdtable->addRow(50);
        $pdtable->addCell(9500, ['gridSpan'=>'4'])->addText('5. Product Details', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        for($i=0;$i<9;$i++){
            $pdtable->addRow(50);
            $pdtable->addCell(4750,$cell_style_gray_span)->addText($left_text_arr[$i], $label_style_bold , $text_style_center_bold);
            $pdtable->addCell(4750,$cell_style_gray_span)->addText($right_text_arr[$i], $label_style_bold , $text_style_center_bold);
            $pdtable->addRow(4000);
            $pdtable->addCell(4750,$cell_style_span); //add image here in array format
            $pdtable->addCell(4750,$cell_style_span); //add image here in array format
        }

        $section->addTextBreak();

        $phpWord->addTableStyle('Additional Remarks', $tableStyle, ['bgColor' => 'white']);
        $section->addText('Additional Remarks:');
        $amtable = $section->addTable('Additional Remarks');       
        $amtable->addRow(50);
        $amtable->addCell(9500, ['gridSpan'=>'4'])->addText('1.	No reference sample for reference and all measured data are actual finding.',['align'=>'left'] ,['align'=>'left','spaceAfter' => 0]);
       
        $section->addTextBreak();

        $phpWord->addTableStyle('Result Observation', $tableStyle, ['bgColor' => 'white']);
        $rotable = $section->addTable('Result Observation');       
        $rotable->addRow(50);       
        $rotable->addCell(3500, $cell_style)->addText('', $label_style , $text_style);
        $rotable->addCell(1500, $cell_style)->addText('Result', $label_style , $text_style);
        $rotable->addCell(4500, $cell_style)->addText('Observation', $label_style , $text_style);
        $ro_col_name=array("Color","Logo","Type Label/Rating Label","Instruction Manual","Accessories","Weight","Dimensions");
        for($i=0;$i<7;$i++){
            $rotable->addRow(50);
            $rotable->addCell(3500)->addText($ro_col_name[$i], $label_style , $text_style);
            $rotable->addCell(1500)->addText('Pass', $label_style , $text_style);
            $rotable->addCell(4500)->addText('', $label_style , $text_style);
        }

        $section->addTextBreak();

        $phpWord->addTableStyle('Inspection Parameter', $tableStyle, ['bgColor' => 'white']);
        $iptable = $section->addTable('Inspection Parameter');           
        $iptable->addRow(50);
        $iptable->addCell(2500, $cell_style)->addText('Inspection Parameter', $label_style , $text_style);
        $iptable->addCell(750, $cell_style)->addText('Unit', $label_style , $text_style);
        $iptable->addCell(750, $cell_style)->addText('Spec.', $label_style , $text_style);
        $iptable->addCell(1500, $cell_style)->addText('Sample', $label_style , $text_style);
        $iptable->addCell(4000, $cell_style)->addText('Condition', $label_style , $text_style);  

        $ip_col1=array("1. Weight","Unit weight ","2.Dimensions","Unit size  LXWXH");
        $ip_col2=array(null,"kg",null,null);
        $ip_col3=array(null,"N/A",null,"N/A");
        $ip_col4=array(null,"N/A",null,null);
        $ip_col5=array(null,"Found no client spec during inspection, please confirm.",null,null);
        $ip_style=array(null,$cell_style,null,$cell_style);     
        for($i=0;$i<4;$i++){
            $iptable->addRow(50);
            $iptable->addCell(2500,$ip_style[$i])->addText($ip_col1[$i], $label_style , $text_style);
            $iptable->addCell(750)->addText($ip_col2[$i], $label_style , $text_style);
            $iptable->addCell(750)->addText($ip_col3[$i], $label_style , $text_style);
            $iptable->addCell(1500)->addText($ip_col4[$i], $label_style , $text_style);
            $iptable->addCell(4000)->addText($ip_col5[$i], $label_style , $text_style);        
        }

        $section->addTextBreak();

        $phpWord->addTableStyle('Measurement table for garments product', $tableStyle, ['bgColor' => '909090']);
        $mtfgptable = $section->addTable('Measurement table for garments product');       
        $mtfgptable->addRow(50);
        $mtfgptable->addCell(9500, ['gridSpan'=>'4'])->addText('6. Measurement table for garments product', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        $mtfgptable->addRow(5000);
        $mtfgptable->addCell(9500, ['gridSpan'=>'4']);

        $section->addPageBreak();

        //table for Function Checking
        $phpWord->addTableStyle('Function Checking', $tableStyle, ['bgColor' => '909090']);
        $fctable = $section->addTable('Function Checking');       
        $fctable->addRow(50);
        $fctable->addCell(9500, ['gridSpan'=>'6'])->addText('7. Function Checking', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        $fctable->addRow(50);
        $fctable->addCell(5500,$cell_style_gray_span)->addText('Checking and testing of details', $label_style , $text_style);
        $fctable->addCell(1500,$cell_style_gray)->addText('Sampling/pcs', $label_style , $text_style);
        $fctable->addCell(500,$cell_style_gray)->addText('OK', $label_style , $text_style);
        $fctable->addCell(500,$cell_style_gray)->addText('NOK', $label_style , $text_style);
        $fctable->addCell(1500,$cell_style_gray)->addText('Pending', $label_style , $text_style);
        $checked = '<w:sym w:font="Wingdings" w:char="F0FE"/>';
        $unChecked = '<w:sym w:font="Wingdings" w:char="F0A8"/>';
        $alpha_arr=array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r"); //18
        $fc_col1=array("Bar Code Scanning Test","Drop test","Pull / Push test: Pull the seams by hand with a tough force. Check if there is any needle holes caused by the needle machine","Assembly test","Color fastness test (fabric, bags etc)","k. Pantone comparison (if customer has pantone code provided)","Logo comparison on the same level","Metal detection test","Label Acid Test/Rubbing test"," How many Stitches per inch : ?","Smell test","Loading test ","Capacity test","Fatigue test ( eg: aluminium bottle)","Water leakage test","Zipper test(anti-fatigue testing)20 times/pcs","","The more function test ,Please made it up according to products更多测试项目，请根据产品补充功能测试内容。");
        for($i=0;$i<18;$i++){
            $fctable->addRow(50);
            $fctable->addCell(300)->addText($alpha_arr[$i], $label_style , $text_style);
            $fctable->addCell(5200)->addText($fc_col1[$i], $label_style , $text_style);
            $fctable->addCell(1500)->addText('pcs', $label_style , $text_style);
            $fctable->addCell(500,$center)->addCheckBox('okChkBox' . $i,'',$center_space,$center_space);
            $fctable->addCell(500,$center)->addCheckBox('nokChkBox','',$center_space,$center_space);
            $fctable->addCell(1500,$center)->addCheckBox('pendingChkBox3','',$center_space,$center_space);
        }


        $section->addPageBreak();
        
        //table for Test Photos
        $tp_col1 = array("Bar Code Scan test", "Smell Test", "Color fastness test by dry  white garments"," Metal detection test","Stitch per inch measurement","Drop Test (height)","Drop Test (Open view)","Pantone comparison");
        $tp_col2 = array("Bar Code Scan test", "Push / Pull Test", "Color fastness test by wet  white garments"," Label acid test","Stitch per inch measurement","Drop Test (product on floor)","Pantone comparison ","Pantone comparison");
        $phpWord->addTableStyle('Test Photos', $tableStyle, ['bgColor' => '909090']);
        $tptable = $section->addTable('Test Photos');       
        $tptable->addRow(50);
        $tptable->addCell(9500, ['gridSpan'=>'4'])->addText('8. Test Photos', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        for($i=0;$i<8;$i++){
            $tptable->addRow(50);
            $tptable->addCell(4750,$cell_style_gray_span)->addText($tp_col1[$i], $label_style_bold , $text_style_center_bold);
            $tptable->addCell(4750,$cell_style_gray_span)->addText($tp_col2[$i], $label_style_bold , $text_style_center_bold);
            $tptable->addRow(4000);
            $tptable->addCell(4750,$cell_style_span); //add image here in array format
            $tptable->addCell(4750,$cell_style_span); //add image here in array format
        }

        $section->addPageBreak();
        
        //table for Packing of products
        $pp_col1 = array("Gift Box", "Top View", "Bottom View"," Side View Right","Logo on Gift Box","Model No.","Size 1","Size 3","Weight");

        $pp_col2 = array("Front View", "Back View", "Side View Left","Back View","Warranty Label","Bar Code","Size 2","Size 4","");
        $phpWord->addTableStyle('Packing of products', $tableStyle, ['bgColor' => '909090']);
        $pptable = $section->addTable('Packing of products');       
        $pptable->addRow(50);
        $pptable->addCell(9500, ['gridSpan'=>'4'])->addText('9. Packing of products', $headerStyle,['align'=>'center','spaceAfter' => 0]);
        for($i=0;$i<9;$i++){
            $pptable->addRow(50);
            $pptable->addCell(4750,$cell_style_gray_span)->addText($pp_col1[$i], $label_style_bold , $text_style_center_bold);
            $pptable->addCell(4750,$cell_style_gray_span)->addText($pp_col2[$i], $label_style_bold , $text_style_center_bold);
            $pptable->addRow(4000);
            $pptable->addCell(4750,$cell_style_span); //add image here in array format
            $pptable->addCell(4750,$cell_style_span); //add image here in array format
        }

        $section->addTextBreak();
        $phpWord->addTableStyle('Additional Remarks', $tableStyle, ['bgColor' => 'white']);
        $section->addText('Additional Remarks:');
        $amtable = $section->addTable('Additional Remarks');       
        $amtable->addRow(50);
        $amtable->addCell(9500, ['gridSpan'=>'4'])->addText('No reference sample for reference and all measured data are actual finding.',['align'=>'left'] ,['align'=>'left','spaceAfter' => 0]);    
        $section->addTextBreak();

        $phpWord->addTableStyle('Result Observation', $tableStyle, ['bgColor' => 'white']);
        $rotable2 = $section->addTable('Result Observation');       
        $rotable2->addRow(50);       
        $rotable2->addCell(3500, $cell_style)->addText('', $label_style , $text_style);
        $rotable2->addCell(1500, $cell_style)->addText('Result', $label_style , $text_style);
        $rotable2->addCell(4500, $cell_style_gray_span3)->addText('Observation', $label_style , $text_style);
        $ro2_col_name1=array("Unit Packing","Accessories Packing","Color","Logo","Type Label/Rating Label","Accessories","Weight","Dimensions","Barcode");
        for($i=0;$i<9;$i++){
            $rotable2->addRow(50);
            $rotable2->addCell(3500)->addText($ro2_col_name1[$i], $label_style , $text_style);
            $rotable2->addCell(1500)->addText('Pass', $label_style , $text_style);
            if($i==0){
                $rotable2->addCell(4500,$cell_style_span3)->addText('?pcs /gift box', $label_style , $text_style);
            }else{
                $rotable2->addCell(4500,$cell_style_span3)->addText('', $label_style , $text_style);
            }
            
        }

        $section->addTextBreak();

        $phpWord->addTableStyle('Inspection Parameter', $tableStyle, ['bgColor' => 'white']);
        $iptable2 = $section->addTable('Inspection Parameter');           
        $iptable2->addRow(50);
        $iptable2->addCell(2500, $cell_style)->addText('Inspection Parameter', $label_style , $text_style);
        $iptable2->addCell(750, $cell_style)->addText('Unit', $label_style , $text_style);
        $iptable2->addCell(750, $cell_style)->addText('Spec.', $label_style , $text_style);
        $iptable2->addCell(1500, $cell_style)->addText('Mass Sample', $label_style , $text_style);
        $iptable2->addCell(4000, $cell_style)->addText('Condition', $label_style , $text_style);  

        $ip2_col1=array("1. Weight","Gift Box weight","2. Dimensions","Gift box size  LxWxH");
        $ip2_col2=array(null,"kg",null,"mm");
        $ip2_col3=array(null,"N/A",null,"N/A");
        $ip2_col4=array(null,"Found no client spec during inspection, please confirm.",null,"PLS double check customer SPEC, If no client spec during inspection, please confirm.");  
        for($i=0;$i<4;$i++){
            $iptable2->addRow(50);
            $iptable2->addCell(2500)->addText($ip2_col1[$i], $label_style , $text_style);
            $iptable2->addCell(750)->addText($ip2_col2[$i], $label_style , $text_style);
            $iptable2->addCell(750)->addText($ip2_col3[$i], $label_style , $text_style);
            $iptable2->addCell(1500)->addText('', $label_style , $text_style);
            if($i==1 || $i==3){
                $iptable2->addCell(4000)->addText($ip2_col4[$i], $label_style_red , $text_style_red); 
            }else{
                $iptable2->addCell(4000)->addText($ip2_col4[$i], $label_style , $text_style); 
            }                
        }

        $section->addPageBreak();
        
        //table for Packing of products      
        $phpWord->addTableStyle('Export Carton Packing', $tableStyle, ['bgColor' => '909090']);
        $ecptable = $section->addTable('Export Carton Packing');       
        $ecptable->addRow(50);
        $ecptable->addCell(9500, ['gridSpan'=>'4'])->addText('9. Export Carton Packing', $headerStyle,['align'=>'center','spaceAfter' => 0]);

        $ecp_col1 = array("Export Carton in Warehouse", "Top View", "Bottom View"," Side View Right","Shipping Mark Detail","Tape Closed Carton","TIC Inspection Chop","Size 2","Weight");
        $ecp_col2 = array("Front View", "Back View", "Side View Left","Back View","Side Mark Detail","TIC Sticker Seal","Size 1","Size 3","");

        for($i=0;$i<9;$i++){
            $ecptable->addRow(50);
            $ecptable->addCell(4750,$cell_style_gray_span)->addText($ecp_col1[$i], $label_style_bold , $text_style_center_bold);
            $ecptable->addCell(4750,$cell_style_gray_span)->addText($ecp_col2[$i], $label_style_bold , $text_style_center_bold);
            $ecptable->addRow(4000);
            $ecptable->addCell(4750,$cell_style_span); //add image here in array format
            $ecptable->addCell(4750,$cell_style_span); //add image here in array format
        }

        $section->addTextBreak();
        $phpWord->addTableStyle('Additional Remarks', $tableStyle, ['bgColor' => 'white']);
        $section->addText('Additional Remarks:');
        $amtable3 = $section->addTable('Additional Remarks');       
        $amtable3->addRow(50);
        $amtable3->addCell(9500, ['gridSpan'=>'4'])->addText('No reference sample for reference and all measured data are actual finding.',['align'=>'left'] ,['align'=>'left','spaceAfter' => 0]);    
        $section->addTextBreak();

        $phpWord->addTableStyle('Result Observation', $tableStyle, ['bgColor' => 'white']);
        $rotable3 = $section->addTable('Result Observation');       
        $rotable3->addRow(50);       
        $rotable3->addCell(3500, $cell_style)->addText('', $label_style , $text_style);
        $rotable3->addCell(1500, $cell_style)->addText('Result', $label_style , $text_style);
        $rotable3->addCell(4500, $cell_style_gray_span3)->addText('Observation', $label_style , $text_style);
        $ro2_col_name1=array("Total No of Cartons","Qty inside Export Carton","Shipping Mark","Side Mark","Export Carton Dimension","Export Carton Weight","Barcode ");
        for($i=0;$i<7;$i++){
            $rotable3->addRow(50);
            $rotable3->addCell(3500)->addText($ro2_col_name1[$i], $label_style , $text_style);
            $rotable3->addCell(1500)->addText('Pass', $label_style , $text_style);
            if($i==0){
                $rotable3->addCell(4500,$cell_style_span3)->addText('? CTN', $label_style , $text_style);
            }else if($i==1){
                $rotable3->addCell(4500,$cell_style_span3)->addText('? PCS per carton', $label_style , $text_style);
            }else{
                $rotable3->addCell(4500,$cell_style_span3)->addText('', $label_style , $text_style);
            }          
        }

        $section->addTextBreak();

        $phpWord->addTableStyle('Inspection Parameter', $tableStyle, ['bgColor' => 'white']);
        $iptable3 = $section->addTable('Inspection Parameter');           
        $iptable3->addRow(50);
        $iptable3->addCell(2500, $cell_style)->addText('Inspection Parameter', $label_style , $text_style);
        $iptable3->addCell(750, $cell_style)->addText('Unit', $label_style , $text_style);
        $iptable3->addCell(750, $cell_style)->addText('Spec.', $label_style , $text_style);
        $iptable3->addCell(1500, $cell_style)->addText('Mass Sample', $label_style , $text_style);
        $iptable3->addCell(4000, $cell_style)->addText('Condition', $label_style , $text_style);  

        $ip3_col1=array("1.Weight","Export Carton weight","2.Dimensions","Export Carton Size  LxWxH");
        $ip3_col2=array(null,"kg",null,"mm");
        $ip3_col3=array(null,"N/A",null,"N/A");
        $ip3_col4=array(null,"Found no client spec during inspection, please confirm.",null,"Found no client spec during inspection, please confirm.");  
        for($i=0;$i<4;$i++){
            $iptable3->addRow(50);
            $iptable3->addCell(2500)->addText($ip3_col1[$i], $label_style , $text_style);
            $iptable3->addCell(750)->addText($ip3_col2[$i], $label_style , $text_style);
            $iptable3->addCell(750)->addText($ip3_col3[$i], $label_style , $text_style);
            $iptable3->addCell(1500)->addText('', $label_style , $text_style);
            if($i==1 || $i==3){
                $iptable3->addCell(4000)->addText($ip3_col4[$i], $label_style_red , $text_style_red); 
            }else{
                $iptable3->addCell(4000)->addText($ip3_col4[$i], $label_style , $text_style); 
            }              
        }

        $section->addTextBreak(2);
        $phpWord->addTableStyle('Last Part', $tableStyle, ['bgColor' => 'white']);
        $lptable = $section->addTable('Last Part');           
        $lptable->addRow(500);
        $lptable->addCell(9500)->addText('The prepared report provides information gathered on site of the performed inspection. All Draft reports are submitted to TIC technical department for verification purposes. Draft reports are exclusively for communication between the inspector and TIC. A Final inspection report will be issued after verification. Any action made by a party based on the results shown on the Draft report is done at the party’s own risk. All TIC reports are for reporting purposes only and do not provide and exemption for the manufacturer or seller from any predetermined obligations to the customer to alter, repair or replace any materials in which defects may hereafter develop or be found. Any exchange of goods after inspection took place is not allowed. The seller or manufacturer is in no case released from his warranty and good product delivery obligations. TIC’s report does not take place of liability insurance for the manufacturer or seller. TIC inspections are performed to best of our ability but without responsibility beyond our liability as stated in TIC terms and conditions of services. TIC Report does not evidence shipment.', $label_style_justify , $text_style_justify);

        $section->addTextBreak();
        $section->addText("Inspected by:");
        $section->addText("Reviewed by: ");
        $section->addText("Confirmed by: XXX(Factory QC Manager)");
        $section->addTextBreak();
        $section->addText("--End of report--",$label_style_bold,$text_style_center_bold);

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
