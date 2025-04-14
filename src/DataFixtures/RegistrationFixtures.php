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
        $registration = new Registration();
        $registration->setUser($this->getReference('user_03', User::class));
        $registration->setEvent($this->getReference('event_01', Event::class));
        $registration->setRegisteredAt(new \DateTimeImmutable());

        $manager->persist($registration);

        $registration = new Registration();
        $registration->setUser($this->getReference('user_05', User::class));
        $registration->setEvent($this->getReference('event_02', Event::class));
        $registration->setRegisteredAt(new \DateTimeImmutable());

        $manager->persist($registration);

        $registration = new Registration();
        $registration->setUser($this->getReference('user_02', User::class));
        $registration->setEvent($this->getReference('event_03', Event::class));
        $registration->setRegisteredAt(new \DateTimeImmutable());

        $manager->persist($registration);

        $registration = new Registration();
        $registration->setUser($this->getReference('user_04', User::class));
        $registration->setEvent($this->getReference('event_02', Event::class));
        $registration->setRegisteredAt(new \DateTimeImmutable());

        $manager->persist($registration);

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
