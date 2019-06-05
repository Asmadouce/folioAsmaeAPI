<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetencesRepository")
 * @ORM\Table(name="competence")
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Type("integer")
     * @JMS\Groups({"competence"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Type("string")
     * @JMS\Groups({"competence"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Type("string")
     * @JMS\Groups({"competence"})
     */
    private $img;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }
}
