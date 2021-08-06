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


class PostInspectionPSIController extends Controller
{

    private $service = [
        'iqi' => 'Incoming Quality Inspection',
        'dupro' => 'During Production Inspection',
        'psi' => 'Pre Shipment Inspection',
        'cli' => 'Container Loading Inspection',
        'pls' => 'Setting up Production Lines',
        'st' => 'Sample Test',
        'cbpi' => 'CBPI - No Serial',
        'cbpi_serial' => 'CBPI - with Serial',
        'cbpi_isce' => 'CBPI - ISCE',
        'site_visit' => 'Site Visit',
        'SPK' => 'SPK',
        'FRI' => 'FRI',
        'physical' => 'Factory Audit',
        'detail' => 'Detail Audit',
        'social' => 'Social Audit'
    ];

    public function getInspectionProjectForm(){
        $role = User::where('id',Auth::id())->first();
        //$clients = Client::all(); old 3/4/2019
        $clients = Client::orderBy('client_name', 'asc')->get();
        $countries = Country::all();
        $factories = Factory::where('factory_status','!=',2)->where('client_code',null)->orderBy('factory_name', 'asc')->get();
        $suppliers = Supplier::select('id','supplier_name')->where('supplier_status','!=',2)->where('client_code',null)->orWhere('client_code','')->orderBy('supplier_name', 'asc')->get();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $inspectors = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->pluck('name','user_id');

        $inspectors_two = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->get();

        $inspectors_new = DB::table('users')
                        ->join('user_infos','user_infos.user_id','=','users.id')
                        ->orderBy('user_infos.name','asc')
                        ->pluck('user_infos.name','users.id');

        //jesser
        $path_blank_report = "images/blankreport/";
        $files_blank_report = scandir($path_blank_report);
        $blank_report_dir=array();
        $currency = [
            'usd' => '($) Us Dollar',
            'eur' => '(€) Euro',
            'gbp' => '(£) British Pound',
            'inr' => '(₹) Indian Rupee',
            'myr' => '(RM) Malaysian Ringgit',
            'cny' => '(¥) Chinese Yuan Renminbi'
        ];
        $products = Product::orderBy('product_name', 'asc')->get();
        $templates = Template::select('id','name')->where('identifier', 1)
        ->orderBy('created_at','desc')
        ->get();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $templates_chinese = Template::select('id','name')
        ->orderBy('created_at','desc')
        ->get();
        //$new_client_count = Client::where('client_code','000')->count();
		$new_client_count = DB::table('clients')
            ->join('users','users.client_code','=','clients.client_code')
            ->select('clients.client_code','users.status')
			->where('clients.client_code',['000'])
			->where('users.status','2')
			->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();
        return view('pages.admin.development.index',compact('clients','role','user_info','inspectors','factories','countries','products','templates','templates_chinese','inspectors_new','files_blank_report','inspectors_two','currency','new_client_count','new_post_client','new_post_client_sera','suppliers'));
    }

    //save and publish draft
    public function postInspectionDataFromDraft(Request $request){
        DB::beginTransaction();
        try {
            //$inspection = new Inspection();
            $old_inspection_details=Inspection::find($request['edit_inspection_id']);
            $inspection = Inspection::find($request['edit_inspection_id']);
            //inspection details
            $inspection->client_id = $request['client'];
            $inspection->contact_person = $request['contact_person'];
            //supplier details
            $inspection->supplier = $request['supplier'];
            $inspection->supplier_contact_person = $request['supplier_contact_person'];
            //factory details
            $inspection->factory = $request['factory'];
            $inspection->factory_contact_person = $request['factory_contact_person'];

            $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

            //inspection details
            $inspection->inspector_id = $request['inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->old_inspector_id = $request['old_inspector'];
            $inspection->manday = $request['manday'];
            $inspection->inspection_date = $request['inspection_date'];
            $inspection->inspection_date_to = $request['inspection_date_to'];
            $inspection->service = $request['service'];
            $inspection->reference_number = $request['reference_number'];
            $inspection->client_project_number = $request['client_project_number'];

            $inspection->percentageFriSpk = $request['percentageSpkFri'];

            $inspection->requirement = $request['requirement'];
            $inspection->memo = $request['memo'];
            $template=$request['template'];
            if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}

            $report_template=$request['report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}

            $inspection->word_template = null;
            $inspection->template_id = $template;
            $inspection->project_type = $request['type_of_project'];


            $inspection->inspection_status = "Released";
            $inspection->created_by =  Auth::id();


            

            if ($inspection->save()) {

                $clientCost = ClientCost::find($request['client_cost_id']);
                $clientCost->currency =  $request['cli_currency'];
                $clientCost->md_charges =  $request['cli_md_charge'];
                $clientCost->travel_cost =  $request['cli_travel_cost'];
                $clientCost->hotel_cost =  $request['cli_hotel_cost'];
                $clientCost->ot_cost =  $request['cli_ot_cost']; 
                $cli_other_cost_text =  $request['cli_other_cost_text']; 
                $cli_other_cost_value =  $request['cli_other_cost_value']; 
                $arr_cli_other_cost_text=null;
                $arr_cli_other_cost_value=null;
                if($cli_other_cost_text==null || $cli_other_cost_text=='null'){
                    
                }else{
                    foreach ($cli_other_cost_text as $i => $value) {
                        //array_push($arr_cli_other_cost_text,$request['cli_other_cost_text'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_text=$request['cli_other_cost_text'][$i];
                        }else{
                            $arr_cli_other_cost_text=$arr_cli_other_cost_text.','.$request['cli_other_cost_text'][$i];
                        }
                    }
                    foreach ($cli_other_cost_value as $i => $value) {
                        //array_push($arr_cli_other_cost_value,$request['cli_other_cost_value'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_value=$request['cli_other_cost_value'][$i];
                        }else{
                            $arr_cli_other_cost_value=$arr_cli_other_cost_value.','.$request['cli_other_cost_value'][$i];
                        }
                    }
                }
                $clientCost->other_cost_text =  $arr_cli_other_cost_text;
                $clientCost->other_cost_value =  $arr_cli_other_cost_value; 
                $clientCost->save();

                $inspectorCost = InspectorCost::find($request['inspector_cost_id']);
                $inspectorCost->currency =  $request['ins_currency'];
                $inspectorCost->md_charges =  $request['ins_md_charge'];
                $inspectorCost->travel_cost =  $request['ins_travel_cost'];
                $inspectorCost->hotel_cost =  $request['ins_hotel_cost'];
                $inspectorCost->ot_cost =  $request['ins_ot_cost']; 
                $ins_other_cost_text =  $request['ins_other_cost_text']; 
                $ins_other_cost_value =  $request['ins_other_cost_value']; 
                $arr_ins_other_cost_text=null;
                $arr_ins_other_cost_value=null;

                if($ins_other_cost_text==null || $ins_other_cost_text=='null'){

                }else{
                    foreach ($ins_other_cost_text as $i => $value) {
                        //array_push($arr_ins_other_cost_text,$request['ins_other_cost_text'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_text=$request['ins_other_cost_text'][$i];
                        }else{
                            $arr_ins_other_cost_text=$arr_ins_other_cost_text.','.$request['ins_other_cost_text'][$i];
                        }

                    }
                    foreach ($ins_other_cost_value as $i => $value) {
                        //array_push($ins_other_cost_value,$request['ins_other_cost_value'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_value=$request['ins_other_cost_value'][$i];
                        }else{
                            $arr_ins_other_cost_value=$arr_ins_other_cost_value.','.$request['ins_other_cost_value'][$i];
                        }
                    }
                }
                $inspectorCost->other_cost_text =  $arr_ins_other_cost_text;
                $inspectorCost->other_cost_value =  $arr_ins_other_cost_value; 
                $inspectorCost->save();
                
                $inserted_inspection_id=$request['edit_inspection_id'];
                $upload_file_name=array();

                $abd_dir = 'email_attachment/ABD_1-5.pdf';
                if(File::exists($abd_dir)){
                    array_push($upload_file_name,$abd_dir); // attach the abd
                }
                
                $oqr_dir = 'email_attachment/TIC_Onsite_Quick_Report.pdf';
                if(File::exists($oqr_dir)){
                    array_push($upload_file_name,$oqr_dir); // attach the abd
                }
                
                $fm_dir = 'email_attachment/File_Manager_User_Manual.pdf';
                if(File::exists($fm_dir)){
                    array_push($upload_file_name,$fm_dir); // attach the abd
                }

                $attachment = Attachment::where('inspection_id',$inserted_inspection_id)->get();
                if(count($attachment)>0){
                    foreach($attachment as $up_file){
                        array_push($upload_file_name,$up_file->path);
                    }
                }
                                
                if($request['hidden_product_id']!=null || $request['hidden_product_id']!=''){
                    $products = $request['product_name'];
                    foreach ($products as $i => $value) {
                        $prods[$i] = PSIProduct::find($request['hidden_product_id'][$i]);
                        $prods[$i]->product_name = $request['product_name'][$i];
                        $prods[$i]->product_category = $request['product_category'][$i];
                        $prods[$i]->brand = $request['brand'][$i];
                        $prods[$i]->po_no = $request['po_number'][$i];
                        $prods[$i]->model_no = $request['model_no'][$i];
                        $prods[$i]->aql_qty = $request['aql_qty'][$i];
                        $prods[$i]->product_unit = $request['p_unit'][$i];
                        $prods[$i]->additional_product_info = $request['prod_addtl_info'][$i];
                        $prods[$i]->save();
                    
                    }
                }
                if($request['is_new_product_added']==0 || $request['is_new_product_added']=='0'){

                }else{
                    $new_product = $request['new_product_name'];
                    foreach ($new_product as $i => $value) {
                        $prods[$i] = new PSIProduct();
                        $prods[$i]->inspection_id = $inserted_inspection_id;
                        $prods[$i]->product_name = $request['new_product_name'][$i];
                        $prods[$i]->product_category = $request['new_product_category'][$i];
                        $prods[$i]->brand = $request['new_brand'][$i];
                        $prods[$i]->po_no = $request['new_po_number'][$i];
                        $prods[$i]->model_no = $request['new_model_no'][$i];
                        $prods[$i]->aql_qty = $request['new_aql_qty'][$i];
                        $prods[$i]->aql_normal_level = $request['new_aql_normal_level'][$i];
                        $prods[$i]->aql_special_level = $request['new_aql_special_level'][$i];
                        $prods[$i]->aql_major = $request['new_aql_major'][$i];
                        $prods[$i]->max_allowed_major = $request['new_max_major'][$i];
                        $prods[$i]->aql_minor = $request['new_aql_minor'][$i];
                        $prods[$i]->max_allowed_minor = $request['new_max_minor'][$i];
                        $prods[$i]->aql_normal_letter = $request['new_aql_normal_letter'][$i];
                        $prods[$i]->aql_normal_sampsize = $request['new_aql_normal_sampsize'][$i];
                        $prods[$i]->aql_special_letter = $request['new_aql_special_letter'][$i];
                        $prods[$i]->aql_special_sampsize = $request['new_aql_special_sampsize'][$i];
                        $prods[$i]->save();
                    }
                }

