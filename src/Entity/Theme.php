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
    private $ImageCapture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ColorFond;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $KeyWord;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $KeyRoot;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Comments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageCapture(): ?string
    {
        return $this->ImageCapture;
    }

    public function setImageCapture(string $ImageCapture): self
    {
        $this->ImageCapture = $ImageCapture;

        return $this;
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

    
    public function getKeyRoot(): ?string
    {
        return $this->KeyRoot;
    }

    public function setKeyRoot(string $KeyRoot): self
    {
        $this->KeyRoot = $KeyRoot;

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

    public function getKeyWord(): ?string
    {
        return $this->KeyWord;
    }

    public function setKeyWord(string $KeyWord): self
    {
        $this->KeyWord = $KeyWord;

        return $this;
    }

}
