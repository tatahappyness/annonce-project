<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisRepository")
 */
class Devis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\JoinColumn(name="dev_user_id_id",referencedColumnName="id",onDelete="SET NULL")
     */
    private $devUserId;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $detailProject;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAcceptedCondition;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $civility;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAskDemande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="dev_user_id_dest_id",referencedColumnName="id",onDelete="SET NULL")
     */
    private $devUserIdDest;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateCrea;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article")
     * @ORM\JoinColumn(name="nature_project_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $natureProject;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Fonction")
     * @ORM\JoinColumn(name="fonction_id_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $fonctionId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type")
     * @ORM\JoinColumn(name="type_project_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $typeProject;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="category_id_id", referencedColumnName="id",onDelete="SET NULL")
     */
    private $CategoryId;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $appartementType;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $prestType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cities")
     */
    private $city;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numDepartement;

    /**
     * @ORM\Column(type="string", length=200,  nullable=true)
     */
    private $fonctionCategory;

    /**
     * @ORM\Column(type="string", length=100,  nullable=true)
     */
    private $timerAppontement;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevUserId(): ?User
    {
        return $this->devUserId;
    }

    public function setDevUserId(?User $devUserId): self
    {
        $this->devUserId = $devUserId;

        return $this;
    }

    public function getDetailProject(): ?string
    {
        return $this->detailProject;
    }

    public function setDetailProject(?string $detailProject): self
    {
        $this->detailProject = $detailProject;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    public function getIsAcceptedCondition(): ?bool
    {
        return $this->isAcceptedCondition;
    }

    public function setIsAcceptedCondition(bool $isAcceptedCondition): self
    {
        $this->isAcceptedCondition = $isAcceptedCondition;

        return $this;
    }

    public function getCivility(): ?string
    {
        return $this->civility;
    }

    public function setCivility(?string $civility): self
    {
        $this->civility = $civility;

        return $this;
    }

    public function getIsAskDemande(): ?bool
    {
        return $this->isAskDemande;
    }

    public function setIsAskDemande(?bool $isAskDemande): self
    {
        $this->isAskDemande = $isAskDemande;

        return $this;
    }

    public function getDevUserIdDest(): ?User
    {
        return $this->devUserIdDest;
    }

    public function setDevUserIdDest(?User $devUserIdDest): self
    {
        $this->devUserIdDest = $devUserIdDest;

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

    public function getNatureProject(): ?Article
    {
        return $this->natureProject;
    }

    public function setNatureProject(?Article $natureProject): self
    {
        $this->natureProject = $natureProject;

        return $this;
    }

    public function getFonctionId(): ?Fonction
    {
        return $this->fonctionId;
    }

    public function setFonctionId(?Fonction $fonctionId): self
    {
        $this->fonctionId = $fonctionId;

        return $this;
    }

    public function getTypeProject(): ?Type
    {
        return $this->typeProject;
    }

    public function setTypeProject(?Type $typeProject): self
    {
        $this->typeProject = $typeProject;

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

    public function getAppartementType(): ?string
    {
        return $this->appartementType;
    }

    public function setAppartementType(?string $appartementType): self
    {
        $this->appartementType = $appartementType;

        return $this;
    }

    public function getPrestType(): ?string
    {
        return $this->prestType;
    }

    public function setPrestType(string $prestType): self
    {
        $this->prestType = $prestType;

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

    public function getNumDepartement(): ?int
    {
        return $this->numDepartement;
    }

    public function setNumDepartement(?int $numDepartement): self
    {
        $this->numDepartement = $numDepartement;

        return $this;
    }

    public function getFonctionCategory(): ?string
    {
        return $this->fonctionCategory;
    }

    public function setFonctionCategory(string $fonctionCategory): self
    {
        $this->fonctionCategory = $fonctionCategory;

        return $this;
    }

    public function getTimerAppontement(): ?string
    {
        return $this->timerAppontement;
    }

    public function setTimerAppontement(string $timerAppontement): self
    {
        $this->timerAppontement = $timerAppontement;

        return $this;
    }
}
