<?php
namespace App\Http\Controllers;
use App\User;
use App\UserInfo;
use Illuminate\Support\Facades\Auth;
use DB;
use App\FactoryData;
use App\FctoryContact;
use App\Country;
use App\Factory;
use App\Client;
use App\Supplier;
use App\SupplierContact;
use App\Http\Controllers\Session;

use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;

class FactoryAccountController extends Controller
{
    public function getDashboardPanelFactory(Request $request){
        $g = User::select('group_id')->where('id',Auth::id())->first();
        if(empty($g->group_id)){
            $client_id = Auth::id();
        } else {
            $client_id = $g->group_id;
        }
        $user = User::where('id',$client_id)->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        return view('pages.factory.dashboard.index-dev',compact('user_info','user'));   
    }

    public function getAccountDashboard(){
        $supplierInfo = DB::table('supplier_datas')
            ->join('suppliers', 'suppliers.id', '=', 'supplier_datas.supplier_id')
            ->select('*','suppliers.id as supplierId')
            ->where('supplier_datas.user_id',Auth::id())->first();
        
        $countries = Country::all();
        $factoryData = DB::table('factories')->get();

        $user = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $client = $user->client_code;
        $client_code = $user_info->client_code;
        $client_aql_details = DB::table('client_aql_details')->where('client_aql_details.client_id',$user->group_id)->first();

        $supplierData = DB::table('suppliers')->where('id',$supplierInfo->supplier_id)->first();
        $users = DB::table('users')->where('client_code',$supplierData->client_code)->first();
        $factory_details = DB::table('factories')->where('factories.supplier_id',$supplierData->id)->get();
        
        
        return view('pages.factory.accountsettings.index',compact('user_info','user','factoryData','supplierInfo','factory_details','client_code')); 
    }

        public function supplierAddFactory(Request $request){
            $this->validate($request,array(
               'factory_name'=>'required',
               'factory_address'=>'required',
               'factory_country'=>'required'
           ));
   
           $factory = new Factory();
           $factory->client_code = $request['client_code'];
           $factory->supplier_id = $request['supplier_id'];
           $factory->factory_name = $request['factory_name'];
           $factory->factory_number = $request['factory_number'];
           $factory->factory_address = $request['factory_address'];
           $factory->factory_address_local = $request['factory_address_local'];
           $factory->factory_country = $request['factory_country'];
           $factory->factory_country_name = $request['factory_country_name'];
           $factory->factory_state = $request['factory_state'];
           $factory->factory_city = $request['factory_city'];
           $factory->factory_city_local = $request['factory_city_local'];
           $factory->factory_state_id = $request['factory_state_id'];
           $factory->factory_city_id = $request['factory_city_id'];
           $factory->factory_status = 0;
   
           if ($factory->save()) {
               $c_person = $request['contact_person'];
               $lastInsertId= $factory->id;

               foreach ($c_person as $i => $value) {
                   $contact[$i] = new FctoryContact();
                   $contact[$i]->factory_id = $lastInsertId;
                   $contact[$i]->client_code = $request['client_code'];
                   $contact[$i]->factory_contact_person = $request['contact_person'][$i];
                   $contact[$i]->factory_contact_number = $request['contact_person_number'][$i];
                   $contact[$i]->factory_tel_number = $request['c_person_tel_number'][$i];
                   $contact[$i]->factory_email = $request['contact_person_email'][$i];
                   $contact[$i]->factory_contact_skype = $request['factory_contact_skype'][$i];
                   $contact[$i]->factory_contact_wechat = $request['factory_contact_wechat'][$i];
                   $contact[$i]->factory_contact_whatsapp = $request['factory_contact_whatsapp'][$i];
                   $contact[$i]->factory_contact_qq = $request['factory_contact_qqmail'][$i];
                   $contact[$i]->factory_contact_status = 0;
                   $contact[$i]->save();
               }
            //    Session::flash('success','You have successfully added a new Factory!');
               return redirect()->route('factory-account-settings'); 
            }
       }

        //ADD CONTACTS
        public function AddMoreSupplierFctoryContact(Request $request){
        $c_person = $request['contact_person'];
            foreach ($c_person as $i => $value) {
                //return $c_person[$i];
                $contact[$i] = new FctoryContact();
                $contact[$i]->factory_id = $request['add_factory_id'];
                $contact[$i]->client_code = $request['client_code']; 
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

        
    public function updateSupplierFactory(Request $request){
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
            $group = User::where('id',Auth::id())->first();
            if($group->group_id){
                $group_id = $group->group_id;
            } else {
                $group_id = "";
            }
            //\LogActivity::addToLog('factory',$factory->id,'edit',$group_id, 'updated the factory: ' . $request['update_factory_name']);
            //Session::flash('success','You have successfully updated the Factory information!');
        }
    }


        

        public function updateSupplyFactory(Request $request){
            $factory = Factory::where('id', $request['id'])->get();
                return response()->json([
                    'factory' => $factory
                ]);
        }
        // public function viewSupplyFactory(Request $request){
        //     $factory = Factory::where('id', $request['id'])->get();
        //     $fctoryContacts = FctoryContact::where('factory_id', $request['id'])->get();
        //         return response()->json([
        //             'factory' => $factory,
        //             'fctoryContacts' =>$fctoryContacts
        //         ]);
        // }

        //UPDATE FACTORY CONTACT PERSON
        public function postUpdateSupplierFctoryContactPerson(Request $request){
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

        public function getOneFactoryWithContact($id){
            $factory = Factory::find($id);
            $contacts = FctoryContact::where('factory_id',$id)->where('factory_contact_status',0)->get();
            $contact = FctoryContact::where('factory_id',$id)->first();
            //$contact = FctoryContact::where('factory_id', $request['id'])->get();
            // $country = Country::find($factory->factory_country);
    
            
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


        
        //Delete Factory
        public function deleteSupplierFactory(Request $request){
            $factory = Factory::where('id', $request['id'])->get();
            return response()->json([
                'factory' => $factory
            ]);
        }
        public function delete_SupplierFactory(Request $request){
            $factory = Factory::where('id', $request['delete_supplierfactory_id'])->delete();
        }

        public function deleteFctoryContact(Request $request){
            $factory_con = FctoryContact::find($request['id']);
            $factory_con->factory_contact_status = 2;
            if ($factory_con->save()) {
                $group = User::where('id',Auth::id())->first();
                if($group->group_id){
                    $group_id = $group->group_id;
                } else {
                    $group_id = "";
                }
                //\LogActivity::addToLog('factory',$factory->id,'delete',$group_id, 'Deleted the factory contact: ' . $factory_con->factory_contact_person);
                //Session::flash('success','You have successfully updated the Factory information!');
            }
        }
    
}