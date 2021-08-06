<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use Dompdf\Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Client;
use App\Role;
use App\User;
use App\UserInfo;
use App\Inspection;
use App\Report;
use App\Factory;
use App\Supplier;
use App\Country;
use App\Product;
use App\ClientContact;
use App\ClientAqlDetail;
use App\ClientAqlMinor;
use App\ClientAqlMajor;
use App\FctoryContact;
use App\SupplierContact;
use App\Attachment;
use App\PSIProduct;
use App\InspectorAddress;
/* use App\PSIProduct; */
use App\ClientCost;
use App\InspectorCost;
use App\ProductPhotos;
use App\SavedProductCategories;
use App\SavedProductSubCategories;
use App\SubAccountPrivelege;


use DB;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Expr\Array_;
use Session;
use Mail;
use Symfony\Component\DomCrawler\Crawler;

class SupplierAccountControllerEditMrn extends Controller
{
    public function getPSIProjectFormEdit($id){
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
       //return Auth::id();
      //  return $id;
        $sub_acc="no";
        $privelege="";
        $client_id="";
        $g = User::select('id')->where('id',Auth::id())->first();
        //return $g;
        if(empty($g->id)){
            $client_id = Auth::id();
            $sub_acc="no";
        } else {
            $client_id = $g->id;
            $sub_acc="yes";
            $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
        }
        
        $user = User::where('id',Auth::id())->first();

        $client1 = Client::where('id',$user->group_id)->first();

        $role = User::where('id',$client_id)->first();
        $client = UserInfo::where('id',$client_id)->first();
        $client_code=$client1->client_code;
        $inspection = Inspection::where('id',$id)->first();
        $inspection_mrn = $inspection->mrn_no;
        $inspection_multiple = Inspection::where('mrn_no',$inspection_mrn)
            ->select('id')
            ->get();
        
        $new_data = json_decode($inspection_multiple, true); 
        
        $reports = Report::whereIn('inspection_id',$new_data)
        ->select('id','service')    
        ->get();  
       
        //suppplier
        $supplier_list = Supplier::where('supplier_status','!=',2)->where('client_code',$client_code)->orderBy('supplier_name', 'asc')->pluck('supplier_name','id');
        $supplier_info = Supplier::where('id',$inspection->supplier_id)->first();
        $supplier_con_list = SupplierContact::where('supplier_id',$inspection->supplier_id)->orderBy('supplier_contact_person','asc')->pluck('supplier_contact_person','id');
        $supplier_con_info = SupplierContact::where('id',$inspection->supplier_contact_id)->first();
        //user
        $user_info = UserInfo::where('user_id',$client_id)->first();

        //factory
        $get_factory = Factory::where('id',$inspection->factory)->first();
        $get_fc = FctoryContact::where('id',$inspection->factory_contact_person)->first();

        $suppData1 = DB::table('supplier_datas')->where('user_id', $user->id)->first();
        $supplierContact1 = DB::table('supplier_contacts')->where('supplier_id', $suppData1->supplier_id)->first();
        $suppliers1 = DB::table('suppliers')->where('id', $supplierContact1->supplier_id)->first();
        $factory_list = Factory::where('supplier_id',$suppliers1->id)->where('factory_status',0)->orderBy('factory_name','asc')->pluck('factory_name','id');
        $factory_con_list = FctoryContact::where('factory_id',$inspection->factory)->orderBy('factory_contact_person','asc')->pluck('factory_contact_person','id');

        $clientProducts = DB::table('clients')->where('id', $user->group_id)->first();
        //product
        $products = Product::where('client_code',$clientProducts->client_code)
                            ->where('status',0)
                            ->where('supplier_id',$suppliers1->id)
                            ->orderBy('product_name', 'asc')->pluck('product_name','id');
        // $psiproducts = PSIProduct::where('inspection_id',$id)->get();
        //return $psiproducts;
        $psiproducts = PSIProduct::where('p_s_i_products.mrn_no',$inspection_mrn)
            ->join('inspections','inspections.id','=','p_s_i_products.inspection_id')
            ->select('inspections.*','p_s_i_products.*')
            ->where('inspections.mrn_no','!=' ,"")
            ->where('p_s_i_products.mrn_no', '!=', "")
            ->get();
            
        $units=['piece'=>'Piece/s','roll'=>'Roll/s','set'=>'Set/s','pair'=>'Pair/s','box'=>'Box/es'];
        $attach_count=0;
        $attach_arr=array();
        foreach($psiproducts as $pp){
            $product_attachment=DB::table('product_photos')->where('product_id',$pp->product_id)->get();
            $attach_count=count($product_attachment);
            $attach_arr[$pp->product_id] = $attach_count;  
        }
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
        ,'Lighting'=>'Lighting'
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
        $p_categories  = SavedProductCategories::where('user_id',Auth::id())->get();
        foreach($p_categories as $cat){
            $p_category += [$cat->category => $cat->category];
        }
        ksort($p_category);
        $p_category += ['Others' => 'Others'];

        //other
        $clients = DB::table('clients')->where('id', $user->group_id)->first();
        $client_contact = ClientContact::where('client_code',$clients->client_code)->orderBy('contact_person','asc')->pluck('contact_person','id');

        // //04-28-2021
        // $supplierContactNew = DB::table('supplier_datas')
        //     //->join('client_contacts', 'client_contacts.id', '=', 'supplier_datas.supplier_client_contact_id')
        //     ->where('supplier_datas.user_id',Auth::id())->first();
        //     // ->where('supplier_datas.supplier_id',$supplierData->id)
        //     //->orderBy('client_contacts.contact_person','asc')->pluck('client_contacts.contact_person','client_contacts.id');  


        $get_cc = ClientContact::where('id',$inspection->contact_person)->first();
        //$clientName1 = DB::table('clients')->where('id', $user->group_id)->first();
        //$clientContact = DB::table('client_contacts')->where('client_code', $clientName1->client_code)
        //client name
        $clientName = DB::table('clients')->where('id', $user->group_id)
                    ->select('*')
                    ->get();

        //aql details
        $client_aql_detail = ClientAqlDetail::where('client_id',Auth::id())->first();
        $client_aql_minors_orig = ClientAqlMinor::all();
        $client_aql_majors_orig = ClientAqlMajor::all();
        $client_aql_minors = $client_aql_minors_orig->pluck('aql','aql');
        $client_aql_majors = $client_aql_majors_orig->pluck('aql','aql');
        $normal=['I'=>'I','II'=>'II','III'=>'III'];
        $special=['S1'=>'S1','S2'=>'S2','S3'=>'S3','S4'=>'S4'];
        $aql_major = ['0.065'=>'0.065','0.1'=>'0.1','0.15'=>'0.15','0.25'=>'0.25','0.40'=>'0.40','1'=>'1','1.5'=>'1.5','2.5'=>'2.5','4'=>'4','6.5'=>'6.5','10'=>'10'];

        if($client_id==755){
            $services = [
                'iqi'=> 'Incoming Quality Inspection',
                'dupro'=> 'During Production Inspection',
                'psi'=> 'Pre Shipment Inspection',
                'cbpi' => 'CBPI - No Serial',
                'cli'=> 'Container Loading Inspection',
                'physical' => 'Factory Audit',
                'detail' => 'Detail Audit',
                'social' => 'Social Audit',
                'st' => 'Sample Test'
            ];
        }else{
            $services = [
                'iqi'=> 'Incoming Quality Inspection',
                'dupro'=> 'During Production Inspection',
                'psi'=> 'Pre Shipment Inspection',
                'cbpi' => 'CBPI - No Serial',
                'cli'=> 'Container Loading Inspection',
                'physical' => 'Factory Audit',
                'detail' => 'Detail Audit',
                'social' => 'Social Audit'
            ];
        }

        return view('pages.supplier.edit-project.index_mrn',compact('role','user_info','products','client_id','client_code','client_contact','client_aql_detail',
        'client_aql_minors','client_aql_majors','inspection','get_factory','get_fc','factory_con_list','factory_list','get_cc','client_aql_majors','normal',
        'special','aql_major','user','supplier_list','supplier_con_list','supplier_info','supplier_con_info','psiproducts','units','attach_arr','p_category',
        'aql_options','services','sub_acc','privelege', 'clientName','supplierInfo','supplierData','inspection_multiple','reports'));
    }

