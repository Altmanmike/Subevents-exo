<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use App\Event\UserRegisteredEvent;

class LogRegisteredEvent
{
    public function __construct(private LoggerInterface $logger) {}

    /**
     * @param mixed $event
     * @return void
     */
    public function onUserRegisteredEvent(UserRegisteredEvent $event): void
    {
        $user = $event->getUser();
        $eventt = $event->getEvent();

        $this->logger->info('Enregistrement effectué de '.$user->getEmail().' à '.$eventt->getTitle());
    }
}