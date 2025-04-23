<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Form\EventRegistrationFormType;
use App\Service\EventRegistrationManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EventRegistrationController extends AbstractController
{
    #[Route('/event/registration', name: 'app_event_registration')]
    public function index(Request $request, EventRegistrationManager $registrationManager): Response
    {
        $registration = new Registration();

        $form = $this->createForm(EventRegistrationFormType::class, $registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $registration = $form->getData();
           
            try {
                $registration->setUser($form->getData()->getUser());
                $registration->setEvent( $form->getData()->getEvent());
                $registration->setRegisteredAt(new \DateTimeImmutable());

                $registrationManager->addRegistration($registration);
                $this->addFlash('success', 'Réservation enregistrée avec succès.');

                return $this->redirectToRoute('app_home');

            } catch (\Exception $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('app_home');
            }            

            return $this->redirectToRoute('app_home');
        }

        return $this->render('event_registration/event_registration.html.twig', [
            'controller_name' => 'EventRegistrationController',
            'eventRegistrationForm' => $form->createView()          
        ]);        
    }
}