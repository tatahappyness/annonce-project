<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisViewedRepository")
 */
class DevisViewed
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user_id_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Devis")
     * @ORM\JoinColumn(name="devis_id_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $devisId;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isclicked;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDevisId(): ?Devis
    {
        return $this->devisId;
    }

    public function setDevisId(?Devis $devisId): self
    {
        $this->devisId = $devisId;

        return $this;
    }

    public function getIsclicked(): ?bool
    {
        return $this->isclicked;
    }

    public function setIsclicked(?bool $isclicked): self
    {
        $this->isclicked = $isclicked;

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
