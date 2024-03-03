<?php


use App\Models\GuestDictation;
use App\Models\Payment;
use App\Models\UserDictation;
use App\Models\UserDictationsReview;
use Database\Factories\UserFactory;
use Database\Factories\PaymentFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Dictation;

class DictationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }


    public function test_dictation_get_lessons()
    {

        $requestData = [
            'dictationTopicId' => 12,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/dictation/getLessons', $requestData);

        $response->assertStatus(200)
            ->assertJsonCount(1);
    }


    public function test_dictation_check_answer_correct()
    {

        $requestData = [
            'userInput' => 'Technology deeply permeates modern society. It influences how we communicate, interact, and understand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also permeate economics, making trade seamless and driving market trends. However, while technology brings myriad advantages, it also poses challenges. Issues such as privacy invasion and dependency require careful regulation. Balancing these aspects remains crucial to leverage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData);

        $response->assertStatus(200)
            ->assertJsonPath('points', 100)
            ->assertJsonPath('differences', 'Technology deeply permeates modern society. It influences how we communicate, interact, and understand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also permeate economics, making trade seamless and driving market trends. However, while technology brings myriad advantages, it also poses challenges. Issues such as privacy invasion and dependency require careful regulation. Balancing these aspects remains crucial to leverage the best technology offers while mitigating its drawbacks.');
    }

    public function test_dictation_check_answer_incorrect()
    {

        $requestData = [
            'userInput' => 'Technology dedeply permeates modern society. It influences how we communicate, interact, and undderstand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also perfmeate economics, making trade seamless and drfiving market trends. Hoswever, while technoldogy brings myriad advantages, it also poses challenges. Issues such as privacy invdasion and dependency require careful refgulation. Balancidng these aspefcts remains crucial to leverfage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData);

        $response->assertStatus(200)
            ->assertJsonPath('points', 86.3)
            ->assertJsonPath('differences', 'Technology <del>dedeply </del><ins>deeply </ins>permeates modern society. It influences how we communicate, interact, and <del>undderstand </del><ins>understand </ins>the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also <del>perfmeate </del><ins>permeate </ins>economics, making trade seamless and <del>drfiving </del><ins>driving </ins>market trends. <del>Hoswever, </del><ins>However, </ins>while <del>technoldogy </del><ins>technology </ins>brings myriad advantages, it also poses challenges. Issues such as privacy <del>invdasion </del><ins>invasion </ins>and dependency require careful <del>refgulation. Balancidng </del><ins>regulation. Balancing </ins>these <del>aspefcts </del><ins>aspects </ins>remains crucial to <del>leverfage </del><ins>leverage </ins>the best technology offers while mitigating its drawbacks.');
    }

    public function test_dictation_check_answer_retry()
    {

        $requestData = [
            'userInput' => 'Technology dedeply permeates modern society. It influences how we communicate, interact, and undderstand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also perfmeate economics, making trade seamless and drfiving market trends. Hoswever, while technoldogy brings myriad advantages, it also poses challenges. Issues such as privacy invdasion and dependency require careful refgulation. Balancidng these aspefcts remains crucial to leverfage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData);
        $guestDictationId = $response['guestDictationId'];

        $requestData = [
            'userInput' => 'Technology deeply permeates modern society. It influences how we communicate, interact, and understand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also permeate economics, making trade seamless and driving market trends. However, while technology brings myriad advantages, it also poses challenges. Issues such as privacy invasion and dependency require careful regulation. Balancing these aspects remains crucial to leverage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => true,
            'userDictationId' => null,
            'guestDictationId' => $guestDictationId
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData);

        $guestDictation = GuestDictation::find($guestDictationId);
        $this->assertEquals(100, $guestDictation['score']);

    }

    public function test_dictation_logged_check_answer_correct()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Technology deeply permeates modern society. It influences how we communicate, interact, and understand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also permeate economics, making trade seamless and driving market trends. However, while technology brings myriad advantages, it also poses challenges. Issues such as privacy invasion and dependency require careful regulation. Balancing these aspects remains crucial to leverage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonPath('points', 100)
            ->assertJsonPath('differences', 'Technology deeply permeates modern society. It influences how we communicate, interact, and understand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also permeate economics, making trade seamless and driving market trends. However, while technology brings myriad advantages, it also poses challenges. Issues such as privacy invasion and dependency require careful regulation. Balancing these aspects remains crucial to leverage the best technology offers while mitigating its drawbacks.');

    }

    public function test_dictation_logged_check_answer_incorrect()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Technology dedeply permeates modern society. It influences how we communicate, interact, and undderstand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also perfmeate economics, making trade seamless and drfiving market trends. Hoswever, while technoldogy brings myriad advantages, it also poses challenges. Issues such as privacy invdasion and dependency require careful refgulation. Balancidng these aspefcts remains crucial to leverfage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonPath('points', 86.3)
            ->assertJsonPath('differences', 'Technology <del>dedeply </del><ins>deeply </ins>permeates modern society. It influences how we communicate, interact, and <del>undderstand </del><ins>understand </ins>the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also <del>perfmeate </del><ins>permeate </ins>economics, making trade seamless and <del>drfiving </del><ins>driving </ins>market trends. <del>Hoswever, </del><ins>However, </ins>while <del>technoldogy </del><ins>technology </ins>brings myriad advantages, it also poses challenges. Issues such as privacy <del>invdasion </del><ins>invasion </ins>and dependency require careful <del>refgulation. Balancidng </del><ins>regulation. Balancing </ins>these <del>aspefcts </del><ins>aspects </ins>remains crucial to <del>leverfage </del><ins>leverage </ins>the best technology offers while mitigating its drawbacks.');
    }

    public function test_dictation_logged_check_answer_retry()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Technology dedeply permeates modern society. It influences how we communicate, interact, and undderstand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also perfmeate economics, making trade seamless and drfiving market trends. Hoswever, while technoldogy brings myriad advantages, it also poses challenges. Issues such as privacy invdasion and dependency require careful refgulation. Balancidng these aspefcts remains crucial to leverfage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);
        $userDictationId = $response['userDictationId'];

        $requestData = [
            'userInput' => 'Technology deeply permeates modern society. It influences how we communicate, interact, and understand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also permeate economics, making trade seamless and driving market trends. However, while technology brings myriad advantages, it also poses challenges. Issues such as privacy invasion and dependency require careful regulation. Balancing these aspects remains crucial to leverage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => true,
            'userDictationId' => $userDictationId,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);

        $userDictation = UserDictation::find($userDictationId);
        $this->assertEquals(100, $userDictation['score']);

    }

    public function test_dictation_logged_mark_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Technology dedeply permeates modern society. It influences how we communicate, interact, and undderstand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also perfmeate economics, making trade seamless and drfiving market trends. Hoswever, while technoldogy brings myriad advantages, it also poses challenges. Issues such as privacy invdasion and dependency require careful refgulation. Balancidng these aspefcts remains crucial to leverfage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);


        $requestData = [
            'dictationId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/dictation/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $dictationToReview = UserDictationsReview::where('dictation_id',1)->first();

        $this->assertEquals(true, $dictationToReview['review']);

    }

    public function test_dictation_logged_unmark_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Technology dedeply permeates modern society. It influences how we communicate, interact, and undderstand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also perfmeate economics, making trade seamless and drfiving market trends. Hoswever, while technoldogy brings myriad advantages, it also poses challenges. Issues such as privacy invdasion and dependency require careful refgulation. Balancidng these aspefcts remains crucial to leverfage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);


        $requestData = [
            'dictationId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/dictation/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $requestData = [
            'dictationId' => 1,
            'mark' => false
        ];
        $response = $this->json('POST', '/api/dictation/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $dictationToReview = UserDictationsReview::where('dictation_id',1)->first();

        $this->assertEquals(false, $dictationToReview['review']);

    }

    public function test_dictation_logged_get_lessons_free_plan_one_lesson()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'dictationTopicId' => 12,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/dictation/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(1);


    }

    public function test_dictation_logged_get_lessons_free_plan_more_than_one_lesson()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'dictationTopicId' => 12,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/dictation/getLessons', $requestData, $headers);

        $response->assertStatus(400);
        $response->assertJsonPath('msgError', 'Free plan users can only take 1 lesson at a time');

    }


    public function test_dictation_logged_get_lessons_premium_plan_more_than_one_lesson()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;
        PaymentFactory::new()->create([
            'user_id' => $userId,
            'id' => 1
        ]);
        $user->payment_id = 1;
        $user->save();

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'dictationTopicId' => 12,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/dictation/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }



    public function test_dictation_logged_get_lessons_only_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];


        $requestData = [
            'userInput' => 'Technology dedeply permeates modern society. It influences how we communicate, interact, and undderstand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also perfmeate economics, making trade seamless and drfiving market trends. Hoswever, while technoldogy brings myriad advantages, it also poses challenges. Issues such as privacy invdasion and dependency require careful refgulation. Balancidng these aspefcts remains crucial to leverfage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];

        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);



        $requestData = [
            'dictationTopicId' => null,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => true
        ];

        $response = $this->json('GET', '/api/dictation/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(0);


        $requestData = [
            'dictationId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/dictation/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $dictationToReview = UserDictationsReview::where('dictation_id',1)->first();

        $this->assertEquals(true, $dictationToReview['review']);

        $requestData = [
            'dictationTopicId' => null,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => true
        ];

        $response = $this->json('GET', '/api/dictation/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 1,
                ]
            ]);
    }


    public function test_dictation_logged_get_lessons_premium_plan_when_new_lesson_registered()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;
        PaymentFactory::new()->create([
            'user_id' => $userId,
            'id' => 1
        ]);
        $user->payment_id = 1;
        $user->save();

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'dictationTopicId' => 12,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/dictation/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);


        $requestData = [
            'userInput' => 'Technology deeply permeates modern society. It influences how we communicate, interact, and understand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also permeate economics, making trade seamless and driving market trends. However, while technology brings myriad advantages, it also poses challenges. Issues such as privacy invasion and dependency require careful regulation. Balancing these aspects remains crucial to leverage the best technology offers while mitigating its drawbacks.',
            'dictationId' => 1,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];
        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => 'The impact of technology on healthcare is profound. With advanced devices, doctors diagnose diseases accurately and swiftly. Technologies like telemedicine bring medical services directly to patients, breaking geographic boundaries. Robotic surgery improves precision, minimizes invasiveness, and quickens recovery times. Gene editing techniques promise cures for inherited diseases. On the mental health front, apps offer therapy and mindfulness exercises. But all these advancements need to uphold ethical standards. It\'s essential to ensure equal access and prioritize patient privacy.',
            'dictationId' => 2,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];
        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => 'Virtual reality technology, often shortened as VR, opens doors to simulated environments unlike any real-world setting. Its applications extend beyond entertainment and gaming. VR can enhance immersive learning, allowing students to virtually visit space or ancient civilizations. In the business sector, VR offers realistic product demos and virtual tours. Mental health professionals use VR for exposure therapy, providing safe environments for patients to confront fears. Future advancements may allow even more immersive experiences, with tangible holographic projections and mind-controlled virtual environments.',
            'dictationId' => 3,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];
        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => 'Smart home technology is reshaping our domestic lives. It enables a connected and automated living space, adjusting to our habits and preferences. Smart lights dim or brighten based on time or activity, while smart thermostats regulate home temperature. Smart refrigerators keep track of grocery lists, and automated vacuum cleaners maintain a clean house. Moreover, smart home security systems ensure safety with camera surveillance and alarms. These integrations provide convenience, efficiency, and peace of mind. Yet, they also pose security risks which must be addressed responsibly.',
            'dictationId' => 4,
            'retryLesson' => false,
            'userDictationId' => null,
            'guestDictationId' => null
        ];
        $response = $this->json('GET', '/api/dictation/checkAnswer', $requestData, $headers);


        $requestData = [
            'dictationTopicId' => 12,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/dictation/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);
        $lessons = $response->json();
        foreach ($lessons as $lesson) {
            $this->assertNotEquals(5, $lesson['id']);
        }


        $dictation = Dictation::find(5);
        $dictation->enabled = 1;
        $dictation->save();


        $requestData = [
            'dictationTopicId' => 12,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/dictation/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 5,
                ]
            ]);

    }
}
