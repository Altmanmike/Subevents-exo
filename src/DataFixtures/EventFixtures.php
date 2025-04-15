<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $event = new Event();
        $event->setTitle("Sports extrême de la ville");
        $event->setDescription("L'ensemble des sports qui seront représentés sont : l'escalade, le vtt trial, le bmx, le skate et d'autres!");
        $event->setMaxParticipants(5);
        $event->setStartAt(new \DateTimeImmutable("2025-04-10 10:00:00"));
        $event->setEndAt(new \DateTimeImmutable("2025-04-15 12:00:00"));
        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setUpdatedAt(new \DateTimeImmutable());
        $this->addReference('event_01', $event);

        $manager->persist($event);


        $event = new Event();
        $event->setTitle("Gallerie d'art : les arts modernes");
        $event->setDescription("Venez voir nos galleries en plein coeur de la vieille ville, de nombreux artistes de toute l'europe sont ici présent pour vous présenter leurs chefs d'oeuvre");
        $event->setMaxParticipants(5);
        $event->setStartAt(new \DateTimeImmutable("2025-06-05 11:00:00"));
        $event->setEndAt(new \DateTimeImmutable("2025-05-09 17:00:00"));
        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setUpdatedAt(new \DateTimeImmutable());
        $this->addReference('event_02', $event);

        $manager->persist($event);


        $event = new Event();
        $event->setTitle("Cinema Pathé nocturne!");
        $event->setDescription("Pathé Gaumont organise toute la moitié de la semaine des séances de cinémas en plein air");
        $event->setMaxParticipants(5);
        $event->setStartAt(new \DateTimeImmutable("2025-04-26 15:00:00"));
        $event->setEndAt(new \DateTimeImmutable("2025-05-30 23:30:00"));
        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setUpdatedAt(new \DateTimeImmutable());
        $this->addReference('event_03', $event);

        $manager->persist($event);
        

        $event = new Event();
        $event->setTitle("Compétition 100m piscine municipal");
        $event->setDescription("Rejoignez les bordures du rhône pour voir sur écran géant la compétition régionale de 100 m toute nage, féminin et masculien, junior et adultes");
        $event->setMaxParticipants(5);
        $event->setStartAt(new \DateTimeImmutable("2025-07-10 15:00:00"));
        $event->setEndAt(new \DateTimeImmutable("2025-07-13 15:00:00"));
        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setUpdatedAt(new \DateTimeImmutable());
        $this->addReference('event_04', $event);

        $manager->persist($event);


        $event = new Event();
        $event->setTitle("Découverte danse rock pour les jeunes");
        $event->setDescription("La ville organise une activité découverte de la danse Rock pour les jeunes, possibilité d'inscription dès 10 ans jusqu'à 20 ans, tous les week-end du mois d'août, les samedi de 14h à 18h");
        $event->setMaxParticipants(5);
        $event->setStartAt(new \DateTimeImmutable("2025-08-01 13:30:00"));
        $event->setEndAt(new \DateTimeImmutable("2025-08-31 18:30:00"));
        $event->setCreatedAt(new \DateTimeImmutable());
        $event->setUpdatedAt(new \DateTimeImmutable());
        $this->addReference('event_05', $event);

        $manager->persist($event);


        $manager->flush();
    }
}
