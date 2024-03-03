<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WordsCount implements ValidationRule
{
    private $minWords;

    public function __construct(int $minWords)
    {
        $this->minWords = $minWords;
    }



    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $wordsCount = str_word_count($value);
        if ($wordsCount < $this->minWords) {
            $fail("Your answer must contain at least {$this->minWords} words.");
        }
    }
}
