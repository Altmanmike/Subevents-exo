<?php

namespace App\Service;

use Exception;
use App\Entity\Registration;
use Psr\Log\LoggerInterface;
use App\Event\UserRegisteredEvent;
use Doctrine\ORM\EntityManagerInterface;
use App\EventListener\LogRegisteredEvent;
use App\EventListener\SendSmsRegisteredEvent;
use App\Repository\RegistrationRepository;
use App\EventListener\SendMailRegisteredEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventRegistrationManager {   

    public function __construct(
        private RegistrationRepository $repo,
        private EntityManagerInterface $entityManager,
        private EventDispatcherInterface $dispatcher,
        private SendMailRegisteredEvent $sendMailRegisteredEvent,
        private LogRegisteredEvent $logRegisteredEvent,
        private SendSmsRegisteredEvent $smsRegisteredEvent,
        private LoggerInterface $logger) {}

    public function addRegistration(Registration $registration) {

        // Vérifier qu’un utilisateur peut s’inscrire.
        if (($this->repo->countRegistrationsByUser($registration->getUser())) == 1 && ($this->repo->countRegistrationsByEvent($registration->getEvent()) == 1)) {
            throw new Exception("❌ Vous êtes déjà inscrit à cet évènement.");
        }

        // Vérifier si l’événement est complet.
        //dd($this->repo->countRegistrationsByEvent($registration->getEvent()), $registration->getEvent()->getMaxParticipants());
        if ($this->repo->countRegistrationsByEvent($registration->getEvent()) >= $registration->getEvent()->getMaxParticipants()) {
            throw new Exception("❌ Il y a déjà trop d'inscrits pour cet évènement.");
        }

        // Ajouter la réservation
        $this->repo->add($registration);
        $this->entityManager->flush();

        // Lancer un Event Symfony UserRegisteredEvent.
        $eventListener = new UserRegisteredEvent($registration->getUser(), $registration->getEvent());
        $this->dispatcher->dispatch($eventListener, UserRegisteredEvent::NAME);

        // Envoie d'un mail par la nouvelle classe SendMailRegisteredEvent
        $this->sendMailRegisteredEvent->onUserRegisteredEvent($eventListener);

        // Création d'un log avec loggerInterface
        $this->logRegisteredEvent->onUserRegisteredEvent($eventListener);

        // Envoie d'un sms par la nouvelle classe SendSmsRegisteredEvent
        $this->smsRegisteredEvent->onUserRegisteredEvent($eventListener);
    }
}