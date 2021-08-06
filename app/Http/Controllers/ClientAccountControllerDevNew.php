<?php

namespace App\Http\Controllers;

use App\Template;
use Dompdf\Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Category;
use App\SubCategory;
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
//use App\ProductPhotos;
use App\productphotos;
use App\SavedProductCategories;
use App\SavedProductSubCategories;

use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use PhpParser\Node\Expr\Array_;
use Session;
use Mail;
use Symfony\Component\DomCrawler\Crawler;
use ZipArchive;


class ClientAccountControllerDevNew extends Controller
{

    public function getDashboardPanelClient($id){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'cli' => 'Container Loading Inspection',
                    'pls' => 'Setting Up Production Lines',
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

        $services_client = [
            'iqi'=> 'Incoming Quality Inspection',
            'dupro'=> 'During Production Inspection',
            'psi'=> 'Pre Shipment Inspection',
            'cbpi' => 'CBPI - No Serial',
            'cli'=> 'Container Loading Inspection',
            'physical' => 'Factory Audit',
			'detail' => 'Detail Audit',
			'social' => 'Social Audit'
        ];
                
    	$role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
            ->where('role_user.user_id',Auth::id())->first();
            
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $client_code=$user_info->client_code;

        $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('clients.client_code',$client_code)
                    ->where('inspections.inspection_status','!=','Deleted')
                    ->where('inspections.client_book','true')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->get();
        $inspector_list=array();
        $user_manager = UserInfo::all();
        foreach($user_manager as $user){
            $inspector_list[$user->id] = $user->name;
        }

        $product = Product::all();
        $psiproduct = PSIProduct::all();
        /* if($user->levelState==0){
            return view('pages.client.dashboard2.index',compact('inspections','services','role','user_info','user_manager','product','psiproduct','services_new','inspector_list','services_client','user'));    	
        }else{
        return view('pages.client.dashboard.index',compact('inspections','services','role','user_info','user_manager','product','psiproduct','services_new','inspector_list','services_client','user'));    
        } */
        return view('pages.client.dashboard.index',compact('inspections','services','role','user_info','user_manager','product','psiproduct','services_new','inspector_list','services_client','user'));   
    }

    public function getDashboardPanelClientByBooking(){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'cli' => 'Container Loading Inspection',
                    'pls' => 'Setting Up Production Lines',
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

        $services_client = [
            'iqi'=> 'Incoming Quality Inspection',
            'dupro'=> 'During Production Inspection',
            'psi'=> 'Pre Shipment Inspection',
            'cli'=> 'Container Loading Inspection',
            'cbpi' => 'CBPI - No Serial',
            'physical' => 'Factory Audit',
			'detail' => 'Detail Audit',
			'social' => 'Social Audit'
        ];
                
    	$role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
            ->where('role_user.user_id',Auth::id())->first();
            
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $client_code=$user_info->client_code;

        $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('inspections.client_id',$client_code)
                    ->where('inspections.client_book',null)
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->get();
        $inspector_list=array();
        $user_manager = UserInfo::all();
        foreach($user_manager as $user){
            $inspector_list[$user->id] = $user->name;
        }

        $product = Product::all();
        $psiproduct = PSIProduct::all();
        return view('pages.client.dashboardBook.index',compact('inspections','services','role','user_info','user_manager','product','psiproduct','services_new','inspector_list','services_client','user'));   
    }

    public function getProductDashboard(){
        $services_client = [
            'iqi'=> 'Incoming Quality Inspection',
            'dupro'=> 'During Production Inspection',
            'psi'=> 'Pre Shipment Inspection',
            'cli'=> 'Container Loading Inspection',
            'cbpi' => 'CBPI - No Serial',
            'physical' => 'Factory Audit',
			'detail' => 'Detail Audit',
			'social' => 'Social Audit'
        ];

        $role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
            ->where('role_user.user_id',Auth::id())->first();
            
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $client_code=$user_info->client_code;

        $products = Product::where('client_code',$client_code)
                    ->where('status',0)
                    ->get();

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
        $p_categories  = SavedProductCategories::where('user_id',Auth::id())->get();
        foreach($p_categories as $cat){
            $p_category += [$cat->category => $cat->category];
        }
        ksort($p_category);
        $p_category += ['Others' => 'Others'];

		return view('pages.client.product.index',compact('role','user_info','client_code','products','user','p_category'));    	
    }

    public function getProductPhoto(Request $request){
        $id=$request['id'];
        $product=DB::table('product_photos')
        ->where('product_id',$id)->get();
        
       
        return response()->json([
            'productphoto' => $product
        ]);

    }


    

    public function getInspectionProjectForm(){
        $client_id=Auth::id();
        $role = User::where('id',$client_id)->first();
        $client = UserInfo::where('id',$client_id)->first();
        $client_code=$client->client_code;

        date_default_timezone_set('UTC');
        $year=date("y");
        $month=date("m");
        $Inspection = Inspection::where('client_id',$client_code)->get();
        $count = $Inspection->count();

        $get_count=$count+1;
		$set_count;
		if($get_count<=9){
			$set_count='0'.''.$get_count;
		}else{
			$set_count=$get_count;
		}

        $ref_num=$client_code.'-'.$year.''.$month.'-'.$set_count;
       
        $countries = Country::all();
        $factories = Factory::where('factory_status','!=',2)->where('client_code',$client_code)->orderBy('factory_name', 'asc')->get();
        $suppliers = Supplier::where('supplier_status','!=',2)->where('client_code',$client_code)->orderBy('supplier_name', 'asc')->get();
        $user_info = UserInfo::where('user_id',$client_id)->first();
        $user = User::where('id',Auth::id())->first();
        $inspectors = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->pluck('name','user_id');

        $inspectors_two = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->get();

        $inspectors_new = DB::table('users')
                        ->join('user_infos','user_infos.user_id','=','users.id')
                        ->orderBy('user_infos.name','asc')
                        ->pluck('user_infos.name','users.id');


        $products = Product::orderBy('product_name', 'desc')->get();

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
        $p_categories  = SavedProductCategories::where('user_id',Auth::id())->get();
        foreach($p_categories as $cat){
            $p_category += [$cat->category => $cat->category];
        }
        ksort($p_category);
        $p_category += ['Others' => 'Others'];

		
		//Categories
        $categories = Category::orderBy('name', 'desc')->get()->pluck('id','name');
        $sub_categories = SubCategory::orderBy('name', 'desc')->get()->pluck('id','category_id','name');

         
        $client_contact = ClientContact::where('client_code',$client_code)->get();
        $client_aql_detail = ClientAqlDetail::where('client_id',Auth::id())->first();
        $client_aql_minors_orig = ClientAqlMinor::all();
        $client_aql_majors_orig = ClientAqlMajor::all();
		
        $client_aql_minors = $client_aql_minors_orig->pluck('aql','aql');
        $client_aql_majors = $client_aql_majors_orig->pluck('aql','aql');
        $normal=['I'=>'I','II'=>'II','III'=>'III'];
        $special=['S1'=>'S1','S2'=>'S2','S3'=>'S3','S4'=>'S4'];
        $aql_major = ['0.065'=>'0.065','0.1'=>'0.1','0.15'=>'0.15','0.25'=>'0.25','0.40'=>'0.40','1'=>'1','1.5'=>'1.5','2.5'=>'2.5','4'=>'4','6.5'=>'6.5','10'=>'10'];
        $units=['piece'=>'Piece/s','roll'=>'Roll/s','set'=>'Set/s','pair'=>'Pair/s','box'=>'Box/es'];
        
        $services=[];
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
        
        
        return view('pages.client.project.index_dev2',compact('role','user_info','inspectors','factories','countries','products','inspectors_new','inspectors_two','client_id','client_code','ref_num','client_contact','client_aql_detail','client_aql_minors','client_aql_majors','normal','special','$aql_major','user','suppliers','units','categories','sub_categories','p_category','services'));
    }

    public function getInspectionProjectFormEdit($id){
        $client_id=Auth::id();
        $role = User::where('id',$client_id)->first();
        $client = UserInfo::where('id',$client_id)->first();
        $client_code=$client->client_code;
        $inspection = Inspection::where('id',$id)->first();
        //factory
        $get_factory = Factory::where('id',$inspection->factory)->first();
        $get_fc = FctoryContact::where('id',$inspection->factory_contact_person)->first();
        $factory_list = Factory::where('client_code',$client_code)->orderBy('factory_name','asc')->pluck('factory_name','id');
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
        $products = Product::where('client_code',$client_code)->where('status',0)->orderBy('product_name', 'asc')->pluck('product_name','id');
        $psiproducts = PSIProduct::where('inspection_id',$id)->get();
        $units=['piece'=>'Piece/s','roll'=>'Roll/s','set'=>'Set/s','pair'=>'Pair/s','box'=>'Box/es'];
        $attach_count=0;
        $attach_arr=array();
        foreach($psiproducts as $pp){
            $product_attachment=DB::table('product_photos')->where('product_id',$pp->product_id)->get();
            $attach_count=count($product_attachment);
            //$data=[$pp->product_id => $attach_count];
            //array_push($attach_arr,$data);
            $attach_arr[$pp->product_id] = $attach_count;  
        }
        
        
        //product category
        $jsonurl = "http://ticapp.tk/json/categories.json";
        $json = file_get_contents($jsonurl);
        $categories = json_decode($json);
        //other
        $client_contact = ClientContact::where('client_code',$client_code)->orderBy('contact_person','asc')->pluck('contact_person','id');
        $get_cc = ClientContact::where('id',$inspection->contact_person)->first();
        //aql details
        $client_aql_detail = ClientAqlDetail::where('client_id',Auth::id())->first();
        $client_aql_minors_orig = ClientAqlMinor::all();
        $client_aql_majors_orig = ClientAqlMajor::all();
        $client_aql_minors = $client_aql_minors_orig->pluck('aql','aql');
        $client_aql_majors = $client_aql_majors_orig->pluck('aql','aql');
        $normal=['I'=>'I','II'=>'II','III'=>'III'];
        $special=['S1'=>'S1','S2'=>'S2','S3'=>'S3','S4'=>'S4'];
        $aql_major = ['0.065'=>'0.065','0.1'=>'0.1','0.15'=>'0.15','0.25'=>'0.25','0.40'=>'0.40','1'=>'1','1.5'=>'1.5','2.5'=>'2.5','4'=>'4','6.5'=>'6.5','10'=>'10'];
        return view('pages.client.edit-project.index',compact('role','user_info','products','client_id','client_code','client_contact','client_aql_detail','client_aql_minors','client_aql_majors','inspection','get_factory','get_fc','factory_con_list','factory_list','get_cc','client_aql_majors','normal','special','$aql_major','user','supplier_list','supplier_con_list','supplier_info','supplier_con_info','psiproducts','units','categories','attach_arr'));
    }


    //Added Jesser for button view project of client
    public function getInspectionDetails($id){
        $user_info = UserInfo::where('user_id',Auth::id())->first();
   
        $reference = Report::where('inspection_id',$id)->get();

        $inspection_new = DB::table('inspections')
                        ->where('id',$id)                    
                        ->first(); 

        $clients = Client::where('client_code',$inspection_new->client_id)->first();
        $factory = Factory::where('id',$inspection_new->factory)->first();
        $client_contact_list=array();
        $client_contact=explode(',',$inspection_new->contact_person);

        foreach($client_contact as $contact){
            $data = ClientContact::where('id',$contact)->first();
            array_push($client_contact_list,$data);
        }

        $factory_contact_list=array();
        $factory_contact=explode(',',$inspection_new->factory_contact_person2);
        foreach($factory_contact as $contact){
            $data = FctoryContact::where('id',$contact)->first();
            array_push($factory_contact_list,$data);
        }

        $factory_contact1 = FctoryContact::where('id',$inspection_new->factory_contact_person)->first();

        $psi_product = DB::table('p_s_i_products')
                    ->where('inspection_id',$id)
                    ->get(); 
        $products = DB::table('products')
                    ->get(); 
        $attachments =  DB::table('attachments')
                    ->where('inspection_id',$id) 
                    ->where('uploaded_by',null)                   
                    ->get(); 

        return response()->json([
            'user_info' => $user_info,
            'inspection_new' => $inspection_new,
            'reference' => $reference,
            'clients'=> $clients,
            'attachments'=> $attachments,
            'client_contact_list'=>$client_contact_list,
            'factory'=>$factory,
            'factory_contact_list'=>$factory_contact_list,
            'factory_contact1'=>$factory_contact1,
            'psi_product'=>$psi_product,
            'products'=>$products
        ]);
    }

