<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EvaluationsRepository")
 */
class Evaluations
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
    private $userProId;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\User")
    */
    private $userPartId;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $haveStart;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $motif;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHaveStart(): ?string
    {
        return $this->haveStart;
    }

    public function setHaveStart(?string $haveStart): self
    {
        $this->haveStart = $haveStart;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

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

    public function getUserPartId(): ?User
    {
        return $this->userPartId;
    }

    public function setUserPartId(?User $userPartId): self
    {
        $this->userPartId = $userPartId;

        return $this;
    }

}
