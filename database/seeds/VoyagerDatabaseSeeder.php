<?php

use Illuminate\Database\Seeder;
use TCG\Voyager\Traits\Seedable;

class VoyagerDatabaseSeeder extends Seeder
{
    use Seedable;

    protected $seedersPath = __DIR__.'/';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed('DataTypesTableSeeder');
        $this->seed('CustomDataTypesTableSeeder');
        $this->seed('DataRowsTableSeeder');
        $this->seed('CustomDataRowsTableSeeder');
        $this->seed('MenusTableSeeder');
        $this->seed('CustomMenusTableSeeder');
        $this->seed('MenuItemsTableSeeder');
        $this->seed('CustomMenuItemsTableSeeder');
        $this->seed('RolesTableSeeder');
        $this->seed('CustomRolesTableSeeder');
        $this->seed('PermissionsTableSeeder');
        $this->seed('CustomPermissionsTableSeeder');
        $this->seed('PermissionRoleTableSeeder');
        $this->seed('CustomPermissionRoleTableSeeder');
        $this->seed('SettingsTableSeeder');
        $this->seed('CustomSettingsTableSeeder');
        $this->seed('CustomUserSeeder');

    }
}
