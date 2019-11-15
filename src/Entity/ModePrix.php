<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModePrixRepository")
 */
class ModePrix
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article")      
     * @ORM\JoinColumn(name="prix_article_id_id",referencedColumnName="id",onDelete="SET NULL")
     */
    private $prixArticleId;

    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SousCategory")      
     * @ORM\JoinColumn(name="prix_sous_category_id_id", nullable=true, referencedColumnName="id",onDelete="SET NULL")
     */
    private $prixSousCategoryId;

    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixTitle;


    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $prixDescription;
    

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixImage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixGlobale;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixMoyen;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prixHautGamme;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $prixDateCrea;


    public function __construct()
    {
    
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrixArticleId(): ?Article
    {
        return $this->prixArticleId;
    }

    public function setPrixArticleId(?Article $prixArticleId): self
    {
        $this->prixArticleId = $prixArticleId;

        return $this;
    }


    
    public function getPrixSousCategoryId(): ?SousCategory
    {
        return $this->prixSousCategoryId;
    }

    public function setPrixSousCategoryId(?SousCategory $prixSousCategoryId): self
    {
        $this->prixSousCategoryId = $prixSousCategoryId;

        return $this;
    }




    public function getPrixTitle(): ?string
    {
        return $this->prixTitle;
    }

    public function setPrixTitle(?string $prixTitle): self
    {
        $this->prixTitle = $prixTitle;

        return $this;
    }

    public function getPrixDescription(): ?string
    {
        return $this->prixDescription;
    }

    public function setPrixDescription(?string $prixDescription): self
    {
        $this->prixDescription = $prixDescription;

        return $this;
    }

    public function getPrixImage(): ?string
    {
        return $this->prixImage;
    }

    public function setPrixImage(?string $prixImage): self
    {
        $this->prixImage = $prixImage;

        return $this;
    }

    
    public function getPrixGlobale(): ?string
    {
        return $this->prixGlobale;
    }

    public function setPrixGlobale(?string $prixGlobale): self
    {
        $this->prixGlobale = $prixGlobale;

        return $this;
    }
    
    public function getPrixMoyen(): ?string
    {
        return $this->prixMoyen;
    }

    public function setPrixMoyen(?string $prixMoyen): self
    {
        $this->prixMoyen = $prixMoyen;

        return $this;
    }

    public function getPrixHautGamme(): ?string
    {
        return $this->prixHautGamme;
    }

    public function setPrixHautGamme(?string $prixHautGamme): self
    {
        $this->prixHautGamme = $prixHautGamme;

        return $this;
    }

    


    public function getPrixDateCrea(): ?\DateTimeInterface
    {
        return $this->prixDateCrea;
    }

    public function setPrixDateCrea(?\DateTimeInterface $prixDateCrea): self
    {
        $this->prixDateCrea = $prixDateCrea;

        return $this;
    }

}
