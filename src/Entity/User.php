<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $geoLocation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessSubCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyTitle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAcceptConditionTerm;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isBusiness;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isProfessional;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $profilImage;

   
    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getBusinessCategory(): ?string
    {
        return $this->businessCategory;
    }

    public function setBusinessCategory(?string $businessCategory): self
    {
        $this->businessCategory = $businessCategory;

        return $this;
    }

    public function getGeoLocation(): ?string
    {
        return $this->geoLocation;
    }

    public function setGeoLocation(?string $geoLocation): self
    {
        $this->geoLocation = $geoLocation;

        return $this;
    }

    public function getBusinessSubCategory(): ?string
    {
        return $this->businessSubCategory;
    }

    public function setBusinessSubCategory(?string $businessSubCategory): self
    {
        $this->businessSubCategory = $businessSubCategory;

        return $this;
    }

    public function getCompanyTitle(): ?string
    {
        return $this->companyTitle;
    }

    public function setCompanyTitle(?string $companyTitle): self
    {
        $this->companyTitle = $companyTitle;

        return $this;
    }

    public function getIsAcceptConditionTerm(): ?bool
    {
        return $this->isAcceptConditionTerm;
    }

    public function setIsAcceptConditionTerm(bool $isAcceptConditionTerm): self
    {
        $this->isAcceptConditionTerm = $isAcceptConditionTerm;

        return $this;
    }

    public function getIsBusiness(): ?bool
    {
        return $this->isBusiness;
    }

    public function setIsBusiness(?bool $isBusiness): self
    {
        $this->isBusiness = $isBusiness;

        return $this;
    }

    public function getIsProfessional(): ?bool
    {
        return $this->isProfessional;
    }

    public function setIsProfessional(?bool $isProfessional): self
    {
        $this->isProfessional = $isProfessional;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getProfilImage(): ?string
    {
        return $this->profilImage;
    }

    public function setProfilImage(?string $profilImage): self
    {
        $this->profilImage = $profilImage;

        return $this;
    }


}
