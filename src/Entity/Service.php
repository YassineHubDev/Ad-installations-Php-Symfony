<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $isValidated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\client")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client_email;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\dispo")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dispo_iddispo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\magasin")
     * @ORM\JoinColumn(nullable=false)
     */
    private $magasin_nom;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?int
    {
        return $this->nom;
    }

    public function setNom(int $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIsValidated(): ?string
    {
        return $this->isValidated;
    }

    public function setIsValidated(?string $isValidated): self
    {
        $this->isValidated = $isValidated;

        return $this;
    }

    public function getClientEmail(): ?client
    {
        return $this->client_email;
    }

    public function setClientEmail(?client $client_email): self
    {
        $this->client_email = $client_email;

        return $this;
    }

    public function getDispoIddispo(): ?dispo
    {
        return $this->dispo_iddispo;
    }

    public function setDispoIddispo(?dispo $dispo_iddispo): self
    {
        $this->dispo_iddispo = $dispo_iddispo;

        return $this;
    }

    public function getMagasinNom(): ?magasin
    {
        return $this->magasin_nom;
    }

    public function setMagasinNom(?magasin $magasin_nom): self
    {
        $this->magasin_nom = $magasin_nom;

        return $this;
    }


}
