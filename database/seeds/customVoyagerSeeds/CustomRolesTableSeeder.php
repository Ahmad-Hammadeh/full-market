<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\Role;

class CustomRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $role = Role::firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('backend.admin'),
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'editor']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => 'Editor',
            ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                'display_name' => __('backend.user'),
            ])->save();
        }
    }
}
