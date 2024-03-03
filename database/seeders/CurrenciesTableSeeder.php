<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('currencies')->insert([
            [
                'id' => 1,
                'code' => 'USD',
                'name' => 'United States Dollar',
                'symbol' => '$',
                'premium_price' => 9.9,
                'enable_decimal_places' => true
            ],
            [
                'id' => 2,
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'premium_price' => 9.9,
                'enable_decimal_places' => true
            ],
            [
                'id' => 3,
                'code' => 'GBP',
                'name' => 'British Pound Sterling',
                'symbol' => '£',
                'premium_price' => 9.9,
                'enable_decimal_places' => true
            ],
            [
                'id' => 4,
                'code' => 'CHF',
                'name' => 'Swiss Franc',
                'symbol' => 'CHF',
                'premium_price' => 11.9,
                'enable_decimal_places' => true
            ],
            [
                'id' => 5,
                'code' => 'JPY',
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'premium_price' => 1390,
                'enable_decimal_places' => false
            ],
            [
                'id' => 6,
                'code' => 'AUD',
                'name' => 'Australian Dollar',
                'symbol' => 'A$',
                'premium_price' => 14.9,
                'enable_decimal_places' => true
            ],
            [
                'id' => 7,
                'code' => 'CAD',
                'name' => 'Canadian Dollar',
                'symbol' => 'C$',
                'premium_price' => 14.9,
                'enable_decimal_places' => true
            ],
            [
                'id' => 8,
                'code' => 'CZK',
                'name' => 'Czech Koruna',
                'symbol' => 'Kč',
                'premium_price' => 249,
                'enable_decimal_places' => true
            ],
            [
                'id' => 9,
                'code' => 'MXN',
                'name' => 'Mexican Peso',
                'symbol' => '$',
                'premium_price' => 199,
                'enable_decimal_places' => true
            ],
            [
                'id' => 10,
                'code' => 'PLN',
                'name' => 'Polish Zloty',
                'symbol' => 'zł‚',
                'premium_price' => 49,
                'enable_decimal_places' => true
            ],
            [
                'id' => 11,
                'code' => 'RUB',
                'name' => 'Russian Ruble',
                'symbol' => '₽',
                'premium_price' => 1190,
                'enable_decimal_places' => true
            ],
            [
                'id' => 12,
                'code' => 'TRY',
                'name' => 'Turkish Lira',
                'symbol' => '₺',
                'premium_price' => 149,
                'enable_decimal_places' => true
            ],
            [
                'id' => 13,
                'code' => 'BRL',
                'name' => 'Brazilian Real',
                'symbol' => 'R$',
                'premium_price' => 49.9,
                'enable_decimal_places' => true
            ],
            [
                'id' => 14,
                'code' => 'SEK',
                'name' => 'Swedish Krona',
                'symbol' => 'kr',
                'premium_price' => 119,
                'enable_decimal_places' => true
            ],
            [
                'id' => 15,
                'code' => 'NOK',
                'name' => 'Norwegian Krone',
                'symbol' => 'kr',
                'premium_price' => 119,
                'enable_decimal_places' => true
            ],
            [
                'id' => 16,
                'code' => 'ILS',
                'name' => 'Israeli New Shekel',
                'symbol' => '₪',
                'premium_price' => 39,
                'enable_decimal_places' => true
            ],
            [
                'id' => 17,
                'code' => 'AED',
                'name' => 'United Arab Emirates Dirham',
                'symbol' => 'د.إ',
                'premium_price' => 49,
                'enable_decimal_places' => true
            ],
            [
                'id' => 18,
                'code' => 'DKK',
                'name' => 'Danish Krone',
                'symbol' => 'kr',
                'premium_price' => 75,
                'enable_decimal_places' => true
            ],
            [
                'id' => 19,
                'code' => 'HUF',
                'name' => 'Hungarian Forint',
                'symbol' => 'Ft',
                'premium_price' => 3900,
                'enable_decimal_places' => true
            ],
            [
                'id' => 20,
                'code' => 'INR',
                'name' => 'Indian Rupee',
                'symbol' => '₹',
                'premium_price' => 890,
                'enable_decimal_places' => true
            ],
            [
                'id' => 21,
                'code' => 'CNY',
                'name' => 'Chinese Yuan',
                'symbol' => '¥',
                'premium_price' => 79,
                'enable_decimal_places' => true
            ],
            [
                'id' => 22,
                'code' => 'UAH',
                'name' => 'Ukrainian Hryvnia',
                'symbol' => '₴',
                'premium_price' => 390,
                'enable_decimal_places' => true
            ],
            [
                'id' => 23,
                'code' => 'MAD',
                'name' => 'Moroccan Dirham',
                'symbol' => 'د.م.',
                'premium_price' => 109,
                'enable_decimal_places' => true
            ],
            [
                'id' => 24,
                'code' => 'EGP',
                'name' => 'Egyptian Pound',
                'symbol' => '£',
                'premium_price' => 290,
                'enable_decimal_places' => true
            ],
        ]);
    }
}
