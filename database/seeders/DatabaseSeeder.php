<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Super Admin
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Create Companies
        $c1 = Company::create([
            'name' => 'Tech Corp',
            'email' => 'tech@example.com',
            'domain' => 'tech-corp',
        ]);

        $c2 = Company::create([
            'name' => 'Fashion Store',
            'email' => 'fashion@example.com',
            'domain' => 'fashion-store',
        ]);

        // 3. Create permissions and roles for companies.
        // Wait, spatie permission needs a company context.
        setPermissionsTeamId($c1->id);
        $role1 = Role::create(['name' => 'Admin']);
        $u1 = User::create([
            'name' => 'Tech Admin',
            'email' => 'techadmin@example.com',
            'password' => Hash::make('password'),
            'company_id' => $c1->id,
        ]);
        $u1->assignRole($role1);

        setPermissionsTeamId($c2->id);
        $role2 = Role::create(['name' => 'Admin']);
        $u2 = User::create([
            'name' => 'Fashion Admin',
            'email' => 'fashionadmin@example.com',
            'password' => Hash::make('password'),
            'company_id' => $c2->id,
        ]);
        $u2->assignRole($role2);
        
        // 4. Default Site Settings
        \App\Models\SiteSetting::insert([
            ['key' => 'site_name', 'value' => 'Daraz Clone'],
            ['key' => 'site_logo', 'value' => ''],
            ['key' => 'primary_color', 'value' => '#f85606'],
            ['key' => 'contact_email', 'value' => 'support@darazclone.com'],
            ['key' => 'phone_number', 'value' => '+1234567890'],
        ]);

        $this->call(ProductSeeder::class);
    }
}
