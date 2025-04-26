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
     * @return object
     */ 
    public function getUser(): object
    {
        return $this->user;
    }

    /**
     * @return object
     */
    public function getEvent(): object
    {
        return $this->event;
    }
}