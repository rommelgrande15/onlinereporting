<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\User;
use App\Inspection;
use App\UserInfo;
use DB;
use App\Report;
use App\Client;
use App\ClientContact;
use App\Factory;
use App\FctoryContact;
use App\PSIProduct;
use App\InspectionPhotos;
use App\InspectorReportData;
use App\ReportsDefectsFailure;
use App\PstCodeDataReport;
use App\PstCodeData;
use App\PartNumberData;
use App\PstCodeBulkData;
use App\SummaryResultData;
use App\ClientAqlDetail;
use App\ClientAqlMinor;
use App\ClientAqlMajor;
use Illuminate\Support\Facades\File;
use Session;
use Exception;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\Element\AbstractContainer;
use PhpOffice\PhpWord\Element\Row;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\SimpleType\NumberFormat;

class InspectorAccountController extends Controller
{

    public function getLoginReturn(){
    	return view('pages.inspector.index');
    }
    public function getDashboardInspectorForReports($id){
		// if(!Auth::id()){
		// 	return redirect()->route('login');
		// }
		
		$role = User::where('id',Auth::id())->first();
		
		// if($role->category == 'inspector'){
		// 	$user_info = UserInfo::where('user_id',Auth::id())->first();
        // 	$user = User::where('id',Auth::id())->first();
        // 	$inspector = UserInfo::select('id','name','email_address')->where('designation','inspector')->orderBy('name')->get();
			
		// 	return view('pages.inspector.index',compact('user_info','user','inspector'));
		// } else {
		// 	return redirect()->route('login');
		// }
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $inspector = UserInfo::select('id','name','email_address')->where('designation','inspector')->orderBy('name')->get();
        
        return view('pages.inspector.index',compact('user_info','user','inspector'));
		
	}

    public function postLoginReportDetails(Request $request){
        //check if report_number exists
        $report = Report::where('report_no', $request['report_no'])
                        ->orWhere('report_no',$request['report_no'])
                        // ->where('password',$request['password'])
                        // ->orWhere('password',$request['password'])
                        ->first();
        $reportCount = Report::where('report_no', $request['report_no'])
                        ->count();
        if ($reportCount == 0) {
            $inspection = Inspection::where('reference_number', $request['report_no'])->orWhere('reference_number', $request['report_no'])->first();

            if($inspection == null){
                //return URL::current();
                Session::flash('error','Incorrect Report Number / Password. Please Insert Report Details Again!');
                    return redirect()->route('login-again');
            }
        }else if($reportCount == 1) {
            if($report->password == $request['password']){
                $inspection = Inspection::where('reference_number', $request['report_no'])->orWhere('reference_number',$request['report_no'])->first();
                if($inspection->inspection_status == 'Released'){
                    return redirect()->route('inspector-reports-general',$report);
                }else if($inspection->inspection_status == 'Client Pending'){
                    Session::flash('error','This inspection is validating by the Booking Team, Please wait for the Booking Team to Release.');
                        return redirect()->route('login-again');
                }else{
                    Session::flash('error','Incorrect Report Number / Password. Please Insert Report Details Again!');
                    return redirect()->route('login-again');
                }
            }else{
                Session::flash('error','Incorrect Report Number / Password. Please Insert Report Details Again!');
                return redirect()->route('login-again');
            }
            }else{
                Session::flash('error','Incorrect Report Number / Password. Please Insert Report Details Again!');
                return redirect()->route('login-again');
            }
        }
        

    public function getInspectorGeneralInformationReportsDetails($id){
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        if($user_info->designation == 'inspector'){
            $role = User::where('id',Auth::id())->first();
            //$countries = Country::all();
            $user_info = UserInfo::where('user_id',Auth::id())->first();
            $user = User::where('id',Auth::id())->first();
            $report = Report::where('id', $id)->first();
            $inspection = Inspection::where('id',$report->inspection_id)->first();
            $inspector = UserInfo::select('id','name','email_address')->where('designation','inspector')->orderBy('name')->get();
           
            $client = Client::where('client_code',$inspection->client_id)->first();
            $client_contact_person = ClientContact::where('id',$inspection->contact_person)->first();
            $factory = Factory::where('id',$inspection->factory)->first();
            $factory_contact_person = FctoryContact::where('id',$inspection->factory_contact_person)->first();
            $psi_products = PSIProduct::where('inspection_id',$inspection->id)->first();
            $inspection_photos = InspectionPhotos::where('report_no',$id)->get();
            $pst_code_data_reports = PstCodeDataReport::all();
            $pst_code_datas = PstCodeData::all();

            $client_aql_minors_orig = ClientAqlMinor::all();
            $client_aql_majors_orig = ClientAqlMajor::all();
            
            $client_aql_minors = $client_aql_minors_orig->pluck('aql','aql');
            $client_aql_majors = $client_aql_majors_orig->pluck('aql','aql');
            $normal=['I'=>'I','II'=>'II','III'=>'III'];
            $special=['S1'=>'S1','S2'=>'S2','S3'=>'S3','S4'=>'S4'];
            $aql_major = ['0.065'=>'0.065','0.1'=>'0.1','0.15'=>'0.15','0.25'=>'0.25','0.40'=>'0.40','1'=>'1','1.5'=>'1.5','2.5'=>'2.5','4'=>'4','6.5'=>'6.5','10'=>'10'];
            $units=['piece'=>'Piece/s','roll'=>'Roll/s','set'=>'Set/s','pair'=>'Pair/s','box'=>'Box/es'];

            //DELETING EXISTING PHOTO PATH IF RELOAD
            $dir="images/inspection/".$id;
            if (File::exists($dir)) {
                File::deleteDirectory(public_path($dir));
                $del_att=DB::table('inspection_photos')->where('report_no',$id)->delete();
                $del_temporary_while_developing=DB::table('inspector_report_datas')->where('report_id',$id)->delete();
                $del_temporary_while_developing_defects=DB::table('reports_defects_failures')->where('report_id',$id)->delete();
                $del_temporary_while_developing_summary=DB::table('summary_result_datas')->where('report_id',$id)->delete();
            }

            return view('pages.inspector.generalinformation.index',compact('user_info','user','inspector','report','inspection','client','client_contact_person','factory','factory_contact_person','psi_products','inspection_photos','pst_code_data_reports','pst_code_datas','client_aql_minors','client_aql_majors','normal','special','aql_major','units'));
        }else{
            return redirect()->route('login');
        }
        
    }

    public function getPstCode($id){
        if($id == '11156889'){
            $main_part_qty = PstCodeBulkData::all();
            return response()->json([
                'main_part_qty' => $main_part_qty,
            ]);
        }else{
            $main_part_qty_id = PstCodeData::where('pst_code',$id)->first(); 
            $main_part_qty = PstCodeDataReport::where('pst_code',$main_part_qty_id->pst_code)->get();
            return response()->json([
                'main_part_qty' => $main_part_qty,
            ]);
        }
        
    }

