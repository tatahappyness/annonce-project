<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SousCategoryRepository")
 */
class SousCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true) 
     */
    private $sousCategTitle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $sousCategDateCrea;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $icon;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="cat_sous_category_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $catSousCategoryId;


    public function __construct()
    {
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSousCategTitle(): ?string
    {
        return $this->sousCategTitle;
    }

    public function setSousCategTitle(?string $sousCategTitle): self
    {
        $this->sousCategTitle = $sousCategTitle;

        return $this;
    }

    public function getSousCategDateCrea(): ?\DateTimeInterface
    {
        return $this->sousCategDateCrea;
    }

    public function setSousCategDateCrea(?\DateTimeInterface $sousCategDateCrea): self
    {
        $this->sousCategDateCrea = $sousCategDateCrea;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    
    public function getCatSousCategoryId(): ?Category
    {
        return $this->catSousCategoryId;
    }

    public function setCatSousCategoryId(?Category $catSousCategoryId): self
    {
        $this->catSousCategoryId = $catSousCategoryId;

        return $this;
    }


}
