<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RealisationsRepository")
 * @ORM\Table(name="realisations")
 */
class Realisations
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Type("integer")
     * @JMS\Groups({"realisations"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Type("string")
     * @JMS\Groups({"realisations"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Type("string")
     * @JMS\Groups({"realisations"})
     *
     */
    private $thumbnail;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}
