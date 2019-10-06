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
     */
    private $articleCategId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $articleTitle;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $articleDateCrea;


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

}