    public function getPartNumberData($id){
        // $pst_code_data_report_id = PstCodeData::find($id);
        $pst_code_data_report_id = PstCodeData::where('main_part',$id)->first(); 
        $pst_code_data_report_filling = PstCodeDataReport::where('pst_code',$pst_code_data_report_id->pst_code)->where('main_part_qty',$pst_code_data_report_id->main_part)->get();
        return response()->json([
            'pst_code_data_report_filling' => $pst_code_data_report_filling,
        ]);
    }

    public function getMainPartData($id){
        // $pst_code_main_part_data_report_id = PstCodeDataReport::find($id);
            $pst_code_main_part_data_report_id = PstCodeDataReport::where('part_number',$id)->count(); 
        if($pst_code_main_part_data_report_id > 0){
            $pst_code_main_part_data_report_id = PstCodeDataReport::where('part_number',$id)->first(); 
        }else{
            $pst_code_main_part_data_report_id = PstCodeBulkData::where('part_number',$id)->first(); 
        }
        
        return response()->json([
            'pst_code_main_part_data_report_id' => $pst_code_main_part_data_report_id,
        ]);
    }



    public function getInspectorInspectionSummaryResultReportsDetails($id){
        $role = User::where('id',Auth::id())->first();
        //$countries = Country::all();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $inspector = UserInfo::select('id','name','email_address')->where('designation','inspector')->orderBy('name')->get();
        $report = Report::where('id', $id)->first();
        $inspection = Inspection::where('id',$report->inspection_id)->first();
        $client = Client::where('client_code',$inspection->client_id)->first();
        $client_contact_person = ClientContact::where('id',$inspection->contact_person)->first();
        $factory = Factory::where('id',$inspection->factory)->first();
        $factory_contact_person = FctoryContact::where('id',$inspection->factory_contact_person)->first();
        $psi_products = PSIProduct::where('inspection_id',$inspection->id)->first();
 
        return view('pages.inspector.inspectionsummary.index',compact('user_info','user','inspector','report','inspection','client','client_contact_person','factory','factory_contact_person','psi_products'));
    }

    public function saveInspectorReportDetails(Request $request){
        // DB::beginTransaction();
        // try {
      

        //GENERAL INFORMATION PAGE
        $inspector_report_datas = new InspectorReportData();
        $inspector_report_datas->inspector_id = $request['inspector_id'];
        $inspector_report_datas->report_id = $request['report_id'];
        $inspector_report_datas->report_no = $request['report_no'];
        $inspector_report_datas->inspection_id = $request['inspection_id'];
        $inspector_report_datas->p_s_i_products_id = $request['p_s_i_products_id'];

        $inspector_report_datas->inspection_date = $request['inspection_date'];
        $inspector_report_datas->service = $request['service'];
        $inspector_report_datas->client_name = $request['client_name'];
        $inspector_report_datas->client_contact_name = $request['client_contact_person'];
        $inspector_report_datas->factory_name = $request['factory_name'];
        $inspector_report_datas->factory_contact_name = $request['factory_contact'];
        $inspector_report_datas->factory_address = $request['factory_address'];
        $inspector_report_datas->remarks_details = $request['remarks_details'];

        //ADDITIONAL HEADER INFORMATION
        $inspector_report_datas->inspected_by = $request['inspected_by'];
        $inspector_report_datas->confirm_by = $request['confirm_by'];
        $inspector_report_datas->report_date = $request['report_date'];
        $inspector_report_datas->result = $request['result'];
        


            if($inspector_report_datas->save()){
                
               $name =  $request->pst_code;
           $countts = count((array)$name);
            //    $summary_result_data = new SummaryResultData();
                //PART #1
            //   print_r($countts);
            //   dd($request->input());  
            //   exit();
                 //  for ($i = 0; $i < count($request['pst_code']); $i++) {
              //  DB::insert("insert into summary_result_datas (report_id, inspection_id,inspector_id,pst_code1) values ('".$request['report_id']."', '".$cc."','".$request['inspector_id']."','".$cc."')");
          //  }
           
for($i = 0; $i < $countts; $i++){
      $k=$i+1;

              
                       $summary_result_data = new SummaryResultData();
                $summary_result_data->report_id = $request['report_id'];
                $summary_result_data->inspection_id = $request['inspection_id'];
                $summary_result_data->inspector_id = $request['inspector_id'];
 $summary_result_data->pst_code2 = $request['uniqueid'];
                $summary_result_data->pst_code1 = $request['pst_code'][$i];
              
                $summary_result_data->main_part_qty1 = $request['main_part_qty'][$i];
                $summary_result_data->part_number1 = $request['part_number'][$i];
                $summary_result_data->manufacture_code1 = $request['manufacture_code'][$i];
                $summary_result_data->description1 = $request['description'][$i];
                $summary_result_data->bom_qty1 = $request['bom_qty'][$i];
                $summary_result_data->qty_pcs1 = $request['qty_pcs'][$i];
                $summary_result_data->total_packaging1 = $request['total_packaging'][$i];
                $summary_result_data->samples_unit1 = $request['samples_unit'][$i];
                $summary_result_data->carton_size_weight1 = $request['carton_size'][$i];
                $summary_result_data->carton_weight1 = $request['carton_weight'][$i];
 // $summary_result_data->aql_qty1 = $request['aql_qty'][$i];
   $summary_result_data->aql_qty_unit1 = $request['aql_qty_unit'][$i];
    $summary_result_data->aql_normal_level1 = $request['aql_normal_level'][$i];
	 $summary_result_data->aql_special_level1 = $request['aql_special_level'][$i];
	  $summary_result_data->product_aql_major1 = $request['aql_major'][$i];
	   $summary_result_data->product_max_allowed_major1 = $request['max_major'][$i];
	     $summary_result_data->product_aql_minor1 = $request['max_minor'][$i];
	   $summary_result_data->product_max_allowed_minor1 = $request['aql_minor'][$i];
	    
               $summary_result_data->shipt_qty1 = $request['shipt_qty'.$k];
               
                $summary_result_data->ce_report1 = $request['ce_report'.$k];
				
                $summary_result_data->color_logo_style1 = $request['color_logo_style'.$k];
                $summary_result_data->marking1 = $request['marking'.$k];
                $summary_result_data->prouct_spect_function1 = $request['prouct_spect_function'.$k];
                $summary_result_data->visual_checking1 = $request['visual_checking'.$k];
                $summary_result_data->product_packing1 = $request['product_packing'.$k];
                $summary_result_data->ship_mark1 = $request['ship_mark'.$k];
                $summary_result_data->export_carton1 = $request['export_carton'.$k];
                $summary_result_data->measurement_data1 = $request['measurement_data'.$k];
                $summary_result_data->comparable_with_sample1 = $request['comparable_with_sample'.$k];

                $summary_result_data->remarks_shipt_qty1 = $request['remarks_shipt_qty'.$k];
                $summary_result_data->remarks_ce_report1 = $request['remarks_ce_report'.$k];
                $summary_result_data->remarks_color_logo_style1 = $request['remarks_color_logo_style'.$k];
                $summary_result_data->remarks_marking1 = $request['remarks_marking'.$k];
                $summary_result_data->remarks_prouct_spect_function1 = $request['remarks_prouct_spect_function'.$k];
                $summary_result_data->remarks_visual_checking1 = $request['remarks_visual_checking'.$k];
                $summary_result_data->remarks_product_packing1 = $request['remarks_product_packing'.$k];
                $summary_result_data->remarks_ship_mark1 = $request['remarks_ship_mark'.$k];
                $summary_result_data->remarks_export_carton1 = $request['remarks_export_carton'.$k];
                $summary_result_data->remarks_measurement_data1 = $request['remarks_measurement_data'.$k];
                $summary_result_data->remarks_comparable_with_sample1 = $request['remarks_comparable_with_sample'.$k];

               
                $summary_result_data->part_of_inspection_product = '1';
                
				
				 $defects_categorys =  $request->sid;
           $counttsp = count((array)$defects_categorys);
              //  if($summary_result_data->save()){
                  
				
               $summary_result_data->save();
			   $lastId = $summary_result_data->id;
			    for($p = 0; $p < $counttsp; $p++){
					   if($request['sid'][$p]==$k){
						   if($request['defects_category'][$p]!=''){
                    $report_defects_failure = new ReportsDefectsFailure();
                    $report_defects_failure->report_id = $request['report_id'];
                    $report_defects_failure->inspection_id = $request['inspection_id'];
                    $report_defects_failure->inspector_id = $request['inspector_id'];

                    $report_defects_failure->defects_category1_part2 = $request['defects_category'][$p];
                    $report_defects_failure->defects_category2_part2 = $lastId;
                    $report_defects_failure->defects_category3_part2 = 'defects';


                    $report_defects_failure->number_of_defects1_part2 = $request['number_of_defects'][$p];
                   
                    $report_defects_failure->defect_details1_part2 = $request['defect_details'][$p];
                   
                    

                    $report_defects_failure->defects_part_number = '1';
                    $report_defects_failure->save();
					   }
					   }
                    }
				 $defects_categorysq =  $request->rid;
           $counttspq = count((array)$defects_categorysq);
				 for($q = 0; $q < $counttspq; $q++){
					   if($request['rid'][$q]==$k){
						   if($request['function_test'][$q]!=''){
                    $report_defects_failure = new ReportsDefectsFailure();
                    $report_defects_failure->report_id = $request['report_id'];
                    $report_defects_failure->inspection_id = $request['inspection_id'];
                    $report_defects_failure->inspector_id = $request['inspector_id'];

                    $report_defects_failure->defects_category1_part2 = $request['function_test'][$q];
                    $report_defects_failure->defects_category2_part2 = $lastId;
                    $report_defects_failure->defects_category3_part2 = 'functional';


                    $report_defects_failure->number_of_defects1_part2 = $request['sampling_size'][$q];
                   
                    $report_defects_failure->defect_details1_part2 = $request['function_test_unit'][$q];
                   
                     $report_defects_failure->defects_category4_part2 = $request['function_test_result'][$q];
                   

                    $report_defects_failure->defects_part_number = '1';
                    $report_defects_failure->save();
					   }
					   }
                    }
			   
			   
                 }
				
				
                
               // }
               
            }
                   
            }
        