    public function getEditAQL($id){
        $psi_product = PSIProduct::where('id',$id)->first();
        return response()->json([
            'psi_product'=> $psi_product
        ]);
    }

    public function getAttachments($id){
        $attachment = Attachment::where('inspection_id',$id)->get();
        return response()->json([
            'attachment'=> $attachment
        ]);
    }


    public function deleteAttachments(Request $request){
        //$del_att = Attachment::find($id);
        $cond=['inspection_id'=>$request['inspection_id'],'file_name'=>$request['file_name']];
        $del_att=DB::table('attachments')->where($cond)->delete();

    }

    public function updateDraftAQL(Request $request){
        $prods = PSIProduct::find($request['aql_product_id']);
        $prods->aql_qty = $request['aql_qty'];
        $prods->aql_qty_unit = $request['aql_qty_unit'];
        $prods->aql_normal_level = $request['aql_normal_level'];
        $prods->aql_special_level = $request['aql_special_level'];
        $prods->aql_major = $request['aql_major'];
        $prods->max_allowed_major = $request['max_major'];
        $prods->aql_minor = $request['aql_minor'];
        $prods->max_allowed_minor = $request['max_minor'];
        $prods->aql_normal_letter = $request['aql_normal_letter'];
        $prods->aql_normal_sampsize = $request['aql_normal_sampsize'];
        $prods->aql_special_letter = $request['aql_special_letter'];
        $prods->aql_special_sampsize = $request['aql_special_sampsize'];
        $prods->save();
    }

    public function deleteDraftProduct($id){
        $psi_product = PSIProduct::find($id);
        $psi_product->delete();
    }


