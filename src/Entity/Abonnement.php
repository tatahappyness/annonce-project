<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AbonnementRepository")
 */
class Abonnement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer")
     * @ORM\JoinColumn(name="customer_id_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $customerId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Services")
     * @ORM\JoinColumn(name="service_id_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $serviceId;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datePayement;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateExpire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): ?Customer
    {
        return $this->customerId;
    }

    public function setCustomerId(?Customer $customerId): self
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getServiceId(): ?Services
    {
        return $this->serviceId;
    }

    public function setServiceId(?Services $serviceId): self
    {
        $this->serviceId = $serviceId;

        return $this;
    }

    public function getDatePayement(): ?\DateTimeInterface
    {
        return $this->datePayement;
    }

    public function setDatePayement(?\DateTimeInterface $datePayement): self
    {
        $this->datePayement = $datePayement;

        return $this;
    }

    public function getDateExpire(): ?\DateTimeInterface
    {
        return $this->dateExpire;
    }

    public function setDateExpire(?\DateTimeInterface $dateExpire): self
    {
        $this->dateExpire = $dateExpire;

        return $this;
    }
}