                foreach ($request->file('file') as $file) {
                    //set a unique file name
                    //$filename = 'psi-'. $inserted_inspection_id . '-' . uniqid().'.'.$file->getClientOriginalExtension();
                    $filename = $file->getClientOriginalName();
                    $filename=str_replace("#","_",$filename);
                    
                    //directory
                    $dir="images/project2/".$inserted_inspection_id."/";
                    
                    //move the files to the correct folder
                    if (!File::exists($dir)) {
                        File::makeDirectory($dir, 0777, true, true);
                    }
                    
                    //push file name in array
                    array_push($upload_file_name,$dir.$filename);
    
                    //save details to db
                    $doc= new Attachment();
                    $doc->inspection_id = $inserted_inspection_id;
                    $doc->project_number = $request['reference_number'];
                    $doc->file_name = $filename;
                    $doc->file_size = $file->getSize();
                    $doc->path = $dir.$filename;
                    $doc->save();
					
					$file->move($dir,$filename);
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                $password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];


                $report_id = Report::where('inspection_id',$inserted_inspection_id)->first();

                $report = Report::find($report_id->id);
                $report->inspection_id = $inspection->id;
                $report->client_code = $client->client_code;
                $report->service = $this->service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->report_no = $report_no;
                $report->password = $password;
                $report->inspector_id=$request['inspector'];
                
