<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Company;
use App\UserInfo;
use App\CustRequirement;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role_inspector = Role::where('name','inspector')->first();
    	$role_admin = Role::where('name','admin')->first();
        $role_booking = Role::where('name','booking')->first();
        $role_reports = Role::where('name','reports')->first();
        $role_client = Role::where('name','client')->first();

        $user = new User();
    	$user->email = 'kim@t-i-c.asia';
    	$user->username = 'inspector';
    	$user->password = bcrypt('inspector1234');
        $user->status = '1';
    	$user->save();
    	$user->roles()->attach($role_inspector);

        $user_inspector_info = new UserInfo();
        $user_inspector_info->user_id = $user->id;
        $user_inspector_info->name = 'Pedro Dela Cruz';
        $user_inspector_info->email_address = $user->email;
        $user_inspector_info->contact_number = '+639056600153';
        $user_inspector_info->designation = 'inspector';
        $user_inspector_info->save();


    	$user_admin = new User();
        $user_admin->email = 'postmaster@t-i-c.asia';
        $user_admin->username = 'admin';
        $user_admin->password = bcrypt('admin1234');
        $user_admin->status = '1';
        $user_admin->save();
        $user_admin->roles()->attach($role_admin);

        $user_admin_info = new UserInfo();
        $user_admin_info->user_id = $user_admin->id;
        $user_admin_info->name = 'Kim Carlo Cortez';
        $user_admin_info->email_address = $user_admin->email;
        $user_admin_info->contact_number = '+639056600153';
        $user_admin_info->designation = 'super_admin';
        $user_admin_info->save();


        $user_booking = new User();
        $user_booking->email = 'booking@t-i-c.asia';
        $user_booking->username = 'booking';
        $user_booking->password = bcrypt('booking1234');
        $user_booking->status = '1';
        $user_booking->save();
        $user_booking->roles()->attach($role_booking);

        $user_booking_info = new UserInfo();
        $user_booking_info->user_id = $user_booking->id;
        $user_booking_info->name = 'Juan Dela Cruz';
        $user_booking_info->email_address = $user_booking->email;
        $user_booking_info->contact_number = '+639051234567';
        $user_booking_info->designation = 'booking';
        $user_booking_info->save();


        $user_report = new User();
        $user_report->email = 'report@t-i-c.asia';
        $user_report->username = 'report';
        $user_report->password = bcrypt('report1234');
        $user_report->status = '1';
        $user_report->save();
        $user_report->roles()->attach($role_reports);

        $user_report_info = new UserInfo();
        $user_report_info->user_id = $user_report->id;
        $user_report_info->name = 'Pedro Penduko';
        $user_report_info->email_address = $user_report->email;
        $user_report_info->contact_number = '+639152468100';
        $user_report_info->designation = 'reports_review';
        $user_report_info->save();
    }
}
