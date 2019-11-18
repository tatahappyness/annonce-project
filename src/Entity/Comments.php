<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $userId;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPro;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isParticular;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isPublish;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getIsPro(): ?bool
    {
        return $this->isPro;
    }

    public function setIsPro(?bool $isPro): self
    {
        $this->isPro = $isPro;

        return $this;
    }

    public function getIsParticular(): ?bool
    {
        return $this->isParticular;
    }

    public function setIsParticular(?bool $isParticular): self
    {
        $this->isParticular = $isParticular;

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

    public function getIsPublish(): ?bool
    {
        return $this->isPublish;
    }

    public function setIsPublish(?bool $isPublish): self
    {
        $this->isPublish = $isPublish;

        return $this;
    }
}
