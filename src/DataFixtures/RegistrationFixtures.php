<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use App\Entity\Registration;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\EventFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RegistrationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $u=1;
        $e=1;
        for ($u=1; $u <= 10; $u++) {
            for ($e=1; $e <=5 ; $e++) {

                $registration = new Registration();

                if ($u === 10) {
                    $registration->setUser($this->getReference('user_'.$u, User::class));
                } else {
                    $registration->setUser($this->getReference('user_0'.$u, User::class));
                }
                
                $registration->setEvent($this->getReference('event_0'.$e, Event::class));
                $registration->setRegisteredAt(new \DateTimeImmutable());

                $manager->persist($registration);
            }             
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            EventFixtures::class,
        ];
    }
}
