<?php

namespace App\Http\Controllers;

use App\Template;
use App\Answer;
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
use App\Geolocation;

use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use PhpParser\Node\Expr\Array_;
use Session;
use Mail;
use DateTime;
use Symfony\Component\DomCrawler\Crawler;
use \PhpOffice\PhpWord\PhpWord;


class ServerSideControllerMRN extends Controller
{

    public function getDashboardPanelTest($id){            
    	$role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
    		->where('role_user.user_id',Auth::id())->first();
      
        $user_info = UserInfo::where('user_id',Auth::id())->first();
		return view('pages.admin.dashboard.index_new',compact('role','user_info'));    	
    }

    public function getClientBookingList(){  
    	$role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
    		->where('role_user.user_id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();
		return view('pages.admin.client-booking.index_new',compact('role','user_info','new_client_count','new_post_client','new_post_client_sera'));    	
    }

    public function getClientBookingListTicSera(){  
    	$role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
    		->where('role_user.user_id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        $new_post_client_sera = Inspection::where('inspection_type','tic_sera')->where('inspection_status','Client Pending')->count();
		return view('pages.admin.client-booking-ticsera.index',compact('role','user_info','new_client_count','new_post_client','new_post_client_sera'));    	
    }

    //nov 29, 2018 
    public function getInspectionsOld2(Request $request){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
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
        $created = UserInfo::where('user_id',Auth::id())->first();
        $columns = array( 
							0=> 'client',
                            1 =>'service',
                            2 =>'reference_number',
                            3 =>'product_name',
                            4=> 'po_no',
							5 =>'address',
							6=> 'inspector_name',						
                            7=> 'created_by',
                            8=> 'inspection_date',
                            9=> 'inspection_date',
                            10=> 'status',
                            11=> 'action',
                        );
        $inspect_count = Inspection::whereNull('inspections.client_book_id')->get();

        $totalData = count($inspect_count);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        if($order=='created_by'){
            $order='created.name';
        }
        $dir = $request->input('order.0.dir');
        $inspection="";
        if(empty($request->input('search.value'))){         
            $inspection = DB::table('inspections')
                    ->leftjoin('p_s_i_products', 'inspections.id', '=', 'p_s_i_products.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
                    ->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
    		        ->select(DB::raw('group_concat(p_s_i_products.product_name) AS p_name, group_concat(p_s_i_products.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client',DB::raw('CONCAT(factories.factory_city,",",factories.factory_country_name) AS address'))
                    // ->select(DB::raw('group_concat(p_s_i_products.product_name) AS p_name, group_concat(p_s_i_products.po_no) AS po, CONCAT(factories.factory_city,",",factories.factory_country_name) AS address'),'inspections.*','inspectors.name AS inspector_name',
                    // 'created.name AS created_by','clients.Company_Name AS client')
                    ->whereNull('inspections.client_book_id')                               
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy($order,$dir)
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 

            $inspection_temp = DB::table('inspections')
                    ->leftjoin('p_s_i_products AS psi', 'inspections.id', '=', 'psi.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
					->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
    		        ->select(DB::raw('group_concat(psi.product_name) AS p_name, group_concat(psi.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client',DB::raw('CONCAT(factories.factory_city,",",factories.factory_country_name) AS address'))
                    // ->select(DB::raw('group_concat(p_s_i_products.product_name) AS p_name, group_concat(p_s_i_products.po_no) AS po, CONCAT(factories.factory_city,",",factories.factory_country_name) AS address'),'inspections.*','inspectors.name AS inspector_name',
                    // 'created.name AS created_by','clients.Company_Name AS client')
                    ->whereNull('inspections.client_book_id')       
                    ->where('psi.product_name','LIKE',"%{$search}%") 
                    ->orWhere('psi.po_no','LIKE',"%{$search}%") 
                    ->orWhere('inspections.reference_number','LIKE',"%{$search}%")
                    ->orWhere('inspections.service','LIKE',"%{$search}%")
                    ->orWhere('inspections.inspection_date','LIKE',"%{$search}%")
                    ->orWhere('inspections.inspection_status','LIKE',"%{$search}%")
                    ->orWhere('inspectors.name','LIKE',"%{$search}%")
                    ->orWhere('created.name','LIKE',"%{$search}%") 
                    ->orWhere('clients.Company_Name','LIKE',"%{$search}%")                    
                    ->orWhere('factories.factory_address','LIKE',"%{$search}%")               
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy($order,$dir)            
                    ->get();
            $inspection = DB::table('inspections')
                    ->leftjoin('p_s_i_products AS psi', 'inspections.id', '=', 'psi.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
					->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
    		        ->select(DB::raw('group_concat(psi.product_name) AS p_name, group_concat(psi.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client',DB::raw('CONCAT(factories.factory_city,",",factories.factory_country_name) AS address'))
                    // ->select(DB::raw('group_concat(p_s_i_products.product_name) AS p_name, group_concat(p_s_i_products.po_no) AS po, CONCAT(factories.factory_city,",",factories.factory_country_name) AS address'),'inspections.*','inspectors.name AS inspector_name',
                    // 'created.name AS created_by','clients.Company_Name AS client')
                    ->whereNull('inspections.client_book_id')       
                    ->where('psi.product_name','LIKE',"%{$search}%") 
                    ->orWhere('psi.po_no','LIKE',"%{$search}%") 
                    ->orWhere('inspections.reference_number','LIKE',"%{$search}%")
                    ->orWhere('inspections.service','LIKE',"%{$search}%")
                    ->orWhere('inspections.inspection_date','LIKE',"%{$search}%")
                    ->orWhere('inspections.inspection_status','LIKE',"%{$search}%")
                    ->orWhere('inspectors.name','LIKE',"%{$search}%")
                    ->orWhere('created.name','LIKE',"%{$search}%") 
                    ->orWhere('clients.Company_Name','LIKE',"%{$search}%")
					->orWhere('factories.factory_address','LIKE',"%{$search}%")
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy($order,$dir)
                    ->offset($start)
                    //->limit(100) 
                    ->limit($limit)                
                    ->get();

            $totalFiltered=count($inspection_temp);
        }

        $data = array();
        if($inspection){
            foreach ($inspection as $ins){
                $show =  "";
                $edit =  "";
                $po_num='';
                $product='';
                //product
                if($ins->p_name==''){
                    $product='No Product';
                }else{
                    $product=$ins->p_name;
                }
                //po no
                if($ins->po==''){
                    $po_num='No PO';
                }else{
                    $po_num=$ins->po;
                }
                $cut_product='';        
                if($product=='No Product' || strlen($product)<15){
                    $cut_product=$product;
                }else{
                    $cut_product=substr($product,0,15)."..."; 
                }         

                $cut_po='';      
                if($po_num=='No PO' || strlen($po_num)<15){
                    $cut_po=$po_num;
                }else{
                    $cut_po=substr($po_num,0,15)."...";
                }
                   
                $ins_address='';
                if($ins->service=='site_visit'){
                    $ins_address=$ins->comp_addr;
                }else{
                    $ins_address=$ins->address;
                }
                $ins_date = date('Y-m-d',strtotime($ins->inspection_date));
                $ins_date_to = date('Y-m-d',strtotime($ins->inspection_date_to));

                $n_ins_date_from = new DateTime($ins->inspection_date);
                $n_ins_date_to = new DateTime($ins->inspection_date_to);
                $ins_diff = $n_ins_date_from->diff($n_ins_date_to); 
                $count_diff=$ins_diff->format("%a");// count days of inspection
                if($ins_date_to==''){
                    $ins_date_to=$ins_date;
                }
                //track
                $reports = Report::where('inspection_id',$ins->id)->first();
                $answers='';
                $tr_indicator=''; //tracking indicator
                if($reports){
                    $answers = Answer::select('created_at')->where('report_id',$reports->id)->first();
                    $geo = Geolocation::where('inspection_id',$ins->id)->first();
                    if($answers && $geo){
                        //if started and ended have values
                        $tr_indicator='<span><i class="fa fa-circle fa-xs text-success" style="font-size:10px;"></i></span> ';
                    }else if($answers){
                        //if ended only have value
                        $tr_indicator='<span><i class="fa fa-circle fa-xs text-danger" style="font-size:10px;"></i></span> ';
                    }else if($geo){
                        //if started only have value
                        $tr_indicator='<span><i class="fa fa-circle fa-xs text-danger" style="font-size:10px;"></i></span> ';
                    }else{
                        $tr_indicator='';
                    }
                }

                if($ins_date==$ins_date_to || $ins_date_to==''){
				    $nestedData['client'] = $tr_indicator .' '. $ins->client;
                    $nestedData['service'] = strtoupper($ins->service);
                    $nestedData['reference_number'] = $ins->reference_number;
                    $nestedData['product_name'] = "<span title='$product'>$cut_product</span>";
                    $nestedData['po_no'] = "<span title='$po_num'>$cut_po</span>";
				    $nestedData['address'] = $ins_address;
                    $nestedData['inspector_name'] = $ins->inspector_name;			
                    $nestedData['created_by'] = ucfirst($ins->created_by);    
                    $nestedData['inspection_date'] = $ins_date; 
                    $nestedData['inspection_date_to'] = $ins_date_to;      
                    $nestedData['status'] = $ins->inspection_status;
                    // $nestedData['booked_by'] = $ins->created_by;  //added by migz 05-06-21
                    if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical'){
                        $edit =  route('edit-project-cbpi',$ins->id);
                        if(!empty($ins->client_book) || $ins->client_book==true){
                            $edit =  route('release-client-order-loading',$ins->id);
                        }
                        $show='btn_view_project_cbpi';
                        $copy = route('copy-project-cbpi-admin',$ins->id);
                    }else if($ins->service=='site_visit'){
                        $edit =  route('edit-project-site',$ins->id);
                        if(!empty($ins->client_book) || $ins->client_book==true){
                            $edit =  route('release-client-order',$ins->id);
                        }
                        $show='btn_view_project_site';
                        $copy = route('copy-project-site-admin',$ins->id);

                    }else{
                        $edit =  route('edit-project',$ins->id);
                        if(!empty($ins->client_book) || $ins->client_book==true){
                            $edit =  route('release-client-order',$ins->id);
                        }
                        $show='btn_view_project';
                        $copy = route('copy-project-admin',$ins->id);
                    }
                    $btn_disable='';
                    if($ins->inspection_status=='Pending' || $ins->inspection_status=='Cancelled'){
                        $btn_disable='disabled';
                    }
				    $tracking = route('track-inspections',$ins->id);
                        if($ins->mrn_no != ""){
                            $edit_mrn = route('edit-project-mrn',$ins->id); 
                            $nestedData['action'] = " <div class='dropdown'>
                            <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                                <span class='caret'></span></button>
                            <ul class='dropdown-menu'>
                                <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                                <li><a href='{$edit_mrn}' title='Edit Multiple Report Project' $btn_disable>Edit Multiple</li>
                                <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                                <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                                <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                            </ul>
                            </div>";    

                            $data[] = $nestedData;
                            }else{
                                $nestedData['action'] = " <div class='dropdown'>
                                <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                                    <span class='caret'></span></button>
                                <ul class='dropdown-menu'>
                                    <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                                    <li><a href='{$edit}' title='Edit Project Details'>Edit</li>
                                    <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                                    <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                                    <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                                </ul>
                                </div>";    

                                $data[] = $nestedData;
                            } 
                }else{
                    for($i=0; $i<=$count_diff; $i++){
                        $inspec_date=$ins_date;
                        if($i!=0){
                            $inspec_date = date('Y-m-d', strtotime($ins_date.' + '.$i.' days'));
                        }
                        $nestedData['client'] = $tr_indicator .' '. $ins->client;
                        $nestedData['service'] = strtoupper($ins->service);
                        $nestedData['reference_number'] = $ins->reference_number;
                        $nestedData['product_name'] = "<span title='$product'>$cut_product</span>";
                        $nestedData['po_no'] = "<span title='$po_num'>$cut_po</span>";
				        $nestedData['address'] = $ins_address;
                        $nestedData['inspector_name'] = $ins->inspector_name;			
                        $nestedData['created_by'] = ucfirst($ins->created_by);    
                        $nestedData['inspection_date'] = $inspec_date; 
                        $nestedData['inspection_date_to'] = $ins_date_to;      
                        $nestedData['status'] = $ins->inspection_status;
                        // $nestedData['booked_by'] = $ins->created_by;  //added by migz 05-06-21
                        if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical'){
                            $edit =  route('edit-project-cbpi',$ins->id);
                            $show='btn_view_project_cbpi';
                            $copy = route('copy-project-cbpi-admin',$ins->id);
                        }else if($ins->service=='site_visit'){
                            $edit =  route('edit-project-site',$ins->id);
                            $show='btn_view_project_site';
                            $copy = route('copy-project-site-admin',$ins->id);
                        }else{
                            $edit =  route('edit-project',$ins->id);
                            $show='btn_view_project';
                            $copy = route('copy-project-admin',$ins->id);
                        }
                        $btn_disable='';
                        if($ins->inspection_status=='Pending' || $ins->inspection_status=='Cancelled'){
                            $btn_disable='disabled';
                        }
				        $tracking = route('track-inspections',$ins->id);
                        $nestedData['action'] = " <div class='dropdown'>
                        <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                            <span class='caret'></span></button>
                        <ul class='dropdown-menu'>
                            <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                            <li><a href='{$edit}' title='Edit Project Details'>Edit</li>
                            <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                            <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                            <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                        </ul>
                        </div>";    

                        $data[] = $nestedData;
                        //$totalFiltered++;
                    }
                }
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }
    //Dec 10, 2018 
    public function getInspectionsOld3(Request $request){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
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
        $created = UserInfo::where('user_id',Auth::id())->first();
        $columns = array( 
							0=> 'client',
                            1 =>'service',
                            2 =>'project_no',
                            3 =>'product_name',
                            4=> 'po_no',
							5 =>'address',
							6=> 'inspector_name',						
                            7=> 'created_by',
                            8=> 'inspection_date',
                            9=> 'inspection_date',
                            10=> 'status',
                            11=> 'action',
                        );
        $inspect_count = Inspection::whereNull('inspections.client_book_id')->get();

        $totalData = count($inspect_count);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        if($order=='created_by'){
            $order='created.name';
        }
        $dir = $request->input('order.0.dir');
        $inspection="";
        if(empty($request->input('search.value'))){         
            $inspection = DB::table('inspections')
                    ->leftjoin('p_s_i_products', 'inspections.id', '=', 'p_s_i_products.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
                    ->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
    		        ->select(DB::raw('group_concat(p_s_i_products.product_name) AS p_name, group_concat(p_s_i_products.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client','factories.factory_address AS address')
                    ->whereNull('inspections.client_book_id')                               
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy($order,$dir)
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 

            $inspection_temp = DB::table('inspections')
                    ->leftjoin('p_s_i_products AS psi', 'inspections.id', '=', 'psi.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
					->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
    		        ->select(DB::raw('group_concat(psi.product_name) AS p_name, group_concat(psi.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client','factories.factory_address AS address')
                    ->whereNull('inspections.client_book_id')       
                    ->where('psi.product_name','LIKE',"%{$search}%") 
                    ->orWhere('psi.po_no','LIKE',"%{$search}%") 
                    ->orWhere('inspections.reference_number','LIKE',"%{$search}%")
                    ->orWhere('inspections.service','LIKE',"%{$search}%")
                    ->orWhere('inspectors.name','LIKE',"%{$search}%")
                    ->orWhere('created.name','LIKE',"%{$search}%") 
                    ->orWhere('clients.Company_Name','LIKE',"%{$search}%")                    
                    ->orWhere('factories.factory_address','LIKE',"%{$search}%")               
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy($order,$dir)            
                    ->get();
            $inspection = DB::table('inspections')
                    ->leftjoin('p_s_i_products AS psi', 'inspections.id', '=', 'psi.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
					->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
    		        ->select(DB::raw('group_concat(psi.product_name) AS p_name, group_concat(psi.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client','factories.factory_address AS address')
                    ->whereNull('inspections.client_book_id')       
                    ->where('psi.product_name','LIKE',"%{$search}%") 
                    ->orWhere('psi.po_no','LIKE',"%{$search}%") 
                    ->orWhere('inspections.reference_number','LIKE',"%{$search}%")
                    ->orWhere('inspections.service','LIKE',"%{$search}%")
                    ->orWhere('inspectors.name','LIKE',"%{$search}%")
                    ->orWhere('created.name','LIKE',"%{$search}%") 
                    ->orWhere('clients.Company_Name','LIKE',"%{$search}%")
					->orWhere('factories.factory_address','LIKE',"%{$search}%")
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy($order,$dir)
                    ->offset($start)
                    ->limit(10)                
                    ->get();

            $totalFiltered=count($inspection_temp);
        }

        $data = array();
        if($inspection){
            foreach ($inspection as $ins){
                $show =  "";
                $edit =  "";
                $po_num='';
                $product='';
                //product
                if($ins->p_name==''){
                    $product='No Product';
                }else{
                    $product=$ins->p_name;
                }
                //po no
                if($ins->po==''){
                    $po_num='No PO';
                }else{
                    $po_num=$ins->po;
                }
                $cut_product='';        
                if($product=='No Product' || strlen($product)<15){
                    $cut_product=$product;
                }else{
                    $cut_product=substr($product,0,15)."..."; 
                }         

                $cut_po='';      
                if($po_num=='No PO' || strlen($po_num)<15){
                    $cut_po=$po_num;
                }else{
                    $cut_po=substr($po_num,0,15)."...";
                }
                   
                $ins_address='';
                if($ins->service=='site_visit'){
                    $ins_address=$ins->comp_addr;
                }else{
                    $ins_address=$ins->address;
                }
                $ins_date = date('Y-m-d',strtotime($ins->inspection_date));
                $ins_date_to = date('Y-m-d',strtotime($ins->inspection_date_to));

                $n_ins_date_from = new DateTime($ins->inspection_date);
                $n_ins_date_to = new DateTime($ins->inspection_date_to);
                $ins_diff = $n_ins_date_from->diff($n_ins_date_to); 
                $count_diff=$ins_diff->format("%a");// count days of inspection

                if($ins_date_to==''){
                    $ins_date_to=$ins_date;
                }
                if($ins_date==$ins_date_to || $ins_date_to==''){
				    $nestedData['client'] = $ins->client;
                    $nestedData['service'] = strtoupper($ins->service);
                    $nestedData['project_no'] = $ins->reference_number;
                    $nestedData['product_name'] = "<span title='$product'>$cut_product</span>";
                    $nestedData['po_no'] = "<span title='$po_num'>$cut_po</span>";
				    $nestedData['address'] = $ins_address;
                    $nestedData['inspector_name'] = $ins->inspector_name;			
                    $nestedData['created_by'] = ucfirst($ins->created_by);    
                    $nestedData['inspection_date'] = $ins_date; 
                    $nestedData['inspection_date_to'] = $ins_date_to;      
                    $nestedData['status'] = $ins->inspection_status;
                    if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce'){
                        $edit =  route('edit-project-cbpi',$ins->id);
                        $show='btn_view_project_cbpi';                     
                        $copy = route('copy-project-cbpi-admin',$ins->id);
                    }else if($ins->service=='site_visit'){
                        $edit =  route('edit-project-site',$ins->id);
                        $show='btn_view_project_site';
                        $copy = route('copy-project-site-admin',$ins->id);
                    }else{
                        $edit =  route('edit-project',$ins->id);
                        $show='btn_view_project';                       
                        $copy = route('copy-project-admin',$ins->id);
                    }
                    $btn_disable='';
                    if($ins->inspection_status=='Pending' || $ins->inspection_status=='Cancelled'){
                        $btn_disable='disabled';
                    }
				    $tracking = route('track-inspections',$ins->id);
                    $nestedData['action'] = " <div class='dropdown'>
                    <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                        <span class='caret'></span></button>
                    <ul class='dropdown-menu'>
                        <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                        <li><a href='{$edit}' title='Edit Project Details'>Edit</li>
                        <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                        <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                        <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                    </ul>
                    </div>";    

                    $data[] = $nestedData;
                }else{
                    for($i=0; $i<=$count_diff; $i++){
                        $inspec_date=$ins_date;
                        if($i!=0){
                            $inspec_date = date('Y-m-d', strtotime($ins_date.' + '.$i.' days'));
                        }
                        $nestedData['client'] = $ins->client;
                        $nestedData['service'] = strtoupper($ins->service);
                        $nestedData['project_no'] = $ins->reference_number;
                        $nestedData['product_name'] = "<span title='$product'>$cut_product</span>";
                        $nestedData['po_no'] = "<span title='$po_num'>$cut_po</span>";
				        $nestedData['address'] = $ins_address;
                        $nestedData['inspector_name'] = $ins->inspector_name;			
                        $nestedData['created_by'] = ucfirst($ins->created_by);    
                        $nestedData['inspection_date'] = $inspec_date; 
                        $nestedData['inspection_date_to'] = $ins_date_to;      
                        $nestedData['status'] = $ins->inspection_status;
                        if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce'){
                            $edit =  route('edit-project-cbpi',$ins->id);
                            $show='btn_view_project_cbpi';
                            $copy = route('copy-project-cbpi-admin',$ins->id);
                        }else if($ins->service=='site_visit'){
                            $edit =  route('edit-project-site',$ins->id);
                            $show='btn_view_project_site';                    
                            $copy = route('copy-project-site-admin',$ins->id);
                        }else{
                            $edit =  route('edit-project',$ins->id);
                            $show='btn_view_project';                          
                            $copy = route('copy-project-admin',$ins->id);
                        }
                        $btn_disable='';
                        if($ins->inspection_status=='Pending' || $ins->inspection_status=='Cancelled'){
                            $btn_disable='disabled';
                        }
				        $tracking = route('track-inspections',$ins->id);
                        $nestedData['action'] = " <div class='dropdown'>
                        <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                            <span class='caret'></span></button>
                        <ul class='dropdown-menu'>
                            <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                            <li><a href='{$edit}' title='Edit Project Details'>Edit</li>
                            <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                            <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                            <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                        </ul>
                        </div>";    

                        $data[] = $nestedData;
                        //$totalFiltered++;
                    }
                }
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }
    //Dec 10, 2018 
    public function getInspections(Request $request){
        
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
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
        $created = UserInfo::where('user_id',Auth::id())->first();
        $columns = array( 
							0=> 'client',
                            1 =>'service',
                            2 =>'reference_number',
                            3 =>'p_name',
                            4=> 'po',
							5 =>'address',
							6=> 'inspector_name',						
                            7=> 'created_by',
                            8=> 'inspection_date',
                            // 9=> 'booked_by',
                            9=> 'status',
                            10=> 'action',
                        );
        $inspect_count = DB::table('all_inspections')->count();

        $totalData = $inspect_count;       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        if($order=='created_by'){
            $order='user_created_by';
        }
        $dir = $request->input('order.0.dir');
        $inspection="";
        if(empty($request->input('search.value'))){     
            $inspection = DB::table('all_inspections')    
                    ->orderBy($order,$dir)
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
                    /* ->where('inspection_status',"Released")     
                    ->orWhere('inspection_status',"Pending")
                    ->orWhere('inspection_status',"Shipment Accepted")
                    ->orWhere('inspection_status',"Hold")
                    ->orWhere('inspection_status',"Shipment Rejected")
                    ->orWhere('inspection_status',"Cancelled")
                    ->orWhere('inspection_status',"Report Released") */
            //->where('inspection_status','!=',"Client Pending")   
        }else{
            $search = $request->input('search.value');
            $length = $request->input('length');

            $inspection_temp = DB::table('all_inspections')
                    ->where('p_name','LIKE',"%{$search}%") 
                    ->orWhere('po','LIKE',"%{$search}%") 
                    ->orWhere('reference_number','LIKE',"%{$search}%")
                    ->orWhere('service','LIKE',"%{$search}%")
                    ->orWhere('inspector_name','LIKE',"%{$search}%")
                    ->orWhere('user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('client','LIKE',"%{$search}%")                    
                    ->orWhere('address','LIKE',"%{$search}%")  
                    ->orWhere('inspection_date','LIKE',"%{$search}%")    
                    ->orWhere('inspection_status','LIKE',"%{$search}%")                      
                    ->orderBy($order,$dir)            
                    ->get();
            $inspection = DB::table('all_inspections')
                    ->where('p_name','LIKE',"%{$search}%") 
                    ->orWhere('po','LIKE',"%{$search}%") 
                    ->orWhere('reference_number','LIKE',"%{$search}%")
                    ->orWhere('service','LIKE',"%{$search}%")
                    ->orWhere('inspector_name','LIKE',"%{$search}%")
                    ->orWhere('user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('client','LIKE',"%{$search}%")                    
                    ->orWhere('address','LIKE',"%{$search}%")
                    ->orWhere('inspection_date','LIKE',"%{$search}%")    
                    ->orWhere('inspection_status','LIKE',"%{$search}%")          
                    ->orderBy($order,$dir)
                    ->offset($start)
                    ->limit($limit)          
                    ->get();

            $totalFiltered=count($inspection_temp);
        }

        $data = array();
        if($inspection){
            foreach ($inspection as $ins){
                $show =  "";
                $edit =  "";
                $po_num='';
                $product='';
                //product
                if($ins->p_name==''){
                    $product='No Product';
                }else{
                    $product=$ins->p_name;
                }
                //po no
                if($ins->po==''){
                    $po_num='No PO';
                }else{
                    $po_num=$ins->po;
                }
                $cut_product='';        
                if($product=='No Product' || strlen($product)<15){
                    $cut_product=$product;
                }else{
                    $cut_product=substr($product,0,15)."..."; 
                }         

                $cut_po='';      
                if($po_num=='No PO' || strlen($po_num)<15){
                    $cut_po=$po_num;
                }else{
                    $cut_po=substr($po_num,0,15)."...";
                }
                   
                $ins_address='';
                if($ins->service=='site_visit'){
                    $ins_address=$ins->comp_addr;
                }else{
                    $ins_address=$ins->address;
                }
                $ins_date = date('Y-m-d',strtotime($ins->inspection_date));
                $ins_date_to = date('Y-m-d',strtotime($ins->inspection_date_to));

                $n_ins_date_from = new DateTime($ins->inspection_date);
                $n_ins_date_to = new DateTime($ins->inspection_date_to);
                $ins_diff = $n_ins_date_from->diff($n_ins_date_to); 
                $count_diff=$ins_diff->format("%a");// count days of inspection
                if($ins_date_to==''){
                    $ins_date_to=$ins_date;
                }
                //track
                $reports = Report::where('inspection_id',$ins->id)->first();
                $answers='';
                $tr_indicator=''; //tracking indicator
                if($reports){
                    $answers = Answer::select('created_at')->where('report_id',$reports->id)->first();
                    $geo = Geolocation::where('inspection_id',$ins->id)->first();
                    if($answers && $geo){
                        //if started and ended have values
                        $tr_indicator='<span><i class="fa fa-circle fa-xs text-success" style="font-size:10px;"></i></span> ';
                    }else if($answers){
                        //if ended only have value
                        $tr_indicator='<span><i class="fa fa-circle fa-xs text-danger" style="font-size:10px;"></i></span> ';
                    }else if($geo){
                        //if started only have value
                        $tr_indicator='<span><i class="fa fa-circle fa-xs text-danger" style="font-size:10px;"></i></span> ';
                    }else{
                        $tr_indicator='';
                    }
                }

                if($ins_date==$ins_date_to || $ins_date_to==''){
				    $nestedData['client'] = $tr_indicator .' '. $ins->client;
                    $nestedData['service'] = strtoupper($ins->service);
                    $nestedData['reference_number'] = $ins->reference_number;
                    $nestedData['p_name'] = "<span title='$product'>$cut_product</span>";
                    $nestedData['po'] = "<span title='$po_num'>$cut_po</span>";
				    $nestedData['address'] = $ins_address;
                    $nestedData['inspector_name'] = $ins->inspector_name;			
                    $nestedData['created_by'] = ucfirst($ins->user_created_by);    
                    $nestedData['inspection_date'] = $ins_date; 
                    $nestedData['inspection_date_to'] = $ins_date_to;      
                    $nestedData['status'] = $ins->inspection_status;
                    if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical'){
                        $edit =  route('edit-project-cbpi',$ins->id);
                        if(!empty($ins->client_book) || $ins->client_book==true){
                            $edit =  route('release-client-order-loading',$ins->id);
                        }
                        $show='btn_view_project_cbpi';
                        $copy = route('copy-project-cbpi-admin',$ins->id);
                    }else if($ins->service=='site_visit'){
                        $edit =  route('edit-project-site',$ins->id);
                        if(!empty($ins->client_book) || $ins->client_book==true){
                            $edit =  route('release-client-order',$ins->id);
                        }
                        $show='btn_view_project_site';
                        $copy = route('copy-project-site-admin',$ins->id);

                    }else{
                        $edit =  route('edit-project',$ins->id);
                        if(!empty($ins->client_book) || $ins->client_book==true){
                            $edit =  route('release-client-order',$ins->id);
                        }
                        $show='btn_view_project';
                        $copy = route('copy-project-admin',$ins->id);
                    }
                    $btn_disable='';
                    if($ins->inspection_status=='Pending' || $ins->inspection_status=='Cancelled'){
                        $btn_disable='disabled';
                    }
				    $tracking = route('track-inspections',$ins->id);
                    $nestedData['action'] = " <div class='dropdown'>
                    <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                        <span class='caret'></span></button>
                    <ul class='dropdown-menu'>
                        <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                        <li><a href='{$edit}' title='Edit Project Details'>Edit</li>
                        <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                        <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                        <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                    </ul>
                    </div>";    

                    $data[] = $nestedData;
                }else{
                    for($i=0; $i<=$count_diff; $i++){
                        $inspec_date=$ins_date;
                        if($i!=0){
                            $inspec_date = date('Y-m-d', strtotime($ins_date.' + '.$i.' days'));
                        }
                        $nestedData['client'] = $tr_indicator .' '. $ins->client;
                        $nestedData['service'] = strtoupper($ins->service);
                        $nestedData['reference_number'] = $ins->reference_number;
                        $nestedData['p_name'] = "<span title='$product'>$cut_product</span>";
                        $nestedData['po'] = "<span title='$po_num'>$cut_po</span>";
				        $nestedData['address'] = $ins_address;
                        $nestedData['inspector_name'] = $ins->inspector_name;			
                        $nestedData['created_by'] = ucfirst($ins->user_created_by);    
                        $nestedData['inspection_date'] = $inspec_date; 
                        $nestedData['inspection_date_to'] = $ins_date_to;      
                        $nestedData['status'] = $ins->inspection_status;
                        if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical'){
                            $edit =  route('edit-project-cbpi',$ins->id);
                            $show='btn_view_project_cbpi';
                            $copy = route('copy-project-cbpi-admin',$ins->id);
                        }else if($ins->service=='site_visit'){
                            $edit =  route('edit-project-site',$ins->id);
                            $show='btn_view_project_site';
                            $copy = route('copy-project-site-admin',$ins->id);
                        }else{
                            $edit =  route('edit-project',$ins->id);
                            $show='btn_view_project';
                            $copy = route('copy-project-admin',$ins->id);
                        }
                        $btn_disable='';
                        if($ins->inspection_status=='Pending' || $ins->inspection_status=='Cancelled'){
                            $btn_disable='disabled';
                        }
				        $tracking = route('track-inspections',$ins->id);
                        $nestedData['action'] = " <div class='dropdown'>
                        <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                            <span class='caret'></span></button>
                        <ul class='dropdown-menu'>
                            <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                            <li><a href='{$edit}' title='Edit Project Details'>Edit</li>
                            <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                            <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                            <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                        </ul>
                        </div>";    

                        $data[] = $nestedData;
                        //$totalFiltered++;
                    }
                }
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }
    // for MRN 06-09-2021
    public function getInspectionsMRN(Request $request){
        
        $services = ['iqi'=>'Incoming Quality Inspection', 
        'dupro' => 'During Production Inspection',
        'psi' => 'Pre Shipment Inspection',
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
        $created = UserInfo::where('user_id',Auth::id())->first();
        $columns = array( 
                        0=> 'client',
                        1 =>'service',
                        2 =>'reference_number',
                        3 =>'product_name',
                        4=> 'po_no',
                        5 =>'address',
                        6=> 'inspector_name',						
                        7=> 'created_by',
                        8=> 'inspection_date',
                        9=> 'inspection_date',
                        10=> 'status',
                        11=> 'action',
                    );
        // $inspect_count = Inspection::->get();
        $inspect_count = DB::table('inspections')->get();

        $totalData = count($inspect_count);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        if($order=='created_by'){
        $order='created.name';
        }
        $dir = $request->input('order.0.dir');
        $inspection="";
        if(empty($request->input('search.value'))){         
        $inspection = DB::table('inspections')
                ->leftjoin('p_s_i_products', 'inspections.id', '=', 'p_s_i_products.inspection_id')
                ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
                ->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
                ->select(DB::raw('group_concat(p_s_i_products.product_name) AS p_name, group_concat(p_s_i_products.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client',DB::raw('CONCAT(factories.factory_city,",",factories.factory_country_name) AS address'))                              
                ->groupBy(DB::raw('inspections.id'))               
                ->orderBy($order,$dir)
                ->offset($start)
                ->limit($limit)                
                ->get();
        }else{
        $search = $request->input('search.value'); 

        $inspection_temp = DB::table('inspections')
                ->leftjoin('p_s_i_products AS psi', 'inspections.id', '=', 'psi.inspection_id')
                ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
                ->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
                ->select(DB::raw('group_concat(psi.product_name) AS p_name, group_concat(psi.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client',DB::raw('CONCAT(factories.factory_city,",",factories.factory_country_name) AS address'))       
                ->where('psi.product_name','LIKE',"%{$search}%") 
                ->orWhere('psi.po_no','LIKE',"%{$search}%") 
                ->orWhere('inspections.reference_number','LIKE',"%{$search}%")
                ->orWhere('inspections.service','LIKE',"%{$search}%")
                ->orWhere('inspections.inspection_date','LIKE',"%{$search}%")
                ->orWhere('inspections.inspection_status','LIKE',"%{$search}%")
                ->orWhere('inspectors.name','LIKE',"%{$search}%")
                ->orWhere('created.name','LIKE',"%{$search}%") 
                ->orWhere('clients.Company_Name','LIKE',"%{$search}%")                    
                ->orWhere('factories.factory_address','LIKE',"%{$search}%")               
                ->groupBy(DB::raw('inspections.id'))               
                ->orderBy($order,$dir)            
                ->get();
        $inspection = DB::table('inspections')
                ->leftjoin('p_s_i_products AS psi', 'inspections.id', '=', 'psi.inspection_id')
                ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
                ->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
                ->select(DB::raw('group_concat(psi.product_name) AS p_name, group_concat(psi.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client',DB::raw('CONCAT(factories.factory_city,",",factories.factory_country_name) AS address'))       
                ->where('psi.product_name','LIKE',"%{$search}%") 
                ->orWhere('psi.po_no','LIKE',"%{$search}%") 
                ->orWhere('inspections.reference_number','LIKE',"%{$search}%")
                ->orWhere('inspections.service','LIKE',"%{$search}%")
                ->orWhere('inspections.inspection_date','LIKE',"%{$search}%")
                ->orWhere('inspections.inspection_status','LIKE',"%{$search}%")
                ->orWhere('inspectors.name','LIKE',"%{$search}%")
                ->orWhere('created.name','LIKE',"%{$search}%") 
                ->orWhere('clients.Company_Name','LIKE',"%{$search}%")
                ->orWhere('factories.factory_address','LIKE',"%{$search}%")
                ->groupBy(DB::raw('inspections.id'))               
                ->orderBy($order,$dir)
                ->offset($start)
                ->limit($limit)                
                ->get();

        $totalFiltered=count($inspection_temp);
        }

        $data = array();
        if($inspection){
        foreach ($inspection as $ins){
            $show =  "";
            $edit =  "";
            $po_num='';
            $product='';
            //product
            if($ins->p_name==''){
                $product='No Product';
            }else{
                $product=$ins->p_name;
            }
            //po no
            if($ins->po==''){
                $po_num='No PO';
            }else{
                $po_num=$ins->po;
            }
            $cut_product='';        
            if($product=='No Product' || strlen($product)<15){
                $cut_product=$product;
            }else{
                $cut_product=substr($product,0,15)."..."; 
            }         

            $cut_po='';      
            if($po_num=='No PO' || strlen($po_num)<15){
                $cut_po=$po_num;
            }else{
                $cut_po=substr($po_num,0,15)."...";
            }
            
            $ins_address='';
            if($ins->service=='site_visit'){
                $ins_address=$ins->comp_addr;
            }else{
                $ins_address=$ins->address;
            }
            $ins_date = date('Y-m-d',strtotime($ins->inspection_date));
            $ins_date_to = date('Y-m-d',strtotime($ins->inspection_date_to));

            $n_ins_date_from = new DateTime($ins->inspection_date);
            $n_ins_date_to = new DateTime($ins->inspection_date_to);
            $ins_diff = $n_ins_date_from->diff($n_ins_date_to); 
            $count_diff=$ins_diff->format("%a");// count days of inspection
            if($ins_date_to==''){
                $ins_date_to=$ins_date;
            }
            //track
            $reports = Report::where('inspection_id',$ins->id)->first();
            $answers='';
            $tr_indicator=''; //tracking indicator
            if($reports){
                $answers = Answer::select('created_at')->where('report_id',$reports->id)->first();
                $geo = Geolocation::where('inspection_id',$ins->id)->first();
                if($answers && $geo){
                    //if started and ended have values
                    $tr_indicator='<span><i class="fa fa-circle fa-xs text-success" style="font-size:10px;"></i></span> ';
                }else if($answers){
                    //if ended only have value
                    $tr_indicator='<span><i class="fa fa-circle fa-xs text-danger" style="font-size:10px;"></i></span> ';
                }else if($geo){
                    //if started only have value
                    $tr_indicator='<span><i class="fa fa-circle fa-xs text-danger" style="font-size:10px;"></i></span> ';
                }else{
                    $tr_indicator='';
                }
            }

            if($ins_date==$ins_date_to || $ins_date_to==''){
                $nestedData['client'] = $tr_indicator .' '. $ins->client;
                $nestedData['service'] = strtoupper($ins->service);
                $nestedData['reference_number'] = $ins->reference_number;
                $nestedData['product_name'] = "<span title='$product'>$cut_product</span>";
                $nestedData['po_no'] = "<span title='$po_num'>$cut_po</span>";
                $nestedData['address'] = $ins_address;
                $nestedData['inspector_name'] = $ins->inspector_name;			
                $nestedData['created_by'] = ucfirst($ins->created_by);    
                $nestedData['inspection_date'] = $ins_date; 
                $nestedData['inspection_date_to'] = $ins_date_to;      
                $nestedData['status'] = $ins->inspection_status;
                // $nestedData['booked_by'] = $ins->created_by;  //added by migz 05-06-21
                if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical'){
                    $edit =  route('edit-project-cbpi',$ins->id);
                    if(!empty($ins->client_book) || $ins->client_book==true){
                        $edit =  route('release-client-order-loading',$ins->id);
                    }
                    $show='btn_view_project_cbpi';
                    $copy = route('copy-project-cbpi-admin',$ins->id);
                }else if($ins->service=='site_visit'){
                    $edit =  route('edit-project-site',$ins->id);
                    if(!empty($ins->client_book) || $ins->client_book==true){
                        $edit =  route('release-client-order',$ins->id);
                    }
                    $show='btn_view_project_site';
                    $copy = route('copy-project-site-admin',$ins->id);

                }else{
                    $edit =  route('edit-project',$ins->id);
                    if(!empty($ins->client_book) || $ins->client_book==true){
                        $edit =  route('release-client-order',$ins->id);
                    }
                    $show='btn_view_project';
                    $copy = route('copy-project-admin',$ins->id);
                }
                $btn_disable='';
                if($ins->inspection_status=='Pending' || $ins->inspection_status=='Cancelled'){
                    $btn_disable='disabled';
                }
                $tracking = route('track-inspections',$ins->id);
                    if($ins->mrn_no != ""){
                        if(!empty($ins->client_book) || $ins->client_book==true){
                            $edit_mrn =  route('release-client-order-mrn',$ins->id);
                        }else{
                            $edit_mrn = route('edit-project-mrn',$ins->id);
                        }
                         
                        $nestedData['action'] = " <div class='dropdown'>
                        <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                            <span class='caret'></span></button>
                        <ul class='dropdown-menu'>
                            <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                            <li><a href='{$edit_mrn}' title='Edit Multiple Report Project' $btn_disable>Edit Multiple</li>
                            <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                            <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                            <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                        </ul>
                        </div>";    

                        $data[] = $nestedData;
                        }else{
                            $nestedData['action'] = " <div class='dropdown'>
                            <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                                <span class='caret'></span></button>
                            <ul class='dropdown-menu'>
                                <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                                <li><a href='{$edit}' title='Edit Project Details'>Edit</li>
                                <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                                <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                                <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                            </ul>
                            </div>";    

                            $data[] = $nestedData;
                        } 
            }else{
                for($i=0; $i<=$count_diff; $i++){
                    $inspec_date=$ins_date;
                    if($i!=0){
                        $inspec_date = date('Y-m-d', strtotime($ins_date.' + '.$i.' days'));
                    }
                    $nestedData['client'] = $tr_indicator .' '. $ins->client;
                    $nestedData['service'] = strtoupper($ins->service);
                    $nestedData['reference_number'] = $ins->reference_number;
                    $nestedData['product_name'] = "<span title='$product'>$cut_product</span>";
                    $nestedData['po_no'] = "<span title='$po_num'>$cut_po</span>";
                    $nestedData['address'] = $ins_address;
                    $nestedData['inspector_name'] = $ins->inspector_name;			
                    $nestedData['created_by'] = ucfirst($ins->created_by);    
                    $nestedData['inspection_date'] = $inspec_date; 
                    $nestedData['inspection_date_to'] = $ins_date_to;      
                    $nestedData['status'] = $ins->inspection_status;
                    // $nestedData['booked_by'] = $ins->created_by;  //added by migz 05-06-21
                    if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical'){
                        $edit =  route('edit-project-cbpi',$ins->id);
                        $show='btn_view_project_cbpi';
                        $copy = route('copy-project-cbpi-admin',$ins->id);
                    }else if($ins->service=='site_visit'){
                        $edit =  route('edit-project-site',$ins->id);
                        $show='btn_view_project_site';
                        $copy = route('copy-project-site-admin',$ins->id);
                    }else{
                        $edit =  route('edit-project',$ins->id);
                        $show='btn_view_project';
                        $copy = route('copy-project-admin',$ins->id);
                    }
                    $btn_disable='';
                    if($ins->inspection_status=='Pending' || $ins->inspection_status=='Cancelled'){
                        $btn_disable='disabled';
                    }
                    $tracking = route('track-inspections',$ins->id);
                    $nestedData['action'] = " <div class='dropdown'>
                    <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                        <span class='caret'></span></button>
                    <ul class='dropdown-menu'>
                        <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View </li>
                        <li><a href='{$edit}' title='Edit Project Details'>Edit</li>
                        <li><a href='{$copy}' title='Copy Project Details'>Copy</li>
                        <li><a href='{$tracking}'  title='Track Project'>Track</a></li>
                        <li><a data-id='{$ins->id}' class='cancel-inspec' title='Cancel Inspection' $btn_disable>Cancel</a></li>
                    </ul>
                    </div>";    

                    $data[] = $nestedData;
                    //$totalFiltered++;
                }
            }
        }
        }

        $json_data = array(
                "draw"            => intval($request->input('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
                );

        echo json_encode($json_data); 
        
    }

    public function getInspectionsDev(){
        $inspection = DB::table('inspections')
                    ->leftjoin('p_s_i_products', 'inspections.id', '=', 'p_s_i_products.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
                    ->leftjoin('factories', 'inspections.factory', '=', 'factories.id')
    		        ->select(DB::raw('group_concat(p_s_i_products.product_name) AS p_name, group_concat(p_s_i_products.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client','factories.factory_address AS address')
                    ->whereNull('inspections.client_book_id')                               
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy('inspections.created_at','DESC')
                    ->get();
        return response()->json([
            'inspection' => $inspection,
        ]);
    }


    public function getClientInspectionsOld(Request $request){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
                    'cli' => 'Container Loading Inspection',
                    'pls' => 'Setting Up Production Lines',
                    'st' => 'Sample Test',
                    'cbpi' => 'CBPI - No Serial',
                    'cbpi_serial' => 'CBPI - with Serial',
                    'cbpi_isce' => 'CBPI - ISCE',
                    'site_visit' => 'Site Visit',
                    'physical' => 'Factory Audit',
                    'SPK' => 'SPK',
                    'FRI' => 'FRI',
                    
                ];
        $created = UserInfo::where('user_id',Auth::id())->first();
        $columns = array( 
                            0=> 'inspector',
                            1=> 'client',
                            2=> 'user',
                            3 =>'service', 
                            4 =>'product',
                            5=> 'po_no',
                            6=> 'inspection_date',
                            7=> 'created_at',
                            8=> 'status',
                            9=> 'action',
                        );
        $inspect_count = Inspection::whereNotNull('inspections.client_book_id')->get();

        $totalData = count($inspect_count);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $inspection="";
        if(empty($request->input('search.value'))){         
            $inspection = DB::table('inspections')
                    ->leftjoin('p_s_i_products', 'inspections.id', '=', 'p_s_i_products.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
    		        ->select(DB::raw('group_concat(p_s_i_products.product_name) AS p_name, group_concat(p_s_i_products.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client')
                    ->whereNotNull('inspections.client_book_id')                               
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy('inspections.created_at', 'desc')
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 

            $inspection_temp = DB::table('inspections')
                    ->leftjoin('p_s_i_products AS psi', 'inspections.id', '=', 'psi.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
    		        ->select(DB::raw('group_concat(psi.product_name) AS p_name, group_concat(psi.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client')
                    ->whereNotNull('inspections.client_book_id')       
                    ->where('psi.product_name','LIKE',"%{$search}%") 
                    ->orWhere('psi.po_no','LIKE',"%{$search}%") 
                    ->orWhere('inspectors.name','LIKE',"%{$search}%")
                    ->orWhere('created.name','LIKE',"%{$search}%") 
                    ->orWhere('clients.Company_Name','LIKE',"%{$search}%")                      
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy('inspections.created_at', 'desc')            
                    ->get();
            $inspection = DB::table('inspections')
                    ->leftjoin('p_s_i_products AS psi', 'inspections.id', '=', 'psi.inspection_id')
                    ->leftjoin('user_infos AS inspectors', 'inspections.inspector_id', '=', 'inspectors.user_id')
                    ->leftjoin('user_infos AS created', 'inspections.created_by', '=', 'created.user_id')
                    ->leftjoin('clients', 'inspections.client_id', '=', 'clients.client_code')
    		        ->select(DB::raw('group_concat(psi.product_name) AS p_name, group_concat(psi.po_no) AS po'),'inspections.*','inspectors.name AS inspector_name','created.name AS created_by','clients.Company_Name AS client')
                    ->whereNotNull('inspections.client_book_id')       
                    ->where('psi.product_name','LIKE',"%{$search}%") 
                    ->orWhere('psi.po_no','LIKE',"%{$search}%") 
                    ->orWhere('inspectors.name','LIKE',"%{$search}%")
                    ->orWhere('created.name','LIKE',"%{$search}%") 
                    ->orWhere('clients.Company_Name','LIKE',"%{$search}%")                      
                    ->groupBy(DB::raw('inspections.id'))               
                    ->orderBy('inspections.created_at', 'desc')
                    ->offset($start)
                    ->limit(10)                
                    ->get();

            $totalFiltered=count($inspection_temp);
        }

        $data = array();
        if($inspection){
            foreach ($inspection as $ins){
                $show =  "";
                $edit =  "";
                $po_num='';
                $product='';
                //product
                if($ins->p_name==''){
                    $product='No Product';
                }else{
                    $product=$ins->p_name;
                }
                //po no
                if($ins->po==''){
                    $po_num='No PO';
                }else{
                    $po_num=$ins->po;
                }
                $cut_product='';        
                if($product=='No Product' || strlen($product)<15){
                    $cut_product=$product;
                }else{
                    $cut_product=substr($product,0,15)."..."; 
                }         

               
                if($po_num=='No PO' || strlen($po_num)<15){
                    $cut_po=$po_num;
                }else{
                    $cut_po=substr($po_num,0,15)."...";
                }
                $nestedData['inspector'] = $ins->inspector_name;
                $nestedData['client'] = $ins->client;
                $nestedData['user'] = $ins->created_by;
                $nestedData['service'] = strtoupper($ins->service);
                $nestedData['product'] = $cut_product;
                $nestedData['po_no'] = $cut_po;
                $nestedData['inspection_date'] = date('Y-m-d',strtotime($ins->inspection_date));
                $nestedData['created_at'] = date('Y-m-d',strtotime($ins->created_at));
                $nestedData['status'] = $ins->inspection_status;
                if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical' || $ins->service=='detail' || $ins->service=='social'){
                    $edit =  route('release-client-order-loading',$ins->id);
                    $show='btn_view_project_cbpi';
                }else{
                    $edit =  route('release-client-order',$ins->id);
                    $show='btn_view_project';
                }
                $nestedData['action'] = " <button data-id='{$ins->id}' class='btn btn-warning btn-xs $show' title='View Project Details'><i class='fa  fa-eye'></i></button>  <a href='{$edit}' class='btn btn-info btn-xs' title='Edit Project Details'><i class='fa fa-pencil'></i></a>";    

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }

    public function getClientInspections(Request $request){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
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
        $created = UserInfo::where('user_id',Auth::id())->first();
        $columns = array( 
                            0=> 'client',
                            1=> 'created_by',
                            2 =>'client_project_number', 
                            3 =>'p_name',
                            4=> 'po',
                            5=> 'inspection_date',
                            6=> 'created_at',  //added by migz 04-08-21
                            7=> 'status',
                            8=> 'action',
                        );
        $inspect_count = Inspection::whereNotNull('inspections.client_book_id')->whereNull('inspections.inspection_type')->get();

        $totalData = count($inspect_count);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        // if($order=='created_by'){
        //     $order='created.name';
        // }
        $dir = $request->input('order.0.dir');

        $inspection="";
        if(empty($request->input('search.value'))){         
            $inspection = DB::table('tic_inspections') 
                    ->join('inspections','tic_inspections.id','=','inspections.id')
                    ->select('tic_inspections.*', 'inspections.mrn_no')    //added by migz 04-08-21                            
                    ->orderBy($order,$dir)    
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 

            $inspection_temp = DB::table('tic_inspections')
                    ->join('inspections','tic_inspections.id','=','inspections.id')  
                    ->select('tic_inspections.*', 'inspections.mrn_no')    //added by migz 04-08-21   
                    ->where('tic_inspections.p_name','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.po','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.client','LIKE',"%{$search}%")
                    ->orWhere('tic_inspections.inspection_date','LIKE',"%{$search}%")   
                    ->orWhere('tic_inspections.inspection_status','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.client_project_number','LIKE',"%{$search}%")
                    ->orWhere('tic_inspections.reference_number','LIKE',"%{$search}%")                            
                    ->orderBy($order,$dir)        
                    ->get();
            $inspection = DB::table('tic_inspections')
                    ->join('inspections','tic_inspections.id','=','inspections.id')
                    ->select('tic_inspections.*', 'inspections.mrn_no')    //added by migz 04-08-21   
                    ->where('tic_inspections.p_name','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.po','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.client','LIKE',"%{$search}%")
                    ->orWhere('tic_inspections.inspection_date','LIKE',"%{$search}%")    
                    ->orWhere('tic_inspections.inspection_status','LIKE',"%{$search}%")        
                    ->orWhere('tic_inspections.client_project_number','LIKE',"%{$search}%")
                    ->orWhere('tic_inspections.reference_number','LIKE',"%{$search}%")                          
                    ->orderBy($order,$dir)
                    ->offset($start)
                    ->limit($limit)                
                    ->get();

            $totalFiltered=count($inspection_temp);
        }

        $data = array();
        if($inspection){
            foreach ($inspection as $ins){
                $show =  "";
                $edit =  "";
                $po_num='';
                $product='';
                
                //product
                if($ins->p_name==''){
                    $product='No Product';
                }else{
                    $product=$ins->p_name;
                }
                //po no
                if($ins->po==''){
                    $po_num='No PO';
                }else{
                    $po_num=$ins->po;
                }
                $cut_product='';        
                if($product=='No Product' || strlen($product)<15){
                    $cut_product=$product;
                }else{
                    $cut_product=substr($product,0,15)."..."; 
                }         

               
                if($po_num=='No PO' || strlen($po_num)<15){
                    $cut_po=$po_num;
                }else{
                    $cut_po=substr($po_num,0,15)."...";
                }

                if($ins->inspection_status=='Client Pending'){
                    $nestedData['client'] = "<i class='fa fa-circle fa-xs' style='color:orangered; font-size:10px;'></i> $ins->client";
                    $inspection_status = "<span class='text-primary'>Client Order - Pending</span>";
                }else{
                    $nestedData['client'] = $ins->client;
                    $inspection_status = $ins->inspection_status;
                }

                $nestedData['created_by'] = $ins->user_created_by;
                //$nestedData['service'] = $services[$ins->service];
                $nestedData['client_project_number'] = $ins->reference_number;
                $nestedData['p_name'] = "<span title='$product'>$cut_product</span>";
                $nestedData['po'] = "<span title='$po_num'>$cut_po</span>";
                $nestedData['inspection_date'] = date('Y-m-d',strtotime($ins->inspection_date));
                $nestedData['created_at'] = date('Y-m-d',strtotime($ins->created_at));
                $nestedData['status'] = $inspection_status;
                if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical' || $ins->service=='detail' || $ins->service=='social'){
                    $edit =  route('release-client-order-loading',$ins->id);
                    $show='btn_view_project_cbpi';
                }else{
                    $edit =  route('release-client-order',$ins->id);
                    $show='btn_view_project';
                }
                $mrn_inspection = $ins->mrn_no;
                $edit_mrn = route('release-client-order-mrn',$ins->id);
                if($mrn_inspection != "" || $mrn_inspection != null){
                    $nestedData['action'] = " <div class='dropdown'>
                    <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                        <span class='caret'></span></button>
                    <ul class='dropdown-menu'>
                        <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View</a> </li>
                        <li><a href='{$edit_mrn}'  title='Edit Project Details'>Edit Multiple</a></li>
                        <li><a data-id='{$ins->id}' class='delete-inspection' title='Delete Client Inspection'>Delete</a></li>
                    </ul>
                    </div>";    
    
                    $data[] = $nestedData;
                }else{
                    $nestedData['action'] = " <div class='dropdown'>
                    <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                        <span class='caret'></span></button>
                    <ul class='dropdown-menu'>
                        <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View</a> </li>
                        <li><a href='{$edit}'  title='Edit Project Details'>Edit</a></li>
                        <li><a data-id='{$ins->id}' class='delete-inspection' title='Delete Client Inspection'>Delete</a></li>
                    </ul>
                    </div>";    
    
                    $data[] = $nestedData;
                }
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }

    public function getClientInspectionStatus(Request $request){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
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
        $created = UserInfo::where('user_id',Auth::id())->first();
        $columns = array( 
                            0=> 'client',
                            1=> 'created_by',
                            2 =>'client_project_number', 
                            3 =>'p_name',
                            4=> 'po',
                            5=> 'inspection_date',
                            6=> 'created_at',  //added by migz 04-08-21
                            7=> 'status',
                            8=> 'action',
                        );
        if(!empty($request['status'])){
            $inspect_count = Inspection::whereNotNull('inspections.client_book_id')->whereNull('inspections.inspection_type')->where('inspections.inspection_status',$request['status']) ->get();    
        }else{
            $inspect_count = Inspection::whereNotNull('inspections.client_book_id')->whereNull('inspections.inspection_type')->get();
        }

        $totalData = count($inspect_count);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        // if($order=='created_by'){
        //     $order='created.name';
        // }
        $dir = $request->input('order.0.dir');

        $inspection="";
        if(!empty($request['status'])){         
            $inspection = DB::table('tic_inspections') 
                    ->join('inspections','tic_inspections.id','=','inspections.id')
                    ->select('tic_inspections.*','inspections.mrn_no')    //added by migz 04-08-21  
                    ->where('inspections.inspection_status',$request['status'])                          
                    ->orderBy($order,$dir)    
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
                    if(!empty($request->input('search.value'))){
                        $search = $request->input('search.value');

                        $inspection_temp = DB::table('tic_inspections')
                                ->join('inspections','tic_inspections.id','=','inspections.id')
                                ->select('tic_inspections.*','inspections.mrn_no')    //added by migz 04-08-21
                                ->where('inspections.inspection_status',$request['status'])   
                                ->where('tic_inspections.p_name','LIKE',"%{$search}%") 
                                ->orWhere('tic_inspections.po','LIKE',"%{$search}%") 
                                ->orWhere('tic_inspections.user_created_by','LIKE',"%{$search}%") 
                                ->orWhere('tic_inspections.client','LIKE',"%{$search}%")
                                ->orWhere('tic_inspections.inspection_date','LIKE',"%{$search}%")   
                                ->orWhere('tic_inspections.client_project_number','LIKE',"%{$search}%")
                                ->orWhere('tic_inspections.reference_number','LIKE',"%{$search}%")                            
                                ->orderBy($order,$dir)        
                                ->get();
                        $inspection = DB::table('tic_inspections')
                                ->join('inspections','tic_inspections.id','=','inspections.id')
                                ->select('tic_inspections.*','inspections.mrn_no')    //added by migz 04-08-21
                                ->where('inspections.inspection_status',$request['status'])                           
                                ->where('tic_inspections.p_name','LIKE',"%{$search}%") 
                                ->orWhere('tic_inspections.po','LIKE',"%{$search}%") 
                                ->orWhere('tic_inspections.user_created_by','LIKE',"%{$search}%") 
                                ->orWhere('tic_inspections.client','LIKE',"%{$search}%")
                                ->orWhere('tic_inspections.inspection_date','LIKE',"%{$search}%")          
                                ->orWhere('tic_inspections.client_project_number','LIKE',"%{$search}%")
                                ->orWhere('tic_inspections.reference_number','LIKE',"%{$search}%")                          
                                ->orderBy($order,$dir)
                                ->offset($start)
                                ->limit($limit)                
                                ->get();

                        $totalFiltered=count($inspection_temp);
                    }
        }else{
            $search = $request->input('search.value');

            $inspection_temp = DB::table('tic_inspections')
                    ->join('inspections','tic_inspections.id','=','inspections.id')  
                    ->select('tic_inspections.*','inspections.mrn_no')    //added by migz 04-08-21  
                    ->where('tic_inspections.p_name','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.po','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.client','LIKE',"%{$search}%")
                    ->orWhere('tic_inspections.inspection_date','LIKE',"%{$search}%")   
                    ->orWhere('tic_inspections.inspection_status','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.client_project_number','LIKE',"%{$search}%")
                    ->orWhere('tic_inspections.reference_number','LIKE',"%{$search}%")                            
                    ->orderBy($order,$dir)        
                    ->get();
            $inspection = DB::table('tic_inspections')
                    ->join('inspections','tic_inspections.id','=','inspections.id')
                    ->select('tic_inspections.*','inspections.mrn_no')    //added by migz 04-08-21                          
                    ->where('tic_inspections.p_name','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.po','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('tic_inspections.client','LIKE',"%{$search}%")
                    ->orWhere('tic_inspections.inspection_date','LIKE',"%{$search}%")    
                    ->orWhere('tic_inspections.inspection_status','LIKE',"%{$search}%")        
                    ->orWhere('tic_inspections.client_project_number','LIKE',"%{$search}%")
                    ->orWhere('tic_inspections.reference_number','LIKE',"%{$search}%")                          
                    ->orderBy($order,$dir)
                    ->offset($start)
                    ->limit($limit)                
                    ->get();

            $totalFiltered=count($inspection_temp);
        }

        $data = array();
        if($inspection){
            foreach ($inspection as $ins){
                $show =  "";
                $edit =  "";
                $po_num='';
                $product='';
                
                //product
                if($ins->p_name==''){
                    $product='No Product';
                }else{
                    $product=$ins->p_name;
                }
                //po no
                if($ins->po==''){
                    $po_num='No PO';
                }else{
                    $po_num=$ins->po;
                }
                $cut_product='';        
                if($product=='No Product' || strlen($product)<15){
                    $cut_product=$product;
                }else{
                    $cut_product=substr($product,0,15)."..."; 
                }         

               
                if($po_num=='No PO' || strlen($po_num)<15){
                    $cut_po=$po_num;
                }else{
                    $cut_po=substr($po_num,0,15)."...";
                }

                if($ins->inspection_status=='Client Pending'){
                    $nestedData['client'] = "<i class='fa fa-circle fa-xs' style='color:orangered; font-size:10px;'></i> $ins->client";
                    $inspection_status = "<span class='text-primary'>Client Order - Pending</span>";
                }else{
                    $nestedData['client'] = $ins->client;
                    $inspection_status = $ins->inspection_status;
                }
                $nestedData['created_by'] = $ins->user_created_by;
                //$nestedData['service'] = $services[$ins->service];
                $nestedData['client_project_number'] = $ins->reference_number;
                $nestedData['p_name'] = "<span title='$product'>$cut_product</span>";
                $nestedData['po'] = "<span title='$po_num'>$cut_po</span>";
                $nestedData['inspection_date'] = date('Y-m-d',strtotime($ins->inspection_date));
                $nestedData['created_at'] = date('Y-m-d',strtotime($ins->created_at));
                $nestedData['status'] = $inspection_status;
                if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical' || $ins->service=='detail' || $ins->service=='social'){
                    $edit =  route('release-client-order-loading',$ins->id);
                    $show='btn_view_project_cbpi';
                }else{
                    $edit =  route('release-client-order',$ins->id);
                    $show='btn_view_project';
                }
                $mrn_inspection = $ins->mrn_no;
                $edit_mrn = route('release-client-order-mrn',$ins->id);
                if($mrn_inspection != "" || $mrn_inspection != null){
                    $nestedData['action'] = " <div class='dropdown'>
                    <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                        <span class='caret'></span></button>
                    <ul class='dropdown-menu'>
                        <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View</a> </li>
                        <li><a href='{$edit_mrn}'  title='Edit Project Details'>Edit Multiple</a></li>
                        <li><a data-id='{$ins->id}' class='delete-inspection' title='Delete Client Inspection'>Delete</a></li>
                    </ul>
                    </div>";    
    
                    $data[] = $nestedData;
                }else{
                    $nestedData['action'] = " <div class='dropdown'>
                    <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                        <span class='caret'></span></button>
                    <ul class='dropdown-menu'>
                        <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View</a> </li>
                        <li><a href='{$edit}'  title='Edit Project Details'>Edit</a></li>
                        <li><a data-id='{$ins->id}' class='delete-inspection' title='Delete Client Inspection'>Delete</a></li>
                    </ul>
                    </div>";    
    
                    $data[] = $nestedData;
                }
            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }

    public function getClientInspectionsTICSERA(Request $request){
        $services = ['iqi'=>'Incoming Quality Inspection', 
                    'dupro' => 'During Production Inspection',
                    'psi' => 'Pre Shipment Inspection',
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
        $created = UserInfo::where('user_id',Auth::id())->first();
        $columns = array( 
                            0=> 'inspector_name',
                            1=> 'client',
                            2=> 'created_by',
                            3 =>'client_project_number', 
                            4 =>'product_name',
                            5=> 'po_no',
                            6=> 'inspection_date',
                            7=> 'status',
                            8=> 'action',
                        );
        $inspect_count = Inspection::whereNotNull('inspections.client_book_id')->whereNotNull('inspections.inspection_type')->get();

        $totalData = count($inspect_count);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        if($order=='created_by'){
            $order='created.name';
        }
        $dir = $request->input('order.0.dir');

        $inspection="";
        if(empty($request->input('search.value'))){         
            $inspection = DB::table('tic_sera_inspections')           
                    ->orderBy($order,$dir)    
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 

            $inspection_temp = DB::table('tic_sera_inspections')                   
                    ->where('p_name','LIKE',"%{$search}%") 
                    ->orWhere('po','LIKE',"%{$search}%") 
                    ->orWhere('inspector_name','LIKE',"%{$search}%")
                    ->orWhere('user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('client','LIKE',"%{$search}%")
                    ->orWhere('inspection_date','LIKE',"%{$search}%")   
                    ->orWhere('inspection_status','LIKE',"%{$search}%")   
                    ->orWhere('client_project_number','LIKE',"%{$search}%")                                
                    ->orderBy($order,$dir)        
                    ->get();
            $inspection = DB::table('tic_sera_inspections')      
                    ->where('p_name','LIKE',"%{$search}%") 
                    ->orWhere('po','LIKE',"%{$search}%") 
                    ->orWhere('inspector_name','LIKE',"%{$search}%")
                    ->orWhere('user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('client','LIKE',"%{$search}%")
                    ->orWhere('inspection_date','LIKE',"%{$search}%")   
                    ->orWhere('inspection_status','LIKE',"%{$search}%")        
                    ->orWhere('client_project_number','LIKE',"%{$search}%")                            
                    ->orderBy($order,$dir)
                    ->offset($start)
                    ->limit(10)                
                    ->get();

            $totalFiltered=count($inspection_temp);
        }

        $data = array();
        if($inspection){
            foreach ($inspection as $ins){
                $show =  "";
                $edit =  "";
                $po_num='';
                $product='';
                
                //product
                if($ins->p_name==''){
                    $product='No Product';
                }else{
                    $product=$ins->p_name;
                }
                //po no
                if($ins->po==''){
                    $po_num='No PO';
                }else{
                    $po_num=$ins->po;
                }
                $cut_product='';        
                if($product=='No Product' || strlen($product)<15){
                    $cut_product=$product;
                }else{
                    $cut_product=substr($product,0,15)."..."; 
                }         

               
                if($po_num=='No PO' || strlen($po_num)<15){
                    $cut_po=$po_num;
                }else{
                    $cut_po=substr($po_num,0,15)."...";
                }

                if($ins->inspection_status=='Client Pending'){
                    $nestedData['inspector_name'] = "<i class='fa fa-circle fa-xs' style='color:orangered; font-size:10px;'></i> $ins->inspector_name";
                }else{
                    $nestedData['inspector_name'] = $ins->inspector_name;
                }
                
                $nestedData['client'] = $ins->client;
                $nestedData['created_by'] = $ins->user_created_by;
                //$nestedData['service'] = $services[$ins->service];
                $nestedData['client_project_number'] = $ins->client_project_number;
                $nestedData['product_name'] = "<span title='$product'>$cut_product</span>";
                $nestedData['po_no'] = "<span title='$po_num'>$cut_po</span>";
                $nestedData['inspection_date'] = date('Y-m-d',strtotime($ins->inspection_date));
               /*  $nestedData['created_at'] = date('Y-m-d',strtotime($ins->created_at)); */
                $nestedData['status'] = $ins->inspection_status;
                if($ins->service=='cli' || $ins->service=='cbpi' || $ins->service=='cbpi_serial' || $ins->service=='cbpi_isce' || $ins->service=='physical' || $ins->service=='detail' || $ins->service=='social'){
                    $edit =  route('release-client-order-loading',$ins->id);
                    $show='btn_view_project_cbpi';
                }else{
                    $edit =  route('release-client-order',$ins->id);
                    $show='btn_view_project';
                }
                $nestedData['action'] = " <div class='dropdown'>
                <button class='btn btn-xs btn-warning dropdown-toggle' type='button' data-toggle='dropdown'>Action
                    <span class='caret'></span></button>
                <ul class='dropdown-menu'>
                    <li><a data-id='{$ins->id}' class='$show' title='View Project Details'>View</a> </li>
                    <li><a href='{$edit}'  title='Edit Project Details'>Edit</a></li>
                    <li><a data-id='{$ins->id}' class='delete-inspection' title='Delete Client Inspection'>Delete</a></li>
                </ul>
            </div>";    

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }


    public function serverSideClients(Request $request){

        $created = UserInfo::where('user_id',Auth::id())->first();
        $columns = array( 
                            0=> 'Company_Name',
                            1=> 'client_code',
                            2=> 'Company_Email',
                            3 =>'address', 
                            4=> 'created_at',
                            5=> 'action',
                        );
        $clients = Client::orderBy('id','desc')->get();

        $totalData = count($clients);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $inspection="";
        if(empty($request->input('search.value'))){   
            $clients = Client::orderBy('id','desc')
                    ->offset($start)
                    ->limit($limit)   
                    ->get();      
        }else{
            $search = $request->input('search.value'); 
            $clients_temp = Client::where('Company_Name','LIKE',"%{$search}%")
                        ->orWhere('client_code','LIKE',"%{$search}%") 
                        ->orWhere('Company_Email','LIKE',"%{$search}%") 
                        ->orWhere('created_at','LIKE',"%{$search}%") 
                        ->get();
            $clients = Client::where('Company_Name','LIKE',"%{$search}%")
                        ->orWhere('client_code','LIKE',"%{$search}%") 
                        ->orWhere('Company_Email','LIKE',"%{$search}%") 
                        ->orWhere('created_at','LIKE',"%{$search}%") 
                        ->orderBy('id','desc')
                        ->offset($start)
                        ->limit($limit)   
                        ->get();
  

            $totalFiltered=count($clients_temp);
        }

        $data = array();
        if($clients){
            foreach ($clients as $client){
                $nestedData['Company_Name'] = $client->Company_Name;
                $nestedData['client_code'] = $client->client_code;
                $nestedData['Company_Email'] = $client->Company_Email;
                $nestedData['address'] = $client->Company_Email;
                $nestedData['created_at'] = date('Y-m-d h:i a',strtotime($client->created_at));
                $nestedData['action'] = " <button data-id='{$client->id}' class='btn btn-warning btn-xs $show' title='View Project Details'><i class='fa  fa-eye'></i></button>  <a href='{$edit}' class='btn btn-info btn-xs' title='Edit Project Details'><i class='fa fa-pencil'></i></a>";    
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }

   
    public function getClientCostOLD(Request $request){
        $columns = array( 
                            0=> 'client_name',
                            1=> 'client_pn',
                            2=> 'report_no',
                            3=> 'currency', 
                            4=> 'total_cost',
                            5=> 'actions'
                        );
        $client_cost = DB::table('client_costs')
                    ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                    ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')
                    ->get();
        $totalData = count($client_cost);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $client_cost="";
        if(empty($request->input('search.value'))){   
                    $client_cost = DB::table('client_costs')
                    ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
    		        ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')            
                    ->orderBy('inspect.created_at', 'desc')
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 
            $client_cost_temp = DB::table('client_costs')
                        ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                        ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                        ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')        
                        ->where('inspect.client_project_number','LIKE',"%{$search}%")
                        ->orWhere('inspect.reference_number','LIKE',"%{$search}%") 
                        ->orWhere('cli.Company_Name','LIKE',"%{$search}%")   
                        ->get();
            $client_cost = DB::table('client_costs')
                        ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                        ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                        ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')        
                        ->where('inspect.client_project_number','LIKE',"%{$search}%")
                        ->orWhere('inspect.reference_number','LIKE',"%{$search}%") 
                        ->orWhere('cli.Company_Name','LIKE',"%{$search}%") 
                        ->orderBy('id','desc')
                        ->offset($start)
                        ->limit($limit)   
                        ->get();
  

            $totalFiltered=count($client_cost_temp);
        }

        $data = array();
        if($client_cost){
            foreach ($client_cost as $cost){
                $total_cost=0;
                
                $md=$cost->md_charges;
                $travel=$cost->travel_cost;
                $hotel=$cost->hotel_cost;
                $ot=$cost->ot_cost;

                $total_cost=$total_cost+$md+$travel+$hotel+$ot;

                $other=$cost->other_cost_value;
                if($other){
                    $exp_other = explode(',', $other);
                    if($exp_other){
                        foreach($exp_other as $oth_cost){
                            $total_cost+=$oth_cost;
                        }
                    }
                }

                $nestedData['client_name'] = "<a href='#' data-id='{$cost->client_code}'>{$cost->Company_Name}</a>";
                $nestedData['client_pn'] = $cost->client_project_number;
                $nestedData['report_no'] = $cost->reference_number;
                $nestedData['currency'] = strtoupper($cost->currency);
                $nestedData['total_cost'] = $total_cost;              
                                            
                $nestedData['actions'] = "  <button class='btn btn-warning btn-xs btn-view-cost-client' title='View' data-id='{$cost->id}'><i class='fa fa-eye'></i> </button>  <button data-id='$cost->id' class='btn btn-info btn-xs' title='Save as PDF'><i class='fa fa-file-pdf-o'></i> </button>";    
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data);       
    }

    public function getClientCost(Request $request){
        $columns = array( 
                            0=> 'client_name',
                            1=> 'client_pn',
                            2=> 'report_no',
                            3=> 'currency', 
                            4=> 'total_cost',
                            5=> 'actions'
                        );
        $client_cost = DB::table('client_costs')
                    ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                    ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')
                    ->get();
        $totalData = count($client_cost);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $client_cost="";
        if(empty($request->input('search.value'))){   
                    $client_cost = DB::table('client_costs')
                    ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
    		        ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')            
                    ->orderBy('inspect.created_at', 'desc')
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 
            $client_cost_temp = DB::table('client_costs')
                        ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                        ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                        ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')        
                        ->where('inspect.client_project_number','LIKE',"%{$search}%")
                        ->orWhere('inspect.reference_number','LIKE',"%{$search}%") 
                        ->orWhere('cli.Company_Name','LIKE',"%{$search}%")   
                        ->get();
            $client_cost = DB::table('client_costs')
                        ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                        ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                        ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')        
                        ->where('inspect.client_project_number','LIKE',"%{$search}%")
                        ->orWhere('inspect.reference_number','LIKE',"%{$search}%") 
                        ->orWhere('cli.Company_Name','LIKE',"%{$search}%") 
                        ->orderBy('id','desc')
                        ->offset($start)
                        ->limit($limit)   
                        ->get();
  

            $totalFiltered=count($client_cost_temp);
        }

        $data = array();
        if($client_cost){
            foreach ($client_cost as $cost){
                $total_cost=0;
                
                $md=$cost->md_charges;
                $travel=$cost->travel_cost;
                $hotel=$cost->hotel_cost;
                $ot=$cost->ot_cost;

                $total_cost=$total_cost+$md+$travel+$hotel+$ot;

                $other=$cost->other_cost_value;
                if($other){
                    $exp_other = explode(',', $other);
                    if($exp_other){
                        foreach($exp_other as $oth_cost){
                            $total_cost+=$oth_cost;
                        }
                    }
                }

                $nestedData['client_name'] = "<a href='specific-client-cost/$cost->client_code' data-id='{$cost->client_code}'>{$cost->Company_Name}</a>";
                $nestedData['client_pn'] = $cost->client_project_number;
                $nestedData['report_no'] = $cost->reference_number;
                $nestedData['currency'] = strtoupper($cost->currency);
                $nestedData['total_cost'] = $total_cost;              
                $print=route('create-one-invoice',$cost->id);
                $nestedData['actions'] = "  <button class='btn btn-warning btn-xs btn-view-cost-client' title='View' data-id='{$cost->id}'><i class='fa fa-eye'></i> </button>  <a data-id='$cost->id' href='{$print}' class='btn btn-info btn-xs' title='Save as PDF'><i class='fa fa-file-pdf-o'></i> </a>";    
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data);       
    }

    public function getSpecificClientCostPage($id){
        $role = DB::table('role_user')
    		->join('roles', 'role_user.role_id', '=', 'roles.id')
    		->join('users', 'role_user.user_id', '=', 'users.id')
    		->select('roles.name','role_user.role_id','users.username')
    		->where('role_user.user_id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $client = Client::where('client_code',$id)->first();
        $client_code=$id;
        $client_name=$client->Company_Name;
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_type',null)->where('inspection_status','Client Pending')->count();
        return view('pages.admin.InspectionCost.specific_client_cost',compact('role','user_info','client_code','client_name','new_client_count','new_post_client')); 
    }
    public function getSpecificClientCost(Request $request){
        $client_code=$request['client_code'];
        $columns = array( 
                            0=> 'client_name',
                            1=> 'service',
                            2=> 'inspection_date',
                            3=> 'client_pn',
                            4=> 'report_no',
                            5=> 'currency', 
                            6=> 'total_cost',
                            7=> 'actions'
                        );
        $client_cost = DB::table('client_costs')
                    ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                    ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')
                    ->where('cli.client_code',$client_code)
                    ->where('inspect.service','!=','null')
                    ->get();
        $totalData = count($client_cost);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $client_cost="";
        if(empty($request->input('search.value'))){   
                    $client_cost = DB::table('client_costs')
                    ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                    ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','inspect.service','inspect.inspection_date','cli.Company_Name','cli.client_code') 
                    ->where('cli.client_code',$client_code)
                    ->where('inspect.service','!=','null')        
                    ->orderBy('inspect.created_at', 'desc')
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 
            $client_cost_temp = DB::table('client_costs')
                        ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                        ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                        ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','inspect.service','inspect.inspection_date','cli.Company_Name','cli.client_code')  
                        ->where('inspect.client_project_number','LIKE',"%{$search}%")
                        ->orWhere('inspect.reference_number','LIKE',"%{$search}%") 
                        ->orWhere('cli.Company_Name','LIKE',"%{$search}%")   
                        ->get();
            $client_cost = DB::table('client_costs')
                        ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                        ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                        ->select('client_costs.*', 'inspect.client_project_number', 'inspect.reference_number','inspect.service','inspect.inspection_date','cli.Company_Name','cli.client_code') 
                        ->where('inspect.client_project_number','LIKE',"%{$search}%")
                        ->orWhere('inspect.reference_number','LIKE',"%{$search}%") 
                        ->orWhere('cli.Company_Name','LIKE',"%{$search}%") 
                        ->orderBy('id','desc')
                        ->offset($start)
                        ->limit($limit)   
                        ->get();
  

            $totalFiltered=count($client_cost_temp);
        }

        $data = array();
        if($client_cost){
            foreach ($client_cost as $cost){
                $total_cost=0;
                
                $md=$cost->md_charges;
                $travel=$cost->travel_cost;
                $hotel=$cost->hotel_cost;
                $ot=$cost->ot_cost;

                $total_cost=$total_cost+$md+$travel+$hotel+$ot;

                $other=$cost->other_cost_value;
                if($other){
                    $exp_other = explode(',', $other);
                    if($exp_other){
                        foreach($exp_other as $oth_cost){
                            $total_cost+=$oth_cost;
                        }
                    }
                }

                $nestedData['client_name'] =$cost->Company_Name;
                $nestedData['service'] = strtoupper($cost->service);
                $nestedData['inspection_date'] = date('M d, Y',strtotime($cost->inspection_date));
                $nestedData['client_pn'] = $cost->client_project_number;
                $nestedData['report_no'] = $cost->reference_number;
                $nestedData['currency'] = strtoupper($cost->currency);
                $nestedData['total_cost'] = $total_cost;              
                $print=route('create-one-invoice',$cost->id);          
                $nestedData['actions'] = "  <button class='btn btn-warning btn-xs btn-view-cost-client' title='View' data-id='{$cost->id}'><i class='fa fa-eye'></i> </button>  <a data-id='$cost->id' href='{$print}' class='btn btn-info btn-xs' title='Save as PDF'><i class='fa fa-file-pdf-o'></i> </a>";    
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data);       
    }

    public function getInspectorCost(Request $request){
        $columns = array( 
                            0=> 'inspector',
                            1=> 'client_pn',
                            2=> 'report_no',
                            3=> 'currency',
                            4=> 'total_cost',
                            5=> 'actions'
                        );
        $inspector_cost = DB::table('inspector_costs')
                    ->join('inspections AS inspect', 'inspector_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                    ->select('inspector_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')
                    ->get();
        $totalData = count($inspector_cost);       
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $inspector_cost="";
        if(empty($request->input('search.value'))){   
                    $inspector_cost = DB::table('inspector_costs')
                    ->join('inspections AS inspect', 'inspector_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
    		        ->select('inspector_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')            
                    ->orderBy('inspect.created_at', 'desc')
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 
            $inspector_cost_temp = DB::table('inspector_costs')
                        ->join('inspections AS inspect', 'inspector_costs.inspection_id', '=', 'inspect.id')
                        ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                        ->select('inspector_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')        
                        ->where('inspect.client_project_number','LIKE',"%{$search}%")
                        ->orWhere('inspect.reference_number','LIKE',"%{$search}%")    
                        ->get();
            $inspector_cost = DB::table('inspector_costs')
                        ->join('inspections AS inspect', 'inspector_costs.inspection_id', '=', 'inspect.id')
                        ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                        ->select('inspector_costs.*', 'inspect.client_project_number', 'inspect.reference_number','cli.Company_Name','cli.client_code')        
                        ->where('inspect.client_project_number','LIKE',"%{$search}%")
                        ->orWhere('inspect.reference_number','LIKE',"%{$search}%")  
                        ->orderBy('id','desc')
                        ->offset($start)
                        ->limit($limit)   
                        ->get();
  

            $totalFiltered=count($inspector_cost_temp);
        }

        $data = array();
        if($inspector_cost){
            foreach ($inspector_cost as $cost){
                $total_cost=0;
                
                $md=$cost->md_charges;
                $travel=$cost->travel_cost;
                $hotel=$cost->hotel_cost;
                $ot=$cost->ot_cost;

                $total_cost=$total_cost+$md+$travel+$hotel+$ot;

                $other=$cost->other_cost_value;
                if($other){
                    $exp_other = explode(',', $other);
                    if($exp_other){
                        foreach($exp_other as $oth_cost){
                            $total_cost+=$oth_cost;
                        }
                    }
                }
                $nestedData['inspector'] = "<a href='#' data-id='{$cost->client_code}'>{$cost->Company_Name}</a>";
                $nestedData['client_pn'] = $cost->client_project_number;
                $nestedData['report_no'] = $cost->reference_number;
                $nestedData['currency'] = strtoupper($cost->currency);
                $nestedData['total_cost'] = $total_cost;              
                                            
                $nestedData['actions'] = "  <button class='btn btn-warning btn-xs btn-view-cost-client' title='View' data-id='{$cost->id}'><i class='fa fa-eye'></i> </button>  <button data-id='$cost->id' class='btn btn-info btn-xs' title='Save as PDF'><i class='fa fa-file-pdf-o'></i> </button>";    
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data);       
    }

    public function getSpecificCost($id){
        $cost_details = DB::table('client_costs')
            ->select('client_costs.*')        
            ->where('client_costs.id',$id)
            ->first();

        $total_cost=0;           
        $md=$cost_details->md_charges;
        $travel=$cost_details->travel_cost;
        $hotel=$cost_details->hotel_cost;
        $ot=$cost_details->ot_cost;
        $total_cost=$total_cost+$md+$travel+$hotel+$ot;
        $other="";
        if($cost_details->other_cost_value){
            $other=$cost_details->other_cost_value;
        }
       
        if($other){
            $exp_other = explode(',', $other);
            if($exp_other){
                foreach($exp_other as $cost){
                    $total_cost+=$cost;
                }
            }
        }

        $inspections = Inspection::where('id',$cost_details->inspection_id)->first();
        $client = Client::where('client_code',$inspections->client_id)->first();
        $inspectors=array();
        $sec_inspector=$inspections->secondary_inspector_id;
        if($sec_inspector=='null' || $sec_inspector==null){

        }else{
            $sec_ins = explode(',', $sec_inspector);
            if($sec_ins){
                foreach($sec_ins as $second){
                    $sec = UserInfo::select('name')->where('user_id',$second)->first();
                    array_push($inspectors, $sec);
                }
            }
        }
        $first_inspector = UserInfo::select('name')->where('user_id',$inspections->inspector_id)->first();
        array_push($inspectors, $first_inspector);
        return response()->json([
            'cost_details' => $cost_details,
            'inspections' => $inspections,
            'inspectors' => $inspectors,
            'client' => $client,
            'total_cost'=>$total_cost
        ]);
    }

    public function getSpecificInsCost($id){
        $cost_details = DB::table('inspector_costs')
            ->select('inspector_costs.*')        
            ->where('inspector_costs.id',$id)
            ->first();

        $total_cost=0;           
        $md=$cost_details->md_charges;
        $travel=$cost_details->travel_cost;
        $hotel=$cost_details->hotel_cost;
        $ot=$cost_details->ot_cost;
        $total_cost=$total_cost+$md+$travel+$hotel+$ot;
        $other="";
        if($cost_details->other_cost_value){
            $other=$cost_details->other_cost_value;
        }
       
        if($other){
            $exp_other = explode(',', $other);
            if($exp_other){
                foreach($exp_other as $cost){
                    $total_cost+=$cost;
                }
            }
        }

        $inspections = Inspection::where('id',$cost_details->inspection_id)->first();
        $client = Client::where('client_code',$inspections->client_id)->first();
        $inspectors=array();
        $sec_inspector=$inspections->secondary_inspector_id;
        if($sec_inspector=='null' || $sec_inspector==null){

        }else{
            $sec_ins = explode(',', $sec_inspector);
            if($sec_ins){
                foreach($sec_ins as $second){
                    $sec = UserInfo::select('name')->where('user_id',$second)->first();
                    array_push($inspectors, $sec);
                }
            }
        }
        $first_inspector = UserInfo::select('name')->where('user_id',$inspections->inspector_id)->first();
        array_push($inspectors, $first_inspector);
        return response()->json([
            'cost_details' => $cost_details,
            'inspections' => $inspections,
            'inspectors' => $inspectors,
            'client' => $client,
            'total_cost'=>$total_cost
        ]);
    }

    public function getCountry($id){
        $url = 'http://world.t-i-c.asia/webapi_world_controller.php';
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    public function getState($id){
        $url = "http://world.t-i-c.asia/webapi_state_controller.php?id=$id";
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    public function getCity($id){
        $url = "http://world.t-i-c.asia/webapi_city_controller.php?state_id=$id";
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function createOneInvoice($id){
        $date_now=date('m/d/Y');

        $client_cost = DB::table('client_costs')
                    ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                    ->select('client_costs.*', 'inspect.inspection_date', 'inspect.service', 'inspect.manday', 'inspect.reference_number', 'inspect.factory', 'cli.*')
                    ->where('client_costs.id',$id)
                    ->first();
                    //cost
        //get payment terms
        $pay_terms=$client_cost->payment_term;
        $arr_pay_terms = [
            'Collect invoice end of the month payable with 10 days' => '10',
            'Collect invoice end of the month payable with 30 days' => '30',
            '2 month Collect invoice payable with 10 days' => '10',
            '2 month Collect invoice payable with 30 days' => '30',
            'Invoice after inspection within 10 days payable' => '10',
            'Invoice to be paid before inspection' => '1',
            'Invoice to be paid by factory before inspection' => '1'
        ];

        $get_pay_days;
        $payable_date="";
        if($pay_terms=='special_term'){
            $get_pay_days=7*86400;
            $payable_date=" Payable before ".$tomorrow;
        }else if($pay_terms==''){
            $get_pay_days=7*86400;
            $tomorrow = date('m/d/Y', time() + $get_pay_days);
            $payable_date=" Payable before ".$tomorrow;
        }else if($pay_terms=='Invoice to be paid before inspection' || $pay_terms=='Invoice to be paid by factory before inspection'){
            $payable_date=" Payable before Inspection ";
        }else{
            $get_pay_days=$arr_pay_terms[$pay_terms]*86400;
            $tomorrow = date('m/d/Y', time() + $get_pay_days);
            $payable_date=" Payable before ".$tomorrow;
        } 

        $currency = [
            'usd' => '$',
            'eur' => '€',
            'gbp' => '£',
            'inr' => '₹',
            'myr' => 'RM',
            'cny' => '¥'
        ];
        $total_cost=0;
        $get_curr= strtoupper($client_cost->currency);
        $set_curr=$currency[$client_cost->currency];
        $md= $client_cost->md_charges;
        $travel=$client_cost->travel_cost;
        $hotel=$client_cost->hotel_cost;
        $ot=$client_cost->ot_cost;
        $total_cost=$total_cost+$md+$travel+$hotel+$ot;
        $other=$client_cost->other_cost_value;
        if($other){
            $exp_other = explode(',', $other);
            if($exp_other){
                foreach($exp_other as $oth_cost){
                    $total_cost+=$oth_cost;
                }
            }
        }
        $cost=$set_curr."".$total_cost;
        //inspection details
        $client= htmlspecialchars($client_cost->Company_Name);
        $manday = $client_cost->manday; 
        $services = ['iqi'=>'Incoming Quality Inspection', 
            'dupro' => 'During Production Inspection',
            'psi' => 'Pre Shipment Inspection',
            'cli' => 'Container Loading Inspection',
            'pls' => 'Setting Up Production Lines',
            'st' => 'Sample Test',
            'cbpi' => 'CBPI - No Serial',
            'cbpi_serial' => 'CBPI - with Serial',
            'cbpi_isce' => 'CBPI - ISCE',
            'site_visit' => 'Site Visit',
            'physical' => 'Factory Audit',
            'SPK' => 'SPK',
            'FRI' => 'FRI',         
        ];
        $service=$client_cost->service;
        $ins_date= date('F d',strtotime($client_cost->inspection_date));
        $ins_refnum=htmlspecialchars($client_cost->reference_number);
        $sub_cost=$manday*$total_cost;
        //invoice file name
        $file_name=$ins_refnum." ".$client.".doc";
        $file_name_server=$client.".doc";
        $set_file_name="invoice/".$client_cost->client_code."/".$file_name;
           
        $dir_inv = "invoice/$client_cost->client_code/";
        $filecount = 1;
        $files = glob($dir_inv . "*");
        if ($files){
            $filecount = 0;
            $filecount = count($files)+1;
        }
        $files_plus= 0;
        $files_plus= $filecount;
        $file_name_server=$client."_".$files_plus.".doc";
        if (File::exists("invoice/$client_cost->client_code/$file_name_server")) {
            $count_temp= $files_plus+1;
            $file_name_server=$client."_".$count_temp.".doc";
        }

        //invoice number
        $year_now=date('Y');
        $inv_number=$year_now.$client_cost->client_code.$filecount;

        //product
        $products=PSIProduct::where('inspection_id',$client_cost->inspection_id)->get();
        $p_name="";
        foreach($products as $product){
            $p_name.=$product->product_name;
        }
        //factory
        $factory=Factory::where('id',$client_cost->factory)->first();
        $f_name="";
        if($factory){
            $f_name=htmlspecialchars($factory->factory_name);
        }

        //invoice description
        $description=$services[$service].' on '.$ins_date.' '.$ins_refnum.' '.$p_name.' '.$f_name;
        //invoice address
        $inv_street = $client_cost->company_inv_street_num; 
        if($inv_street=='N/A' || $inv_street=='N/a' || $inv_street=='n/a'){
            $inv_street="";
        }
        $inv_bldg = $client_cost->company_inv_bldg_num;
        if($inv_bldg=='N/A' || $inv_bldg=='N/a' || $inv_bldg=='n/a'){
            $inv_bldg="";
        }
        $inv_addr1=$inv_street.','.$inv_bldg;

        $inv_city =  $client_cost->company_invoice_city_name;
        $inv_country =  $client_cost->company_invoice_country_name;
        $inv_zip =  $client_cost->company_inv_zip_code;
        $inv_addr2=$inv_city.','.$inv_country.','.$inv_zip;
        

        $php_word  = new PHPWord();
        // Adding an empty Section to the document...
        $section_style=array( 'marginLeft'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5), 'marginRight'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5), 'marginTop'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.25), 'marginBottom'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.25),'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2),'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2));

        $section_style2=['marginLeft' => 600, 'marginRight' => 600, 'marginTop' => 600, 'marginBottom' => 600];
        $section = $php_word->addSection($section_style2);

        //header
        $header = $section->createHeader();
        $header->addImage('images/tic_inline_logo.png',['marginTop' => 0, 'width'=>'500', 'marginLeft' => -1]);

        //footer
        $footer = $section->createFooter();
        $footer->addText('The Inspection Company Limited',['align'=>'center','spaceAfter' => 0,'size' => 10,'color'=>'FF4500'],['align'=>'center','color'=>'FF4500']);
        $footer->addText('Level 12, Infinitus Plaza, 199 Des Voeux Road Central, Sheung Wan, Hong Kong.',['align'=>'center','spaceAfter' => 0,'size' => 10],['align'=>'center']);
        $footer->addText('Phone: +852-3796 3305 Fax: +852-3796 3000',['align'=>'center','spaceAfter' => 0,'size' => 10],['align'=>'center']);
        $footer->addPreserveText('{PAGE}',['align'=>'right','spaceAfter' => 0,'size' => 10],['align'=>'right']);

        $table_style = ['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50];
        $inv_table_style = ['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50];

        $header_style = ['color'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        //left style
        $label_style_l_pay = ['align'=>'left','spaceAfter' => 0,'size' => 11];
        $label_style_l = ['align'=>'left','spaceAfter' => 0,'size' => 12];
        $cell_style_l = ['align'=>'left','spaceAfter' => 0];
        //right style
        $label_style_r = ['align'=>'right','spaceAfter' => 0,'size' => 12];
        $cell_style_r = ['align'=>'right','spaceAfter' => 0];
        //center style
        $label_style_c = ['align'=>'center','spaceAfter' => 0,'size' => 12];
        $cell_style_c = ['align'=>'center','spaceAfter' => 0];

        $invoice_style_right = ['bold'=>true,'align'=>'right','spaceAfter' => 0,'size' => 14];
        $table_cell_normal = ['valign' => 'center','color'=>'000000','size' => 12];
        $remove_cell_bottom_padding = ['spaceAfter' => 0];
        $header_text_style= ['color'=>'FFFFFF', 'size' => 12];
        $table_header_cell_style =['gridSpan'=>'4','bgColor'=>'909090'];
        $align_center=['align' => 'center'];

        //invoice address
        $invtable = $section->addTable('Invoice Address');
        $invtable->addRow(50);
        $invtable->addCell(4750, ['align' => 'center'])->addText('The Inspection Company 199 Des Voeux Road Sheung Wan HK', $label_style_l,$cell_style_l);
        $invtable->addCell(4750, ['align' => 'center'])->addText('Invoice', $invoice_style_right,$cell_style_r);
        $invtable->addRow(200);
        $invtable->addCell(4750, ['align' => 'center'])->addText($client, $label_style_l,$cell_style_l);
        $invtable->addCell(4750, ['align' => 'center'])->addText('Date: '.$date_now, $label_style_r,$cell_style_r);
        $invtable->addRow(50);

        if($inv_addr1==','){
            $invtable->addCell(4750, ['align' => 'center'])->addText($inv_addr2, $label_style_l,$cell_style_l);
            $invtable->addCell(4750, ['align' => 'center'])->addText('Invoice #: '.$inv_number, $label_style_r,$cell_style_r);
        }else{
            $invtable->addCell(4750, ['align' => 'center'])->addText($inv_addr1, $label_style_l,$cell_style_l);
            $invtable->addCell(4750, ['align' => 'center'])->addText('Invoice #: '.$inv_number, $label_style_r,$cell_style_r);
            $invtable->addRow(50);
            $invtable->addCell(9500, ['align' => 'center'])->addText($inv_addr2, $label_style_l,$cell_style_l);
        }
        
        
        $section->addTextBreak();

        //description table
        $php_word->addTableStyle('Description Table', $table_style);
        $gentable = $section->addTable('Description Table');
        $gentable->addRow(50);
        $gentable->addCell(6000, ['align' => 'center'])->addText('Description', $label_style_c,$cell_style_c);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Manday', $label_style_c,$cell_style_c);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Price in '.$get_curr, $label_style_c,$cell_style_c);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Total in '.$get_curr, $label_style_c,$cell_style_c);
        $gentable->addRow(50);
        $gentable->addCell(6000, ['align' => 'center'])->addText($description, $label_style_c,$cell_style_c);
        $gentable->addCell(2000, ['align' => 'center'])->addText($manday, $label_style_c,$cell_style_c);
        $gentable->addCell(2000, ['align' => 'center'])->addText($cost, $label_style_c,$cell_style_c);
        $gentable->addCell(2000, ['align' => 'center'])->addText($set_curr."".$sub_cost, $label_style_c,$cell_style_c);
        $gentable->addRow(50);
        $gentable->addCell(10000, ['gridSpan'=>'3', 'align' => 'center'])->addText('Total Amount: ', $label_style_r,$cell_style_r);
        $gentable->addCell(2000, ['align' => 'center'])->addText($set_curr."".$sub_cost, $label_style_c,$cell_style_c);

        $section->addTextBreak();

        //payable box
        $textrun = $section->addTextRun($table_style);
        $textrun->addTextBreak();
        $textrun->addText($payable_date,$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText("  To: \t \t \t HSBC Hong Kong",$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText("  Bank Address: \t 1 Queens Road Central, Hong Kong",$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText("  In Favor of: \t \t The Inspection Company Limited",$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText("  Account Number: \t 640-047858-838",$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText("  Swift Code: \t \t HSBCHKHHHKH",$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText("  Bank Code: \t \t 004",$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText('  Or small amount to Paypal (need add total amount 4.4% paypal fee): paypal@t-i-c.asia',$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText('  Bank Charges policy:',$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText('  TIC pays for its local bank charges',$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText('  Clients pay for their own local bank charges as well as an intermediary charges',$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText('  (if their bank has chosen an intermediary to process the payment)',$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText('  We will issue a Debit Note if these charges are deducted from the remitted amount.',$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText('  For payment tracking purposes, please mention clearly your Invoice Number on your Transfer Order.',$label_style_l_pay);



        //save to server
        $objWriter2 = \PhpOffice\PhpWord\IOFactory::createWriter($php_word, 'Word2007');
        $save_path="invoice/$client_cost->client_code/";
        if (!File::isDirectory($save_path)) {
            File::makeDirectory($save_path, 0777, true, true);
        }
        $objWriter2->save($save_path.$file_name_server);
        return response()->download($save_path.$file_name_server);
    }
    public function createInvoice($client_code,$date_from, $date_to){
        $id=$client_code;
        $from= date('Y-m-d',strtotime($date_from));
        $to= date('Y-m-d',strtotime($date_to));
        $date_now=date('m/d/Y');
        //$tomorrow = date('m/d/Y', time() + 86400);
        
        $client_cost = DB::table('client_costs')
                    ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                    ->select('client_costs.*', 'inspect.inspection_date', 'inspect.service', 'inspect.manday', 'inspect.reference_number', 'cli.*')
                    ->where('cli.client_code',$id)           
                    ->first();
        $cost_details = DB::table('client_costs')
                    ->join('inspections AS inspect', 'client_costs.inspection_id', '=', 'inspect.id')
                    ->join('clients AS cli', 'inspect.client_id', '=', 'cli.client_code')
                    ->select('client_costs.*', 'inspect.inspection_date', 'inspect.service', 'inspect.manday', 'inspect.reference_number', 'inspect.factory', 'cli.*')
                    ->where('cli.client_code',$id)
                    ->where('inspect.inspection_date', '>=', $from)
                    ->where('inspect.inspection_date', '<=', $to)                  
                    ->get();
        //get payment terms
        $pay_terms=$client_cost->payment_term;
        $arr_pay_terms = [
            'Collect invoice end of the month payable with 10 days' => '10',
            'Collect invoice end of the month payable with 30 days' => '30',
            '2 month Collect invoice payable with 10 days' => '10',
            '2 month Collect invoice payable with 30 days' => '30',
            'Invoice after inspection within 10 days payable' => '10',
            'Invoice to be paid before inspection' => '1',
            'Invoice to be paid by factory before inspection' => '1'
        ];
        $get_pay_days;
        $payable_date="";
        if($pay_terms=='special_term'){
            $get_pay_days=7*86400;
            $payable_date=" Payable before ".$tomorrow;
        }else if($pay_terms==''){
            $get_pay_days=7*86400;
            $tomorrow = date('m/d/Y', time() + $get_pay_days);
            $payable_date=" Payable before ".$tomorrow;
        }else if($pay_terms=='Invoice to be paid before inspection' || $pay_terms=='Invoice to be paid by factory before inspection'){
            $payable_date=" Payable before Inspection ";
        }else{
            $get_pay_days=$arr_pay_terms[$pay_terms]*86400;
            $tomorrow = date('m/d/Y', time() + $get_pay_days);
            $payable_date=" Payable before ".$tomorrow;
        }       

        

       

        //cost

        $currency = [
            'usd' => '$',
            'eur' => '€',
            'gbp' => '£',
            'inr' => '₹',
            'myr' => 'RM',
            'cny' => '¥'
        ];
        
        //file name
        $get_com_name=htmlspecialchars($client_cost->Company_Name);
        $file_name=$get_com_name.".doc";
        $file_name_server=$get_com_name.".doc";
        $set_file_name="invoice/".$client_code."/".$file_name;
        //$files = Storage::allFiles("http://newapi.t-i-c.asia/invoice/$client_code/");
        //$files_plus= 0;
        //foreach ($files as $file){
        //    $files_plus+=1;
        //}
        //$file_name_server=$client_cost->Company_Name."(".$files_plus.").doc";
           
        $dir_inv = "invoice/$client_code/";
        $filecount = 1;
        $files = glob($dir_inv . "*");
        if ($files){
            $filecount = 0;
            $filecount = count($files)+1;
        }
        $files_plus= 0;
        $files_plus= $filecount;
        $file_name_server=$get_com_name."_".$files_plus.".doc";
        

        if (File::exists("invoice/$client_code/$file_name_server")) {
            $count_temp= $files_plus+1;
            $file_name_server=$get_com_name."_".$count_temp.".doc";
        }
        //invoice number
        $year_now=date('Y');
        $inv_number=$year_now.$client_code.$filecount;
        
        //invoice address
        $inv_street = $client_cost->company_inv_street_num; 
        if($inv_street=='N/A' || $inv_street=='N/a' || $inv_street=='n/a'){
            $inv_street="";
        }
        $inv_bldg = $client_cost->company_inv_bldg_num;
        if($inv_bldg=='N/A' || $inv_bldg=='N/a' || $inv_bldg=='n/a'){
            $inv_bldg="";
        }
        $inv_addr1=$inv_street.','.$inv_bldg;

        $inv_city =  $client_cost->company_invoice_city_name;
        $inv_country =  $client_cost->company_invoice_country_name;
        $inv_zip =  $client_cost->company_inv_zip_code;
        $inv_addr2=$inv_city.','.$inv_country.','.$inv_zip;
        
        $from_label= date('F d,Y',strtotime($date_from));
        $to_label= date('F d,Y',strtotime($date_to));
        $invoice_label='Invoice Date from ' . $from_label .' to '. $to_label;
        

        $php_word  = new PHPWord();
        // Adding an empty Section to the document...
        $section_style=array( 'marginLeft'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5), 'marginRight'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.5), 'marginTop'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.25), 'marginBottom'=>\PhpOffice\PhpWord\Shared\Converter::inchToTwip(.25),'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2),'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2));

        $section_style2=['marginLeft' => 600, 'marginRight' => 600, 'marginTop' => 600, 'marginBottom' => 600];
        $section = $php_word->addSection($section_style2);

        //header
        $header = $section->createHeader();
        $header->addImage('images/tic_inline_logo.png',['marginTop' => 0, 'width'=>'500', 'marginLeft' => -1]);

        //footer
        $footer = $section->createFooter();
        $footer->addText('The Inspection Company Limited',['align'=>'center','spaceAfter' => 0,'size' => 10,'color'=>'FF4500'],['align'=>'center','color'=>'FF4500']);
        $footer->addText('Level 12, Infinitus Plaza, 199 Des Voeux Road Central, Sheung Wan, Hong Kong.',['align'=>'center','spaceAfter' => 0,'size' => 10],['align'=>'center']);
        $footer->addText('Phone: +852-3796 3305 Fax: +852-3796 3000',['align'=>'center','spaceAfter' => 0,'size' => 10],['align'=>'center']);
        $footer->addPreserveText('{PAGE}',['align'=>'right','spaceAfter' => 0,'size' => 10],['align'=>'right']);

        $table_style = ['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50];
        $inv_table_style = ['borderSize' => 1, 'borderColor' => '000000', 'cellMargin' => 50];

        $header_style = ['color'=>'000000','alignment'=>\PhpOffice\PhpWord\SimpleType\JcTable::CENTER];
        //left style
        $label_style_l_pay = ['align'=>'left','spaceAfter' => 0,'size' => 11];
        $label_style_l = ['align'=>'left','spaceAfter' => 0,'size' => 12];
        $cell_style_l = ['align'=>'left','spaceAfter' => 0];
        //right style
        $label_style_r = ['align'=>'right','spaceAfter' => 0,'size' => 12];
        $cell_style_r = ['align'=>'right','spaceAfter' => 0];
        //center style
        $label_style_c = ['align'=>'center','spaceAfter' => 0,'size' => 12];
        $cell_style_c = ['align'=>'center','spaceAfter' => 0];

        $invoice_style_right = ['bold'=>true,'align'=>'right','spaceAfter' => 0,'size' => 14];
        $table_cell_normal = ['valign' => 'center','color'=>'000000','size' => 12];
        $remove_cell_bottom_padding = ['spaceAfter' => 0];
        $header_text_style= ['color'=>'FFFFFF', 'size' => 12];
        $table_header_cell_style =['gridSpan'=>'4','bgColor'=>'909090'];
        $align_center=['align' => 'center'];

        //invoice address
        $invtable = $section->addTable('Invoice Address');
        $invtable->addRow(50);
        $invtable->addCell(8000, ['align' => 'center'])->addText('The Inspection Company 199 Des Voeux Road Sheung Wan HK', $label_style_l,$cell_style_l);
        $invtable->addCell(4000, ['align' => 'center'])->addText('Invoice', $invoice_style_right,$cell_style_r);
        $invtable->addRow(200);
        $invtable->addCell(8000, ['align' => 'center'])->addText($get_com_name, $label_style_l,$cell_style_l);
        $invtable->addCell(4000, ['align' => 'center'])->addText('Date: '.$date_now, $label_style_r,$cell_style_r);
        $invtable->addRow(50);

        if($inv_addr1==','){
            $invtable->addCell(8000, ['align' => 'center'])->addText($inv_addr2, $label_style_l,$cell_style_l);
            $invtable->addCell(4000, ['align' => 'center'])->addText('Invoice #: '.$inv_number, $label_style_r,$cell_style_r);
        }else{
            $invtable->addCell(8000, ['align' => 'center'])->addText($inv_addr1, $label_style_l,$cell_style_l);
            $invtable->addCell(4000, ['align' => 'center'])->addText('Invoice #: '.$inv_number, $label_style_r,$cell_style_r);
            $invtable->addRow(50);
            $invtable->addCell(12000, ['align' => 'center'])->addText($inv_addr2, $label_style_l,$cell_style_l);
        }
        
        
        $section->addTextBreak();

        //label
        $invtable = $section->addTable('Invoice Label');
        $invtable->addRow(50);
        $invtable->addCell(12000, ['align' => 'center'])->addText($invoice_label, $label_style_c,$cell_style_c);

        $section->addTextBreak();
        
        //description table
        $php_word->addTableStyle('Description Table', $table_style);
        $gentable = $section->addTable('Description Table');
        $gentable->addRow(50);
        $gentable->addCell(6000, ['align' => 'center'])->addText('Description', $label_style_c,$cell_style_c);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Manday', $label_style_c,$cell_style_c);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Price in '.strtoupper($client_cost->currency), $label_style_c,$cell_style_c);
        $gentable->addCell(2000, ['align' => 'center'])->addText('Total in '.strtoupper($client_cost->currency), $label_style_c,$cell_style_c);
        $over_all_total_cost=0;
        foreach($cost_details as $d_cost){
            $total_cost=0;
            $get_curr= strtoupper($d_cost->currency);
            $set_curr=$currency[$d_cost->currency];
            $md= $d_cost->md_charges;
            $travel=$d_cost->travel_cost;
            $hotel=$d_cost->hotel_cost;
            $ot=$d_cost->ot_cost;
            $total_cost=$total_cost+$md+$travel+$hotel+$ot;
            $other=$d_cost->other_cost_value;
            $get_other_cost=0;
            if($other){
                $exp_other = explode(',', $other);
                if($exp_other){
                    foreach($exp_other as $oth_cost){
                        $total_cost+=$oth_cost;
                        $get_other_cost+=$oth_cost;
                    }
                }
            }
            $cost=$set_curr."".$total_cost;
           
            //inspection details
            $client= htmlspecialchars($d_cost->Company_Name);
            $manday = $d_cost->manday; 

            $md_cost=$set_curr."".$md;
            $total_manday_cost=$md*$manday;
            $total_md_cost=$set_curr."".$total_manday_cost;
            $over_all_total_cost+=$total_manday_cost;

            $services = ['iqi'=>'Incoming Quality Inspection', 
                'dupro' => 'During Production Inspection',
                'psi' => 'Pre Shipment Inspection',
                'cli' => 'Container Loading Inspection',
                'pls' => 'Setting Up Production Lines',
                'st' => 'Sample Test',
                'cbpi' => 'CBPI - No Serial',
                'cbpi_serial' => 'CBPI - with Serial',
                'cbpi_isce' => 'CBPI - ISCE',
                'site_visit' => 'Site Visit',
                'physical' => 'Factory Audit',
                'SPK' => 'SPK',
                'FRI' => 'FRI',         
            ];
            $service=$d_cost->service;
            $ins_date= date('F d',strtotime($d_cost->inspection_date));
            $ins_refnum=htmlspecialchars($d_cost->reference_number);
           

            $products=PSIProduct::where('inspection_id',$d_cost->inspection_id)->get();
            $p_name="";
            foreach($products as $product){
                $p_name.=$product->product_name;
            }
            $factory=Factory::where('id',$d_cost->factory)->first();
            $f_name="";
            if($factory){
                $f_name=htmlspecialchars($factory->factory_name);
            }
            
            $description=$services[$service].' on '.$ins_date.' '.$ins_refnum.', '.$p_name.', '.$f_name;
            //$description=$services[$service].' on '.$ins_date.' '.$ins_refnum.', '.$p_name;
            $gentable->addRow(50);
            $gentable->addCell(6000, ['align' => 'center'])->addText($description, $label_style_c,$cell_style_c);
            $gentable->addCell(2000, ['align' => 'center'])->addText($manday, $label_style_c,$cell_style_c);
            $gentable->addCell(2000, ['align' => 'center'])->addText($md_cost, $label_style_c,$cell_style_c);
            $gentable->addCell(2000, ['align' => 'center'])->addText($total_md_cost, $label_style_c,$cell_style_c);     
            //other cost
            $travel_description="";
            $travel_sub_total=$travel+$hotel+$ot+$get_other_cost;
            $travel_total=0;
            if($travel_sub_total!='' || $travel_sub_total!='0' || $travel_sub_total!=0 ){
                $t_desc=""; $hotel_desc=""; $ot_desc=""; $other_desc="";
                if($travel!='' || $travel!='0' || $travel!=0){
                    $t_desc="Travel Cost,";
                }
                if($hotel!='' || $hotel!='0' || $hotel!=0){
                    $hotel_desc="Hotel Cost,";
                }
                if($ot!='' || $ot!='0' || $ot!=0){
                    $ot_desc="OT Cost,";
                }
                if($other!=''){
                    $other_desc="Other Cost";
                }
                $travel_description=$t_desc." ".$hotel_desc." ".$ot_desc." ".$other_desc;
                $travel_total=$travel_sub_total*$manday;
                $gentable->addRow(50);
                $gentable->addCell(6000, ['align' => 'center'])->addText($travel_description, $label_style_c,$cell_style_c);
                $gentable->addCell(2000, ['align' => 'center'])->addText($manday, $label_style_c,$cell_style_c);
                $gentable->addCell(2000, ['align' => 'center'])->addText($set_curr."".$travel_sub_total, $label_style_c,$cell_style_c);
                $gentable->addCell(2000, ['align' => 'center'])->addText($set_curr."".$travel_total, $label_style_c,$cell_style_c); 
                $over_all_total_cost+=$travel_total;    
            }
        }
        $over_all_cost=$currency[$client_cost->currency].$over_all_total_cost;
        $gentable->addRow(50);
        $gentable->addCell(10000, ['gridSpan'=>'3', 'align' => 'center'])->addText('Total Amount: ', $label_style_r,$cell_style_r);
        $gentable->addCell(2000, ['align' => 'center'])->addText($over_all_cost, $label_style_c,$cell_style_c);
        $section->addTextBreak();

        //payable box
        $textrun = $section->addTextRun($table_style);
        $textrun->addTextBreak();
        $textrun->addText($payable_date,$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText("  To: \t \t \t HSBC Hong Kong",$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText("  Bank Address: \t 1 Queens Road Central, Hong Kong",$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText("  In Favor of: \t \t The Inspection Company Limited",$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText("  Account Number: \t 640-047858-838",$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText("  Swift Code: \t \t HSBCHKHHHKH",$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText("  Bank Code: \t \t 004",$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText('  Or small amount to Paypal (need add total amount 4.4% paypal fee): paypal@t-i-c.asia',$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText('  Bank Charges policy:',$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText('  TIC pays for its local bank charges',$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText('  Clients pay for their own local bank charges as well as an intermediary charges',$label_style_l_pay);
        $textrun->addTextBreak();
        $textrun->addText('  (if their bank has chosen an intermediary to process the payment)',$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText('  We will issue a Debit Note if these charges are deducted from the remitted amount.',$label_style_l_pay);
        $textrun->addTextBreak(2);
        $textrun->addText('  For payment tracking purposes, please mention clearly your Invoice Number on your Transfer Order.',$label_style_l_pay);

        

        //save to server
        $objWriter2 = \PhpOffice\PhpWord\IOFactory::createWriter($php_word, 'Word2007');
        $save_path="invoice/$client_code/";
        if (!File::isDirectory($save_path)) {
            File::makeDirectory($save_path, 0777, true, true);
        }
        $objWriter2->save($save_path.$file_name_server);        

        return response()->download($save_path.$file_name_server);

    }



}
