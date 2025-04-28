<?php

namespace App\Tests;

use App\Entity\User;
use App\Entity\Event;
use PHPUnit\Framework\TestCase;
use App\Event\UserRegisteredEvent;

class UnitaireManagerTest extends TestCase 
{
    //public function __construct() {}

    public function testUserRegisteredEvent()
    {
        $user = new User();
        $user->setEmail("test@test.fr");
        $user->setRoles(['ROLE_USER']);
        $user->setFirstName("testy");
        $user->setLastName("THETEST");
        $user->setPhone("+33781570127");
        $user->setPassword("testtest");
        $user->setIsVerified(true);
        $user->setCreatedAt(new \DatetimeImmutable());

        $event = new Event();
        $event->setTitle("Nos activités de tests");
        $event->setDescription("L'ensemble des tests unitaires à effectuer");
        $event->setMaxParticipants(11);
        $event->setStartAt(new \DateTimeImmutable("2025-04-30 10:00:00"));
        $event->setEndAt(new \DateTimeImmutable("2025-04-31 12:00:00"));
        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setUpdatedAt(new \DateTimeImmutable());

        $userReg = new UserRegisteredEvent($user, $event);
        
        // Valeurs
        $this->assertEquals($user, $userReg->getUser());
        $this->assertEquals($event, $userReg->getEvent());

        // Types
        $this->assertIsObject($userReg->getUser());
        $this->assertIsObject($userReg->getEvent());

        // Contenu
        $this->assertContainsOnlyInstancesOf(User::class, [ $userReg->getUser() ]);
        $this->assertContainsOnlyInstancesOf(Event::class, [ $userReg->getEvent() ]);
    }

    /*public function testLogRegisteredEvent()
    {

    }

    public function testSendMailRegisteredEvent()
    {

    }

    public function testSendSmsRegisteredEvent()
    {

    }

    public function testAddRegistration()
    {

    } */
    
}