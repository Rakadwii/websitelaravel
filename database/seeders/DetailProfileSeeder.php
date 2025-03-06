<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetailProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insert data ke table pegawai
        DB::table('detail_profile')->insert([
            'nama'=> 'Raka dwi',
            'username'=> 'raka',
            'email'=>'rakadwi2938@gmail.com',
            'password'=>'rakadwi123'
        ]);
    }
}
