<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageVariantsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('language_variants')->insert([
            ['id' => 1, 'learning_language_id' => 1, 'code' => 'en-US', 'description' => 'American English', 'sort_order' => 1, 'enabled' => 1],
            ['id' => 2, 'learning_language_id' => 1, 'code' => 'en-GB', 'description' => 'British English', 'sort_order' => 2, 'enabled' => 1],
        ]);
    }
}
