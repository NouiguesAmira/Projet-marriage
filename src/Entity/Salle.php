<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalleRepository")
 */
class Salle
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
    private $NomS;

    /**
     * @Assert\NotBlank
     * @ORM\Column(type="string", length=255)
     */
    private $AdresseS;


    /**
     * @Assert\NotBlank
     * @ORM\Column(type="integer")
     */
    private $CapasiteS;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mariage", mappedBy="salle")
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

    public function getNomS(): ?string
    {
        return $this->NomS;
    }

    public function setNomS(string $NomS): self
    {
        $this->NomS = $NomS;

        return $this;
    }

    public function getAdresseS(): ?string
    {
        return $this->AdresseS;
    }

    public function setAdresseS(string $AdresseS): self
    {
        $this->AdresseS = $AdresseS;

        return $this;
    }

 

    public function getCapasiteS(): ?int
    {
        return $this->CapasiteS;
    }

    public function setCapasiteS(int $CapasiteS): self
    {
        $this->CapasiteS = $CapasiteS;

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
            $mariage->setSalle($this);
        }

        return $this;
    }

    public function removeMariage(Mariage $mariage): self
    {
        if ($this->mariage->contains($mariage)) {
            $this->mariage->removeElement($mariage);
            // set the owning side to null (unless already changed)
            if ($mariage->getSalle() === $this) {
                $mariage->setSalle(null);
            }
        }

        return $this;
    }
}
