<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonneRepository")
 */
class Personne
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
    private $NomP;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $PrenomP;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(choices={"Homme", "Femme"})
     * @ORM\Column(type="string", length=255)
     */
    private $Sexe;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mariage", mappedBy="personne")
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

    public function getNomP(): ?string
    {
        return $this->NomP;
    }

    public function setNomP(string $NomP): self
    {
        $this->NomP = $NomP;

        return $this;
    }

    public function getPrenomP(): ?string
    {
        return $this->PrenomP;
    }

    public function setPrenomP(string $PrenomP): self
    {
        $this->PrenomP = $PrenomP;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->Sexe;
    }

    public function setSexe(string $Sexe): self
    {
        $this->Sexe = $Sexe;

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
            $mariage->setPersonne($this);
        }

        return $this;
    }

    public function removeMariage(Mariage $mariage): self
    {
        if ($this->mariage->contains($mariage)) {
            $this->mariage->removeElement($mariage);
            // set the owning side to null (unless already changed)
            if ($mariage->getPersonne() === $this) {
                $mariage->setPersonne(null);
            }
        }

        return $this;
    }

    
}
