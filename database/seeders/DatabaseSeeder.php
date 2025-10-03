<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web']
        );
          $ketuaprpmRole = Role::firstOrCreate(
            ['name' => 'ketuaPRPM', 'guard_name' => 'web']
        );
        $userRole = Role::firstOrCreate(
            ['name' => 'user', 'guard_name' => 'web']
        );
      

        $role1 = Role::find('1');
        $role2 = Role::find('2');
        $role3 = Role::find('3');



        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('12345678'),
                'status' => 'approved',
            ]
        );
        $ketuaprpm= User::firstOrCreate(
            ['email' => 'prpmtgd@example.com'],
            [
                'name' => 'ketuaprpm',
                'password' => Hash::make('prpm1582004'),
                'status' => 'approved',
            ]
        );
        $ketuaprpm= User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'anto ketes',
                'password' => Hash::make('user12345'),
                'status' => 'approved',
            ]
        )->assignRole($role3);
        $superAdmin->assignRole($role1);
        $ketuaprpm->assignRole($role2);
       
    }
}
