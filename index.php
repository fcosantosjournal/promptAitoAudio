<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controllers\Audio;
use App\Controllers\OpenAi;
use App\Controllers\OpenAiLettersFilter;
use App\Controllers\PostConditions;
use App\Controllers\HtmlAnswer;

$postCondition = (new PostConditions())->postCondition();

include 'header.php';

if ($postCondition) {

    $openAiLettersFilter = new OpenAiLettersFilter($_POST["prompt"], $_POST["language"]);
    $language = $openAiLettersFilter->getLanguage();
    $prompt = $openAiLettersFilter->filterPrompt();

    $openAi = new OpenAi();
    $text = $openAi->GenerateText($prompt, $language);

    $audio = new Audio();
    $filename = $audio->GenerateAudio($text, $language);

    if ($filename != false) {
        $htmlAnswer = (new HtmlAnswer())->generateAnswer($text, $filename);
    }
    
} 

include 'footer.php';

          

