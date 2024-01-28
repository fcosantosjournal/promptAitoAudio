<?php

namespace App\Controllers;

class OpenAiConfig {

    const OPENAI_API_KEY = "";
    const OPENAI_API_URL = "https://api.openai.com/v1/chat/completions";
    const OPENAI_MODEL = "gpt-3.5-turbo-1106";
    const OPENAI_MAX_TOKENS = 256;

    public function getOpenaiApiKey(): string {
        return self::OPENAI_API_KEY;
    }

    public function getUrl(): string {
        return self::OPENAI_API_URL;
    }

    public function getModel(): string {
        return self::OPENAI_MODEL;
    }

    public function getMaxTokens(): int {
        return self::OPENAI_MAX_TOKENS;
    }
}
