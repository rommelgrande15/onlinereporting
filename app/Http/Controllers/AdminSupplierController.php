<?php

namespace App\Http\Controllers;

use App\Template;


use App\Role;
use App\User;
use App\UserInfo;
use App\Client;
use App\ClientContact;
use App\Factory;
use App\FctoryContact;
use App\Supplier;
use App\SupplierContact;



use DB;
use Session;
use Mail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Array_;
use Dompdf\Exception;
use Symfony\Component\DomCrawler\Crawler;


class AdminSupplierController extends Controller
{



    public function getSuppliersListAdmin(){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $suppliers = Supplier::where('added_by','admin')->where('supplier_status',0)->get();
        return view('pages.admin.supplier.index',compact('role','suppliers','user_info','client_code','user'));
    }

    public function getFactoryListAdmin($id){
        $role = User::where('id',Auth::id())->first();
        $user_info = UserInfo::where('user_id',Auth::id())->first();
        $user = User::where('id',Auth::id())->first();
        $factories = Factory::where('supplier_id',$id)->where('factory_status',0)->get();
        $suppliers = Supplier::where('id',$id)->first();
        $client_code=$user_info->client_code;
        $req='get_factory_by_supplier';
        $supplier_id=$id;
        return view('pages.admin.view-factory-page.index',compact('role','factories','user_info','client_code','req','supplier_id','user','suppliers'));
    }

    //add supplier function
    public function addSupplier(Request $request){
        $supplier = new Supplier();
        $supplier->client_code = '';
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

        $supplier->supplier_status = 0;
        $supplier->added_by = 'admin';
 
        if ($supplier->save()) {
            $c_person = $request['contact_person'];
            $lastInsertId= $supplier->id;
 
            foreach ($c_person as $i => $value) {
                $contact[$i] = new SupplierContact();
                $contact[$i]->supplier_id = $lastInsertId;
                $contact[$i]->client_code = '';
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
                $factory->client_code = '';
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
                    $c_person = $request['contact_person'];
         
                    foreach ($c_person as $i => $value) {
                        $contact[$i] = new FctoryContact();
                        $contact[$i]->factory_id = $factory->id;
                        $contact[$i]->client_code ='';
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
                }
            }

            Session::flash('success','You have successfully added a new Supplier!');          
            return response()->json([
                'supplier' => $supplier->id
            ]); 
        }
    }

    //update supplier function
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
                    $new_contact[$i]->client_code ='';
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
            Session::flash('success','You have successfully updated the Supplier information!');
        }
    }

    //factory of supplier function
    public function postNewFactorySupplier(Request $request){
        $factory = new Factory();
        $factory->client_code = null;
        $factory->supplier_id = $request['supplier_id'];
        $factory->factory_name = $request['factory_name'];
        $factory->factory_number = $request['factory_number'];


        $factory->factory_address = $request['factory_address'];
        $factory->factory_city = $request['factory_city'];
        $factory->factory_address_local = $request['factory_address_local'];
        $factory->factory_city_local = $request['factory_city_local'];


        $factory->factory_country = $request['factory_country'];
        $factory->factory_country_name = $request['factory_country_name'];

        $factory->factory_state = null;
        $factory->factory_state_id = null;
        $factory->factory_city_id = null;

        $factory->factory_status = 0;
 
        if ($factory->save()) {
            $c_person = $request['contact_person'];
            $lastInsertId= $factory->id;
 
            foreach ($c_person as $i => $value) {
                $contact[$i] = new FctoryContact();
                $contact[$i]->factory_id = $lastInsertId;
                $contact[$i]->client_code = null;
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

    public function updateFactorySupplier(Request $request){
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
                    $new_contact[$i]->client_code = null;
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


 
}
