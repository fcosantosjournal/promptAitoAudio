<?php

namespace App\Controllers;

use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

class Audio {

    protected string $text;
    protected string $filename;
    protected string $directory;
    protected $audio; 
    protected string $language;
    protected string $uuid;
    protected string $filepath;

    public static function getClient(): TextToSpeechClient {
        $client = new TextToSpeechClient([
            'credentials' => __DIR__.'/../../vozai-412320-c48dd0bd7bd3.json'
        ]);
        return $client;
    }

    public function clearString(string $string): string {
        $this->text = $string;
        $removeFirstSpace = ltrim($this->text);
        $this->text = str_replace("  ", " ", $removeFirstSpace);
        return $this->text;
    }

    public function generateFilename(): string {
        $this->uuid = uniqid();
        $this->filename = "$this->uuid.mp3";
        return $this->filename;
    }

    // Generate audio from text using Google Cloud Text-to-Speech
    public function generateAudio(string $text, string $language): string|false {
        
        $this->text = $this->clearString($text);
        $this->filename = $this->generateFilename();

        $this->filepath = __DIR__ . "/../../audio/$this->filename";

        $input = new SynthesisInput();
        $input->setText($this->text);

        $voice = new VoiceSelectionParams();
        $voice->setLanguageCode($language);

        $audioConfig = new AudioConfig();
        $audioConfig->setAudioEncoding(AudioEncoding::MP3);

        $textToSpeechClient = $this->getClient();

        $resp = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);

        file_put_contents($this->filepath, $resp->getAudioContent());

        return (file_exists("audio/$this->filename")) ? "audio/$this->filename" : false;
            
    }  
}