            // } catch (Exception $e) {
                //     DB::rollback();
                //     return response()->json([
                //         'message'=>$e->getMessage()
                //     ],500);
                // }     
    
                public function generateDocx($id,$pid){
                    $user_info = UserInfo::where('user_id',Auth::id())->first();
                    $user = User::where('id',Auth::id())->first();
                    $inspection_report_data = InspectorReportData::where('report_id', $id)->first();
                    $psi_products = PSIProduct::where('id',$inspection_report_data->p_s_i_products_id)->first();
                    $inspection = Inspection::where('id',$inspection_report_data->inspection_id)->first();
                    $report = Report::where('id', $id)->first();
                    $reports_defects_failures1 = ReportsDefectsFailure::where('report_id',$inspection_report_data->report_id)
                                                ->where('inspection_id',$inspection_report_data->inspection_id)
                                                ->where('inspector_id',$inspection_report_data->inspector_id)
                                                ->where('defects_part_number','1')
                                                ->first();
                    $product = SummaryResultData::where('report_id',$inspection_report_data->report_id)
                                                ->where('inspection_id',$inspection_report_data->inspection_id)
                                                ->where('inspector_id',$inspection_report_data->inspector_id)
												  ->where('pst_code2',$pid)
                                                ->where('part_of_inspection_product','1')
                                                ->get();
                    
                    // $inspectionPhotosDefectFailurePhotos1Part2 = InspectionPhotos::where('report_no', $id)
                    //                             ->where('photo_description','defect_failure_photos1_part2')
                    //                             ->get();
                    // $inspectionPhotosDefectFailurePhotos1Part3 = InspectionPhotos::where('report_no', $id)
                    //                             ->where('photo_description','defect_failure_photos1_part3')
                    //                             ->get();
                    // $inspectionPhotosDefectFailurePhotos1Part4 = InspectionPhotos::where('report_no', $id)
                    //                             ->where('photo_description','defect_failure_photos1_part4')
                    //                             ->get();
                    // $inspectionPhotosDefectFailurePhotos1Part5 = InspectionPhotos::where('report_no', $id)
                    //                             ->where('photo_description','defect_failure_photos1_part5')
                    //                             ->get();
             $inspectionPhotosRemarks = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','remarks_photos')
                                                        ->get();
                    $inspectionPhotosRemarksCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','remarks_photos')
                                                        ->count();
                    $inspectionPhotos = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','general_information_photos')
                                                        ->get();
                    $inspectionPhotosCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','general_information_photos')
                                                        ->count();
            
                    //PART NUMBER1 PHOTOS
                   
                  
                    $inspectionPhotosDefectFailurePhotos = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','defect_failure_photos1')
                                                        ->get();
                    $inspectionPhotosDefectFailureCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','defect_failure_photos1')
                                                        ->count();
                    $inspectionPhotosFunctionChecks = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','function_checking_test_photos')
                                                        ->get(); 
                    $inspectionPhotosFunctionChecksCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','function_checking_test_photos')
                                                        ->count(); 
                    
                   
            
               
            
                    $inspectionPhotosFunctionChecks = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','function_checking_test_photos1')
                                                        ->get(); 
                    $inspectionPhotosFunctionChecksCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','function_checking_test_photos1')
                                                        ->count(); 
            
                                                        
                    $inspectionPhotosDefects = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','defect_failure_photos')
                                                        ->get();
                    $inspectionPhotosDefectsCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','defect_failure_photos')
                                                        ->count();    
                    $inspectionPhotosBribery = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','ab_nd_or_photos')
                                                        ->get();
                    $inspectionPhotosBriberyCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','ab_nd_or_photos')
                                                        ->count();                            
                    $inspectionPhotosOnsite = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','onsite_report_photos')
                                                        ->get();
                    $inspectionPhotosOnsiteCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','onsite_report_photos')
                                                        ->count();   
                                                        
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $phpWord->setDefaultParagraphStyle(array(
                        'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT,
                        // 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),
                        // 'spacing' => 120,
                        // 'lineHeight' => 1,
                        )
                        );
            
                    $phpWord->getCompatibility()->setOoxmlVersion(14);
                    $phpWord->getCompatibility()->setOoxmlVersion(15);
            
            
                    $section = $phpWord->addSection(array('marginLeft' => 400, 'marginRight' => 400,'marginTop' => 400, 'marginBottom' => 400));
                    $section->getStyle()->setBreakType('continuous');
                    $header = $section->addHeader();
                    $header->headerTop(10);
            
                    $styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','valign'=>'center' );
                    $TitlestyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','bgColor'=>'#d3d9de','valign'=>'center');
                    //FONT STYLE
                    $fontStyle = array('italic'=> false, 'size'=>12, 'name'=>'Arial','afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'valign'=>'center',);
                    $TfontStyle = array('bold'=>true, 'italic'=> false, 'size'=>12, 'name' => 'Arial', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'valign'=>'center');
                    $HfontStyle = array('bold'=>true, 'italic'=> false, 'size'=>12, 'name' => 'Arial', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'valign'=>'center',);
                    $cfontStyle = array('allCaps'=>true,'italic'=> false, 'size'=>12, 'name' => 'Times New Roman','afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0, 'valign'=>'center',);
                    $noSpace = array('textBottomSpacing' => -1);
                    
                    // Add header for all other pages
                    $subsequent = $section->addHeader();
                    $tableHeader = $header->addTable();
                    $tableHeader->addRow(-0.5, array('exactHeight' => -5));
                    $tableHeader->addCell(1800,$styleCell)->addImage('images/inspection/TIC-LOGO-WORD.png',array('width' => 70, 'height' => 70, 'align' => 'center'));
                    $tableHeader->addCell(1800,$TitlestyleCell)->addText('Detail Inspection Report',$TfontStyle);
                    $tableHeader->addCell(1800,$styleCell)->addText('Client: '.$inspection_report_data->client_name,$TfontStyle);
                    $tableHeader->addCell(1800,$TitlestyleCell)->addText('Report Date: '.$inspection_report_data->report_date,$fontStyle);
                    $tableHeader->addCell(1500,$styleCell)->addText('Inspection Result: '.$inspection_report_data->result,$TfontStyle);
                    //SPACE OF TABLE - INVISBLE CELL 
                    $tableHeader->addRow(-0.5, array('exactHeight' => -5));
                    $tableHeader->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,))->addText('');
            
                    
                    // Add footer
                    $footer = $section->addFooter();
                    $footer->addPreserveText('Page {PAGE} of {NUMPAGES}',null,array('align' => 'center'));
            
                    // WORD FILE DESIGN AND DATA'S
                    $tableStyle = array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0  );
                    $BgStyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black' );
                    $styleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black' );
                    $TitlestyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','bgColor'=>'#d3d9de');
                    
