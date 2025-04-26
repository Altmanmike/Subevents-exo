<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $maxParticipants = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Registration>
     */
    #[ORM\OneToMany(targetEntity: Registration::class, mappedBy: 'event')]
    private Collection $registrations;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
        $this->registrations = new ArrayCollection();
    }
       
    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
        
    /**
     * @return ?string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    
    /**
     * @param mixed $title
     * @return static
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
    
    /**
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    /**
     * @param mixed $description
     * @return static
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
    
    /**
     * @return ?int
     */
    public function getMaxParticipants(): ?int
    {
        return $this->maxParticipants;
    }
    
    /**
     * @param mixed $maxParticipants
     * @return static
     */
    public function setMaxParticipants(int $maxParticipants): static
    {
        $this->maxParticipants = $maxParticipants;

        return $this;
    }
    
    /**
     * @return ?\DateTimeImmutable
     */
    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }
    
    /** 
     * @param mixed $startAt
     * @return static
     */
    public function setStartAt(\DateTimeImmutable $startAt): static
    {
        $this->startAt = $startAt;

        return $this;
    }
    
    /**
     * @return ?DateTimeImmutable
     */
    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }
    
    /**
     * @param mixed $endAt
     * @return static
     */
    public function setEndAt(\DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }
    
    /**
     * @return ?\DateTimeImmutable
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }
    
    /**
     * @param mixed $createdAt
     * @return static
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    
    /**
     * @return ?\DateTimeImmutable
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
    
    /**
     * @param mixed $updatedAt
     * @return static
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Registration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }
    
    /**
     * @param mixed $registration
     * @return static
     */
    public function addRegistrations(Registration $registration): static
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations->add($registration);
            $registration->setEvent($this);
        }

        return $this;
    }
    
    /**
     * @param mixed $registration
     * @return static
     */
    public function removeRegistrations(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getEvent() === $this) {
                $registration->setEvent(null);
            }
        }

        return $this;
    }
}
