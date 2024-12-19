<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = Carbon::now();

        $categories = [
            ['name' => 'Tax Planning Strategies', 'created_at' => $now, 'sort_order' => '1'],
            ['name' => 'Estate and Wealth Management', 'created_at' => $now, 'sort_order' => '2'],
            ['name' => 'Business Tax Essentials', 'created_at' => $now, 'sort_order' => '3'],
            ['name' => 'Legal Updates in Tax Law', 'created_at' => $now, 'sort_order' => '4'],
            ['name' => 'Tax Controversy and Resolution', 'created_at' => $now, 'sort_order' => '5'],
        ];

        DB::table('blog_category')->insert($categories);
    }
}