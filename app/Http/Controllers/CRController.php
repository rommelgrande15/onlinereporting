<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Company;
use App\CustRequirement;
use Session;

class CRController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCustomerRequirements(){
    	$company = Company::where('user_id',Auth::id())->first();
    	$cust = CustRequirement::where('user_id', Auth::id())->first();
    	return view('pages.requirements.index',compact('company','cust'));
    }

    public function updateChanges(Request $request){

    	if ($request['special_requirements'] == '') {
    		$special_requirements = 'n/a';
    	}else{
    		$special_requirements = $request['special_requirements'];
    	}

    	if ($request['instructions'] == '') {
    		$instructions = 'n/a';
    	}else{
    		$instructions = $request['instructions'];
    	}

    	if ($request['additional_requirements'] == '') {
    		$additional_requirements = 'n/a';
    	}else{
    		$additional_requirements = $request['additional_requirements'];
    	}

    	$cr = CustRequirement::where('user_id', Auth::id())->first();
        $cr->no_key_component = $request['no_key_component'];
        $cr->no_serial_number = $request['no_serial_number'];
        $cr->no_rating_label = $request['no_rating_label'];
        $cr->no_removable_sticker_product = $request['no_removable_sticker_product'];
        $cr->missing_logo_product = $request['missing_logo_product'];
        $cr->no_removable_sticker_carton = $request['no_removable_sticker_carton'];
        $cr->no_imp_exp_info = $request['no_imp_exp_info'];
        $cr->packing_not_finished = $request['packing_not_finished'];
        $cr->production_not_finished = $request['production_not_finished'];
        $cr->report_requirement_1 = $request['report_requirement_1'];
        $cr->report_requirement_2 = $request['report_requirement_2'];
        $cr->report_requirement_3 = $request['report_requirement_3'];

        $cr->double_sampling = $request['double_sampling'];
        $cr->seal_every_product = $request['seal_every_product'];
        $cr->seal_opened_carton = $request['seal_opened_carton'];
        $cr->seal_on_whole_quantity = $request['seal_on_whole_quantity'];
        $cr->tic_own_report = $request['tic_own_report'];
        $cr->tic_chop = $request['tic_chop'];

        $cr->temperature_test = $request['temperature_test'];
        $cr->humidity_test = $request['humidity_test'];
        $cr->temp_rise_test = $request['temp_rise_test'];
        $cr->noise_test = $request['noise_test'];
        $cr->special_requirements = $special_requirements;

        $cr->instructions = $instructions;
        $cr->blister_packing = $request['blister_packing'];
        $cr->carton_packing = $request['carton_packing'];
        $cr->tape = $request['tape'];

        $cr->additional_requirements = $additional_requirements;
        if ($cr->update()) {
			Session::flash('success','Successfully saved Customer Requirements!');
            return redirect()->route('requirements');
        }
    }
}
