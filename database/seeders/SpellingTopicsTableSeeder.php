<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpellingTopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('spelling_topics')->insert([
            ['id' => 1, 'learning_language_id' => 1, 'description' => 'Personal Names', 'sort_order' => 1, 'enabled' => 1],
            ['id' => 2, 'learning_language_id' => 1, 'description' => 'Cities and Countries', 'sort_order' => 2, 'enabled' => 1],
            ['id' => 3, 'learning_language_id' => 1, 'description' => 'Animals', 'sort_order' => 3, 'enabled' => 1],
            ['id' => 4, 'learning_language_id' => 1, 'description' => 'Food and Drinks', 'sort_order' => 4, 'enabled' => 1],
        ]);
    }
}
