<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BioSeeder extends Seeder
{
    public function run()
    {
        DB::table('bios')->insert([
            [
                'first_name' => 'Douglas',
                'middle_initial' => 'R',
                'last_name' => 'Foley',
                'email' => 'dfoley@taylorfoleylaw.com',
                'phone_number' => '843.723.2000',
            ],
            [
                'first_name' => 'Joseph',
                'middle_initial' => 'P',
                'last_name' => 'Foley',
                'email' => 'jfoley@taylorfoleylaw.com',
                'phone_number' => '843.723.2000',
            ],
            [
                'first_name' => 'Connor',
                'middle_initial' => null,
                'last_name' => 'Foley',
                'email' => 'cfoley@taylorfoleylaw.com',
                'phone_number' => '843.723.2000',
            ],
        ]);
    }
}