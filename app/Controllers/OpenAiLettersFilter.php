<?php

namespace App\Controllers;

class OpenAiLettersFilter {

    private string $prompt;
    private string $language;

    public function __construct(string $prompt, string $language) {    
        $this->prompt = $prompt;
        $this->language = $this->filterLanguage($language);
        // Removida a instrução 'return' do construtor
    }

    public function filterPrompt(): string {
        $prompt = "Write an small article about " . $this->prompt . " with less than 250 characters on each paragraph on the following languages: " . $this->language . ".\n\n";
        $prompt = preg_replace('/[^A-Za-z0-9\- ]/', '', $prompt);
        return $prompt;
    }

    public function filterLanguage(string $language): string {
        $languages = ["en", "es", "pt-BR"];
        return in_array($language, $languages) ? $language : "en";
    }

    public function filterGeneratedText(string $text): string {
        $text = str_replace("_", "", $text);
        $text = str_replace('"', '', $text);
        return $text;
    }

    public function getLanguage(): string {
        return $this->language;
    }

    public function cleanTextOnlyLetters(string $text): string {
        $text = str_replace("_", "", $text);
        $text = str_replace('"', '', $text);
        $text = preg_replace('/[^A-Za-z0-9\- ]/', '', $text);        
        return $text;
    }

}
