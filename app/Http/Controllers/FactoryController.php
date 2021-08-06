<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Factory;
use App\Company;
use App\Country;

class FactoryController extends Controller
{
    public function postAJAXNewFactory(Request $request){

    	$this->validate($request,array(
            'new_factory_name'=>'required',
            'new_factory_address'=>'required',
            'new_country'=>'required',
            'new_city'=>'required',
            'new_contact_person'=>'required',
            'new_contact_number'=>'required',
            'new_email_address'=>'required',
        ));

        $factory = new Factory();
        $factory->user_id = Auth::id();
        $factory->factory_name = $request['new_factory_name'];
        $factory->factory_address = $request['new_factory_address'];
        $factory->factory_country = $request['new_country'];
        $factory->factory_city = $request['new_city'];
        $factory->factory_contact_person = $request['new_contact_person'];
        $factory->factory_contact_number = $request['new_contact_number'];
        $factory->factory_email = $request['new_email_address'];

        if ($factory->save()) {
        	$new = Factory::where('id',$factory->id)->first();
        	return response()->json([
        		'factory' => $new
        	],200);
        }
    }

    public function retrieveFactory(Request $request){
		$factory = Factory::where('id',$request['id'])->first();
			return response()->json([ 
				'factory' => $factory
			],200);
	}

    public function getFactoryIndex(){
        $factories = Factory::where('user_id',Auth::id())->get();
        $company = Company::where('user_id',Auth::id())->first();
        $countries = Country::pluck('nicename','iso');
        return view('pages.factories.index', compact('factories','company','countries'));
    }

     public function updateFactory(Request $request){
        $this->validate($request,array(
            'edit_factory_name' =>'required',
            'edit_factory_address'=>'required',
            'edit_country'=>'required',
            'edit_city'=>'required',
            'edit_contact_person'=>'required',
            'edit_contact_number'=>'required',
            'edit_email_address'=>'required',
        ));

        $factory = Factory::find($request['edit_factory_id']);
        $factory->factory_name = $request['edit_factory_name'];
        $factory->factory_address = $request['edit_factory_address'];
        $factory->factory_country = $request['edit_country'];
        $factory->factory_city = $request['edit_city'];
        $factory->factory_contact_person = $request['edit_contact_person'];
        $factory->factory_contact_number = $request['edit_contact_number'];
        $factory->factory_email = $request['edit_email_address'];
        if ($factory->save()) {
            $new = Factory::where('id',$factory->id)->first();
            return response()->json([
                'factory' => $new
            ],200);
        }

    }

     public function deleteFactory(Request $request){
       /*  $factory = Factory::find($request['factory_id']);
        $factory->delete();
        return response()->json([
                'message' => 'Factory has been deleted!'
            ],200); */

        $factory = Factory::find($request['factory_id']);
        $factory->factory_status=2;
        $factory->save();
        return response()->json([
                'message' => 'Factory has been deleted!'
            ],200);
    }
}
