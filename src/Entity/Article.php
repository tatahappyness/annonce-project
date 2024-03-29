<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="article_categ_id_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $articleCategId;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\SousCategory")
    * @ORM\JoinColumn(name="article_sous_categ_id_id", referencedColumnName="id",onDelete="SET NULL")
    */
    private $articleSousCategId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $articleTitle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $articleDateCrea;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $img;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $icon;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPopular;


    public function __construct()
    {
    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleCategId(): ?Category
    {
        return $this->articleCategId;
    }

    public function setArticleCategId(?Category $articleCategId): self
    {
        $this->articleCategId = $articleCategId;

        return $this;
    }

    public function getArticleSousCategId(): ?SousCategory
    {
        return $this->articleSousCategId;
    }

    public function setArticleSousCategId(?SousCategory $articleSousCategId): self
    {
        $this->articleSousCategId = $articleSousCategId;

        return $this;
    }

    public function getArticleTitle(): ?string
    {
        return $this->articleTitle;
    }

    public function setArticleTitle(?string $articleTitle): self
    {
        $this->articleTitle = $articleTitle;

        return $this;
    }

    public function getArticleDateCrea(): ?\DateTimeInterface
    {
        return $this->articleDateCrea;
    }

    public function setArticleDateCrea(?\DateTimeInterface $articleDateCrea): self
    {
        $this->articleDateCrea = $articleDateCrea;

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

    public function getIsPopular(): ?bool
    {
        return $this->isPopular;
    }

    public function setIsPopular(?bool $isPopular): self
    {
        $this->isPopular = $isPopular;

        return $this;
    }

}