                    $widthstyleCell = array('borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black', 'width'=>'100%' );
                    //HEADER OF TABLE STYLE
                    $HstyleCell = array('borderTopSize'=>.5 ,'borderTopColor' =>'black','borderLeftSize'=>.5,'borderLeftColor' =>'black','borderBottomSize' =>.5,'borderBottomColor'=>'black', 'bgColor'=>'#ffa500' );
                    $HMergestyleCell = array('borderTopSize'=>.5 ,'borderTopColor' =>'black','borderBottomSize' =>.5,'borderBottomColor'=>'black', 'bgColor'=>'#ffa500' );
                    $HMergeLeftstyleCell = array('borderTopSize'=>.5 ,'borderTopColor' =>'black','borderRightSize'=>.5,'borderRightColor'=>'black','borderBottomSize' =>.5,'borderBottomColor'=>'black', 'bgColor'=>'#ffa500' );
            
                    //FONT STYLE
                    $fontStyle = array('italic'=> false, 'size'=>12, 'name'=>'Arial','afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0 );
                    $TfontStyle = array('bold'=>true, 'italic'=> false, 'size'=>12, 'name' => 'Arial', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);
                    $HfontStyle = array('bold'=>true, 'italic'=> false, 'size'=>12, 'name' => 'Arial', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);
                    $cfontStyle = array('allCaps'=>true,'italic'=> false, 'size'=>12, 'name' => 'Times New Roman','afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0);
                    $noSpace = array('textBottomSpacing' => -1);
            
            
                    //GENERAL INFORMATION TABLE
                    $table = $section->addTable('generalInfoTable',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0,'alignment' =>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER,'layout'=> \PhpOffice\PhpWord\Style\Table::LAYOUT_FIXED,  ));
                    $table2 = $section->addTable('generalInfoTable');
                    //HEADER OF TABLE
                    $table->addRow(-0.5, array('exactHeight' => -5));
                    $table->addCell(4000,array('gridSpan' => 4,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#ffa500'),$HstyleCell)->addText('1.General Information',$HfontStyle);
                    $table->addCell(4200,$HMergestyleCell);
                    $table->addCell(2500,$HMergestyleCell);
                    $table->addCell(3000,$HMergestyleCell);
                    $table->addCell(2800,$HMergeLeftstyleCell);
                    //CELLS OF TABLE
                    $table->addRow(-0.5, array('exactHeight' => -5));
                    $table->addCell(2000,$TitlestyleCell)->addText('Inspection Date',$TfontStyle);
                    $table->addCell(4000,$styleCell)->addText($inspection_report_data->inspection_date,$fontStyle);
                    $table->addCell(2000,$TitlestyleCell)->addText('Service',$TfontStyle);
                    $table->addCell(4000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,),$styleCell)->addText($inspection_report_data->service,$fontStyle);
            
                    $table->addRow(-0.5, array('exactHeight' => -5));
                    $table->addCell(2000,$TitlestyleCell)->addText('Client',$TfontStyle);
                    $table->addCell(4000,$styleCell)->addText($inspection_report_data->client_name,$fontStyle);
                    $table->addCell(2000,$TitlestyleCell)->addText('Contact',$TfontStyle);
                    $table->addCell(4000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,),$styleCell)->addText($inspection_report_data->client_contact_name,$fontStyle);
            
                    $table->addRow(-0.5, array('exactHeight' => -5));
                    $table->addCell(2000,$TitlestyleCell)->addText('Factory',$TfontStyle);
                    $table->addCell(4000,$styleCell)->addText($inspection_report_data->factory_name,$fontStyle);
                    $table->addCell(2000,$TitlestyleCell)->addText('Contact',$TfontStyle);
                    $table->addCell(4000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,),$styleCell)->addText($inspection_report_data->factory_contact_name,$fontStyle);
            
