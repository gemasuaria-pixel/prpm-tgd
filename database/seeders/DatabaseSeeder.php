<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $ketuaprpmRole = Role::firstOrCreate(['name' => 'ketua_prpm', 'guard_name' => 'web']);
        $dosenRole = Role::firstOrCreate(['name' => 'dosen', 'guard_name' => 'web']);
        $reviewerRole = Role::firstOrCreate(['name' => 'reviewer', 'guard_name' => 'web']); // 👈 role baru

        // Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Super',
                'password' => Hash::make('12345678'),
                'status' => 'approved',
            ]
        );
        $superAdmin->assignRole($adminRole);

        // Ketua PRPM
        $ketuaprpm = User::firstOrCreate(
            ['email' => 'ketuaprpm@example.com'],
            [
                'name' => 'Ketua PRPM',
                'password' => Hash::make('prpm1582004'),
                'status' => 'approved',
            ]
        );
        $ketuaprpm->assignRole($ketuaprpmRole);

        // Generate 10 dosen dummy
        for ($i = 1; $i <= 10; $i++) {
            $dosen = User::firstOrCreate(
                ['email' => "dosen$i@example.com"],
                [
                    'name' => "Dosen $i",
                    'password' => Hash::make('dosen123'),
                    'status' => 'approved',
                ]
            );
            $dosen->assignRole($dosenRole);
        }

        // Generate 3 reviewer dummy
        for ($i = 1; $i <= 3; $i++) {
            $reviewer = User::firstOrCreate(
                ['email' => "reviewer$i@example.com"],
                [
                    'name' => "Reviewer $i",
                    'password' => Hash::make('reviewer123'),
                    'status' => 'approved',
                ]
            );
            $reviewer->assignRole($reviewerRole);
        }
    }
}