    //edit psi inspection
    public function editInspectionData(Request $request){
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $validator = Validator::make($request->all(), [
            'inspection_id' => 'required',
            'client' => 'required',
            'contact_person' => 'required', 
            'supplier' => 'required',
            'supplier_name' => 'required',
            'supplier_contact_person' => 'required',
            'factory' => 'required',
            'factory_contact_person' => 'required',
            'inspection_date' => 'required',
            'psi_shipment_date' => 'required',
            'service' => 'required',
            'reference_number' => 'required',
            'client_project_number' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json([
                'message' => 'Empty fields',
            ],500);
        }else{

            DB::beginTransaction();
            try{
                $auth_id=Auth::id();
                //get user type
                $user_data = User::where('id',Auth::id())->first();
                $user_type=null;
                if($user_data->user_type=='tic_sera'){
                    $user_type='tic_sera';
                }
            
                $edit_ins_id=$request['inspection_id'];
                // $inspection = Inspection::find($edit_ins_id);
                //06-02-2021
                $mrn_inspection_id = $request['mrn_inspection_id'];
                $inspections = Inspection::whereIn('id',$mrn_inspection_id)->get();
                foreach($inspections as $inspection){
                     //inspection details
                    $inspection->client_id = $request['client'];
                    $inspection->contact_person = $request['contact_person'];
                    //factory details
                    $inspection->supplier_id = $request['supplier'];
                    $inspection->supplier_name = $request['supplier_name'];
                    $inspection->supplier_contact_id = $request['supplier_contact_person'];
                    //factory details
                    $inspection->factory = $request['factory'];
                    $inspection->factory_contact_person = $request['factory_contact_person'];
                    //inspection details
                    $inspection->inspection_date = $request['inspection_date'];
                    $inspection->inspection_date_to = $request['inspection_date_to'];
                    $inspection->shipment_date = $request['psi_shipment_date'];
                    // $inspection->factory_change_date = $request['fac_change_date'];
                    $inspection->service = $request['service'];
                    // $inspection->reference_number = $request['reference_number'];
                    $inspection->client_project_number = $request['client_project_number'];
                    $inspection->requirement = $request['requirement'];
                    $inspection->memo = $request['memo'];
                    
                    $inspection->inspection_status = "Client Pending";
                    $inspection->client_book = "false";
                    $inspection->supplier_book = "true";
                    $inspection->client_book_id =  Auth::id();
                    $inspection->created_by =  Auth::id();
                    $inspection->save();
                }
            
                // if ($inspection->save()) {
                    
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
                
                    if($request['new_product_id']){
                        $new_products = $request['new_product_id'];
                        foreach ($new_products as $i => $value) {
                            $new_prod[$i] = new PSIProduct();
                            $new_prod[$i]->inspection_id = $edit_ins_id;
                            $new_prod[$i]->product_id = $request['new_product_id'][$i];
                            $new_prod[$i]->product_name = $request['new_product_name'][$i];
                            $new_prod[$i]->product_first_category = $request['new_product_category'][$i];
                            $new_prod[$i]->product_category = $request['new_product_sub_category'][$i];
                            $new_prod[$i]->brand = $request['new_brand'][$i];
                            $new_prod[$i]->po_no = $request['new_po_number'][$i];
                            $new_prod[$i]->model_no = $request['new_model_no'][$i];
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
                            //additional product
                            $product_saved = Product::where('id',$request['new_product_id'][$i])->first();
                            if(!empty($product_saved)){
                                $new_prod[$i]->product_length = $product_saved->product_length;
                                $new_prod[$i]->product_width = $product_saved->product_width;
                                $new_prod[$i]->product_height = $product_saved->product_height;
                                $new_prod[$i]->product_diameter = $product_saved->product_diameter;
                                $new_prod[$i]->product_weight = $product_saved->product_weight;
                                $new_prod[$i]->retail_length = $product_saved->retail_length;
                                $new_prod[$i]->retail_width = $product_saved->retail_width;
                                $new_prod[$i]->retail_height = $product_saved->retail_height;
                                $new_prod[$i]->retail_diameter = $product_saved->retail_diameter;
                                $new_prod[$i]->retail_weight = $product_saved->retail_weight;
                                $new_prod[$i]->retail_box_qty = $product_saved->retail_box_qty;
                                $new_prod[$i]->inner_length = $product_saved->inner_length;
                                $new_prod[$i]->inner_width = $product_saved->inner_width;
                                $new_prod[$i]->inner_height = $product_saved->inner_height;
                                $new_prod[$i]->inner_diameter = $product_saved->inner_diameter;
                                $new_prod[$i]->inner_weight = $product_saved->inner_weight;
                                $new_prod[$i]->inner_box_qty = $product_saved->inner_box_qty;
                                $new_prod[$i]->export_length = $product_saved->export_length;
                                $new_prod[$i]->export_width = $product_saved->export_width;
                                $new_prod[$i]->export_height = $product_saved->export_height;
                                $new_prod[$i]->export_diameter = $product_saved->export_diameter;
                                $new_prod[$i]->export_weight = $product_saved->export_weight;
                                $new_prod[$i]->export_box_qty = $product_saved->export_box_qty;
                                $new_prod[$i]->export_max_weight_carton = $product_saved->export_max_weight_carton;
                                $new_prod[$i]->export_cbm = $product_saved->export_cbm; 
                                $new_prod[$i]->grd = $product_saved->grd;
                                $new_prod[$i]->item_description = $product_saved->item_description;
                                $new_prod[$i]->additional_product_info = $product_saved->additional_product_info;
                            }
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
                        }
                    }
                    if($request['edit_pid']){
                        $products_edit = $request['edit_pid'];                    
                        foreach ($products_edit as $i => $value) {                          
                            $prods[$i] = PSIProduct::find($request['edit_pid'][$i]);
                            // $prods[$i]->inspection_id = $edit_ins_id;
                            $prods[$i]->product_id = $request['product_id'][$i];
                            $prods[$i]->product_name = $request['product_name'][$i];
                            $prods[$i]->product_first_category = $request['product_category'][$i];
                            $prods[$i]->product_category = $request['product_sub_category'][$i];
                            $prods[$i]->brand = $request['brand'][$i];
                            $prods[$i]->po_no = $request['po_number'][$i];
                            $prods[$i]->model_no = $request['model_no'][$i];
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
                            //additional product
                            $product_saved = Product::where('id',$request['edit_pid'][$i])->first();
                            if(!empty($product_saved)){
                                $prods[$i]->product_length = $product_saved->product_length;
                                $prods[$i]->product_width = $product_saved->product_width;
                                $prods[$i]->product_height = $product_saved->product_height;
                                $prods[$i]->product_diameter = $product_saved->product_diameter;
                                $prods[$i]->product_weight = $product_saved->product_weight;
                                $prods[$i]->retail_length = $product_saved->retail_length;
                                $prods[$i]->retail_width = $product_saved->retail_width;
                                $prods[$i]->retail_height = $product_saved->retail_height;
                                $prods[$i]->retail_diameter = $product_saved->retail_diameter;
                                $prods[$i]->retail_weight = $product_saved->retail_weight;
                                $prods[$i]->retail_box_qty = $product_saved->retail_box_qty;
                                $prods[$i]->inner_length = $product_saved->inner_length;
                                $prods[$i]->inner_width = $product_saved->inner_width;
                                $prods[$i]->inner_height = $product_saved->inner_height;
                                $prods[$i]->inner_diameter = $product_saved->inner_diameter;
                                $prods[$i]->inner_weight = $product_saved->inner_weight;
                                $prods[$i]->inner_box_qty = $product_saved->inner_box_qty;
                                $prods[$i]->export_length = $product_saved->export_length;
                                $prods[$i]->export_width = $product_saved->export_width;
                                $prods[$i]->export_height = $product_saved->export_height;
                                $prods[$i]->export_diameter = $product_saved->export_diameter;
                                $prods[$i]->export_weight = $product_saved->export_weight;
                                $prods[$i]->export_box_qty = $product_saved->export_box_qty;
                                $prods[$i]->export_max_weight_carton = $product_saved->export_max_weight_carton;
                                $prods[$i]->export_cbm = $product_saved->export_cbm; 
                                $prods[$i]->grd = $product_saved->grd;
                                $prods[$i]->item_description = $product_saved->item_description;
                                $prods[$i]->additional_product_info = $product_saved->additional_product_info;
                            }
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
                        }
                    }
                
                    //blank report details
                
                    $service = [
                        'iqi' => 'Incoming Quality Inspection',
                        'dupro' => 'During Production Inspection',
                        'psi' => 'Pre Shipment Inspection',
                        'cli' => 'Container Loading Inspection',
                        'pls' => 'Setting up Production Lines',
                        'cbpi' => 'CBPI - No Serial',
                        'cbpi_serial' => 'CBPI - with Serial',
                        'cbpi_isce' => 'CBPI - ISCE',
                        'site_visit' => 'Site Visit',
                        'SPK' => 'SPK',
                        'FRI' => 'FRI',
                        'physical' => 'Factory Audit',
		    		    'detail' => 'Detail Audit',
                        'social' => 'Social Audit',
                        'st' => 'Sample Test'
                    ];
                    $get_attachment=Attachment::where('inspection_id',$edit_ins_id)->get();
                    if($get_attachment){
                        $edit_dir="images/project2/".$edit_ins_id."/"; 
                        foreach ($get_attachment as $att) {                   
                            array_push($upload_file_name,$edit_dir.$att->file_name); 
                        }
                    }
                    if($request->file('file')){
                        $mrn_inspections = Inspection::whereIn('id',$mrn_inspection_id)
                        ->select('*')
                        ->get();
                        foreach($mrn_inspections as $mrn_ins){
                            foreach ($request->file('file') as $file) {
                                $filename = $file->getClientOriginalName();  
                                $filename=str_replace("#","_",$filename);                  
                                //directory
                                $dir="images/project2/".$mrn_ins->id."/";               
                                //move the files to the correct folder
                                if (!File::exists($dir)) {
                                    File::makeDirectory($dir);
                                }
                                    $inserted_inspection_id2 = $mrn_ins->id-1;
                                    $dir2="images/project2/".$inserted_inspection_id2."/";  
                                    if(File::exists($dir2.$filename)){
                                        $inserted_inspection_id1 = $mrn_ins->id-1;
                                        $dir1="images/project2/".$inserted_inspection_id1."/";  
                                        $sourceFilePath= $dir1;
                                        $destinationPath= $dir;
                                        $success = File::copy($sourceFilePath.$filename,$destinationPath.$filename);
                                    }
                                    else{
                                        $file->move($dir,$filename);
                                    }
                                    //push file name in array
                                    array_push($upload_file_name,$dir.$filename);  
                                    //save details to db
                                    $doc= new Attachment();
                                    $doc->inspection_id = $mrn_ins->id;
                                    $doc->project_number = $mrn_ins->reference_number;
                                    $doc->file_name = $filename;
                                    //$doc->file_size = $file->getSize();
                                    $doc->file_size = 56716;
                                    $doc->path = $dir.$filename;
                                    $doc->save();
                            }
                        }
                            
                    }
                
                    $client = Client::where('client_code',$request['client'])->first();
                    $report_data = Report::where('inspection_id',$edit_ins_id)->first();
                
                    $password = mt_rand(100000, 999999);
                    $report_no = $request['reference_number'];
                    //06-02-2021
                    $report_id = $request['report_id'];
                    $reports = Report::whereIn('id',$report_id)->get();
                    foreach($reports as $report){
                        // $report = Report::find($report_data->id);
                        // $report->inspection_id = $edit_ins_id;
                        $report->client_code = $client->client_code;
                        $report->service = $service[$request['service']];
                        $report->inspection_date = $request['inspection_date'];
                        $report->inspector_id=0;
                        $report->save();
                        // $report->report_no = $report_no;
                        // $report->password = $password;  
                    }
                           
                    // if ($report->save()) {
                        $client_info = UserInfo::find(Auth::id());
                        $psi_product_list = PSIProduct::where('inspection_id',$edit_ins_id)->get();
                        $factory = Factory::where('id',$request['factory'])->first();
                        $factory_cont = FctoryContact::where('id',$request['factory_contact_person'])->first();
                        //06-02-2021
                        $mrn_reports = DB::table('inspections')
                            ->join('p_s_i_products','inspections.id','=','p_s_i_products.inspection_id')
                            ->whereIn('p_s_i_products.inspection_id',$mrn_inspection_id)
                            ->select('p_s_i_products.*')
                            ->get();
                        foreach($mrn_reports as $mrn_rep){
                            $data = ['report_number' =>  $request['reference_number'],
                                'service'=>$service[$request['service']],
                                'inspection_date'=>$request['inspection_date'],
                                'inspection_date_to'=>$request['inspection_date_to'],
                                'client_number'=>$request['client_project_number'],
                                'supplier_name'=>$request['supplier_name'],
                                'c_name'=> $client->Company_Name,
                                'company_email'=> $client->Company_Email,
                                'psi_product_list'=>$psi_product_list,
                                'product_name'=>$mrn_rep->product_name,
                                'product_category'=>$mrn_rep->product_first_category,
                                'brand'=>$mrn_rep->brand,
                                'model_no'=>$mrn_rep->model_no,
                                'po_no'=>$mrn_rep->po_no,
                                'aql_qty'=>$mrn_rep->aql_qty,
                                'aql_qty_unit'=>$mrn_rep->aql_qty_unit,
                                'aql_normal_level'=>$mrn_rep->aql_normal_level,
                                'aql_special_level'=>$mrn_rep->aql_special_level,
                                'aql_normal_sampsize'=>$mrn_rep->aql_normal_sampsize,
                                'aql_special_sampsize'=>$mrn_rep->aql_special_sampsize,
                                'aql_major'=>$mrn_rep->aql_major,
                                'max_allowed_major'=>$mrn_rep->max_allowed_major,
                                'aql_minor'=>$mrn_rep->aql_minor,
                                'max_allowed_minor'=>$mrn_rep->max_allowed_minor,
                                'item_description'=>$mrn_rep->item_description,
                                'additional_product_info'=>$mrn_rep->additional_product_info,
                                'client_info'=>$client_info,
                                'factory'=>$factory,
                                'factory_cont'=>$factory_cont,
                                'file_passed'=>$upload_file_name,
                                'products_id'=>$products_id,
                                'client_email'=>$client_info->email_address,
                                'dear_client'=>$client_info->name,
                                'requirement'=>$request['requirement'],
                                'memo'=>$request['memo'],
                                'user_type'=>$user_type,
                                'auth_id' => $auth_id
                            ];
                            if($request['service']=='st'){
                                DB::commit();
                                return response()->json([
                                    'message' => 'OK',
                                ],200);
                            }else{
                                Mail::send('email.edit_book_from_client_mrn',$data, function($message) use ($data){                        
                                    if($data['client_email']){
                                        // $message->to($data['client_email'],$data['supplier_name']);
                                        // $message->cc($data['company_email'],$data['c_name']);
                                        $message->to('miguelbuojr@gmail.com');
                                    }else{
                                        // $message->to('booking@t-i-c.asia');
                                    }
                                    // $message->bcc('booking@t-i-c.asia');
                                    // $message->bcc('it-support@t-i-c.asia');
                                    // $message->bcc('gregor@t-i-c.asia');           
                                    // $message->bcc('gregor.voege@web.de');
                                    if($data['user_type']=='tic_sera'){
                                        // $message->bcc('aarreola@sera.com.mx','Aarreola');    
                                        // $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                        // $message->bcc('coordination@sera.com.mx','Coordination');  
                                        if($data['auth_id']=='904' || $data['auth_id']==904){
                                            // $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                            // $message->bcc('sera.asiaop@outlook.com','SeraAsiaop');
                                            // $message->bcc('aarreola.sera@gmail.com','AarreolaSera');
                                        }
                                    
                                    }else{
                                        // $message->bcc('1249484103@qq.com');                             
                                        // $message->bcc('2891400188@qq.com');
                                    }
                                     $message->subject("Supplier Booked Updated - ".$data['service'] ." for " .$data['client_number']. " on " . $data['inspection_date']);                                             
                                });
                            } 
                        }
                                          
                        if (count(Mail::failures()) > 0) {
                            DB::rollback();
                            return response()->json([
                                'message' => 'error',
                            ],500);
                        
                        }
                        else{
                            DB::commit();
                            return response()->json([
                                'message' => 'OK',
                            ],200);
                        }
                   // }
                  //  }
               // }
            }catch (Exception $e) {
                DB::rollback();
                 return response()->json([
                    'message'=>$e->getMessage()
                ],500);
            }
        }
    }

    public function getPSIProjectFormCopy($id){
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $sub_acc="no";
        $privelege="";
        $client_id="";
        $g = User::select('id')->where('id',Auth::id())->first();
        if(empty($g->id)){
            $client_id = Auth::id();
            $sub_acc="no";
        } else {
            $client_id = $g->id;
            $sub_acc="yes";
            $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
        }
        //$client_id=Auth::id();
        $role = User::where('id',$client_id)->first();
        $client = UserInfo::where('id',$client_id)->first();
        $client_code=$client->client_code;
        $inspection = Inspection::where('id',$id)->first();
        
        //set reference number
        date_default_timezone_set('UTC');
        $year=date("y");
        $month=date("m");
        $inspection_count = Inspection::where('client_id',$client_code)->get();
        $count = $inspection_count->count();

        $get_count=$count+1;
		$set_count;
		if($get_count<=9){
			$set_count='0'.''.$get_count;
		}else{
			$set_count=$get_count;
		}

        $ref_num=$client_code.'-'.$year.''.$month.'-'.$set_count;

        //user
        $user_info = UserInfo::where('user_id',$client_id)->first();
        $user = User::where('id',Auth::id())->first();

        //factory
        $get_factory = Factory::where('id',$inspection->factory)->first();
        $get_fc = FctoryContact::where('id',$inspection->factory_contact_person)->first();
        $suppData1 = DB::table('supplier_datas')->where('user_id', $user->id)->first();
        $supplierContact1 = DB::table('supplier_contacts')->where('supplier_id', $suppData1->supplier_id)->first();
        $suppliers1 = DB::table('suppliers')->where('id', $supplierContact1->supplier_id)->first();
        $factory_list = Factory::where('supplier_id',$suppliers1->id)->orderBy('factory_name','asc')->pluck('factory_name','id');
        $factory_con_list = FctoryContact::where('factory_id',$inspection->factory)->orderBy('factory_contact_person','asc')->pluck('factory_contact_person','id');

        //suppplier
        $supplier_list = Supplier::where('supplier_status','!=',2)->where('client_code',$client_code)->orderBy('supplier_name', 'asc')->pluck('supplier_name','id');
        $supplier_info = Supplier::where('id',$inspection->supplier_id)->first();
        $supplier_con_list = SupplierContact::where('supplier_id',$inspection->supplier_id)->orderBy('supplier_contact_person','asc')->pluck('supplier_contact_person','id');
        $supplier_con_info = SupplierContact::where('id',$inspection->supplier_contact_id)->first();
        //user
        $user_info = UserInfo::where('user_id',$client_id)->first();
        $user = User::where('id',Auth::id())->first();
        //product
        $products = Product::where('client_code',$suppliers1->client_code)
                    ->where('status',0)
                    ->where('supplier_id',$suppliers1->id)
                    ->orderBy('product_name', 'asc')->pluck('product_name','id');
        $psiproducts = PSIProduct::where('inspection_id',$id)->get();
        $units=['piece'=>'Piece/s','roll'=>'Roll/s','set'=>'Set/s','pair'=>'Pair/s','box'=>'Box/es'];
        $attach_count=0;
        $attach_arr=array();
        foreach($psiproducts as $pp){
            $product_attachment=DB::table('product_photos')->where('product_id',$pp->product_id)->get();
            $attach_count=count($product_attachment);
            $attach_arr[$pp->product_id] = $attach_count;  
        }
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
        ,'Lighting'=>'Lighting'
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
        $p_categories  = SavedProductCategories::where('user_id',Auth::id())->get();
        foreach($p_categories as $cat){
            $p_category += [$cat->category => $cat->category];
        }
        ksort($p_category);
        $p_category += ['Others' => 'Others'];

        //other
        $clients = DB::table('clients')->where('id', $user->group_id)->first();
        $client_contact = ClientContact::where('client_code',$clients->client_code)->orderBy('contact_person','asc')->pluck('contact_person','id');
        $get_cc = ClientContact::where('id',$inspection->contact_person)->first();

         //04-28-2021
        //  $supplierContactNew = DB::table('supplier_datas')
        //  ->join('client_contacts', 'client_contacts.id', '=', 'supplier_datas.supplier_client_contact_id')
        //  ->where('supplier_datas.user_id',Auth::id())
        // // ->where('supplier_datas.supplier_id',$supplierData->id)
        //  ->orderBy('client_contacts.contact_person','asc')->pluck('client_contacts.contact_person','client_contacts.id');  

        //client name
        $clientName = DB::table('clients')->where('id', $user->group_id)
                    ->select('*')
                    ->get();

        //aql details
        $client_aql_detail = ClientAqlDetail::where('client_id',Auth::id())->first();
        $client_aql_minors_orig = ClientAqlMinor::all();
        $client_aql_majors_orig = ClientAqlMajor::all();
        $client_aql_minors = $client_aql_minors_orig->pluck('aql','aql');
        $client_aql_majors = $client_aql_majors_orig->pluck('aql','aql');
        $normal=['I'=>'I','II'=>'II','III'=>'III'];
        $special=['S1'=>'S1','S2'=>'S2','S3'=>'S3','S4'=>'S4'];
        $aql_major = ['0.065'=>'0.065','0.1'=>'0.1','0.15'=>'0.15','0.25'=>'0.25','0.40'=>'0.40','1'=>'1','1.5'=>'1.5','2.5'=>'2.5','4'=>'4','6.5'=>'6.5','10'=>'10'];

        if($client_id==755){
            $services = [
                'iqi'=> 'Incoming Quality Inspection',
                'dupro'=> 'During Production Inspection',
                'psi'=> 'Pre Shipment Inspection',
                'cbpi' => 'CBPI - No Serial',
                'cli'=> 'Container Loading Inspection',
                'physical' => 'Factory Audit',
                'detail' => 'Detail Audit',
                'social' => 'Social Audit',
                'st' => 'Sample Test'
            ];
        }else{
            $services = [
                'iqi'=> 'Incoming Quality Inspection',
                'dupro'=> 'During Production Inspection',
                'psi'=> 'Pre Shipment Inspection',
                'cbpi' => 'CBPI - No Serial',
                'cli'=> 'Container Loading Inspection',
                'physical' => 'Factory Audit',
                'detail' => 'Detail Audit',
                'social' => 'Social Audit'
            ];
        }

        return view('pages.supplier.copy-project.index',compact('role','user_info','products','client_id','client_code','client_contact',
        'client_aql_detail','client_aql_minors','client_aql_majors','inspection','get_factory','get_fc','factory_con_list','factory_list',
        'get_cc','client_aql_majors','normal','special','aql_major','user','supplier_list','supplier_con_list','supplier_info','supplier_con_info',
        'psiproducts','units','attach_arr','p_category','aql_options','ref_num','services','sub_acc','privelege', 'clientName','supplierInfo',
        'supplierData'));
    }
    //copy psi 
    public function copyPSIData(Request $request){
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $validator = Validator::make($request->all(), [
            'inspection_id' => 'required',
            'client' => 'required',
            'contact_person' => 'required', 
            'supplier' => 'required',
            'supplier_name' => 'required',
            'supplier_contact_person' => 'required',
            'factory' => 'required',
            'factory_contact_person' => 'required',
            'inspection_date' => 'required',
            'psi_shipment_date' => 'required',
            'service' => 'required',
            'reference_number' => 'required',
            'client_project_number' => 'required',
        ]);
        if($validator->fails()) {
            return response()->json([
                'message' => 'Empty fields',
            ],500);
        }else{
        
            DB::beginTransaction();
            try{
                $auth_id=Auth::id();
                //get user type
                $user_data = User::where('id',Auth::id())->first();
                $user_type=null;
                if($user_data->user_type=='tic_sera'){
                    $user_type='tic_sera';
                }

                $edit_ins_id= $request['inspection_id'];
                $inspection = new Inspection();
                //inspection details
                $inspection->client_id = $request['client'];
                $inspection->contact_person = $request['contact_person'];
                //factory details
                $inspection->supplier_id = $request['supplier']; 
                $inspection->supplier_name = $request['supplier_name'];
                $inspection->supplier_contact_id = $request['supplier_contact_person'];
                //factory details
                $inspection->factory = $request['factory'];
                $inspection->factory_contact_person = $request['factory_contact_person'];
                //inspection details
                $inspection->inspector_id = 0;
                $inspection->secondary_inspector_id = $request['second_inspector'];
                $inspection->manday = $request['manday'];
                $inspection->inspection_date = $request['inspection_date'];
                $inspection->inspection_date_to = $request['inspection_date_to'];
                $inspection->shipment_date = $request['psi_shipment_date'];
                // $inspection->factory_change_date = $request['fac_change_date'];
                $inspection->service = $request['service'];
                $inspection->reference_number = $request['reference_number'];
                $inspection->client_project_number = $request['client_project_number'];
                $inspection->requirement = $request['requirement'];
                $inspection->memo = $request['memo'];

                $inspection->inspection_type = $user_type;


                $inspection->inspection_status = "Client Pending";
                $inspection->client_book = "false";
                $inspection->supplier_book = "true";
                $inspection->client_book_id =  Auth::id();
                $inspection->created_by =  Auth::id();


                if ($inspection->save()) {
                    $new_ins_id=$inspection->id;

                    $clientCost = new ClientCost();
                    $clientCost->inspection_id =  $inspection->id;
                    $clientCost->currency =  'usd';
                    $clientCost->md_charges =  0;
                    $clientCost->travel_cost =  0;
                    $clientCost->hotel_cost =  0;
                    $clientCost->ot_cost =  0; 
                    $clientCost->save();

                    $inspectorCost = new InspectorCost();
                    $inspectorCost->inspection_id =  $inspection->id;
                    $inspectorCost->currency =  'usd';
                    $inspectorCost->md_charges =  0;
                    $inspectorCost->travel_cost =  0;
                    $inspectorCost->hotel_cost =  0;
                    $inspectorCost->ot_cost =  0; 
                    $inspectorCost->save();

                    //$products = $request['product_id'];
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

                    $product_id = $request['product_id'];
                    foreach ($product_id as $i => $value) {
                        $prods[$i] = new PSIProduct();
                        $prods[$i]->inspection_id = $new_ins_id;
                        $prods[$i]->product_id = $request['product_id'][$i];
                        $prods[$i]->product_name = $request['product_name'][$i];
                        $prods[$i]->product_first_category = $request['product_category'][$i];
                        $prods[$i]->product_category = $request['product_sub_category'][$i];
                        $prods[$i]->brand = $request['brand'][$i];
                        $prods[$i]->po_no = $request['po_number'][$i];
                        $prods[$i]->model_no = $request['model_no'][$i];
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
                        //$prods[$i]->additional_product_info = $request['additional_product_info'][$i];

                        //asd123
                        $product_saved = Product::where('id',$request['product_id'][$i])->first();
                        if(!empty($product_saved)){
                            $prods[$i]->product_length = $product_saved->product_length;
                            $prods[$i]->product_width = $product_saved->product_width;
                            $prods[$i]->product_height = $product_saved->product_height;
                            $prods[$i]->product_diameter = $product_saved->product_diameter;
                            $prods[$i]->product_weight = $product_saved->product_weight;
                            $prods[$i]->retail_length = $product_saved->retail_length;
                            $prods[$i]->retail_width = $product_saved->retail_width;
                            $prods[$i]->retail_height = $product_saved->retail_height;
                            $prods[$i]->retail_diameter = $product_saved->retail_diameter;
                            $prods[$i]->retail_weight = $product_saved->retail_weight;
                            $prods[$i]->inner_length = $product_saved->inner_length;
                            $prods[$i]->inner_width = $product_saved->inner_width;
                            $prods[$i]->inner_height = $product_saved->inner_height;
                            $prods[$i]->inner_diameter = $product_saved->inner_diameter;
                            $prods[$i]->inner_weight = $product_saved->inner_weight;
                            $prods[$i]->export_length = $product_saved->export_length;
                            $prods[$i]->export_width = $product_saved->export_width;
                            $prods[$i]->export_height = $product_saved->export_height;
                            $prods[$i]->export_diameter = $product_saved->export_diameter;
                            $prods[$i]->export_weight = $product_saved->export_weight;
                            $prods[$i]->export_max_weight_carton = $product_saved->export_max_weight_carton; 
                            $prods[$i]->grd = $product_saved->grd;
                            $prods[$i]->item_description = $product_saved->item_description;
                            $prods[$i]->additional_product_info = $product_saved->additional_product_info;
                        }
                        $prods[$i]->save();
                        $product = Product::find($request['product_id'][$i]);
                        array_push($products_id,$request['product_id'][$i]);
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

                    //blank report details
                
                    $service = [
                        'iqi' => 'Incoming Quality Inspection',
                        'dupro' => 'During Production Inspection',
                        'psi' => 'Pre Shipment Inspection',
                        'cli' => 'Container Loading Inspection',
                        'cbpi' => 'CBPI - No Serial',
                        'physical' => 'Factory Audit',
		        		'detail' => 'Detail Audit',
                        'social' => 'Social Audit',
                        'st' => 'Sample Test'
                    ];
                    $get_attachment=Attachment::where('inspection_id',$edit_ins_id)->get();
                    if($get_attachment){
                        $edit_dir="images/project2/".$edit_ins_id."/"; 
                        $new_dir="images/project2/".$new_ins_id."/"; 
                        foreach ($get_attachment as $att) {                   
                            $new_att= new Attachment();
                            $new_att->inspection_id = $new_ins_id;
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
                    }
                    if($request->file('file')){
                        foreach ($request->file('file') as $file) {
                            $filename = $file->getClientOriginalName();    
                            $filename=str_replace("#","_",$filename);                
                            //directory
                            $dir="images/project2/".$new_ins_id."/";               
                            //move the files to the correct folder
                            if (!File::exists($dir)) {
                                File::makeDirectory($dir);
                            }
                            $file->move($dir,$filename);
                            //push file name in array
                            array_push($upload_file_name,$dir.$filename);  
                            //save details to db
                            $doc= new Attachment();
                            $doc->inspection_id = $new_ins_id;
                            $doc->project_number = $request['reference_number'];
                            $doc->file_name = $filename;
                            $doc->file_size = 3212334;
                            $doc->path = $dir.$filename;
                            $doc->save();
                        }
                    }

                    $client = Client::where('client_code',$request['client'])->first();
                
                    $password = mt_rand(100000, 999999);
                    $report_no = $request['reference_number'];

                    $report = new Report();
                    $report->inspection_id = $new_ins_id;
                    $report->client_code = $client->client_code;
                    $report->service = $service[$request['service']];
                    $report->inspection_date = $request['inspection_date'];
                    $report->inspector_id=0;
                    $report->report_no = $report_no;
                    $report->password = $password;         
                    if ($report->save()) {
                        $client_info = UserInfo::find(Auth::id());
                        $psi_product_list = PSIProduct::where('inspection_id',$new_ins_id)->get();
                        $factory = Factory::where('id',$request['factory'])->first();
                        $factory_cont = FctoryContact::where('id',$request['factory_contact_person'])->first();
                        $data = ['report_number' =>  $request['reference_number'],
                                'service'=>$service[$request['service']],
                                'inspection_date'=>$request['inspection_date'],
                                'client_number'=>$request['client_project_number'],
                                'supplier_name'=>$request['supplier_name'],
                                'c_name'=> $client->Company_Name,
                                'company_email'=> $client->Company_Email,
                                'psi_product_list'=>$psi_product_list,
                                'client_info'=>$client_info,
                                'factory'=>$factory,
                                'factory_cont'=>$factory_cont,
                                'file_passed'=>$upload_file_name,
                                'products_id'=>$products_id,
                                'client_email'=>$client_info->email_address,
                                'dear_client'=>$client_info->name,
                                'requirement'=>$request['requirement'],
                                'memo'=>$request['memo'],
                                'user_type'=>$user_type,
                                'auth_id' => $auth_id
                            ];
                            if($request['service']=='st'){
                                DB::commit();
                                return response()->json([
                                    'message' => 'OK',
                                ],200);
                            }else{
                                Mail::send('email.book_from_client',$data, function($message) use ($data){
                                    if($data['client_email']){
                                        // $message->to($data['client_email'],$data['supplier_name']);
                                        // $message->cc($data['company_email'],$data['c_name']);
                                        $message->to('miguelbuojr@gmail.com');
                                    }else{
                                        // $message->to('booking@t-i-c.asia');
                                    }
                                    // $message->bcc('booking@t-i-c.asia');
                                    // $message->bcc('it-support@t-i-c.asia');
                                    // $message->bcc('gregor@t-i-c.asia');      
                                    // $message->bcc('gregor.voege@web.de');  
                                    if($data['user_type']=='tic_sera'){
                                        // $message->bcc('aarreola@sera.com.mx','Aarreola');    
                                        // $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                        // $message->bcc('coordination@sera.com.mx','Coordination');    
                                        if($data['auth_id']=='904' || $data['auth_id']==904){
                                            // $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                            // $message->bcc('sera.asiaop@outlook.com','SeraAsiaop');
                                            // $message->bcc('aarreola.sera@gmail.com','AarreolaSera');
                                        }
                                    }else{
                                        // $message->bcc('1249484103@qq.com');                             
                                        // $message->bcc('2891400188@qq.com');
                                    }    
                                    $message->subject("Supplier Booked - ".$data['service'] ." for " .$data['client_number']. " on " . $data['inspection_date']);                      
                                });               
                                if (count(Mail::failures()) > 0) {
                                    DB::rollback();
                                    return response()->json([
                                        'message' => 'error',
                                    ],500);

                                }
                                else{
                                    DB::commit();
                                    return response()->json([
                                        'message' => 'OK',
                                    ],200);
                                }
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
    //---------Added By Rommel ----- 03/26/2021-----//
    public function getInspectionLoadingProjectFormCopySupplier($id){
        $sub_acc="no";
        $privelege="";
        $client_id="";
        $g = User::select('group_id')->where('id',Auth::id())->first();
        if(empty($g->group_id)){
            $client_id = Auth::id();
            $sub_acc="no";
        } else {
            $client_id = $g->group_id;
            $sub_acc="yes";
            $privelege = SubAccountPrivelege::where('user_id',Auth::id())->first();
        }

        //SUPPLIER DATA
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $users = DB::table('users')->where('client_code',$supplierData->client_code)->first();

        $client_id=Auth::id();
        $role = User::where('id',$client_id)->first();
        $client = UserInfo::where('id',$client_id)->first();
        $client_code=$users->client_code;
        $inspection = Inspection::where('id',$id)->first();
        //factory
        $get_factory = Factory::where('id',$inspection->factory)->first();
        $get_fc = FctoryContact::where('id',$inspection->factory_contact_person)->first();
        $factory_list = Factory::where('supplier_id',$supplierData->id)->orderBy('factory_name','asc')->pluck('factory_name','id');
        $factory_con_list = FctoryContact::where('factory_id',$inspection->factory)->orderBy('factory_contact_person','asc')->pluck('factory_contact_person','id');
        //suppplier
        $supplier_list = Supplier::where('supplier_status','!=',2)->where('client_code',$client_code)->orderBy('supplier_name', 'asc')->pluck('supplier_name','id');
        $supplier_info = Supplier::where('id',$inspection->supplier_id)->first();
        $supplier_con_list = SupplierContact::where('supplier_id',$inspection->supplier_id)->orderBy('supplier_contact_person','asc')->pluck('supplier_contact_person','id');
        $supplier_con_info = SupplierContact::where('id',$inspection->supplier_contact_id)->first();
        //user
        $user_info = UserInfo::where('user_id',$client_id)->first();
        $user = User::where('id',Auth::id())->first();

        ///05-07-2021
        // $supplierContactNew = DB::table('supplier_datas')
        //     ->join('client_contacts', 'client_contacts.id', '=', 'supplier_datas.supplier_client_contact_id')
        //      ->where('supplier_datas.user_id',Auth::id())
        //     ->orderBy('client_contacts.contact_person','asc')->pluck('client_contacts.contact_person','client_contacts.id'); 

      
        //other
        $client_contact = ClientContact::where('client_code',$users->client_code)->orderBy('contact_person','asc')->pluck('contact_person','id');
        $get_cc = ClientContact::where('id',$inspection->contact_person)->first();

        $clientName = DB::table('clients')->where('id', $user->group_id)->first();

        // //reference number
        // $reference_num = $this->getReferenceNumber($client_code,$inspection->inspection_date);

        return view('pages.supplier.copy-project.index_loading',compact('role','user_info','client_id','client_code','client_contact','inspection','get_factory',
        'get_fc','factory_con_list','factory_list','get_cc','user','supplier_list','supplier_con_list','supplier_info','supplier_con_info','sub_acc','privelege',
        'supplierInfo','supplierData','clientName'));
    }


    public function copyLoadingInspectionSupplier(Request $request){
        $validator = Validator::make($request->all(), [
            'edit_inspection_id' => 'required',
            'loading_client' => 'required',
            'loading_contact_person' => 'required', 
            'loading_supplier' => 'required',
            'loading_supplier_contact_person' => 'required',
            'loading_factory' => 'required',
            'loading_factory_contact_person' => 'required',
            'loading_inspection_date' => 'required',
            //'shipment_date' => 'required',
            'loading_service' => 'required',
            'loading_reference_number' => 'required',
            'client_project_number_cbpi' => 'required',
        ]);
        //SUPPLIER DATA
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        if($validator->fails()) {
            return response()->json([
                'message' => 'Empty fields',
            ],500);
        }else{
            DB::beginTransaction();
            try{
                $auth_id=Auth::id();
                //get user type
                $user_data = User::where('id',Auth::id())->first();
                $user_type=null;
                if($user_data->user_type=='tic_sera'){
                    $user_type='tic_sera';
                }

                $eid=$request['edit_inspection_id'];
                $inspection = new Inspection();
                //inspection details
                $inspection->service = $request['loading_service'];
                $inspection->reference_number = $request['loading_reference_number'];
                $inspection->client_project_number = $request['client_project_number_cbpi'];
                $inspection->inspection_date = $request['loading_inspection_date'];
                $inspection->inspection_date_to = $request['loading_inspection_date_to'];
                $inspection->shipment_date = $request['shipment_date'];
                // $inspection->factory_change_date = $request['loading_fac_change_date'];
                $inspection->client_id = $request['loading_client'];
                $inspection->contact_person = $request['loading_contact_person'];
                //supplier details
                $inspection->supplier_id = $request['loading_supplier'];
                $inspection->supplier_contact_id = $request['loading_supplier_contact_person'];
                //factory details
                $inspection->factory = $request['loading_factory'];
                $inspection->factory_contact_person = $request['loading_factory_contact_person'];
                $inspection->factory_contact_person2 = $request['factory_contact_person2_cbpi'];

                $inspection->supplier_name = $supplierData->supplier_name;
            
                $inspection->requirement = $request['loading_requirements'];
                $inspection->memo = $request['memo'];
                $inspection->inspector_id = 0;
                $inspection->secondary_inspector_id = $request['second_inspector'];
                $inspection->manday = 1;

                $loading_template=$request['loading_template'];
                if($loading_template=="" || $request['project_type_cbpi']=="word_project" || $request['project_type_cbpi']=="esprit"){$loading_template=0;}

                $report_template=$request['loading_report_template'];
                if($report_template=="" || $report_template=='N/A'){$report_template=null;}
                $report_template=null;
                $inspection->word_template = $report_template;

                $inspection->template_id = $loading_template;
                $inspection->project_type = $request['project_type_cbpi'];

                $inspection->inspection_type = $user_type;

                $inspection->inspection_status = "Client Pending";
                $inspection->client_book = "false";
                $inspection->supplier_book = "true";//05-07-2021
                $inspection->client_book_id =  Auth::id();
                $inspection->created_by =  Auth::id();


                if($request['loading_invisible'] == "on"){
                    $inspection->Clientstatus = '1';
                }

                if ($inspection->save()) {
                    $new_ins_id=$inspection->id;

                    $clientCost = new ClientCost();
                    $clientCost->inspection_id =  $inspection->id;
                    $clientCost->currency =  'usd';
                    $clientCost->md_charges =  0;
                    $clientCost->travel_cost =  0;
                    $clientCost->hotel_cost =  0;
                    $clientCost->ot_cost =  0; 
                    $clientCost->save();

                    $inspectorCost = new InspectorCost();
                    $inspectorCost->inspection_id =  $inspection->id;
                    $inspectorCost->currency =  'usd';
                    $inspectorCost->md_charges =  0;
                    $inspectorCost->travel_cost =  0;
                    $inspectorCost->hotel_cost =  0;
                    $inspectorCost->ot_cost =  0; 
                    $inspectorCost->save();

                    $upload_file_name=array();
                    $service = [
                        'iqi' => 'Incoming Quality Inspection',
                        'dupro' => 'During Production Inspection',
                        'psi' => 'Pre Shipment Inspection',
                        'cli' => 'Container Loading Inspection',
                        'cbpi' => 'CBPI - No Serial',
                        'physical' => 'Factory Audit',
		        		'detail' => 'Detail Audit',
                        'social' => 'Social Audit',
                        'st' => 'Sample Test'
                    ];
                    $get_attachment=Attachment::where('inspection_id',$eid)->get();
                    if($get_attachment){
                        $edit_dir="images/project2/".$eid."/"; 
                        $new_dir="images/project2/".$new_ins_id."/"; 
                        foreach ($get_attachment as $att) {                   
                            $new_att= new Attachment();
                            $new_att->inspection_id = $new_ins_id;
                            $new_att->project_number = $request['loading_reference_number'];
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
                        }

                    }
                    if($request->file('file')){
                        foreach ($request->file('file') as $file) {
                            $filename = $file->getClientOriginalName();
                            $filename=str_replace("#","_",$filename);
                            $dir="images/project2/".$new_ins_id."/";
                            //move the files to the correct folder
                            if (!File::exists($dir)) {
                                File::makeDirectory($dir);
                            }
                            //move the files to the correct folder
                            $file->move($dir,$filename);
                            //push file name in array
                            array_push($upload_file_name,$dir.$filename);

                            //save details to db
                            $doc= new Attachment();
                            $doc->inspection_id = $new_ins_id;
                            $doc->project_number = $request['loading_reference_number'];
                            $doc->file_name = $filename;
                            $doc->file_size = 3212334;
                            $doc->path = $dir.$filename;
                            $doc->save();
                        }
                    }

                    $client = Client::where('client_code',$request['loading_client'])->first();
                
                    $password = mt_rand(100000, 999999);
                
                    $report = new Report();
                    $report->inspection_id = $new_ins_id;
                    $report->client_code = $request['loading_client'];
                    $report->service = $request['loading_service'];
                    $report->inspection_date = $request['loading_inspection_date'];
                    $report->inspector_id = $request['loading_inspector'];
                    $report->report_no = $request['loading_reference_number'];
                    $report->password = $password;
                    $email_po_number="No PO #";
                    if ($report->save()) {
                        $client_info = UserInfo::find(Auth::id());
                        $factory = Factory::where('id',$request['loading_factory'])->first();
                        $factory_cont = FctoryContact::where('id',$request['loading_factory_contact_person'])->first();
                        $psi_product_list=null;
                        $data = ['report_number' =>  $request['loading_reference_number'],
                                'service'=>$service[$request['loading_service']],
                                'inspection_date'=>$request['loading_inspection_date'],
                                'inspection_date_to'=>$request['loading_inspection_date_to'],
                                'client_number'=>$request['client_project_number_cbpi'],
                                'c_name'=> $client->Company_Name,
                                'c_email'=> $client->Company_Email,
                                'client_info'=>$client_info,
                                'email_po_number'=>$email_po_number,
                                'factory'=>$factory,
                                'factory_cont'=>$factory_cont,
                                'file_passed'=>$upload_file_name,
                                'psi_product_list'=>$psi_product_list,
                                'client_email'=>$client_info->email_address,
                                'dear_client'=>$client_info->name,
                                'requirement'=>$request['loading_re    quirements'],
                                'memo'=>$request['memo'],
                                'user_type'=>$user_type,
                                'auth_id' => $auth_id
                            ];
                            Mail::send('email.book_from_client',$data, function($message) use ($data){
                                if($data['client_email']){
                                    // $message->to($data['client_email']);
                                    // $message->to($data['c_email']);
                                    $message->to('miguelbuojr@gmail.com');
                                    
                                }else{
                                    // $message->to('booking@t-i-c.asia');
                                }
                                // $message->bcc('booking@t-i-c.asia');
                                // $message->bcc('it-support@t-i-c.asia');
                                // $message->bcc('gregor@t-i-c.asia');
                                // $message->bcc('gregor.voege@web.de');                    
                                if($data['user_type']=='tic_sera'){
                                    // $message->bcc('aarreola@sera.com.mx','Aarreola');       
                                    // $message->bcc('coordination@sera.com.mx','Coordination');    
                                    if($data['auth_id']=='904' || $data['auth_id']==904){
                                        // $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                        // $message->bcc('sera.asiaop@outlook.com','SeraAsiaop');
                                        // $message->bcc('aarreola.sera@gmail.com','AarreolaSera');
                                    }

                                }else{
                                    // $message->bcc('1249484103@qq.com');                            
                                    // $message->bcc('2891400188@qq.com');
                                }
                                $message->subject("Supplier Booked - ".$data['service'] ." for " .$data['client_number']. " on " . $data['inspection_date']);    
                                /* remove attachment 08/01/2020*/ 
                                /* if($data['file_passed']){ 
                                    foreach ($data['file_passed'] as $file_name) {
                                        $message->attach($file_name);
                                    }     
                                }    */                                     
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

}