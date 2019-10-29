<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OptionEmailRepository")
 */
class OptionEmail
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
    private $typekey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypekey(): ?string
    {
        return $this->typekey;
    }

    public function setTypekey(string $typekey): self
    {
        $this->typekey = $typekey;

        return $this;
    }
}
