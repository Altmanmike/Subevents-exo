<?php

namespace App\EventListener;

use Symfony\Component\Mime\Email;
use App\Event\UserRegisteredEvent;
use Symfony\Component\Mailer\MailerInterface;

class SendMailRegisteredEvent 
{
    public function __construct(private MailerInterface $mailer) {}

    public function onUserRegisteredEvent(UserRegisteredEvent $event)
    {
        $user = $event->getUser();
        $eventt = $event->getEvent();

        $email = (new Email())
            ->from('zenith.kings77@gmail.com')
            ->to($user->getEmail())
            ->subject('Enregistrement à l\'évènement '.$eventt->getTitle())
            ->text('Vous '.$user->getEmail().' êtes bien enregistré à l\'évènement '.$eventt->getTitle());        
        
        $this->mailer->send($email);
    }
}