<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class CustomPermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'editor')->firstOrFail();

        $permissions = Permission::all();

        $permissionsFiltered = $permissions->reject(function ($permission, $key) {
            return in_array($permission->key, [
                'browse_database',
                'browse_media',
                'browse_compass',
                'delete_menus',
                'delete_pages',
                'browse_roles',
                'read_roles',
                'edit_roles',
                'add_roles',
                'delete_roles',
                'browse_users',
                'edit_users',
                'add_users',
                'delete_users',
                'delete_categories',
                'delete_settings',
                'delete_products',
                'delete_coupons',
                'delete_category',
                'add_orders',
            ]);
        });

        $role->permissions()->sync(
            $permissionsFiltered->pluck('id')->all()
        );
    }
}
