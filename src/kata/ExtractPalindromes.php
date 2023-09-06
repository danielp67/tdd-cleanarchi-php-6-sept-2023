<?php

namespace App\kata;

class ExtractPalindromes
{

    static function extractPalindromes(string $sentence): array
    {
        $palindromes = [];
        $words = preg_split("/\s|'/", $sentence);
        foreach ($words as $word) {
            $lowerCaseWord = strtolower($word);
            if (self::isPalindrome($lowerCaseWord))
                $palindromes[] = $lowerCaseWord;
        }
        return $palindromes;
    }

    static function isPalindrome(string $word): bool
    {
        return self::hasMoreThanTwoCharacters($word)
            && self::assertForSymmetricalLetters($word);
    }

    static function hasMoreThanTwoCharacters(string $word): bool
    {
        return strlen($word) >= 2;
    }

    static function assertForSymmetricalLetters(string $word): bool {
        for ($i = 0; $i < strlen($word); $i++)
            if (self::checkForSymmetricalInequality($word[$i], $word[strlen($word) - 1 - $i]))
                return false;
        return true;
    }

    static function checkForSymmetricalInequality(string $letter, string $symmetricalLetter): bool
    {
        return $letter !== $symmetricalLetter;
    }

}