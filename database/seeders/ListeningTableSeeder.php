<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListeningTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('listening')->insert([
            [
                'id' => 1,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Yesterday, we went to the park and had a picnic.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase1.mp3',
                'sort_order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 2,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Can you help me find my glasses? I lost them.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase2.mp3',
                'sort_order' => 2,
                'enabled' => 1
            ],
            [
                'id' => 3,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'I\'m thinking of baking a cake for dessert tonight.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase3.mp3',
                'sort_order' => 3,
                'enabled' => 1
            ],
            [
                'id' => 4,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'The weather is lovely today, perfect for a walk.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase4.mp3',
                'sort_order' => 4,
                'enabled' => 1
            ],
            [
                'id' => 5,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Have you seen the new movie at the cinema?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase5.mp3',
                'sort_order' => 5,
                'enabled' => 0
            ],
            [
                'id' => 6,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Let\'s go grocery shopping this afternoon, we need milk.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase6.mp3',
                'sort_order' => 6,
                'enabled' => 0
            ],
            [
                'id' => 7,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'I\'m learning to play the guitar, it\'s quite challenging.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase7.mp3',
                'sort_order' => 7,
                'enabled' => 0
            ],
            [
                'id' => 8,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Let\'s meet for coffee and catch up on our lives.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase8.mp3?v=1.1',
                'sort_order' => 8,
                'enabled' => 0
            ],
            [
                'id' => 9,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'My favorite book is missing; have you seen it?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase9.mp3',
                'sort_order' => 9,
                'enabled' => 0
            ],
            [
                'id' => 10,
                'listening_topic_id' => 1,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'The cat is sleeping in the sun, looking peaceful.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Everyday+Conversations+Phrase10.mp3',
                'sort_order' => 10,
                'enabled' => 0
            ],
            [
                'id' => 11,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Could I have a cup of tea, please?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase11.mp3',
                'sort_order' => 11,
                'enabled' => 1
            ],
            [
                'id' => 12,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'What\'s the weather like outside today?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase12.mp3',
                'sort_order' => 12,
                'enabled' => 1
            ],
            [
                'id' => 13,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'I\'m popping to the shops, do you need anything?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase13.mp3',
                'sort_order' => 13,
                'enabled' => 1
            ],
            [
                'id' => 14,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Shall we meet at the cafÃ© around half-past three?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase14.mp3',
                'sort_order' => 14,
                'enabled' => 1
            ],
            [
                'id' => 15,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'I\'ve got to catch the train to work this morning.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase15.mp3',
                'sort_order' => 15,
                'enabled' => 1
            ],
            [
                'id' => 16,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'How was your weekend? Did you do anything nice?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase16.mp3',
                'sort_order' => 16,
                'enabled' => 1
            ],
            [
                'id' => 17,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'I\'m quite knackered, had a long day at the office.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase17.mp3',
                'sort_order' => 17,
                'enabled' => 1
            ],
            [
                'id' => 18,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'What time are we having dinner tonight?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase18.mp3',
                'sort_order' => 18,
                'enabled' => 1
            ],
            [
                'id' => 19,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'I think I left my umbrella on the bus.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase19.mp3',
                'sort_order' => 19,
                'enabled' => 1
            ],
            [
                'id' => 20,
                'listening_topic_id' => 1,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Fancy a quick chat over lunch?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Everyday+Conversations+Phrase20.mp3',
                'sort_order' => 20,
                'enabled' => 1
            ],
            [
                'id' => 21,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'I need to check my emails before the meeting.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase21.mp3',
                'sort_order' => 21,
                'enabled' => 1
            ],
            [
                'id' => 22,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Let\'s have lunch together after the project presentation.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase22.mp3',
                'sort_order' => 22,
                'enabled' => 1
            ],
            [
                'id' => 23,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Today\'s conference will discuss market trends.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase23.mp3',
                'sort_order' => 23,
                'enabled' => 1
            ],
            [
                'id' => 24,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Please submit the financial report by Friday.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase24.mp3',
                'sort_order' => 24,
                'enabled' => 1
            ],
            [
                'id' => 25,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Our team is working on the quarter\'s closing.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase25.mp3',
                'sort_order' => 25,
                'enabled' => 1
            ],
            [
                'id' => 26,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'Can we schedule a video call to discuss this?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase26.mp3',
                'sort_order' => 26,
                'enabled' => 1
            ],
            [
                'id' => 27,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'The sales department exceeded its targets this month.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase27.mp3',
                'sort_order' => 27,
                'enabled' => 1
            ],
            [
                'id' => 28,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'We need more coffee in the break room.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase28.mp3',
                'sort_order' => 28,
                'enabled' => 1
            ],
            [
                'id' => 29,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'The strategic planning meeting is next week.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase29.mp3',
                'sort_order' => 29,
                'enabled' => 1
            ],
            [
                'id' => 30,
                'listening_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'text' => 'I\'m updating the software on my work computer.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Listening+-+Business+Phrase30.mp3',
                'sort_order' => 30,
                'enabled' => 1
            ],
            [
                'id' => 31,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'I\'ve organised a team briefing for tomorrow morning.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase31.mp3',
                'sort_order' => 31,
                'enabled' => 1
            ],
            [
                'id' => 32,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Could you please finalise the budget report by Monday?',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase32.mp3',
                'sort_order' => 32,
                'enabled' => 1
            ],
            [
                'id' => 33,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Our new marketing strategy focuses on online advertising.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase33.mp3',
                'sort_order' => 33,
                'enabled' => 1
            ],
            [
                'id' => 34,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'I\'ll be on annual leave next week for a short holiday.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase34.mp3',
                'sort_order' => 34,
                'enabled' => 1
            ],
            [
                'id' => 35,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'The company has been prioritising sustainability this year.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase35.mp3',
                'sort_order' => 35,
                'enabled' => 1
            ],
            [
                'id' => 36,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'We need to discuss the agenda for the upcoming meeting.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase36.mp3',
                'sort_order' => 36,
                'enabled' => 1
            ],
            [
                'id' => 37,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'I\'ve just updated the rota for the customer service team.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase37.mp3',
                'sort_order' => 37,
                'enabled' => 1
            ],
            [
                'id' => 38,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Our director will be speaking at the business conference in London.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase38.mp3',
                'sort_order' => 38,
                'enabled' => 1
            ],
            [
                'id' => 39,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'Please ensure all expenses are submitted by the end of the week.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase39.mp3',
                'sort_order' => 39,
                'enabled' => 1
            ],
            [
                'id' => 40,
                'listening_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'text' => 'The HR department is revising the employee handbook currently.',
                'path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Listening+-+Business+Phrase40.mp3',
                'sort_order' => 40,
                'enabled' => 1
            ]
        ]);
    }
}
