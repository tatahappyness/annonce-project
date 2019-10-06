<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CitiesRepository")
 */
class Cities
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $villeId;

    /**
     * @ORM\Column(type="string", length=4, nullable=true)
     */
    private $villeDepartement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $villeSlug;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $villeNom;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $villeNomSimple;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $villeNomReel;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $villeNomSoundex;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $villeNomMetaphone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $villeCodePostal;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $villeCommune;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $villeCodeCommune;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $villeArrondissement;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $villeCanton;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $villeAmdi;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $villePopulation_2010;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $villePopulation_1999;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $villePopulation_2012;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $villeDensite_2010;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $villeSurface;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $villeLongitudeDeg;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $villeLatitudeDeg;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $villeLongitudeGrd;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $villeLatitudeGrd;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $villeLongitudeDms;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $villeLatitudeDms;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $villeZmin;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $villeZmax;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVilleId(): ?int
    {
        return $this->villeId;
    }

    public function setVilleId(?int $villeId): self
    {
        $this->villeId = $villeId;

        return $this;
    }

    public function getVilleDepartement(): ?string
    {
        return $this->villeDepartement;
    }

    public function setVilleDepartement(?string $villeDepartement): self
    {
        $this->villeDepartement = $villeDepartement;

        return $this;
    }

    public function getVilleSlug(): ?string
    {
        return $this->villeSlug;
    }

    public function setVilleSlug(?string $villeSlug): self
    {
        $this->villeSlug = $villeSlug;

        return $this;
    }

    public function getVilleNom(): ?string
    {
        return $this->villeNom;
    }

    public function setVilleNom(?string $villeNom): self
    {
        $this->villeNom = $villeNom;

        return $this;
    }

    public function getVilleNomSimple(): ?string
    {
        return $this->villeNomSimple;
    }

    public function setVilleNomSimple(?string $villeNomSimple): self
    {
        $this->villeNomSimple = $villeNomSimple;

        return $this;
    }

    public function getVilleNomReel(): ?string
    {
        return $this->villeNomReel;
    }

    public function setVilleNomReel(?string $villeNomReel): self
    {
        $this->villeNomReel = $villeNomReel;

        return $this;
    }

    public function getVilleNomSoundex(): ?string
    {
        return $this->villeNomSoundex;
    }

    public function setVilleNomSoundex(?string $villeNomSoundex): self
    {
        $this->villeNomSoundex = $villeNomSoundex;

        return $this;
    }

    public function getVilleNomMetaphone(): ?string
    {
        return $this->villeNomMetaphone;
    }

    public function setVilleNomMetaphone(?string $villeNomMetaphone): self
    {
        $this->villeNomMetaphone = $villeNomMetaphone;

        return $this;
    }

    public function getVilleCodePostal(): ?string
    {
        return $this->villeCodePostal;
    }

    public function setVilleCodePostal(?string $villeCodePostal): self
    {
        $this->villeCodePostal = $villeCodePostal;

        return $this;
    }

    public function getVilleCommune(): ?string
    {
        return $this->villeCommune;
    }

    public function setVilleCommune(?string $villeCommune): self
    {
        $this->villeCommune = $villeCommune;

        return $this;
    }

    public function getVilleCodeCommune(): ?string
    {
        return $this->villeCodeCommune;
    }

    public function setVilleCodeCommune(?string $villeCodeCommune): self
    {
        $this->villeCodeCommune = $villeCodeCommune;

        return $this;
    }

    public function getVilleArrondissement(): ?int
    {
        return $this->villeArrondissement;
    }

    public function setVilleArrondissement(?int $villeArrondissement): self
    {
        $this->villeArrondissement = $villeArrondissement;

        return $this;
    }

    public function getVilleCanton(): ?string
    {
        return $this->villeCanton;
    }

    public function setVilleCanton(?string $villeCanton): self
    {
        $this->villeCanton = $villeCanton;

        return $this;
    }

    public function getVilleAmdi(): ?int
    {
        return $this->villeAmdi;
    }

    public function setVilleAmdi(?int $villeAmdi): self
    {
        $this->villeAmdi = $villeAmdi;

        return $this;
    }

    public function getVillePopulation2010(): ?int
    {
        return $this->villePopulation_2010;
    }

    public function setVillePopulation2010(?int $villePopulation_2010): self
    {
        $this->villePopulation_2010 = $villePopulation_2010;

        return $this;
    }

    public function getVillePopulation1999(): ?int
    {
        return $this->villePopulation_1999;
    }

    public function setVillePopulation1999(?int $villePopulation_1999): self
    {
        $this->villePopulation_1999 = $villePopulation_1999;

        return $this;
    }

    public function getVillePopulation2012(): ?int
    {
        return $this->villePopulation_2012;
    }

    public function setVillePopulation2012(?int $villePopulation_2012): self
    {
        $this->villePopulation_2012 = $villePopulation_2012;

        return $this;
    }

    public function getVilleDensite2010(): ?int
    {
        return $this->villeDensite_2010;
    }

    public function setVilleDensite2010(?int $villeDensite_2010): self
    {
        $this->villeDensite_2010 = $villeDensite_2010;

        return $this;
    }

    public function getVilleSurface(): ?float
    {
        return $this->villeSurface;
    }

    public function setVilleSurface(?float $villeSurface): self
    {
        $this->villeSurface = $villeSurface;

        return $this;
    }

    public function getVilleLongitudeDeg(): ?float
    {
        return $this->villeLongitudeDeg;
    }

    public function setVilleLongitudeDeg(?float $villeLongitudeDeg): self
    {
        $this->villeLongitudeDeg = $villeLongitudeDeg;

        return $this;
    }

    public function getVilleLatitudeDeg(): ?float
    {
        return $this->villeLatitudeDeg;
    }

    public function setVilleLatitudeDeg(?float $villeLatitudeDeg): self
    {
        $this->villeLatitudeDeg = $villeLatitudeDeg;

        return $this;
    }

    public function getVilleLongitudeGrd(): ?string
    {
        return $this->villeLongitudeGrd;
    }

    public function setVilleLongitudeGrd(?string $villeLongitudeGrd): self
    {
        $this->villeLongitudeGrd = $villeLongitudeGrd;

        return $this;
    }

    public function getVilleLatitudeGrd(): ?string
    {
        return $this->villeLatitudeGrd;
    }

    public function setVilleLatitudeGrd(?string $villeLatitudeGrd): self
    {
        $this->villeLatitudeGrd = $villeLatitudeGrd;

        return $this;
    }

    public function getVilleLongitudeDms(): ?string
    {
        return $this->villeLongitudeDms;
    }

    public function setVilleLongitudeDms(?string $villeLongitudeDms): self
    {
        $this->villeLongitudeDms = $villeLongitudeDms;

        return $this;
    }

    public function getVilleLatitudeDms(): ?string
    {
        return $this->villeLatitudeDms;
    }

    public function setVilleLatitudeDms(?string $villeLatitudeDms): self
    {
        $this->villeLatitudeDms = $villeLatitudeDms;

        return $this;
    }

    public function getVilleZmin(): ?int
    {
        return $this->villeZmin;
    }

    public function setVilleZmin(?int $villeZmin): self
    {
        $this->villeZmin = $villeZmin;

        return $this;
    }

    public function getVilleZmax(): ?int
    {
        return $this->villeZmax;
    }

    public function setVilleZmax(?int $villeZmax): self
    {
        $this->villeZmax = $villeZmax;

        return $this;
    }
}
