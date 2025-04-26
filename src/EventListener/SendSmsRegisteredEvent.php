<?php

namespace App\EventListener;

use Exception;

use \Vonage\Client;
use \Vonage\SMS\Message\SMS;
use App\Event\UserRegisteredEvent;
use \Vonage\Client\Credentials\Basic;

class SendSmsRegisteredEvent
{    
    public function __construct() {}

    /**
     * @param mixed $event
     * @return void
     */
    public function onUserRegisteredEvent(UserRegisteredEvent $event): void
    {

        $user = $event->getUser();
        $eventt = $event->getEvent();
        
        $basic  = new Basic("ebea466b", "UMCDLASMcqG3tVqa");
        $client = new Client($basic);
    
        $response = $client->sms()->send(
            new SMS('+33781570127', 'SubEvents', "Nouvel inscrit : ".$user->getEmail().' à '.$eventt->getTitle())
        );
        
        $message = $response->current();        
       
        if ($message->getStatus() == 0) {            
            echo "Le sms a bien été envoyé!";
        } else {            
            echo "❌ Le sms n\a pas été envoyé ".$message->getStatus();
        }
    }
}