    public function postInspectionData(Request $request){
        DB::beginTransaction();
        try {
            //get user type
            $user_data = User::where('id',Auth::id())->first();
            $user_type=null;
            if($user_data->user_type=='tic_sera'){
                $user_type='tic_sera';
            }
            $inspection = new Inspection();
            //inspection details
            $inspection->client_id = $request['client'];
            $inspection->contact_person = $request['contact_person'];
            //factory details
            $inspection->supplier_id = $request['supplier'];
            $inspection->supplier_contact_id = $request['supplier_contact_person'];
            //factory details
            $inspection->factory = $request['factory'];
            $inspection->factory_contact_person = $request['factory_contact_person'];
            $inspection->factory_contact_person2 = $request['factory_contact_person2_psi'];
            //inspection details
            $inspection->inspector_id = 0;
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->manday = $request['manday'];
            $inspection->inspection_date = $request['inspection_date'];
            $inspection->inspection_date_to = $request['inspection_date_to'];
            $inspection->shipment_date = $request['psi_shipment_date'];
            $inspection->factory_change_date = $request['fac_change_date'];
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
            $inspection->word_template = $report_template;

            $inspection->template_id = $template;
            $inspection->project_type = $request['type_of_project'];

            $inspection->inspection_type = $user_type;

            $inspection->inspection_status = "Client Pending";
            $inspection->client_book = "true";
            $inspection->client_book_id =  Auth::id();
            $inspection->created_by =  Auth::id();

            $email_po_number="";

            if($request['invisible'] == "on"){
                $inspection->Clientstatus = '1';
            }

            if ($inspection->save()) {
                $products = $request['product_id'];
                $inserted_inspection_id=$inspection->id;

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

               

                foreach ($products as $i => $value) {
                    $prods[$i] = new PSIProduct();
                    $prods[$i]->inspection_id = $inspection->id;
                    $prods[$i]->product_id = $request['product_id'][$i];
                    $prods[$i]->product_name = $request['product_name'][$i];
                    $prods[$i]->product_first_category = $request['product_category'][$i];
                    $prods[$i]->product_category = $request['product_sub_category'][$i];
                    $prods[$i]->brand = $request['brand'][$i];
                    $prods[$i]->po_no = $request['po_number'][$i];
                    $prods[$i]->model_no = $request['model_no'][$i];
                    $prods[$i]->additional_product_info = $request['addtnl_pinfo'][$i];
                    //$prods[$i]->product_unit = $request['p_unit'][$i];
                    //$prods[$i]->cmf = $request['cmf'][$i];
                    //$prods[$i]->product_number = $request['prod_number'][$i];
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
                    $product = Product::find($request['product_id'][$i]);
                    array_push($products_id,$request['product_id'][$i]);
                    array_push($prod_name,$product->product_name);
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
                    
                    if( $email_po_number==''){
                        $email_po_number=$request['po_number'][$i];
                    }else{
                        $email_po_number=$email_po_number.','.$request['po_number'][$i];
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
				    'social' => 'Social Audit'
                ];
                if($request->file('file')){
                    foreach ($request->file('file') as $file) {
                        $filename = $file->getClientOriginalName();    
                        $filename=str_replace("#","_",$filename);                
                        //directory
                        $dir="images/project2/".$inserted_inspection_id."/";               
                        //move the files to the correct folder
                        if (!File::exists($dir)) {
                            File::makeDirectory($dir);
                        }
                        $file->move($dir,$filename);
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
                    }
                }

                $client = Client::where('client_code',$request['client'])->first();
             
                $password = mt_rand(100000, 999999);
                $report_no = $request['reference_number'];

                $report = new Report();
                $report->inspection_id = $inspection->id;
                $report->client_code = $client->client_code;
                $report->service = $service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->inspector_id=$request['inspector'];
                $report->report_no = $report_no;
                $report->password = $password;         
                if ($report->save()) {
                    $client_info = UserInfo::find(Auth::id());
                    $psi_product_list = PSIProduct::where('inspection_id',$inserted_inspection_id)->get();
                    $factory = Factory::where('id',$request['factory'])->first();
                    $factory_cont = FctoryContact::where('id',$request['factory_contact_person'])->first();
                    $data = ['report_number' =>  $request['reference_number'],
                            'service'=>$service[$request['service']],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'manday'=>$request['manday'],
                            'client_number'=>$request['client_project_number'],
                            'c_name'=> $client->Company_Name,
                            'email_po_number'=>$email_po_number,
                            'psi_product_list'=>$psi_product_list,
                            'factory'=>$factory,
                            'factory_cont'=>$factory_cont,
                            'file_passed'=>$upload_file_name,
                            'products_id'=>$products_id,
                            'client_email'=>$client_info->email_address,
                            'dear_client'=>$client_info->name,
                            'requirement'=>$request['requirement'],
                            'memo'=>$request['memo'],
                            'user_type'=>$user_type
                        ];
                        Mail::send('email.book_from_client',$data, function($message) use ($data){
                                                    
                            if($data['client_email']){
                                $message->to($data['client_email'],$data['c_name']);
                            }else{
                                $message->to('booking@t-i-c.asia','Booking');
                            }
                            $message->bcc('booking@t-i-c.asia','Booking');
                            $message->bcc('it-support@t-i-c.asia','IT Support');
                            $message->bcc('report@t-i-c.asia','Report');				
                            $message->bcc('gregor@t-i-c.asia','Gregor');      
                            //$message->bcc('gregor.voege@web.de');
                            if($data['user_type']=='tic_sera'){
                                $message->bcc('aarreola@sera.com.mx','Aarreola');    
                                $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                $message->bcc('coordination@sera.com.mx','Coordination');  
                                //$message->cc('zen4emil@gmail.com','Emil');  
                            }else{
                                $message->bcc('1249484103@qq.com');                             
                                $message->bcc('2891400188@qq.com');
                                //$message->cc('jessergalapon00@gmail.com','Jesser');  
                            }
                                  
                            $message->subject("Client-".$data['client_number']);
                            /* remove attachment 08/01/2020*/
                            /* if($data['file_passed']){ 
                                foreach ($data['file_passed'] as $file_name) {
                                    $message->attach($file_name);
                                }     
                            }
                            if($data['products_id']){         
                                foreach ($data['products_id'] as $pid) {
                                    $p_photos = DB::table('product_photos')->where('product_id',$pid)->get();
                                    if($p_photos){
                                        foreach ($p_photos as $p) {
                                            $p_src="js/dropzone/upload/".$p->photo_category."/".$p->user_id."/".$p->file_name;
                                            //$p_src="js/dropzone/upload/".$p->photo_category."/".$client->client_code."/".$p->file_name;
                                            $message->attach($p_src);
                                        }   
                                    }
                                }       
                            } */                         
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

    public function postCBPIData(Request $request){
        DB::beginTransaction();
        try{
            $user_data = User::where('id',Auth::id())->first();
            $user_type=null;
            if($user_data->user_type=='tic_sera'){
                $user_type='tic_sera';
            }

            $inspection = new Inspection();
            //inspection details
            $inspection->service = $request['loading_service'];
            $inspection->reference_number = $request['loading_reference_number'];
            $inspection->client_project_number = $request['client_project_number_cbpi'];
            $inspection->inspection_date = $request['loading_inspection_date'];
            $inspection->inspection_date_to = $request['loading_inspection_date_to'];
            $inspection->shipment_date = $request['shipment_date'];
            $inspection->factory_change_date = $request['loading_fac_change_date'];
            $inspection->client_id = $request['loading_client'];
            $inspection->contact_person = $request['loading_contact_person'];
            //supplier details
            $inspection->supplier_id = $request['loading_supplier'];
            $inspection->supplier_contact_id = $request['loading_supplier_contact_person'];
            //factory details
            $inspection->factory = $request['loading_factory'];
            $inspection->factory_contact_person = $request['loading_factory_contact_person'];
            $inspection->factory_contact_person2 = $request['factory_contact_person2_cbpi'];

            $inspection->supplier_name = $request['loading_supplier_name'];
        
            $inspection->requirement = $request['loading_requirements'];
            $inspection->memo = $request['memo'];
            $inspection->inspector_id = 0;
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->manday = $request['manday'];

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
            $inspection->client_book = "true";
            $inspection->client_book_id =  Auth::id();
            $inspection->created_by =  Auth::id();


            if($request['loading_invisible'] == "on"){
                $inspection->Clientstatus = '1';
            }

            if ($inspection->save()) {
                $inserted_inspection_id=$inspection->id;

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
		    		'social' => 'Social Audit'
                ];
                if($request->file('file')){
                    foreach ($request->file('file') as $file) {
                        //set a unique file name
                        //$filename = uniqid().'.'.$file->getClientOriginalExtension();

                        $filename = $file->getClientOriginalName();
                        $filename=str_replace("#","_",$filename);

                        $dir="images/project2/".$inserted_inspection_id."/";

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
                        $doc->inspection_id = $inserted_inspection_id;
                        $doc->project_number = $request['loading_reference_number'];
                        $doc->file_name = $filename;
                        /* $doc->file_size = $file->getSize(); */
                        $doc->file_size =  $file->getSize();
                        $doc->path = $dir.$filename;
                        $doc->save();
                    }
                }

                $client = Client::where('client_code',$request['loading_client'])->first();
            
                $password = mt_rand(100000, 999999);

                $report = new Report();
                $report->inspection_id = $inspection->id;
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
                            'email_po_number'=>$email_po_number,
                            'factory'=>$factory,
                            'factory_cont'=>$factory_cont,
                            'file_passed'=>$upload_file_name,
                            'psi_product_list'=>$psi_product_list,
                            'client_email'=>$client_info->email_address,
                            'dear_client'=>$client_info->name,
                            'requirement'=>$request['loading_requirements'],
                            'memo'=>$request['memo'],
                            'user_type'=>$user_type
                        ]; 
                        Mail::send('email.book_from_client',$data, function($message) use ($data){
                            if($data['client_email']){
                                $message->to($data['client_email'],$data['c_name']);
                            }else{
                                $message->to('booking@t-i-c.asia','Booking');
                            }
                            $message->bcc('booking@t-i-c.asia','Booking');
                            $message->bcc('it-support@t-i-c.asia','IT Support');
		    				$message->bcc('report@t-i-c.asia','Report');
                            $message->bcc('gregor@t-i-c.asia','Gregor');
                            //$message->bcc('gregor.voege@web.de');
                            if($data['user_type']=='tic_sera'){
                                $message->bcc('aarreola@sera.com.mx','Aarreola');    
                                $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                $message->bcc('coordination@sera.com.mx','Coordination');    
                            }else{
                                $message->bcc('1249484103@qq.com');                             
                                $message->bcc('2891400188@qq.com');
                            }
                            $message->subject("Client-".$data['client_number']);  
                            /* remove attachment 08/01/2020*/   
                            /* if($data['file_passed']){ 
                                foreach ($data['file_passed'] as $file_name) {
                                    $message->attach($file_name);
                                }     
                            }   */                                      
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

    public function postSiteData(Request $request){
        DB::beginTransaction();
        try{
            $user_data = User::where('id',Auth::id())->first();
            $user_type=null;
            if($user_data->user_type=='tic_sera'){
                $user_type='tic_sera';
            }
            $inspection = new Inspection();
            $inspection->service = $request['site_service'];
            $inspection->reference_number = $request['site_reference_number'];
            $inspection->client_project_number = $request['site_project_number'];
            $inspection->inspection_date = $request['site_inspection_date'];
            $inspection->inspection_date_to = $request['site_inspection_date_to'];
            $inspection->client_id = $request['site_client'];
            $inspection->contact_person = $request['site_contact_person'];

            $inspection->com_name = $request['com_name'];
            $inspection->comp_addr = $request['comp_addr'];
            $inspection->comp_other_info = $request['comp_other_info'];
        
            $inspection->requirement = $request['site_requirements'];
            $inspection->memo = $request['site_memo'];
            $inspection->inspector_id = 0;
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->manday = $request['site_manday'];

            $loading_template=$request['site_template'];
            if($loading_template=="" || $request['project_type_site']=="word_project"){$loading_template=0;}

            $report_template=$request['site_report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}
            $report_template=null;
            $inspection->word_template = $report_template;

            $inspection->template_id = $loading_template;
            $inspection->project_type = $request['project_type_site'];

            $inspection->inspection_type = $user_type;

            $inspection->inspection_status = "Client Pending";
            $inspection->client_book = "true";
            $inspection->client_book_id =  Auth::id();
            $inspection->created_by =  Auth::id();


            if($request['site_invisible'] == "on"){
                $inspection->Clientstatus = '1';
            }

            if ($inspection->save()) {
                $inserted_inspection_id=$inspection->id;

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
                    'pls' => 'Setting up Production Lines',
                    'cbpi' => 'CBPI - No Serial',
                    'cbpi_serial' => 'CBPI - with Serial',
                    'cbpi_isce' => 'CBPI - ISCE',
                    'site_visit' => 'Site Visit',
		    		'SPK' => 'SPK',
		    		'FRI' => 'FRI',
                ];
                foreach ($request->file('file') as $file) {
                    $filename = $file->getClientOriginalName();
                    $filename=str_replace("#","_",$filename);
                    $dir="images/project2/".$inserted_inspection_id."/";
                    if (!File::exists($dir)) {
                        File::makeDirectory($dir);
                    }
                    $file->move($dir,$filename);
                    array_push($upload_file_name,$dir.$filename);
                    $doc= new Attachment();
                    $doc->inspection_id = $inserted_inspection_id;
                    $doc->project_number = $request['site_reference_number'];
                    $doc->file_name = $filename;
                   /*  $doc->file_size = $file->getSize(); */
                   $doc->file_size = 56716;
                    $doc->path = $dir.$filename;
                    $doc->save();
                }
                $client = Client::where('client_code',$request['site_client'])->first();
            
                $password = mt_rand(100000, 999999);

                $report = new Report();
                $report->inspection_id = $inspection->id;
                $report->client_code = $request['site_client'];
                $report->service = $request['site_service'];
                $report->inspection_date = $request['site_inspection_date'];
                $report->inspector_id = $request['site_inspector'];
                $report->report_no = $request['site_reference_number'];
                $report->password = $password;


                if ($report->save()) {
                    $email_po_number='No PO #';
                    $client_info = UserInfo::find(Auth::id());
                    $data = ['report_number' =>  $request['site_reference_number'],
                            'service'=>$service[$request['site_service']],
                            'inspection_date'=>$request['site_inspection_date'],
                            'inspection_date_to'=>$request['site_inspection_date_to'],
                            'manday'=>$request['site_manday'],
                            'client_number'=>$request['site_project_number'],
                            'c_name'=> $client->Company_Name,
                            'email_po_number'=>$email_po_number,
                            'requirement'=>$request['site_requirements'],
                            'memo'=>$request['site_memo'],
                            'user_type'=>$user_type,
                        ];
                        Mail::send('email.book_from_client',$data, function($message) use ($data){
                            $message->to('booking@t-i-c.asia','Booking');
                            $message->bcc('it-support@t-i-c.asia','IT Support');
		    				$message->bcc('report@t-i-c.asia','Report');
                            $message->bcc('gregor@t-i-c.asia','Gregor');    
                            //$message->bcc('gregor.voege@web.de');          
                            if($data['user_type']=='tic_sera'){
                                $message->bcc('aarreola@sera.com.mx','Aarreola');    
                                $message->bcc('asiaop@sera.com.mx','Asiaop');    
                                $message->bcc('coordination@sera.com.mx','Coordination');    
                            }else{
                                $message->bcc('1249484103@qq.com');                            
                                $message->bcc('2891400188@qq.com');
                            }
                            $message->subject("Client-".$data['client_number']);                                              
                        });   
                        DB::commit();
                }
            }
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    //Added Jesser for button view projet
    public function getProjectDetailsNew($id){
        $user_info = UserInfo::where('user_id',Auth::id())->first();
   
        $inspection = DB::table('inspections')
                    ->join('clients','clients.client_code', '=', 'inspections.client_id')
                    ->join('users','inspections.inspector_id', '=', 'users.id')
                    ->join('user_infos','users.id', '=', 'user_infos.user_id')
                    ->join('client_contacts','inspections.contact_person', '=', 'client_contacts.id')
                    ->join('factories','inspections.factory', '=', 'factories.id')
                    ->join('fctory_contacts','inspections.factory_contact_person', '=', 'fctory_contacts.id')
                    ->join('p_s_i_products','inspections.id', '=', 'p_s_i_products.inspection_id')
                    ->join('products','p_s_i_products.product_name', '=', 'products.id')
                    ->select('inspections.*','clients.client_name','users.*','user_infos.*','client_contacts.*','factories.*','fctory_contacts.*','p_s_i_products.*','products.*')
                    ->where('inspections.id',$id)                    
                    ->first();    
        $reference = Report::where('inspection_id',$id)->get();

        $inspection_new = DB::table('inspections')
                        ->where('id',$id)                    
                        ->first(); 

        $clients = Client::where('client_code',$inspection_new->client_id)->first();
        $factory = Factory::where('id',$inspection_new->factory)->first();
        $client_contact_list=array();
        $client_contact=explode(',',$inspection_new->contact_person);

        foreach($client_contact as $contact){
            $data = ClientContact::where('id',$contact)->first();
            array_push($client_contact_list,$data);
        }

        $factory_contact_list=array();
        $factory_contact=explode(',',$inspection_new->factory_contact_person2);
        foreach($factory_contact as $contact){
            $data = FctoryContact::where('id',$contact)->first();
            array_push($factory_contact_list,$data);
        }

        $factory_contact1 = FctoryContact::where('id',$inspection_new->factory_contact_person)->first();

        $psi_product = DB::table('p_s_i_products',$id)
                    ->join('products','p_s_i_products.product_name', '=', 'products.id')
                    ->where('p_s_i_products.inspection_id',$id)
                    ->get();   
        $psi_product2 = DB::table('p_s_i_products')
                    ->where('inspection_id',$id)
                    ->get(); 
        $products = DB::table('products')
                    ->get(); 
        $attachments =  DB::table('attachments')
                    ->where('inspection_id',$id)                    
                    ->get(); 

        return response()->json([
            'user_info' => $user_info,
            'inspection' => $inspection,
            'inspection_new' => $inspection_new,
            'reference' => $reference,
            'psi_product' => $psi_product,
            'clients'=> $clients,
            'attachments'=> $attachments,
            'client_contact_list'=>$client_contact_list,
            'factory'=>$factory,
            'factory_contact_list'=>$factory_contact_list,
            'factory_contact1'=>$factory_contact1,
            'psi_product2'=>$psi_product2,
            'products'=>$products
        ]);
    }

    public function getProjectDetailsCbpiNew($id){
        $user_info = UserInfo::where('user_id',Auth::id())->first(); 
        $inspection = DB::table('inspections')
                    ->join('clients','clients.client_code', '=', 'inspections.client_id')
                    ->join('users','inspections.inspector_id', '=', 'users.id')
                    ->join('user_infos','users.id', '=', 'user_infos.id')
                    ->join('client_contacts','inspections.contact_person', '=', 'client_contacts.id')
                    ->join('factories','inspections.factory', '=', 'factories.id')
                    ->join('fctory_contacts','inspections.factory_contact_person', '=', 'fctory_contacts.id')
                  
                 
                    ->select('inspections.*','clients.client_name','users.*','user_infos.*','client_contacts.*','factories.*','fctory_contacts.*')
                    ->where('inspections.id',$id)
                       
                    ->first();  
        $reference = Report::where('inspection_id',$id)->get();
        $inspection_new = DB::table('inspections')
                        ->where('id',$id)                    
                        ->first();       
        $clients = Client::where('client_code',$inspection_new->client_id)->first();
        $factory = Factory::where('id',$inspection_new->factory)->first();
        $client_contact_list=array();
        $client_contact=explode(',',$inspection_new->contact_person);       
        foreach($client_contact as $contact){
            $data = ClientContact::where('id',$contact)->first();
            array_push($client_contact_list,$data);
        }        
        $factory_contact_list=array();
        $factory_contact=explode(',',$inspection_new->factory_contact_person2);
        foreach($factory_contact as $contact){
            $data = FctoryContact::where('id',$contact)->first();
            array_push($factory_contact_list,$data);
        }       

        $factory_contact1 = FctoryContact::where('id',$inspection_new->factory_contact_person)->first();

 
        $attachments =  DB::table('attachments')
                    ->where('inspection_id',$id)                    
                    ->get(); 
      
        return response()->json([
            'user_info' => $user_info,
            'inspection' => $inspection,
            'inspection_new' => $inspection_new,
            'reference' => $reference,
            'clients'=> $clients,
            'attachments'=> $attachments,
            'client_contact_list'=>$client_contact_list,
            'factory'=>$factory,
            'factory_contact_list'=>$factory_contact_list,
            'factory_contact1'=>$factory_contact1
        ]);
    }

    public function getProjectDetailsSite($id){
        $user_info = UserInfo::where('user_id',Auth::id())->first(); 
        $reference = Report::where('inspection_id',$id)->get();
        $inspection_new = DB::table('inspections')
                        ->where('id',$id)                    
                        ->first();       
        $clients = Client::where('client_code',$inspection_new->client_id)->first();
        $factory = Factory::where('id',$inspection_new->factory)->first();
        $client_contact_list=array();
        $client_contact=explode(',',$inspection_new->contact_person);       
        foreach($client_contact as $contact){
            $data = ClientContact::where('id',$contact)->first();
            array_push($client_contact_list,$data);
        }        
        $factory_contact_list=array();
        $factory_contact=explode(',',$inspection_new->factory_contact_person2);
        foreach($factory_contact as $contact){
            $data = FctoryContact::where('id',$contact)->first();
            array_push($factory_contact_list,$data);
        }       

        $factory_contact1 = FctoryContact::where('id',$inspection_new->factory_contact_person)->first();

 
        $attachments =  DB::table('attachments')
                    ->where('inspection_id',$id)                    
                    ->get(); 
      
        return response()->json([
            'user_info' => $user_info,
            'inspection_new' => $inspection_new,
            'reference' => $reference,
            'clients'=> $clients,
            'attachments'=> $attachments,
            'client_contact_list'=>$client_contact_list,
            'factory'=>$factory,
            'factory_contact_list'=>$factory_contact_list,
            'factory_contact1'=>$factory_contact1
        ]);
    }

    public function uploadFiles(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $imageName=str_replace("#","_",$imageName);
        $image->move(public_path('images/upload'),$imageName);
        
        $imageUpload = new ImageUpload();
        $imageUpload->filename = $imageName;
        $imageUpload->save();
        return response()->json(['success'=>$imageName]);
    }

    public function getAllClientContacts($id){
        //$contacts  = ClientContact::where('client_code',$id)->get();
        $contacts  = ClientContact::where('client_code',$id)->whereNotIn('client_contact_status',[2,1])->get();
        if (!$contacts->isEmpty()) {
            return response()->json([
                'contacts' => $contacts
            ],200);
        }else{
            return response()->json([
                'message' => 'No Contacts Found!'
            ],404);
        }
       
    }

    public function saveNewProductCategory(Request $request){
        if($request['req']=='save_category'){
            $new_category = new SavedProductCategories();
            $new_category->user_id = $request['user_id'];
            $new_category->category = $request['category'];
            if ($new_category->save()) {
                $new_sub_category = new SavedProductSubCategories();
                $new_sub_category->user_id = $request['user_id'];
                $new_sub_category->category_id = $new_category->id;
                $new_sub_category->category = $request['category'];
                $new_sub_category->sub_category = $request['sub_category'];
                if ($new_sub_category->save()) {
                    return response()->json([
                        'id' => $new_category->id,
                    ]);
                }
            }
        }else{
            $new_sub_category = new SavedProductSubCategories();
            $new_sub_category->user_id = $request['user_id'];
            $new_sub_category->category_id = 0;
            $new_sub_category->category = $request['category'];
            $new_sub_category->sub_category = $request['sub_category'];
            if ($new_sub_category->save()) {
                return response()->json([
                    'message' => 'ok',
                ]);
            }
        }
    }
    public function getSavedProductCategory($id){
        $p_categories  = SavedProductCategories::where('user_id',$id)->get();
        return response()->json([
            'categories' => $p_categories
        ]);
    }
    public function getSavedProductSubCategory(Request $request){
        $auth_id=Auth::id();
        $id=$request['id'];
        $pcid  = Category::where('name',$id)->first();
        $orig_sub_categories="";
        if($pcid){
            $orig_sub_categories  = SubCategory::where('category_id',$pcid->id)->get();
        }
        
        $saved_sub_categories  = SavedProductSubCategories::where('category',$id)->where('user_id',$auth_id)->get();
        return response()->json([
            'sub_categories' => $saved_sub_categories,
            'orig_sub_categories' => $orig_sub_categories
        ]);
    }

    public function updateUserState(Request $request){
        $user = User::find($request['user_id']);
        $user->levelState = 1;
        if ($user->save()) {          
            return response()->json([
                'message' => 'ok',
            ]);
        }
    }

    public function getClientContact($id){
        $contact  = ClientContact::find($id);
        //$contact  = ClientContact::where('id',$id)->where('client_contact_status',0)->get();
        return response()->json([
            'contact' => $contact
        ]);
    }
    //Inspector Address
    public function getInspectorAddress($id){
         $address = UserInfo::where('id',$id)->get();
        return response()->json([
            'address' => $address
        ]);
    }
    public function addNewContactAJAX(Request $request){
        $this->validate($request,array(
            'client_code' => 'required',
            'contact_person' => 'required',
            'contact_person_email' =>'required',
            'contact_person_number' => 'required',
        ));
        $client = new ClientContact();
        $client->client_code = $request['client_code'];
        $client->contact_person = $request['contact_person'];
        $client->email_address = $request['contact_person_email'];
        $client->contact_number = $request['contact_person_number'];
        if ($client->save()) {
            return response()->json([
                'contact' =>$client
            ]);
        }

    }

    public function getInspectorCount($id,$insp_date){
        $assignment = Inspection::where('inspector_id',$id)->where('inspection_date',$insp_date)->count();
        return response()->json([
            'count' => $assignment
        ]);
    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('administrator');
    }

    public function getCountInspection($id){
        $Inspection = Inspection::where('client_id',$id)->get();
        $count = $Inspection->count();
        return response()->json([
            'count' => $count
        ]);
    }

    public function getProductByCode($id){
        $products = Product::where('client_code',$id)->get();
        return response()->json([
            'products' => $products
        ]);
    }

    public function geClientContactList($id){
        $count=0;
        $count = ClientContact::where('client_code','=',$id)->count();
        if($count>0){
        $ClientContact = ClientContact::where('client_code',$id)->first();
        $ClientContactList = ClientContact::where('client_code',$id)->whereNotIn('client_contact_status',[1,2])->get();
        return response()->json([
            'client_contact_list' => $ClientContactList,
            'contact_client_id' => $ClientContact->id,
            'contact_person' => $ClientContact->contact_person,
            'contact_number' => $ClientContact->contact_number,
            'email_address' => $ClientContact->email_address
    	]);
        }else{
            return response()->json([
                'message' => 'Nodata',
            ]);

        }
        //$contacts = FctoryContact::where('factory_id',$id)->get();

    
    }
    public function clientAddNewContact(Request $request){
        $c_person = $request['contact_person'];
        $cc=$request['client_code'];
 
        $client = new ClientContact();
        $client->client_code = $request['client_code'];
        $client->contact_person = $request['contact_person'];
        $client->email_address = $request['contact_person_email'];
        $client->contact_number = $request['contact_person_number'];
        $client->tel_number = $request['contact_person_tel_number'];
        $client_skype= $request['client_skype'];
        $client_wechat = $request['client_wechat'];
        $client_whatsapp = $request['client_whatsapp'];
        $client_qqmail = $request['client_qqmail'];
        if($client_skype==""){ $client_skype="N/A"; }
        if($client_wechat==""){ $client_wechat="N/A"; }
        if($client_whatsapp==""){ $client_whatsapp="N/A"; }
        if($client_qqmail==""){ $client_qqmail="N/A";}
        $client->client_skype = $client_skype;
        $client->client_wechat = $client_wechat;
        $client->client_whatsapp = $client_whatsapp;
        $client->client_qqmail = $client_qqmail;
        $client->client_contact_status = 0;
        $client->save();
 
     }

    /*public function clientUpdateContact(Request $request){
        $c_person = $request['contact_person'];
        $cc=$request['client_code'];
 
        //$client =ClientContact::where($request['contact_id']);
        $client =ClientContact::where('id', $request['contact_id']);
        $client->contact_person = $request['contact_person'];
        $client->email_address = $request['contact_person_email'];
        $client->contact_number = $request['contact_person_number'];
        $client->tel_number = $request['contact_person_tel_number'];
        $client_skype= $request['client_skype'];
        $client_wechat = $request['client_wechat'];
        $client_whatsapp = $request['client_whatsapp'];
        $client_qqmail = $request['client_qqmail'];
        if($client_skype==""){ $client_skype="N/A"; }
        if($client_wechat==""){ $client_wechat="N/A"; }
        if($client_whatsapp==""){ $client_whatsapp="N/A"; }
        if($client_qqmail==""){ $client_qqmail="N/A";}
        $client->client_skype = $client_skype;
        $client->client_wechat = $client_wechat;
        $client->client_whatsapp = $client_whatsapp;
        $client->client_qqmail = $client_qqmail;
        $client->update();
 
    }*/
    
    //Add Company Contact Detail
    public function clientAddContact(Request $request){
        $client_contact = new ClientContact();
        $client_contact->client_code = $request['client_code'];
        $client_contact->contact_person =  $request['contact_person'];
		$client_contact->contact_number =  $request['contact_person_number'];
		$client_contact->tel_number =  $request['contact_person_tel_number'];
		$client_contact->email_address =  $request['contact_person_email'];
        $client_skype= $request['client_skype'];
        $client_wechat = $request['client_wechat'];
        $client_whatsapp = $request['client_whatsapp'];
        $client_qqmail = $request['client_qqmail'];
        if($client_skype==""){ $client_skype="N/A"; }
        if($client_wechat==""){ $client_wechat="N/A"; }
        if($client_whatsapp==""){ $client_whatsapp="N/A"; }
        if($client_qqmail==""){ $client_qqmail="N/A"; }
        $client_contact->client_skype = $client_skype;
        $client_contact->client_wechat = $client_wechat;
        $client_contact->client_whatsapp = $client_whatsapp;
        $client_contact->client_qqmail = $client_qqmail;
        if ($client_contact->save()) {
            return response()->json([
                'client_contact' => $client_contact
            ],200);
        }
        
    }
    
    
    //Update Company Contact Detail
    public function clientUpdateContact(Request $request){
        $client_contact = ClientContact::where('id', $request->input('contact_id'));
        //$client = Client::where('client_id', Auth::id());
        $data = array(
			'contact_person' => $request->input('contact_person'),
			'contact_number' => $request->input('contact_person_number'),
			'tel_number' => $request->input('contact_person_tel_number'),
			'email_address' => $request->input('contact_person_email'),
			'client_skype' => $request->input('client_skype'),
			'client_wechat' => $request->input('client_wechat'),
			'client_whatsapp' => $request->input('client_whatsapp'),
			'client_qqmail' => $request->input('client_qqmail')
		);

        if ($client_contact->update($data)) {
            return response()->json([
                'client_contact' => $client_contact
            ],200);
        }
        
    }
    
    //Delete Contact Person
    public function deleteContactPerson(Request $request){
        $client = ClientContact::where('id', $request['id'])->get();
        return response()->json([
            'client' => $client
        ]);
    }
    
    //Delete Contact Person
    public function delete_ContactPerson(Request $request){
        //$client_contact = ClientContact::where('id', $request->input('contact_id'));
		$client = ClientContact::where('id', $request['delete_contact_id'])->delete();
        /*$data = array(
			'id' => $request->input('contact_id')
		);*/
        /*if ($client_contact->delete($data)) {
            return response()->json([
                'client_contact' => $client_contact
            ],200);
        }*/
		//$client_contact->forceDelete();
    }
    
    public function getClientContacts($id){
        $contacts = ClientContact::where('client_code',$id)->get();
        return response()->json([
            'contacts' => $contacts
        ]);
    }
    public function addNewClient(Request $request){
        $client = new Client();
        $client->client_code = $request['client_code'];
        $client->client_name = $request['client_name'];
        $client->Company_Name = $request['Company_Name'];
        $client->Company_Email = $request['Company_Email'];
        $comp_addr=$request['company_city_name'].' '. $request['company_state_name'] .' '. $request['company_country_name'];
        $client->Company_Address = $comp_addr;
        $client->company_country_name = $request['company_country_name'];
        $client->company_state_name = $request['company_state_name'];
        $client->company_city_name = $request['company_city_name'];
        $client->company_country_id = $request['company_country_id'];
        $client->company_state_id = $request['company_state_id'];
        $client->company_city_id = $request['company_city_id'];

        $client->company_bldg_num = $request['company_bldg_num'];
        
        $client->company_street_num = $request['street_number'];
        $client->company_house_num = $request['house_number'];
        $client->company_zip_code = $request['zip_code'];

        $client->company_inv_bldg_num = $request['company_inv_bldg_num'];
        $client->company_invoice_country_name = $request['company_invoice_country_name'];
        $client->company_invoice_state_name = $request['company_invoice_state_name'];
        $client->company_invoice_city_name = $request['company_invoice_city_name'];
        $client->company_invoice_country_id = $request['company_invoice_country_id'];
        $client->company_invoice_state_id = $request['company_invoice_state_id'];
        $client->company_invoice_city_id = $request['company_invoice_city_id'];
        $client->company_inv_street_num = $request['inv_street_number'];
        $client->company_inv_house_num = $request['inv_house_number'];
        $client->company_inv_zip_code = $request['inv_zip_code'];

        $client->Phone_number = $request['Phone_number'];
        $client->payment_term = $request['payment_terms'];
        $client->special_term = $request['special_terms'];
        if ($client->save()) {
            //for user tables
            /* $user = new User();
    	    $user->username = $request['username'];
    	    $user->email = $request['Company_Email'];
    	    $user->password = bcrypt($request['password']);
    	    $user->status = 1;

    	    if ($user->save()) {
    	    	$user_client = new UserInfo();
                $user_client->user_id = $user->id;
    	    	$user_client->name = $request['Company_Name'];
    	    	$user_client->email_address = $request['Company_Email'];
    	    	$user_client->contact_number = $request['Phone_number'];
                $user_client->designation = 'client';
                $user_client->address = $comp_addr;
                $user_client->client_code = $request['client_code'];
                $user_client->save();
    	    } */
            $c_person = $request['contact_person'];
            $cc=$request['client_code'];
            foreach ($c_person as $i => $value) {
                $client_contact[$i] = new ClientContact();
                $client_contact[$i]->client_code = $request['client_code'];
                $client_contact[$i]->contact_person = $request['contact_person'][$i];
                $client_contact[$i]->email_address = $request['contact_person_email'][$i];
                $client_contact[$i]->contact_number = $request['contact_person_number'][$i];
                $client_contact[$i]->tel_number = $request['contact_person_tel_number'][$i];
              
                $client_skype= $request['client_skype'][$i];
                $client_wechat = $request['client_wechat'][$i];
                $client_whatsapp = $request['client_whatsapp'][$i];
                $client_qqmail = $request['client_qqmail'][$i];

                if($client_skype==""){ $client_skype="N/A"; }
                if($client_wechat==""){ $client_wechat="N/A"; }
                if($client_whatsapp==""){$client_whatsapp="N/A"; }
                if($client_qqmail==""){ $client_qqmail="N/A"; }

                $client_contact[$i]->client_skype = $client_skype;
                $client_contact[$i]->client_wechat = $client_wechat;
                $client_contact[$i]->client_whatsapp = $client_whatsapp;
                $client_contact[$i]->client_qqmail = $client_qqmail;
                $client_contact[$i]->client_contact_status = 0;
                $client_contact[$i]->save();
            }
            //Session::flash('success', 'You have successfuly added new client!');
            //return redirect()->route('clients');
        }
    }
    public function clientPostNewFactory(Request $request){
        $factory = new Factory();
        $factory->client_code = $request['client_code'];
        $factory->supplier_id = $request['supplier_id'];
        $factory->factory_name = $request['factory_name'];
        $factory->factory_number = $request['factory_number'];



        $factory->factory_address = $request['factory_address'];
        $factory->factory_city = $request['factory_city'];
        $factory->factory_address_local = $request['factory_address_local'];
        $factory->factory_city_local = $request['factory_city_local'];


        $factory->factory_country = $request['factory_country'];
        $factory->factory_country_name = $request['factory_country_name'];
        /* $factory->factory_state = $request['factory_state']; */

        $factory->factory_state = null;
        $factory->factory_state_id = null;
        $factory->factory_city_id = null;

      /*   $factory->factory_state_id = $request['factory_state_id'];
        $factory->factory_city_id = $request['factory_city_id']; */
        $factory->factory_status = 0;
 
        if ($factory->save()) {
            $c_person = $request['contact_person'];
            $lastInsertId= $factory->id;
 
            foreach ($c_person as $i => $value) {
                $contact[$i] = new FctoryContact();
                $contact[$i]->factory_id = $lastInsertId;
                $contact[$i]->client_code = $request['client_code'];
                $contact[$i]->factory_contact_person = $request['contact_person'][$i];
                $contact[$i]->factory_email = $request['contact_person_email'][$i];
                $contact[$i]->factory_contact_number = $request['contact_person_number'][$i];
                $contact[$i]->factory_tel_number = $request['c_person_tel_number'][$i];
 
                $contact[$i]->factory_contact_skype = $request['factory_contact_skype'][$i];
                $contact[$i]->factory_contact_wechat = $request['factory_contact_wechat'][$i];
                $contact[$i]->factory_contact_whatsapp = $request['factory_contact_whatsapp'][$i];
                $contact[$i]->factory_contact_qq = $request['factory_contact_qqmail'][$i];
                $contact[$i]->factory_contact_status = 0;
                $contact[$i]->save();
            }
            Session::flash('success','You have successfully added a new Factory!');          
            return response()->json([
                'factory_id' => $factory->id
            ]); 
        }
    }

    public function clientPostNewSupplier(Request $request){
        $supplier = new Supplier();
        $supplier->client_code = $request['client_code'];
        $supplier->supplier_name = $request['supplier_name'];
        $supplier->supplier_number = $request['supplier_number'];
        
        $supplier->supplier_address_local = $request['supplier_local_address'];
        $supplier->supplier_country = $request['supplier_country'];
        $supplier->supplier_country_name = $request['supplier_country_name'];
        $supplier->supplier_state = $request['supplier_state'];

        $supplier->supplier_city = $request['supplier_city'];
        $supplier->supplier_address = $request['supplier_address'];
        $supplier->supplier_local_address = $request['supplier_local_address'];
        $supplier->supplier_local_city = $request['supplier_local_city'];


      /*   $supplier->supplier_state_id = $request['supplier_state_id'];
        $supplier->supplier_city_id = $request['supplier_city_id']; */
        $supplier->supplier_status = 0;
 
        if ($supplier->save()) {
            $c_person = $request['contact_person'];
            $lastInsertId= $supplier->id;
 
            foreach ($c_person as $i => $value) {
                $contact[$i] = new SupplierContact();
                $contact[$i]->supplier_id = $lastInsertId;
                $contact[$i]->client_code = $request['client_code'];
                $contact[$i]->supplier_contact_person = $request['contact_person'][$i];
                $contact[$i]->supplier_email = $request['contact_person_email'][$i];
                $contact[$i]->supplier_contact_number = $request['contact_person_number'][$i];
                $contact[$i]->supplier_tel_number = $request['c_person_tel_number'][$i];
 
                $contact[$i]->supplier_contact_skype = $request['supplier_contact_skype'][$i];
                $contact[$i]->supplier_contact_wechat = $request['supplier_contact_wechat'][$i];
                $contact[$i]->supplier_contact_whatsapp = $request['supplier_contact_whatsapp'][$i];
                $contact[$i]->supplier_contact_qq = $request['supplier_contact_qqmail'][$i];
                $contact[$i]->supplier_contact_status = 0;
                $contact[$i]->save();
            }
            
            if($request['same_as_factory']=='true'){
                $factory = new Factory();
                $factory->client_code = $request['client_code'];
                $factory->supplier_id = $supplier->id;
                $factory->factory_name = $request['supplier_name'];
                $factory->factory_number = $request['supplier_number'];
                $factory->factory_address = $request['supplier_address'];
                $factory->factory_city = $request['supplier_city'];
                $factory->factory_address_local = $request['supplier_local_address'];
                $factory->factory_city_local = $request['supplier_local_city'];
                $factory->factory_country = $request['supplier_country'];
                $factory->factory_country_name = $request['supplier_country_name'];
                
                
                
              /*   $factory->factory_state = $request['supplier_state'];
               
                $factory->factory_state_id = $request['supplier_state_id'];
                $factory->factory_city_id = $request['supplier_city_id']; */
                $factory->factory_status = 0;
         
                if ($factory->save()) {
                    $c_person = $request['contact_person'];
         
                    foreach ($c_person as $i => $value) {
                        $contact[$i] = new FctoryContact();
                        $contact[$i]->factory_id = $factory->id;
                        $contact[$i]->client_code = $request['client_code'];
                        $contact[$i]->factory_contact_person = $request['contact_person'][$i];
                        $contact[$i]->factory_email = $request['contact_person_email'][$i];
                        $contact[$i]->factory_contact_number = $request['contact_person_number'][$i];
                        $contact[$i]->factory_tel_number = $request['c_person_tel_number'][$i];
         
                        $contact[$i]->factory_contact_skype = $request['supplier_contact_skype'][$i];
                        $contact[$i]->factory_contact_wechat = $request['supplier_contact_wechat'][$i];
                        $contact[$i]->factory_contact_whatsapp = $request['supplier_contact_whatsapp'][$i];
                        $contact[$i]->factory_contact_qq = $request['supplier_contact_qqmail'][$i];
                        $contact[$i]->factory_contact_status = 0;
                        $contact[$i]->save();
                    }
                   /*  Session::flash('success','You have successfully added a new Factory!');          
                    return response()->json([
                        'factory_id' => $factory->id
                    ]);  */
                }
            }

            Session::flash('success','You have successfully added a new Supplier!');          
            return response()->json([
                'supplier' => $supplier->id
            ]); 
        }
    }

    public function getOneSupplier($id){
        $supplier = Supplier::find($id);
        $contacts = SupplierContact::where('supplier_id',$id)->where('supplier_contact_status',0)->get();   
        return response()->json([
            'supplier' => $supplier,
            'contacts' => $contacts,
        ]);
    }

    public function getOneSupplierContact($id){
        $contacts = SupplierContact::where('id',$id)->first();   
        return response()->json([
            'contacts' => $contacts,
        ]);
    }

    public function updateFactory(Request $request){
        $factory = Factory::find($request['update_factory_id']);
        $factory->factory_name = $request['update_factory_name'];
        $factory->factory_number = $request['update_factory_number'];
        $factory->factory_address = $request['update_factory_address'];
        $factory->factory_address_local = $request['update_factory_address_local'];
        $factory->factory_country = $request['update_factory_country'];
        $factory->factory_country_name = $request['update_factory_country_name'];
        $factory->factory_city = $request['update_factory_city'];
        $factory->factory_city_id = $request['update_factory_city_id'];
        $factory->factory_state = $request['update_factory_state'];
        $factory->factory_state_id = $request['update_factory_state_id'];

        $factory->factory_city_local = $request['update_factory_city_local'];
        $factory->factory_address = $request['update_factory_address'];

 

        $IdcontactFactory = $request['IdcontactFactory'];
        foreach ($IdcontactFactory as $i => $value) {
            $contact[$i] = FctoryContact::find($request['IdcontactFactory'][$i]);
            $contact[$i]->factory_contact_person = $request['update_contact_person'][$i];
            $contact[$i]->factory_email = $request['update_contact_person_email'][$i];
            $contact[$i]->factory_contact_number = $request['update_contact_person_number'][$i];
            $contact[$i]->factory_tel_number = $request['update_contact_person_tel_number'][$i];
            $contact[$i]->factory_contact_skype = $request['update_contact_skype'][$i];
            $contact[$i]->factory_contact_wechat = $request['update_contact_wechat'][$i];
            $contact[$i]->factory_contact_whatsapp = $request['update_contact_whatsapp'][$i];
            $contact[$i]->factory_contact_qq= $request['update_contact_qqmail'][$i];
            $contact[$i]->save();
        }
        if ($factory->save()) {  
            if($request['contact_added']==0){   
                //do nothing         
            }else{
                $c_person = $request['new_contact_person'];
                foreach ($c_person as $i => $value) {
                    $new_contact[$i] = new FctoryContact();
                    $new_contact[$i]->factory_id = $request['update_factory_id'];
                    $new_contact[$i]->client_code = $request['client_code'];
                    $new_contact[$i]->factory_contact_person = $request['new_contact_person'][$i];
                    $new_contact[$i]->factory_email = $request['new_contact_person_email'][$i];
                    $new_contact[$i]->factory_contact_number = $request['new_contact_person_number'][$i];
                    $new_contact[$i]->factory_tel_number = $request['new_contact_person_tel_number'][$i];
                    $new_contact[$i]->factory_contact_skype = $request['new_contact_skype'][$i];
                    $new_contact[$i]->factory_contact_wechat = $request['new_contact_wechat'][$i];
                    $new_contact[$i]->factory_contact_whatsapp = $request['new_contact_whatsapp'][$i];
                    $new_contact[$i]->factory_contact_qq = $request['new_contact_qqmail'][$i];
                    $new_contact[$i]->factory_contact_status = 0;
                    $new_contact[$i]->save();
                }
            }         
            Session::flash('success','You have successfully updated the Factory information!');
        }
    }

    public function updateSupplier(Request $request){
        $supplier = Supplier::find($request['update_factory_id']);
        $supplier->supplier_name = $request['update_factory_name'];
        $supplier->supplier_number = $request['update_factory_number'];
        $supplier->supplier_address = $request['update_factory_address'];
        $supplier->supplier_local_address = $request['update_factory_address_local'];
        $supplier->supplier_country = $request['update_factory_country'];
        $supplier->supplier_country_name = $request['update_factory_country_name'];
        $supplier->supplier_city = $request['update_factory_city'];
        $supplier->supplier_city_id = $request['update_factory_city_id'];
        $supplier->supplier_state = $request['update_factory_state'];

        $supplier->supplier_state_id = $request['update_factory_state_id'];
        $supplier->supplier_local_city = $request['update_factory_city_local'];

        $IdcontactFactory = $request['IdcontactFactory'];
        foreach ($IdcontactFactory as $i => $value) {
            $contact[$i] = SupplierContact::find($request['IdcontactFactory'][$i]);
            $contact[$i]->supplier_contact_person = $request['update_contact_person'][$i];
            $contact[$i]->supplier_email = $request['update_contact_person_email'][$i];
            $contact[$i]->supplier_contact_number = $request['update_contact_person_number'][$i];
            $contact[$i]->supplier_tel_number = $request['update_contact_person_tel_number'][$i];
            $contact[$i]->supplier_contact_skype = $request['update_contact_skype'][$i];
            $contact[$i]->supplier_contact_wechat = $request['update_contact_wechat'][$i];
            $contact[$i]->supplier_contact_whatsapp = $request['update_contact_whatsapp'][$i];
            $contact[$i]->supplier_contact_qq= $request['update_contact_qqmail'][$i];
            $contact[$i]->save();
        }
        if ($supplier->save()) {  
            if($request['contact_added']==0){   
                //do nothing         
            }else{
                $c_person = $request['new_contact_person'];
                foreach ($c_person as $i => $value) {
                    $new_contact[$i] = new SupplierContact();
                    $new_contact[$i]->supplier_id = $request['update_factory_id'];
                    $new_contact[$i]->client_code = $request['client_code'];
                    $new_contact[$i]->supplier_contact_person = $request['new_contact_person'][$i];
                    $new_contact[$i]->supplier_email = $request['new_contact_person_email'][$i];
                    $new_contact[$i]->supplier_contact_number = $request['new_contact_person_number'][$i];
                    $new_contact[$i]->supplier_tel_number = $request['new_contact_person_tel_number'][$i];
                    $new_contact[$i]->supplier_contact_skype = $request['new_contact_skype'][$i];
                    $new_contact[$i]->supplier_contact_wechat = $request['new_contact_wechat'][$i];
                    $new_contact[$i]->supplier_contact_whatsapp = $request['new_contact_whatsapp'][$i];
                    $new_contact[$i]->supplier_contact_qq = $request['new_contact_qqmail'][$i];
                    $new_contact[$i]->supplier_contact_status = 0;
                    $new_contact[$i]->save();
                }
            }         
            Session::flash('success','You have successfully updated the Factory information!');
        }
    }

    public function deleteSupplier(Request $request){
        $supplier = Supplier::find($request['id']);
        $supplier->supplier_status = 2;
        if ($supplier->save()) {          
            Session::flash('success','You have successfully delete the supplier!');
        }
    }

    public function deleteFactory(Request $request){
        $factory = Factory::find($request['id']);
        $factory->factory_status = 2;
        if ($factory->save()) {          
            Session::flash('success','You have successfully updated the Factory information!');
        }
    }
    public function deleteFactoryContact(Request $request){
        $factory_con = FctoryContact::find($request['id']);
        $factory_con->factory_contact_status = 2;
        if ($factory_con->save()) {          
            Session::flash('success','You have successfully updated the Factory information!');
        }
    }

    public function deleteproduct(Request $request){
        $product = Product::find($request['id']);
        $product->status = 2;
        if ($product->save()) {          
            Session::flash('success','You have successfully updated the Product information!');
        }
    }
    public function getFactoryListClient(){
        $role = User::where('id',Auth::id())->first();
        $countries = Country::all();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $factories = Factory::where('client_code',$user_info->client_code)->get();
        $client_code=$user_info->client_code;
        $req='get_factory';
        return view('pages.client.factory.index',compact('role','factories','user_info','countries','client_code','req','user'));
    }
    public function getSuppliersListClient(){
        $role = User::where('id',Auth::id())->first();
        $countries = Country::all();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $suppliers = Supplier::where('client_code',$user_info->client_code)->where('supplier_status',0)->get();
        $client_code=$user_info->client_code;
        return view('pages.client.supplier.index',compact('role','suppliers','user_info','countries','client_code','user'));
    }

    public function getFactoryBySupplier($id){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $factories = Factory::where('supplier_id',$id)->where('factory_status',0)->get();
        $suppliers = Supplier::where('id',$id)->first();
        $client_code=$user_info->client_code;
        $req='get_factory_by_supplier';
        $supplier_id=$id;
        return view('pages.client.factory.index',compact('role','factories','user_info','client_code','req','supplier_id','user','suppliers'));
    }

    public function getFactoryList($id){
        $factories = Factory::where('client_code',$id)->orderBy('factory_name', 'asc')->get();
        return response()->json([
            'factories' => $factories
        ]);
    }

    public function getFactorySupplier($id){
        $factories = Factory::where('supplier_id',$id)->get();
        $supplier = Supplier::find($id);
        $contacts = SupplierContact::where('supplier_id',$id)->where('supplier_contact_status',0)->get();   
        return response()->json([
            'supplier' => $supplier,
            'contacts' => $contacts,
            'factories' => $factories
        ]);
    }

    public function getClientCodeList(){
       
        $client_code = Client::select('client_code')->get();
        return response()->json([
            'client_code_list' => $client_code
        ]);
    }

    public function getCreateAccountForm(){
        //return view('pages.client.createAccount.index');
        $countries = Country::pluck('nicename','phonecode');
        return view('pages.client.createAccount.index',compact('countries'));
    }
    
    //New Registration
    public function getCreateAccountFormNew(){
        //return view('pages.client.createAccount.index');
        $countries = Country::pluck('nicename','phonecode');
        return view('pages.client.createAccount.new_register',compact('countries'));
    }
    
    public function activateAccount($code){
        //return view('pages.client.createAccount.index');
        //$countries = Country::pluck('nicename','phonecode');
        $user = User::where('confirmation_code',$code)->first();
        //$count=count($user);
        if($user){
            $update_user = User::find($user->id);
            $update_user->status = 1;
            if($update_user->save()){
                Session::flash('success','You successfully activate your account! Thank you.');
            }else{
                Session::flash('error','Something went wrong please try again later.');
            }
        }else{
            Session::flash('error','Error: Confirmation does not exist!');
        }
        
        return view('pages.client.createAccount.activateaccount');
       
    }

    public function registerClient(Request $request){
       /*  $client = new Client();
        $client->client_code = $request['client_code'];
        $client->client_name = $request['company_name'];
        $client->Company_Name = $request['company_name'];
        $client->Company_Email = $request['company_email'];
        $comp_addr=$request['company_city'].' '. $request['company_state'] .' '. $request['company_country'];
        $client->Company_Address = $comp_addr;
        $client->company_country_name = $request['company_country_name'];
        $client->company_country_id = $request['company_country'];
        $client->company_state_name = $request['company_state'];
        $client->company_state_id = $request['company_state'];
        $client->company_city_name = $request['company_city'];
        $client->company_city_id = $request['company_city'];
        
        

        $client->company_bldg_num = null;
        
        $client->company_street_num = null;
        $client->company_house_num = null;
        $client->company_zip_code = null;

        $client->company_inv_bldg_num = null;
        $client->company_invoice_country_name =  $request['company_country_name'];
        $client->company_invoice_state_name = $request['company_state'];
        $client->company_invoice_city_name = $request['company_city'];
        $client->company_invoice_country_id = $request['company_country_name'];
        $client->company_invoice_state_id = $request['company_state'];
        $client->company_invoice_city_id = $request['company_city'];
        $client->company_inv_street_num = null;
        $client->company_inv_house_num = null;
        $client->company_inv_zip_code = null;

        $client->Phone_number = $request['company_phone'];
        $client->payment_term = null;
        $client->special_term = null;
        if ($client->save()) {
            $confirmation_code = str_random(35);
            //for user tables
            $user = new User();
            $user->username = $request['username'];
            $user->client_code = $request['client_code'];
    	    $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->plain = $request['password'];
            $user->confirmation_code =  $confirmation_code;
    	    $user->status = 0;

    	    if ($user->save()) {
    	    	$user_client = new UserInfo();
                $user_client->user_id = $user->id;
    	    	$user_client->name = $request['company_name'];
    	    	$user_client->email_address = $request['company_email'];
    	    	$user_client->contact_number = $request['company_phone'];
                $user_client->designation = 'client';
                $user_client->address = $comp_addr;
                $user_client->client_code = $request['client_code'];
                
                if ($user_client->save()) {
                    $client_aql_detail = new CLientAqlDetail();
                    $client_aql_detail->client_id = $user->id;
                    $client_aql_detail->normal_level = "I";
                    $client_aql_detail->special_level = "S1";
                    $client_aql_detail->aql_minor = 0.065;
                    $client_aql_detail->aql_major = 0.065;
                    $client_aql_detail->save();
                }
    	    }

            $client_contact = new ClientContact();
            $client_contact->client_code = $request['client_code'];
            $client_contact->contact_person = $request['contact_name'];
            $client_contact->email_address = $request['contact_email'];
            $client_contact->contact_number = $request['phone_number'];
            $client_contact->tel_number = $request['phone_number'];
             
            
            $client_contact->client_skype = "N/A";
            $client_contact->client_wechat = "N/A";
            $client_contact->client_whatsapp = "N/A";
            $client_contact->client_qqmail = "N/A";
            $client_contact->client_contact_status = 0;
            $client_contact->save();
            $data = ['client_rep_email' =>  $request['email'],
                    'code' =>  $confirmation_code,
                    'client_name' =>  $request['company_name']];
                Mail::send('email.register_client',$data, function($message) use ($data){
                    $message->to($data['client_rep_email']);
                    $message->cc('rommel@t-i-c.asia');
                    $message->cc('manuel@t-i-c.asia');
                    $message->cc('jesser@t-i-c.asia');
                    $message->cc('gregor@t-i-c.asia','Gregor');             
                    $message->subject("Activate your account - The Inspection Company Online Booking");                                              
                });               

            if (count(Mail::failures()) > 0) {
                return response()->json([
                    'message' => 'error',
                ],500);
            }else{                     
                Session::flash('success','You have registered your account! Please check your email and activate your account!');
                return redirect()->route('login');
            }         
        } */
        $com_name="The Inspection Company";
        $msg_subject="Account Registration - The Inspection Company Online Booking";
        $user_type=null;
        if($request['site_url']=='tic-sera'){
            $user_type='tic_sera';
            $com_name='TIC-SERA';
            $msg_subject="Account Registration - TIC-SERA Online Booking";
        }

        $email=$request['username'];
        $count=0;
        $count = UserInfo::where('email_address','=',$email)->where('designation','client')->count();
        if($count<=0){
        
            $confirmation_code = str_random(35);
            //for user tables
            $user = new User();
            $user->username = $request['username'];
            $user->client_code = "000";
    	    $user->email = $request['username'];
            $user->password = bcrypt($request['password']);
            $user->plain = $request['password'];
            $user->confirmation_code =  $confirmation_code;
            $user->status = 0;
            $user->user_type = $user_type;
            
    	    if ($user->save()) {
				$client = new Client();
				$client->client_code = "000";
				$client->user_id = $user->id;
				$client->client_name = $request['name'];
				$client->Company_Name = $request['Company_name'];
				$client->Company_Email = $request['username'];
				$company_city=$request['company_city'];
				$company_state=$request['company_state'];
				if( $company_city== "" &&$company_state=="" ){
					$comp_addr="N/A";
				}else{
					$comp_addr=$request['company_city'].' '. $request['company_state'] .' '. $request['company_country'];
				}


        $company_country_name=$request['countryname'];
        if( $company_country_name== "" ){
            $company_country_name="N/A";
        }else{
            $company_country_name=$request['countryname'];
        }
       
        $client->Company_Address = $comp_addr;
        $client->company_country_name = $company_country_name;
        $client->company_country_id = $request['country'];
        $client->company_state_name = "N/A";
        $client->company_state_id = 0;
        $client->company_city_name =  "N/A";
        $client->company_city_id =  0;
        
        

        $client->company_bldg_num = null;
        
        $client->company_street_num = null;
        $client->company_house_num = null;
        $client->company_zip_code = null;

        $client->company_inv_bldg_num = null;
        $client->company_invoice_country_name = null;
        $client->company_invoice_state_name = null;
        $client->company_invoice_city_name = null;
        $client->company_invoice_country_id = null;
        $client->company_invoice_state_id = null;
        $client->company_invoice_city_id = null;
        $client->company_inv_street_num = null;
        $client->company_inv_house_num = null;
        $client->company_inv_zip_code = null;

        $client->Phone_number = $request['company_phone'];
        $client->payment_term = null;
        $client->special_term = null;
        $client->added_by = 'client';
        $client->client_type = $user_type;
        if ($client->save()) {
				
    	    	$user_client = new UserInfo();
                $user_client->user_id = $user->id;
    	    	$user_client->name = $request['name'];
    	    	$user_client->user_gender = $request['TermsOfAddress'];
    	    	$user_client->email_address = $request['username'];
    	    	$user_client->contact_number = $request['company_phone'];
                $user_client->designation = 'client';
                $user_client->address = $comp_addr;
                $user_client->client_code = "000";
                $user_client->user_country_name =  $company_country_name;
                $user_client->user_country_id =   $request['country'];
                if ($user_client->save()) {
                    $client_aql_detail = new CLientAqlDetail();
                    $client_aql_detail->client_id = $user->id;
                    $client_aql_detail->normal_level = "I";
                    $client_aql_detail->special_level = "S1";
                    $client_aql_detail->aql_minor = 0.065;
                    $client_aql_detail->aql_major = 0.065;
                    $client_aql_detail->save();
                }
            }
            
            

            $client_contact = new ClientContact();
            $client_contact->client_code = "000";
            $client_contact->contact_person = "N/A";
            $client_contact->email_address ="N/A";
            $client_contact->contact_number = "N/A";
            $client_contact->tel_number = "N/A";
            
            
            $client_contact->client_skype = "N/A";
            $client_contact->client_wechat = "N/A";
            $client_contact->client_whatsapp = "N/A";
            $client_contact->client_qqmail = "N/A";
            $client_contact->client_contact_status = 0;
            $client_contact->save();
			$gender = $user_client->user_gender;
			if($gender == 0){
				$gender_label = "Ms.";
			} else if($gender == 1) {
				$gender_label = "Mr.";
			} else {
				$gender_label = "Mrs.";
			}
            $data = ['client_rep_email' =>  $request['username'],
                    'code' =>  $confirmation_code,
                    'client_name' =>  $request['name'],
                    'email' =>  $email,
                    'full_name' =>  $request['name'],
                    'user_gender' => $gender_label,
                    'msg_subject'=>$msg_subject,
                    'com_name'=>$com_name,
                    'user_type'=>$user_type
					];
                Mail::send('email.verify',$data, function($message) use ($data){
                    $message->to($data['client_rep_email']);
                    $message->bcc('it-support@t-i-c.asia','IT Support');
                    $message->bcc('gregor@t-i-c.asia','Gregor'); 
                    //$message->bcc('gregor.voege@web.de');

                    if($data['user_type']=='tic_sera'){
                        $message->bcc('aarreola@sera.com.mx','Aarreola');    
                        $message->bcc('asiaop@sera.com.mx','Asiaop');    
                        $message->bcc('coordination@sera.com.mx','Coordination');  
                    }else{
                        $message->bcc('1249484103@qq.com');                             
                        $message->bcc('2891400188@qq.com');
                    }
                    //$message->bcc('1249484103@qq.com');
                    //$message->bcc('2891400188@qq.com');
                    //$message->cc('booking@t-i-c.asia','Booking');             
                    $message->subject($data['msg_subject']);                                              
                });               

            if (count(Mail::failures()) > 0) {
                return response()->json([
                    'message' => 'error',
                ],500);
            }else{           
                return response()->json([
                    'message' => 'ok',
                ]);
				//return view('pages.client.trackInspection.index'
				//return redirect()->route('administrator');
            }         
        } else {
                return response()->json([
                    'message' => 'error',
                ],500);
            }
		}else{
			return response()->json([
            'message' => 'dupticateEmail',
			]);

		}
    }
	
	//Update Username or Fullname or Both on Account Settings
	public function updateUsername(Request $request){
		$email=$request['change_username'];
        $count=0;
        $count = User::where('email','=',$email)
			->where('id', '!=', Auth::id())
			->count();
        if($count<=0){
			$user = User::where('id',Auth::id())->first();
			$user_info = UserInfo::where('user_id',Auth::id())->first();
			$user_info->name = $request['change_fullname'];
			//$user_password = $request['change_new_pass'];
			//$user_confirm_password = $request['change_conf_pass'];
			//if($user_password == $user_confirm_password){
				/*if(!empty($user_password) || $user_password!=""){
					$user->password = bcrypt($request['change_new_pass']);
        			$user->plain = $request['change_new_pass'];
				}*/
				$user->username = $request['change_username'];
				$user->email = $request['change_username'];
				if ($user->update()) {
					if($user_info->update()){
						return response()->json([
							'message' => 'ok',
						]);
					}
        		}
			/*} else {
				Session::flash('faled','Password Not Match');
			}*/
		} else {
			return response()->json([
            	'message' => 'dupticateEmail',
        	]);
		}
	}
	
	//Update User Password on Account Settings
	public function updateUserPassword(Request $request){
		$user = User::where('id',Auth::id())->first();
		$user_password = $request['change_new_pass'];
		$user_confirm_password = $request['change_conf_pass'];
		if($user_password == $user_confirm_password){
			if(!empty($user_password) || $user_password!=""){
				$user->password = bcrypt($request['change_new_pass']);
       			$user->plain = $request['change_new_pass'];
				if ($user->update()) {
					return response()->json([
						'message' => 'ok',
					]);
       			}
			}
		} else {
			Session::flash('faled','Password Not Match');
		}
	}
	
    public function saveProduct(Request $request){
        $this->validate($request,array(
            'client_code' =>'required',
            'product_name' =>'required',
            'product_category'=>'required',
            'product_unit'=>'required'
        ));
        $product = new Product();
        $product->client_code = $request['client_code'];
        $product->product_name = $request['product_name'];
        $product->product_category = $request['product_category'];
        $product->product_sub_category = $request['product_sub_category'];
        $product->product_unit = $request['product_unit'];
        $product->product_number = $request['product_number'];

        $po_no = $request['po_no'];
        $model_no = $request['model_no'];
        $brand = $request['brand'];
        $additional_product_info = $request['additional_product_info'];

        if($po_no==""){$po_no="N/A";}
        if($model_no==""){$model_no="N/A";}
        if($brand==""){$brand="N/A";}
        if($additional_product_info==""){$additional_product_info="N/A";}

        $product->po_no = $po_no;
        $product->model_no = $model_no;
        $product->brand = $brand;
        $product->additional_product_info = $additional_product_info;
        $product->save();
        /* if ($product->save()) {
            return response()->json([
                'product' => $product
            ],200);
        } */
        //joe
        $clientcodedata=$request['client_code'];
       
        $userId = Product::where('client_code', $clientcodedata)->max('id');
        

            DB::table('product_photos')
            ->where('user_id', $clientcodedata)
            ->where('product_id', 0)
            ->update(['product_id' => $userId]);
    }

    public function copyProduct(Request $request){
        $productId;
        $product = new Product();
        $product->client_code = $request['client_code'];
        $product->product_name = $request['product_name'];
        $product->product_category = $request['product_category'];
        $product->product_sub_category = $request['product_sub_category'];
        $product->product_unit = $request['product_unit'];
        $product->product_number = $request['product_number'];

        $po_no = $request['po_no'];
        $model_no = $request['model_no'];
        $brand = $request['brand'];
        $additional_product_info = $request['additional_product_info'];

        if($po_no==""){$po_no="N/A";}
        if($model_no==""){$model_no="N/A";}
        if($brand==""){$brand="N/A";}
        if($additional_product_info==""){$additional_product_info="N/A";}

        $product->po_no = $po_no;
        $product->model_no = $model_no;
        $product->brand = $brand;
        $product->additional_product_info = $additional_product_info;
        $product->save();

        $clientcodedata=$request['client_code'];
       
        $productId = Product::where('client_code', $clientcodedata)->max('id');
        

        $id= $request['product_id'];

        $product=DB::table('product_photos')
        ->where('product_id', $id)->get();
        $pieces; 
        foreach ($product as  $value) {     
        $tempDir ='js/dropzone/'.$value->file_path;
        $tmpFileName=$value->file_name;
       
        $photo_category='PS';
        $user_id='GVG';    
        $pieces = explode(".", $tmpFileName);
        $tmp1=$pieces[0];

        
        $file_copy=$tempDir.''.$tmpFileName;
        $new_dir=$tempDir;
        if (!File::exists($new_dir)) {
            File::makeDirectory($new_dir);
        }
             
        File::copy($file_copy,$new_dir.''.$pieces[0].'-TIC-copy('.$productId.').'.''.$pieces[1]);

        $newFilenameTmp=$pieces[0].'-TIC-copy('.$productId.').'.''.$pieces[1];
        $productSave = new productphotos();
        $productSave->user_id=$value->user_id;
        $productSave->product_id=$productId;
        $productSave->file_name=$newFilenameTmp;
        $productSave->file_path=$value->file_path;
        $productSave->file_type=$value->file_type;
        $productSave->photo_category=$value->photo_category;
        $productSave->file_size=$value->file_size;
        $productSave->save();

        }

        DB::table('product_photos')
        ->where('user_id', $clientcodedata)
        ->where('product_id', 0)
        ->update(['product_id' => $productId]);
       // return count($a);
        
    }

    public function saveProductNew(Request $request){
        $this->validate($request,array(
            'client_code' =>'required',
            'product_name' =>'required',
            'product_category'=>'required',
            'product_unit'=>'required'
        ));
        $product = new Product();
        $product->client_code = $request['client_code'];
        $product->product_name = $request['product_name'];
        $product->product_category = $request['product_category'];
        $product->product_sub_category = $request['product_sub_category'];
        $product->product_unit = $request['product_unit'];
        $product->product_number = $request['product_number'];

        $po_no = $request['po_no'];
        $model_no = $request['model_no'];
        $brand = $request['brand'];
        $additional_product_info = $request['additional_product_info'];

        if($po_no==""){$po_no="N/A";}
        if($model_no==""){$model_no="N/A";}
        if($brand==""){$brand="N/A";}
        if($additional_product_info==""){$additional_product_info="N/A";}

        $product->po_no = $po_no;
        $product->model_no = $model_no;
        $product->brand = $brand;
        $product->additional_product_info = $additional_product_info;
        $product->save();
       
        //joe
        $clientcodedata=$request['client_code'];
       
        $userId = Product::where('client_code', $clientcodedata)->max('id');
        

            DB::table('product_photos')
            ->where('user_id', $clientcodedata)
            ->where('product_id', 0)
            ->update(['product_id' => $userId]);

 if ($product->save()) {
            return response()->json([
                'product_id' => $product->id
            ],200);
        }
    }

    public function updateProduct(Request $request){
        $product = Product::find($request['product_id']);
        $product->product_name = $request['product_name'];
        $product->product_category = $request['product_category'];
        $product->product_sub_category = $request['product_sub_category'];
        $product->product_unit = $request['product_unit'];
        $product->product_number = $request['product_number'];
        
        $po_no = $request['po_no'];
        $model_no = $request['model_no'];
        $brand = $request['brand'];
        $additional_product_info = $request['additional_product_info'];

        if($po_no==""){$po_no="N/A";}
        if($model_no==""){$model_no="N/A";}
        if($brand==""){$brand="N/A";}
        if($additional_product_info==""){$additional_product_info="N/A";}

        $product->po_no = $po_no;
        $product->model_no = $model_no;
        $product->brand = $brand;
        $product->additional_product_info = $additional_product_info;
        $product->save();
       /*  if ($product->save()) {
            return response()->json([
                'product' => $product
            ],200);
        } */
        $clientcodedata=$request['client_code'];
        $userId=$request['product_id'];
        DB::table('product_photos')
        ->where('user_id', $clientcodedata)
        ->where('product_id', 0)
        ->update(['product_id' => $userId]);
    }

    public function updateProduct_only(Request $request){
       
        $clientcodedata=$request['client_code'];
        $userId=$request['product_id'];
        DB::table('product_photos')
        ->where('user_id', $clientcodedata)
        ->where('product_id', 0)
        ->update(['product_id' => $userId]);
    }

    public function getClientProduct($id){
        $product = Product::where('id',$id)->first();
        return response()->json([
            'product' => $product
        ]);
    }

    public function getAccountDashboard(){
        $role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
            ->where('role_user.user_id',Auth::id())->first();
            
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $client_code=$user_info->client_code;
        $user = User::where('id',Auth::id())->first();
        $client = Client::where('client_code',$client_code)->first();
        $client_contact = ClientContact::where('client_code',$client_code)->get();
        //$client_aql = ClientAqlDetail::where('client_id',Auth::id())->first();
        $client_aql_detail = ClientAqlDetail::where('client_id',Auth::id())->first();
        $client_aql_minors_orig = ClientAqlMinor::all();
        $client_aql_majors_orig = ClientAqlMajor::all();
        $client_aql_minors = $client_aql_minors_orig->pluck('aql','aql');
        $client_aql_majors = $client_aql_majors_orig->pluck('aql','aql_select');
        $normal=['I'=>'I','II'=>'II','III'=>'III'];
        $special=['S1'=>'S1','S2'=>'S2','S3'=>'S3','S4'=>'S4'];
        $aql_major = ['0.065'=>'0.065','0.1'=>'0.1','0.15'=>'0.15','0.25'=>'0.25','0.40'=>'0.40','1'=>'1','1.5'=>'1.5','2.5'=>'2.5','4'=>'4','6.5'=>'6.5','10'=>'10'];
        /* if($user->levelState==0){
            return view('pages.client.accountsettings.index2',compact('role','user_info','client_code','client','client_contact','user','client_aql_detail','client_aql_minors','client_aql_majors','normal','special','$aql_major')); 
        }else{
        return view('pages.client.accountsettings.index',compact('role','user_info','client_code','client','client_contact','user','client_aql_detail','client_aql_minors','client_aql_majors','normal','special','$aql_major'));    	
        } */
        return view('pages.client.accountsettings.index',compact('role','user_info','client_code','client','client_contact','user','client_aql_detail','client_aql_minors','client_aql_majors','normal','special','$aql_major')); 
    }

    public function getAccountDashboardNew(){
        $role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
            ->where('role_user.user_id',Auth::id())->first();
            
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $client_code=$user_info->client_code;
        $user = User::where('id',Auth::id())->first();
        $client = Client::where('client_code',$client_code)->first();
        $client_contact = ClientContact::where('client_code',$client_code)->get();
        //$client_aql = ClientAqlDetail::where('client_id',Auth::id())->first();
        $client_aql_detail = ClientAqlDetail::where('client_id',Auth::id())->first();
        $client_aql_minors_orig = ClientAqlMinor::all();
        $client_aql_majors_orig = ClientAqlMajor::all();
        $client_aql_minors = $client_aql_minors_orig->pluck('aql','aql');
        $client_aql_majors = $client_aql_majors_orig->pluck('aql','aql_select');
        $normal=['I'=>'I','II'=>'II','III'=>'III'];
        $special=['S1'=>'S1','S2'=>'S2','S3'=>'S3','S4'=>'S4'];
        $aql_major = ['0.065'=>'0.065','0.1'=>'0.1','0.15'=>'0.15','0.25'=>'0.25','0.40'=>'0.40','1'=>'1','1.5'=>'1.5','2.5'=>'2.5','4'=>'4','6.5'=>'6.5','10'=>'10'];
        return view('pages.client.accountsettings.index2',compact('role','user_info','client_code','client','client_contact','user','client_aql_detail','client_aql_minors','client_aql_majors','normal','special','$aql_major')); 
    }
    public function getTrackInspectionDashboard($id){
        $role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
            ->where('role_user.user_id',Auth::id())->first();
            
        $user_info = UserInfo::where('user_id',Auth::id())->first(); 
        $client_code=$user_info->client_code;
        $user = User::where('id',Auth::id())->first();
        $client = Client::where('client_code',$client_code)->first();
        $client_contact = ClientContact::where('client_code',$client_code)->get();

		return view('pages.client.trackInspection.index',compact('role','user_info','client_code','client','client_contact','user','id'));    	
    }

    public function updateClientInfo(Request $request){
        $is_request=$request['is_request'];
        
        //update company
        if($is_request=='company_request'){
            $client = Client::find($request['client_id']);
            $client->Company_Name = $request['company_name'];
            $client->Company_Email = $request['company_email'];
            $client->Phone_number = $request['company_phone'];
            $client->company_country_name = $request['company_country_name'];
            $client->company_country_id = $request['company_country_id'];
            $client->company_state_name = $request['company_state_name'];
            $client->company_state_id = $request['company_state_id'];
            $client->company_city_name = $request['company_city_name'];
            $client->company_city_id = $request['company_city_id'];
            $client->company_zip_code = $request['company_zip'];
            $client->company_house_num = $request['company_house_num'];
            $client->company_bldg_num = $request['company_bldg_num'];
            if ($client->save()) {
                return response()->json([
                    'message' => 'OK',
                ],200);
            }
        }
        //update invoice
        else if($is_request=='invoice_request'){
            $client = Client::find($request['client_id']);
            $client->company_invoice_country_name = $request['inv_company_country_name'];
            $client->company_invoice_country_id = $request['inv_company_country_id'];
            $client->company_invoice_state_name = $request['inv_company_state_name'];
            $client->company_invoice_state_id = $request['inv_company_state_id'];
            $client->company_invoice_city_name = $request['inv_company_city_name'];
            $client->company_invoice_city_id = $request['inv_company_city_id'];
            $client->company_inv_zip_code = $request['inv_company_zip'];
            $client->company_inv_house_num = $request['inv_company_house_num'];
            $client->company_inv_bldg_num = $request['inv_company_bldg_num'];
            if ($client->save()) {
                return response()->json([
                    'message' => 'OK',
                ],200);
            }
        }
        //update password
        else if($is_request=='update_password'){
            if (Auth::attempt(['username'=>$request['username'],'password' =>$request['curr_password'] ]) || Auth::attempt(['email'=>$request['email'],'password' =>$request['curr_password'] ])) {              
                return response()->json([
                    'message' => 'correct_pass',
                ],200);
            }else{
                return response()->json([
                    'message' => 'wrong_pass',
                ],200);
            }
        }
    }
    public function cancelInspection($id){
        $inspection = Inspection::find($id);
        $status="Cancelled";
        $inspection->inspection_status = $status;
        if ($inspection->save()) {
            return response()->json([
                'message' => 'OK',
            ],200);
        }
    }
	
	//Delete Inspection
	public function deleteInspection($id){
        $inspection = Inspection::find($id);
        $status="Deleted";
        $inspection->inspection_status = $status;
        if ($inspection->save()) {
            return response()->json([
                'message' => 'OK',
            ],200);
        }
    }
    
    public function updateAql(Request $request){
        //$client_aql_detail = ClientAqlDetail::firstOrNew('client_id', Auth::id());
        //$client_aql_detail = ClientAqlDetail::updateOrCreate(['client_id' => Auth::id()]);
        $client_aql_detail = ClientAqlDetail::where('client_id', Auth::id());
        $data = array(
			'normal_level' => $request->input('aql_normal_level'),
			'special_level' => $request->input('aql_special_level'),
			'aql_minor' => $request->input('aql_minor'),
			'aql_major' => $request->input('aql_major')
		);

        if ($client_aql_detail->update($data)) {
            return response()->json([
                'client_aql_detail' => $client_aql_detail
            ],200);
        }
    }
    
    public function updateCompanyDetails(Request $request){
        //$client = Client::find($request['client_code']);
        
        $client = Client::where('client_code', $request->input('client_code')); 
        $data = array(
			'company_name' => $request->input('company_name'),
			'Company_Email' => $request->input('company_email'),
			'Phone_number' => $request->input('company_phone'),
			'company_country_name' => $request->input('company_country'),
			'company_country_id' => $request->input('company_country_id'),
			'company_state_name' => $request->input('company_state'),
			'company_city_name' => $request->input('company_city'),
			'company_zip_code' => $request->input('company_zip'),
			'company_house_num' => $request->input('house_number'),
			'company_bldg_num' => $request->input('bldg_number'),
			'company_street_num' => $request->input('company_street_num')
		);

        if ($client->update($data)) {
            return response()->json([
                'client' => $client
            ],200);
        } 
    }
    
    //Update Company Invoice Details
    public function updateInvoiceDetails(Request $request){
        $client = Client::where('client_code', $request->input('client_code'));
        //$client = Client::where('client_id', Auth::id());
        $data = array(
			'company_invoice_country_name' => $request->input('inv_company_country_name'),
			'company_invoice_country_id' => $request->input('inv_country_id'),
			'company_invoice_state_name' => $request->input('inv_company_state_name'),
			'company_invoice_state_id' => $request->input('inv_company_state_name_id'),
			'company_invoice_city_name' => $request->input('inv_company_city_name'),
			'company_invoice_city_id' => $request->input('inv_company_city_name_id'),
			'company_inv_zip_code' => $request->input('inv_company_zip'),
			'company_inv_house_num' => $request->input('inv_company_house_num'),
			'company_inv_bldg_num' => $request->input('inv_company_bldg_num'),
			'company_inv_street_num' => $request->input('company_inv_street_num')
		);

        if ($client->update($data)) {
            return response()->json([
                'client' => $client
            ],200);
        }
        
    }
    
    //Update Contact Person
    public function updateContactPerson(Request $request){
        $client = ClientContact::where('id', $request['id'])->get();
        
        //$client = Client::where('client_id', Auth::id());
            return response()->json([
                'client' => $client
            ]);
        
        
    }
	
	//Download Updated Inspection App
	public function download_app() {
        //$file_path = public_path('updated-app') . '/TIC-Inspection-app-v1.0.15.apk';
        $file_path= "updated-app/TIC-Inspection-app-v1.0.15.apk";
        //$file_path = URL::asset($file_path);
    	return response()->download($file_path);
	}
	
	//Download Updated Client App
	public function download_client_app() {
		$file_path = public_path('updated-app') . '/TIC-Online-Booking-App-v1.0.1.apk';
    	return response()->download($file_path);
    }
    
    public function downloadAttachments($inspection_id) {

        $attach_path=public_path('images/project2');
		$inspections = Inspection::where('id',$inspection_id)->first();
		
		$dirname = 'images/zip_attachment';

        $zip = new ZipArchive;

        $zip_path= $dirname . '/' . $inspections->client_project_number . ".zip";
        $zip_url = URL::asset($zip_path);

        if (file_exists($zip_path))
			@unlink($zip_path);

        $zip->open($zip_path, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE);

        if (file_exists("images/project2/$inspection_id")){
            $files = File::allFiles("images/project2/$inspection_id");
            foreach ($files as $file){
				$file_info = pathinfo($file);
                $zip->addFile($file->getPathname(), $file_info['basename']);
                //$zip->addFile($file->getPathname());
            }
		}
		$zip->close();

        return redirect($zip_url);
	}
     
}
