<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="cet email est exite déjà!")
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
     * @ORM\Column(type="string", length=255, nullable=true)
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
    private $businessSubCategory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyTitle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
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

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $memberType;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActivity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */ 
    private $firstname;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isParticular;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $siretNumber;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $log;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="user_category_activity_id",referencedColumnName="id",onDelete="SET NULL")
     */
    private $userCategoryActivity;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $freeDateExpire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cities")
     */
    private $userCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyCarater;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $companydescription;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyDateCrea;
    

    public function __construct()
    {
        
    }

   
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

    public function getMemberType(): ?string
    {
        return $this->memberType;
    }

    public function setMemberType(?string $memberType): self
    {
        $this->memberType = $memberType;

        return $this;
    }

    public function getIsActivity(): ?bool
    {
        return $this->isActivity;
    }

    public function setIsActivity(?bool $isActivity): self
    {
        $this->isActivity = $isActivity;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): self
    {
        $this->enabled = $enabled;

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

    public function getSiretNumber(): ?string
    {
        return $this->siretNumber;
    }

    public function setSiretNumber(?string $siretNumber): self
    {
        $this->siretNumber = $siretNumber;

        return $this;   
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLog(): ?string
    {
        return $this->log;
    }

    public function setLog(?string $log): self
    {
        $this->log = $log;

        return $this;
    }

    public function getUserCategoryActivity(): ?Category
    {
        return $this->userCategoryActivity;
    }

    public function setUserCategoryActivity(?Category $userCategoryActivity): self
    {
        $this->userCategoryActivity = $userCategoryActivity;

        return $this;
    }

    public function getFreeDateExpire(): ?\DateTimeInterface
    {
        return $this->freeDateExpire;
    }

    public function setFreeDateExpire(?\DateTimeInterface $freeDateExpire): self
    {
        $this->freeDateExpire = $freeDateExpire;

        return $this;
    }

    public function getUserCity(): ?Cities
    {
        return $this->userCity;
    }

    public function setUserCity(?Cities $userCity): self
    {
        $this->userCity = $userCity;

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

    public function getCompanyCarater(): ?string
    {
        return $this->companyCarater;
    }

    public function setCompanyCarater(string $companyCarater): self
    {
        $this->companyCarater = $companyCarater;

        return $this;
    }

    public function getCompanydescription(): ?string
    {
        return $this->companydescription;
    }

    public function setCompanydescription(?string $companydescription): self
    {
        $this->companydescription = $companydescription;

        return $this;
    }

    public function getCompanyDateCrea(): ?string
    {
        return $this->companyDateCrea;
    }

    public function setCompanyDateCrea(?string $companyDateCrea): self
    {
        $this->companyDateCrea = $companyDateCrea;

        return $this;
    }

}
