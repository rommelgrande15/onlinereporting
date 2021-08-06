<?php

namespace App\Http\Controllers;

use App\Template;
use Dompdf\Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Http;
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
use App\Category;
use App\SubCategory;


use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Array_;
use Session;
use Mail;
use Symfony\Component\DomCrawler\Crawler;


class AdminAccountController extends Controller
{


    public function getDashboardPanel($id){
        if(!Auth::id()){
			return redirect()->route('login');
		}
        
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'pus' => 'Pick Up Sample',
                    'cli' => 'Container Loading Inspection',
                    'pls' => 'Setting Up Production Lines',
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

        $services_new = ['iqi'=>'IQI', 
            'dupro' => 'DUPRO',
            'psi' => 'PSI',
            'cli' => 'CLI',
            'pls' => 'SUPL',
            'st' => 'Sample Test',
            'cbpi' => 'CBPI - No Serial',
            'cbpi_serial' => 'CBPI - w/ Serial',
            'cbpi_isce' => 'CBPI - ISCE',
            'site_visit' => 'Site Visit',
            'SPK' => 'SPK',
            'FRI' => 'FRI',
            'physical' => 'Factory Audit',
			'detail' => 'Detail Audit',
			'social' => 'Social Audit'
        ];
                
    	$role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
    		->where('role_user.user_id',Auth::id())->first();

        $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id')
                    ->where('inspections.client_book', null)
                    ->where('inspections.service','!=', 'null')
                    ->orWhere('inspections.client_book', 'false')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->get();
        //$inspector = UserInfo::where('user_id',$inspections->inspector_id);
        $inspector_list=array();
        $user_manager = UserInfo::all();
        foreach($user_manager as $user){
            $inspector_list[$user->id] = $user->name;
        }
        
        $user_info = UserInfo::where('user_id',Auth::id())->first();

        
        $product = Product::all();
        $psiproduct = PSIProduct::all();
        //$new_client_count = Client::where('client_code','000')->count();
		$new_client_count = DB::table('clients')
            ->join('users','users.client_code','=','clients.client_code')
            ->select('clients.*','users.status')
			->where('clients.client_code',['000'])
			->where('users.status','2')
			->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();

		return view('pages.admin.dashboard.index_new',compact('inspections','services','role','user_info','user_manager','product','psiproduct','services_new','inspector_list','new_client_count','new_post_client','new_post_client_sera'));    	
    }

    public function getDashboardPanelDev($id){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'pus' => 'Pick Up Sample',
                    'cli' => 'Container Loading Inspection',
                    'pls' => 'Setting Up Production Lines',
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

        $services_new = ['iqi'=>'IQI', 
            'dupro' => 'DUPRO',
            'psi' => 'PSI',
            'cli' => 'CLI',
            'pls' => 'SUPL',
            'st' => 'Sample Test',
            'cbpi' => 'CBPI - No Serial',
            'cbpi_serial' => 'CBPI - w/ Serial',
            'cbpi_isce' => 'CBPI - ISCE',
            'site_visit' => 'Site Visit',
            'SPK' => 'SPK',
            'FRI' => 'FRI',
            'physical' => 'Factory Audit',
			'detail' => 'Detail Audit',
			'social' => 'Social Audit'
        ];
                
    	$role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
    		->where('role_user.user_id',Auth::id())->first();

        $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id')
                    ->where('inspections.client_book', null)
                    ->where('inspections.service','!=', 'null')
                    ->orWhere('inspections.client_book', 'false')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->get();
        //$inspector = UserInfo::where('user_id',$inspections->inspector_id);
        $inspector_list=array();
        $user_manager = UserInfo::all();
        foreach($user_manager as $user){
            $inspector_list[$user->id] = $user->name;
        }
        
        $user_info = UserInfo::where('user_id',Auth::id())->first();

        
        $product = Product::all();
        $psiproduct = PSIProduct::all();
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();

		return view('pages.admin.dashboard.index_dev',compact('inspections','services','role','user_info','user_manager','product','psiproduct','services_new','inspector_list','new_client_count','new_post_client','new_post_client_sera'));    	
    }

    public function getClientBookingList(){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'pus' => 'Pick Up Sample',
                    'cli' => 'Container Loading Inspection',
                    'pls' => 'Setting Up Production Lines',
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

        $services_new = ['iqi'=>'IQI', 
            'dupro' => 'DUPRO',
            'psi' => 'PSI',
            'cli' => 'CLI',
            'pls' => 'SUPL',
            'st' => 'Sample Test',
            'cbpi' => 'CBPI - No Serial',
            'cbpi_serial' => 'CBPI - w/ Serial',
            'cbpi_isce' => 'CBPI - ISCE',
            'site_visit' => 'Site Visit',
            'SPK' => 'SPK',
            'FRI' => 'FRI',
            'physical' => 'Factory Audit',
			'detail' => 'Detail Audit',
			'social' => 'Social Audit'
        ];
                
    	$role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
    		->where('role_user.user_id',Auth::id())->first();

        $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->where('inspections.client_book', 'true')
                    ->get();
        //$inspector = UserInfo::where('user_id',$inspections->inspector_id);
        $inspector_list=array();
        $user_manager = UserInfo::all();
        foreach($user_manager as $user){
            $inspector_list[$user->id] = $user->name;
        }
        
        $user_info = UserInfo::where('user_id',Auth::id())->first();

        
        $product = Product::all();
        $psiproduct = PSIProduct::all();
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();
        
		return view('pages.admin.client-booking.index',compact('inspections','services','role','user_info','user_manager','product','psiproduct','services_new','inspector_list','new_client_count','new_post_client','new_post_client_sera'));    	
    }

    public function getSuppliersListAdmin(){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $suppliers = Supplier::where('added_by','admin')->where('supplier_status',0)->get();
        return view('pages.admin.supplier.index',compact('role','suppliers','user_info','client_code','user'));
    }

