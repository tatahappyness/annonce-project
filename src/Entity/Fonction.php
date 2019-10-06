<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FonctionRepository")
 */
class Fonction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $fonctionName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFonctionName(): ?string
    {
        return $this->fonctionName;
    }

    public function setFonctionName(?string $fonctionName): self
    {
        $this->fonctionName = $fonctionName;

        return $this;
    }

    public function getDateCrea(): ?\DateTimeInterface
    {
        return $this->dateCrea;
    }

    public function setDateCrea(?\DateTimeInterface $dateCrea): self
    {
        $this->dateCrea = $dateCrea;

        return $this;
    }
}
