<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LearningLanguagesSeeder::class);
        $this->call(LanguageVariantsTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);

        $this->call(ListeningTopicsTableSeeder::class);
        $this->call(ListeningTableSeeder::class);

        $this->call(DictationTopicsTableSeeder::class);
        $this->call(DictationsTableSeeder::class);

        $this->call(SpellingTopicsTableSeeder::class);
        $this->call(SpellingTableSeeder::class);

        $this->call(NumberTopicsTableSeeder::class);
        $this->call(NumberTableSeeder::class);
    }
}
