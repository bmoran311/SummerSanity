<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BioSeeder extends Seeder
{
    public function run()
    {
        // Only seed the bio table if it's empty
        if (DB::table('bio')->count() > 0) {
            return;
        }
        DB::table('bio')->insert([
            [
                'first_name' => 'Megan',
                'middle_initial' => 'R',
                'last_name' => 'Spivey',
                'email' => 'megan@career-outfitters.com',
                'phone_number' => '843.723.2000',
                'headshot' => 'testing.jpg',
                'created_at' => now(),
                'firm_id' => 1,
            ],
            [
                'first_name' => 'Brian',
                'middle_initial' => 'E',
                'last_name' => 'Moran',
                'email' => 'bmoran@enertia-inc.com',
                'phone_number' => '843.723.2000',
                'headshot' => 'testing.jpg',
                'created_at' => now(),
                'firm_id' => 1,
            ],
            [
                'first_name' => 'Megan',
                'middle_initial' => null,
                'last_name' => 'Petrik',
                'email' => 'megan.e.petrik@gmail.com',
                'phone_number' => '843.723.2000',
                'headshot' => 'testing.jpg',
                'created_at' => now(),
                'firm_id' => 1,
            ],
        ]);
    }
}
