<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LearningLanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('learning_languages')->insert([
            'id' => 1,
            'code' => 'en',
            'description' => 'English',
            'sort_order' => 1,
            'enabled' => 1,
        ]);
    }
}
