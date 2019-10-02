<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReponsePostAdsRepository")
 */
class ReponsePostAds
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $userPartId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $userProId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post")
     */
    private $postAdsId;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserPartId(): ?User
    {
        return $this->userPartId;
    }

    public function setUserPartId(?User $userPartId): self
    {
        $this->userPartId = $userPartId;

        return $this;
    }

    public function getUserProId(): ?User
    {
        return $this->userProId;
    }

    public function setUserProId(?User $userProId): self
    {
        $this->userProId = $userProId;

        return $this;
    }

    public function getPostAdsId(): ?Post
    {
        return $this->postAdsId;
    }

    public function setPostAdsId(?Post $postAdsId): self
    {
        $this->postAdsId = $postAdsId;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

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
