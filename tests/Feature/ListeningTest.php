<?php

namespace Tests\Feature;

use App\Models\GuestListening;
use App\Models\UserListening;
use App\Models\UserListeningReview;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Listening;

class ListeningTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }


    public function test_listening_get_lessons()
    {

        $requestData = [
            'listeningTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/listening/getLessons', $requestData);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }


    public function test_listening_check_answer_correct()
    {

        $requestData = [
            'userInput' => 'Yesterday, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData);

        $response->assertStatus(200)
            ->assertJsonPath('correct', true)
            ->assertJsonPath('differences', 'Yesterday, we went to the park and had a picnic.');
    }

    public function test_listening_check_answer_incorrect()
    {

        $requestData = [
            'userInput' => 'Yesterdayy, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData);

        $response->assertStatus(200)
            ->assertJsonPath('correct', false)
            ->assertJsonPath('differences', '<del>Yesterdayy,</del> we went to the park and had a picnic.');
    }

    public function test_listening_check_answer_retry()
    {

        $requestData = [
            'userInput' => 'Yesterdayy, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData);
        $guestListeningId = $response['guestListeningId'];

        $requestData = [
            'userInput' => 'Yesterday, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => true,
            'userListeningId' => null,
            'guestListeningId' => $guestListeningId
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData);

        $guestListening = GuestListening::find($guestListeningId);
        $this->assertEquals(100, $guestListening['score']);

    }

    public function test_listening_logged_check_answer_correct()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Yesterday, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonPath('correct', true)
            ->assertJsonPath('differences', 'Yesterday, we went to the park and had a picnic.');

    }

    public function test_listening_logged_check_answer_incorrect()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Yesterdayy, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonPath('correct', false)
            ->assertJsonPath('differences', '<del>Yesterdayy,</del> we went to the park and had a picnic.');
    }

    public function test_listening_logged_check_answer_retry()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Yesterdayy, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);
        $userListeningId = $response['userListeningId'];

        $requestData = [
            'userInput' => 'Yesterday, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => true,
            'userListeningId' => $userListeningId,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);

        $userListening = UserListening::find($userListeningId);
        $this->assertEquals(100, $userListening['score']);

    }

    public function test_listening_logged_mark_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Yesterdayy, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);


        $requestData = [
            'listeningId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/listening/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $listeningToReview = UserListeningReview::where('listening_id',1)->first();

        $this->assertEquals(true, $listeningToReview['review']);

    }

    public function test_listening_logged_unmark_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Yesterdayy, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);


        $requestData = [
            'listeningId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/listening/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $requestData = [
            'listeningId' => 1,
            'mark' => false
        ];
        $response = $this->json('POST', '/api/listening/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $listeningToReview = UserListeningReview::where('listening_id',1)->first();

        $this->assertEquals(false, $listeningToReview['review']);

    }

    public function test_listening_logged_get_lessons()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'listeningTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/listening/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function test_listening_logged_get_lessons_only_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];


        $requestData = [
            'userInput' => 'Yesterdayy, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];

        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);



        $requestData = [
            'listeningTopicId' => null,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => true
        ];

        $response = $this->json('GET', '/api/listening/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(0);


        $requestData = [
            'listeningId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/listening/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $listeningToReview = UserListeningReview::where('listening_id',1)->first();

        $this->assertEquals(true, $listeningToReview['review']);

        $requestData = [
            'listeningTopicId' => null,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => true
        ];

        $response = $this->json('GET', '/api/listening/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 1,
                ]
            ]);
    }



    public function test_listening_logged_get_lessons_when_new_lesson_registered()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'listeningTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/listening/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);


        $requestData = [
            'userInput' => 'Yesterday, we went to the park and had a picnic.',
            'listeningId' => 1,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];
        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => 'Can you help me find my glasses? I lost them.',
            'listeningId' => 2,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];
        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => 'I\'m thinking of baking a cake for dessert tonight.',
            'listeningId' => 3,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];
        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => 'The weather is lovely today, perfect for a walk.',
            'listeningId' => 4,
            'retryLesson' => false,
            'userListeningId' => null,
            'guestListeningId' => null
        ];
        $response = $this->json('GET', '/api/listening/checkAnswer', $requestData, $headers);


        $requestData = [
            'listeningTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/listening/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);
        $lessons = $response->json();
        foreach ($lessons as $lesson) {
            $this->assertNotEquals(5, $lesson['id']);
        }


        $listening = Listening::find(5);
        $listening->enabled = 1;
        $listening->save();


        $requestData = [
            'listeningTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/listening/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 5,
                ]
            ]);

    }



}
