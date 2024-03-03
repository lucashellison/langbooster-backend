<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DictationTopicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dictation_topics')->insert([
            ['id' => 1, 'learning_language_id' => 1, 'description' => 'Arts', 'sort_order' => 1, 'enabled' => 1],
            ['id' => 2, 'learning_language_id' => 1, 'description' => 'Books', 'sort_order' => 2, 'enabled' => 1],
            ['id' => 3, 'learning_language_id' => 1, 'description' => 'Business', 'sort_order' => 3, 'enabled' => 1],
            ['id' => 4, 'learning_language_id' => 1, 'description' => 'Fashion', 'sort_order' => 4, 'enabled' => 1],
            ['id' => 5, 'learning_language_id' => 1, 'description' => 'Food', 'sort_order' => 5, 'enabled' => 1],
            ['id' => 6, 'learning_language_id' => 1, 'description' => 'Games', 'sort_order' => 6, 'enabled' => 1],
            ['id' => 7, 'learning_language_id' => 1, 'description' => 'Health', 'sort_order' => 7, 'enabled' => 1],
            ['id' => 8, 'learning_language_id' => 1, 'description' => 'Politics', 'sort_order' => 8, 'enabled' => 1],
            ['id' => 9, 'learning_language_id' => 1, 'description' => 'Science', 'sort_order' => 9, 'enabled' => 1],
            ['id' => 10, 'learning_language_id' => 1, 'description' => 'Short stories', 'sort_order' => 10, 'enabled' => 1],
            ['id' => 11, 'learning_language_id' => 1, 'description' => 'Science', 'sort_order' => 11, 'enabled' => 1],
            ['id' => 12, 'learning_language_id' => 1, 'description' => 'Technology', 'sort_order' => 12, 'enabled' => 1],
            ['id' => 13, 'learning_language_id' => 1, 'description' => 'Travel', 'sort_order' => 13, 'enabled' => 1]
        ]);
    }
}
