<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExperiencesRepository")
 * @ORM\Table(name="experiences")
 */
class Experiences
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Type("integer")
     * @JMS\Groups({"experiences"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     * @JMS\Type("string")
     * @JMS\Groups({"experiences"})
     */
    private $poste;

    /**
     * @ORM\Column(type="string", length=1000)
     * @JMS\Type("string")
     * @JMS\Groups({"experiences"})
     */
    private $entreprise;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @JMS\Type("string")
     * @JMS\Groups({"experiences"})
     */
    private $descriptions;

    /**
     * @ORM\Column(type="string", length=1000)
     * @JMS\Type("string")
     * @JMS\Groups({"experiences"})
     */
    private $duree;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getEntreprise(): ?string
    {
        return $this->entreprise;
    }

    public function setEntreprise(string $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->descriptions;
    }

    public function setDescriptions(string $descriptions): self
    {
        $this->descriptions = $descriptions;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }


}
