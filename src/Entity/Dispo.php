<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DispoRepository")
 */
class Dispo
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
    private $id_dispo;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $jour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdDispo(): ?int
    {
        return $this->id_dispo;
    }

    public function setIdDispo(int $id_dispo): self
    {
        $this->id_dispo = $id_dispo;

        return $this;
    }

    public function getJour(): ?\DateTimeInterface
    {
        return $this->jour;
    }

    public function setJour(?\DateTimeInterface $jour): self
    {
        $this->jour = $jour;

        return $this;
    }
}
