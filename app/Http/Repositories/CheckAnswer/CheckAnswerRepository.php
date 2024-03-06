<?php

namespace App\Http\Repositories\CheckAnswer;

use App\Services\FineDiff\FineDiff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class CheckAnswerRepository
{
    public function getComparisonResult(string $correctText, string $userInput=null)
    {

        $totalWords = $this->getNumberOfWords($correctText);
        $userInput = $this->formatText($userInput);

        $granularity = FineDiff::$wordGranularity;

        $diff = new FineDiff($userInput, $correctText, $granularity);
        $differences = $diff->renderDiffToHTML();

        preg_match_all('/<ins>(.*?)<\/ins>/', $differences, $matches);
        $ins_contents = implode(" ", $matches[1]);

        $wrongWords = $this->getNumberOfWords($ins_contents);

        $correctWords = $totalWords - $wrongWords;

        $points =  round(($correctWords/$totalWords) * 100,1);
        $percentage = round(($correctWords/$totalWords) * 100,1);

        return [
            'differences' => $differences,
            'totalWords' => $totalWords,
            'correctWords' => $correctWords,
            'points' => $points,
            'percentage' => $percentage,
        ];
    }


    private function getNumberOfWords($string) {
        if(!$string) return 0;
        $string = preg_replace('/\s+/', ' ', trim($string));
        $words = explode(" ", $string);
        return count($words);
    }


    private function formatText($text) {
        // Ignore spaces at the beginning and end of the text
        $text = trim($text);

        // First letter of the text in uppercase
        $text = ucfirst($text);

        // There should not be more than one space. If there are 2 or more spaces, turn them into 1 space.
        $text = preg_replace('/\s+/', ' ', $text);

        // Add a space after each comma, period, exclamation mark or question mark if there is not
        $text = preg_replace('/([.,!?])(?=[^\s])/', '$1 ', $text);

        // Change the first letter to uppercase after a period, exclamation mark or question mark
        $text = preg_replace_callback('/([.!?]) ([a-z])/', function($matches) {
            return $matches[1] . ' ' . strtoupper($matches[2]);
        }, $text);

        return $text;
    }






    public function checkListeningResult($userInput,$correctText): array
    {

        $userInput = preg_replace('/\s+/', ' ', $userInput);


        $granularity = FineDiff::$wordGranularity;


        $wordsInput = explode(" ",$userInput);

        $words = [];

        $newText = "";

        foreach ($wordsInput as $word){
            if (!preg_match('/^[^A-Za-z0-9]+$/', $word)) {
                $words[] = $word;
                $newText .= $word . ' ';
            }
        }



        $newText = substr($newText,0,-1);

        $userInput = $newText;


        $userInputWithoutSpecialChar = preg_replace("/[^A-Za-z ']/", '', $userInput);
        $correctTextSpecialChar = preg_replace("/[^A-Za-z ']/", '', $correctText);


        $diff = new FineDiff(strtolower($userInputWithoutSpecialChar), strtolower($correctTextSpecialChar), $granularity);
        $differences = $diff->renderDiffToHTML();


        $differences = preg_replace('/<ins>.*?<\/ins>/', '', $differences);

        $differences = str_replace(' </del>','</del> ',$differences);

        $finalUserInput = "";

        $wordsDiff = explode(' ',$differences);

        $correct = true;

        $tagDelClose = true;


        foreach ($wordsDiff as $index => $word){

            if(!str_starts_with($word, '<del>') && $tagDelClose){
                $finalUserInput .= $words[$index] . ' ';
            }else{
                if(str_ends_with($word,'</del>')){
                    $tagDelClose = true;
                }else{
                    $tagDelClose = false;
                }
                $finalUserInput .= "<del>{$words[$index]}</del> ";
                $correct = false;
            }
        }

        $finalUserInput = substr($finalUserInput,0,-1);

        if($correct){
            if(str_word_count($userInput) !== str_word_count($correctText)){
                $correct = false;
            }
        }

        return [
            'differences' => $finalUserInput,
            'correctText' => $correctText,
            'correct' => $correct,
            'points' => $correct ? 100 : 0
        ];

    }

    public function checkSpellingResult($userInput,$correctText): array
    {

        $userInput = preg_replace('/\s+/', ' ', $userInput);

        $granularity = FineDiff::$wordGranularity;


        $wordsInput = explode(" ",$userInput);

        $words = [];

        $newText = "";

        foreach ($wordsInput as $word){
            if (!preg_match('/^[^A-Za-z0-9]+$/', $word)) {
                $words[] = $word;
                $newText .= $word . ' ';
            }
        }



        $newText = substr($newText,0,-1);

        $userInput = $newText;


        $userInputWithoutSpecialChar = preg_replace("/[^A-Za-z ']/", '', $userInput);
        $correctTextSpecialChar = preg_replace("/[^A-Za-z ']/", '', $correctText);


        $diff = new FineDiff(strtolower($userInputWithoutSpecialChar), strtolower($correctTextSpecialChar), $granularity);
        $differences = $diff->renderDiffToHTML();


        $differences = preg_replace('/<ins>.*?<\/ins>/', '', $differences);

        $differences = str_replace(' </del>','</del> ',$differences);

        $finalUserInput = "";

        $wordsDiff = explode(' ',$differences);

        $correct = true;

        $tagDelClose = true;


        foreach ($wordsDiff as $index => $word){

            if(!str_starts_with($word, '<del>') && $tagDelClose){
                $finalUserInput .= $words[$index] . ' ';
            }else{
                if(str_ends_with($word,'</del>')){
                    $tagDelClose = true;
                }else{
                    $tagDelClose = false;
                }
                $finalUserInput .= "<del>{$words[$index]}</del> ";
                $correct = false;
            }
        }

        $finalUserInput = substr($finalUserInput,0,-1);

        if($correct){
            if(str_word_count($userInput) !== str_word_count($correctText)){
                $correct = false;
            }
        }


        return [
            'differences' => $finalUserInput,
            'correctText' => $correctText,
            'correct' => $correct,
            'points' => $correct ? 100 : 0
        ];

    }

    public function checkNumberResult($userInput,$correctText): array
    {


        if($userInput){
            $userInput = preg_replace('/[^0-9,.]/', '', $userInput);
            $userInput = str_replace('.',',',$userInput);

            if (!strpos($userInput, ',') !== false) {
                $userInput = preg_replace('/[^0-9]/', '', $userInput);
                $userInput = number_format((float) $userInput, 0, '.', ',');
            }

            $correctText = preg_replace('/[^0-9]/', '', $correctText);
            $correctText = number_format((float) $correctText, 0, '.', ',');

            $granularity = FineDiff::$wordGranularity;

            $diff = new FineDiff(strtolower($userInput), strtolower($correctText), $granularity);
            $differences = $diff->renderDiffToHTML();


            $differences = preg_replace('/<ins>.*?<\/ins>/', '', $differences);

            $differences = str_replace(' </del>','</del> ',$differences);


            $correct = !strpos($differences, 'del') !== false;
        }else{
            $differences = "";
            $correct = false;
        }





        return [
            'differences' => $differences,
            'correctText' => $correctText,
            'correct' => $correct,
            'points' => $correct ? 100 : 0
        ];

    }



}
