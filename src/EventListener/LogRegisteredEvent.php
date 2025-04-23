<?php

namespace App\EventListener;

use App\Entity\Registration;
use Psr\Log\LoggerInterface;
use App\Event\UserRegisteredEvent;

class LogRegisteredEvent
{
    public function __construct(private LoggerInterface $logger) {}

    public function onUserRegisteredEvent(UserRegisteredEvent $event)
    {
        $user = $event->getUser();
        $eventt = $event->getEvent();

        $this->logger->info('Enregistrement effectué de '.$user->getEmail().' à '.$eventt->getTitle());
    }
}