<?php

use Illuminate\Database\Seeder;
use App\Inspector;
class InspectorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$mail = 'kuyakimpoy010@gmail.com';
        $inspector = new Inspector();
        $inspector->name = 'Juan Dela Cruz';
        $inspector->email_address = $mail;
        $inspector->contact_number = '09056600153';
        $inspector->save();

        $inspecto = new Inspector();
        $inspecto->name = 'Pedro Magsakay';
        $inspecto->email_address = $mail;
        $inspecto->contact_number = '09056600153';
        $inspecto->save();

        $inspect = new Inspector();
        $inspect->name = 'Kim Carlo Cortez';
        $inspect->email_address = $mail;
        $inspect->contact_number = '09056600153';
        $inspect->save();
    }
}
