<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\role;
use App\Models\StatePintu;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        role::create([
            'namarole' => 'admin',
        ]);
        role::create([
            'namarole' => 'satpam',
        ]);
        role::create([
            'namarole' => 'warga',
        ]);
        User::create([
            'nama' => 'aldan',
            'username' => 'aldan',
            'email' => 'aldan@gmail.com',
            'password' => 'aldandata',
            'roles' => 1,
        ]);
        StatePintu::create([
            'keterangan' => 'masuk',
            'state' => 0,
        ]);
        StatePintu::create([
            'keterangan' => 'keluar',
            'state' => 0,
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}