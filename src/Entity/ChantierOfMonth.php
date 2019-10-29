<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChantierOfMonthRepository")
 */
class ChantierOfMonth
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="category_id_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $categoryId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article")
     * @ORM\JoinColumn(name="article_id_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $articleId;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $imageBefor;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $imageAfter;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getArticle(): ?Article
    {
        return $this->articleId;
    }

    public function setArticle(?Article $articleId): self
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

    public function getImageBefor(): ?string
    {
        return $this->imageBefor;
    }

    public function setImageBefor(string $imageBefor): self
    {
        $this->imageBefor = $imageBefor;

        return $this;
    }

    public function getImageAfter(): ?string
    {
        return $this->imageAfter;
    }

    public function setImageAfter(?string $imageAfter): self
    {
        $this->imageAfter = $imageAfter;

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
