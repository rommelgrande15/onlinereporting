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


class ServerSideReportsController extends Controller
{
    private $reports_path;
	
	public function __construct() {
		$this->reports_path = public_path('reviewer-reports');
	
	} 

    public function viewInspectionLists(){            
    	$user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $reviewers = UserInfo::select('id','name','email_address')->where('designation','reports_review')->orderBy('name')->get();
		return view('pages.reportsReviewer.inspection_list',compact('user_info','user','reviewers'));    	
    }


    //Dec 10, 2018 
    public function getInspectionsList(Request $request){
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
                            0 => 'client',
                            1 => 'inspection_type',
                            2 =>'service',
                            3 =>'reference_number',
							4 => 'inspector_name',						
                            5 => 'created_by',
                            6 => 'inspection_date',
                            7 => 'status',
                            8 => 'action',
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
        }else{
            $search = $request->input('search.value'); 

            $inspection_temp = DB::table('all_inspections')   
                    ->where('reference_number','LIKE',"%{$search}%")
                    ->orWhere('service','LIKE',"%{$search}%")
                    ->orWhere('inspector_name','LIKE',"%{$search}%")
                    ->orWhere('user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('client','LIKE',"%{$search}%")                    
                    ->orWhere('inspection_date','LIKE',"%{$search}%")    
                    ->orWhere('inspection_status','LIKE',"%{$search}%")                         
                    ->orderBy($order,$dir)            
                    ->get();
            $inspection = DB::table('all_inspections')
                    ->where('reference_number','LIKE',"%{$search}%")
                    ->orWhere('service','LIKE',"%{$search}%")
                    ->orWhere('inspector_name','LIKE',"%{$search}%")
                    ->orWhere('user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('client','LIKE',"%{$search}%")                    
                    ->orWhere('inspection_date','LIKE',"%{$search}%")    
                    ->orWhere('inspection_status','LIKE',"%{$search}%")             
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
                $inspect_client_type="";
                if($ins->inspection_type=='tic_sera' || $ins->inspection_type=='tic-sera'){
                    $inspect_client_type="TIC-SERA";
                }else{
                    $inspect_client_type="TIC";
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
                    $nestedData['inspection_type'] = $inspect_client_type;      
                    $nestedData['service'] = strtoupper($ins->service);
                    $nestedData['reference_number'] = $ins->reference_number;
                    $nestedData['inspector_name'] = $ins->inspector_name;			
                    $nestedData['created_by'] = ucfirst($ins->user_created_by);    
                    $nestedData['inspection_date'] = $ins_date;       
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
                        $nestedData['inspection_type'] = $inspect_client_type;     
                        $nestedData['service'] = strtoupper($ins->service);
                        $nestedData['reference_number'] = $ins->reference_number;
                        $nestedData['inspector_name'] = $ins->inspector_name;			
                        $nestedData['created_by'] = ucfirst($ins->user_created_by);    
                        $nestedData['inspection_date'] = $inspec_date;     
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
                            0=> 'inspector_name',
                            1=> 'client',
                            2=> 'created_by',
                            3 =>'service', 
                            4 =>'product_name',
                            5=> 'po_no',
                            6=> 'inspection_date',
                            7=> 'status',
                            8=> 'action',
                        );
        $inspect_count = Inspection::whereNotNull('inspections.client_book_id')->whereNull('inspections.inspection_type')->get();

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
            $inspection = DB::table('tic_inspections')                               
                    ->orderBy($order,$dir)    
                    ->offset($start)
                    ->limit($limit)                
                    ->get();
        }else{
            $search = $request->input('search.value'); 

            $inspection_temp = DB::table('tic_inspections')  
                    ->where('p_name','LIKE',"%{$search}%") 
                    ->orWhere('po','LIKE',"%{$search}%") 
                    ->orWhere('inspector_name','LIKE',"%{$search}%")
                    ->orWhere('user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('client','LIKE',"%{$search}%")
                    ->orWhere('inspection_date','LIKE',"%{$search}%")   
                    ->orWhere('inspection_status','LIKE',"%{$search}%")                            
                    ->orderBy($order,$dir)        
                    ->get();
            $inspection = DB::table('tic_inspections')
                    ->where('p_name','LIKE',"%{$search}%") 
                    ->orWhere('po','LIKE',"%{$search}%") 
                    ->orWhere('inspector_name','LIKE',"%{$search}%")
                    ->orWhere('user_created_by','LIKE',"%{$search}%") 
                    ->orWhere('client','LIKE',"%{$search}%")
                    ->orWhere('inspection_date','LIKE',"%{$search}%")    
                    ->orWhere('inspection_status','LIKE',"%{$search}%")                               
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
                $nestedData['service'] = $services[$ins->service];
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
                            3 =>'service', 
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
                $nestedData['service'] = $services[$ins->service];
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





}
