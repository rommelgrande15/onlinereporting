<?php
namespace App\Http\Controllers;
use App\ClientContact;
use App\Country;
use App\Factory;
use App\FctoryContact;
use App\Template;
use App\UserInfo;
use App\ProductPhoto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Report;
use App\Inspection;
use App\Client;
use App\InspectionInfo;
use App\Checklist;
use App\Supplier;
use App\Cargo;
use App\Product;
use App\PSIProduct;
use App\DetailedProduct;
use App\DetailedProductQty;
use App\Observation;
use App\Loading;
use App\DetailedPhoto;
use App\DetailedPhotoDescription;
use App\Geolocation;
use App\Answer;
use App\ReportUpdate;
use App\SupplierContact;
use App\ClientAqlDetail;
use App\Category;
use App\SubCategory;
use App\Role;
use App\ClientAqlMinor;
use App\ClientAqlMajor;
use App\Attachment;
use App\InspectorAddress;
use App\ClientCost;
use App\InspectorCost;
use App\ProductPhotos;
use App\SavedProductCategories;
use App\SavedProductSubCategories;
use Illuminate\Support\Facades\File;
use Mail;


use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;


class APIController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('jwt.auth',['except' => ['postApplogin', 'pingServer']]);
    }

	public function getAppLogin(){
		return view('api.login');
	}
	
    public function postApplogin(Request $request){

        $credentials = $request->only('username','password');
        try{
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'],401);
            }
        }catch(JWTException $e){
            return response()->json(['error' => 'Could not create token'],500);
        }
        return response()->json(compact('token'), 200);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
		$user = collect($user)->except(['password', 'plain', 'remember_token', 'confirmation_code']);
        return response()->json(compact('user'));
    }

    public function index(){
        $users = User::all();
        return response()->json(compact('users'));
    }

    public function downloadBlankReport(Request $request){
        try {
            if (! $report = Report::where('report_no', $request['report_no'])->where('password',$request['password'])->first() ) {
                return response()->json(['Report not found'], 404);
            }
        } catch (Exception $e) {
             return response()->json(['Invalid details provided'], $e->getStatusCode());
        }
        
        $inspection = Inspection::where('id',$report->inspection_id)->first();
        $client = Client::where('client_code', $inspection->client_id)->first();
        $client_contact = ClientContact::where('id', $inspection->contact_person)->first();
        $inspector = UserInfo::where('user_id', $inspection->inspector_id)->first();
		if($inspection->factory){
			$factory = Factory::where('id', $inspection->factory)->first();
			$factory_contact = FctoryContact::where('id', $inspection->factory_contact_person)->first();
			$factory->factory_country = Country::where('id', $factory->factory_country)->first()->nicename;
		} else {
			$factory = new Factory();
			$factory->factory_name = "";
			$factory->factory_address = $inspection->comp_addr;
			$factory->factory_city = "";
			$factory->factory_country = "";
			$factory_contact = new FctoryContact();
			$factory_contact->factory_contact_person = "";
			$factory_contact->factory_contact_number = "";
			$factory_contact->factory_contact_email = "";
			
		}
		if($inspection->supplier_id && $inspection->supplier_id != 0) {
			$supplier = Supplier::where('id', $inspection->supplier_id)->first();
			$supplier_contact = SupplierContact::where('id', $inspection->supplier_contact_id)->first();
		}else{
			$supplier = new Supplier();
			$supplier->supplier_number = "";
			$supplier->supplier_address_local = "";
			$supplier->supplier_code = "";
			$supplier->supplier_address = "";
			$supplier_contact = new SupplierContact();
			$supplier_contact->supplier_contact_person = "";
			$supplier_contact->supplier_contact_number = "";
			$supplier_contact->supplier_email = "";
		}
		$inspection->supplier_name = $supplier->supplier_name;
		$supplier_contact->supplier_contact_phone = $supplier_contact->supplier_contact_number;
        $products = DB::table('p_s_i_products')->where('inspection_id', $report->inspection_id)->get();
		if($products->count() == 1) {
			if($products->first()->product_id){
				$prod = Product::find($products->first()->product_id);
				$supplier->supplier_number = $prod->supplier_item_no;
			}
		}
		
        $items = @json_decode(Template::where('id', $inspection->template_id)->first()->items);

        return response()->json(compact('inspection','report','client','client_contact','inspector','factory','factory_contact','products','items','supplier', 'supplier_contact'));
    }
	
	public function pingServer()
    {
        return response()->json(['ok'], 200);
    }
	
	public function getClientInformation(Request $request)
	{
        $user_info = UserInfo::where('user_id',$request['user']['id'])->first();
        $user = User::where('id',$request['user']['id'])->first();
        $client_code=$user_info->client_code;
		$client = Client::where('client_code',$client_code)->first();
		$aql_preset = ClientAqlDetail::where('client_id',$request['user']['id'])->first();

        $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('clients.client_code',$client_code)
                    ->where('inspections.inspection_status','<>','Deleted')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->get();
		
		return response()->json(compact('inspections','user_info', 'user', 'client', 'aql_preset'));
	}
	
	public function getInspectionDetails($id){
        $inspection = DB::table('inspections')
                        ->where('id',$id)                    
                        ->first(); 
						
        $factory = Factory::where('id',$inspection->factory)->first();
        $client_contact_list=array();
        $client_contact=explode(',',$inspection->contact_person);

        foreach($client_contact as $contact){
            $data = ClientContact::where('id',$contact)->first();
            array_push($client_contact_list,$data);
        }

        $factory_contact_list=array();
        $factory_contact=explode(',',$inspection->factory_contact_person2);
        foreach($factory_contact as $contact){
            $data = FctoryContact::where('id',$contact)->first();
			if($data)
				array_push($factory_contact_list,$data);
        }

        $factory_contact1 = FctoryContact::where('id',$inspection->factory_contact_person)->first();

        $psi_product = DB::table('p_s_i_products')
                    ->where('inspection_id',$id)
                    ->get(); 
        $attachments =  DB::table('attachments')
                    ->where('inspection_id',$id)                    
                    ->get(); 

        return response()->json([
            'inspection' => $inspection,
            'attachments'=> $attachments,
            'client_contact_list'=>$client_contact_list,
            'factory'=>$factory,
            'factory_contact_list'=>$factory_contact_list,
            'factory_contact1'=>$factory_contact1,
            'psi_product'=>$psi_product,
        ]);
    }
	
	public function inspectionTracking($id){
		$geo = null;
		$start_time = 'Pending..';
		$end_time = 'Pending..';
		$render = [];
		if($id){
			$geo = Geolocation::where('inspection_id', $id)->orderBy('timestamp', 'Desc')->first();
			$report = Report::select('id')->where('inspection_id', $id)->first();
			if($report){
				$answer = Answer::where('report_id', $report->id)->orderBy('created_at', 'Asc')->first();
				if($answer){
					$end_time = $answer->created_at->setTimezone('Asia/Hong_Kong')->addHours(8)->toDayDateTimeString() . (' (Asia/Hong_Kong)');
				} 
			}
			$geo_start = Geolocation::where('inspection_id', $id)->orderBy('timestamp', 'Asc')->first();
			if($geo_start){
				$dt = Carbon::now('Asia/Hong_Kong');
				$dt->timestamp($geo_start->timestamp/1000);
				$start_time = $dt->toDayDateTimeString() . (' (Asia/Hong_Kong)');
			}
			$template_id = Inspection::select('template_id')->where('id', $id)->first();
			if($template_id){
				$sections = Template::select('items')->where('id', $template_id->template_id)->first();
				if($sections){
					$sections = collect(json_decode($sections->items))->pluck('title');
					$report_status = collect(json_decode(ReportUpdate::select('section')->where('inspection_id', $id)->get()))->pluck('section')->toArray();
					$render = $sections->map(function($section) use ($report_status, $end_time){
						if($end_time != 'Pending..'){
							return [ 'section' => $section, 'status' => 'completed' ];
						}
							
						if(in_array($section, $report_status)){
							return [ 'section' => $section, 'status' => 'completed' ];
						}
						
						return [ 'section' => $section, 'status' => 'on-going' ];
					});
				}
			}
			$response = [
				'geo' => $geo,
				'template' => $render,
				'start_time' => $start_time,
				'end_time' => $end_time,
			];
			return response()->json($response, 200);
		} else {
			return response()->json([ 'error' => 'inspection id not found' ], 200);
		}
	}
	
	public function getContactPerson($code){
		return ClientContact::where('client_code',$code)->get();
	}
	
	public function getSupplier($code){
		return Supplier::where('supplier_status','!=',2)->where('client_code',$code)->orderBy('supplier_name', 'asc')->get();
	}
	
	public function getSupplierContact($supplier_id){
		return SupplierContact::where('supplier_id',$supplier_id)->where('supplier_contact_status',0)->get();
	}
	
	public function getFactory($supplier_id){
		return Factory::where('supplier_id',$supplier_id)->get();
	}
	
	public function getAllFactory($code){
		return Factory::where('client_code',$code)->get();
	}
	
	public function getFctoryContact($factory_id){
		return FctoryContact::where('factory_id',$factory_id)->where('factory_contact_status',0)->get();
	}
	
	public function getProducts($code){
		return Product::with('photos')->where('client_code',$code)->where('status',0)->orderBy('product_name', 'asc')->get();
	}
	
	public function createBooking(Request $request) {
        try {
			$year=date("y");
			$month=date("m");
			$set_count=Inspection::where('client_id',$request['client'])->count()+1;
			if($set_count<10) $set_count='0'.$set_count;
			$ref_num=$request['client'].'-'.$year.''.$month.'-'.$set_count;
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
            $inspection->reference_number = $ref_num;
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

            
            $inspection->inspection_status = "Client Pending";
            $inspection->client_book = "true";
            $inspection->client_book_id =  Auth::id();
            $inspection->created_by =  Auth::id();

            $email_po_number="";

            if($request['invisible'] == "on"){
                $inspection->Clientstatus = '1';
            }

            if ($inspection->save()) {
				if($request['service'] != 'cli'){
					$products = $request['products'];
					foreach ($products as $product) {
						$prods = new PSIProduct();
						$prods->inspection_id = $inspection->id;
						$prods->product_id = $product['id'];
						$prods->product_name = $product['product_name'];
						$prods->product_first_category = $product['product_category'];
						$prods->product_category = $product['product_sub_category'];
						$prods->brand = $product['brand'];
						$prods->po_no = $product['po_number'];
						$prods->model_no = $product['model_no'];
						$prods->aql_qty = $product['qty']['aql_qty'];
						$prods->aql_qty_unit = $product['qty']['quantity_unit'];
						$prods->aql_normal_level = $product['qty']['aql_normal_level'];
						$prods->aql_special_level = $product['qty']['aql_special_level'];
						$prods->aql_major = $product['qty']['aql_major'];
						$prods->max_allowed_major = $product['qty']['max_major'];
						$prods->aql_minor = $product['qty']['aql_minor'];
						$prods->max_allowed_minor = $product['qty']['max_minor'];
						$prods->aql_normal_letter = $product['qty']['aql_normal_letter'];
						$prods->aql_normal_sampsize = $product['qty']['aql_normal_sampsize'];
						$prods->aql_special_letter = $product['qty']['aql_special_letter'];
						$prods->aql_special_sampsize = $product['qty']['aql_special_sampsize'];
						$prods->product_length = $product['product_length'];
						$prods->product_width = $product['product_width'];
						$prods->product_height = $product['product_height'];
						$prods->product_diameter = $product['product_diameter'];
						$prods->product_weight = $product['product_weight'];
						$prods->retail_length = $product['retail_length'];
						$prods->retail_width = $product['retail_width'];
						$prods->retail_height = $product['retail_height'];
						$prods->retail_diameter = $product['retail_diameter'];
						$prods->retail_weight = $product['retail_weight'];
						$prods->retail_box_qty = $product['retail_box_qty'];
						$prods->inner_length = $product['inner_length'];
						$prods->inner_width = $product['inner_width'];
						$prods->inner_height = $product['inner_height'];
						$prods->inner_diameter = $product['inner_diameter'];
						$prods->inner_weight = $product['inner_weight'];
						$prods->inner_box_qty = $product['inner_box_qty'];
						$prods->export_length = $product['export_length'];
						$prods->export_width = $product['export_width'];
						$prods->export_height = $product['export_height'];
						$prods->export_diameter = $product['export_diameter'];
						$prods->export_weight = $product['export_weight'];
						$prods->export_box_qty = $product['export_box_qty'];
						$prods->export_max_weight_carton = $product['export_max_weight_carton'];
						$prods->export_cbm = $product['export_cbm']; 
						$prods->grd = $product['grd'];
						$prods->item_description = $product['item_description'];
						$prods->additional_product_info = $product['additional_product_info'];
						$prods->save();
					}
				}
                
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

                $client = Client::where('client_code',$request['client'])->first();
             
                $password = mt_rand(100000, 999999);
                $report_no = $ref_num;

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
                    $psi_product_list=null;
                    $factory = Factory::where('id',$request['factory'])->first();
                    $factory_cont = FctoryContact::where('id',$request['factory_contact_person'])->first();
                    $data = ['report_number' =>  $report_no,
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
                            'file_passed'=>[],
                            'products_id'=>[],
							'client_email'=>$client_info->email_address,
							'dear_client'=>$client_info->name,
							'requirement'=>$request['requirement'],
                            'memo'=>$request['memo'],
							'user_type'=>$client_info->user_type
                        ];
					Mail::send('email.book_from_client',$data, function($message) use ($data){
						if($data['client_email']){
							$message->to($data['client_email'],$data['c_name']);
						}else{
							$message->to('booking@t-i-c.asia','Booking');
						}
						$message->to('booking@t-i-c.asia');
						$message->cc('rommel@t-i-c.asia');
						$message->cc('manuel@t-i-c.asia');
						$message->cc('jesser@t-i-c.asia');
						$message->cc('gregor@t-i-c.asia');             
						$message->subject("Client book an inspection");  
						/*if($data['file_passed']){ 
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
										$message->attach($p_src);
									}   
								}
							}       
						}*/                       
					});               

					return response()->json([
						'message' => 'OK',
						'inspection_id' => $inserted_inspection_id,
						'reference_number' => $ref_num,
					],200);
                }
            }
            
        } catch (Exception $e) {
             return response()->json([
                'message'=>$e->getMessage()
            ],500);
        }
	}
	
	public function uploadAttachments(Request $request){
		if($request->file('file')){
			try{
				$file = $request->file('file');
				$filename = $file->getClientOriginalName();                    
				$dir="images/project2/".$request['inspection_id']."/";
				
				if (!File::exists($dir)) {
					File::makeDirectory($dir);
				}
				
				$file->move($dir,$filename);

				$doc= new Attachment();
				$doc->inspection_id = $request['inspection_id'];
				$doc->project_number = $request['reference_number'];
				$doc->file_name = $filename;
				$doc->file_size = $file->getSize();
				$doc->path = $dir.$filename;
				$doc->save();
				
				return response()->json([
					'message' => 'OK'
				],200);
			} catch (Exception $e) {
				 return response()->json([
					'message'=>$e->getMessage()
				],500);
			}
			
		}
	}
	
	public function updateAccountDetails(Request $request) {
		$user  = User::where('id', $request['id'])->first();
		$user_info = UserInfo::where('user_id',$request['id'])->first();
		$email = $request['username'];
		$fullname = $request['fullname'];
		$password = $request['password'];
		
		if($user->email != $email){
			$count = User::where('email','=',$email)
			->where('id', '!=', $request['id'])
			->count();
			if($count<=0){
				$user->username = $email;
				$user->email = $email;
				$user->update();
			} else {
				return response()->json([
					'message' => 'Email entered is not available',
				]);
			}
		}
		
		$user_info->name = $fullname;
		$user_info->update();
				
		if($password){
			$user->password = bcrypt($password);
			$user->plain = $password;
			$user->update();
		}
		
        $client_code=$user_info->client_code;
		$client = Client::where('client_code',$client_code)->first();
		$aql_preset = ClientAqlDetail::where('client_id',$request['id'])->first();

        $inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('clients.client_code',$client_code)
                    ->where('inspections.inspection_status','<>','Deleted')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->get();
		
		return response()->json(compact('inspections','user_info', 'user', 'client', 'aql_preset'));
	}
	
	public function updateCompanyDetails(Request $request) {
		$user  = User::where('id', $request['id'])->first();
		$user_info = UserInfo::where('user_id',$request['id'])->first();
		$aql_preset = ClientAqlDetail::where('client_id',$request['id'])->first();
		$client_code=$user_info->client_code;
		$client = Client::where('client_code',$client_code)->first();

		$client->company_name = $request->input('company_name');
		$client->Company_Email = $request->input('Company_Email');
		$client->Phone_number = $request->input('Phone_number');
		$client->company_country_name = $request->input('company_country_name');
		$client->company_country_id = $request->input('company_country_id');
		$client->company_state_name = $request->input('company_state_name');
		$client->company_city_name = $request->input('company_city_name');
		$client->company_zip_code = $request->input('company_zip_code');
		$client->company_house_num = $request->input('company_house_num');
		$client->company_bldg_num = $request->input('company_bldg_num');
		$client->company_street_num = $request->input('company_street_num');

		$client->save();
		
		$inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('clients.client_code',$client_code)
                    ->where('inspections.inspection_status','<>','Deleted')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->get();
		
		return response()->json(compact('inspections','user_info', 'user', 'client', 'aql_preset'));
	}
	public function updateInvoiceDetails(Request $request) {
		$user  = User::where('id', $request['id'])->first();
		$user_info = UserInfo::where('user_id',$request['id'])->first();
		$aql_preset = ClientAqlDetail::where('client_id',$request['id'])->first();
		$client_code=$user_info->client_code;
		$client = Client::where('client_code',$client_code)->first();
		
		$client->company_invoice_country_name = $request->input('company_invoice_country_name');
		$client->company_invoice_country_id = $request->input('company_invoice_country_id');
		$client->company_invoice_city_name = $request->input('company_invoice_city_name');
		$client->company_inv_zip_code = $request->input('company_inv_zip_code');
		$client->company_inv_house_num = $request->input('company_inv_house_num');
		$client->company_inv_bldg_num = $request->input('company_inv_bldg_num');
		$client->company_inv_street_num = $request->input('company_inv_street_num');
			
		$client->save();
		
		$inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('clients.client_code',$client_code)
                    ->where('inspections.inspection_status','<>','Deleted')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->get();
		
		return response()->json(compact('inspections','user_info', 'user', 'client', 'aql_preset'));
	}
	public function updateAqlDetails(Request $request) {
		$user  = User::where('id', $request['id'])->first();
		$user_info = UserInfo::where('user_id',$request['id'])->first();
		$aql_preset = ClientAqlDetail::where('client_id',$request['id'])->first();
		$client_code=$user_info->client_code;
		$client = Client::where('client_code',$client_code)->first();
		
		$aql_preset->aql_major = $request->input('aql_major');
		$aql_preset->aql_minor = $request->input('aql_minor');
		$aql_preset->normal_level = $request->input('aql_normal_level');
		$aql_preset->special_level = $request->input('aql_special_level');
			
		$aql_preset->save();
		
		$inspections = DB::table('inspections')
                    ->join('clients','clients.client_code','=','inspections.client_id')
                    ->join('reports','inspections.id', '=', 'reports.inspection_id')
                    ->join('factories','inspections.factory', '=', 'factories.id') 
                    ->select('reports.report_no','reports.password','clients.client_name','inspections.service','inspections.id','inspections.inspection_date','inspections.created_at','inspections.created_by','inspections.client_project_number','inspections.inspection_status','inspections.inspector_id','factories.factory_name')
                    ->where('clients.client_code',$client_code)
                    ->where('inspections.inspection_status','<>','Deleted')
                    ->orderBy('inspections.inspection_date', 'desc')
                    ->get();
		
		return response()->json(compact('inspections','user_info', 'user', 'client', 'aql_preset'));
	}
	
	public function saveClientContact(Request $request){
		$c_person = $request['contact_person'];
        $cc=$request['client_code'];
 
		if($request['type'] == 'Add')
			$client = new ClientContact();
		else
			$client = ClientContact::find($request['id']);
		
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
		
		return response()->json(['message' => 'OK'],200);
	}
	
	public function deleteClientContact(Request $request){
		$client = ClientContact::find($request['id']);
		$code = $client->client_code;
		$client->delete();
		
		return ClientContact::where('client_code',$code)->get();
	}
	
	public function saveClientSupplier(Request $request){
		if($request['type'] == 'Add')
			$supplier = new Supplier();
		else
			$supplier = Supplier::find($request['id']);
			
        $supplier->client_code = $request['client_code'];
        $supplier->supplier_name = $request['supplier_name'];
        $supplier->supplier_number = $request['supplier_number'];
		$supplier->supplier_code = $request['supplier_number'];
        
        $supplier->supplier_address_local = $request['supplier_local_address'];
        $supplier->supplier_country = $request['supplier_country'];
        $supplier->supplier_country_name = $request['supplier_country_name'];
        $supplier->supplier_state = $request['supplier_state'];

        $supplier->supplier_city = $request['supplier_city'];
        $supplier->supplier_address = $request['supplier_address'];
        $supplier->supplier_local_address = $request['supplier_local_address'];
        $supplier->supplier_local_city = $request['supplier_local_city'];
        $supplier->supplier_status = 0;

        if ($supplier->save()) {
            $lastInsertId= $supplier->id;
			
			
			foreach ($request['supplierContacts'] as $cont) {
				if($request['type'] == 'Add' || !array_key_exists('id', $cont))
					$contact = new SupplierContact();
				else
					$contact = SupplierContact::find($cont['id']);
				
				$contact->supplier_id = $lastInsertId;
				$contact->client_code = $request['client_code'];
				$contact->supplier_contact_person = $cont['contact_person'];
				$contact->supplier_email = $cont['contact_person_email'];
				$contact->supplier_contact_number = $cont['contact_person_number'];
				$contact->supplier_tel_number = $cont['c_person_tel_number'];
				$contact->supplier_contact_skype = $cont['supplier_contact_skype']?$cont['supplier_contact_skype']:'N/A';
				$contact->supplier_contact_wechat = $cont['supplier_contact_wechat']?$cont['supplier_contact_wechat']:'N/A';
				$contact->supplier_contact_whatsapp = $cont['supplier_contact_whatsapp']?$cont['supplier_contact_whatsapp']:'N/A';
				$contact->supplier_contact_qq = $cont['supplier_contact_qqmail']?$cont['supplier_contact_qqmail']:'N/A';
				$contact->supplier_contact_status = 0;
				$contact->save();
			}

            if($request['same_as_factory']=='true' && $request['type'] == 'Add'){
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
                $factory->factory_status = 0;
         
                if ($factory->save()) {
					foreach ($request['supplierContacts'] as $contact) {
						$factory_contact = new FctoryContact();
						$factory_contact->factory_id = $factory->id;
						$factory_contact->client_code = $request['client_code'];
						$factory_contact->factory_contact_person = $contact['contact_person'];
						$factory_contact->factory_email = $contact['contact_person_email'];
						$factory_contact->factory_contact_number = $contact['contact_person_number'];
						$factory_contact->factory_tel_number = $contact['c_person_tel_number'];
		 
						$factory_contact->factory_contact_skype = $contact['supplier_contact_skype']?$contact['supplier_contact_skype']:'N/A';
						$factory_contact->factory_contact_wechat = $contact['supplier_contact_wechat']?$contact['supplier_contact_wechat']:'N/A';
						$factory_contact->factory_contact_whatsapp = $contact['supplier_contact_whatsapp']?$contact['supplier_contact_whatsapp']:'N/A';
						$factory_contact->factory_contact_qq = $contact['supplier_contact_qqmail']?$contact['supplier_contact_qqmail']:'N/A';
						$factory_contact->factory_contact_status = 0;
						$factory_contact->save();
					}
                }
            }
        }
		
		return response()->json(['message' => 'OK'],200);
	}
	
	public function deleteClientSupplierContact(Request $request) {
		$contact = SupplierContact::find($request['id']);
		$contact->delete();
		
		return response()->json(['message' => 'OK'],200);
	}
	
	public function deleteClientFactoryContact(Request $request) {
		$contact = FctoryContact::find($request['id']);
		$contact->delete();
		
		return response()->json(['message' => 'OK'],200);
	}
	
	public function deleteClientSupplier(Request $request){
		$supplier = Supplier::find($request['id']);
		$supplier->delete();
		$contact = SupplierContact::find($request['contact_id']);
		$contact->delete();
		
		return response()->json(['message' => 'OK'],200);
	}
	
	public function saveClientFactory(Request $request){
		if($request['type'] == 'Add')
			$factory = new Factory();
		else
			$factory = Factory::find($request['id']);
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
		$factory->factory_status = 0;
 
		if ($factory->save()) {
			foreach ($request['factoryContacts'] as $cont) {
				if($request['type'] == 'Add' || !array_key_exists('id', $cont))
					$factory_contact = new FctoryContact();
				else
					$factory_contact = FctoryContact::find($cont['id']);
				
				$factory_contact->factory_id = $factory->id;
				$factory_contact->client_code = $request['client_code'];
				$factory_contact->factory_contact_person = $cont['contact_person'];
				$factory_contact->factory_email = $cont['contact_person_email'];
				$factory_contact->factory_contact_number = $cont['contact_person_number'];
				$factory_contact->factory_tel_number = $cont['c_person_tel_number'];

				$factory_contact->factory_contact_skype = $cont['factory_contact_skype']?$cont['factory_contact_skype']:'N/A';
				$factory_contact->factory_contact_wechat = $cont['factory_contact_wechat']?$cont['factory_contact_wechat']:'N/A';
				$factory_contact->factory_contact_whatsapp = $cont['factory_contact_whatsapp']?$cont['factory_contact_whatsapp']:'N/A';
				$factory_contact->factory_contact_qq = $cont['factory_contact_qqmail']?$cont['factory_contact_qqmail']:'N/A';
				$factory_contact->factory_contact_status = 0;
				$factory_contact->save();
			}
		}
		return response()->json(['message' => 'OK'],200);
	}
	
	public function deleteClientFactory(Request $request){
		$factory = Factory::find($request['id']);
		$factory->delete();
		$contact = FctoryContact::find($request['contact_id']);
		$contact->delete();
		
		return response()->json(['message' => 'OK'],200);
	}
	
	public function saveClientProduct(Request $request) {
		if($request['type'] == 'Add')
			$product = new Product();
		else
			$product = Product::find($request['id']);
		
		$product->client_code = $request['client_code'];
        $product->product_name = $request['product_name'];
        $product->product_category = $request['product_category'];
        $product->product_sub_category = $request['product_sub_category'];
        $product->product_unit = $request['product_unit'];
        $product->product_number = $request['product_number'];
		
		if($request['product_category'] == 'Others') {
			$category = new SavedProductCategories();
			$category->user_id = $request['user_id'];
			$category->category = $request['product_category_other'];
			$category->save();
			$sub_category = new SavedProductSubCategories();
			$sub_category->user_id = $request['user_id'];
			$sub_category->category_id = $category->id;
			$sub_category->category = $request['product_category_other'];
			$sub_category->sub_category = $request['product_sub_category_other'];
			$sub_category->save();
			$product->product_category = $request['product_category_other'];
			$product->product_sub_category = $request['product_sub_category_other'];
		}
		
		$product->supplier_item_no = $request['supplier_item_no'];
		$product->item_description = $request['item_desc'];
		$product->grd = $request['grd'];
		
		$product->product_length = $request['prod_length'];
		$product->product_width = $request['prod_width'];
		$product->product_height = $request['prod_height'];
		$product->product_diameter = $request['prod_diameter'];
		$product->product_weight = $request['prod_weight'];

		$product->retail_length = $request['retail_length'];
		$product->retail_width = $request['retail_width'];
		$product->retail_height = $request['retail_height'];
		$product->retail_diameter = $request['retail_diameter'];
		$product->retail_weight = $request['retail_weight'];
		$product->retail_box_qty = $request['retail_box_qty'];

		$product->inner_length = $request['inner_length'];
		$product->inner_width = $request['inner_width'];
		$product->inner_height = $request['inner_height'];
		$product->inner_diameter = $request['inner_diameter'];
		$product->inner_weight = $request['inner_weight'];
		$product->inner_box_qty = $request['inner_box_qty'];

		$product->export_length = $request['export_length'];
		$product->export_width = $request['export_width'];
		$product->export_height = $request['export_height'];
		$product->export_diameter = $request['export_diameter'];
		$product->export_weight = $request['export_weight'];
		$product->export_box_qty = $request['export_box_qty'];
		$product->export_max_weight_carton = $request['export_max_weight'];
		$product->export_cbm = $request['export_cbm'];

        $product->po_no = $request['po_no'];
        $product->model_no = $request['model_no'];
        $product->brand = $request['brand'];
        $product->additional_product_info = $request['additional_product_info'];
        $product->save();
		
		return response()->json(['message' => 'OK', 'client_code' => $product->client_code, 'product_id' => $product->id ],200);
	}
	
	public function saveClientProductImages(Request $request)
	{
		$code = $request->input('client_code');
		$prod_id = $request->input('product_id');
		
		if ($request->hasFile('product_photo')) {
			$cat = 'PS';
			$file = $request->file('product_photo');
		}
		
		if ($request->hasFile('product_spec')) {
			$cat = 'TD';
			$file = $request->file('product_spec');
		}
		
		if ($request->hasFile('art_work')) {
			$cat = 'AW';
			$file = $request->file('art_work');
		}
		
		if ($request->hasFile('shipping_mark')) {
			$cat = 'SM';
			$file = $request->file('shipping_mark');
		}
		
		if ($request->hasFile('packing_details')) {
			$cat = 'PD';
			$file = $request->file('packing_details');
		}
		
		if ($request->hasFile('other_photos')) {
			$cat = 'PP';
			$file = $request->file('other_photos');
		}
		
		$path = "upload/$cat/$code/";
		
		$dir = "js/dropzone/$path";
				
		if (!File::exists($dir)) {
			File::makeDirectory($dir);
		}
		
		$filename = $file->getClientOriginalName();
		$type = $file->getClientMimeType();
		
		$file->move($dir,$filename);
		
		ProductPhoto::create([
			'user_id' => $code,
			'product_id' => $prod_id,
			'inspection_id' => 0,
			'file_name' => $filename,
			'file_path' => $path,
			'file_type' => $type,
			'description' => null,
			'photo_category' => '',
			'status' => 0
		]);
		
		return response(['status' => 'ok']);
	}
	
	public function deleteClientProductImage(Request $request)
	{
		$image = ProductPhoto::find($request['id']);
		$image->delete();
		
		return response()->json(['message' => 'OK'],200);
	}
	
	public function deleteClientProduct(Request $request){
		$product = Product::find($request['id']);
		$product->delete();
		
		return response()->json(['message' => 'OK'],200);
	}
	
	public function getCategories($id){
        $p_category=[
		'Accessories / components'
        ,'Apparel'
        ,'Automotive Parts'
        ,'Bag and case'
        ,'Beauty / hairdressing and personal care appliance'
        ,'Chemical Products'
        ,'Construction and Mechanical Products'
        ,'Consumer Electronics'
        ,'Fans'
        ,'Furniture'
        ,'Garden'
        ,'Garment'
        ,'Garment accessories'
        ,'Gifts and Promo Items'
        ,'Healthcare and Beauty'
        ,'Home Appliances'
        ,'Homeware'
        ,'Hometextile'
        ,'Hotel Supplies'
        ,'Kitchen Appliances'
        ,'Lightning'
        ,'Machinery Parts/Products'
        ,'Multimedia'
        ,'Outdoor and Sports Products'
        ,'Pet Products'
        ,'Power tools'
        ,'Printing and Packaging'
        ,'Shoes'
        ,'Stationery and Luggage Products'
        ,'Toys / Recreational Items'];

        $p_categories  = SavedProductCategories::where('user_id',$id)->get();
        foreach($p_categories as $cat){
            $p_category[] = $cat->category;
        }

        $p_category[] = 'Others';

		return $p_category;
	}
	
	public function getSubCategories(Request $request){
		$category = $request['category'];
        $pcid  = Category::where('name', $category)->first();
        if($pcid){
            $sub_categories  = SubCategory::where('category_id',$pcid->id)->get()->pluck('name');
        } else {
			$sub_categories  = SavedProductSubCategories::where('category',$category)->get()->pluck('sub_category');
		}
        
        return $sub_categories;
	}
	
}
