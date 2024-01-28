<?php

namespace App\Controllers;

class HtmlAnswer {

    public function generateAnswer(string $text, string $filename): void {
        if ($text !== false && $filename !== false) {
            echo "$text<br><br><audio controls='controls'>
            <source src='$filename' type='audio/mpeg' />
            </audio>";
        }
    }
}