                    $table->addRow(-0.5, array('exactHeight' => -5));
                    $table->addCell(2000,$TitlestyleCell)->addText('Address',$TfontStyle);
                    $table->addCell(4000,array('gridSpan' => 7,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,),$styleCell)->addText($inspection_report_data->factory_address,$fontStyle);
            
                    
                    $table->addRow(-0.5, array('exactHeight' => -5));
                    $table->addCell(2000,array('gridSpan' => 8,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5,'bgColor'=>'#d3d9de','align' => 'center', ))->addText('General Information Photos Of Products',$TfontStyle);
            
                    
                    
                    $table->addRow();
                    $counter = 0;
                    if($inspectionPhotosCount > 0){
                        foreach($inspectionPhotos as $inspectionPhoto){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table->addRow();
                            }
                            if($counter < 3){
                                $table->addCell(5000,array('gridSpan' => 4,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhoto->photo_path,array('width' => 250, 'height' => 200, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                            $counter++; 
                            }
                        }
                    }else{
                        $table->addCell(2000,array('borderLeftColor'=>'black','borderLeftSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#d3d9de',),$TitlestyleCell)->addText('',$TfontStyle);
                        $table->addCell(4000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('No Image Available',$TfontStyle);
                    }
            
                    
                    //SPACE OF TABLE - INVISBLE CELL
                    $table->addRow(-0.5, array('exactHeight' => -5));
                    $table->addCell(12000,array('gridSpan' => 10,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
            
            
                    // NEW FORM, NEW NEW NEW NEW //
                    // // PART #1 NEW ON THE FORM
                    $table4 = $section->addTable('samplePhotos',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0,'alignment'));
                    $table5 = $section->addTable('samplePhotos');
					$ctr=0;
					foreach ($product as $summary_result_data) {
						$ctr++;
						
						
						 $inspectionPhotosSamplePhotos = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','sample_photos'.$ctr)
                                                        ->get();
                    $inspectionPhotosSamplePhotosCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','sample_photos'.$ctr)
                                                        ->count();
            
                    $inspectionPhotosPackingPhotos = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','packing_photos'.$ctr)
                                                        ->get();
                    $inspectionPhotosPackingPhotosCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','packing_photos'.$ctr)
                                                        ->count();
            
                    $inspectionPhotosProductLabelPhotos = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','product_label_photos'.$ctr)
                                                        ->get();
                    $inspectionPhotosProductLabelPhotosCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','product_label_photos'.$ctr)
                                                        ->count();
                    $inspectionPhotosDateCodeLabelPhotos = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','date_code_label_photos'.$ctr)
                                                        ->get();
                    $inspectionPhotosDateCodeLabelPhotosCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','date_code_label_photos'.$ctr)
                                                        ->count();
                    $inspectionPhotosCartonBoxPhotos = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','carton_box_photos'.$ctr)
                                                        ->get();
                    $inspectionPhotosCartonBoxPhotosCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','carton_box_photos'.$ctr)
                                                        ->count();
                    $inspectionPhotosCartonLabelPhotos = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','carton_label_photos'.$ctr)
                                                        ->get();
						  $inspectionPhotosCartonLabelPhotosCount = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description','carton_label_photos'.$ctr)
                                                        ->count();
						
                    if($summary_result_data->pst_code1 === 'N/A'){
                        
                    }else{
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,array('gridSpan' => 11,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#ffa500'),$HstyleCell)->addText('3.)Inspection Of Product Report #'.$ctr,$HfontStyle);
                        $table4->addCell(3900,$HMergestyleCell);
                        $table4->addCell(100,$HMergestyleCell);
                        $table4->addCell(2000,$HMergestyleCell);
                        $table4->addCell(2000,$HMergeLeftstyleCell);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('PST Code',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($summary_result_data->pst_code1,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('Main Part Qty.',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($summary_result_data->main_part_qty1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('Part Number',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($summary_result_data->part_number1,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('Manufacture Code',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($summary_result_data->manufacture_code1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('Description',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($summary_result_data->description1,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('BOM Qty.',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($summary_result_data->bom_qty1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('Quantity(pcs)',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($summary_result_data->qty_pcs1,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('AQL Qty Unit',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($summary_result_data->aql_qty_unit1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('AQL Major',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($summary_result_data->product_aql_major1,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('AQL Major Max Allowed',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($summary_result_data->product_max_allowed_major1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('AQL Minor',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($summary_result_data->product_aql_minor1,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('AQL Minor Max Allowed',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($summary_result_data->product_max_allowed_minor1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('AQL Normal Level',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($summary_result_data->aql_special_level1,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('AQL Special Level',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($summary_result_data->aql_normal_level1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('Samples',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($summary_result_data->samples_unit1,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('Carton Size(LxWxH)',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($summary_result_data->carton_size_weight1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('Carton Weight',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($summary_result_data->carton_weight1,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('Total Packaging',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($summary_result_data->total_packaging1,$fontStyle);
                        
            
                        //SPACE OF TABLE - INVISBLE CELL
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
                    
            
                        //INSPECTION SUMMARY RESULT 
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,array('gridSpan' => 12,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#ffa500'),$HstyleCell)->addText('Inspection Summary Result',$HfontStyle);
                        $table4->addCell(3900,$HMergestyleCell);
                        $table4->addCell(100,$HMergestyleCell);
                        $table4->addCell(2000,$HMergeLeftstyleCell);
            
                        //SUBHEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Overall Checking',$TfontStyle);
                        //CELLS OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Inspection Item',$TfontStyle);
                        $table4->addCell(3000,$TitlestyleCell)->addText('Result',$TfontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Remarks',$TfontStyle);
            
                        
                            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Shipping Qty.',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->shipt_qty1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_shipt_qty1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Lab Certification',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->ce_report1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_ce_report1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Color / Logo / Style',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->color_logo_style1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_color_logo_style1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Marking / Type Label',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->marking1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_marking1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Product Specification / Function',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->prouct_spect_function1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_prouct_spect_function1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Visual Checking',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->visual_checking1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_visual_checking1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Product Packing',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->product_packing1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_product_packing1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Shipping Mark',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->ship_mark1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_ship_mark1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Export Carton',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->export_carton1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_export_carton1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Measurement Data',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->measurement_data1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_measurement_data1,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,$TitlestyleCell)->addText('Comparable With Sample',$TfontStyle);
                        $table4->addCell(3000,$styleCell)->addText($summary_result_data->comparable_with_sample1,$fontStyle);
                        $table4->addCell(3000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5),$styleCell)->addText($summary_result_data->remarks_comparable_with_sample1,$fontStyle);
                    }
            
            
                    //SPACE OF TABLE - INVISBLE CELL START OF INSPECTION OF PRODUCT REPORT #1
                    $table4->addRow(-0.5, array('exactHeight' => -5));
                    $table4->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
            
                    if($inspectionPhotosSamplePhotosCount > 0){
                        //EXPORT CARTON PHOTOS
                        
                        //HEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,array('gridSpan' => 11,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#ffa500'),$HstyleCell)->addText('Product Details #1',$HfontStyle);
                        $table4->addCell(3900,$HMergestyleCell);
                        $table4->addCell(100,$HMergestyleCell);
                        $table4->addCell(2000,$HMergestyleCell);
                        $table4->addCell(2000,$HMergeLeftstyleCell);
            
                        //SUBHEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Sample Photos',$TfontStyle);
            
                        $table4->addRow();
                        $counter = 0;
                        foreach($inspectionPhotosSamplePhotos as $inspectionPhotosSamplePhoto){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table4->addRow();
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosSamplePhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table4->addCell(6000,array('gridSpan' =>10,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosSamplePhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosSamplePhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else{
                                
                            }
                        }
                    }
            
                    if($inspectionPhotosPackingPhotosCount > 0){
            
                        //SUBHEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Packing Photos',$TfontStyle);
            
                        $table4->addRow();
                        $counter = 0;
                        foreach($inspectionPhotosPackingPhotos as $inspectionPhotosPackingPhoto){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table4->addRow();
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosPackingPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table4->addCell(6000,array('gridSpan' =>10,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosPackingPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosPackingPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else{
                                
                            }
                        }
                    }
            
                    if($inspectionPhotosProductLabelPhotosCount > 0){
            
                        //SUBHEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Product Label Photos',$TfontStyle);
            
                        $table4->addRow();
                        $counter = 0;
                        foreach($inspectionPhotosProductLabelPhotos as $inspectionPhotosProductLabelPhoto){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table4->addRow();
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosProductLabelPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table4->addCell(6000,array('gridSpan' =>10,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosProductLabelPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosProductLabelPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else{
                                
                            }
                        }
                    }
            
                    if($inspectionPhotosDateCodeLabelPhotosCount > 0){
            
                        //SUBHEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Date Code Label photos',$TfontStyle);
            
                        $table4->addRow();
                        $counter = 0;
                        foreach($inspectionPhotosDateCodeLabelPhotos as $inspectionPhotosDateCodeLabelPhoto){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table4->addRow();
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosDateCodeLabelPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table4->addCell(6000,array('gridSpan' =>10,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosDateCodeLabelPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosDateCodeLabelPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else{
                                
                            }
                        }
                    }
            
                    if($inspectionPhotosCartonBoxPhotosCount > 0){
            
                        //SUBHEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Carton Box Photos',$TfontStyle);
            
                        $table4->addRow();
                        $counter = 0;
                        foreach($inspectionPhotosCartonBoxPhotos as $inspectionPhotosCartonBoxPhoto){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table4->addRow();
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosCartonBoxPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table4->addCell(6000,array('gridSpan' =>10,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosCartonBoxPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosCartonBoxPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else{
                                
                            }
                        }
                    }
            
                    
            
                    if($inspectionPhotosCartonLabelPhotosCount > 0){
            
                        //SUBHEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Carton Label Photos',$TfontStyle);
            
                        $table4->addRow();
                        $counter = 0;
                        foreach($inspectionPhotosCartonLabelPhotos as $inspectionPhotosCartonLabelPhoto){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table4->addRow();
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosCartonLabelPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table4->addCell(6000,array('gridSpan' =>10,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosCartonLabelPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosCartonLabelPhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else{
                                
                            }
                        }
                    }
             $reports_defects_failures1 = ReportsDefectsFailure::where('report_id',$inspection_report_data->report_id)
                                                ->where('inspection_id',$inspection_report_data->inspection_id)
                                                ->where('inspector_id',$inspection_report_data->inspector_id)
												  ->where('defects_category2_part2',$summary_result_data->id)
												    ->where('defects_category3_part2','defects')
                                                ->where('defects_part_number','1')
                                                ->get();
                  if(count($reports_defects_failures1)>0){
					  $ctrs=0;
						 foreach($reports_defects_failures1 as $inspectionPhotosDefectFailurelist){						
                    if($summary_result_data->number_of_defects1 != 'N/A'){
						$ctrs++;
						
						$countrr=$ctr.'defect_failure_photos'.$ctrs;
                        //DEFECTS / FAILURE
                        //HEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,array('gridSpan' => 11,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#ffa500'),$HstyleCell)->addText('Defects And Failures',$HfontStyle);
                        $table4->addCell(3900,$HMergestyleCell);
                        $table4->addCell(100,$HMergestyleCell);
                        $table4->addCell(2000,$HMergestyleCell);
                        $table4->addCell(2000,$HMergeLeftstyleCell);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('Defects Category:',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($inspectionPhotosDefectFailurelist->defects_category1_part2,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('Number Of Defects:',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($inspectionPhotosDefectFailurelist->number_of_defects1_part2,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('Defects Description',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 14,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($inspectionPhotosDefectFailurelist->defect_details1_part2,$fontStyle);
                       //  $table4->addRow(-0.5, array('exactHeight' => -5));
              $table4->addRow(-0.5, array('exactHeight' => -5));
                    $table4->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
                    $inspectionPhotosDefectFailurePhotos = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description',$countrr)
                                                        ->get();
														
                      //  $table4->addRow();
						 if(count($inspectionPhotosDefectFailurePhotos)>0){
  $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Defect Failure Photoes',$TfontStyle);
            
                        $table4->addRow();
                        $counter = 0;
                        
                            foreach($inspectionPhotosDefectFailurePhotos as $inspectionPhotosDefectFailurePhoto){
                            $dir="images/inspection/".$id."/";
                                if($counter === 2){
                                $counter = 0;
                                $table4->addRow();
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosDefectFailurePhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table4->addCell(6000,array('gridSpan' =>10,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosDefectFailurePhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table4->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosDefectFailurePhoto->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else{
                                
                            }
                            }
                        }
						 $table4->addRow(-0.5, array('exactHeight' => -5));
                    $table4->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
                   
					//	$table4->addRow();
						//  $table4->addRow(-0.5, array('exactHeight' => -5));
                    }
					}
					}
                 
                    $reports_defects_failures1s = ReportsDefectsFailure::where('report_id',$inspection_report_data->report_id)
                                                ->where('inspection_id',$inspection_report_data->inspection_id)
                                                ->where('inspector_id',$inspection_report_data->inspector_id)
												  ->where('defects_category2_part2',$summary_result_data->id)
												   ->where('defects_category3_part2','functional')
                                                ->where('defects_part_number','1')
                                                ->get();
                  if(count($reports_defects_failures1s)>0){
					    $ctrsp=0;
						 foreach($reports_defects_failures1s as $inspectionPhotosDefectsFailurelist){	
                   $ctrsp++;
						
						$countrrp=$ctr.'function_checking_test_photos'.$ctrsp;
                        //DEFECTS / FAILURE
                        //HEADER OF TABLE
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(6000,array('gridSpan' => 11,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#ffa500'),$HstyleCell)->addText('Function Test',$HfontStyle);
                        $table4->addCell(3900,$HMergestyleCell);
                        $table4->addCell(100,$HMergestyleCell);
                        $table4->addCell(2000,$HMergestyleCell);
                        $table4->addCell(2000,$HMergeLeftstyleCell);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('Function Test:',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($inspectionPhotosDefectsFailurelist->defects_category1_part2,$fontStyle);
                        $table4->addCell(2000,$TitlestyleCell)->addText('Unit:',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($inspectionPhotosDefectsFailurelist->defect_details1_part2,$fontStyle);
            
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(2000,$TitlestyleCell)->addText('Sampling Size:',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 8,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($inspectionPhotosDefectsFailurelist->number_of_defects1_part2,$fontStyle);
                        // NEED TO CHANGE TO SAMPLING SIZE ON VARIABLE
                        $table4->addCell(2000,$TitlestyleCell)->addText('Result:',$TfontStyle);
                        $table4->addCell(2000,array('gridSpan' => 5,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5),$styleCell)->addText($inspectionPhotosDefectsFailurelist->defects_category4_part2,$fontStyle);
                        
              $table4->addRow(-0.5, array('exactHeight' => -5));
                    $table4->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
                    $inspectionPhotosFunctionChecks = InspectionPhotos::where('report_no', $id)
                                                        ->where('photo_description',$countrrp)
                                                        ->get(); 
                     //   $table4->addRow();
                        $table4->addRow(-0.5, array('exactHeight' => -5));
                        $table4->addCell(12000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('Function Checking Photoes',$TfontStyle);
            
                        $table4->addRow();
                        $counter = 0;
                        
                            foreach($inspectionPhotosFunctionChecks as $inspectionPhotosFunctionCheck){
								
                                $dir="images/inspection/".$id."/";
                                    if($counter === 2){
                                        $counter = 0;
                                        $table4->addRow();
                                        $table4->addCell(6000,array('gridSpan' => 3,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosFunctionCheck->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                        $counter++; 
                                    }else if($counter === 1){
                                        $table4->addCell(6000,array('gridSpan' =>12,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosFunctionCheck->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                        $counter++; 
                                    }else if($counter === 0){
                                        $table4->addCell(6000,array('gridSpan' => 3,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosFunctionCheck->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                        $counter++; 
                                    }else{
                                        
                                    }
                                }
								 $table4->addRow(-0.5, array('exactHeight' => -5));
                    $table4->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
                   
                            }
						 
				  }						 
                        
                
                  
				}
            
			//INVISIBLE CELL
                    $table4->addRow(-0.5, array('exactHeight' => -5));
                    $table4->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
                    //REMARKS AND ADDITIONAL INFORMATION
                    $table6 = $section->addTable('remarksAddInfo',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0,'alignment'));
                    $table7 = $section->addTable('remarksAddInfo');
                    //HEADER OF TABLE
                    $table6->addRow(-0.5, array('exactHeight' => -5));
                    $table6->addCell(6000,array('gridSpan' => 11,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#ffa500'),$HstyleCell)->addText('4. Remarks and Additional Information',$HfontStyle);
                    $table6->addCell(3900,$HMergestyleCell);
                    $table6->addCell(100,$HMergestyleCell);
                    $table6->addCell(2000,$HMergestyleCell);
                    $table6->addCell(2000,$HMergeLeftstyleCell);
            
                    $table6->addRow(-0.5, array('exactHeight' => -5));
                    $table6->addCell(1000,$TitlestyleCell)->addText('Remarks',$TfontStyle);
                    $table6->addCell(1000,array('gridSpan' => 14,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,),$styleCell)->addText($inspection_report_data->remarks_details,$fontStyle);
            
            
                    $table6->addRow();
                    $counter = 0;
                    if($inspectionPhotosRemarksCount > 0){
                    foreach($inspectionPhotosRemarks as $inspectionPhotosRemark){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table6->addRow();
                                $table6->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosRemark->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table6->addCell(6000,array('gridSpan' =>10,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosRemark->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table6->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosRemark->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }
                        }
                    }else{
                        $table6->addCell(2000,array('borderLeftColor'=>'black','borderLeftSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#d3d9de',),$TitlestyleCell)->addText('',$TfontStyle);
                        $table6->addCell(4000,array('gridSpan' => 15,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('No Image Available',$TfontStyle);
                    }
                    
            
            
            
            
                    // AB AND OR PHOTOS
                    $table18 = $section->addTable('ABandOR',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0,'alignment'));
                    $table19 = $section->addTable('ABandOR');
                    //SPACE OF TABLE - INVISBLE CELL
                    $table18->addRow(-0.5, array('exactHeight' => -5));
                    $table18->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
                    //HEADER OF TABLE
                    $table18->addRow(-0.5, array('exactHeight' => -5));
                    $table18->addCell(5500,array('gridSpan' => 9,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#ffa500'),$HstyleCell)->addText('5).Anti Bribery And Onsite Report Photos',$HfontStyle);
                    $table18->addCell(4400,$HMergestyleCell);
                    $table18->addCell(2200,$HMergestyleCell);
                    $table18->addCell(2000,$HMergestyleCell);
                    $table18->addCell(800,$HMergeLeftstyleCell);
            
                    //SUBHEADER OF TABLE
                    $table18->addRow(-0.5, array('exactHeight' => -5));
                    $table18->addCell(12000,array('gridSpan' => 13,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('A.)Anti Bribery Photos',$TfontStyle);
            
                    $table18->addRow();
                    $counter = 0;
                    if($inspectionPhotosBriberyCount > 0){
                    foreach($inspectionPhotosBribery as $inspectionPhotosBriberys){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table18->addRow();
                                $table18->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosBriberys->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table18->addCell(6000,array('gridSpan' =>8,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosBriberys->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table18->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosBriberys->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }
                        }
                    }else{
                        $table18->addCell(2000,array('borderLeftColor'=>'black','borderLeftSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#d3d9de',),$TitlestyleCell)->addText('',$TfontStyle);
                        $table18->addCell(4000,array('gridSpan' => 12,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('No Image Available',$TfontStyle);
                    }
            
                    //SUBHEADER OF TABLE
                    $table18->addRow(-0.5, array('exactHeight' => -5));
                    $table18->addCell(12000,array('gridSpan' => 13,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderLeftColor'=>'black','borderLeftSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('B.)Onsite Report Photos',$TfontStyle);
            
                    $table18->addRow();
                    $counter = 0;
                    if($inspectionPhotosOnsiteCount > 0){
                    foreach($inspectionPhotosOnsite as $inspectionPhotosOnsit){
                        $dir="images/inspection/".$id."/";
                            if($counter === 2){
                                $counter = 0;
                                $table18->addRow();
                                $table18->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosOnsit->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 1){
                                $table18->addCell(6000,array('gridSpan' =>8,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosOnsit->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }else if($counter === 0){
                                $table18->addCell(6000,array('gridSpan' => 5,'borderTopSize'=>1 ,'borderTopColor' =>'black','borderLeftSize'=>1,'borderLeftColor' =>'black','borderRightSize'=>1,'borderRightColor'=>'black','borderBottomSize' =>1,'borderBottomColor'=>'black','marginLeft' => 0.5,'marginTop' => 1,'marginBottom' => 0.5,'marginRight' => 0.5, ))->addImage($dir.$inspectionPhotosOnsit->photo_path,array('width' => 250, 'height' => 180, 'align' => 'center','marginLeft' => 0.5,'marginTop' => -1,'marginBottom' => 0.5,'marginRight' => 0.5,));
                                $counter++; 
                            }
                        }
                    }else{
                        $table18->addCell(2000,array('borderLeftColor'=>'black','borderLeftSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#d3d9de',),$TitlestyleCell)->addText('',$TfontStyle);
                        $table18->addCell(4000,array('gridSpan' => 12,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'bgColor'=>'#d3d9de'),$TitlestyleCell)->addText('No Image Available',$TfontStyle);
                    }
                    
                    //SPACE OF TABLE - INVISBLE CELL
                    $table18->addRow(-0.5, array('exactHeight' => -5));
                    $table18->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
            
                    // ADDITIONAL INFORMATION
                    $table20 = $section->addTable('ABandOR',array('borderSize' => 1, 'borderColor' => '999999', 'afterSpacing' => 0, 'Spacing'=> 0, 'cellMargin'=>0,'alignment'));
                    $table21 = $section->addTable('ABandOR');
                    //HEADER OF TABLE
                    $table20->addRow(-0.5, array('exactHeight' => -5));
                    $table20->addCell(6000,array('gridSpan' => 11,'borderLeftColor'=>'black','borderLeftSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'bgColor'=>'#ffa500'),$HstyleCell)->addText('6).Additional Information',$HfontStyle);
                    $table20->addCell(2000,$HMergestyleCell);
                    $table20->addCell(2000,$HMergestyleCell);
                    $table20->addCell(2000,$HMergestyleCell);
                    $table20->addCell(2000,$HMergeLeftstyleCell);
            
                    $table20->addRow(-0.5, array('exactHeight' => -5));
                    $table20->addCell(2000,$TitlestyleCell)->addText('Client',$TfontStyle);
                    $table20->addCell(4000,$styleCell)->addText($inspection_report_data->client_name,$fontStyle);
                    $table20->addCell(2000,$TitlestyleCell)->addText('Inspection Result:',$TfontStyle);
                    $table20->addCell(2000,array('gridSpan' => 12,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,),$styleCell)->addText($inspection_report_data->result,$fontStyle);
            
                    $table20->addRow(-0.5, array('exactHeight' => -5));
                    $table20->addCell(2000,$TitlestyleCell)->addText('Report Date:',$TfontStyle);
                    $table20->addCell(4000,$styleCell)->addText($inspection_report_data->report_date,$fontStyle);
                    $table20->addCell(2000,$TitlestyleCell)->addText('Report Number:',$TfontStyle);
                    $table20->addCell(2000,array('gridSpan' => 12,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,),$styleCell)->addText($inspection_report_data->report_no,$fontStyle);
            
                    $table20->addRow(-0.5, array('exactHeight' => -5));
                    $table20->addCell(2000,$TitlestyleCell)->addText('Inspected By:',$TfontStyle);
                    $table20->addCell(4000,$styleCell)->addText($inspection_report_data->inspected_by,$fontStyle);
                    $table20->addCell(2000,$TitlestyleCell)->addText('Confirm By QC/Manager:',$TfontStyle);
                    $table20->addCell(2000,array('gridSpan' => 12,'borderRightColor'=>'black','borderRightSize'=>.5,'borderBottomColor'=>'black','borderBottomSize'=>.5,'borderTopColor'=>'black','borderTopSize'=>.5,),$styleCell)->addText($inspection_report_data->confirm_by,$fontStyle);
            
                    //SPACE OF TABLE - INVISBLE CELL
                    $table20->addRow(-0.5, array('exactHeight' => -5));
                    $table20->addCell(12000,array('gridSpan' => 5,'borderRightColor'=>'white','borderRightSize'=>0,'borderBottomColor'=>'white','borderBottomSize'=>0,'borderLeftColor'=>'white','borderLeftSize'=>0,),$TitlestyleCell)->addText('',$TfontStyle);
            
            
            
                    $section->addTextBreak(-1);
                    
			
                    //OUTPUT OF WORD FILE
                    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    try {
                        $objWriter->save(storage_path('OnlineReport-'.$inspection_report_data->report_no.'.docx'));
                    } catch (Exception $e) {
                        $objWriter->save(storage_path('OnlineReport-'.$inspection_report_data->report_no.'.docx'));
                    }
                    return response()->download(storage_path('OnlineReport-'.$inspection_report_data->report_no.'.docx'));
            
                    // // Saving the document as ODF file...
                    // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
                    // $objWriter->save('helloWorld.odt');
            
                    // // Saving the document as HTML file...
                    // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
                    // $objWriter->save('helloWorld.html');
            
                    /* Note: we skip RTF, because it's not XML-based and requires a different example. */
                    /* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */
                }
				



    public function inspectorFileImageCreate(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $imageName=str_replace("#","_",$imageName);      
        $dir="images/inspection/".$request['report_id']."/";
       // $image->move(public_path($dir),$imageName);
		 $image->move($dir,$imageName);
        if (!File::exists($dir)) {
            File::makeDirectory($dir);
        }
        $imageUpload = new InspectionPhotos();
        $imageUpload->report_no = $request['report_id'];
        $imageUpload->photo_description = $request['photo_description'];
        $imageUpload->photo_path = $imageName;
        $imageUpload->save();
        return response()->json(['success'=>$imageName]);
    }

    public function inspectorFileImageDelete(Request $request)
    {
        $filename =  $request->get('filename');
        $photo_id = InspectionPhotos::where('photo_path',$filename)
                                    ->where('report_no',$request['report_id'])->first();
        $path=public_path()."/images/inspection/".$request['report_id'].'/'.$filename;
        if (file_exists($path)) {
            unlink($path);
            $cond=['report_no'=>$request['report_id'],'photo_path'=>$filename];
            $del_att=DB::table('inspection_photos')->where($cond)->delete();
        }
        return $filename;  
    }

}
