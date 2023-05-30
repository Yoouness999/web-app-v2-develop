<?php

use App\OrderPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ArxminPermissionsSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $permissions = [
            'users',
            'bookings',
            'items',
            'invoices',
            'affiliates',
            'employees',
            'website'
        ];

        foreach ($permissions as $permission) {
            \App\ArxminPermission::create(['slug' => $permission]);
        }

        /**
         * Give access to all arxmin_users (by default)
         */
        $permissions = \App\ArxminPermission::all();

        foreach (\App\ArxminUser::all() as $user) {
            foreach ($permissions as $permission) {
                DB::table('arxmin_user_permissions')->insert([
                    'arxmin_user_id' => $user->id,
                    'arxmin_permission_id' => $permission->id
                ]);
            }
        }
    }
}
