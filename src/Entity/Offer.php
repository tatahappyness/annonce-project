<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $offerPrice;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="category_id_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $categoryId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfferPrice(): ?float
    {
        return $this->offerPrice;
    }

    public function setOfferPrice(?float $offerPrice): self
    {
        $this->offerPrice = $offerPrice;

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

    public function getCategoryId(): ?Category
    {
        return $this->categoryId;
    }

    public function setCategoryId(?Category $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }
}
