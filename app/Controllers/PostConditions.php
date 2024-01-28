<?php

namespace App\Controllers;

class PostConditions {
    
    public function postCondition(): bool {
        return ($_SERVER["REQUEST_METHOD"] === "POST") && !empty($_POST["prompt"]) && !empty($_POST["language"]);
    }    
}
