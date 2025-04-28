<?php

namespace App\Tests;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IntegrationApiControllerTest extends WebTestCase
{    
    public function testGetRegistration()
    {
        $client = static::createClient();
        $client->enableProfiler();  

        // Envoie une requête GET à la route /api/registrations
        $client->request('GET', '/api/registrations');

        // Vérifie que la réponse a un statut 401 CAR PAS DE TOKEN BEARER        
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

        
        // BESOIN DU TOKEN :
        
        // Envoie une requête GET à la route /api/registrations
        $client->request(
            'POST', 
            '/api/login_check',
            [], 
            [], 
            ['CONTENT_TYPE' => 'application/json'], 
            json_encode(['email' => 'admin@aol.fr','password' => 'admin'])
        );
        
        // Vérifie que la réponse a un statut 200 OK        
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Décode le contenu JSON de la réponse pour récupérer le token
        $data = json_decode($client->getResponse()->getContent());        
        $token = $data->token;

        $client->request(
            'GET',
            '/api/registrations',
            [],
            [],
            ['HTTP_AUTHORIZATION' => 'Bearer ' . $token]
        );

        // Vérifie que la réponse a un statut 200 OK        
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        // Vérifie que le Content-Type est application/json dd($client->getResponse()->headers->get('Content-type'));
        $this->assertResponseHeaderSame('Content-type', 'application/ld+json; charset=utf-8');

        // Décode le contenu JSON de la réponse des registrations
        $data = json_decode($client->getResponse()->getContent());
        
        // 3 données retournées pour tous les enregistrements: 2 objets user et event + datetime du createdAt
        foreach($data->member as $d) {             
            $this->assertStringContainsString('/api/users/', $d->user);
            $this->assertStringContainsString('/api/events/', $d->event);
            $this->assertIsString($d->registeredAt);
        }
    }
}