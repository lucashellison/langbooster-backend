<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpellingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('spelling')->insert([
            [
                'id' => 1,
                'spelling_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Michael',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase1+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase1+(Spelled).mp3',
                'sort_order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 2,
                'spelling_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Jennifer',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase2+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase2+(Spelled).mp3',
                'sort_order' => 2,
                'enabled' => 1
            ],
            [
                'id' => 3,
                'spelling_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'James',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase3+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase3+(Spelled).mp3',
                'sort_order' => 3,
                'enabled' => 1
            ],
            [
                'id' => 4,
                'spelling_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Linda',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase4+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase4+(Spelled).mp3',
                'sort_order' => 4,
                'enabled' => 1
            ],
            [
                'id' => 5,
                'spelling_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'John',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase5+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Personal+Names+-+Phrase5+(Spelled).mp3',
                'sort_order' => 5,
                'enabled' => 0
            ],
            [
                'id' => 6,
                'spelling_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Patricia',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase6+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase6+(Spelled).mp3',
                'sort_order' => 6,
                'enabled' => 1
            ],
            [
                'id' => 7,
                'spelling_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Robert',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase7+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase7+(Spelled).mp3',
                'sort_order' => 7,
                'enabled' => 1
            ],
            [
                'id' => 8,
                'spelling_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Jessica',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase8+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase8+(Spelled).mp3',
                'sort_order' => 8,
                'enabled' => 1
            ],
            [
                'id' => 9,
                'spelling_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'William',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase9+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase9+(Spelled).mp3',
                'sort_order' => 9,
                'enabled' => 1
            ],
            [
                'id' => 10,
                'spelling_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Elizabeth',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase10+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Personal+Names+-+Phrase10+(Spelled).mp3',
                'sort_order' => 10,
                'enabled' => 1
            ],
            [
                'id' => 11,
                'spelling_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'New York',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase11+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase11+(Spelled).mp3',
                'sort_order' => 11,
                'enabled' => 1
            ],
            [
                'id' => 12,
                'spelling_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Brazil',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase12+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase12+(Spelled).mp3',
                'sort_order' => 12,
                'enabled' => 1
            ],
            [
                'id' => 13,
                'spelling_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Paris',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase13+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase13+(Spelled).mp3',
                'sort_order' => 13,
                'enabled' => 1
            ],
            [
                'id' => 14,
                'spelling_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Canada',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase14+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase14+(Spelled).mp3',
                'sort_order' => 14,
                'enabled' => 1
            ],
            [
                'id' => 15,
                'spelling_topic_id' => 2,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Tokyo',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase15+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(American)+Spelling+-+Cities+and+Countries+-+Phrase15+(Spelled).mp3',
                'sort_order' => 15,
                'enabled' => 1
            ],
            [
                'id' => 16,
                'spelling_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Germany',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase16+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase16+(Spelled).mp3',
                'sort_order' => 16,
                'enabled' => 1
            ],
            [
                'id' => 17,
                'spelling_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Sydney',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase17+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase17+(Spelled).mp3',
                'sort_order' => 17,
                'enabled' => 1
            ],
            [
                'id' => 18,
                'spelling_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'India',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase18+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase18+(Spelled).mp3',
                'sort_order' => 18,
                'enabled' => 1
            ],
            [
                'id' => 19,
                'spelling_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'London',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase19+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase19+(Spelled).mp3',
                'sort_order' => 19,
                'enabled' => 1
            ],
            [
                'id' => 20,
                'spelling_topic_id' => 2,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'South Africa',
                'path_normal_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase20+(Normal).mp3',
                'path_spelled_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/(British)+Spelling+-+Cities+and+Countries+-+Phrase20+(Spelled).mp3',
                'sort_order' => 20,
                'enabled' => 1
            ],

        ]);
    }
}
