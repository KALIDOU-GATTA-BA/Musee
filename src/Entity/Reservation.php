<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

use App\Validator\Constraints\GeneralConstraints;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @GeneralConstraints()
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $visitDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ticket", cascade={"persist"})
     */
    private $tickets;

    /**
     * @ORM\Column(type="boolean")
     */
    private $payment;

    /**
     * @ORM\Column(type="integer")
     */
    private $count;

    public function __construct()
    {
        
        $this->tickets = new ArrayCollection();
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVisitDate(): ?\DateTimeInterface
    {
        return $this->visitDate;
    }

    public function setVisitDate(\DateTimeInterface $visitDate): self
    {
        $this->visitDate = $visitDate;
        return $this;
    }
    /**
     * @return Collection|Ticket[]
     */
    public function getTickets()
    {
        return $this->tickets;
    }
    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
        }
        return $this;
    }
    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
        }
        return $this;
    }

    public function getPayment(): ?bool
    {
        return $this->payment;
    }

    public function setPayment(bool $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}