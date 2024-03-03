<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NumberTopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('number_topics')->insert([
            ['id' => 1, 'learning_language_id' => 1, 'description' => 'Foundational Figures', 'sort_order' => 1, 'enabled' => 1],
            ['id' => 2, 'learning_language_id' => 1, 'description' => 'Tens and Units', 'sort_order' => 2, 'enabled' => 1],
            ['id' => 3, 'learning_language_id' => 1, 'description' => 'Hundred Heroes', 'sort_order' => 3, 'enabled' => 1],
            ['id' => 4, 'learning_language_id' => 1, 'description' => 'Thousand Thinkers', 'sort_order' => 4, 'enabled' => 1],
            ['id' => 5, 'learning_language_id' => 1, 'description' => 'Tens of Thousands', 'sort_order' => 5, 'enabled' => 1],
            ['id' => 6, 'learning_language_id' => 1, 'description' => 'Hundred Thousand Heavens', 'sort_order' => 6, 'enabled' => 1],
            ['id' => 7, 'learning_language_id' => 1, 'description' => 'Millionaire Minds', 'sort_order' => 7, 'enabled' => 1],
        ]);
    }
}
