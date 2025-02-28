<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AdmissionSeeder::class,
            AwardSeeder::class,
            BioSeeder::class,
            BlogCategorySeeder::class,
            EducationSeeder::class,
            FirmSeeder::class,
            LanguageSeeder::class,
            LevelSeeder::class,
            LicenseSeeder::class,
            MembershipSeeder::class,
            PracticeAreaSeeder::class,
            // ResourceCategorySeeder::class,
            StatesTableSeeder::class,
            UserSeeder::class,
            WeeksSeeder::class,
        ]);
    }
}
