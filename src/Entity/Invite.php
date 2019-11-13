<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Personne;
/**
 * @ORM\Entity(repositoryClass="App\Repository\InviteRepository")
 */
class Invite extends Personne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Mariage", inversedBy="invites")
     */
    private $mariage;

    public function __construct()
    {
        $this->mariage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Mariage[]
     */
    public function getMariage(): Collection
    {
        return $this->mariage;
    }

    public function addMariage(Mariage $mariage): self
    {
        if (!$this->mariage->contains($mariage)) {
            $this->mariage[] = $mariage;
        }

        return $this;
    }

    public function removeMariage(Mariage $mariage): self
    {
        if ($this->mariage->contains($mariage)) {
            $this->mariage->removeElement($mariage);
        }

        return $this;
    }
}
