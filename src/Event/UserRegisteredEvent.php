<?php

namespace App\Event;

use App\Entity\User;
use App\Entity\Event as EventEntity;
use Symfony\Contracts\EventDispatcher\Event;

class UserRegisteredEvent extends Event
{
    public const NAME = 'user.registered';

    public function __construct(private User $user, private EventEntity $event) {}  

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the value of event
     */ 
    public function getEvent()
    {
        return $this->event;
    }
}