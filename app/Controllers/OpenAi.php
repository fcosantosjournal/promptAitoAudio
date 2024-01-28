<?php

namespace App\Controllers;

use App\Controllers\OpenAiConfig;
use App\Controllers\OpenAiLettersFilter;

class OpenAi {

    private string $openaiApiKey;
    private string $url;
    private string $model;
    private int $maxTokens;
    private string $prompt;
    private string $language;

    public function __construct() {
        $openAiConfig = new OpenAiConfig();

        $this->openaiApiKey = $openAiConfig->getOpenaiApiKey();
        $this->url = $openAiConfig->getUrl();
        $this->model = $openAiConfig->getModel();
        $this->maxTokens = $openAiConfig->getMaxTokens();
    }

    public function generateText(string $prompt, string $language): string {
        $this->prompt = $prompt;
        $this->language = $language;

        $this->prompt = (new OpenAiLettersFilter($this->prompt, $this->language))->filterPrompt();

        return $this->generateTextFromCurl();
    }

    private function generateTextFromCurl(): string {
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $this->openaiApiKey"
        );

        $data = array(
            "model" => $this->model,
            "messages" => array(
                array(
                    "role" => "user",
                    "content" => $this->prompt
                )
            ),
            "temperature" => 1,
            "max_tokens" => $this->maxTokens,
            "top_p" => 1,
            "frequency_penalty" => 0,
            "presence_penalty" => 0
        );

        $ch = curl_init($this->url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
            die();
        }

        curl_close($ch);

        $responseArray = json_decode($response, true);
        $generatedText = $responseArray["choices"][0]['message']['content'];

        $filteredText = (new OpenAiLettersFilter($generatedText, $this->language))->filterGeneratedText($generatedText);

        return $filteredText;
    }
}
