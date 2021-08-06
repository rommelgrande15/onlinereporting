<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Factory;
use App\Client;
use App\Country;
use App\User;
use App\UserInfo;
use App\FctoryContact;
use App\Report;
use App\PSIProduct;
use App\Inspection;
use Session;
use DB;

class AdminFactoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getFactoryList(){
  		$role = User::where('id',Auth::id())->first();
    	//$FctoryContact = FctoryContact::all();
    	$factories = DB::table('factories')
                 /*    ->join('countries','factories.factory_country', '=', 'countries.id')
                    ->join('FctoryContact','FctoryContact.factory_id', '=', 'factories.id') */
                    ->select('factories.*')
                    ->get();
        $countries = Country::all();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $new_client_count = DB::table('clients')->join('users','users.client_code','=','clients.client_code')->select('clients.client_code','users.status')->where('clients.client_code',['000'])->where('users.status','2')->count();
        $new_post_client = Inspection::where('inspection_status','Client Pending')->count();
    	return view('pages.admin.factory.index',compact('role','factories','user_info','countries','new_client_count','new_post_client'));
    }

  /*   public function getFactoryList(){
        $role = User::where('id',Auth::id())->first();
      $clients = Client::orderBy('id','desc')->get();
      $factories = DB::table('factories')
                  ->join('countries','factories.factory_country', '=', 'countries.id')
                  ->join('clients','clients.client_code', '=', 'factories.client_code')
                  ->select('factories.*','countries.nicename','clients.client_name')
                  ->get();
      $countries = Country::all();
      $user_info = UserInfo::where('user_id',Auth::id())->first();
      return view('pages.admin.factory.index',compact('clients','role','factories','user_info','countries'));
  } */

    public function postNewFactory(Request $request){
         $this->validate($request,array(
            /* 'client_code' => 'required', */
            'factory_name'=>'required',
            'factory_address'=>'required',
            'factory_country'=>'required'
        ));

        $factory = new Factory();
       /*  $factory->client_code = $request['client_code']; */
        $factory->factory_name = $request['factory_name'];
        $factory->factory_address = $request['factory_address'];
        $factory->factory_address_local = $request['factory_address_local'];
        $factory->factory_country = $request['factory_country'];
        $factory->factory_country_name = $request['factory_country_name'];
        $factory->factory_state = $request['factory_state'];
        $factory->factory_city = $request['factory_city'];
        $factory->factory_state_id = $request['factory_state_id'];
        $factory->factory_city_id = $request['factory_city_id'];
        $factory->factory_status = 0;

        if ($factory->save()) {
            $c_person = $request['contact_person'];
            $lastInsertId= $factory->id;

            foreach ($c_person as $i => $value) {
                //return $c_person[$i];
                $contact[$i] = new FctoryContact();
                $contact[$i]->factory_id = $lastInsertId;
              /*   $contact[$i]->client_code = $request['client_code']; */
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
            /* if ($contact->save()) {
                Session::flash('success','You have successfully added a new Factory!');
                return redirect()->route('factorylist');     
            } */
            Session::flash('success','You have successfully added a new Factory!');
            return redirect()->route('factorylist');  
        }

       
       

    }

    public function postNewFactoryAJAX(Request $request){
         $this->validate($request,array(
            'client_code' => 'required',
            'factory_name'=>'required',
            'factory_address'=>'required',
            'factory_country'=>'required',
            'factory_city'=>'required',
        ));

        $factory = new Factory();
        $factory->client_code = $request['client_code'];
        $factory->factory_name = $request['factory_name'];
        $factory->factory_address = $request['factory_address'];
        $factory->factory_country = $request['factory_country'];
        $factory->factory_city = $request['factory_city'];

        if ($factory->save()) {
            return response()->json([
                'factory' => $factory
            ]);
        }
    }

    public function AddMoreFctoryContact(Request $request){
        $c_person = $request['contact_person'];
            foreach ($c_person as $i => $value) {
                //return $c_person[$i];
                $contact[$i] = new FctoryContact();
                $contact[$i]->factory_id = $request['add_factory_id'];
                /* $contact[$i]->client_code = $request['client_code']; */
                $contact[$i]->factory_contact_person = $request['contact_person'][$i];
                $contact[$i]->factory_email = $request['contact_person_email'][$i];
                $contact[$i]->factory_contact_number = $request['contact_person_number'][$i];
                $contact[$i]->factory_tel_number = $request['add_contact_person_tel_number'][$i];

                $factory_contact_skype= $request['factory_contact_skype'][$i];
                $factory_contact_wechat = $request['factory_contact_wechat'][$i];
                $factory_contact_whatsapp = $request['factory_contact_whatsapp'][$i];
                $factory_contact_qq = $request['factory_contact_qqmail'][$i];

                if($factory_contact_skype==""){ $factory_contact_skype="N/A"; }
                if($factory_contact_wechat==""){ $factory_contact_wechat="N/A"; }
                if($factory_contact_whatsapp==""){ $factory_contact_whatsapp="N/A"; }
                if($factory_contact_qq==""){ $factory_contact_qq="N/A";}

                $contact[$i]->factory_contact_skype = $factory_contact_skype;
                $contact[$i]->factory_contact_wechat = $factory_contact_wechat;
                $contact[$i]->factory_contact_whatsapp = $factory_contact_whatsapp;
                $contact[$i]->factory_contact_qq = $factory_contact_qq;
                $contact[$i]->factory_contact_status = 0;
                $contact[$i]->save();
            }
            Session::flash('success','You have successfully added a new Factory!');
            return redirect()->route('factorylist');  
   }

    public function getOneFactory($id){
        $factory = Factory::find($id);
        $contacts = FctoryContact::where('factory_id',$id)->where('factory_contact_status',0)->get();
        $contact = FctoryContact::where('factory_id',$id)->first();
        $country = Country::find($factory->factory_country);

        
        return response()->json([
            'factory_id' => $id,
            'client_code' => $factory->client_code,
            'factory_name' => $factory->factory_name,
            'factory_number' => $factory->factory_number,
            'factory_address' => $factory->factory_address,
            'factory_address_local' => $factory->factory_address_local,
            'factory_city' => $factory->factory_city,
            'factory_city_id' => $factory->factory_city_id,
            'factory_state' => $factory->factory_state,
            'factory_state_id' => $factory->factory_state_id,
            'factory_city_local' => $factory->factory_city_local,
            'factory_country' => $factory->factory_country,
            'factory_country_name' => $factory->factory_country_name,
            'country'=>$country,
            'contacts'=>$contacts,
            'factory_contact_person' => $contact->factory_contact_person,
            'factory_contact_number' => $contact->factory_contact_number,
            'factory_email' => $contact->factory_email,
            'factory_contact_id' => $contact->id,
            'factory_contact_skype' => $contact->factory_contact_skype,
            'factory_contact_wechat' => $contact->factory_contact_wechat,
            'factory_contact_whatsapp' => $contact->factory_contact_whatsapp,
            'factory_contact_qq' => $contact->factory_contact_qq
        ]);
    }

    public function getOneFactory2($id,$id2){
 
        $contact = FctoryContact::where('factory_id',$id)
        ->where('factory_id','!=',$id)
        ->get();

        
        return response()->json([
            'factory_contact_person' => $contact->factory_contact_person,
            'factory_contact_number' => $contact->factory_contact_number,
            'factory_email' => $contact->factory_email
        ]);
    }


    public function postUpdateFactory(Request $request){
        $this->validate($request,array(
            
            /* 'update_client_code' => 'required', */
            'update_factory_name'=>'required',
            'update_factory_address'=>'required',
            'update_factory_country'=>'required',
            'update_factory_city'=>'required'
            /* 'update_contact_person'=>'required',
            'update_contact_person_email'=>'required',
            'update_contact_person_number'=>'required', */
            
        ));

        
 
       $factory = Factory::find($request['update_factory_id']);
       /*  $factory->client_code = $request['update_client_code']; */
        $factory->factory_name = $request['update_factory_name'];
        $factory->factory_address = $request['update_factory_address'];
        $factory->factory_address_local = $request['update_factory_address_local'];
        $factory->factory_country = $request['update_factory_country'];
        $factory->factory_country_name = $request['update_factory_country_name'];
        $factory->factory_city = $request['update_factory_city'];
        $factory->factory_city_id = $request['update_factory_city_id'];
        $factory->factory_state = $request['update_factory_state'];
        $factory->factory_state_id = $request['update_factory_state_id'];

        $IdcontactFactory = $request['IdcontactFactory'];

        foreach ($IdcontactFactory as $i => $value) {
            $contact[$i] = FctoryContact::find($request['IdcontactFactory'][$i]);
         /*    $contact[$i]->factory_contact_person = $request['update_contact_person'][$i]; */
            $contact[$i]->factory_contact_person = $request['update_contact_person'][$i];
            $contact[$i]->factory_email = $request['update_contact_person_email'][$i];
            $contact[$i]->factory_contact_number = $request['update_contact_person_number'][$i];
            $contact[$i]->factory_tel_number = $request['update_contact_person_tel_number'][$i];
            $contact[$i]->factory_contact_skype = $request['update_contact_skype'][$i];
            $contact[$i]->factory_contact_wechat = $request['update_contact_wechat'][$i];
            $contact[$i]->factory_contact_whatsapp = $request['update_contact_whatsapp'][$i];
            $contact[$i]->factory_contact_qq= $request['update_contact_qqmail'][$i];
            $contact[$i]->save();




/* 

            $contact[$i] = FctoryContact::find($request['IdcontactFactory'][$i]);
            
            $update_contact_skype;
            $update_contact_wechat;
            $update_contact_whatsapp;
            $update_contact_qqmail;
            if($request['update_contact_skype'][$i]=="" || $request['update_contact_skype'][$i]==null){
   
               $update_contact_skype="N/A";
            }else{
               $update_contact_skype=$request['update_contact_skype'][$i];
            }
            if($request['update_contact_wechat'][$i]=="" || $request['update_contact_wechat'][$i]==null){
   
               $update_contact_wechat="N/A";
            }else{
                $update_contact_wechat=$request['update_contact_wechat'][$i];
           }
            if($request['update_contact_whatsapp'][$i]=="" || $request['update_contact_whatsapp'][$i]==null){
   
               $update_contact_whatsapp="N/A";
            }else{
                $update_contact_whatsapp=$request['update_contact_whatsapp'][$i];
           }
            if($request['update_contact_qqmail'][$i]=="" || $request['update_contact_qqmail'][$i]==null){
   
               $update_contact_qqmail="N/A";
            }else{
               $update_contact_qqmail=$request['update_contact_qqmail'][$i]; 
           }
               $contact[$i]->factory_contact_person =$request['update_contact_person'][$i];
               $contact[$i]->factory_email = $request['update_contact_person_email'][$i];
               $contact[$i]->factory_contact_number = $request['update_contact_person_number'][$i];
               $contact[$i]->factory_tel_number = $request['update_contact_person_tel_number'][$i];
               $contact[$i]->factory_contact_skype = $update_contact_skype;
               $contact[$i]->factory_contact_wechat = $update_contact_wechat;
               $contact[$i]->factory_contact_whatsapp = $update_contact_whatsapp;
               $contact[$i]->factory_contact_qq= $update_contact_qqmail;
               $contact[$i]->save(); */
        }
        
        if ($factory->save()) {           
            Session::flash('success','You have successfully updated the Factory information!');
            return redirect()->route('factorylist');
        }
    }


    public function postUpdateFctoryContactPerson(Request $request){
        //joe
        $contact = FctoryContact::find($request['update_contact_id']);
        $contact->factory_contact_person = $request['update_contact_person'];
        $contact->factory_email = $request['update_contact_person_email'];
        $contact->factory_contact_number = $request['update_contact_person_number'];

        $contact->factory_contact_skype = $request['update_contact_skype'];
        $contact->factory_contact_wechat = $request['update_contact_wechat'];
        $contact->factory_contact_whatsapp = $request['update_contact_whatsapp'];
        $contact->factory_contact_qq= $request['update_contact_qqmail'];
        
        if ($contact->save()) {           
            Session::flash('success','You have successfully updated the Factory information!');
            return redirect()->route('factorylist');
        }
    }

    public function postDeleteFactory(Request $request){
         
        /* $factory = Factory::find($request['factory_id']);

        if (DB::table('fctory_contacts')->where('factory_id', '=', $request['factory_id'])->delete() && $factory->delete()) {
            Session::flash('error', 'Factory details has been deleted from the database!');
            return redirect()->route('factorylist')->with('alert', 'Deleted!');
        } */

        $factory = Factory::find($request['factory_id']);
        $factory->factory_status=2;
        if($factory->save()){
            Session::flash('error', 'Factory details has been deleted from the database!');
            return redirect()->route('factorylist')->with('alert', 'Deleted!');
        }
    }

    public function getFctoryContacts($id){
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $factory = DB::table('factories')
                    ->join('clients','clients.client_code', '=', 'factories.client_code')
                    ->select('factories.*','clients.client_name')
                    ->where('factories.id',$id)
                       
                    ->first();
        $contacts = FctoryContact::where('fctory_contacts.factory_id',$id)->get();
        return view('pages.admin.factory.contacts',compact('user_info','factory','contacts'));
    }
    //Added
    public function getProjectDetails($id){
        $user_info = UserInfo::where('user_id',Auth::id())->first();
     
      
      
      
        $inspection = DB::table('inspections')
                    ->join('clients','clients.client_code', '=', 'inspections.client_id')
                    ->join('users','inspections.inspector_id', '=', 'users.id')
                    ->join('user_infos','users.id', '=', 'user_infos.id')
                    ->join('client_contacts','inspections.contact_person', '=', 'client_contacts.id')
                    ->join('factories','inspections.factory', '=', 'factories.id')
                    ->join('fctory_contacts','inspections.factory_contact_person', '=', 'fctory_contacts.id')
                    ->join('p_s_i_products','inspections.id', '=', 'p_s_i_products.inspection_id')
                    ->join('products','p_s_i_products.product_name', '=', 'products.id')
                    ->select('inspections.*','clients.client_name','users.*','user_infos.*','client_contacts.*','factories.*','fctory_contacts.*','p_s_i_products.*','products.*')
                    ->where('inspections.id',$id)
                       
                    ->first();
      
        $reference = Report::where('id',$id)->get();
      
        return view('pages.admin.detail.project',compact('user_info','inspection','reference'));
    }

    /* //Added Jesser
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
            'attachments'=> $attachments
        ]);
    } */
    
    /* public function getProjectDetailsCbpiNew($id){
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
      
        return response()->json([
            'user_info' => $user_info,
            'inspection' => $inspection,
            'reference' => $reference
        ]);
    } */

  public function getProjectDetails_cbpi($id){
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
      
        $reference = Report::where('id',$id)->get();
      
        return view('pages.admin.detail.project_cbpi',compact('user_info','inspection','reference'));
    }
    
    public function addNewContact(Request $request){
        $this->validate($request,array(
            'factory_id' => 'required',
            'client_code'=>'required',
            'contact_person'=>'required',
            'contact_person_email'=>'required',
            'contact_person_number'=>'required',
        ));

        $contact = new FctoryContact();
        $contact->factory_id = $request['factory_id'];
        $contact->client_code = $request['client_code'];
        $contact->factory_contact_person = $request['contact_person'];
        $contact->factory_email = $request['contact_person_email'];
        $contact->factory_contact_number = $request['contact_person_number'];

        if ($contact->save()) {
            Session::flash('success', 'New factory contact person has been added successfully!');
            return redirect()->route('FctoryContacts',$contact->factory_id);
        }
    }

    public function getOneContact($id){
        $contact = DB::table('fctory_contacts')
                ->join('factories', 'factories.id', '=', 'fctory_contacts.factory_id')
                ->select('fctory_contacts.*','factories.factory_name')
                ->where('fctory_contacts.id',$id)               
                ->first();
        return response()->json([
            'contact' => $contact
        ]);
    }

    public function updateFctoryContact(Request $request){
        $this->validate($request,array(
            'update_contact_id' => 'required',
            'contact_person'=>'required',
            'contact_person_email'=>'required',
            'contact_person_number'=>'required',
        ));

        $contact = FctoryContact::find($request['update_contact_id']);
        $contact->factory_contact_person = $request['contact_person'];
        $contact->factory_email = $request['contact_person_email'];
        $contact->factory_contact_number = $request['contact_person_number'];
     
        if ($contact->save()) {
            Session::flash('success', 'Factory contact person details has been updated successfully!');
      
            return redirect()->route('FctoryContacts',$contact->factory_id);
            //alert($contact->factory_id);
   
        }
    }

    public function deleteFctoryContact(Request $request){
       // return $request['contact_id'];
       /*  $contact = FctoryContact::find($request['contact_id']);
        if ($contact->delete()) {
            Session::flash('error', 'Contact person has been deleted from the database!');
            return $request['contact_id'];
           // return redirect()->route('FctoryContacts',$contact->factory_id);
        } */

        $contact = FctoryContact::find($request['contact_id']);
        $contact->factory_contact_status=2;
        if ($contact->save()) {
            Session::flash('error', 'Contact person has been deleted from the database!');
            return $request['contact_id'];
           // return redirect()->route('FctoryContacts',$contact->factory_id);
        }
    }

    public function addNewContactAJAX(Request $request){
        $contact = new FctoryContact();
        $contact->factory_id = $request['factory_id'];
        $contact->client_code = $request['client_code'];
        $contact->factory_contact_person = $request['contact_person'];
        $contact->factory_email = $request['factory_email'];
        $contact->factory_contact_number = $request['contact_number'];

        if ($contact->save()) {
            return response()->json([
                'contact' => $contact
            ]);
        }
    }

    public function getAllFactories($id){
        $factories = Factory::where('client_code',$id)->get();
        return response()->json([
            'factories' => $factories
        ]);
    }
}
