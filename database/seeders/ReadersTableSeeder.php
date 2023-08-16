<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReadersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('readerstable')->insert([
        ['user_id' => '001', 'password' => bcrypt('bentram37')],
        ['user_id' => '002', 'password' => bcrypt('blackroad19')],
        ['user_id' => '003', 'password' => bcrypt('murkypaste20')],
    ]);
    }
}
