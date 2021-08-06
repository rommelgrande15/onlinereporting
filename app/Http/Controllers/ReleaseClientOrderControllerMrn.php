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


class ReleaseClientOrderControllerMrn extends Controller
{
    public function getInspectionProjectFormClientOrder($inspection_id){
        $role = User::where('id',Auth::id())->first();
        $clients = Client::all();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        //inspector
        $inspectors = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->pluck('name','user_id');
        $inspector_list = UserInfo::where('designation','inspector')->where('status',0)->orderBy('name','asc')->get();
        //templates
        //$templates = Template::where('identifier',1)->orderBy('created_at','desc')->pluck('name','id');
        //$templates = Template::select('id','name')->where('identifier', 1)->orderBy('created_at','desc')->pluck('name','id');
        //04-30-2021
        $templates = Template::select('id','name')->where('identifier', 1)
        ->orderBy('created_at','desc')
        ->get();
        $inspection_details = DB::table('inspections')
                    ->join('clients','clients.client_code', '=', 'inspections.client_id')
                    ->join('users','inspections.inspector_id', '=', 'users.id')
                    ->join('user_infos','users.id', '=', 'user_infos.user_id')
                    ->join('client_contacts','inspections.contact_person', '=', 'client_contacts.id')
                    ->join('factories','inspections.factory', '=', 'factories.id')
                    ->join('fctory_contacts','inspections.factory_contact_person', '=', 'fctory_contacts.id')
                    ->join('p_s_i_products','inspections.id', '=', 'p_s_i_products.inspection_id')
                    ->select('inspections.*','inspections.factory_contact_person AS fac_con_per','inspections.contact_person AS con_per','inspections.id AS inspec_id','clients.client_name','users.*','user_infos.*','client_contacts.*','factories.*','fctory_contacts.*','p_s_i_products.*')
                    ->where('inspections.id',$inspection_id)                    
                    ->first(); 
        $client_code=$inspection_details->client_id;
        $inspection_new = DB::table('inspections')
                    ->where('id',$inspection_id)                    
                    ->first(); 
        $contact_person_list=explode(',',$inspection_new->contact_person);

        //06-03-2021
        $inspection_mrn = $inspection_details->mrn_no;
        $inspection_multiple = Inspection::where('mrn_no',$inspection_mrn)->select('id')->get();  
        $new_data = json_decode($inspection_multiple, true);  
        $reports = Report::whereIn('inspection_id',$new_data)->select('id','service')->get(); 

        //suppplier
        $supplier_list = Supplier::where('supplier_status','!=',2)->where('client_code',$client_code)->orderBy('supplier_name', 'asc')->pluck('supplier_name','id');
        $supplier_info = Supplier::where('id',$inspection_details->supplier_id)->first();
        $supplier_con_list = SupplierContact::where('supplier_id',$inspection_details->supplier_id)->orderBy('supplier_contact_person','asc')->pluck('supplier_contact_person','id');
        $supplier_con_info = SupplierContact::where('id',$inspection_details->supplier_contact_id)->first();
        //factory
        $get_factory = Factory::where('id',$inspection_new->factory)->first();
        $get_fc = FctoryContact::where('id',$inspection_new->factory_contact_person)->first();
        $factory_list = Factory::where('supplier_id',$inspection_new->supplier_id)->orderBy('factory_name','asc')->pluck('factory_name','id');
        $factory_con_list = FctoryContact::where('factory_id',$inspection_new->factory)->orderBy('factory_contact_person','asc')->pluck('factory_contact_person','id');
        //
        $client_contacts  = ClientContact::where('client_code',$client_code)->get();
        $inspector_info = UserInfo::where('user_id',$inspection_details->inspector_id)->first();
        //product
        $products = Product::where('client_code',$client_code)->where('status',0)->orderBy('product_name', 'asc')->pluck('product_name','id');
        // $psi_product = PSIProduct::where('inspection_id',$inspection_id)->get();
        //06-03-2021
        $psi_product = PSIProduct::where('p_s_i_products.mrn_no',$inspection_mrn)
            ->join('inspections','inspections.id','=','p_s_i_products.inspection_id')
            ->select('inspections.*','p_s_i_products.*')
            ->where('inspections.mrn_no','!=' ,"")
            ->where('p_s_i_products.mrn_no', '!=', "")
            ->get();

        $attach_count=0;
        $attach_arr=array();
        foreach($psi_product as $pp){
            $product_attachment=DB::table('product_photos')->where('product_id',$pp->product_id)->get();
            $attach_count=count($product_attachment);
            $attach_arr[$pp->product_id] = $attach_count;  
        }

        $client_contact = ClientContact::where('client_code',$client_code)->orderBy('contact_person','asc')->pluck('contact_person','id');
        $get_cc = ClientContact::where('id',$inspection_new->contact_person)->first();


        $client_cost = ClientCost::where('inspection_id',$inspection_id)->first();
        $client_other_cost_text="";
        $client_other_cost_val="";
        if($client_cost){
            $client_other_cost_text=explode(',',$client_cost->other_cost_text);
            $client_other_cost_val=explode(',',$client_cost->other_cost_value);
        }

       
        $client_other_cost_array=array();
        if($client_other_cost_text){
            $count_text_cost=count($client_other_cost_text);
            for($i=0; $i<$count_text_cost; $i++){
                $client_other_cost_array[$client_other_cost_text[$i]] = $client_other_cost_val[$i];
            }
        }

        $inspector_cost = InspectorCost::where('inspection_id',$inspection_id)->first();
        $ins_other_cost_text="";
        $ins_other_cost_val="";
        if($inspector_cost){
            $ins_other_cost_text=explode(',',$inspector_cost->other_cost_text);
            $ins_other_cost_val=explode(',',$inspector_cost->other_cost_value);
        }
        $ins_other_cost_array=array();
        if($ins_other_cost_text){
            $count_ins_text_cost=count($ins_other_cost_text);
            for($i=0; $i<$count_ins_text_cost; $i++){
                $ins_other_cost_array[$ins_other_cost_text[$i]] = $ins_other_cost_val[$i];
            }
        }
        $currency = [
            'usd' => '($) Us Dollar',
            'eur' => '(€) Euro',
            'gbp' => '(£) British Pound',
            'inr' => '(₹) Indian Rupee',
            'myr' => '(RM) Malaysian Ringgit',
            'cny' => '(¥) Chinese Yuan Renminbi'
        ];

        $services=[
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
        //product category    
        $p_category=array();

        $p_category=['Accessories / components'=>'Accessories / components'
        ,'Apparel'=>'Apparel'
        ,'Automotive Parts'=>'Automotive Parts'
        ,'Bag and case'=>'Bag and case'
        ,'Beauty / hairdressing and personal care appliance'=>'Beauty / hairdressing and personal care appliance'
        ,'Chemical Products'=>'Chemical Products'
        ,'Construction and Mechanical Products'=>'Construction and Mechanical Products'
        ,'Consumer Electronics'=>'Consumer Electronics'
        ,'Fans'=>'Fans'
        ,'Furniture'=>'Furniture'
        ,'Garden'=>'Garden'
        ,'Garment'=>'Garment'
        ,'Garment accessories'=>'Garment accessories'
        ,'Gifts and Promo Items'=>'Gifts and Promo Items'
        ,'Healthcare and Beauty'=>'Healthcare and Beauty'
        ,'Home Appliances'=>'Home Appliances'
        ,'Homeware'=>'Homeware'
        ,'Hometextile'=>'Hometextile'
        ,'Hotel Supplies'=>'Hotel Supplies'
        ,'Kitchen Appliances'=>'Kitchen Appliances'
        ,'Lightning'=>'Lightning'
        ,'Machinery Parts/Products'=>'Machinery Parts/Products'
        ,'Multimedia'=>'Multimedia'
        ,'Outdoor and Sports Products'=>'Outdoor and Sports Products'
        ,'Pet Products'=>'Pet Products'
        ,'Power tools'=>'Power tools'
        ,'Printing and Packaging'=>'Printing and Packaging'
        ,'Shoes'=>'Shoes'
        ,'Stationery and Luggage Products'=>'Stationery and Luggage Products'
        ,'Toys / Recreational Items'=>'Toys / Recreational Items'];
        $cat_arr=array();
        $p_categories  = SavedProductCategories::where('user_id',$inspection_details->client_book_id)->get();
        foreach($p_categories as $cat){
            $p_category += [$cat->category => $cat->category];
        }
        ksort($p_category);
        $p_category += ['Others' => 'Others'];

        $aql_options =[
            "0.065"=> "0.065",
            "0.10"=> "0.10",
            "0.15"=> "0.15",
            "0.25"=> "0.25",
            "0.4"=> "0.4",
            "0.65"=> "0.65",
            "1"=> "1.0",
            "1.5"=> "1.5",
            "2.5"=> "2.5",
            "4"=> "4.0",
            "6.5"=> "6.5",
            "10"=> "10.0"
        ];
        $normal=['I'=>'I','II'=>'II','III'=>'III','Special'=>'Special','N/A'=>'N/A'];
        $special=['S1'=>'S1','S2'=>'S2','S3'=>'S3','S4'=>'S4','Special'=>'Special','N/A'=>'N/A'];
        $aql_major = ['0.065'=>'0.065','0.1'=>'0.1','0.15'=>'0.15','0.25'=>'0.25','0.40'=>'0.40','1'=>'1','1.5'=>'1.5','2.5'=>'2.5','4'=>'4','6.5'=>'6.5','10'=>'10'];
        $units=['piece'=>'Piece/s','roll'=>'Roll/s','set'=>'Set/s','pair'=>'Pair/s','box'=>'Box/es','kg'=>'Kilogram/s'];
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();
        return view('pages.admin.release-order.index_mrn',compact('clients','role','user_info','inspectors','templates','inspection_details','client_contacts',
        'inspector_info','psi_product','client_contact','contact_person_list','currency','client_cost','inspector_cost','client_other_cost_text',
        'client_other_cost_val','ins_other_cost_text','ins_other_cost_val','client_other_cost_array','ins_other_cost_array','inspector_list','services',
        'supplier_list','supplier_info','supplier_con_list','supplier_con_info','p_category','get_cc','get_factory','get_fc','factory_list',
        'factory_con_list','client_code','products','attach_arr','aql_options','normal','special','aql_major','units','new_client_count','new_post_client',
        'new_post_client_sera','inspection_multiple','reports'));
    }

    public function getInspectionProjectFormLoadingClientOrder($inspection_id){
        $role = User::where('id',Auth::id())->first();
        $clients = Client::all();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        //inspector
        $inspectors = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->pluck('name','user_id');
        $inspector_list = UserInfo::where('designation','inspector')->where('status',0)->orderBy('name','asc')->get();
        //templates
        // $templates = Template::where('identifier',1)->orderBy('created_at','desc')->pluck('name','id');
        //04-30-2021
        $templates = Template::select('id','name')->where('identifier', 1)
        ->orderBy('created_at','desc')
        ->get();
        
        $inspections = DB::table('inspections')
                    ->where('id',$inspection_id)                    
                    ->first(); 
        $client_code=$inspections->client_id;
        $contact_person_list=explode(',',$inspections->contact_person);

        //suppplier
        $supplier_list = Supplier::where('supplier_status','!=',2)->where('client_code',$client_code)->orderBy('supplier_name', 'asc')->pluck('supplier_name','id');
        $supplier_info = Supplier::where('id',$inspections->supplier_id)->first();
        $supplier_con_list = SupplierContact::where('supplier_id',$inspections->supplier_id)->orderBy('supplier_contact_person','asc')->pluck('supplier_contact_person','id');
        $supplier_con_info = SupplierContact::where('id',$inspections->supplier_contact_id)->first();
        //factory
        $get_factory = Factory::where('id',$inspections->factory)->first();
        $get_fc = FctoryContact::where('id',$inspections->factory_contact_person)->first();
        $factory_list = Factory::where('supplier_id',$inspections->supplier_id)->orderBy('factory_name','asc')->pluck('factory_name','id');
        $factory_con_list = FctoryContact::where('factory_id',$inspections->factory)->orderBy('factory_contact_person','asc')->pluck('factory_contact_person','id');
        //
        $client_contacts  = ClientContact::where('client_code',$client_code)->get();
        $inspector_info = UserInfo::where('user_id',$inspections->inspector_id)->first();


        $client_contact = ClientContact::where('client_code',$client_code)->orderBy('contact_person','asc')->pluck('contact_person','id');
        $get_cc = ClientContact::where('id',$inspections->contact_person)->first();


        $client_cost = ClientCost::where('inspection_id',$inspection_id)->first();
        $client_other_cost_text="";
        $client_other_cost_val="";
        if($client_cost){
            $client_other_cost_text=explode(',',$client_cost->other_cost_text);
            $client_other_cost_val=explode(',',$client_cost->other_cost_value);
        }

       
        $client_other_cost_array=array();
        if($client_other_cost_text){
            $count_text_cost=count($client_other_cost_text);
            for($i=0; $i<$count_text_cost; $i++){
                $client_other_cost_array[$client_other_cost_text[$i]] = $client_other_cost_val[$i];
            }
        }

        $inspector_cost = InspectorCost::where('inspection_id',$inspection_id)->first();
        $ins_other_cost_text="";
        $ins_other_cost_val="";
        if($inspector_cost){
            $ins_other_cost_text=explode(',',$inspector_cost->other_cost_text);
            $ins_other_cost_val=explode(',',$inspector_cost->other_cost_value);
        }
        $ins_other_cost_array=array();
        if($ins_other_cost_text){
            $count_ins_text_cost=count($ins_other_cost_text);
            for($i=0; $i<$count_ins_text_cost; $i++){
                $ins_other_cost_array[$ins_other_cost_text[$i]] = $ins_other_cost_val[$i];
            }
        }
        $currency = [
            'usd' => '($) Us Dollar',
            'eur' => '(€) Euro',
            'gbp' => '(£) British Pound',
            'inr' => '(₹) Indian Rupee',
            'myr' => '(RM) Malaysian Ringgit',
            'cny' => '(¥) Chinese Yuan Renminbi'
        ];

        $services=[
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

        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();
        return view('pages.admin.release-order.index_cbpi',compact('clients','role','user_info','inspectors','templates','client_contacts','inspector_info','client_contact','contact_person_list','currency','client_cost','inspector_cost','client_other_cost_text','client_other_cost_val','ins_other_cost_text','ins_other_cost_val','client_other_cost_array','ins_other_cost_array','inspector_list','services','supplier_list','supplier_info','supplier_con_list','supplier_con_info','get_cc','get_factory','get_fc','factory_list','factory_con_list','client_code','inspections','new_client_count','new_post_client','new_post_client_sera'));
    }

    //client release order
    public function releaseClientOrder(Request $request){
        DB::beginTransaction();
        try {
            //$inspection = new Inspection();    
            // $inspection = Inspection::find($request['edit_inspection_id']);
            $mrn_inspection_id = $request['mrn_inspection_id'];
            $inspections = Inspection::whereIn('id',$mrn_inspection_id)->get();
            foreach($inspections as $inspection){
                //inspection details
                $inspection->client_id = $request['client'];
                $inspection->contact_person = $request['contact_person'];
                //factory details
                $inspection->factory = $request['factory'];
                $inspection->factory_contact_person = $request['factory_contact_person'];
                

                $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

                //inspection details
                $inspection->inspector_id = $request['inspector'];
                $inspection->secondary_inspector_id = $request['second_inspector'];
                $manday = number_format((float)$request['manday'], 1);
                $inspection->manday = $manday;
                $inspection->inspection_date = $request['inspection_date'];
                $inspection->inspection_date_to = $request['inspection_date_to'];
                $inspection->service = $request['service'];
                $inspection->reference_number = $inspection->reference_number;
                $inspection->client_project_number = $request['client_project_number'];

                $inspection->percentageFriSpk = $request['percentageSpkFri'];

                $inspection->requirement = $request['requirement'];
                $inspection->memo = $request['memo'];
                $template=$request['template'];
                $template_word=$request['template_word'];
                // if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}
                if($template=="" || $request['type_of_project']=="esprit"){$template=0;}

                //04-30-2021
                if($template_word ==""){$template_word=0;}

                $report_template=$request['report_template'];
                if($report_template=="" || $report_template=='N/A'){$report_template=null;}

                $inspection->word_template = null;

                
                //$inspection->template_id = $template;
                $inspection->project_type = $request['type_of_project'];
                $project_type = $request['type_of_project'];
                //04-30-2021
                if($project_type == "word_project"){
                    $inspection->template_id = $template_word;
                }else{
                    $inspection->template_id = $template;
                }

                $inspection->created_by =  Auth::id();

                $inspection->inspection_status = "Released";
                $inspection->save();
            }
            // if ($inspection->save()) {

                // $clientCost = ClientCost::find($request['client_cost_id']);
                $clientCosts = ClientCost::whereIn('inspection_id',$mrn_inspection_id)->get();
                foreach($clientCosts as $clientCost){
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
                }

                // $inspectorCost = InspectorCost::find($request['inspector_cost_id']);
                $inspectorCosts = InspectorCost::whereIn('inspection_id',$mrn_inspection_id)->get();
                foreach( $inspectorCosts as  $inspectorCost){
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
                }
                
                $inserted_inspection_id=$request['edit_inspection_id'];
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
                $products_id=array();
                $add_info=array();
                $item_description=array();

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
                    
                if($request['new_product_id']){
                    $new_products = $request['new_product_id'];
                    foreach ($new_products as $i => $value) {
                        $new_prod[$i] = new PSIProduct();
                        $new_prod[$i]->inspection_id = $inserted_inspection_id;
                        $new_prod[$i]->product_id = $request['new_product_id'][$i];
                        $new_prod[$i]->product_name = $request['new_product_name'][$i];
                        $new_prod[$i]->product_first_category = $request['new_product_category'][$i];
                        $new_prod[$i]->product_category = $request['new_product_sub_category'][$i];
                        $new_prod[$i]->brand = $request['new_brand'][$i];
                        $new_prod[$i]->po_no = $request['new_po_number'][$i];
                        $new_prod[$i]->model_no = $request['new_model_no'][$i];
                        $new_prod[$i]->additional_product_info = $request['new_addtl_info'][$i];
                        $new_prod[$i]->item_description = $request['new_item_description'][$i];
                        $new_prod[$i]->aql_qty = $request['new_aql_qty'][$i];
                        $new_prod[$i]->aql_qty_unit = $request['new_aql_qty_unit'][$i];
                        $new_prod[$i]->aql_normal_level = $request['new_aql_normal_level'][$i];
                        $new_prod[$i]->aql_special_level = $request['new_aql_special_level'][$i];
                        $new_prod[$i]->aql_major = $request['new_aql_major'][$i];
                        $new_prod[$i]->max_allowed_major = $request['new_max_major'][$i];
                        $new_prod[$i]->aql_minor = $request['new_aql_minor'][$i];
                        $new_prod[$i]->max_allowed_minor = $request['new_max_minor'][$i];
                        $new_prod[$i]->aql_normal_letter = $request['new_aql_normal_letter'][$i];
                        $new_prod[$i]->aql_normal_sampsize = $request['new_aql_normal_sampsize'][$i];
                        $new_prod[$i]->aql_special_letter = $request['new_aql_special_letter'][$i];
                        $new_prod[$i]->aql_special_sampsize = $request['new_aql_special_sampsize'][$i];
                        $new_prod[$i]->save();
                        array_push($products_id,$request['new_product_id'][$i]);
                        array_push($prod_name,$request['new_product_name'][$i]);
                        array_push($brand_arr,$request['new_brand'][$i]);
                        array_push($po_number_arr,$request['new_po_number'][$i]);
                        array_push($model_no_arr,$request['new_model_no'][$i]);
                        array_push($aql_qty_arr,$request['new_aql_qty'][$i]);
                        array_push($aql_normal_level_arr,$request['new_aql_normal_level'][$i].'/'.$request['new_aql_special_level'][$i]);
                        array_push($aql_special_level_arr,$request['new_aql_normal_sampsize'][$i].'/'. $request['new_aql_special_sampsize'][$i]);
                        array_push($aql_major_arr,$request['new_aql_major'][$i]);
                        array_push($max_major_arr,$request['new_max_major'][$i]);
                        array_push($aql_minor_arr,$request['new_aql_minor'][$i]);
                        array_push($max_minor_arr,$request['new_max_minor'][$i]);
                        array_push($add_info,$request['new_addtl_info'][$i]);
                        array_push($item_description,$request['new_item_description'][$i]);
                    }
                }
                

                if($request['edit_pid']){
                    $products_edit = $request['edit_pid'];
                    foreach ($products_edit as $i => $value) {
                        $prods[$i] = PSIProduct::find($request['edit_pid'][$i]);
                        // $prods[$i]->inspection_id = $inserted_inspection_id;
                        $prods[$i]->product_id = $request['product_id'][$i];
                        $prods[$i]->product_name = $request['product_name'][$i];
                        $prods[$i]->product_first_category = $request['product_category'][$i];
                        $prods[$i]->product_category = $request['product_sub_category'][$i];
                        $prods[$i]->brand = $request['brand'][$i];
                        $prods[$i]->po_no = $request['po_number'][$i];
                        $prods[$i]->model_no = $request['model_no'][$i];
                        $prods[$i]->item_description = $request['item_description'][$i];
                        $prods[$i]->additional_product_info = $request['addtl_info'][$i];
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
                        //$product = Product::find($request['edit_pid'][$i]);
                        array_push($products_id,$request['edit_pid'][$i]);
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
                        array_push($add_info,$request['addtl_info'][$i]);
                        array_push($item_description,$request['item_description'][$i]);
                    }
                }
                //blank report details
            
                $service = [
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
                if($request->file('file')){
                    $mrn_inspections = Inspection::whereIn('id',$mrn_inspection_id)
                        ->select('*')
                        ->get();
                    foreach($mrn_inspections as $mrn_id){
                        foreach ($request->file('file') as $file) {
                            //set a unique file name
                            //$filename = 'psi-'. $inserted_inspection_id . '-' . uniqid().'.'.$file->getClientOriginalExtension();
                            $filename = $file->getClientOriginalName();
                            $filename=str_replace("#","_",$filename);
                            
                            //directory
                            $dir="images/project2/".$mrn_id->id."/";
                            
                            //move the files to the correct folder
                            if (!File::exists($dir)) {
                                File::makeDirectory($dir, 0777, true, true);
                            }
                            
                            //push file name in array
                            array_push($upload_file_name,$dir.$filename);
                        
                                $doc= new Attachment();
                                $doc->inspection_id = $mrn_id->id;
                                $doc->project_number = $mrn_id->reference_number; 
                                $doc->file_name = $filename;
                                // $doc->file_size = $file->getSize();
                                $doc->file_size = 56716;
                                $doc->path = $dir.$filename;
                                $doc->uploaded_by = 'booking';
                                $doc->save();
                            
                                $inserted_inspection_id2 = $mrn_id->id-1;
                                $dir2="images/project2/".$inserted_inspection_id2."/";
                            if(File::exists($dir2.$filename)){
                                $inserted_inspection_id1 = $mrn_id->id-1;
                                $dir1="images/project2/".$inserted_inspection_id1."/";
                                $sourceFilePath= $dir1;
                                $destinationPath= $dir;
                                $success = File::copy($sourceFilePath.$filename,$destinationPath.$filename);
                            }
                            else{
                                $file->move($dir,$filename);
                            } 
                        }
                    }    
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                //$password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];


                // $report_id = Report::where('inspection_id',$inserted_inspection_id)->first();

                // $password = $report_id->password;

                $report_id = $request['report_id'];
                $reports = Report::whereIn('id',$report_id)->get();
                foreach($reports as $report){
                    // $report->inspection_id = $inspection->id;
                    $report->client_code = $client->client_code;
                    $report->service = $service[$request['service']];
                    $report->inspection_date = $request['inspection_date'];
                    // $report->report_no = $report_no;
                    // $report->password = $password;
                    $report->inspector_id=$request['inspector'];
                    $report->save();
                }   
                
                // if ($report->save()) {

                    $insp_details = Inspection::where('id',$inserted_inspection_id)->first();
                    $fac_contact2=$insp_details->factory_contact_person2;

                    $secondary_inspector=$insp_details->secondary_inspector_id;
                    $second_inspector_email=[];
                    if(!empty($secondary_inspector) || $secondary_inspector!=null || $secondary_inspector!="null"){
                        $get_ids=explode(',',$secondary_inspector);
                        foreach($get_ids as $sec_ins_id){
                            $get_email=UserInfo::select('email_address')->where('user_id',$sec_ins_id)->first();
                            array_push($second_inspector_email,$get_email->email_address);
                            //'second_inspector_email' => $second_inspector_email,
                        }
                    }

                    $inspector_info = UserInfo::find($request['inspector']);
                    $inspector_cred = User::find($request['inspector']);
                    $factory = Factory::find($request['factory']);
                    $factory_contact = FctoryContact::find($request['factory_contact_person']);
                    $factory_contact_sec = FctoryContact::find($request['factory_contact_person2_psi']);
                    $psi_product_list = PSIProduct::where('inspection_id',$inserted_inspection_id)->get();
                    $product_list = Product::all();
                    $product_photos = DB::table('product_photos')->get(); 
                    
                    $booking_info = UserInfo::find(Auth::id());
                    $client_info = User::where('client_code',$request['client'])->first(); //jesser 111
                    
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
                    
                    $psi_product_mrn = DB::table('p_s_i_products')
                        ->join('inspections','p_s_i_products.inspection_id','=','inspections.id')
                        ->whereIn('p_s_i_products.inspection_id',$mrn_inspection_id)
                        ->select('p_s_i_products.*','inspections.reference_number')
                        ->get();

                    $reference_number_mrn = '';
        
                    foreach($psi_product_mrn as $rep){
                        $reference_number_mrn .= $rep->reference_number.',';
                        
                    }    

                    $reports = DB::table('reports')
                        ->join('users','reports.inspector_id','=','users.id')
                        ->whereIn('reports.inspection_id',$mrn_inspection_id)
                        ->select('reports.report_no','reports.password','users.username','users.plain')
                        ->get();  

                        if($request['type_of_project']=='word_project' || $request['type_of_project']=="esprit"){                     
                            $data = ['report_number' =>  $reference_number_mrn, 
                                'email' => $inspector_info->email_address,
                                'second_inspector_email' => $second_inspector_email,
                                'insp_name' => $inspector_info->name,
                                'insp_un' => $inspector_cred->username,
                                'insp_pw' => $inspector_cred->plain,
                                'manday'=>$manday,
                                'spk_fri'=>$request['percentageSpkFri'],
                                'file_passed'=>$upload_file_name,
                                'service'=>$service[$request['service']],
                                'ref_num'=>$request['reference_number'],
                                'inspection_date'=>$request['inspection_date'],
                                'inspection_date_to'=>$request['inspection_date_to'],
                                'factory_name'=>$factory->factory_name,
                                'factory_address' => $request['factory_address'],
                                'factory_address_local'=>$factory->factory_address_local,
                                'factory_contact'=>$factory_contact->factory_contact_person,
                                'client_number'=>$request['client_project_number'],
                                'requirement'=>$request['requirement'],
                                'psi_product_list'=>$psi_product_list,
                                'product_list'=>$product_list,
                                'psi_product_mrn'=>$psi_product_mrn,
                                'reports'=>$reports,
                                'product_photos'=>$product_photos,                      
                                'memo'=>$request['memo'],
                                'product_subject'=>$product_subject,
                                'book_email'=>$booking_info->email_address,
                                'fac_contact'=>$fac_contact,
                                'fac_email'=>$fac_email,
                                'fac_num'=>$fac_num,
                                'products_id'=>$products_id,
                                'client'=>$client->Company_Name,
                                'user_type'=>$client_info->user_type,
                                'client_email'=>$client_info->email];
                            $files_uploaded = $request->file('file');

                            Mail::send('email.manual_release_order_client',$data, function($message) use ($data){
                                // $message->to($data['client_email']);
                                // $message->bcc('it-support@t-i-c.asia');
                                // $message->bcc('gregor@t-i-c.asia');
                                // $message->bcc('report@t-i-c.asia');
                                // $message->bcc('booking@t-i-c.asia');
                                // $message->bcc('1249484103@qq.com');
                                // //$message->bcc('gregor.voege@web.de');
                                // $message->bcc('2891400188@qq.com');
                                $message->to('miguelbuojr@gmail.com');
                                $message->cc('it-support@t-i-c.asia');
                                $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");         
                            });

                            Mail::send('email.manual_release_order_mrn',$data, function($message) use ($data,$files_uploaded ){
                                // $message->to($data['email']);
                                // $message->cc('it-support@t-i-c.asia');
                                // $message->cc($data['book_email']);
                                // $message->cc('gregor@t-i-c.asia');
                                // $message->cc('report@t-i-c.asia');
                                // $message->cc('booking@t-i-c.asia');
                                // $message->cc('1249484103@qq.com');
                                // //$message->cc('gregor.voege@web.de');
                                // $message->cc('2891400188@qq.com');
                                $message->to('miguelbuojr@gmail.com');
                                $message->cc('it-support@t-i-c.asia');
                                //secondary inspector email
                                if(!empty($data['second_inspector_email'])){
                                    foreach ($data['second_inspector_email'] as $sec_email) {
                                        // $message->cc($sec_email);
                                    }
                                }
                                $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");
                                if($data['file_passed']){
                                    foreach ($data['file_passed'] as $file_name) {
                                        if($file_name=='email_attachment/ABD_1-5.pdf'){
                                            $message->attach($file_name);
                                        }
                                        
                                    }
                                }     
                                /* remove attachment 08/01/2020*/
                                /* if($data['products_id']){         
                                    foreach ($data['products_id'] as $pid) {
                                        $p_photos = DB::table('product_photos')->where('product_id',$pid)->get();
                                        if($p_photos){
                                            foreach ($p_photos as $p) {
                                                $p_src="js/dropzone/upload/".$p->photo_category."/".$p->user_id."/".$p->file_name;
                                                $message->attach($p_src);
                                            }   
                                        }
                                    }       
                                }  */           
                            });
                            Mail::send('email.login_details_geo',$data, function($message) use ($data,$files_uploaded ){
                                // $message->to($data['email']);
                                // $message->cc('it-support@t-i-c.asia');
                                // $message->cc($data['book_email']);
                                // $message->cc('gregor@t-i-c.asia');
                                // $message->cc('report@t-i-c.asia');
                                // $message->cc('booking@t-i-c.asia');
                                // $message->cc('1249484103@qq.com');
                                // //$message->cc('gregor.voege@web.de');
                                // $message->cc('2891400188@qq.com');
                                $message->to('miguelbuojr@gmail.com');
                                $message->cc('it-support@t-i-c.asia');
                                if(!empty($data['second_inspector_email'])){
                                    foreach ($data['second_inspector_email'] as $sec_email) {
                                        // $message->cc($sec_email);
                                    }
                                }
                                $message->subject('App Login Details for Report Number - '. $data['report_number']);                            
                              
                        
                            });
                            
                        }else{
                            $data = ['report_number' =>  $reference_number_mrn,
                                'inspection_date'=>$request['inspection_date'],
                                'email' => $inspector_info->email_address,
                                'second_inspector_email' => $second_inspector_email,
                                'insp_name' => $inspector_info->name,
                                'insp_un' => $inspector_cred->username,
                                'insp_pw' => $inspector_cred->plain,
                                'file_passed'=>$upload_file_name,
                                'requirement'=>$request['requirement'],
                                'psi_product_list'=>$psi_product_list,
                                'product_list'=>$product_list,
                                'psi_product_mrn'=>$psi_product_mrn,
                                'reports'=>$reports,
                                'product_photos'=>$product_photos,
                                'memo'=>$request['memo'],
                                'factory_name'=>$factory->factory_name,
                                'factory_address' => $request['factory_address'],
                                'input_factory_addres' => $request['factory_address'],
                                'factory_address_local'=>$factory->factory_address_local,
                                'factory_contact'=>$factory_contact->factory_contact_person,
                                'fac_contact'=>$fac_contact,
                                'fac_email'=>$fac_email,
                                'fac_num'=>$fac_num,
                                'book_email'=>$booking_info->email_address,
                                'products_id'=>$products_id,
                                'product_subject'=>$product_subject,
                                'client_number'=>$request['client_project_number'],
                                'client'=>$client->Company_Name,
                                'user_type'=>$client_info->user_type,
                                'client_email'=>$client_info->email];
                            $files_uploaded = $request->file('file');

                            Mail::send('email.manual_release_order_client',$data, function($message) use ($data){
                                // $message->to($data['client_email']);
                                // $message->bcc('it-support@t-i-c.asia');
                                // $message->bcc('gregor@t-i-c.asia');
                                // $message->bcc('report@t-i-c.asia');
                                // $message->bcc('booking@t-i-c.asia');                     
                                // $message->bcc('1249484103@qq.com');
                                // $message->bcc('gregor.voege@web.de');
                                // $message->bcc('2891400188@qq.com');
                                $message->to('miguelbuojr@gmail.com');
                                $message->cc('it-support@t-i-c.asia');
                                $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");         
                            });

                            Mail::send('email.download_release_order_mrn',$data, function($message) use ($data,$files_uploaded ){
                                // $message->to($data['email']);
                                // $message->cc('it-support@t-i-c.asia');
                                // $message->cc('gregor@t-i-c.asia');
                                // $message->cc('report@t-i-c.asia');
                                // $message->cc('booking@t-i-c.asia');
                                // $message->cc($data['book_email']);
                                // $message->cc('1249484103@qq.com');
                                // //$message->cc('gregor.voege@web.de');
                                // $message->cc('2891400188@qq.com');
                                $message->to('miguelbuojr@gmail.com');
                                $message->cc('it-support@t-i-c.asia');
                                //secondary inspector email
                                if(!empty($data['second_inspector_email'])){
                                    foreach ($data['second_inspector_email'] as $sec_email) {
                                        // $message->cc($sec_email);
                                    }
                                }
                                $message->subject('Download Blank Report for ' . $data['report_number']);
                                if($data['file_passed']){
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
                                }    
                                /*remove attachment 08/01/2020*/ 
                                /* if($data['products_id']){         
                                    foreach ($data['products_id'] as $pid) {
                                        $p_photos = DB::table('product_photos')->where('product_id',$pid)->get();
                                        if($p_photos){
                                            foreach ($p_photos as $p) {
                                                $p_src="js/dropzone/upload/".$p->photo_category."/".$p->user_id."/".$p->file_name;
                                                $message->attach($p_src);
                                            }   
                                        }
                                    }       
                                }    */               
                            });
                            Mail::send('email.login_details',$data, function($message) use ($data,$files_uploaded ){
                                // $message->to($data['email']);
                                // $message->cc('it-support@t-i-c.asia');
                                // $message->cc($data['book_email']);
                                // $message->cc('gregor@t-i-c.asia');
                                // $message->cc('report@t-i-c.asia');
                                // $message->cc('booking@t-i-c.asia');
                                // $message->cc('1249484103@qq.com');
                                // //$message->cc('gregor.voege@web.de');
                                // $message->cc('2891400188@qq.com');
                                $message->to('miguelbuojr@gmail.com');
                                $message->cc('it-support@t-i-c.asia');
                                if(!empty($data['second_inspector_email'])){
                                    foreach ($data['second_inspector_email'] as $sec_email) {
                                        // $message->cc($sec_email);
                                    }
                                }
                                $message->subject('App Login Details for Report Number - '. $data['report_number']);                            
                              
                        
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
              //  }
          //  }
            
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    //client release order
    public function holdClientOrder(Request $request){
        DB::beginTransaction();
        try {
            //$inspection = new Inspection();
            
            // $inspection = Inspection::find($request['edit_inspection_id']);
            $mrn_inspection_id = $request['mrn_inspection_id'];
            $inspections = Inspection::whereIn('id',$mrn_inspection_id)->get();
            foreach($inspections as $inspection){
                //inspection details
                $inspection->client_id = $request['client'];
                $inspection->contact_person = $request['contact_person'];
                //factory details
                $inspection->factory = $request['factory'];
                $inspection->factory_contact_person = $request['factory_contact_person'];

                $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

                //inspection details
                $inspection->inspector_id = $request['inspector'];
                $inspection->secondary_inspector_id = $request['second_inspector'];
                $manday = number_format((float)$request['manday'], 1);
                $inspection->manday = $manday;
                //$inspection->manday = $request['manday'];
                $inspection->inspection_date = $request['inspection_date'];
                $inspection->inspection_date_to = $request['inspection_date_to'];
                $inspection->service = $request['service'];
                $inspection->reference_number = $inspection->reference_number;
                $inspection->client_project_number = $request['client_project_number'];

                $inspection->percentageFriSpk = $request['percentageSpkFri'];

                $inspection->requirement = $request['requirement'];
                $inspection->memo = $request['memo'];
                $template=$request['template'];
                $template_word=$request['template_word'];
                // if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}
                if($template=="" || $request['type_of_project']=="esprit"){$template=0;}

                //05-05-2021
                if($template_word==""){$template_word=0;}

                $report_template=$request['report_template'];
                if($report_template=="" || $report_template=='N/A'){$report_template=null;}

                $inspection->word_template = null;

                $inspection->project_type = $request['type_of_project'];
                $project_type = $request['type_of_project'];
                //04-30-2021
                if($project_type == "word_project"){
                    $inspection->template_id = $template_word;
                }else{
                    $inspection->template_id = $template;
                }

                $inspection->created_by =  Auth::id();

                $inspection->inspection_status = "Hold";
                $inspection->save();
            }
            

            // if ($inspection->save()) {
                $clientCosts = ClientCost::whereIn('inspection_id',$mrn_inspection_id)->get();
                foreach($clientCosts as $clientCost){
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
                }
                
                $inspectorCosts = InspectorCost::whereIn('inspection_id',$mrn_inspection_id)->get();
                foreach($inspectorCosts as $inspectorCost){
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
                }
                
                
                $inserted_inspection_id=$request['edit_inspection_id'];
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
                $products_id=array();
                $add_info=array();
                $item_description=array();

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
                    
                if($request['new_product_id']){
                    $new_products = $request['new_product_id'];
                    foreach ($new_products as $i => $value) {
                        $new_prod[$i] = new PSIProduct();
                        $new_prod[$i]->inspection_id = $inserted_inspection_id;
                        $new_prod[$i]->product_id = $request['new_product_id'][$i];
                        $new_prod[$i]->product_name = $request['new_product_name'][$i];
                        $new_prod[$i]->product_first_category = $request['new_product_category'][$i];
                        $new_prod[$i]->product_category = $request['new_product_sub_category'][$i];
                        $new_prod[$i]->brand = $request['new_brand'][$i];
                        $new_prod[$i]->po_no = $request['new_po_number'][$i];
                        $new_prod[$i]->model_no = $request['new_model_no'][$i];
                        $new_prod[$i]->additional_product_info = $request['new_addtl_info'][$i];
                        $new_prod[$i]->item_description = $request['new_item_description'][$i];
                        $new_prod[$i]->aql_qty = $request['new_aql_qty'][$i];
                        $new_prod[$i]->aql_qty_unit = $request['new_aql_qty_unit'][$i];
                        $new_prod[$i]->aql_normal_level = $request['new_aql_normal_level'][$i];
                        $new_prod[$i]->aql_special_level = $request['new_aql_special_level'][$i];
                        $new_prod[$i]->aql_major = $request['new_aql_major'][$i];
                        $new_prod[$i]->max_allowed_major = $request['new_max_major'][$i];
                        $new_prod[$i]->aql_minor = $request['new_aql_minor'][$i];
                        $new_prod[$i]->max_allowed_minor = $request['new_max_minor'][$i];
                        $new_prod[$i]->aql_normal_letter = $request['new_aql_normal_letter'][$i];
                        $new_prod[$i]->aql_normal_sampsize = $request['new_aql_normal_sampsize'][$i];
                        $new_prod[$i]->aql_special_letter = $request['new_aql_special_letter'][$i];
                        $new_prod[$i]->aql_special_sampsize = $request['new_aql_special_sampsize'][$i];
                        $new_prod[$i]->save();
                        array_push($products_id,$request['new_product_id'][$i]);
                        array_push($prod_name,$request['new_new_product_name'][$i]);
                        array_push($brand_arr,$request['new_brand'][$i]);
                        array_push($po_number_arr,$request['new_po_number'][$i]);
                        array_push($model_no_arr,$request['new_model_no'][$i]);
                        array_push($aql_qty_arr,$request['new_aql_qty'][$i]);
                        array_push($aql_normal_level_arr,$request['new_aql_normal_level'][$i].'/'.$request['new_aql_special_level'][$i]);
                        array_push($aql_special_level_arr,$request['new_aql_normal_sampsize'][$i].'/'. $request['new_aql_special_sampsize'][$i]);
                        array_push($aql_major_arr,$request['new_aql_major'][$i]);
                        array_push($max_major_arr,$request['new_max_major'][$i]);
                        array_push($aql_minor_arr,$request['new_aql_minor'][$i]);
                        array_push($max_minor_arr,$request['new_max_minor'][$i]);
                        array_push($add_info,$request['new_addtl_info'][$i]);
                        array_push($item_description,$request['new_item_description'][$i]);
                    }
                }
                

                if($request['edit_pid']){
                    $products_edit = $request['edit_pid'];
                    foreach ($products_edit as $i => $value) {
                        $prods[$i] = PSIProduct::find($request['edit_pid'][$i]);
                        // $prods[$i]->inspection_id = $inserted_inspection_id;
                        $prods[$i]->product_id = $request['product_id'][$i];
                        $prods[$i]->product_name = $request['product_name'][$i];
                        $prods[$i]->product_first_category = $request['product_category'][$i];
                        $prods[$i]->product_category = $request['product_sub_category'][$i];
                        $prods[$i]->brand = $request['brand'][$i];
                        $prods[$i]->po_no = $request['po_number'][$i];
                        $prods[$i]->model_no = $request['model_no'][$i];
                        $prods[$i]->additional_product_info = $request['addtl_info'][$i];
                        $prods[$i]->item_description = $request['item_description'][$i];
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
                        //$product = Product::find($request['edit_pid'][$i]);
                        array_push($products_id,$request['edit_pid'][$i]);
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
                        array_push($add_info,$request['addtl_info'][$i]);
                        array_push($item_description,$request['item_description'][$i]);
                    }
                }
                //blank report details
            
                $service = [
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
                if($request->file('file')){
                    $mrn_inspections = Inspection::whereIn('id',$mrn_inspection_id)
                        ->select('*')
                        ->get();
                    foreach($mrn_inspections as $mrn_id){
                        foreach ($request->file('file') as $file) {
                            //set a unique file name
                            //$filename = 'psi-'. $inserted_inspection_id . '-' . uniqid().'.'.$file->getClientOriginalExtension();
                            $filename = $file->getClientOriginalName();
                            $filename=str_replace("#","_",$filename);
                            
                            //directory
                            $dir="images/project2/".$mrn_id->id."/";
                            
                            //move the files to the correct folder
                            if (!File::exists($dir)) {
                                File::makeDirectory($dir, 0777, true, true);
                            }
                            
                            //push file name in array
                            array_push($upload_file_name,$dir.$filename);
                        
                            //save details to db
                            $doc= new Attachment();
                            $doc->inspection_id = $mrn_id->id;
                            $doc->project_number = $mrn_id->reference_number; 
                            $doc->file_name = $filename;
                            // $doc->file_size = $file->getSize();
                            $doc->file_size = 56716;
                            $doc->path = $dir.$filename;
                            $doc->uploaded_by = 'booking';
                            $doc->save();
                        
                            $inserted_inspection_id2 = $mrn_id->id-1;
                            $dir2="images/project2/".$inserted_inspection_id2."/";
                        if(File::exists($dir2.$filename)){
                            $inserted_inspection_id1 = $mrn_id->id-1;
                            $dir1="images/project2/".$inserted_inspection_id1."/";
                            $sourceFilePath= $dir1;
                            $destinationPath= $dir;
                            $success = File::copy($sourceFilePath.$filename,$destinationPath.$filename);
                        }
                        else{
                            $file->move($dir,$filename);
                        } 
                        }
                    }    
                    
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                //$password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];

                $report_id = $request['report_id'];
                $reports = Report::whereIn('id',$report_id)->get();
                foreach($reports as $report){
                    $report->client_code = $client->client_code;
                    $report->service = $service[$request['service']];
                    $report->inspection_date = $request['inspection_date'];
                    $report->inspector_id=$request['inspector'];
                    $report->save();
                }
                
                
                // if ($report->save()) {

                    $insp_details = Inspection::where('id',$inserted_inspection_id)->first();
                    $fac_contact2=$insp_details->factory_contact_person2;

                    $inspector_info = UserInfo::find($request['inspector']);
                    $inspector_cred = User::find($request['inspector']);
                    $factory = Factory::find($request['factory']);
                    $factory_contact = FctoryContact::find($request['factory_contact_person']);
                    $factory_contact_sec = FctoryContact::find($request['factory_contact_person2_psi']);
                    $psi_product_list = PSIProduct::where('inspection_id',$inserted_inspection_id)->get();
                    $product_list = Product::all();
                    
                    $booking_info = UserInfo::find(Auth::id());
                    $client_info = User::where('client_code',$request['client'])->first();
                    
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

                    $data = [
                        'client' =>  $client->Company_Name, 
                        'client_email' =>  $client_info->email, 
                        'client_number' => $request['client_project_number'],
                        'product_subject' => $product_subject,
                        'factory_name' => $factory->factory_name,
                        'factory_address' => $factory->factory_address,
                        'inspection_date'=>$request['inspection_date']
                        ];
                    $files_uploaded = $request->file('file');
                    Mail::send('email.manual_hold_order',$data, function($message) use ($data,$files_uploaded ){
                        // $message->to($data['client_email']);
                        // $message->cc('it-support@t-i-c.asia');
                        // $message->cc('gregor@t-i-c.asia');
                        // $message->cc('booking@t-i-c.asia');
                        // $message->cc('1249484103@qq.com');
                        // //$message->cc('gregor.voege@web.de');
                        // $message->cc('2891400188@qq.com');
                        $message->to('miguelbuojr@gmail.com');
                        $message->subject($data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");         
                    });

                   

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
               // }
          //  }
            
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    //client release order
    public function releaseClientOrderLoading(Request $request){
        DB::beginTransaction();
        try {
            //$inspection = new Inspection();
            
            $inspection = Inspection::find($request['edit_inspection_id']);
            //inspection details
            $inspection->client_id = $request['client'];
            $inspection->contact_person = $request['contact_person'];
            //factory details
            $inspection->factory = $request['factory'];
            $inspection->factory_contact_person = $request['factory_contact_person'];

            $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

            //inspection details
            $inspection->inspector_id = $request['inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $manday = number_format((float)$request['manday'], 1);
            $inspection->manday = $manday;
            //$inspection->manday = $request['manday'];
            $inspection->inspection_date = $request['inspection_date'];
            $inspection->inspection_date_to = $request['inspection_date_to'];
            $inspection->service = $request['service'];
            $inspection->reference_number = $request['reference_number'];
            $inspection->client_project_number = $request['client_project_number'];

            $inspection->percentageFriSpk = $request['percentageSpkFri'];

            $inspection->requirement = $request['requirement'];
            $inspection->memo = $request['memo'];
            $template=$request['template'];
            $template_word=$request['template_word'];
            // if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}
            if($template=="" || $request['type_of_project']=="esprit"){$template=0;}

            //05-05-2021
            if($template_word==""){$template_word=0;}

            $report_template=$request['report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}

            $inspection->word_template = null;

            //05-05-2021
            // if($template_word!=""){
            //     $inspection->template_id = $template_word;
            // }else{
            //     $inspection->template_id = $template;
            // }

            //$inspection->template_id = $template;
            $inspection->project_type = $request['type_of_project'];
            $project_type = $request['type_of_project'];
            //04-30-2021
            if($project_type == "word_project"){
                $inspection->template_id = $template_word;
            }else{
                $inspection->template_id = $template;
            }

            $inspection->created_by =  Auth::id();

            $inspection->inspection_status = "Released";

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
                

                //blank report details
            
                $service = [
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
                if($request->file('file')){
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
                        $doc->uploaded_by = 'booking';
                        $doc->save();
                    
				    	$file->move($dir,$filename);
                    }
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                //$password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];


                $report_id = Report::where('inspection_id',$inserted_inspection_id)->first();

                $password = $report_id->password;

                $report = Report::find($report_id->id);
                $report->inspection_id = $inspection->id;
                $report->client_code = $client->client_code;
                $report->service = $service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->report_no = $report_no;
                $report->password = $password;
                $report->inspector_id=$request['inspector'];
                
                if ($report->save()) {

                    $insp_details = Inspection::where('id',$inserted_inspection_id)->first();
                    $fac_contact2=$insp_details->factory_contact_person2;

                    $secondary_inspector=$insp_details->secondary_inspector_id;
                    $second_inspector_email=[];
                    if(!empty($secondary_inspector) || $secondary_inspector!=null || $secondary_inspector!="null"){
                        $get_ids=explode(',',$secondary_inspector);
                        foreach($get_ids as $sec_ins_id){
                            $get_email=UserInfo::select('email_address')->where('user_id',$sec_ins_id)->first();
                            array_push($second_inspector_email,$get_email->email_address);
                            //'second_inspector_email' => $second_inspector_email,
                        }
                    }

                    $inspector_info = UserInfo::find($request['inspector']);
                    $inspector_cred = User::find($request['inspector']);
                    $factory = Factory::find($request['factory']);
                    $factory_contact = FctoryContact::find($request['factory_contact_person']);
                    $factory_contact_sec = FctoryContact::find($request['factory_contact_person2_psi']);
                    $psi_product_list = PSIProduct::where('inspection_id',$inserted_inspection_id)->get();
                    $product_list = Product::all();
                    
                    $booking_info = UserInfo::find(Auth::id());
                    $client_info = User::where('client_code',$request['client'])->first();
                    
                    $blank_report=array();


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
                    $psi_product_list="";
                    if($request['type_of_project']=='word_project' || $request['type_of_project']=="esprit"){                     
                        $data = ['report_number' =>  $request['reference_number'], 
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'second_inspector_email' => $second_inspector_email,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'manday'=>$manday,
                            'spk_fri'=>$request['percentageSpkFri'],
                            'file_passed'=>$upload_file_name,
                            'service'=>$service[$request['service']],
                            'ref_num'=>$request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'factory_name'=>$factory->factory_name,
                            'factory_address' => $request['factory_address'],
                            'input_factory_addres' => $request['factory_address_loading'],
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'client_number'=>$request['client_project_number'],
                            'requirement'=>$request['requirement'],
                            'memo'=>$request['memo'],
                            'book_email'=>$booking_info->email_address,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num,
                            'psi_product_list'=>$psi_product_list,
                            'client' =>  $client->Company_Name, 
                            'user_type'=>$client_info->user_type,
                            'client_email' =>  $client_info->email
                        ];
                        $files_uploaded = $request->file('file');

                        // Mail::send('email.manual_release_order_client',$data, function($message) use ($data,$files_uploaded ){
                        //     $message->to($data['client_email']);
                        //     $message->bcc('it-support@t-i-c.asia');
                        //     $message->bcc('gregor@t-i-c.asia');
                        //     $message->bcc('booking@t-i-c.asia');
                        //     $message->bcc('1249484103@qq.com');
                        //     $message->bcc('gregor.voege@web.de');
                        //     $message->bcc('2891400188@qq.com');
                        //     $message->subject($data['client_number']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");         
                        // });

                        // Mail::send('email.manual_release_order',$data, function($message) use ($data,$files_uploaded ){
                        //     $message->to($data['email']);
                        //     $message->cc('it-support@t-i-c.asia');
                        //     $message->cc($data['book_email']);
                        //     $message->cc('gregor@t-i-c.asia');
                        //     $message->cc('report@t-i-c.asia');
                        //     $message->cc('booking@t-i-c.asia');
                        //     $message->cc('1249484103@qq.com');
                        //     //$message->cc('gregor.voege@web.de');
                        //     $message->cc('2891400188@qq.com');
                        //     if(!empty($data['second_inspector_email'])){
                        //         foreach ($data['second_inspector_email'] as $sec_email) {
                        //             $message->cc($sec_email);
                        //         }
                        //     }
                        //     $message->subject($data['client_number']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");
                        //     if($data['file_passed']){
                        //         foreach ($data['file_passed'] as $file_name) {
                        //             if($file_name=='email_attachment/ABD_1-5.pdf'){
                        //                 $message->attach($file_name);
                        //             }
                        //             if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                        //                 $message->attach($file_name);
                        //             }
                        //             if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                        //                 $message->attach($file_name);
                        //             }
                        //         }
                        //     }            
                        // });
                        
                        
                    }else{
                        $data = ['report_number' =>  $request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'second_inspector_email' => $second_inspector_email,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'file_passed'=>$upload_file_name,
                            'requirement'=>$request['requirement'],
                            'memo'=>$request['memo'],
                            'factory_name'=>$factory->factory_name,
                            'factory_address' => $request['factory_address'],
                            'input_factory_addres' => $request['factory_address_loading'],
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num,
                            'client' =>  $client->Company_Name,
                            'client_email' =>  $client_info->email,
                            'client_number'=>$request['client_project_number'],
                            'book_email'=>$booking_info->email_address,
                            'user_type'=>$client_info->user_type,
                            'psi_product_list'=>$psi_product_list];
                        $files_uploaded = $request->file('file');

                        // Mail::send('email.manual_release_order_client',$data, function($message) use ($data,$files_uploaded ){
                        //     $message->to($data['client_email']);
                        //     $message->bcc('it-support@t-i-c.asia');
                        //     $message->bcc('gregor@t-i-c.asia');
                        //     $message->bcc('booking@t-i-c.asia');
                        //     $message->bcc('1249484103@qq.com');
                        //     $message->bcc('gregor.voege@web.de');
                        //     $message->bcc('2891400188@qq.com');
                        //     $message->subject($data['client_number']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");         
                        // });

                        // Mail::send('email.download_release_order',$data, function($message) use ($data,$files_uploaded ){
                        //     $message->to($data['email']);
                        //     $message->cc('it-support@t-i-c.asia');
                        //     $message->cc('gregor@t-i-c.asia');
                        //     $message->cc('report@t-i-c.asia');
                        //     $message->cc('booking@t-i-c.asia');
                        //     $message->cc('1249484103@qq.com');
                        //     //$message->cc('gregor.voege@web.de');
                        //     $message->cc('2891400188@qq.com');
                        //     $message->cc($data['book_email']);
                        //     if(!empty($data['second_inspector_email'])){
                        //         foreach ($data['second_inspector_email'] as $sec_email) {
                        //             $message->cc($sec_email);
                        //         }
                        //     }
                        //     $message->subject('Download Blank Report for ' . $data['report_number']);
                        //     if($data['file_passed']){
                        //         foreach ($data['file_passed'] as $file_name) {
                        //             if($file_name=='email_attachment/ABD_1-5.pdf'){
                        //                 $message->attach($file_name);
                        //             }
                        //             if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                        //                 $message->attach($file_name);
                        //             }
                                    
                        //             if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                        //                 $message->attach($file_name);
                        //             }
                        //         }
                        //     }                      
                        // });

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

    //client hold order loading
    public function holdClientOrderLoading(Request $request){
        DB::beginTransaction();
        try {
            //$inspection = new Inspection();
            
            $inspection = Inspection::find($request['edit_inspection_id']);
            //inspection details
            $inspection->client_id = $request['client'];
            $inspection->contact_person = $request['contact_person'];
            //factory details
            $inspection->factory = $request['factory'];
            $inspection->factory_contact_person = $request['factory_contact_person'];

            $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];

            //inspection details
            $inspection->inspector_id = $request['inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $manday = number_format((float)$request['manday'], 1);
            $inspection->manday = $manday;
            //$inspection->manday = $request['manday'];
            $inspection->inspection_date = $request['inspection_date'];
            $inspection->inspection_date_to = $request['inspection_date_to'];
            $inspection->service = $request['service'];
            $inspection->reference_number = $request['reference_number'];
            $inspection->client_project_number = $request['client_project_number'];

            $inspection->percentageFriSpk = $request['percentageSpkFri'];

            $inspection->requirement = $request['requirement'];
            $inspection->memo = $request['memo'];
            $template=$request['template'];
            $template_word=$request['template_word']; //05-05-2021
            // if($template=="" || $request['type_of_project']=="word_project" || $request['type_of_project']=="esprit"){$template=0;}
            if($template=="" || $request['type_of_project']=="esprit"){$template=0;}

            //05-05-2021
            if($template_word==""){$template_word=0;}

            $report_template=$request['report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}

            $inspection->word_template = null;
            
            //05-05-2021
            // if($template_word!=""){
            //     $inspection->template_id = $template_word;
            // }else{
            //     $inspection->template_id = $template;
            // }

            //$inspection->template_id = $template;
            $inspection->project_type = $request['type_of_project'];
            $project_type = $request['type_of_project'];
            //04-30-2021
            if($project_type == "word_project"){
                $inspection->template_id = $template_word;
            }else{
                $inspection->template_id = $template;
            }


            $inspection->inspection_status = "Hold";

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
                

                //blank report details
            
                $service = [
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
                if($request->file('file')){
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
                        $doc->uploaded_by = 'booking';
                        $doc->save();
                    
				    	$file->move($dir,$filename);
                    }
                }

                $client = Client::where('client_code',$request['client'])->first();
                
                //$password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];


                $report_id = Report::where('inspection_id',$inserted_inspection_id)->first();

                $password = $report_id->password;

                $report = Report::find($report_id->id);
                $report->inspection_id = $inspection->id;
                $report->client_code = $client->client_code;
                $report->service = $service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->report_no = $report_no;
                $report->password = $password;
                $report->inspector_id=$request['inspector'];
                
                if ($report->save()) {

                    $insp_details = Inspection::where('id',$inserted_inspection_id)->first();
                    $fac_contact2=$insp_details->factory_contact_person2;

                    $inspector_info = UserInfo::find($request['inspector']);
                    $inspector_cred = User::find($request['inspector']);
                    $factory = Factory::find($request['factory']);
                    $factory_contact = FctoryContact::find($request['factory_contact_person']);
                    $factory_contact_sec = FctoryContact::find($request['factory_contact_person2_psi']);
                    $psi_product_list = PSIProduct::where('inspection_id',$inserted_inspection_id)->get();
                    $product_list = Product::all();
                    
                    $booking_info = UserInfo::find(Auth::id());
                    $client_info = User::where('client_code',$request['client'])->first();
                    
                    $blank_report=array();


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
                    $psi_product_list="";                
                    $data = [
                        'client' =>  $client->Company_Name, 
                        'client_email' =>  $client_info->email, 
                        'client_number' => $request['client_project_number'],
                        'factory_name' => $factory->factory_name,
                        'factory_address' => $factory->factory_address,
                        'inspection_date'=>$request['inspection_date']
                        ];
                        $files_uploaded = $request->file('file');
                        // Mail::send('email.manual_hold_order',$data, function($message) use ($data,$files_uploaded ){
                        //     $message->to($data['client_email']);
                        //     $message->cc('it-support@t-i-c.asia');
                        //     $message->cc('gregor@t-i-c.asia');
                        //     $message->cc('booking@t-i-c.asia');
                        //     $message->cc('1249484103@qq.com');
                        //     //$message->cc('gregor.voege@web.de');
                        //     $message->cc('2891400188@qq.com');
                        //     $message->subject($data['client_number']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");         
                        // });
                   

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
}
