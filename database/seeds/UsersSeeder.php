<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat Role Admin
        $roleAdmin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
        ]);

        // Membuat Role Admin
        $roleMember = Role::create([
            'name' => 'member',
            'display_name' => 'Member',
        ]);

        // Contoh Membuat Dengan Role Admin
        $adminUser = User::create([
            'name' => 'Admin Tamvan',
            'email' => 'admin@main.com',
            'password' => bcrypt('rahasia'),
        ]);

        $adminUser->attachRole($roleAdmin);

        // Contoh Membuat Dengan Role User
        $memberUser = User::create([
            'name' => 'Member Tamvan',
            'email' => 'member@main.com',
            'password' => bcrypt('rahasia'),
        ]);
        
        $memberUser->attachRole($roleMember);
    }
}
