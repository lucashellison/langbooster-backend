<?php


use App\Models\GuestNumber;
use App\Models\UserNumber;
use App\Models\UserNumberReview;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Number;

class NumberTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }


    public function test_number_get_lessons()
    {

        $requestData = [
            'numberTopicId' => 2,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/number/getLessons', $requestData);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }


    public function test_number_check_answer_correct()
    {

        $requestData = [
            'userInput' => '70',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData);

        $response->assertStatus(200)
            ->assertJsonPath('correct', true)
            ->assertJsonPath('differences', '70');
    }

    public function test_number_check_answer_incorrect()
    {

        $requestData = [
            'userInput' => '85',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData);

        $response->assertStatus(200)
            ->assertJsonPath('correct', false)
            ->assertJsonPath('differences', '<del>85</del>');
    }

    public function test_number_check_answer_retry()
    {

        $requestData = [
            'userInput' => '85',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData);
        $guestNumberId = $response['guestNumberId'];

        $requestData = [
            'userInput' => '70',
            'numberId' => 1,
            'retryLesson' => true,
            'userNumberId' => null,
            'guestNumberId' => $guestNumberId
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData);

        $guestNumber = GuestNumber::find($guestNumberId);
        $this->assertEquals(100, $guestNumber['score']);

    }

    public function test_number_logged_check_answer_correct()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => '70',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonPath('correct', true)
            ->assertJsonPath('differences', '70');

    }

    public function test_number_logged_check_answer_incorrect()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => '85',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonPath('correct', false)
            ->assertJsonPath('differences', '<del>85</del>');
    }

    public function test_number_logged_check_answer_retry()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => '85',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);
        $userNumberId = $response['userNumberId'];

        $requestData = [
            'userInput' => '70',
            'numberId' => 1,
            'retryLesson' => true,
            'userNumberId' => $userNumberId,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);

        $userNumber = UserNumber::find($userNumberId);
        $this->assertEquals(100, $userNumber['score']);

    }

    public function test_number_logged_mark_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => '85',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);


        $requestData = [
            'numberId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/number/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $numberToReview = UserNumberReview::where('number_id',1)->first();

        $this->assertEquals(true, $numberToReview['review']);

    }

    public function test_number_logged_unmark_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'userInput' => '85',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);


        $requestData = [
            'numberId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/number/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $requestData = [
            'numberId' => 1,
            'mark' => false
        ];
        $response = $this->json('POST', '/api/number/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $numberToReview = UserNumberReview::where('number_id',1)->first();

        $this->assertEquals(false, $numberToReview['review']);

    }

    public function test_number_logged_get_lessons()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'numberTopicId' => 2,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/number/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function test_number_logged_get_lessons_only_to_review()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];


        $requestData = [
            'userInput' => '85',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];

        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);



        $requestData = [
            'numberTopicId' => null,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => true
        ];

        $response = $this->json('GET', '/api/number/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(0);


        $requestData = [
            'numberId' => 1,
            'mark' => true
        ];
        $response = $this->json('POST', '/api/number/markToReview', $requestData, $headers);
        $response->assertStatus(200);

        $numberToReview = UserNumberReview::where('number_id',1)->first();

        $this->assertEquals(true, $numberToReview['review']);

        $requestData = [
            'numberTopicId' => null,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => true
        ];

        $response = $this->json('GET', '/api/number/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 1,
                ]
            ]);
    }


    public function test_number_logged_get_lessons_when_new_lesson_registered()
    {

        $user = UserFactory::new()->create();
        $userId = $user->id;

        $token = JWTAuth::fromUser($user);
        $headers = ['Authorization' => "Bearer $token"];

        $requestData = [
            'numberTopicId' => 2,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/number/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);


        $requestData = [
            'userInput' => '70',
            'numberId' => 1,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];
        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => '73',
            'numberId' => 2,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];
        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => '28',
            'numberId' => 3,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];
        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);

        $requestData = [
            'userInput' => '93',
            'numberId' => 4,
            'retryLesson' => false,
            'userNumberId' => null,
            'guestNumberId' => null
        ];
        $response = $this->json('GET', '/api/number/checkAnswer', $requestData, $headers);


        $requestData = [
            'numberTopicId' => 2,
            'languageVariantId' => 1,
            'quantityLessons' => 5,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/number/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(5);
        $lessons = $response->json();
        foreach ($lessons as $lesson) {
            $this->assertNotEquals(5, $lesson['id']);
        }


        $number = Number::find(5);
        $number->enabled = 1;
        $number->save();


        $requestData = [
            'numberTopicId' => 2,
            'languageVariantId' => 1,
            'quantityLessons' => 1,
            'reviewOnly' => false
        ];

        $response = $this->json('GET', '/api/number/getLessons', $requestData, $headers);

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJson([
                [
                    'id' => 5,
                ]
            ]);

    }



}