                if ($report->save()) {

                    $insp_details = Inspection::where('id',$inserted_inspection_id)->first();
                    $fac_contact2=$insp_details->factory_contact_person2;

                    $inspector_info = UserInfo::find($request['inspector']);
                    $inspector_cred = User::find($request['inspector']);
                    //old inspector details
                    $old_inspector_info = UserInfo::find($request['old_inspector']);
                    $supplier = Supplier::find($request['supplier']);
                    $supplier_contact = SupplierContact::find($request['supplier_contact_person']);
                    $factory = Factory::find($request['factory']);
                    $factory_contact = FctoryContact::find($request['factory_contact_person']);
                    $factory_contact_sec = FctoryContact::find($request['factory_contact_person2_psi']);
                    $psi_product_list = PSIProduct::where('inspection_id',$inserted_inspection_id)->get();
                    $product_list = Product::all();
                    
                    $booking_info = UserInfo::find(Auth::id());
                    
                    $blank_report=array();

                    $product_subject = "";
                    foreach($psi_product_list as $psi_prod){
                        foreach($product_list as $prod){
                            if($prod->id==$psi_prod->product_name){                                  
                                if($product_subject==""){
                                    $product_subject=$prod->product_name ." Qty ". $psi_prod->aql_qty ." pcs ";
                                }else{
                                    $product_subject=$product_subject ." , ". $prod->product_name ." Qty ". $psi_prod->aql_qty ." pcs ";
                                }
                            }
                        }
                    }
                    $fac_contact="";
                    $fac_email="";
                    $fac_num="";
                    $fac_con2="";
                    $fac_email2="";
                    $fac_num2="";

                    if($fac_contact2=="" || $fac_contact2=="N/A" || $fac_contact2=="0" || $fac_contact2==0 || $fac_contact2==null){
                        $fac_contact=$factory_contact->factory_contact_person;
                        $fac_num=$factory_contact->factory_tel_number;
                        $fac_email=$factory_contact->factory_email;
                    }else{                     
                        $fac_sec_ex=explode(',',$fac_contact2);
                        foreach($fac_sec_ex as $key => $fid){
                            $fac_sec = FctoryContact::where('id',$fid)->first();
                            $fac_con2.=$fac_sec->factory_contact_person;    
                            $fac_email2.=$fac_sec->factory_tel_number;
                            $fac_num2.=$fac_sec->factory_email;    
                            if($key!=count($fac_sec_ex)){
                                $fac_con2.=',';
                                $fac_email2.=',';
                                $fac_num2.=',';
                            }
                        }
                        $fac_contact=$factory_contact->factory_contact_person .', '. $fac_con2;
                        $fac_num=$factory_contact->factory_tel_number .', '. $fac_email2;
                        $fac_email=$factory_contact->factory_email .', '. $fac_num2;
                    }

                    if($request['type_of_project']=='word_project' || $request['type_of_project']=="esprit"){                     
                        $data = ['report_number' =>  $request['reference_number'], 
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'old_insp_email' => $old_inspector_info->email_address,
                            'old_insp_name' => $old_inspector_info->name,
                            'manday'=>$request['manday'],
                            'spk_fri'=>$request['percentageSpkFri'],
                            'file_passed'=>$upload_file_name,
                            'service'=>$this->service[$request['service']],
                            'ref_num'=>$request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'supplier_name'=>$supplier->supplier_name,
                            'supplier_address'=>$supplier->supplier_address,
                            'supplier_address_local'=>$supplier->supplier_address_local,
                            'supplier_contact'=>$supplier_contact->supplier_contact_person,
                            'client_number'=>$request['client_project_number'],
                            'requirement'=>$request['requirement'],
                            'psi_product_list'=>$psi_product_list,
                            'product_list'=>$product_list,
                            'memo'=>$request['memo'],
                            'product_subject'=>$product_subject,
                            'book_email'=>$booking_info->email_address,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num];
                        $files_uploaded = $request->file('file');
                        Mail::send('email.manual_download',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");
                            foreach ($data['file_passed'] as $file_name) {
                                if($file_name=='email_attachment/ABD_1-5.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                                    $message->attach($file_name);
                                }
                            }                 
                        });
                        if($request['old_inspector']==$request['inspector'] || $request['old_inspector']=='' || $request['old_inspector']==null){

                        }else{
                            if($old_inspection_details->inspection_status=='Released'){
                                Mail::send('email.cancel_inspector',$data, function($message) use ($data){
                                    $message->to($data['old_insp_email']);
                                    $message->cc('it-support@t-i-c.asia');
                                    $message->cc($data['book_email']);
                                    $message->cc('gregor@t-i-c.asia');
                                    $message->cc('report@t-i-c.asia');
                                    $message->cc('booking@t-i-c.asia');
                                    $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                                    $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .") - Cancelled Inspection");             
                                });
                            }
                        }
                        
                    }else{
                        $data = ['report_number' =>  $request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'old_insp_email' => $old_inspector_info->email_address,
                            'old_insp_name' => $old_inspector_info->name,
                            'service'=>$this->service[$request['service']],
                            'ref_num'=>$request['reference_number'],
                            'file_passed'=>$upload_file_name,
                            'requirement'=>$request['requirement'],
                            'psi_product_list'=>$psi_product_list,
                            'product_list'=>$product_list,
                            'memo'=>$request['memo'],
                            'client_number'=>$request['client_project_number'],
                            'product_subject'=>$product_subject,
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'supplier_name'=>$supplier->supplier_name,
                            'supplier_address'=>$supplier->supplier_address,
                            'supplier_address_local'=>$supplier->supplier_address_local,
                            'supplier_contact'=>$supplier_contact->supplier_contact_person,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num,
                            'book_email'=>$booking_info->email_address];
                        $files_uploaded = $request->file('file');
                        Mail::send('email.download',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            $message->subject('Download Blank Report for ' . $data['report_number']);
                            /* $message->attach($data['blank_report']); */
                            foreach ($data['file_passed'] as $file_name) {
                                if($file_name=='email_attachment/ABD_1-5.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                                    $message->attach($file_name);
                                }
                            }                   
                        });
                        if($request['old_inspector']==$request['inspector'] || $request['old_inspector']=='' || $request['old_inspector']==null){

                        }else{
                            if($old_inspection_details->inspection_status=='Released'){
                                Mail::send('email.cancel_inspector',$data, function($message) use ($data){
                                    $message->to($data['old_insp_email']);
                                    $message->cc('it-support@t-i-c.asia');
                                    $message->cc($data['book_email']);
                                    $message->cc('gregor@t-i-c.asia');
                                    $message->cc('report@t-i-c.asia');
                                    $message->cc('booking@t-i-c.asia');
                                    $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                                    $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .") - Cancelled Inspection");             
                                });
                            }
                        }
                    }
                   

                    if (count(Mail::failures()) > 0) {
                        DB::rollback();
                        return response()->json([
                            'message' => 'error',
                        ],500);

                    }else{
                        DB::commit();
                        return response()->json([
                            'message' => 'OK',
                        ],200);
                    }
                }
            }
            
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    //save and publish draft
    public function postInspectionDataFromDraftWoutAddedFiles(Request $request){
        DB::beginTransaction();
        try {
            //$inspection = new Inspection();
            $old_inspection_details=Inspection::find($request['edit_inspection_id']);
            $inspection = Inspection::find($request['edit_inspection_id']);
            //inspection details
            $inspection->client_id = $request['client'];
            $inspection->contact_person = $request['contact_person'];
            //supplier details
            $inspection->supplier = $request['supplier'];
            $inspection->supplier_contact_person = $request['supplier_contact_person'];
            //factory details
            $inspection->factory = $request['factory'];
            $inspection->factory_contact_person = $request['factory_contact_person'];

            $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

            //inspection details
            $inspection->inspector_id = $request['inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->old_inspector_id = $request['old_inspector'];
            $inspection->manday = $request['manday'];
            $inspection->inspection_date = $request['inspection_date'];
            $inspection->inspection_date_to = $request['inspection_date_to'];
            $inspection->service = $request['service'];
            $inspection->reference_number = $request['reference_number'];
            $inspection->client_project_number = $request['client_project_number'];

            $inspection->percentageFriSpk = $request['percentageSpkFri'];

            $inspection->requirement = $request['requirement'];
            $inspection->memo = $request['memo'];
            $template=$request['template'];
            if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}

            $report_template=$request['report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}

            $inspection->word_template = null;
            $inspection->template_id = $template;
            $inspection->project_type = $request['type_of_project'];


            $inspection->inspection_status = "Released";
            $inspection->created_by =  Auth::id();


            

            if ($inspection->save()) {
                
                $clientCost = ClientCost::find($request['client_cost_id']);
                $clientCost->currency =  $request['cli_currency'];
                $clientCost->md_charges =  $request['cli_md_charge'];
                $clientCost->travel_cost =  $request['cli_travel_cost'];
                $clientCost->hotel_cost =  $request['cli_hotel_cost'];
                $clientCost->ot_cost =  $request['cli_ot_cost']; 
                $cli_other_cost_text =  $request['cli_other_cost_text']; 
                $cli_other_cost_value =  $request['cli_other_cost_value']; 
                $arr_cli_other_cost_text=null;
                $arr_cli_other_cost_value=null;
                if($cli_other_cost_text==null || $cli_other_cost_text=='null'){
                    
                }else{
                    foreach ($cli_other_cost_text as $i => $value) {
                        //array_push($arr_cli_other_cost_text,$request['cli_other_cost_text'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_text=$request['cli_other_cost_text'][$i];
                        }else{
                            $arr_cli_other_cost_text=$arr_cli_other_cost_text.','.$request['cli_other_cost_text'][$i];
                        }
                    }
                    foreach ($cli_other_cost_value as $i => $value) {
                        //array_push($arr_cli_other_cost_value,$request['cli_other_cost_value'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_value=$request['cli_other_cost_value'][$i];
                        }else{
                            $arr_cli_other_cost_value=$arr_cli_other_cost_value.','.$request['cli_other_cost_value'][$i];
                        }
                    }
                }
                $clientCost->other_cost_text =  $arr_cli_other_cost_text;
                $clientCost->other_cost_value =  $arr_cli_other_cost_value; 
                $clientCost->save();

                $inspectorCost = InspectorCost::find($request['inspector_cost_id']);
                $inspectorCost->currency =  $request['ins_currency'];
                $inspectorCost->md_charges =  $request['ins_md_charge'];
                $inspectorCost->travel_cost =  $request['ins_travel_cost'];
                $inspectorCost->hotel_cost =  $request['ins_hotel_cost'];
                $inspectorCost->ot_cost =  $request['ins_ot_cost']; 
                $ins_other_cost_text =  $request['ins_other_cost_text']; 
                $ins_other_cost_value =  $request['ins_other_cost_value']; 
                $arr_ins_other_cost_text=null;
                $arr_ins_other_cost_value=null;

                if($ins_other_cost_text==null || $ins_other_cost_text=='null'){

                }else{
                    foreach ($ins_other_cost_text as $i => $value) {
                        //array_push($arr_ins_other_cost_text,$request['ins_other_cost_text'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_text=$request['ins_other_cost_text'][$i];
                        }else{
                            $arr_ins_other_cost_text=$arr_ins_other_cost_text.','.$request['ins_other_cost_text'][$i];
                        }

                    }
                    foreach ($ins_other_cost_value as $i => $value) {
                        //array_push($ins_other_cost_value,$request['ins_other_cost_value'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_value=$request['ins_other_cost_value'][$i];
                        }else{
                            $arr_ins_other_cost_value=$arr_ins_other_cost_value.','.$request['ins_other_cost_value'][$i];
                        }
                    }
                }
                $inspectorCost->other_cost_text =  $arr_ins_other_cost_text;
                $inspectorCost->other_cost_value =  $arr_ins_other_cost_value; 
                $inspectorCost->save();
                
                $inserted_inspection_id=$request['edit_inspection_id'];
                $upload_file_name=array();

                $attachment = Attachment::where('inspection_id',$inserted_inspection_id)->get();
                if(count($attachment)>0){
                    foreach($attachment as $up_file){
                        array_push($upload_file_name,$up_file->path);
                    }
                }
                
                $inserted_inspection_id=$request['edit_inspection_id'];
                $upload_file_name=array();

                $abd_dir = 'email_attachment/ABD_1-5.pdf';
                if(File::exists($abd_dir)){
                    array_push($upload_file_name,$abd_dir); // attach the abd
                }
                
                $oqr_dir = 'email_attachment/TIC_Onsite_Quick_Report.pdf';
                if(File::exists($oqr_dir)){
                    array_push($upload_file_name,$oqr_dir); // attach the abd
                }
                
                $fm_dir = 'email_attachment/File_Manager_User_Manual.pdf';
                if(File::exists($fm_dir)){
                    array_push($upload_file_name,$fm_dir); // attach the abd
                }

                $attachment = Attachment::where('inspection_id',$inserted_inspection_id)->get();
                if(count($attachment)>0){
                    foreach($attachment as $up_file){
                        array_push($upload_file_name,$up_file->path);
                    }
                }
                           

                if($request['hidden_product_id']!=null || $request['hidden_product_id']!=''){
                    $products = $request['product_name'];
                        foreach ($products as $i => $value) {
                            $prods[$i] = PSIProduct::find($request['hidden_product_id'][$i]);
                            $prods[$i]->product_name = $request['product_name'][$i];
                            $prods[$i]->product_category = $request['product_category'][$i];
                            $prods[$i]->brand = $request['brand'][$i];
                            $prods[$i]->product_unit = $request['p_unit'][$i];
                            $prods[$i]->po_no = $request['po_number'][$i];
                            $prods[$i]->model_no = $request['model_no'][$i];
                            $prods[$i]->additional_product_info = $request['prod_addtl_info'][$i];
                            $prods[$i]->aql_qty = $request['aql_qty'][$i];
                            $prods[$i]->save();                  
                        }
                }

                if($request['is_new_product_added']==0 || $request['is_new_product_added']=='0'){

                }else{
                    $new_product = $request['new_product_name'];
                    foreach ($new_product as $i => $value) {
                        $prods[$i] = new PSIProduct();
                        $prods[$i]->inspection_id = $inserted_inspection_id;
                        $prods[$i]->product_name = $request['new_product_name'][$i];
                        $prods[$i]->product_category = $request['new_product_category'][$i];
                        $prods[$i]->brand = $request['new_brand'][$i];
                        $prods[$i]->po_no = $request['new_po_number'][$i];
                        $prods[$i]->model_no = $request['new_model_no'][$i];
                        $prods[$i]->aql_qty = $request['new_aql_qty'][$i];
                        $prods[$i]->aql_normal_level = $request['new_aql_normal_level'][$i];
                        $prods[$i]->aql_special_level = $request['new_aql_special_level'][$i];
                        $prods[$i]->aql_major = $request['new_aql_major'][$i];
                        $prods[$i]->max_allowed_major = $request['new_max_major'][$i];
                        $prods[$i]->aql_minor = $request['new_aql_minor'][$i];
                        $prods[$i]->max_allowed_minor = $request['new_max_minor'][$i];
                        $prods[$i]->aql_normal_letter = $request['new_aql_normal_letter'][$i];
                        $prods[$i]->aql_normal_sampsize = $request['new_aql_normal_sampsize'][$i];
                        $prods[$i]->aql_special_letter = $request['new_aql_special_letter'][$i];
                        $prods[$i]->aql_special_sampsize = $request['new_aql_special_sampsize'][$i];
                        $prods[$i]->save();
                    }
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                $password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];


                $report_id = Report::where('inspection_id',$inserted_inspection_id)->first();

                $report = Report::find($report_id->id);
                $report->inspection_id = $inspection->id;
                $report->client_code = $client->client_code;
                $report->service = $this->service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->report_no = $report_no;
                $report->password = $password;
                $report->inspector_id=$request['inspector'];
                
                if ($report->save()) {

                    $insp_details = Inspection::where('id',$inserted_inspection_id)->first();
                    $fac_contact2=$insp_details->factory_contact_person2;

                    $inspector_info = UserInfo::find($request['inspector']);
                    $inspector_cred = User::find($request['inspector']);
                    //old inspector details
                    $old_inspector_info = UserInfo::find($request['old_inspector']);
                    $factory = Factory::find($request['factory']);
                    $factory_contact = FctoryContact::find($request['factory_contact_person']);
                    $factory_contact_sec = FctoryContact::find($request['factory_contact_person2_psi']);
                    $supplier = Supplier::find($request['supplier']);
                    $supplier_contact = SupplierContact::find($request['supplier_contact_person']);
                    $psi_product_list = PSIProduct::where('inspection_id',$inserted_inspection_id)->get();
                    $product_list = Product::all();
                    
                    $booking_info = UserInfo::find(Auth::id());
                    
                    $blank_report=array();
                    $product_subject = "";
                    foreach($psi_product_list as $psi_prod){
                        foreach($product_list as $prod){
                            if($prod->id==$psi_prod->product_name){                                  
                                if($product_subject==""){
                                    $product_subject=$prod->product_name ." Qty ". $psi_prod->aql_qty ." pcs ";
                                }else{
                                    $product_subject=$product_subject ." , ". $prod->product_name ." Qty ". $psi_prod->aql_qty ." pcs ";
                                }
                            }
                        }
                    }
                    $fac_contact="";
                    $fac_email="";
                    $fac_num="";
                    $fac_con2="";
                    $fac_email2="";
                    $fac_num2="";

                    if($fac_contact2=="" || $fac_contact2=="N/A" || $fac_contact2=="0" || $fac_contact2==0 || $fac_contact2==null){
                        $fac_contact=$factory_contact->factory_contact_person;
                        $fac_num=$factory_contact->factory_tel_number;
                        $fac_email=$factory_contact->factory_email;
                    }else{                     
                        $fac_sec_ex=explode(',',$fac_contact2);
                        foreach($fac_sec_ex as $key => $fid){
                            $fac_sec = FctoryContact::where('id',$fid)->first();
                            $fac_con2.=$fac_sec->factory_contact_person;    
                            $fac_email2.=$fac_sec->factory_tel_number;
                            $fac_num2.=$fac_sec->factory_email;    

                            if($key!=count($fac_sec_ex)){
                                $fac_con2.=',';
                                $fac_email2.=',';
                                $fac_num2.=',';
                            }
                        }

                        $fac_contact=$factory_contact->factory_contact_person .', '. $fac_con2;
                        $fac_num=$factory_contact->factory_tel_number .', '. $fac_email2;
                        $fac_email=$factory_contact->factory_email .', '. $fac_num2;
                    }

                    if($request['type_of_project']=='word_project' || $request['type_of_project']=="esprit"){


                        $data = ['report_number' =>  $request['reference_number'],
                         'password' => $password,
                          'email' => $inspector_info->email_address,
                          'insp_name' => $inspector_info->name,
                          'insp_pw' => $inspector_cred->plain,
                            'insp_un' => $inspector_cred->username,
                            'old_insp_email' => $old_inspector_info->email_address,
                            'old_insp_name' => $old_inspector_info->name,
                            'manday'=>$request['manday'],
                            'spk_fri'=>$request['percentageSpkFri'],
                           'file_passed'=>$upload_file_name,
                           'service'=>$this->service[$request['service']],
                           'ref_num'=>$request['reference_number'],
                           'inspection_date'=>$request['inspection_date'],
                           'inspection_date_to'=>$request['inspection_date_to'],
                           'factory_name'=>$factory->factory_name,
                           'factory_address'=>$factory->factory_address,
                           'factory_address_local'=>$factory->factory_address_local,
                           'factory_contact'=>$factory_contact->factory_contact_person,
                           'supplier_name'=>$supplier->supplier_name,
                            'supplier_address'=>$supplier->supplier_address,
                            'supplier_address_local'=>$supplier->supplier_address_local,
                            'supplier_contact'=>$supplier_contact->supplier_contact_person,
                           'client_number'=>$request['client_project_number'],
                           'requirement'=>$request['requirement'],
                           'psi_product_list'=>$psi_product_list,
                           'product_list'=>$product_list,
                           'memo'=>$request['memo'],
                           'product_subject'=>$product_subject,
                           'book_email'=>$booking_info->email_address,
                           'fac_contact'=>$fac_contact,
                           'fac_email'=>$fac_email,
                           'fac_num'=>$fac_num];
                        $files_uploaded = $request->file('file');
                        Mail::send('email.manual_download',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");
                            foreach ($data['file_passed'] as $file_name) {
                                if($file_name=='email_attachment/ABD_1-5.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                                    $message->attach($file_name);
                                }
                            }                 
                        });
                        if($request['old_inspector']==$request['inspector'] || $request['old_inspector']=='' || $request['old_inspector']==null){

                        }else{
                            if($old_inspection_details->inspection_status=='Released'){
                                Mail::send('email.cancel_inspector',$data, function($message) use ($data){
                                    $message->to($data['old_insp_email']);
                                    $message->cc('it-support@t-i-c.asia');
                                    $message->cc($data['book_email']);
                                    $message->cc('gregor@t-i-c.asia');
                                    $message->cc('report@t-i-c.asia');
                                    $message->cc('booking@t-i-c.asia');
                                    $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                                    $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .") - Cancelled Inspection");             
                                });
                            }
                        }
                    }else{
                        $data = ['report_number' =>  $request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'old_insp_email' => $old_inspector_info->email_address,
                            'old_insp_name' => $old_inspector_info->name,
                            'insp_pw' => $inspector_cred->plain,
                            'service'=>$this->service[$request['service']],
                            'ref_num'=>$request['reference_number'],
                            'client_number'=>$request['client_project_number'],
                            'product_subject'=>$product_subject,
                            'file_passed'=>$upload_file_name,
                            'psi_product_list'=>$psi_product_list,
                            'product_list'=>$product_list,
                            'requirement'=>$request['requirement'],
                            'memo'=>$request['memo'],
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'supplier_name'=>$supplier->supplier_name,
                            'supplier_address'=>$supplier->supplier_address,
                            'supplier_address_local'=>$supplier->supplier_address_local,
                            'supplier_contact'=>$supplier_contact->supplier_contact_person,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num,
                            'book_email'=>$booking_info->email_address];
                        $files_uploaded = $request->file('file');
                        Mail::send('email.download',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            $message->subject('Download Blank Report for ' . $data['report_number']);
                            foreach ($data['file_passed'] as $file_name) {
                                if($file_name=='email_attachment/ABD_1-5.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                                    $message->attach($file_name);
                                }
                            }                   
                        });
                        if($request['old_inspector']==$request['inspector'] || $request['old_inspector']=='' || $request['old_inspector']==null){

                        }else{
                            if($old_inspection_details->inspection_status=='Released'){
                                Mail::send('email.cancel_inspector',$data, function($message) use ($data){
                                    $message->to($data['old_insp_email']);
                                    $message->cc('it-support@t-i-c.asia');
                                    $message->cc($data['book_email']);
                                    $message->cc('gregor@t-i-c.asia');
                                    $message->cc('report@t-i-c.asia');
                                    $message->cc('booking@t-i-c.asia');
                                    $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                                    $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .") - Cancelled Inspection");             
                                });
                            }
                        }
                    }
                   

                    if (count(Mail::failures()) > 0) {
                        DB::rollback();
                        return response()->json([
                            'message' => 'error',
                        ],500);

                    }else{
                        DB::commit();
                        return response()->json([
                            'message' => 'OK',
                        ],200);
                    }
                }
            }
            
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    //save and publish copied inspection
    public function postInspectionDataFromCopy(Request $request){
        DB::beginTransaction();
        try {
            //$inspection = new Inspection();
            $old_inspection_details=Inspection::find($request['edit_inspection_id']);
            $inspection = new Inspection();
            //inspection details
            $inspection->client_id = $request['client'];
            $inspection->contact_person = $request['contact_person'];
            //supplier details
            $inspection->supplier = $request['supplier'];
            $inspection->supplier_contact_person = $request['supplier_contact_person'];
            //factory details
            $inspection->factory = $request['factory'];
            $inspection->factory_contact_person = $request['factory_contact_person'];

            $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

            //inspection details
            $inspection->inspector_id = $request['inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->old_inspector_id = $request['old_inspector'];
            $inspection->manday = $request['manday'];
            $inspection->inspection_date = $request['inspection_date'];
            $inspection->inspection_date_to = $request['inspection_date_to'];
            $inspection->service = $request['service'];
            $inspection->reference_number = $request['reference_number'];
            $inspection->client_project_number = $request['client_project_number'];

            $inspection->percentageFriSpk = $request['percentageSpkFri'];

            $inspection->requirement = $request['requirement'];
            $inspection->memo = $request['memo'];
            $template=$request['template'];
            if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}

            $report_template=$request['report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}

            $inspection->word_template = null;
            $inspection->template_id = $template;
            $inspection->project_type = $request['type_of_project'];


            $inspection->inspection_status = "Released";
            $inspection->created_by =  Auth::id();


            

            if ($inspection->save()) {
                $new_inspection_id=$inspection->id;
                $edit_inspection_id=$request['edit_inspection_id'];
                
                $clientCost = new ClientCost();
                $clientCost->inspection_id =  $new_inspection_id;
                $clientCost->currency =  $request['cli_currency'];
                $clientCost->md_charges =  $request['cli_md_charge'];
                $clientCost->travel_cost =  $request['cli_travel_cost'];
                $clientCost->hotel_cost =  $request['cli_hotel_cost'];
                $clientCost->ot_cost =  $request['cli_ot_cost']; 
                $cli_other_cost_text =  $request['cli_other_cost_text']; 
                $cli_other_cost_value =  $request['cli_other_cost_value']; 
                $arr_cli_other_cost_text=null;
                $arr_cli_other_cost_value=null;
                if($cli_other_cost_text==null || $cli_other_cost_text=='null'){
                    
                }else{
                    foreach ($cli_other_cost_text as $i => $value) {
                        //array_push($arr_cli_other_cost_text,$request['cli_other_cost_text'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_text=$request['cli_other_cost_text'][$i];
                        }else{
                            $arr_cli_other_cost_text=$arr_cli_other_cost_text.','.$request['cli_other_cost_text'][$i];
                        }
                    }
                    foreach ($cli_other_cost_value as $i => $value) {
                        //array_push($arr_cli_other_cost_value,$request['cli_other_cost_value'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_value=$request['cli_other_cost_value'][$i];
                        }else{
                            $arr_cli_other_cost_value=$arr_cli_other_cost_value.','.$request['cli_other_cost_value'][$i];
                        }
                    }
                }
                $clientCost->other_cost_text =  $arr_cli_other_cost_text;
                $clientCost->other_cost_value =  $arr_cli_other_cost_value; 
                $clientCost->save();

                $inspectorCost = new InspectorCost();
                $inspectorCost->inspection_id =  $new_inspection_id;
                $inspectorCost->currency =  $request['ins_currency'];
                $inspectorCost->md_charges =  $request['ins_md_charge'];
                $inspectorCost->travel_cost =  $request['ins_travel_cost'];
                $inspectorCost->hotel_cost =  $request['ins_hotel_cost'];
                $inspectorCost->ot_cost =  $request['ins_ot_cost']; 
                $ins_other_cost_text =  $request['ins_other_cost_text']; 
                $ins_other_cost_value =  $request['ins_other_cost_value']; 
                $arr_ins_other_cost_text=null;
                $arr_ins_other_cost_value=null;

                if($ins_other_cost_text==null || $ins_other_cost_text=='null'){

                }else{
                    foreach ($ins_other_cost_text as $i => $value) {
                        //array_push($arr_ins_other_cost_text,$request['ins_other_cost_text'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_text=$request['ins_other_cost_text'][$i];
                        }else{
                            $arr_ins_other_cost_text=$arr_ins_other_cost_text.','.$request['ins_other_cost_text'][$i];
                        }

                    }
                    foreach ($ins_other_cost_value as $i => $value) {
                        //array_push($ins_other_cost_value,$request['ins_other_cost_value'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_value=$request['ins_other_cost_value'][$i];
                        }else{
                            $arr_ins_other_cost_value=$arr_ins_other_cost_value.','.$request['ins_other_cost_value'][$i];
                        }
                    }
                }
                $inspectorCost->other_cost_text =  $arr_ins_other_cost_text;
                $inspectorCost->other_cost_value =  $arr_ins_other_cost_value; 
                $inspectorCost->save();
                
                

                $upload_file_name=array();

                $abd_dir = 'email_attachment/ABD_1-5.pdf';
                if(File::exists($abd_dir)){
                    array_push($upload_file_name,$abd_dir); // attach the abd
                }
                
                $oqr_dir = 'email_attachment/TIC_Onsite_Quick_Report.pdf';
                if(File::exists($oqr_dir)){
                    array_push($upload_file_name,$oqr_dir); // attach the abd
                }
                
                $fm_dir = 'email_attachment/File_Manager_User_Manual.pdf';
                if(File::exists($fm_dir)){
                    array_push($upload_file_name,$fm_dir); // attach the abd
                }

                $get_attachment = Attachment::where('inspection_id',$edit_inspection_id)->get();
                /* if($get_attachment){
                    $edit_dir="images/project2/".$edit_inspection_id."/"; 
                    $new_dir="images/project2/".$new_inspection_id."/";  
                    foreach ($get_attachment as $att) {                   
                        $new_att= new Attachment();
                        $new_att->inspection_id = $new_inspection_id;
                        $new_att->project_number = $request['reference_number'];
                        $new_att->file_name = $att->file_name;
                        $new_att->file_size = $att->file_size;
                        $new_att->path = $att->path;
                        $new_att->save();
                        array_push($upload_file_name,$edit_dir.$att->file_name); 
                        $file_copy=$edit_dir.$att->file_name;
                        $file_destination=$new_dir.$att->file_name;
                        if (!File::exists($new_dir)) {
                            File::makeDirectory($new_dir);
                        }
                        File::copy($file_copy,$file_destination); 
                    }
                }    */                         

                $new_product = $request['new_product_name'];
                foreach ($new_product as $i => $value) {
                    $prods[$i] = new PSIProduct();
                    $prods[$i]->inspection_id = $new_inspection_id;
                    $prods[$i]->product_name = $request['new_product_name'][$i];
                    $prods[$i]->product_category = $request['new_product_category'][$i];
                    $prods[$i]->product_unit = $request['new_aql_qty_unit'][$i];
                    $prods[$i]->brand = $request['new_brand'][$i];
                    $prods[$i]->po_no = $request['new_po_number'][$i];
                    $prods[$i]->model_no = $request['new_model_no'][$i];
                    $prods[$i]->additional_product_info = $request['new_add_product_info'][$i];
                    $prods[$i]->aql_qty = $request['new_aql_qty'][$i];
                    $prods[$i]->aql_qty_unit = $request['new_aql_qty_unit'][$i];
                    $prods[$i]->aql_normal_level = $request['new_aql_normal_level'][$i];
                    $prods[$i]->aql_special_level = $request['new_aql_special_level'][$i];
                    $prods[$i]->aql_major = $request['new_aql_major'][$i];
                    $prods[$i]->max_allowed_major = $request['new_max_major'][$i];
                    $prods[$i]->aql_minor = $request['new_aql_minor'][$i];
                    $prods[$i]->max_allowed_minor = $request['new_max_minor'][$i];
                    $prods[$i]->aql_normal_letter = $request['new_aql_normal_letter'][$i];
                    $prods[$i]->aql_normal_sampsize = $request['new_aql_normal_sampsize'][$i];
                    $prods[$i]->aql_special_letter = $request['new_aql_special_letter'][$i];
                    $prods[$i]->aql_special_sampsize = $request['new_aql_special_sampsize'][$i];
                    $prods[$i]->save();
                }

                if($request->file('file')){
                    foreach ($request->file('file') as $file) {
                        //set a unique file name
                        //$filename = 'psi-'. $inserted_inspection_id . '-' . uniqid().'.'.$file->getClientOriginalExtension();
                        $filename = $file->getClientOriginalName();    
                        $filename=str_replace("#","_",$filename);                  
                        //directory
                        $dir="images/project2/".$new_inspection_id."/";

                        //move the files to the correct folder
                        if (!File::exists($dir)) {
                            File::makeDirectory($dir, 0777, true, true);
                        }
                        //push file name in array
                        array_push($upload_file_name,$dir.$filename);                   
                        //save details to db
                        $doc= new Attachment();
                        $doc->inspection_id = $new_inspection_id;
                        $doc->project_number = $request['reference_number'];
                        $doc->file_name = $filename;
                        $doc->file_size = $file->getSize();
                        $doc->path = $dir.$filename;
                        $doc->save();
                    
				    	$file->move($dir,$filename);
                    }
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                $password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];


                //$report_id = Report::where('inspection_id',$inserted_inspection_id)->first();

                $report = new Report();
                $report->inspection_id = $new_inspection_id;
                $report->client_code = $client->client_code;
                $report->service = $this->service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->report_no = $report_no;
                $report->password = $password;
                $report->inspector_id=$request['inspector'];
                
                if ($report->save()) {

                    $insp_details = Inspection::where('id',$new_inspection_id)->first();
                    $fac_contact2=$insp_details->factory_contact_person2;

                    $inspector_info = UserInfo::find($request['inspector']);
                    $inspector_cred = User::find($request['inspector']);
                    //old inspector details
                    $old_inspector_info = UserInfo::find($request['old_inspector']);
                    $supplier = Supplier::find($request['supplier']);
                    $supplier_contact = SupplierContact::find($request['supplier_contact_person']);
                    $factory = Factory::find($request['factory']);
                    $factory_contact = FctoryContact::find($request['factory_contact_person']);
                    $factory_contact_sec = FctoryContact::find($request['factory_contact_person2_psi']);
                    $psi_product_list = PSIProduct::where('inspection_id',$new_inspection_id)->get();
                    $product_list = Product::all();
                    
                    $booking_info = UserInfo::find(Auth::id());
                    
                    $blank_report=array();

                    $product_subject = "";
                    foreach($psi_product_list as $psi_prod){
                        foreach($product_list as $prod){
                            if($prod->id==$psi_prod->product_name){                                  
                                if($product_subject==""){
                                    $product_subject=$prod->product_name ." Qty ". $psi_prod->aql_qty ." pcs ";
                                }else{
                                    $product_subject=$product_subject ." , ". $prod->product_name ." Qty ". $psi_prod->aql_qty ." pcs ";
                                }
                            }
                        }
                    }
                    $fac_contact="";
                    $fac_email="";
                    $fac_num="";
                    $fac_con2="";
                    $fac_email2="";
                    $fac_num2="";

                    if($fac_contact2=="" || $fac_contact2=="N/A" || $fac_contact2=="0" || $fac_contact2==0 || $fac_contact2==null){
                        $fac_contact=$factory_contact->factory_contact_person;
                        $fac_num=$factory_contact->factory_tel_number;
                        $fac_email=$factory_contact->factory_email;
                    }else{                     
                        $fac_sec_ex=explode(',',$fac_contact2);
                        foreach($fac_sec_ex as $key => $fid){
                            $fac_sec = FctoryContact::where('id',$fid)->first();
                            $fac_con2.=$fac_sec->factory_contact_person;    
                            $fac_email2.=$fac_sec->factory_tel_number;
                            $fac_num2.=$fac_sec->factory_email;    
                            if($key!=count($fac_sec_ex)){
                                $fac_con2.=',';
                                $fac_email2.=',';
                                $fac_num2.=',';
                            }
                        }
                        $fac_contact=$factory_contact->factory_contact_person .', '. $fac_con2;
                        $fac_num=$factory_contact->factory_tel_number .', '. $fac_email2;
                        $fac_email=$factory_contact->factory_email .', '. $fac_num2;
                    }

                    if($request['type_of_project']=='word_project' || $request['type_of_project']=="esprit"){                     
                        $data = ['report_number' =>  $request['reference_number'], 
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'old_insp_email' => $old_inspector_info->email_address,
                            'old_insp_name' => $old_inspector_info->name,
                            'manday'=>$request['manday'],
                            'spk_fri'=>$request['percentageSpkFri'],
                            'file_passed'=>$upload_file_name,
                            'service'=>$this->service[$request['service']],
                            'ref_num'=>$request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'supplier_name'=>$supplier->supplier_name,
                            'supplier_address'=>$supplier->supplier_address,
                            'supplier_address_local'=>$supplier->supplier_address_local,
                            'supplier_contact'=>$supplier_contact->supplier_contact_person,
                            'client_number'=>$request['client_project_number'],
                            'requirement'=>$request['requirement'],
                            'psi_product_list'=>$psi_product_list,
                            'product_list'=>$product_list,
                            'memo'=>$request['memo'],
                            'product_subject'=>$product_subject,
                            'book_email'=>$booking_info->email_address,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num];
                        $files_uploaded = $request->file('file');
                        Mail::send('email.manual_download',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");
                            foreach ($data['file_passed'] as $file_name) {
                                if($file_name=='email_attachment/ABD_1-5.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                                    $message->attach($file_name);
                                }
                            }                 
                        });
                        
                    }else{
                        $data = ['report_number' =>  $request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'old_insp_email' => $old_inspector_info->email_address,
                            'old_insp_name' => $old_inspector_info->name,
                            'service'=>$this->service[$request['service']],
                            'ref_num'=>$request['reference_number'],
                            'file_passed'=>$upload_file_name,
                            'requirement'=>$request['requirement'],
                            'psi_product_list'=>$psi_product_list,
                            'product_list'=>$product_list,
                            'memo'=>$request['memo'],
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'supplier_name'=>$supplier->supplier_name,
                            'supplier_address'=>$supplier->supplier_address,
                            'supplier_address_local'=>$supplier->supplier_address_local,
                            'supplier_contact'=>$supplier_contact->supplier_contact_person,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num,
                            'book_email'=>$booking_info->email_address];
                        $files_uploaded = $request->file('file');
                        Mail::send('email.download',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            $message->subject('Download Blank Report for ' . $data['report_number']);
                            /* $message->attach($data['blank_report']); */
                            foreach ($data['file_passed'] as $file_name) {
                                if($file_name=='email_attachment/ABD_1-5.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                                    $message->attach($file_name);
                                }
                            }                   
                        });
                    }
                   

                    if (count(Mail::failures()) > 0) {
                        DB::rollback();
                        return response()->json([
                            'message' => 'error',
                        ],500);

                    }else{
                        DB::commit();
                        return response()->json([
                            'message' => 'OK',
                        ],200);
                    }
                }
            }
            
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function postInspectionData(Request $request){
        $this->validate($request,array(
            'service'=>'required',
            'reference_number' => 'required',
            'inspection_date' => 'required',
            'client' => 'required',
            'contact_person' => 'required',
            'factory'=>'required',
            'factory_contact_person'=>'required',
            'requirement'=>'required',
        ));
        
        DB::beginTransaction();

        try {
            $inspection = new Inspection();
            //inspection details
            $inspection->client_id = $request['client'];
            $inspection->contact_person = $request['contact_person'];
            //supplier details
            $inspection->supplier = $request['supplier'];
            $inspection->supplier_contact_person = $request['supplier_contact_person'];
            //factory details
            $inspection->factory = $request['factory'];
            $inspection->factory_contact_person = $request['factory_contact_person'];

            $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

            //inspection details
            $inspection->inspector_id = $request['inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->manday = $request['manday'];
            $inspection->inspection_date = $request['inspection_date'];
            $inspection->inspection_date_to = $request['inspection_date_to'];
            $inspection->service = $request['service'];
            $inspection->reference_number = $request['reference_number'];
            $inspection->client_project_number = $request['client_project_number'];
            $inspection->percentageFriSpk = $request['percentageSpkFri'];
            $inspection->requirement = $request['requirement'];
            $inspection->memo = $request['memo'];
            $template=$request['template'];
            if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}

            $report_template=$request['report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}
            $inspection->word_template = null;

            $inspection->template_id = $template;
            $inspection->project_type = $request['type_of_project'];

            
            $inspection->inspection_status = "Released";
            //$inspection->complex_report =  $request['complex_report'];
            $inspection->created_by =  Auth::id();
           

            if($request['invisible'] == "on"){
                $inspection->Clientstatus = '1';
            }

            

            if ($inspection->save()) {
                $products = $request['product_name'];
                $inserted_inspection_id=$inspection->id;
                $upload_file_name=array();
                $prod_name=array();
                $brand_arr=array();
                $po_number_arr=array();
                $model_no_arr=array();
                $aql_qty_arr=array();
                $aql_normal_level_arr=array();
                $aql_special_level_arr=array();
                $aql_major_arr=array();
                $max_major_arr=array();
                $aql_minor_arr=array();
                $max_minor_arr=array();

                $clientCost = new ClientCost();
                $clientCost->inspection_id =  $inspection->id;
                $clientCost->currency =  $request['cli_currency'];
                $clientCost->md_charges =  $request['cli_md_charge'];
                $clientCost->travel_cost =  $request['cli_travel_cost'];
                $clientCost->hotel_cost =  $request['cli_hotel_cost'];
                $clientCost->ot_cost =  $request['cli_ot_cost']; 
                $cli_other_cost_text =  $request['cli_other_cost_text']; 
                $cli_other_cost_value =  $request['cli_other_cost_value']; 
                $arr_cli_other_cost_text=null;
                $arr_cli_other_cost_value=null;
                if($cli_other_cost_text==null || $cli_other_cost_text=='null'){
                    
                }else{
                    foreach ($cli_other_cost_text as $i => $value) {
                        //array_push($arr_cli_other_cost_text,$request['cli_other_cost_text'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_text=$request['cli_other_cost_text'][$i];
                        }else{
                            $arr_cli_other_cost_text=$arr_cli_other_cost_text.','.$request['cli_other_cost_text'][$i];
                        }
                    }
                    foreach ($cli_other_cost_value as $i => $value) {
                        //array_push($arr_cli_other_cost_value,$request['cli_other_cost_value'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_value=$request['cli_other_cost_value'][$i];
                        }else{
                            $arr_cli_other_cost_value=$arr_cli_other_cost_value.','.$request['cli_other_cost_value'][$i];
                        }
                    }
                }
                $clientCost->other_cost_text =  $arr_cli_other_cost_text;
                $clientCost->other_cost_value =  $arr_cli_other_cost_value; 
                $clientCost->save();

                $inspectorCost = new InspectorCost();
                $inspectorCost->inspection_id =  $inspection->id;
                $inspectorCost->currency =  $request['ins_currency'];
                $inspectorCost->md_charges =  $request['ins_md_charge'];
                $inspectorCost->travel_cost =  $request['ins_travel_cost'];
                $inspectorCost->hotel_cost =  $request['ins_hotel_cost'];
                $inspectorCost->ot_cost =  $request['ins_ot_cost']; 
                $ins_other_cost_text =  $request['ins_other_cost_text']; 
                $ins_other_cost_value =  $request['ins_other_cost_value']; 
                $arr_ins_other_cost_text=null;
                $arr_ins_other_cost_value=null;

                if($ins_other_cost_text==null || $ins_other_cost_text=='null'){

                }else{
                    foreach ($ins_other_cost_text as $i => $value) {
                        //array_push($arr_ins_other_cost_text,$request['ins_other_cost_text'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_text=$request['ins_other_cost_text'][$i];
                        }else{
                            $arr_ins_other_cost_text=$arr_ins_other_cost_text.','.$request['ins_other_cost_text'][$i];
                        }

                    }
                    foreach ($ins_other_cost_value as $i => $value) {
                        //array_push($ins_other_cost_value,$request['ins_other_cost_value'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_value=$request['ins_other_cost_value'][$i];
                        }else{
                            $arr_ins_other_cost_value=$arr_ins_other_cost_value.','.$request['ins_other_cost_value'][$i];
                        }
                    }
                }
                $inspectorCost->other_cost_text =  $arr_ins_other_cost_text;
                $inspectorCost->other_cost_value =  $arr_ins_other_cost_value; 
                $inspectorCost->save();

                foreach ($products as $i => $value) {
                    $prods[$i] = new PSIProduct();
                    $prods[$i]->inspection_id = $inspection->id;
                    $prods[$i]->product_name = $request['product_name'][$i];
                    $prods[$i]->product_category = $request['product_category'][$i];
                    $prods[$i]->brand = $request['brand'][$i];
                    $prods[$i]->po_no = $request['po_number'][$i];
                    $prods[$i]->model_no = $request['model_no'][$i];
                    $prods[$i]->product_unit = $request['p_unit'][$i];
                    $prods[$i]->cmf = null;
                    $prods[$i]->tech_specs = null;
                    $prods[$i]->shipping_mark = null;
                    $prods[$i]->additional_product_info = $request['prod_addtl_info'][$i];
                    $prods[$i]->aql_qty = $request['aql_qty'][$i];
                    $prods[$i]->aql_qty_unit = $request['aql_qty_unit'][$i];
                    $prods[$i]->aql_normal_level = $request['aql_normal_level'][$i];
                    $prods[$i]->aql_special_level = $request['aql_special_level'][$i];
                    $prods[$i]->aql_major = $request['aql_major'][$i];
                    $prods[$i]->max_allowed_major = $request['max_major'][$i];
                    $prods[$i]->aql_minor = $request['aql_minor'][$i];
                    $prods[$i]->max_allowed_minor = $request['max_minor'][$i];
                    $prods[$i]->aql_normal_letter = $request['aql_normal_letter'][$i];
                    $prods[$i]->aql_normal_sampsize = $request['aql_normal_sampsize'][$i];
                    $prods[$i]->aql_special_letter = $request['aql_special_letter'][$i];
                    $prods[$i]->aql_special_sampsize = $request['aql_special_sampsize'][$i];
                    $prods[$i]->save();
                    $product = Product::find($request['product_name'][$i]);
                    array_push($prod_name,$request['product_name'][$i]);
                    array_push($brand_arr,$request['brand'][$i]);
                    array_push($po_number_arr,$request['po_number'][$i]);
                    array_push($model_no_arr,$request['model_no'][$i]);
                    array_push($aql_qty_arr,$request['aql_qty'][$i]);
                    array_push($aql_normal_level_arr,$request['aql_normal_level'][$i].'/'.$request['aql_special_level'][$i]);
                    array_push($aql_special_level_arr,$request['aql_normal_sampsize'][$i].'/'. $request['aql_special_sampsize'][$i]);
                    array_push($aql_major_arr,$request['aql_major'][$i]);
                    array_push($max_major_arr,$request['max_major'][$i]);
                    array_push($aql_minor_arr,$request['aql_minor'][$i]);
                    array_push($max_minor_arr,$request['max_minor'][$i]);
                }


                $abd_dir = 'email_attachment/ABD_1-5.pdf';
                if(File::exists($abd_dir)){
                    array_push($upload_file_name,$abd_dir); // attach the abd
                }
                
                $oqr_dir = 'email_attachment/TIC_Onsite_Quick_Report.pdf';
                if(File::exists($oqr_dir)){
                    array_push($upload_file_name,$oqr_dir); // attach the abd
                }
                
                $fm_dir = 'email_attachment/File_Manager_User_Manual.pdf';
                if(File::exists($fm_dir)){
                    array_push($upload_file_name,$fm_dir); // attach the abd
                }

                foreach ($request->file('file') as $file) {
                    //set a unique file name
                    //$filename = 'psi-'. $inserted_inspection_id . '-' . uniqid().'.'.$file->getClientOriginalExtension();
                    $filename = $file->getClientOriginalName();
                    $filename=str_replace("#","_",$filename);
                    
                    //directory
                    $dir="images/project2/".$inserted_inspection_id."/";
                    
                    //move the files to the correct folder
                    if (!File::exists($dir)) {
                        File::makeDirectory($dir, 0777, true, true);
                    }
                    
                    //push file name in array
                    array_push($upload_file_name,$dir.$filename);
    
                    //save details to db
                    $doc= new Attachment();
                    $doc->inspection_id = $inserted_inspection_id;
                    $doc->project_number = $request['reference_number'];
                    $doc->file_name = $filename;
                    $doc->file_size = $file->getSize();
                    //$doc->file_size = 56716;
                    $doc->path = $dir.$filename;
                    $doc->save();
					
					$file->move($dir,$filename);
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                $password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];

                $report = new Report();
                $report->inspection_id = $inspection->id;
                $report->client_code = $client->client_code;
                $report->service = $this->service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->inspector_id=$request['inspector'];
                $report->report_no = $report_no;
                $report->password = $password;
                
                if ($report->save()) {

                    $fac_contact2=$request['factory_contact_person2_psi'];
                    $inspector_info = UserInfo::find($request['inspector']);
                    $inspector_cred = User::find($request['inspector']);
                    $supplier = Supplier::find($request['supplier']);
                    $supplier_contact = SupplierContact::find($request['supplier_contact_person']);
                    $factory = Factory::find($request['factory']);
                    $factory_contact = FctoryContact::find($request['factory_contact_person']);
                    $factory_contact_sec = FctoryContact::find($request['factory_contact_person2_psi']);
                    $psi_product_list = PSIProduct::where('inspection_id',$inserted_inspection_id)->get();
                    $product_list = Product::all();
                    $blank_report_dir=array();

                    $blank_report = array();

                    $booking_info = UserInfo::find(Auth::id());
                    
                    $product_subject = "";
                        foreach($psi_product_list as $psi_prod){
                            foreach($product_list as $prod){
                                if($prod->id==$psi_prod->product_name){                                  
                                    if($product_subject==""){
                                        $product_subject=$prod->product_name ." Qty ". $psi_prod->aql_qty ." pcs ";
                                    }else{
                                        $product_subject=$product_subject ." , ". $prod->product_name ." Qty ". $psi_prod->aql_qty ." pcs ";
                                    }
                                }
                            }
                        }

                        $fac_contact="";
                        $fac_email="";
                        $fac_num="";
                        $fac_con2="";
                        $fac_email2="";
                        $fac_num2="";

                        if($fac_contact2=="" || $fac_contact2=="N/A" || $fac_contact2=="0" || $fac_contact2==0 || $fac_contact2==null){
                            $fac_contact=$factory_contact->factory_contact_person;
                            $fac_num=$factory_contact->factory_tel_number;
                            $fac_email=$factory_contact->factory_email;
                        }else{                     
                            $fac_sec_ex=explode(',',$fac_contact2);
                            foreach($fac_sec_ex as $key => $fid){
                                $fac_sec = FctoryContact::where('id',$fid)->first();
                                $fac_con2.=$fac_sec->factory_contact_person;    
                                $fac_email2.=$fac_sec->factory_tel_number;
                                $fac_num2.=$fac_sec->factory_email;    

                                if($key!=count($fac_sec_ex)){
                                    $fac_con2.=',';
                                    $fac_email2.=',';
                                    $fac_num2.=',';
                                }
                            }

                            $fac_contact=$factory_contact->factory_contact_person .', '. $fac_con2;
                            $fac_num=$factory_contact->factory_tel_number .', '. $fac_email2;
                            $fac_email=$factory_contact->factory_email .', '. $fac_num2;
                        }
                   
                    if($request['type_of_project']=='word_project' || $request['type_of_project']=="esprit"){                                                     

                        $data = ['report_number' =>  $request['reference_number'],
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'manday'=>$request['manday'],
                            'spk_fri'=>$request['percentageSpkFri'],
                            'file_passed'=>$upload_file_name,
                            'service'=>$this->service[$request['service']],
                            'ref_num'=>$request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'supplier_name'=>$supplier->supplier_name,
                            'supplier_address'=>$supplier->supplier_address,
                            'supplier_address_local'=>$supplier->supplier_address_local,
                            'supplier_contact'=>$supplier_contact->supplier_contact_person,
                            'client_number'=>$request['client_project_number'],
                            'requirement'=>$request['requirement'],
                            'psi_product_list'=>$psi_product_list,
                            'product_list'=>$product_list,
                            'memo'=>$request['memo'],
                            'product_subject'=>$product_subject,
                            'book_email'=>$booking_info->email_address,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num];


                        $files_uploaded = $request->file('file');
                        Mail::send('email.manual_download',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");                            
                            foreach ($data['file_passed'] as $file_name) {
                                if($file_name=='email_attachment/ABD_1-5.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                                    $message->attach($file_name);
                                }
                            }
                    
                        });
                    }else{
                        $data = ['report_number' =>  $request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'file_passed'=>$upload_file_name,
                            'requirement'=>$request['requirement'],
                            'memo'=>$request['memo'],
                            'psi_product_list'=>$psi_product_list,
                            'supplier_name'=>$supplier->supplier_name,
                            'supplier_address'=>$supplier->supplier_address,
                            'supplier_address_local'=>$supplier->supplier_address_local,
                            'supplier_contact'=>$supplier_contact->supplier_contact_person,
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num,
                            'book_email'=>$booking_info->email_address];
                        $files_uploaded = $request->file('file');
                        Mail::send('email.download',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('1249484103@qq.com');
                            $message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            $message->subject('Download Blank Report for ' . $data['report_number']);
                            foreach ($data['file_passed'] as $file_name) {
                                if($file_name=='email_attachment/ABD_1-5.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                                    $message->attach($file_name);
                                }
                                if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                                    $message->attach($file_name);
                                }
                            }                   
                        });
                    }
                   

                    if (count(Mail::failures()) > 0) {
                        DB::rollback();
                        return response()->json([
                            'message' => 'error',
                        ],500);

                    }else{
                        DB::commit();
                        return response()->json([
                            'message' => 'OK',
                        ],200);
                    }
                }
            }
            
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function saveDraftInspection(Request $request){
        DB::beginTransaction();
        try {
            $inspection = new Inspection();
            //inspection details
            $inspection->client_id = $request['client'];
            $inspection->contact_person = $request['contact_person'];
            //supplier details
            $inspection->supplier = $request['supplier'];
            $inspection->supplier_contact_person = $request['supplier_contact_person'];
            //factory details
            $inspection->factory = $request['factory'];
            $inspection->factory_contact_person = $request['factory_contact_person'];

            $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

            //inspection details
            $inspection->inspector_id = $request['inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->manday = $request['manday'];
            $inspection->inspection_date = $request['inspection_date'];
            $inspection->inspection_date_to = $request['inspection_date_to'];
            $inspection->service = $request['service'];
            $inspection->reference_number = $request['reference_number'];
            $inspection->client_project_number = $request['client_project_number'];
            $inspection->requirement = $request['requirement'];
            $inspection->memo = $request['memo'];
            $template=$request['template'];
            if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}

            $report_template=$request['report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}
            $inspection->word_template = null;

            $inspection->template_id = $template;

            $type_of_project=$request['type_of_project'];
            if($type_of_project=="" ){$type_of_project="N/A";}

            $inspection->project_type = $type_of_project;

            $inspection->inspection_status = "Pending";
            $inspection->created_by =  Auth::id();

            if($request['invisible'] == "on"){
                $inspection->Clientstatus = '1';
            }        

            if ($inspection->save()) {
                $products = $request['product_name'];
                $inserted_inspection_id=$inspection->id;

                $clientCost = new ClientCost();
                $clientCost->inspection_id =  $inspection->id;

                $cli_currency=$request['cli_currency'];
                $cli_md_charge=$request['cli_md_charge'];
                $cli_travel_cost=$request['cli_travel_cost'];
                $cli_hotel_cost=$request['cli_hotel_cost'];
                $cli_ot_cost=$request['cli_ot_cost'];
                if($cli_currency==null){$cli_currency="";}
                if($cli_md_charge==null){$cli_md_charge=0;}
                if($cli_travel_cost==null){$cli_travel_cost=0;}
                if($cli_hotel_cost==null){$cli_hotel_cost=0;}
                if($cli_ot_cost==null){$cli_ot_cost=0;}

                $clientCost->currency =  $cli_currency;
                $clientCost->md_charges =  $cli_md_charge;
                $clientCost->travel_cost =  $cli_travel_cost;
                $clientCost->hotel_cost =  $cli_hotel_cost;
                $clientCost->ot_cost =  $cli_ot_cost; 
                $cli_other_cost_text =  $request['cli_other_cost_text']; 
                $cli_other_cost_value =  $request['cli_other_cost_value']; 
                $arr_cli_other_cost_text=null;
                $arr_cli_other_cost_value=null;
                if($cli_other_cost_text==null || $cli_other_cost_text=='null'){
                    
                }else{
                    foreach ($cli_other_cost_text as $i => $value) {
                        //array_push($arr_cli_other_cost_text,$request['cli_other_cost_text'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_text=$request['cli_other_cost_text'][$i];
                        }else{
                            $arr_cli_other_cost_text=$arr_cli_other_cost_text.','.$request['cli_other_cost_text'][$i];
                        }
                    }
                    foreach ($cli_other_cost_value as $i => $value) {
                        //array_push($arr_cli_other_cost_value,$request['cli_other_cost_value'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_value=$request['cli_other_cost_value'][$i];
                        }else{
                            $arr_cli_other_cost_value=$arr_cli_other_cost_value.','.$request['cli_other_cost_value'][$i];
                        }
                    }
                }
                $clientCost->other_cost_text =  $arr_cli_other_cost_text;
                $clientCost->other_cost_value =  $arr_cli_other_cost_value; 
                $clientCost->save();

                $inspectorCost = new InspectorCost();
                $inspectorCost->inspection_id =  $inspection->id;

                $ins_currency=$request['ins_currency'];
                $ins_md_charge=$request['ins_md_charge'];
                $ins_travel_cost=$request['ins_travel_cost'];
                $ins_hotel_cost=$request['ins_hotel_cost'];
                $ins_ot_cost=$request['ins_ot_cost'];
                if($ins_currency==null){$ins_currency="";}
                if($ins_md_charge==null){$ins_md_charge=0;}
                if($ins_travel_cost==null){$ins_travel_cost=0;}
                if($ins_hotel_cost==null){$ins_hotel_cost=0;}
                if($ins_ot_cost==null){$ins_ot_cost=0;}

                $inspectorCost->currency =  $ins_currency;
                $inspectorCost->md_charges =  $ins_md_charge;
                $inspectorCost->travel_cost =  $ins_travel_cost;
                $inspectorCost->hotel_cost =  $ins_hotel_cost;
                $inspectorCost->ot_cost =  $ins_ot_cost; 
                $ins_other_cost_text =  $request['ins_other_cost_text']; 
                $ins_other_cost_value =  $request['ins_other_cost_value']; 
                $arr_ins_other_cost_text=null;
                $arr_ins_other_cost_value=null;

                if($ins_other_cost_text==null || $ins_other_cost_text=='null'){

                }else{
                    foreach ($ins_other_cost_text as $i => $value) {
                        //array_push($arr_ins_other_cost_text,$request['ins_other_cost_text'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_text=$request['ins_other_cost_text'][$i];
                        }else{
                            $arr_ins_other_cost_text=$arr_ins_other_cost_text.','.$request['ins_other_cost_text'][$i];
                        }

                    }
                    foreach ($ins_other_cost_value as $i => $value) {
                        //array_push($ins_other_cost_value,$request['ins_other_cost_value'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_value=$request['ins_other_cost_value'][$i];
                        }else{
                            $arr_ins_other_cost_value=$arr_ins_other_cost_value.','.$request['ins_other_cost_value'][$i];
                        }
                    }
                }
                $inspectorCost->other_cost_text =  $arr_ins_other_cost_text;
                $inspectorCost->other_cost_value =  $arr_ins_other_cost_value; 
                $inspectorCost->save();

                foreach ($products as $i => $value) {
                    $prods[$i] = new PSIProduct();
                    $prods[$i]->inspection_id = $inspection->id;
                    $prods[$i]->product_name = $request['product_name'][$i];
                    $prods[$i]->product_category = $request['product_category'][$i];
                    $prods[$i]->brand = $request['brand'][$i];
                    $prods[$i]->po_no = $request['po_number'][$i];
                    $prods[$i]->model_no = $request['model_no'][$i];
                    $prods[$i]->product_unit = $request['p_unit'][$i];
                    $prods[$i]->cmf = null;
                    $prods[$i]->tech_specs = null;
                    $prods[$i]->shipping_mark = null;
                    $prods[$i]->additional_product_info = $request['prod_addtl_info'][$i];
                    $prods[$i]->aql_qty = $request['aql_qty'][$i];
                    $prods[$i]->aql_qty_unit = $request['aql_qty_unit'][$i];
                    $prods[$i]->aql_normal_level = $request['aql_normal_level'][$i];
                    $prods[$i]->aql_special_level = $request['aql_special_level'][$i];
                    $prods[$i]->aql_major = $request['aql_major'][$i];
                    $prods[$i]->max_allowed_major = $request['max_major'][$i];
                    $prods[$i]->aql_minor = $request['aql_minor'][$i];
                    $prods[$i]->max_allowed_minor = $request['max_minor'][$i];
                    $prods[$i]->aql_normal_letter = $request['aql_normal_letter'][$i];
                    $prods[$i]->aql_normal_sampsize = $request['aql_normal_sampsize'][$i];
                    $prods[$i]->aql_special_letter = $request['aql_special_letter'][$i];
                    $prods[$i]->aql_special_sampsize = $request['aql_special_sampsize'][$i];
                    $prods[$i]->save();

                }

                //blank report details
            
                

                if($request['has_file']=='false' || $request['has_file']==false){

                }else{
                    foreach ($request->file('file') as $file) {
                        $filename = $file->getClientOriginalName();
                        $filename=str_replace("#","_",$filename);

                        //directory
                        $dir="images/project2/".$inserted_inspection_id."/";

                        //move the files to the correct folder
                        if (!File::exists($dir)) {
                            File::makeDirectory($dir, 0777, true, true);
                        }
                        
                    
                        //save details to db
                        $doc= new Attachment();
                        $doc->inspection_id = $inserted_inspection_id;
                        $doc->project_number = $request['reference_number'];
                        $doc->file_name = $filename;
                        $doc->file_size = $file->getSize();
                        //$doc->file_size = 56716;
                        $doc->path = $dir.$filename;
                        $doc->save();
						
						$file->move($dir,$filename);
                    }
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                $password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];

                $report = new Report();
                $report->inspection_id = $inspection->id;
                $report->client_code = $client->client_code;
                $report->service = $this->service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->report_no = $report_no;
                $report->password = $password;
                $report->inspector_id=$request['inspector'];
                DB::commit();
                return response()->json([
                    'message' => 'OK',
                ],200);
            }
            
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    public function updateInspectionPsiDataFromDraft(Request $request){
        DB::beginTransaction();
        try {
            //$inspection = new Inspection();
            
            $inspection = Inspection::find($request['edit_inspection_id']);
            //inspection details
            $inspection->client_id = $request['client'];
            $inspection->contact_person = $request['contact_person'];
            //supplier details
            $inspection->supplier = $request['supplier'];
            $inspection->supplier_contact_person = $request['supplier_contact_person'];
            //factory details
            $inspection->factory = $request['factory'];
            $inspection->factory_contact_person = $request['factory_contact_person'];

            $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

            //inspection details
            $inspection->inspector_id = $request['inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->manday = $request['manday'];
            $inspection->inspection_date = $request['inspection_date'];
            $inspection->inspection_date_to = $request['inspection_date_to'];
            $inspection->service = $request['service'];
            $inspection->reference_number = $request['reference_number'];
            $inspection->client_project_number = $request['client_project_number'];

            $inspection->percentageFriSpk = $request['percentageSpkFri'];

            $inspection->requirement = $request['requirement'];
            $inspection->memo = $request['memo'];
            $template=$request['template'];
            if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}

            $report_template=$request['report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}
            $inspection->word_template = null;
            
            $inspection->template_id = $template;
            $inspection->project_type = $request['type_of_project'];


            $inspection->inspection_status = "Pending";
            $inspection->created_by =  Auth::id();


            

            if ($inspection->save()) {

                $clientCost = ClientCost::find($request['client_cost_id']);
                $clientCost->currency =  $request['cli_currency'];
                $clientCost->md_charges =  $request['cli_md_charge'];
                $clientCost->travel_cost =  $request['cli_travel_cost'];
                $clientCost->hotel_cost =  $request['cli_hotel_cost'];
                $clientCost->ot_cost =  $request['cli_ot_cost']; 
                $cli_other_cost_text =  $request['cli_other_cost_text']; 
                $cli_other_cost_value =  $request['cli_other_cost_value']; 
                $arr_cli_other_cost_text=null;
                $arr_cli_other_cost_value=null;
                if($cli_other_cost_text==null || $cli_other_cost_text=='null'){
                    
                }else{
                    foreach ($cli_other_cost_text as $i => $value) {
                        //array_push($arr_cli_other_cost_text,$request['cli_other_cost_text'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_text=$request['cli_other_cost_text'][$i];
                        }else{
                            $arr_cli_other_cost_text=$arr_cli_other_cost_text.','.$request['cli_other_cost_text'][$i];
                        }
                    }
                    foreach ($cli_other_cost_value as $i => $value) {
                        //array_push($arr_cli_other_cost_value,$request['cli_other_cost_value'][$i]);
                        if($i==0){
                            $arr_cli_other_cost_value=$request['cli_other_cost_value'][$i];
                        }else{
                            $arr_cli_other_cost_value=$arr_cli_other_cost_value.','.$request['cli_other_cost_value'][$i];
                        }
                    }
                }
                $clientCost->other_cost_text =  $arr_cli_other_cost_text;
                $clientCost->other_cost_value =  $arr_cli_other_cost_value; 
                $clientCost->save();

                $inspectorCost = InspectorCost::find($request['inspector_cost_id']);
                $inspectorCost->currency =  $request['ins_currency'];
                $inspectorCost->md_charges =  $request['ins_md_charge'];
                $inspectorCost->travel_cost =  $request['ins_travel_cost'];
                $inspectorCost->hotel_cost =  $request['ins_hotel_cost'];
                $inspectorCost->ot_cost =  $request['ins_ot_cost']; 
                $ins_other_cost_text =  $request['ins_other_cost_text']; 
                $ins_other_cost_value =  $request['ins_other_cost_value']; 
                $arr_ins_other_cost_text=null;
                $arr_ins_other_cost_value=null;

                if($ins_other_cost_text==null || $ins_other_cost_text=='null'){

                }else{
                    foreach ($ins_other_cost_text as $i => $value) {
                        //array_push($arr_ins_other_cost_text,$request['ins_other_cost_text'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_text=$request['ins_other_cost_text'][$i];
                        }else{
                            $arr_ins_other_cost_text=$arr_ins_other_cost_text.','.$request['ins_other_cost_text'][$i];
                        }

                    }
                    foreach ($ins_other_cost_value as $i => $value) {
                        //array_push($ins_other_cost_value,$request['ins_other_cost_value'][$i]);
                        if($i==0){
                            $arr_ins_other_cost_value=$request['ins_other_cost_value'][$i];
                        }else{
                            $arr_ins_other_cost_value=$arr_ins_other_cost_value.','.$request['ins_other_cost_value'][$i];
                        }
                    }
                }
                $inspectorCost->other_cost_text =  $arr_ins_other_cost_text;
                $inspectorCost->other_cost_value =  $arr_ins_other_cost_value; 
                $inspectorCost->save();
              
                $inserted_inspection_id=$request['edit_inspection_id'];
               
                if($request['hidden_product_id']!=null || $request['hidden_product_id']!=''){
                    $products = $request['product_name'];
                    foreach ($products as $i => $value) {                       
                        $prods[$i] = PSIProduct::find($request['hidden_product_id'][$i]);
                        $prods[$i]->product_name = $request['product_name'][$i];
                        $prods[$i]->product_category = $request['product_category'][$i];
                        $prods[$i]->brand = $request['brand'][$i];
                        $prods[$i]->po_no = $request['po_number'][$i];
                        $prods[$i]->model_no = $request['model_no'][$i];
                        $prods[$i]->product_unit = $request['p_unit'][$i];
                        $prods[$i]->cmf = $request['cmf'][$i];
                        $prods[$i]->tech_specs = $request['technical'][$i];
                        $prods[$i]->shipping_mark = $request['shipping'][$i];
                        $prods[$i]->additional_product_info = $request['prod_addtl_info'][$i];
                        $prods[$i]->aql_qty = $request['aql_qty'][$i];                       
                        $prods[$i]->save();   
                    }
                }

                if($request['is_new_product_added']==0 || $request['is_new_product_added']=='0'){

                }
                else{
                    $new_product = $request['new_product_name'];
                    foreach ($new_product as $i => $value) {
                        $prods[$i] = new PSIProduct();
                        $prods[$i]->inspection_id = $inserted_inspection_id;
                        $prods[$i]->product_name = $request['new_product_name'][$i];
                        $prods[$i]->product_category = $request['new_product_category'][$i];
                        $prods[$i]->brand = $request['new_brand'][$i];
                        $prods[$i]->po_no = $request['new_po_number'][$i];
                        $prods[$i]->model_no = $request['new_model_no'][$i];
                        $prods[$i]->aql_qty = $request['new_aql_qty'][$i];
                        $prods[$i]->aql_normal_level = $request['new_aql_normal_level'][$i];
                        $prods[$i]->aql_special_level = $request['new_aql_special_level'][$i];
                        $prods[$i]->aql_major = $request['new_aql_major'][$i];
                        $prods[$i]->max_allowed_major = $request['new_max_major'][$i];
                        $prods[$i]->aql_minor = $request['new_aql_minor'][$i];
                        $prods[$i]->max_allowed_minor = $request['new_max_minor'][$i];
                        $prods[$i]->aql_normal_letter = $request['new_aql_normal_letter'][$i];
                        $prods[$i]->aql_normal_sampsize = $request['new_aql_normal_sampsize'][$i];
                        $prods[$i]->aql_special_letter = $request['new_aql_special_letter'][$i];
                        $prods[$i]->aql_special_sampsize = $request['new_aql_special_sampsize'][$i];
                        $prods[$i]->save();
                    }
                }
            

                if($request['has_file']=='false' || $request['has_file']==false){

                }else{
                    foreach ($request->file('file') as $file) {
                        $filename = $file->getClientOriginalName();
                        $filename=str_replace("#","_",$filename);

                        //directory
                        $dir="images/project2/".$inserted_inspection_id."/";

                        //move the files to the correct folder
                        if (!File::exists($dir)) {
                            File::makeDirectory($dir, 0777, true, true);
                        }
                        
                    
                        //save details to db
                        $doc= new Attachment();
                        $doc->inspection_id = $inserted_inspection_id;
                        $doc->project_number = $request['reference_number'];
                        $doc->file_name = $filename;
                        $doc->file_size = $file->getSize();
                        $doc->path = $dir.$filename;
                        $doc->save();
						
						$file->move($dir,$filename);
                    }
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                $password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];


                $report_id = Report::where('inspection_id',$inserted_inspection_id)->first();

                $report = Report::find($report_id->id);
                /* $report->inspection_id = $inspection->id; */
                $report->client_code = $client->client_code;
                $report->service = $this->service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->report_no = $report_no;
                $report->password = $password;
                $report->inspector_id=$request['inspector'];
                DB::commit();
                return response()->json([
                    'message' => 'OK',
                ],200);
            }
            
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }
}
