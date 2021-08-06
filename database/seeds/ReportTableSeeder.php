<?php

use Illuminate\Database\Seeder;
use App\Report;
use App\Inspection;


class ReportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	$inspection =  array('id' => '1','client_id' => '104','inspection_date' => '2016-12-30','service' => 'cli','contact' => '123456897987','factory' => 'Chocolate Factory','contact_person' => 'Juan Dela Cruz','factory_address' => 'Bonifacio Global City, Taguig','product' => 'Chocolate','brand' => 'Cadburry','model_no' => '12356789798','po_no' => '231321231','qty' => '123123','sample_level' => '2121','sampling_size' => '2121','max_minor' => '1','max_major' => '1','max_critical' => '1','max_functional' => '1','aql_minor' => '0.0000','aql_major' => '0.0000','aql_critical' => '0.0000','aql_functional' => '0.0000','requirement' => 'Kaisdaosidoaisdasoda','created_at' => '2016-12-28 12:37:36','updated_at' => '2016-12-28 12:37:36');

    	$ins = new Inspection();
    	$ins->client_id = $inspection['client_id'];
    	$ins->inspection_date = $inspection['inspection_date'];
    	$ins->service = $inspection['service'];
    	$ins->contact = $inspection['contact'];
    	$ins->factory = $inspection['factory'];
    	$ins->contact_person = $inspection['contact_person'];
    	$ins->factory_address = $inspection['factory_address'];
    	$ins->product = $inspection['product'];
    	$ins->brand = $inspection['brand'];
    	$ins->model_no = $inspection['model_no'];
    	$ins->po_no = $inspection['po_no'];
    	$ins->qty = $inspection['qty'];
    	$ins->sample_level = $inspection['sample_level'];
    	$ins->sampling_size = $inspection['sampling_size'];
    	$ins->max_minor = $inspection['max_minor'];
    	$ins->max_major = $inspection['max_major'];
    	$ins->max_critical = $inspection['max_critical'];
    	$ins->max_functional = $inspection['max_functional'];
    	$ins->aql_minor = $inspection['aql_minor'];
    	$ins->aql_major = $inspection['aql_major'];
    	$ins->aql_critical = $inspection['aql_critical'];
    	$ins->aql_functional = $inspection['aql_functional'];
    	$ins->requirement = $inspection['requirement'];
    	$ins->created_at = $inspection['created_at'];
    	$ins->updated_at = $inspection['updated_at'];
    	$ins->save();

        $report = array('id' => '1','inspection_id' => '1','client_code' => 'sr','service' => 'Container Loading Inspection','inspection_date' => '2016-12-30','report_no' => 'sr-2016-00000001','password' => '242349','created_at' => '2016-12-28 12:37:36','updated_at' => '2016-12-28 12:37:36');

        $rep = new Report();
        $rep->inspection_id = $report['inspection_id'];
        $rep->client_code = $report['client_code'];
        $rep->service = $report['service'];
        $rep->inspection_date = $report['inspection_date'];
        $rep->report_no = $report['report_no'];
        $rep->password = $report['password'];
        $rep->created_at = $report['created_at'];
        $rep->updated_at = $report['updated_at'];
        $rep->save();
    }
}
