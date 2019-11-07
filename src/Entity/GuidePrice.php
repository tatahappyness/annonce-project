<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GuidePriceRepository")
 */
class GuidePrice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SousCategory")
     * @ORM\JoinColumn(name="sous_category_id_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $sousCategoryId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article")
     * @ORM\JoinColumn(name="article_id_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $articleId;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $subjectLink;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryId(): ?SousCategory
    {
        return $this->sousCategoryId;
    }

    public function setCategoryId(?SousCategory $sousCategoryId): self
    {
        $this->sousCategoryId = $sousCategoryId;

        return $this;
    }

    public function getArticleId(): ?Article
    {
        return $this->articleId;
    }

    public function setArticleId(?Article $articleId): self
    {
        $this->articleId = $articleId;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

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

    public function getSubjectLink(): ?string
    {
        return $this->subjectLink;
    }

    public function setSubjectLink(?string $subjectLink): self
    {
        $this->subjectLink = $subjectLink;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
}
