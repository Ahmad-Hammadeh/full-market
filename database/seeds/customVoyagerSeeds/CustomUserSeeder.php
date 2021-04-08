<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;

class CustomUserSeeder extends Seeder
{
   /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {

        $editor_role = Role::where('name', 'editor')->firstOrFail();

        if (User::count() == 0){

            $admin_role = Role::where('name', 'admin')->firstOrFail();

            User::create([
                'name' => 'super_admin',
                'email' => 'super_admin@gmail.com',
                'password' => bcrypt('12345678'),
                'remember_token' => Str::random(60),
                'role_id' => $admin_role->id
            ]);

        }

        User::create([
            'name' => 'editor',
            'email' => 'editor@gmail.com',
            'password' => bcrypt('12345678'),
            'remember_token' => Str::random(60),
            'role_id' => $editor_role->id
        ]);

    }
}
