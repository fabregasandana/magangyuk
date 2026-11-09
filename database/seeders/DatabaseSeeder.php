<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Alip Hidayat',
                'email' => 'alip@gmail.com',
                'password' => Hash::make('alip123'),
            ],
            [
                'name' => 'Nabila Amriyanti',
                'email' => 'makucup@gmail.com',
                'password' => Hash::make('makucup123'),
            ],
            [
                'name' => 'Azam Darmansyah',
                'email' => 'pakucup@gmail.com',
                'password' => Hash::make('pakucup123'),
            ],
        ]);
    }
}
