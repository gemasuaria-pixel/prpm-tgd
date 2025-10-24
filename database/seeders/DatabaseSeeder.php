<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Lokal Indonesia

        // === Buat Roles ===
        $adminRole       = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $ketuaprpmRole   = Role::firstOrCreate(['name' => 'ketua_prpm', 'guard_name' => 'web']);
        $dosenRole       = Role::firstOrCreate(['name' => 'dosen', 'guard_name' => 'web']);
        $reviewerRole    = Role::firstOrCreate(['name' => 'reviewer', 'guard_name' => 'web']);

        // === Buat Admin ===
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Super',
                'full_name' => 'Admin Super, S.Kom, M.Kom',
                'password' => Hash::make('12345678'),
                'status' => 'approved',
            ]
        );
        $superAdmin->assignRole($adminRole);

        // === Buat Ketua PRPM ===
        $ketuaprpm = User::firstOrCreate(
            ['email' => 'ketuaprpm@example.com'],
            [
                'name' => 'Ketua PRPM',
                'full_name' => 'Ketua PRPM, S.Kom, M.Kom',
                'password' => Hash::make('prpm1582004'),
                'status' => 'approved',
            ]
        );
        $ketuaprpm->assignRole($ketuaprpmRole);

        // === Data Program Studi untuk dosen ===
        $programStudis = ['Sistem Informasi', 'Sistem Komputer'];

        // === Generate 10 dosen dummy ===
        for ($i = 1; $i <= 10; $i++) {
            $name = $faker->name;
            $fullName = $name . ', S.Kom, M.Kom';

            $dosen = User::firstOrCreate(
                ['email' => "dosen$i@example.com"],
                [
                    'name' => $name,
                    'full_name' => $fullName,
                    'nidn' => $faker->unique()->numerify('##########'),
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date('Y-m-d', '-30 years'),
                    'institusi' => 'Universitas ' . $faker->city,
                    'program_studi' => $programStudis[array_rand($programStudis)],
                    'alamat' => $faker->address,
                    'kontak' => $faker->numerify('08##########'),
                    'password' => Hash::make('dosen123'),
                    'status' => 'approved',
                ]
            );

            // Kalau dosen ke-1 → assign dua role
            if ($i === 1) {
                $dosen->assignRole([$dosenRole, $reviewerRole]);
            } else {
                $dosen->assignRole($dosenRole);
            }
        }

        // === Generate 3 reviewer dummy ===
        for ($i = 1; $i <= 3; $i++) {
            $name = $faker->name;
            $fullName = $name . ', S.Kom, M.Kom';

            $reviewer = User::firstOrCreate(
                ['email' => "reviewer$i@example.com"],
                [
                    'name' => $name,
                    'full_name' => $fullName,
                    'password' => Hash::make('reviewer123'),
                    'status' => 'approved',
                ]
            );
            $reviewer->assignRole($reviewerRole);
        }
    }
}
