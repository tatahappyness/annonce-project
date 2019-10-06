<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $postUserId;
    
    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $postLocation;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $postZipcode;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $postRegion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postLatitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $postLongitude;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $postAdsTravauxDescription;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $postAdsDateCrea;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $postAdsTypeClient;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $postAdsTypeHabitation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $postAdsStartDate;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $postAdsTravauxSurface;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $postAdsEtatTerrain;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     */
    private $typeId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private $CategoryId;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cities")
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostUserId(): ?User
    {
        return $this->postUserId;
    }

    public function setPostUserId(?User $postUserId): self
    {
        $this->postUserId = $postUserId;

        return $this;
    }

    public function getPostZipcode(): ?string
    {
        return $this->postZipcode;
    }

    public function setPostZipcode(?string $postZipcode): self
    {
        $this->postZipcode = $postZipcode;

        return $this;
    }


    public function getPostRegion(): ?string
    {
        return $this->postRegion;
    }

    public function setPostRegion(?string $postRegion): self
    {
        $this->postRegion = $postRegion;

        return $this;
    }

    public function getPostLatitude(): ?string
    {
        return $this->postLatitude;
    }

    public function setPostLatitude(?string $postLatitude): self
    {
        $this->postLatitude = $postLatitude;

        return $this;
    }

    public function getPostLongitude(): ?string
    {
        return $this->postLongitude;
    }

    public function setPostLongitude(?string $postLongitude): self
    {
        $this->postLongitude = $postLongitude;

        return $this;
    }

    public function getPostAdsTravauxDescription(): ?string
    {
        return $this->postAdsTravauxDescription;
    }

    public function setPostAdsTravauxDescription(?string $postAdsTravauxDescription): self
    {
        $this->postAdsTravauxDescription = $postAdsTravauxDescription;

        return $this;
    }

    public function getPostAdsDateCrea(): ?\DateTimeInterface
    {
        return $this->postAdsDateCrea;
    }

    public function setPostAdsDateCrea(?\DateTimeInterface $postAdsDateCrea): self
    {
        $this->postAdsDateCrea = $postAdsDateCrea;

        return $this;
    }

    public function getPostAdsTypeHabitation(): ?string
    {
        return $this->postAdsTypeHabitation;
    }

    public function setPostAdsTypeHabitation(?string $postAdsTypeHabitation): self
    {
        $this->postAdsTypeHabitation = $postAdsTypeHabitation;

        return $this;
    }

    public function getPostAdsStartDate(): ?\DateTimeInterface
    {
        return $this->postAdsStartDate;
    }

    public function setPostAdsStartDate(?\DateTimeInterface $postAdsStartDate): self
    {
        $this->postAdsStartDate = $postAdsStartDate;

        return $this;
    }

    public function getPostAdsTravauxSurface(): ?string
    {
        return $this->postAdsTravauxSurface;
    }

    public function setPostAdsTravauxSurface(?string $postAdsTravauxSurface): self
    {
        $this->postAdsTravauxSurface = $postAdsTravauxSurface;

        return $this;
    }

    public function getPostAdsEtatTerrain(): ?string
    {
        return $this->postAdsEtatTerrain;
    }

    public function setPostAdsEtatTerrain(?string $postAdsEtatTerrain): self
    {
        $this->postAdsEtatTerrain = $postAdsEtatTerrain;

        return $this;
    }

    public function getTypeId(): ?Type
    {
        return $this->typeId;
    }

    public function setTypeId(?Type $typeId): self
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getCategoryId(): ?Category
    {
        return $this->CategoryId;
    }

    public function setCategoryId(?Category $CategoryId): self
    {
        $this->CategoryId = $CategoryId;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): self
    {
        $this->city = $city;

        return $this;
    }

   
}
