<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MariageRepository")
 */
class Mariage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $DateMariage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personne", inversedBy="epoux")
     */
    private $personne;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Invite", mappedBy="mariage")
     */
    private $invites;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Salle", inversedBy="mariage")
     */
    private $salle;

    public function __construct()
    {
        $this->invites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMariage(): ?\DateTimeInterface
    {
        return $this->DateMariage;
    }

    public function setDateMariage(\DateTimeInterface $DateMariage): self
    {
        $this->DateMariage = $DateMariage;

        return $this;
    }

    public function getPersonne(): ?Personne
    {
        return $this->personne;
    }

    public function setPersonne(?Personne $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * @return Collection|Invite[]
     */
    public function getInvites(): Collection
    {
        return $this->invites;
    }

    public function addInvite(Invite $invite): self
    {
        if (!$this->invites->contains($invite)) {
            $this->invites[] = $invite;
            $invite->addMariage($this);
        }

        return $this;
    }

    public function removeInvite(Invite $invite): self
    {
        if ($this->invites->contains($invite)) {
            $this->invites->removeElement($invite);
            $invite->removeMariage($this);
        }

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): self
    {
        $this->salle = $salle;

        return $this;
    }
}
