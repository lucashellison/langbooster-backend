<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NumberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('number')->insert([
            [
                'id' => 1,
                'number_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '70',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Tens+and+Units+Phrase1.mp3',
                'sort_order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 2,
                'number_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '73',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Tens+and+Units+Phrase2.mp3',
                'sort_order' => 2,
                'enabled' => 1
            ],
            [
                'id' => 3,
                'number_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '28',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Tens+and+Units+Phrase3.mp3',
                'sort_order' => 3,
                'enabled' => 1
            ],
            [
                'id' => 4,
                'number_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '93',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Tens+and+Units+Phrase4.mp3',
                'sort_order' => 4,
                'enabled' => 1
            ],
            [
                'id' => 5,
                'number_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '34',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Tens+and+Units+Phrase5.mp3',
                'sort_order' => 5,
                'enabled' => 0
            ],
            [
                'id' => 6,
                'number_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '99',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Tens+and+Units+Phrase6.mp3',
                'sort_order' => 6,
                'enabled' => 1
            ],
            [
                'id' => 7,
                'number_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '33',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Tens+and+Units+Phrase7.mp3',
                'sort_order' => 7,
                'enabled' => 1
            ],
            [
                'id' => 8,
                'number_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '48',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Tens+and+Units+Phrase8.mp3',
                'sort_order' => 8,
                'enabled' => 1
            ],
            [
                'id' => 9,
                'number_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '88',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Tens+and+Units+Phrase9.mp3',
                'sort_order' => 9,
                'enabled' => 1
            ],
            [
                'id' => 10,
                'number_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '35',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Tens+and+Units+Phrase10.mp3',
                'sort_order' => 10,
                'enabled' => 1
            ],
            [
                'id' => 11,
                'number_topic_id' => 4,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '4894',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Thousand+Thinkers+Phrase11.mp3',
                'sort_order' => 11,
                'enabled' => 1
            ],
            [
                'id' => 12,
                'number_topic_id' => 4,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '2044',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Thousand+Thinkers+Phrase12.mp3',
                'sort_order' => 12,
                'enabled' => 1
            ],
            [
                'id' => 13,
                'number_topic_id' => 4,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '1515',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Thousand+Thinkers+Phrase13.mp3',
                'sort_order' => 13,
                'enabled' => 1
            ],
            [
                'id' => 14,
                'number_topic_id' => 4,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '5722',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Thousand+Thinkers+Phrase14.mp3',
                'sort_order' => 14,
                'enabled' => 1
            ],
            [
                'id' => 15,
                'number_topic_id' => 4,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => '6498',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Number+-+Thousand+Thinkers+Phrase15.mp3',
                'sort_order' => 15,
                'enabled' => 1
            ],
            [
                'id' => 16,
                'number_topic_id' => 4,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '8073',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Thousand+Thinkers+Phrase16.mp3',
                'sort_order' => 16,
                'enabled' => 1
            ],
            [
                'id' => 17,
                'number_topic_id' => 4,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '9179',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Thousand+Thinkers+Phrase17.mp3',
                'sort_order' => 17,
                'enabled' => 1
            ],
            [
                'id' => 18,
                'number_topic_id' => 4,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '7757',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Thousand+Thinkers+Phrase18.mp3',
                'sort_order' => 18,
                'enabled' => 1
            ],
            [
                'id' => 19,
                'number_topic_id' => 4,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '2511',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Thousand+Thinkers+Phrase19.mp3',
                'sort_order' => 19,
                'enabled' => 1
            ],
            [
                'id' => 20,
                'number_topic_id' => 4,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => '9152',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Number+-+Thousand+Thinkers+Phrase20.mp3',
                'sort_order' => 20,
                'enabled' => 1
            ],
        ]);
    }
}
