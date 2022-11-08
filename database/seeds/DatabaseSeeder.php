<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'username' => 'administrator',
                'level' => 'Super Admin',
                'password' => Hash::make('admin'),
            ],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'level' => 'Admin',
                'password' => Hash::make('admin'),
            ],
        ]);
        DB::table('data_kotas')->insert([[
            'kota' => 'CIWANDAN',
        ],[
            'kota' => 'CILEGON',
        ],[
            'kota' => 'SURALAYA',
        ],[
            'kota' => 'CIRUAS',
        ],[
            'kota' => 'SERANG',
        ],[
            'kota' => 'CIKANDE',
        ],[
            'kota' => 'PANDEGLANG',
        ],[
            'kota' => 'PANIMBANG',
        ],[
            'kota' => 'BALARAJA',
        ],[
            'kota' => 'LEGOK',
        ],[
            'kota' => 'CISAUK',
        ],[
            'kota' => 'TANGERANG',
        ],[
            'kota' => 'JAKARTA BARAT',
        ],[
            'kota' => 'JAKARTA TIMUR',
        ],[
            'kota' => 'JAKARTA UTARA',
        ],[
            'kota' => 'JAKARTA PUSAT',
        ],[
            'kota' => 'JAKARTA SELATAN',
        ],[
            'kota' => 'BEKASI UTARA',
        ],[
            'kota' => 'BEKASI TIMUR',
        ],[
            'kota' => 'BEKASI SELATAN',
        ],[
            'kota' => 'BEKASI BARAT',
        ],[
            'kota' => 'CIKARANG UTARA',
        ],[
            'kota' => 'CIKARANG TIMUR',
        ],[
            'kota' => 'CIKARANG SELATAN',
        ],[
            'kota' => 'CIKARANG BARAT',
        ],[
            'kota' => 'BOGOR',
        ],[
            'kota' => 'CIANJUR',
        ],[
            'kota' => 'BANDUNG',
        ],[
            'kota' => 'KARAWANG',
        ],[
            'kota' => 'KARAWANG BARAT',
        ],[
            'kota' => 'KARAWANG TIMUR',
        ],[
            'kota' => 'PALIMANAN',
        ],[
            'kota' => 'KERTAJATI',
        ],[
            'kota' => 'LAMPUNG',
        ],[
            'kota' => 'LAMPUNG TARAHAN',
        ],[
            'kota' => 'LAMPUNG TEGINENENG',
        ],[
            'kota' => 'BOJONEGARA',
        ],[
            'kota' => 'PURWAKARTA',
        ],[
            'kota' => 'BITUNG',
        ],[
            'kota' => 'CILEUNGSI',
        ],[
            'kota' => 'PADALARANG',
        ]]);
    }
}
