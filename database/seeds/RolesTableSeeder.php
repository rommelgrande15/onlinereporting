<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_client = new Role();
        $role_client->name = 'client';
        $role_client->description ='A client role';
        $role_client->save();

        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description ='An admin role';
        $role_admin->save();

        $role_booking = new Role();
        $role_booking->name = 'booking';
        $role_booking->description ='A booking team role';
        $role_booking->save();

        $role_reports = new Role();
        $role_reports->name = 'reports';
        $role_reports->description ='A reports team role';
        $role_reports->save();

        $role = new Role();
        $role->name = 'inspector';
        $role->description ='An inspector role';
        $role->save();

        $role_client_view = new Role();
        $role_client_view->name = 'role_client_view';
        $role_client_view->description ='Can view clients';
        $role_client_view->save();

        $role_client_add = new Role();
        $role_client_add->name = 'role_client_add';
        $role_client_add->description ='Can add clients';
        $role_client_add->save();

        $role_client_edit = new Role();
        $role_client_edit->name = 'role_client_edit';
        $role_client_edit->description ='Can edit clients';
        $role_client_edit->save();

        $role_client_delete = new Role();
        $role_client_delete->name = 'role_client_delete';
        $role_client_delete->description ='Can delete clients';
        $role_client_delete->save();

        $role_inspector_view = new Role();
        $role_inspector_view->name = 'role_inspector_view';
        $role_inspector_view->description ='Can view inspectors';
        $role_inspector_view->save();

        $role_inspector_add = new Role();
        $role_inspector_add->name = 'role_inspector_add';
        $role_inspector_add->description ='Can add inspectors';
        $role_inspector_add->save();

        $role_inspector_edit = new Role();
        $role_inspector_edit->name = 'role_inspector_edit';
        $role_inspector_edit->description ='Can edit inspectors';
        $role_inspector_edit->save();

        $role_inspector_delete = new Role();
        $role_inspector_delete->name = 'role_inspector_delete';
        $role_inspector_delete->description ='Can delete inspectors';
        $role_inspector_delete->save();

        $role_factory_add = new Role();
        $role_factory_add->name = 'role_factory_add';
        $role_factory_add->description ='Can add factory';
        $role_factory_add->save();

        $role_factory_view = new Role();
        $role_factory_view->name = 'role_factory_view';
        $role_factory_view->description ='Can view factory';
        $role_factory_view->save();

        $role_factory_edit = new Role();
        $role_factory_edit->name = 'role_factory_edit';
        $role_factory_edit->description ='Can view factory';
        $role_factory_edit->save();

        $role_factory_delete = new Role();
        $role_factory_delete->name = 'role_factory_delete';
        $role_factory_delete->description ='Can delete factory';
        $role_factory_delete->save();

        $role_change_permissions = new Role();
        $role_change_permissions->name = 'role_change_permissions';
        $role_change_permissions->description ='Can change user permissions';
        $role_change_permissions->save();


        $role_account_view = new Role();
        $role_account_view->name = 'role_account_view';
        $role_account_view->description ='Can view accounts';
        $role_account_view->save();

        $role_account_add = new Role();
        $role_account_add->name = 'role_account_add';
        $role_account_add->description ='Can view accounts';
        $role_account_add->save();

        $role_account_edit = new Role();
        $role_account_edit->name = 'role_account_edit';
        $role_account_edit->description ='Can edit accounts';
        $role_account_edit->save();

        $role_account_delete = new Role();
        $role_account_delete->name = 'role_account_delete';
        $role_account_delete->description ='Can delete accounts';
        $role_account_delete->save();


    }
}