    public function getInspectionProjectForm(){
        $role = User::where('id',Auth::id())->first();
        //$clients = Client::all(); old 3/4/2019
        $clients = Client::orderBy('client_name', 'asc')->get();
        $countries = Country::all();
        //$factories = Factory::where('factory_status','!=',2)->orderBy('factory_name', 'asc')->get();
        $factories = Factory::where('factory_status','!=',2)->where('client_code',null)->orderBy('factory_name', 'asc')->get();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $inspectors = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->pluck('name','user_id');

        $inspectors_two = UserInfo::where('designation','Inspector')->where('status',0)->orderBy('name','asc')->get();

        $inspectors_new = DB::table('users')
                        ->join('user_infos','user_infos.user_id','=','users.id')
                        ->orderBy('user_infos.name','asc')
                        ->pluck('user_infos.name','users.id');

        //jesser
        // $path_blank_report = "images/blankreport/";
        // $files_blank_report = scandir($path_blank_report);
        // $blank_report_dir=array();
        $currency = [
            'usd' => '($) Us Dollar',
            'eur' => '(€) Euro',
            'gbp' => '(£) British Pound',
            'inr' => '(₹) Indian Rupee',
            'myr' => '(RM) Malaysian Ringgit',
            'cny' => '(¥) Chinese Yuan Renminbi'
        ];
        //$products = Product::all(); old 3/4/2019
        $products = Product::orderBy('product_name', 'asc')->get();
        //$templates = Template::all()->sortByDesc("created_at");
        //$templates = Template::where('identifier',1)->orderBy('created_at','desc')->get();
        $templates = Template::select('id','name')->where('identifier', 1)
        ->orderBy('created_at','desc')
        ->get();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        /* $templates_chinese = Template::where('name','like','%chinese%')->orderBy('name','asc')->get(); */
        //$templates_chinese = Template::all()->sortByDesc("created_at");
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

        ///product category    
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

		
		//Categories
        $categories = Category::orderBy('name', 'desc')->get()->pluck('id','name');
        $sub_categories = SubCategory::orderBy('name', 'desc')->get()->pluck('id','category_id','name');

        ///////API for FM///
        $fm_api = new \GuzzleHttp\Client();
        
        $request = $fm_api->get('http://localhost/web/filemanager-api');
        // Get the actual response without headers
        $response = $request->getBody();

        $fm_accounts = json_decode($response,true);
    

        return view('pages.admin.project.index',compact('clients','role','user_info','p_category','inspectors','factories','countries','products','templates','templates_chinese',
        'inspectors_new','inspectors_two','currency','new_client_count','new_post_client','new_post_client_sera','fm_accounts'));
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
        //06-02-2021
        $insId = $request->input('inspection_id');
        $fileName = $request->input('file_name');
        $image_path = public_path()."/images/project2/".$insId.'/'.$fileName;  // Value is not URL but directory file path
        unlink($image_path);

        $cond=['inspection_id'=>$request['inspection_id'],'file_name'=>$request['file_name']];
        $del_att=DB::table('attachments')->where($cond)->delete();

       // $file = public_path
     
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
            //04-29-2021
            if($template=="" || $request['type_of_project']=="esprit"){$template=0;}
            //04-29-2021
            if($template_word=="" || $request['type_of_project']=="esprit"){$template_word=0;}

            $report_template=$request['report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}
            $inspection->word_template = null;
            
            //04-29-2021
            // if($template_word!=""){
            //     $inspection->template_id = $template_word;
            //  }else{
            //      $inspection->template_id = $template;
            //  }

            // $inspection->template_id = $template;
            $inspection->project_type = $request['type_of_project'];
            $project_type = $request['type_of_project'];

             //05-28-2021
            if($project_type == "word_project"){
                $inspection->template_id = $template_word;
            }else{
                $inspection->template_id = $template;
            }

            
            $inspection->inspection_status = "Released";
            //$inspection->complex_report =  $request['complex_report'];
            $inspection->created_by =  Auth::id();
            $inspection->fm_id =  $request['fm_inspector'];
           

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
                    $prods[$i]->product_first_category = $request['order_product_category'][$i]; //04-15-2021
                    $prods[$i]->product_category = $request['product_sub_category'][$i];
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

                //blank report details
            
                $service = [
                    'iqi' => 'Incoming Quality Inspection',
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'pus' => 'Pick Up Sample',
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
                $report->service = $service[$request['service']];
                $report->inspection_date = $request['inspection_date'];
                $report->inspector_id=$request['inspector'];
                $report->report_no = $report_no;
                $report->password = $password;
                
                if ($report->save()) {

                    $insp_details = Inspection::where('id',$inserted_inspection_id)->first();
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

                    $fac_contact2=$request['factory_contact_person2_psi'];
                    $inspector_info = UserInfo::find($request['inspector']);
                    $inspector_cred = User::find($request['inspector']);
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
                            'second_inspector_email' => $second_inspector_email,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'fm_un' => $request['fm_username'],
                            'fm_pw' => $request['fm_password'],
                            'manday'=>$manday,
                            'spk_fri'=>$request['percentageSpkFri'],
                            'file_passed'=>$upload_file_name,
                            'service'=>$service[$request['service']],
                            'ref_num'=>$request['reference_number'],
                            'inspection_date'=>$request['inspection_date'],
                            'inspection_date_to'=>$request['inspection_date_to'],
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
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
                            // $message->to($data['email']);
                            // // $message->cc('it-support@t-i-c.asia');
                            // // $message->cc('gregor@t-i-c.asia');
                            // // $message->cc('report@t-i-c.asia');
                            // // $message->cc('booking@t-i-c.asia');
                            // // $message->cc($data['book_email']);
                            // // $message->cc('1249484103@qq.com');
                            // // //$message->cc('gregor.voege@web.de');
                            // // $message->cc('2891400188@qq.com');
                            $message->to('miguelbuojr@gmail.com');
                            $message->cc('miguel@t-i-c.asia');
                            if(!empty($data['second_inspector_email'])){
                                foreach ($data['second_inspector_email'] as $sec_email) {
                                    // $message->cc($sec_email);
                                }
                            }
                            $message->subject($data['service'] ." for ". $data['client_number'] ." ". $data['product_subject']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .")");                            
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
                            'service'=>$service[$request['service']],
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'second_inspector_email' => $second_inspector_email,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'fm_un' => $request['fm_username'],
                            'fm_pw' => $request['fm_password'],
                            'file_passed'=>$upload_file_name,
                            'requirement'=>$request['requirement'],
                            'memo'=>$request['memo'],
                            'manday'=>$request['manday'],
                            'client_number'=>$request['client_project_number'],
                            'psi_product_list'=>$psi_product_list,
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num,
                            'book_email'=>$booking_info->email_address];
                        $files_uploaded = $request->file('file');
                        // Mail::send('email.download',$data, function($message) use ($data,$files_uploaded ){
                        //     // $message->to($data['email']);
                        //     // $message->cc('it-support@t-i-c.asia');
                        //     // $message->cc('gregor@t-i-c.asia');
                        //     // $message->cc('report@t-i-c.asia');
                        //     // $message->cc('booking@t-i-c.asia');
                        //     // $message->cc($data['book_email']);
                        //     // $message->cc('1249484103@qq.com');
                        //     // //$message->cc('gregor.voege@web.de');
                        //     // $message->cc('2891400188@qq.com');
                        //     $message->to('miguelbuojr@gmail.com');
                        //     if(!empty($data['second_inspector_email'])){
                        //         foreach ($data['second_inspector_email'] as $sec_email) {
                        //             $message->cc($sec_email);
                        //         }
                        //     }
                        //     $message->subject('Download Blank Report for ' . $data['report_number']);
                        //     foreach ($data['file_passed'] as $file_name) {
                        //         if($file_name=='email_attachment/ABD_1-5.pdf'){
                        //             $message->attach($file_name);
                        //         }
                        //         if($file_name=='email_attachment/TIC_Onsite_Quick_Report.pdf'){
                        //             $message->attach($file_name);
                        //         }
                        //         if($file_name=='email_attachment/File_Manager_User_Manual.pdf'){
                        //             $message->attach($file_name);
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
                       //\LogActivity::addToLog('book',$inspection->id,'add', 'Added New Inspection');
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
            $inspection = new Inspection();
            //inspection details
            $inspection->service = $request['loading_service'];
            $inspection->reference_number = $request['loading_reference_number'];
            $inspection->client_project_number = $request['client_project_number_cbpi'];
            $inspection->inspection_date = $request['loading_inspection_date'];
            $inspection->inspection_date_to = $request['loading_inspection_date_to'];
            $inspection->client_id = $request['loading_client'];
            $inspection->contact_person = $request['loading_contact_person'];
            //factory details
            $inspection->factory = $request['loading_factory'];
            $inspection->factory_contact_person = $request['loading_factory_contact_person'];
            $inspection->factory_contact_person2 = $request['factory_contact_person2_cbpi'];
            //product details
            /* $inspection->client_name = $request['loading_client_name']; */
            $inspection->supplier_name = $request['loading_supplier_name'];
            
            $inspection->requirement = $request['loading_requirements'];
            $inspection->memo = $request['memo'];
            $inspection->inspector_id = $request['loading_inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->manday = $request['manday'];

            $loading_template=$request['loading_template'];
            $loading_template_word=$request['loading_template_word']; //05-05-2021
            // if($loading_template=="" || $request['project_type_cbpi']=="word_project" || $request['project_type_cbpi']=="esprit"){$loading_template=0;}
            if($loading_template=="" || $request['project_type_cbpi']=="esprit"){$loading_template=0;}
            //05-05-2021
            if($loading_template_word==""){$loading_template_word=0;}

            $report_template=$request['loading_report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}
            $report_template=null;
            $inspection->word_template = null;

            //$inspection->template_id = $loading_template;
            $inspection->project_type = $request['project_type_cbpi'];
            $project_type = $request['project_type_cbpi'];

            //05-05-2021
            if($project_type == "word_project"){
                $inspection->template_id = $loading_template_word;
            }else{
                $inspection->template_id = $loading_template;
            }



            $inspection->inspection_status = "Released";
            //$inspection->complex_report =  $request['complex_report'];

            $inspection->created_by =  Auth::id();
            $inspection->fm_id =  $request['fm_inspector_cbpi'];


            if($request['loading_invisible'] == "on"){
                $inspection->Clientstatus = '1';
            }

            if ($inspection->save()) {
                $inserted_inspection_id=$inspection->id;
                $upload_file_name=array();


                $clientCost = new ClientCost();
                    $clientCost->inspection_id =  $inspection->id;
                    $clientCost->currency =  $request['cbpi_cli_currency'];
                    $clientCost->md_charges =  $request['cbpi_cli_md_charge'];
                    $clientCost->travel_cost =  $request['cbpi_cli_travel_cost'];
                    $clientCost->hotel_cost =  $request['cbpi_cli_hotel_cost'];
                    $clientCost->ot_cost =  $request['cbpi_cli_ot_cost']; 
                    $cli_other_cost_text =  $request['cbpi_cli_other_cost_text']; 
                    $cli_other_cost_value =  $request['cbpi_cli_other_cost_value']; 
                    $arr_cli_other_cost_text=null;
                    $arr_cli_other_cost_value=null;
                    if($cli_other_cost_text==null || $cli_other_cost_text=='null'){

                    }else{
                        foreach ($cli_other_cost_text as $i => $value) {
                            //array_push($arr_cli_other_cost_text,$request['cli_other_cost_text'][$i]);
                            if($i==0){
                                $arr_cli_other_cost_text=$request['cbpi_cli_other_cost_text'][$i];
                            }else{
                                $arr_cli_other_cost_text=$arr_cli_other_cost_text.','.$request['cbpi_cli_other_cost_text'][$i];
                            }
                        }
                        foreach ($cli_other_cost_value as $i => $value) {
                            //array_push($arr_cli_other_cost_value,$request['cli_other_cost_value'][$i]);
                            if($i==0){
                                $arr_cli_other_cost_value=$request['cbpi_cli_other_cost_value'][$i];
                            }else{
                                $arr_cli_other_cost_value=$arr_cli_other_cost_value.','.$request['cbpi_cli_other_cost_value'][$i];
                            }
                        }
                    }
                    $clientCost->other_cost_text =  $arr_cli_other_cost_text;
                    $clientCost->other_cost_value =  $arr_cli_other_cost_value; 
                    $clientCost->save();

                    $inspectorCost = new InspectorCost();
                    $inspectorCost->inspection_id =  $inspection->id;
                    $inspectorCost->currency =  $request['cbpi_ins_currency'];
                    $inspectorCost->md_charges =  $request['cbpi_ins_md_charge'];
                    $inspectorCost->travel_cost =  $request['cbpi_ins_travel_cost'];
                    $inspectorCost->hotel_cost =  $request['cbpi_ins_hotel_cost'];
                    $inspectorCost->ot_cost =  $request['cbpi_ins_ot_cost']; 
                    $ins_other_cost_text =  $request['cbpi_ins_other_cost_text']; 
                    $ins_other_cost_value =  $request['cbpi_ins_other_cost_value']; 
                    $arr_ins_other_cost_text=null;
                    $arr_ins_other_cost_value=null;

                    if($ins_other_cost_text==null || $ins_other_cost_text=='null'){

                    }else{
                        foreach ($ins_other_cost_text as $i => $value) {
                            //array_push($arr_ins_other_cost_text,$request['ins_other_cost_text'][$i]);
                            if($i==0){
                                $arr_ins_other_cost_text=$request['cbpi_ins_other_cost_text'][$i];
                            }else{
                                $arr_ins_other_cost_text=$arr_ins_other_cost_text.','.$request['cbpi_ins_other_cost_text'][$i];
                            }

                        }
                        foreach ($ins_other_cost_value as $i => $value) {
                            //array_push($ins_other_cost_value,$request['ins_other_cost_value'][$i]);
                            if($i==0){
                                $arr_ins_other_cost_value=$request['cbpi_ins_other_cost_value'][$i];
                            }else{
                                $arr_ins_other_cost_value=$arr_ins_other_cost_value.','.$request['cbpi_ins_other_cost_value'][$i];
                            }
                        }
                    }
                    $inspectorCost->other_cost_text =  $arr_ins_other_cost_text;
                    $inspectorCost->other_cost_value =  $arr_ins_other_cost_value; 
                    $inspectorCost->save();

                /* $prods = new PSIProduct();
                $prods->inspection_id = $inspection->id;
                $prods->product_name = "null";
                $prods->brand = "null";
                $prods->po_no = "null";
                $prods->model_no = "null";
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
                $prods->save(); */

                /* $abd_dir = 'email_attachment/ABD_1-5.pdf';
                if(File::exists($abd_dir)){
                    array_push($upload_file_name,$abd_dir); // attach the abd
                } */

                $attachment = Attachment::where('inspection_id',$inserted_inspection_id)->get();
                    if(count($attachment)>0){
                        foreach($attachment as $up_file){
                            array_push($upload_file_name,$up_file->path);
                        }
                    }

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

                foreach ($request->file('file') as $file) {
                    //set a unique file name
                    //$filename = uniqid().'.'.$file->getClientOriginalExtension();

                    $filename = $file->getClientOriginalName();
                    $filename=str_replace("#","_",$filename);

                    $dir="images/project2/".$inserted_inspection_id."/";

                    //move the files to the correct folder
                    if (!File::exists($dir)) {
                        File::makeDirectory($dir, 0777, true, true);
                    }

                    //move the files to the correct folder


                    //push file name in array
                    array_push($upload_file_name,$dir.$filename);

                    //save details to db
                    $doc= new Attachment();
                    $doc->inspection_id = $inserted_inspection_id;
                    $doc->project_number = $request['loading_reference_number'];
                    $doc->file_name = $filename;
                    $doc->file_size = $file->getSize();
                    $doc->path = $dir.$filename;
                    $doc->save();
                
		    		$file->move($dir,$filename);
                }

                $client = Client::where('id',$request['client'])->first();
            
                $password = mt_rand(100000, 999999);

                $report = new Report();
                $report->inspection_id = $inspection->id;
                $report->client_code = $request['loading_client'];
                $report->service = $request['loading_service'];
                $report->inspection_date = $request['loading_inspection_date'];
                $report->inspector_id = $request['loading_inspector'];
                $report->report_no = $request['loading_reference_number'];
                $report->password = $password;


                if ($report->save()) {

                    $insp_details = Inspection::where('id',$inserted_inspection_id)->first();
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

                    $fac_contact2=$request['factory_contact_person2_cbpi'];
                    $inspector_info = UserInfo::find($request['loading_inspector']);
                    $inspector_cred = User::find($request['loading_inspector']);
                    $factory = Factory::find($request['loading_factory']);
                    $factory_contact = FctoryContact::find($request['loading_factory_contact_person']);
                    $factory_contact_sec = FctoryContact::find($request['factory_contact_person2_cbpi']);

                    $blank_report_dir=array();
                    $booking_info = UserInfo::find(Auth::id());

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

                    if($request['project_type_cbpi']=='word_project' || $request['project_type_cbpi']=="esprit"){

                        $data = ['report_number' =>  $request['loading_reference_number'],
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'second_inspector_email' => $second_inspector_email,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'fm_un' => $request['fm_username_cbpi'],
                            'fm_pw' => $request['fm_password_cbpi'],
                            'file_passed'=>$upload_file_name,
                            'service'=>$service[$request['loading_service']],
                            'ref_num'=>$request['loading_reference_number'],
                            'inspection_date'=>$request['loading_inspection_date'],
                            'inspection_date_to'=>$request['loading_inspection_date_to'],
                            'manday'=>$request['manday'],
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'factory_address_local'=>$factory->factory_address_local,
                            'factory_contact'=>$factory_contact->factory_contact_person,
                            'client_number'=>$request['client_project_number_cbpi'],
                            'requirement'=>$request['loading_requirements'],
                            'supplier'=>$request['loading_supplier_name'],
                            'memo'=>$request['memo'],
                            'book_email'=>$booking_info->email_address,
                            'fac_contact'=>$fac_contact,
                            'fac_email'=>$fac_email,
                            'fac_num'=>$fac_num];

                        $files_uploaded = $request->file('file');
                        Mail::send('email.manual_download_cbpi',$data, function($message) use ($data,$files_uploaded ){
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
                            if(!empty($data['second_inspector_email'])){
                                foreach ($data['second_inspector_email'] as $sec_email) {
                                    $message->cc($sec_email);
                                }
                            }

                            if($data['service']=="Factory Audit"){
                                $message->subject('Factory Audit at ' .$data['factory_name']. " on " . $data['inspection_date']);
                            }else if($data['service']=="Container Loading Inspection"){
                                $message->subject('CLI for ' .$data['factory_name']. " on " . $data['inspection_date']);
                            }else if($data['service']=="Detail Audit"){
                                $message->subject('Detail At ' .$data['factory_name']. " on " . $data['inspection_date']);
                            }else if($data['service']=="Social Audit"){
                                $message->subject('Social At ' .$data['factory_name']. " on " . $data['inspection_date']);
                            }else{
                                $message->subject('CBPI for ' .$data['client_number']. " on " . $data['inspection_date']);
                            }
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
                            $data = ['report_number' =>  $request['loading_reference_number'],
                                'inspection_date'=>$request['loading_inspection_date'],
                                'inspection_date_to'=>$request['loading_inspection_date_to'],
                                'password' => $password,
                                'service'=>$service[$request['loading_service']],
                                'email' => $inspector_info->email_address,
                                'second_inspector_email' => $second_inspector_email,
                                'insp_name' => $inspector_info->name,
                                'insp_un' => $inspector_cred->username,
                                'insp_pw' => $inspector_cred->plain,
                                'fm_un' => $request['fm_username_cbpi'],
                                'fm_pw' => $request['fm_password_cbpi'],
                                'file_passed'=>$upload_file_name,
                                'requirement'=>$request['loading_requirements'],
                                'memo'=>$request['memo'],
                                'client_number'=>$request['client_project_number_cbpi'],
                                'factory_name'=>$factory->factory_name,
                                'factory_address'=>$factory->factory_address,
                                'factory_address_local'=>$factory->factory_address_local,
                                'factory_contact'=>$factory_contact->factory_contact_person,
                                'fac_contact'=>$fac_contact,
                                'fac_email'=>$fac_email,
                                'fac_num'=>$fac_num,
                                'book_email'=>$booking_info->email_address];
                        $files_uploaded = $request->file('file');
                        Mail::send('email.download_cbpi',$data, function($message) use ($data,$files_uploaded ){
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
                            if(!empty($data['second_inspector_email'])){
                                foreach ($data['second_inspector_email'] as $sec_email) {
                                    $message->cc($sec_email);
                                }
                            }
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
                        // Session::flash('error',"There was a problem sending the inspection project details!");
                        // return redirect()->route('panel',Auth::id());
                        DB::rollback();
                        return response()->json([
                            'message' => 'error',
                        ],500);
                    }else{
                       /* Session::flash('success',"Successfully saved new inspection project details!");
                        return redirect()->route('panel',Auth::id());*/
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
            $inspection->inspector_id = $request['site_inspector'];
            $inspection->secondary_inspector_id = $request['second_inspector'];
            $inspection->manday = $request['site_manday'];

            $loading_template=$request['site_template'];
            if($loading_template=="" || $request['project_type_site']=="word_project"){$loading_template=0;}

            $report_template=$request['site_report_template'];
            if($report_template=="" || $report_template=='N/A'){$report_template=null;}
            $report_template=null;
            $inspection->word_template = null;

            $inspection->template_id = $loading_template;
            $inspection->project_type = $request['project_type_site'];



            $inspection->inspection_status = "Released";

            $inspection->created_by =  Auth::id();


            if($request['site_invisible'] == "on"){
                $inspection->Clientstatus = '1';
            }

            if ($inspection->save()) {
                $inserted_inspection_id=$inspection->id;
                $upload_file_name=array();


                $clientCost = new ClientCost();
                    $clientCost->inspection_id =  $inspection->id;
                    $clientCost->currency =  $request['site_cli_currency'];
                    $clientCost->md_charges =  $request['site_cli_md_charge'];
                    $clientCost->travel_cost =  $request['site_cli_travel_cost'];
                    $clientCost->hotel_cost =  $request['site_cli_hotel_cost'];
                    $clientCost->ot_cost =  $request['site_cli_ot_cost']; 
                    $cli_other_cost_text =  $request['site_cli_other_cost_text']; 
                    $cli_other_cost_value =  $request['site_cli_other_cost_value']; 
                    $arr_cli_other_cost_text=null;
                    $arr_cli_other_cost_value=null;
                    if($cli_other_cost_text==null || $cli_other_cost_text=='null'){

                    }else{
                        foreach ($cli_other_cost_text as $i => $value) {
                            if($i==0){
                                $arr_cli_other_cost_text=$request['site_cli_other_cost_text'][$i];
                            }else{
                                $arr_cli_other_cost_text=$arr_cli_other_cost_text.','.$request['site_cli_other_cost_text'][$i];
                            }
                        }
                        foreach ($cli_other_cost_value as $i => $value) {
                            if($i==0){
                                $arr_cli_other_cost_value=$request['site_cli_other_cost_value'][$i];
                            }else{
                                $arr_cli_other_cost_value=$arr_cli_other_cost_value.','.$request['site_cli_other_cost_value'][$i];
                            }
                        }
                    }
                    $clientCost->other_cost_text =  $arr_cli_other_cost_text;
                    $clientCost->other_cost_value =  $arr_cli_other_cost_value; 
                    $clientCost->save();

                    $inspectorCost = new InspectorCost();
                    $inspectorCost->inspection_id =  $inspection->id;
                    $inspectorCost->currency =  $request['site_ins_currency'];
                    $inspectorCost->md_charges =  $request['site_ins_md_charge'];
                    $inspectorCost->travel_cost =  $request['site_ins_travel_cost'];
                    $inspectorCost->hotel_cost =  $request['site_ins_hotel_cost'];
                    $inspectorCost->ot_cost =  $request['site_ins_ot_cost']; 
                    $ins_other_cost_text =  $request['site_ins_other_cost_text']; 
                    $ins_other_cost_value =  $request['site_ins_other_cost_value']; 
                    $arr_ins_other_cost_text=null;
                    $arr_ins_other_cost_value=null;

                    if($ins_other_cost_text==null || $ins_other_cost_text=='null'){

                    }else{
                        foreach ($ins_other_cost_text as $i => $value) {
                            if($i==0){
                                $arr_ins_other_cost_text=$request['site_ins_other_cost_text'][$i];
                            }else{
                                $arr_ins_other_cost_text=$arr_ins_other_cost_text.','.$request['site_ins_other_cost_text'][$i];
                            }

                        }
                        foreach ($ins_other_cost_value as $i => $value) {
                            if($i==0){
                                $arr_ins_other_cost_value=$request['site_ins_other_cost_value'][$i];
                            }else{
                                $arr_ins_other_cost_value=$arr_ins_other_cost_value.','.$request['site_ins_other_cost_value'][$i];
                            }
                        }
                    }
                    $inspectorCost->other_cost_text =  $arr_ins_other_cost_text;
                    $inspectorCost->other_cost_value =  $arr_ins_other_cost_value; 
                    $inspectorCost->save();

                    /* $abd_dir = 'email_attachment/ABD_1-5.pdf';
                    if(File::exists($abd_dir)){
                        array_push($upload_file_name,$abd_dir); // attach the abd
                    } */

                $attachment = Attachment::where('inspection_id',$inserted_inspection_id)->get();
                    if(count($attachment)>0){
                        foreach($attachment as $up_file){
                            array_push($upload_file_name,$up_file->path);
                        }
                    }

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

                foreach ($request->file('file') as $file) {


                    $filename = $file->getClientOriginalName();
                    $filename=str_replace("#","_",$filename);

                    $dir="images/project2/".$inserted_inspection_id."/";

                    if (!File::exists($dir)) {
                        File::makeDirectory($dir, 0777, true, true);
                    }





                    array_push($upload_file_name,$dir.$filename);


                    $doc= new Attachment();
                    $doc->inspection_id = $inserted_inspection_id;
                    $doc->project_number = $request['site_reference_number'];
                    $doc->file_name = $filename;
                    $doc->file_size = $file->getSize();
                   //$doc->file_size = 56716;
                    $doc->path = $dir.$filename;
                    $doc->save();
                
		    		$file->move($dir,$filename);
                }

                $client = Client::where('id',$request['site_client'])->first();
            
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

                    $insp_details = Inspection::where('id',$inserted_inspection_id)->first();
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

                    $inspector_info = UserInfo::find($request['site_inspector']);
                    $inspector_cred = User::find($request['site_inspector']);
                    $blank_report_dir=array();
                    $booking_info = UserInfo::find(Auth::id());

                    $fac_contact="";
                    $fac_email="";
                    $fac_num="";

                    $fac_con2="";
                    $fac_email2="";
                    $fac_num2="";

                    if($request['project_type_site']=='word_project'){

                        $data = ['report_number' =>  $request['site_reference_number'],
                            'password' => $password,
                            'email' => $inspector_info->email_address,
                            'second_inspector_email' => $second_inspector_email,
                            'insp_name' => $inspector_info->name,
                            'insp_un' => $inspector_cred->username,
                            'insp_pw' => $inspector_cred->plain,
                            'file_passed'=>$upload_file_name,
                            'service'=>$service[$request['site_service']],
                            'ref_num'=>$request['site_reference_number'],
                            'inspection_date'=>$request['site_inspection_date'],
                            'inspection_date_to'=>$request['site_inspection_date_to'],
                            'manday'=>$request['site_manday'],
                            'company_name'=>$request['com_name'],
                            'company_address'=>$request['comp_addr'],
                            'company_other_info'=>$request['comp_other_info'],
                            'client_number'=>$request['site_project_number'],
                            'requirement'=>$request['site_requirements'],
                            'memo'=>$request['site_memo'],
                            'book_email'=>$booking_info->email_address];

                        $files_uploaded = $request->file('file');
                        Mail::send('email.manual_download_site',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('1249484103@qq.com');
                            //$message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            if(!empty($data['second_inspector_email'])){
                                foreach ($data['second_inspector_email'] as $sec_email) {
                                    $message->cc($sec_email);
                                }
                            }
                            $message->subject('Site Visit for ' .$data['client_number']. " on " . $data['inspection_date']);                            

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
                            $data = ['report_number' =>  $request['site_reference_number'],
                                'inspection_date'=>$request['site_inspection_date'],
                                'inspection_date_to'=>$request['site_inspection_date_to'],
                                'password' => $password,
                                'email' => $inspector_info->email_address,
                                'second_inspector_email' => $second_inspector_email,
                                'insp_name' => $inspector_info->name,
                                'insp_un' => $inspector_cred->username,
                                'insp_pw' => $inspector_cred->plain,
                                'file_passed'=>$upload_file_name,
                                'company_name'=>$request['com_name'],
                                'company_address'=>$request['comp_addr'],
                                'company_other_info'=>$request['comp_other_info'],
                                'requirement'=>$request['site_requirements'],
                                'memo'=>$request['site_memo'],
                                'book_email'=>$booking_info->email_address];
                        $files_uploaded = $request->file('file');
                        Mail::send('email.download_site',$data, function($message) use ($data,$files_uploaded ){
                            $message->to($data['email']);
                            $message->cc('it-support@t-i-c.asia');
                            $message->cc('gregor@t-i-c.asia');
                            $message->cc('report@t-i-c.asia');
                            $message->cc('booking@t-i-c.asia');
                            $message->cc($data['book_email']);
                            $message->cc('1249484103@qq.com');
                            //$message->cc('gregor.voege@web.de');
                            $message->cc('2891400188@qq.com');
                            if(!empty($data['second_inspector_email'])){
                                foreach ($data['second_inspector_email'] as $sec_email) {
                                    $message->cc($sec_email);
                                }
                            }
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
        $inspector_cost = InspectorCost::where('inspection_id',$id)->first();
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
            'products'=>$products,
            'inspector_cost'=>$inspector_cost
        ]);
    }

    //Added Jesser for button view project of PSI
    public function getInspectionDetails($id){
        $user_info = UserInfo::where('user_id',Auth::id())->first();
   
        $inspection = DB::table('inspections')
                    ->join('clients','clients.client_code', '=', 'inspections.client_id')
                    ->join('users','inspections.inspector_id', '=', 'users.id')
                    ->join('user_infos','users.id', '=', 'user_infos.user_id')
                    ->join('client_contacts','inspections.contact_person', '=', 'client_contacts.id')
                    ->join('factories','inspections.factory', '=', 'factories.id')
                    ->join('fctory_contacts','inspections.factory_contact_person', '=', 'fctory_contacts.id')
                    ->select('inspections.*','clients.client_name','users.*','user_infos.*','client_contacts.*','factories.*','fctory_contacts.*')
                    ->where('inspections.id',$id)                    
                    ->first();  
                    
        $second_inspector = DB::table('inspections')
        ->join('users','inspections.secondary_inspector_id', '=', 'users.id')
        ->join('user_infos','users.id', '=', 'user_infos.user_id')
        ->select('inspections.*','users.*','user_infos.*')
        ->where('inspections.id',$id)                    
        ->first(); 

        $reference = Report::where('inspection_id',$id)->get();
        $inspector_cost = InspectorCost::where('inspection_id',$id)->get();

        $inspection_new = DB::table('inspections')
                        ->where('id',$id)                    
                        ->first(); 
        $inspector_cost = InspectorCost::where('inspection_id',$id)->first();
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
        $product_photos = DB::table('product_photos')
                    ->get(); 
        $attachments =  DB::table('attachments')
                    ->where('inspection_id',$id)                    
                    ->get(); 
        $client_attachments =  DB::table('client_attachments')
                    ->where('inspection_id',$id)                    
                    ->get(); 
        $supplier = [];
        $supplier_contacts = [];
        if(!empty($inspection_new)){
            $supplier = DB::table('suppliers')
                ->where('id',$inspection_new->supplier_id)                    
                ->get();
            $supplier_contacts =  DB::table('supplier_contacts')
            ->where('id',$inspection_new->supplier_contact_id)                    
            ->get();
        }

        return response()->json([
            'user_info' => $user_info,
            'inspection' => $inspection,
            'inspection_new' => $inspection_new,
            'reference' => $reference,
            'clients'=> $clients,
            'attachments'=> $attachments,
            'client_attachments'=> $client_attachments,
            'client_contact_list'=>$client_contact_list,
            'factory'=>$factory,
            'factory_contact_list'=>$factory_contact_list,
            'factory_contact1'=>$factory_contact1,
            'psi_product'=>$psi_product,
            'products'=>$products,
            'product_photos'=>$product_photos,
            'supplier'=>$supplier,
            'supplier_contacts'=>$supplier_contacts,
            'inspector_cost'=>$inspector_cost,
            'second_inspector'=>$second_inspector
        ]);
    }

    //Added Jesser
    public function getEditProjectDetails($id){
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
                        ->get(); 
       // $psi_product = PSIProduct::where('inspection_id',$id)->get();
        $clients =  DB::table('inspections')
                    ->join('clients','clients.client_code', '=', 'inspections.client_id')
                    ->where('inspections.id',$id)                    
                    ->get(); 
       $psi_product = DB::table('p_s_i_products',$id)
                    ->join('products','p_s_i_products.product_name', '=', 'products.id')
                    ->where('p_s_i_products.inspection_id',$id)
                    ->get();   
    
        return response()->json([
            'user_info' => $user_info,
            'inspection' => $inspection,
            'inspection_new' => $inspection_new,
            'reference' => $reference,
            'psi_product' => $psi_product,
            'clients'=> $clients
        ]);
    }

    //get specific details of inspection
    public function getOneInspectionDetail($id){
        $inspection = Inspection::where('id',$id)->first(); 
        $client = Client::where('client_code',$inspection->client_id)->first();
        return response()->json([
            'inspection' => $inspection,
            'client' => $client
        ]);
    }

    //admin cancel of inspection
    public function cancelInspection($id){
        DB::beginTransaction();
        try{
            $inspection = Inspection::where('id',$id)->first(); 
            $client = Client::where('client_code',$inspection->client_id)->first();
            $inspector_info = UserInfo::find($inspection->inspector_id);
            $factory = Factory::find($inspection->factory);
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

            $update_inspection = Inspection::find($id);
            $update_inspection->inspection_status = 'Cancelled';
            if ($update_inspection->save()) {
                $data = ['inspection_date'=>$inspection->inspection_date,
                            'service'=>$service[$inspection->service],
                            'ref_num'=>$inspection->reference_number,
                            'client_number'=>$inspection->reference_number,
                            'factory_name'=>$factory->factory_name,
                            'factory_address'=>$factory->factory_address,
                            'insp_email' => $inspector_info->email_address,
                            'old_insp_name' => $inspector_info->name,
                            'client_name'=>$client->Company_Name,
                            'client_email'=>$client->Company_Email
                        ];

                if($inspection->inspection_status=='Released'){
                    Mail::send('email.cancel_inspector',$data, function($message) use ($data){
                        // $message->to($data['insp_email']);
                        // $message->cc('it-support@t-i-c.asia');
                        // $message->cc('gregor@t-i-c.asia');
                        // $message->cc('report@t-i-c.asia');
                        // $message->cc('booking@t-i-c.asia');
                        // $message->cc('1249484103@qq.com');
                        //         //$message->cc('gregor.voege@web.de');
                        //         $message->cc('2891400188@qq.com');
                        $message->to('miguelbuojr@gmail.com');
                        $message->subject($data['client_number']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .") - Cancelled Inspection");             
                    });
                }

                /* Mail::send('email.cancel_client',$data, function($message) use ($data){
                    $message->to($data['client_email']);
                    $message->cc('it-support@t-i-c.asia');
                    $message->cc('gregor@t-i-c.asia');
                    $message->cc('report@t-i-c.asia');
                    $message->cc('booking@t-i-c.asia');
                    $message->subject($data['client_number']  ." at ". $data['factory_name'] ." in ". $data['factory_address'] ." (". $data['inspection_date'] .") - Cancelled Inspection");             
                }); */

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
        } catch (Exception $e) {
            DB::rollback();
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
    }

    //admin delete client inspection
    public function deleteInspection($id){
        DB::beginTransaction();
        try{
            $inspection = Inspection::where('id',$id)->delete(); 
            $report = Report::where('inspection_id',$id)->delete(); 
            $attachment = Attachment::where('inspection_id',$id)->delete(); 
            $attach_dir=public_path('images/project2/'.$id);
            File::deleteDirectory($attach_dir);
            DB::commit();
            return response()->json([
                'message' => 'OK',
            ],200);

            /* if($inspection->delete() && $report->delete() && $attachment->delete()){
                File::deleteDirectory($attach_dir);
                DB::commit();
                return response()->json([
                    'message' => 'OK',
                ],200);
            } */
        }catch (Exception $e) {
            DB::rollback();
            return response()->json([
               'message'=>$e->getMessage()
           ],500);
       }
        
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
        
        $second_inspector = DB::table('inspections')
                    ->join('users','inspections.secondary_inspector_id', '=', 'users.id')
                    ->join('user_infos','users.id', '=', 'user_infos.user_id')
                    ->select('inspections.*','users.*','user_infos.*')
                    ->where('inspections.id',$id)                    
                    ->first(); 
                    
        $reference = Report::where('inspection_id',$id)->get();
        $inspection_new = DB::table('inspections')
                        ->where('id',$id)                    
                        ->first();       
        $inspector_cost = InspectorCost::where('inspection_id',$id)->first();
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

        $client_attachments =  DB::table('client_attachments')
                    ->where('inspection_id',$id)                    
                    ->get(); 
      
        return response()->json([
            'user_info' => $user_info,
            'inspection' => $inspection,
            'inspection_new' => $inspection_new,
            'reference' => $reference,
            'clients'=> $clients,
            'attachments'=> $attachments,
            'client_attachments'=> $client_attachments,
            'client_contact_list'=>$client_contact_list,
            'factory'=>$factory,
            'factory_contact_list'=>$factory_contact_list,
            'factory_contact1'=>$factory_contact1,
            'inspector_cost'=>$inspector_cost,
            'second_inspector'=>$second_inspector
        ]);
    }

    public function uploadFiles(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
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

    public function testReportNo(){
        $client = Client::where('id',2)->first();
        $year = date("Y");

        $report_id = Report::orderBy('id','desc')->first();

        if (empty($report_id)) {
            $report_id = 1;
        }
        $report_id = str_pad($report_id, 8, '0', STR_PAD_LEFT);

        $report_no = $client->client_code.'-'.$year.'-'.$report_id;
        return response()->json([
            'id'=>$report_no,
        ]);
    }

    public function getTemplateForm() {
        $role = User::where('id',Auth::id())->first();
        $clients = Client::all();
        $countries = Country::all();
        $factories = Factory::all();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $inspectors = UserInfo::where('designation','Inspector')->where('status',0)->pluck('name','id');
        $products = Product::all();
        $templates = Template::all()->sortByDesc('id');
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();
        return view('pages.admin.templates.index', compact('clients','role','user_info','inspectors','factories','countries','products','templates','new_client_count','new_post_client','new_post_client_sera'));
    }

    public function getTemplate($id){
        $template = Template::find($id);

        return response()->json($template, 200);
    }



    public function postTemplate(Request $request){
        $html_string = <<<HTML
<!DOCTYPE html>
<html>
<body>
$request->html
</body>
</html>
HTML;

        $html = new Crawler();
        $html->addHtmlContent($html_string);

        $html->filter('table[tic-input=custom-table]')->each(function ($node) {
            $node->filterXPath('//td/*[@tic-input != "cb-option" and @tic-input != "product-option" and @tic-input != "cr-option"]')->each(function($nod){
                $attr = $nod->getNode(0)->getAttribute('tic-input');
                $nod->getNode(0)->removeAttribute('tic-input');
                $nod->getNode(0)->setAttribute('tic-component', $attr);
            });
        });

        $data = $html->filter('table[section=yes]')->each(function ($node) {
            $items = $node->filterXPath('//td/*[@tic-input != "cb-option" and @tic-input != "product-option" and @tic-input != "cr-option"]')->each(function($nod){
                switch ($nod->attr('tic-input')){
                    case 'custom-table':
                        $item['component'] = 'custom-table';
                        $item['key'] = $nod->attr('id');
						$item['label'] = $nod->attr('label');
                        $items = $nod->filterXPath('//td/*[@tic-component]')->each(function($no){
                            switch($no->attr('tic-component')){
                                case 'inputbox':
                                    $item['field'] = $no->attr('field');
                                    $item['key'] = $no->attr('id');
                                    $item['label'] = $no->attr('label');
                                    if($no->attr('field') == 'time24'){
                                        $item['component'] = 'date-time-input';
                                    } elseif ($no->attr('field') == 'time12') {
                                        $item['component'] = 'date-time-input';
                                    } else {
                                        $item['component'] = 'form-input';
                                    }

                                    return $item;
                                case 'picture':
                                    $item['key'] = $no->attr('id');
                                    $item['label'] = $no->attr('label');
                                    if($no->attr('field') == NULL){
                                        $item['component'] = 'take-picture';
                                    } else {
                                        $item['component'] = $no->attr('field');
                                    }
                                    if($no->attr('edit-label') !== null){
                                        $item['options']['editable'] = true;
                                    } else {
                                        $item['options']['editable'] = false;
                                    }
                                    if($no->attr('portrait-mode') !== null){
                                        $item['options']['portrait'] = true;
                                    } else {
                                        $item['options']['portrait'] = false;
                                    }

                                    return $item;
                                case 'remarks':
                                    $item['key'] = $no->attr('id');
                                    $item['label'] = $no->attr('label');
                                    $item['component'] = $no->attr('field') == NULL?'remarks':$no->attr('field');

                                    return $item;
                                case 'cb-group':
                                    $item['component'] = 'combo-box-condition';
                                    $item['key'] = $no->attr('id');
                                    $item['label'] = $no->attr('label');
                                    $item['field'] = $no->getNode(0)->hasAttribute('display-all')?'yes':'no';
                                    $options = $no->children()->each(function ($n) {
                                        if ($n->attr('field') !== null) {
                                            $item = [
                                                "option" => $n->attr('label'),
                                                "condition" => true,
                                                "field" => $n->attr('field')
                                            ];
                                            return $item;
                                        }
                                        $item = [
                                            "option" => $n->attr('label'),
                                            "condition" => false,
                                            "field" => ''
                                        ];

                                        return $item;
                                    });
                                    $item['options'] = $options;

                                    return $item;
                            }
                        });
                        $item['options'] = $items;

                        return $item;
                    case 'total-number':
                        $item['component'] = 'total-number';
                        $item['key'] = $nod->attr('id');

                        return $item;
                    case 'cr-group':
                        $item['component'] = 'checkbox-radio';
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['field'] = $nod->getNode(0)->hasAttribute('multiple');
                        $options = $nod->children()->each(function ($no) {
                            $item = [
                                "option" => $no->attr('label'),
                                "value" => false
                            ];

                            return $item;
                        });
                        $item['options'] = $options;

                        return $item;

                    case 'image':
                        $item['key'] = $nod->attr('id');
                        $item['component'] = 'show-image';
                        if($nod->getNode(0)->hasAttribute('show-in-app')){
                            $item['label'] = true;
                            $path = $nod->attr('src');
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $item['field'] = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        } else {
                            $item['label'] = false;
                            $item['field'] = '';
                        }

                        return $item;
                    case 'gen-info':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['component'] = 'gen-info';
                        $item['field'] = $nod->attr('field') ? $nod->attr('field') : $nod->attr('custom-value');
                        $item['options'] = $nod->attr('editable') !== null ? 'editable' : 'not';

                        return $item;
                    case 'inputbox':
                        $item['field'] = $nod->attr('field');
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        if($nod->attr('field') == 'time24'){
                            $item['component'] = 'date-time-input';
                        } elseif ($nod->attr('field') == 'time12') {
                            $item['component'] = 'date-time-input';
                        } else {
                            $item['component'] = 'form-input';
                        }

                        return $item;
                    case 'picture':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        if($nod->attr('field') == NULL){
                            $item['component'] = 'take-picture';
                        } else {
                            $item['component'] = $nod->attr('field');
                        }
                        if($nod->attr('edit-label') !== null){
                            $item['options']['editable'] = true;
                        } else {
                            $item['options']['editable'] = false;
                        }
                        if($nod->attr('portrait-mode') !== null){
                            $item['options']['portrait'] = true;
                        } else {
                            $item['options']['portrait'] = false;
                        }

                        return $item;
                    case 'cb-group':
                        $item['component'] = 'combo-box-condition';
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['field'] = $nod->getNode(0)->hasAttribute('display-all')?'yes':'no';
                        $options = $nod->children()->each(function ($no) {
                            if ($no->attr('field') !== null) {
                                $item = [
                                    "option" => $no->attr('label'),
                                    "condition" => true,
                                    "field" => $no->attr('field')
                                ];
                                return $item;
                            }
                            $item = [
                                "option" => $no->attr('label'),
                                "condition" => false,
                                "field" => ''
                            ];

                            return $item;
                        });
                        $item['options'] = $options;

                        return $item;
                    case 'remarks':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['component'] = $nod->attr('field') == NULL?'remarks':$nod->attr('field');

                        return $item;
                    case 'product-input':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['component'] = 'product-input';
                        $options = $nod->filter('td div[tic-input=product-option]')->each(function ($no) {
                            $item = [
                                "key" => $no->attr('id'),
                                "label" => $no->attr('label'),
                                "field" => $no->attr('field'),
                                "value" => ''
                            ];
                            return $item;
                        });
                        $item['options'] = $options;

                        return $item;
                    case 'product-description':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['component'] = 'product-description';

                        return $item;
                }
            });
            if($items && count($items) > 0)
                return ["key" => $node->attr('id'), "title" => $node->filter('th div')->text(), "data" => ["items" => $items]];
        });

        $hf = $html->filterXPath('//table[@class = "header" or @class="footer"]')->each(function ($node) {
            $items = $node->filterXPath('//td/*[@tic-input != "cb-option" and @tic-input != "product-option" and @tic-input != "cr-option"]')->each(function($nod){
                switch ($nod->attr('tic-input')){
                    case 'custom-table':
                        $item['component'] = 'custom-table';
                        $item['key'] = $nod->attr('id');
                        $items = $nod->filterXPath('//td/*[@tic-component]')->each(function($no){
                            switch($no->attr('tic-component')){
                                case 'inputbox':
                                    $item['field'] = $no->attr('field');
                                    $item['key'] = $no->attr('id');
                                    $item['label'] = $no->attr('label');
                                    if($no->attr('field') == 'time24'){
                                        $item['component'] = 'date-time-input';
                                    } elseif ($no->attr('field') == 'time12') {
                                        $item['component'] = 'date-time-input';
                                    } else {
                                        $item['component'] = 'form-input';
                                    }

                                    return $item;
                                case 'picture':
                                    $item['key'] = $no->attr('id');
                                    $item['label'] = $no->attr('label');
                                    if($no->attr('field') == NULL){
                                        $item['component'] = 'take-picture';
                                    } else {
                                        $item['component'] = $no->attr('field');
                                    }
                                    if($no->attr('edit-label') !== null){
                                        $item['options']['editable'] = true;
                                    } else {
                                        $item['options']['editable'] = false;
                                    }
                                    if($no->attr('portrait-mode') !== null){
                                        $item['options']['portrait'] = true;
                                    } else {
                                        $item['options']['portrait'] = false;
                                    }

                                    return $item;
                                case 'remarks':
                                    $item['key'] = $no->attr('id');
                                    $item['label'] = $no->attr('label');
                                    $item['component'] = $no->attr('field') == NULL?'remarks':$no->attr('field');

                                    return $item;
                                case 'cb-group':
                                    $item['component'] = 'combo-box-condition';
                                    $item['key'] = $no->attr('id');
                                    $item['label'] = $no->attr('label');
                                    $item['field'] = $no->getNode(0)->hasAttribute('display-all')?'yes':'no';
                                    $options = $no->children()->each(function ($n) {
                                        if ($n->attr('field') !== null) {
                                            $item = [
                                                "option" => $n->attr('label'),
                                                "condition" => true,
                                                "field" => $n->attr('field')
                                            ];
                                            return $item;
                                        }
                                        $item = [
                                            "option" => $n->attr('label'),
                                            "condition" => false,
                                            "field" => ''
                                        ];

                                        return $item;
                                    });
                                    $item['options'] = $options;

                                    return $item;
                            }
                        });
                        $item['options'] = $items;

                        return $item;
                    case 'total-number':
                        $item['component'] = 'total-number';
                        $item['key'] = $nod->attr('id');

                        return $item;
                    case 'cr-group':
                        $item['component'] = 'checkbox-radio';
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['field'] = $nod->getNode(0)->hasAttribute('multiple');
                        $options = $nod->children()->each(function ($no) {
                            $item = [
                                "option" => $no->attr('label'),
                                "value" => false
                            ];

                            return $item;
                        });
                        $item['options'] = $options;

                        return $item;


                    case 'image':
                        $item['key'] = $nod->attr('id');
                        $item['component'] = 'show-image';
                        if($nod->getNode(0)->hasAttribute('show-in-app')){
                            $item['label'] = true;
                            $path = $nod->attr('src');
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $item['field'] = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        } else {
                            $item = null;
                        }

                        return $item;
                    case 'gen-info':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['component'] = 'gen-info';
                        $item['field'] = $nod->attr('field')?$nod->attr('field'):$nod->attr('custom-value');

                        return $item;
                    case 'inputbox':
                        $item['field'] = $nod->attr('field');
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        if($nod->attr('field') == 'time24'){
                            $item['component'] = 'date-time-input';
                        } elseif ($nod->attr('field') == 'time12') {
                            $item['component'] = 'date-time-input';
                        } else {
                            $item['component'] = 'form-input';
                        }

                        return $item;
                    case 'picture':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        if($nod->attr('field') == NULL){
                            $item['component'] = 'take-picture';
                        } else {
                            $item['component'] = $nod->attr('field');
                        }
                        if($nod->attr('edit-label') !== null){
                            $item['options']['editable'] = true;
                        } else {
                            $item['options']['editable'] = false;
                        }
                        if($nod->attr('portrait-mode') !== null){
                            $item['options']['portrait'] = true;
                        } else {
                            $item['options']['portrait'] = false;
                        }

                        return $item;
                    case 'cb-group':
                        $item['component'] = 'combo-box-condition';
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['field'] = $nod->getNode(0)->hasAttribute('display-all')?'yes':'no';
                        $options = $nod->children()->each(function ($no) {
                            if ($no->attr('field') !== null) {
                                $item = [
                                    "option" => $no->attr('label'),
                                    "condition" => true,
                                    "field" => $no->attr('field')
                                ];
                                return $item;
                            }
                            $item = [
                                "option" => $no->attr('label'),
                                "condition" => false,
                                "field" => ''
                            ];

                            return $item;
                        });
                        $item['options'] = $options;

                        return $item;
                    case 'remarks':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['component'] = $nod->attr('field') == NULL?'remarks':$nod->attr('field');

                        return $item;
                    case 'product-input':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['component'] = 'product-input';
                        $options = $nod->filter('td div[tic-input=product-option]')->each(function ($no) {
                            $item = [
                                "key" => $no->attr('id'),
                                "label" => $no->attr('label'),
                                "field" => $no->attr('field'),
                                "value" => ''
                            ];
                            return $item;
                        });
                        $item['options'] = $options;

                        return $item;
                    case 'product-description':
                        $item['key'] = $nod->attr('id');
                        $item['label'] = $nod->attr('label');
                        $item['component'] = 'product-description';

                        return $item;
                }
            });
			$items = array_values(array_filter($items,function($v){return !is_null($v);}));
            if($items && count($items) > 0)
                return ["key" => $node->attr('id'), "title" => "Additional " . ucfirst($node->attr('class')) . " Information", "data" => ["items" => $items]];
        });

        $data = array_merge(array_filter($data), array_filter($hf));

        $template = new Template();

        $html->filterXPath('//td/*[@tic-page-number]')->each(function ($node){
            $nod = $node->getNode(0);
            $nod->parentNode->setAttribute('preserve-text', 'yes');
            $nod->parentNode->removeChild($nod);
        });

        $emogrifier = new \Pelago\Emogrifier($html->html(), $request->input('css'));

        $template->name =  $request->input('name');
        $template->css =   $request->input('css');
        $template->styles = json_encode($request->input('styles'));
        $template->html = $emogrifier->emogrify();
        $template->components = json_encode($request->input('components'));
        $template->items = json_encode($data);
        $template->save();

        $response['id'] = $template->id;
        $response['name'] = $template->name;
        $response['created'] = $template->created_at->toFormattedDateString();

        return response()->json($response,200);
    }

    public function deleteTemplate($id){
        $template = Template::find($id);
        $template->delete();

        return back();
    }
	
	public function postTemplateAssets(Request $request){
	if(is_null($request->file('file')))
		return response()->json(['data' => ''],200);

		$file = $request->file('file');

		$filename = uniqid().'.'.$file[0]->getClientOriginalExtension();

		$file[0]->move('images/template/assets',$filename);

		return response()->json(['data' => 'images/template/assets/' . $filename],200);
	}

    public function getCountInspection($id){
        date_default_timezone_set("Asia/Shanghai");
        
        $year = date('Y');
        $month = date('m');
        $month_now = $year .'-'. $month;
        $Inspection = Inspection::where('client_id',$id)->where('inspection_date','LIKE',"%{$month_now}%")->get();
        $count = $Inspection->count();
        //$count++;
        return response()->json([
            'count' => $count
        ]);
    }

    public function getCountInspectionNew($id, $inspect_date){
        date_default_timezone_set("Asia/Shanghai");
        
        $year = date('Y',strtotime($inspect_date));
        $month = date('m',strtotime($inspect_date));
        $month_now = $year .'-'. $month;
        $Inspection = Inspection::where('client_id',$id)->where('inspection_date','LIKE',"%{$month_now}%")->get();
        $count = $Inspection->count();
        $new_ref_num = '';

        //$count++;
        /* $year_format = date('y',strtotime($inspect_date));
        $add_trail_zero = sprintf("%02d",$count);
        $new_ref_num = $id.'-'.$year_format.$month.'-'.$add_trail_zero;
        //remove space if any
        $new_ref_num = preg_replace('/\s+/', '', $new_ref_num); */

        //here is the code when there has inspection deleted
        if($count == 0){
            $count++;
            $year_format = date('y',strtotime($inspect_date));
            $add_trail_zero = sprintf("%02d",$count);
            $new_ref_num = $id.'-'.$year_format.$month.'-01';
            //remove space if any
            $new_ref_num = preg_replace('/\s+/', '', $new_ref_num);
        }else{
            $array_id = [];
            foreach($Inspection as $inspect){
                $explode_ref_num = explode("-", $inspect->reference_number);
                $get_num = $explode_ref_num[2];
                array_push($array_id,$get_num);
            }
            $max_id = max($array_id);
            $max_num = $max_id + 1;
            $year_format = date('y',strtotime($inspect_date));
            $add_trail_zero = sprintf("%02d",$max_num);
            $new_ref_num = $id.'-'.$year_format.$month.'-'.$add_trail_zero;
            //remove space if any
            $new_ref_num = preg_replace('/\s+/', '', $new_ref_num);
        }

        return response()->json([
            'ref_num' => $new_ref_num
        ]);
    }

    public function getClientDBCountInspection($id, $inspect_date){
        date_default_timezone_set("Asia/Shanghai");
        
        $year = date('Y',strtotime($inspect_date));
        $month = date('m',strtotime($inspect_date));
        $month_now = $year .'-'. $month;
        $Inspection = Inspection::where('client_id',$id)->where('inspection_date','LIKE',"%{$month_now}%")->get();
        $count = $Inspection->count();
        $new_ref_num = '';
        if($count == 0){
            $count++;
            $year_format = date('y',strtotime($inspect_date));
            $add_trail_zero = sprintf("%02d",$count);
            $new_ref_num = $id.'-'.$year_format.$month.'-01';
            //remove space if any
            $new_ref_num = preg_replace('/\s+/', '', $new_ref_num);
        }else{
            //need to use this code next month haha
            /* $array_id = [];
            foreach($Inspection as $inspect){
                $explode_ref_num = explode("-", $inspect->reference_number);
                $get_num = $explode_ref_num[2];
                array_push($array_id,$get_num);
            }
            $max_id = max($array_id);
            $max_num = $max_id + 1;
            $year_format = date('y',strtotime($inspect_date));
            $add_trail_zero = sprintf("%02d",$max_num);
            $new_ref_num = $id.'-'.$year_format.$month.'-'.$add_trail_zero;
            //remove space if any
            $new_ref_num = preg_replace('/\s+/', '', $new_ref_num); */

            //for the mean time code
            $count++;
            $year_format = date('y',strtotime($inspect_date));
            $add_trail_zero = sprintf("%02d",$count);
            $new_ref_num = $id.'-'.$year_format.$month.'-'.$add_trail_zero;
            //remove space if any
            $new_ref_num = preg_replace('/\s+/', '', $new_ref_num);
        }

        return response()->json([
            'ref_num' => $new_ref_num
        ]);
    }


    public function getProductByCode($id){
        $products = Product::where('client_code',$id)->where('status',0)->orderBy('product_name', 'asc')->get();
        return response()->json([
            'products' => $products
        ]);
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

        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'pus' => 'Pick Up Sample',
                    'cli' => 'Container Loading Inspection',
                    'pls' => 'Setting Up Production Lines',
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

        $inspection = Inspection::where('id',$id)->first();
        $get_service=$inspection->service;
        $inspection_details="";
        if($get_service=='site_visit' || $get_service=='physical' ){
            $inspection_details = DB::table('inspections')
            ->join('clients','clients.client_code', '=', 'inspections.client_id')
            ->join('users','inspections.inspector_id', '=', 'users.id')
            ->join('user_infos','users.id', '=', 'user_infos.user_id')
            ->join('client_contacts','inspections.contact_person', '=', 'client_contacts.id')
            ->select('inspections.*','clients.client_name','users.*','user_infos.*','user_infos.name AS inspector_name','client_contacts.*')
            ->where('inspections.id',$id)                    
            ->first();  
        }else{
            $inspection_details = DB::table('inspections')
            ->join('clients','clients.client_code', '=', 'inspections.client_id')
            ->join('users','inspections.inspector_id', '=', 'users.id')
            ->join('user_infos','users.id', '=', 'user_infos.user_id')
            ->join('client_contacts','inspections.contact_person', '=', 'client_contacts.id')
            ->join('factories','inspections.factory', '=', 'factories.id')
            ->join('fctory_contacts','inspections.factory_contact_person', '=', 'fctory_contacts.id')
            ->select('inspections.*','clients.client_name','users.*','user_infos.*','user_infos.name AS inspector_name','client_contacts.*','factories.*','fctory_contacts.*')
            ->where('inspections.id',$id)                    
            ->first();  
        }


		return view('pages.admin.trackInspection.index',compact('role','user_info','client_code','client','client_contact','user','id','services','inspection_details'));    	
    }
    public function getTrackInspectionDashboardDev($id){
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
        //$inspection = Inspection::where('client_id',$id)->first();
        //$service=$inspection->service;
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'pus' => 'Pick Up Sample',
                    'cli' => 'Container Loading Inspection',
                    'pls' => 'Setting Up Production Lines',
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

        $inspection_details = DB::table('inspections')
                    ->join('clients','clients.client_code', '=', 'inspections.client_id')
                    ->join('users','inspections.inspector_id', '=', 'users.id')
                    ->join('user_infos','users.id', '=', 'user_infos.user_id')
                    ->join('client_contacts','inspections.contact_person', '=', 'client_contacts.id')
                    ->join('factories','inspections.factory', '=', 'factories.id')
                    ->join('fctory_contacts','inspections.factory_contact_person', '=', 'fctory_contacts.id')
                    ->select('inspections.*','clients.client_name','users.*','user_infos.*','user_infos.name AS inspector_name','client_contacts.*','factories.*','fctory_contacts.*')
                    ->where('inspections.id',$id)                    
                    ->first();  

		return view('pages.admin.trackInspection.index_dev',compact('role','user_info','client_code','client','client_contact','user','id','services','inspection_details'));    	
    }
    //get Inspector FM Credentials
    public function getInspectorFMAccount($id){
       
        $fm_api = new \GuzzleHttp\Client();
        
        $request = $fm_api->get('http://localhost/web/filemanager-api');
        // Get the actual response without headers
        $response = $request->getBody();

        $fm_accounts = json_decode($response,true);

        $inspector =  $fm_accounts[$id];
        
        return response()->json([
            'username' => $inspector['user_name'],
            'password' => $inspector['password_text']
        ]);
    }
}

