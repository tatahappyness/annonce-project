<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImagesRepository")
 */
class Images
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article")
     * @ORM\JoinColumn(name="article_title_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $articleTitle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $UserId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleTitle(): ?Article
    {
        return $this->articleTitle;
    }

    public function setArticleTitle(?Article $articleTitle): self
    {
        $this->articleTitle = $articleTitle;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function setUserId(?User $UserId): self
    {
        $this->UserId = $UserId;

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
