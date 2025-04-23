<?php

namespace App\Service;

use Twilio\Rest\Client;

class SmsService
{
    private Client $twilio;

    public function __construct(string $sid, string $token, private string $fromNumber) {

        $this->twilio = new Client($sid, $token);

    }

    public function send($to, $message) {
        
        $this->twilio->messages->create($to, [
            'from' => $this->fromNumber,
            'body' => $message
        ]);
    }
}