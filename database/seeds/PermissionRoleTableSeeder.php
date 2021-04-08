<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $permissionsFiltered = $permissions->reject(function ($permission, $key) {
            return in_array($permission->key, ['add_orders']);
        });

        $role->permissions()->sync(
            $permissionsFiltered->pluck('id')->all()
        );
    }
}
