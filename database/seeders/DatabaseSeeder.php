<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mahasiswa;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Lokal Indonesia

        // =========================
        // 1. Buat Roles
        // =========================
        $adminRole       = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $ketuaprpmRole   = Role::firstOrCreate(['name' => 'ketua_prpm', 'guard_name' => 'web']);
        $dosenRole       = Role::firstOrCreate(['name' => 'dosen', 'guard_name' => 'web']);
        $reviewerRole    = Role::firstOrCreate(['name' => 'reviewer', 'guard_name' => 'web']);

        // =========================
        // 2. Buat Admin
        // =========================
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

        // =========================
        // 3. Buat Ketua PRPM
        // =========================
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

        // =========================
        // 4. Buat 20 mahasiswa dummy
        // =========================
        $prodis = ['Sistem Informasi', 'Sistem Komputer'];

        for ($j = 1; $j <= 20; $j++) {
            Mahasiswa::create([
                'nama' => $faker->name,
                'nim' => $faker->unique()->numerify('20########'),
                'prodi' => $prodis[array_rand($prodis)],
                'email' => $faker->unique()->safeEmail,
                'no_hp' => $faker->numerify('08##########'),
                'alamat' => $faker->address,
            ]);
        }

        // =========================
        // 5. Buat 10 dosen dummy
        // =========================
        $programStudis = ['Sistem Informasi', 'Sistem Komputer'];

        for ($k = 1; $k <= 10; $k++) {
            $name = $faker->name;
            $fullName = $name . ', S.Kom, M.Kom';

            $dosen = User::firstOrCreate(
                ['email' => "dosen$k@example.com"],
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

            // Dosen pertama assign dua role
            if ($k === 1) {
                $dosen->assignRole([$dosenRole, $reviewerRole]);
            } else {
                $dosen->assignRole($dosenRole);
            }
        }

        // =========================
        // 6. Buat 3 reviewer dummy
        // =========================
        for ($l = 1; $l <= 3; $l++) {
            $name = $faker->name;
            $fullName = $name . ', S.Kom, M.Kom';

            $reviewer = User::firstOrCreate(
                ['email' => "reviewer$l@example.com"],
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
