<?php

// "Anna s'est faite flashée par un radar pendant qu'elle faisait du Kayak"

use App\kata\ExtractPalindromes;

test('should detect whether a word is a palindrome', function(
    $candidate, $expectedPalindromes
){
    expect(ExtractPalindromes::extractPalindromes($candidate))->toEqual($expectedPalindromes);
})->with([
    '' => ["", []],
    'a' => ["a", []],
    'aa' => ["aa", ['aa']],
    'ab' => ["ab", []],
    'aba' => ["aba", ["aba"]],
    'abca' => ["abca", []],
]);

test('should extract all palindromes found in a sentence', function(
    $candidate, $expectedPalindromes
){
    expect(ExtractPalindromes::extractPalindromes($candidate))->toEqual($expectedPalindromes);
})->with([
    'anna ' => ["anna ", ["anna"]],
    'anna radar' => ["anna radar", ["anna", "radar"]],
    'anna Radar' => ["anna Radar", ["anna", "radar"]],
    "qu'elle" => ["qu'elle", ["elle"]],
    "Phrase complète et complexe de référence"
    =>
        ["Anna s'est faite flashée par un radar pendant qu'elle faisait du Kayak",
            ["anna", "radar", "elle", "kayak"]],
]);

