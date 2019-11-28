<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThemeRepository")
 */
class Theme
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
    private $ImageFond;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ColorFond;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Comments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageFond(): ?string
    {
        return $this->ImageFond;
    }

    public function setImageFond(string $ImageFond): self
    {
        $this->ImageFond = $ImageFond;

        return $this;
    }

    public function getColorFond(): ?string
    {
        return $this->ColorFond;
    }

    public function setColorFond(string $ColorFond): self
    {
        $this->ColorFond = $ColorFond;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->Comments;
    }

    public function setComments(string $Comments): self
    {
        $this->Comments = $Comments;

        return $this;
    }

}
