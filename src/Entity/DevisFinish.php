<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisFinishRepository")
 */
class DevisFinish
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
     * @ORM\ManyToOne(targetEntity="App\Entity\DevisValid")
     * @ORM\JoinColumn(name="devis_valid_id",referencedColumnName="id",onDelete="CASCADE")
     */
    private $devisValid;

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

    public function getDevisValid(): ?DevisValid
    {
        return $this->devisValid;
    }

    public function setDevisValid(?DevisValid $devisValid): self
    {
        $this->devisValid = $devisValid;

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
