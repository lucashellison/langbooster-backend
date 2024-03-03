<?php

namespace Tests\Unit;

use App\Http\Repositories\CheckAnswer\CheckAnswerRepository;
use Tests\TestCase;

class CheckAnswerRepositoryTest extends TestCase
{
    private $checkAnswerRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->checkAnswerRepository = new CheckAnswerRepository();
    }

    public function test_check_listening_result_correct_answer()
    {
        $userInput = "This is a test sentence";
        $correctText = "This is a test sentence";
        $result = $this->checkAnswerRepository->checkListeningResult($userInput, $correctText);
        $this->assertTrue($result['correct']);

        $userInput = "this, is a test sentence.";
        $correctText = "This is a test sentence";
        $result = $this->checkAnswerRepository->checkListeningResult($userInput, $correctText);
        $this->assertTrue($result['correct']);

        $userInput = "THIS, is a test sentence";
        $correctText = "This is a test sentence";
        $result = $this->checkAnswerRepository->checkListeningResult($userInput, $correctText);
        $this->assertTrue($result['correct']);
    }

    public function test_check_listening_result_incorrect_answer()
    {
        $userInput = "This is a test";
        $correctText = "This is a test sentence";

        $result = $this->checkAnswerRepository->checkListeningResult($userInput, $correctText);

        $this->assertFalse($result['correct']);
        $this->assertEquals(0, $result['points']);
        $this->assertNotEquals($userInput, $result['differences']);
    }



    public function test_check_spelling_result_correct_answer()
    {
        $userInput = "United States";
        $correctText = "United States";
        $result = $this->checkAnswerRepository->checkSpellingResult($userInput, $correctText);
        $this->assertTrue($result['correct']);

        $userInput = "united states";
        $correctText = "United States";
        $result = $this->checkAnswerRepository->checkSpellingResult($userInput, $correctText);
        $this->assertTrue($result['correct']);
    }

    public function test_check_spelling_result_incorrect_answer()
    {
        $userInput = "United States";
        $correctText = "Unitedd States";

        $result = $this->checkAnswerRepository->checkSpellingResult($userInput, $correctText);

        $this->assertFalse($result['correct']);
        $this->assertEquals(0, $result['points']);
        $this->assertNotEquals($userInput, $result['differences']);
    }

    public function test_check_number_result_correct_answer()
    {
        $userInput = "30";
        $correctText = "30";
        $result = $this->checkAnswerRepository->checkNumberResult($userInput, $correctText);
        $this->assertTrue($result['correct']);

        $userInput = "30000";
        $correctText = "30,000";
        $result = $this->checkAnswerRepository->checkNumberResult($userInput, $correctText);
        $this->assertTrue($result['correct']);

        $userInput = "30,000";
        $correctText = "30,000";
        $result = $this->checkAnswerRepository->checkNumberResult($userInput, $correctText);
        $this->assertTrue($result['correct']);

        $userInput = "30.000";
        $correctText = "30,000";
        $result = $this->checkAnswerRepository->checkNumberResult($userInput, $correctText);
        $this->assertTrue($result['correct']);
    }

    public function test_check_number_result_incorrect_answer()
    {
        $userInput = "40";
        $correctText = "30";

        $result = $this->checkAnswerRepository->checkNumberResult($userInput, $correctText);

        $this->assertFalse($result['correct']);
        $this->assertEquals(0, $result['points']);
        $this->assertNotEquals($userInput, $result['differences']);
    }



    public function test_check_dictation_result_correct_answer()
    {
        $userInput = "This is a test sentence";
        $correctText = "This is a test sentence";
        $result = $this->checkAnswerRepository->getComparisonResult($userInput, $correctText);
        $this->assertEquals(100,$result['points']);
    }

    public function test_check_dictation_result_incorrect_answer()
    {
        $userInput = "This is a test";
        $correctText = "This is a test sentence";

        $result = $this->checkAnswerRepository->getComparisonResult($userInput, $correctText);

        $this->assertNotEquals(100,$result['points']);
    }

}
