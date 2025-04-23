<?php

namespace App\EventListener;

use App\Event\UserRegisteredEvent;
use App\Service\SmsService;

class SendSmsRegisteredEvent
{
    public function __construct(private SmsService $sms) {        

    }

    public function onUserRegisteredEvent(UserRegisteredEvent $event) {

        $user = $event->getUser();
        $eventt = $event->getEvent();

        $this->sms->send(
            $user->getPhone(),
            "Nouvel inscrit : ".$user->getEmail().' à '.$eventt->getTitle()
        );        
    }
}