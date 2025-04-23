<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

/**
 * Secured resource.
 */
#[ApiResource(
    operations: [
        new Get(security: "is_granted('ROLE_USER')", securityMessage: 'Nécessite une authentification par token'),
        new GetCollection(security: "is_granted('ROLE_USER')", securityMessage: 'Nécessite une authentification par token'),
        new Post(security: "is_granted('ROLE_ADMIN')", securityMessage: 'Nécessite une authentification par token et d\'être admin'),
        new Put(security: "is_granted('ROLE_ADMIN')", securityMessage: 'Nécessite une authentification par token et d\'être admin'),
        new Patch(security: "is_granted('ROLE_ADMIN')", securityMessage: 'Nécessite une authentification par token et d\'être admin'),
        new Delete(security: "is_granted('ROLE_ADMIN')", securityMessage: 'Nécessite une authentification par token et d\'être admin')
    ]
)]
#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $registeredAt = null;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    private ?Event $event = null;

    public function __construct() {
        $this->registeredAt = new \DateTimeImmutable(); 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeImmutable $registeredAt): static
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }
}
