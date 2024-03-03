<?php


use App\Models\GuestSpelling;
use App\Models\Listening;
use App\Models\UserSpelling;
use App\Models\UserSpellingReview;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Spelling;

class SpellingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }


    public function test_spelling_get_lessons()
    {

        $requestData = [
            'spellingTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/spelling/getLessons', $requestData);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }


    public function test_spelling_check_answer_correct()
    {

        $requestData = [
            'userInput' => 'Michael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData);

        $response->assertStatus(200)
            ->assertJsonPath('correct', true)
            ->assertJsonPath('differences', 'Michael');
    }

    public function test_spelling_check_answer_incorrect()
    {

        $requestData = [
            'userInput' => 'Micchael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData);

        $response->assertStatus(200)
            ->assertJsonPath('correct', false)
            ->assertJsonPath('differences', '<del>Micchael</del>');
    }

    public function test_spelling_check_answer_retry()
    {

        $requestData = [
            'userInput' => 'Micchael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData);
        $guestSpellingId = $response['guestSpellingId'];

        $requestData = [
            'userInput' => 'Michael',
            'spellingId' => 1,
            'retryLesson' => true,
            'userSpellingId' => null,
            'guestSpellingId' => $guestSpellingId
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData);

        $guestSpelling = GuestSpelling::find($guestSpellingId);
        $this->assertEquals(100, $guestSpelling['score']);

    }

    public function test_spelling_logged_check_answer_correct()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Michael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonPath('correct', true)
            ->assertJsonPath('differences', 'Michael');

    }

    public function test_spelling_logged_check_answer_incorrect()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Micchael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonPath('correct', false)
            ->assertJsonPath('differences', '<del>Micchael</del>');
    }

    public function test_spelling_logged_check_answer_retry()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Micchael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);
        $userSpellingId = $response['userSpellingId'];

        $requestData = [
            'userInput' => 'Michael',
            'spellingId' => 1,
            'retryLesson' => true,
            'userSpellingId' => $userSpellingId,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);

        $userSpelling = UserSpelling::find($userSpellingId);
        $this->assertEquals(100, $userSpelling['score']);

    }

    public function test_spelling_logged_mark_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Micchael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);


        $requestData = [
            'spellingId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/spelling/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $spellingToReview = UserSpellingReview::where('spelling_id',1)->first();

        $this->assertEquals(true, $spellingToReview['review']);

    }

    public function test_spelling_logged_unmark_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => 'Micchael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);


        $requestData = [
            'spellingId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/spelling/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $requestData = [
            'spellingId' => 1,
            'mark' => false
        ];
        $response = $this->json('POST', '/api/spelling/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $spellingToReview = UserSpellingReview::where('spelling_id',1)->first();

        $this->assertEquals(false, $spellingToReview['review']);

    }

    public function test_spelling_logged_get_lessons()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'spellingTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/spelling/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function test_spelling_logged_get_lessons_only_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];


        $requestData = [
            'userInput' => 'Micchael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];

        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);



        $requestData = [
            'spellingTopicId' => null,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => true
        ];

        $response = $this->json('GET', '/api/spelling/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(0);


        $requestData = [
            'spellingId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/spelling/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $spellingToReview = UserSpellingReview::where('spelling_id',1)->first();

        $this->assertEquals(true, $spellingToReview['review']);

        $requestData = [
            'spellingTopicId' => null,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => true
        ];

        $response = $this->json('GET', '/api/spelling/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 1,
                ]
            ]);
    }



    public function test_spelling_logged_get_lessons_when_new_lesson_registered()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'spellingTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/spelling/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);


        $requestData = [
            'userInput' => 'Michael',
            'spellingId' => 1,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];
        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => 'Jennifer',
            'spellingId' => 2,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];
        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => 'James',
            'spellingId' => 3,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];
        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => 'Linda',
            'spellingId' => 4,
            'retryLesson' => false,
            'userSpellingId' => null,
            'guestSpellingId' => null
        ];
        $response = $this->json('GET', '/api/spelling/checkAnswer', $requestData, $headers);


        $requestData = [
            'spellingTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/spelling/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);
        $lessons = $response->json();
        foreach ($lessons as $lesson) {
            $this->assertNotEquals(5, $lesson['id']);
        }


        $spelling = Spelling::find(5);
        $spelling->enabled = 1;
        $spelling->save();


        $requestData = [
            'spellingTopicId' => 1,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/spelling/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 5,
                ]
            ]);

    }



}
