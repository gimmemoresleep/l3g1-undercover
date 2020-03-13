<?php

/**
 * Création de l'entité afin de générer le formulaire
 * @author CHABOUR Lina ij00898
 * date 12-03-2020
 * @version 1.0
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SaisirAdresseRepository")
 */
class SaisirAdresse
{


    // Création des attributs 


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $temps;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $transport;



    //Génération des getters et setter pour chaque attribut


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTemps(): ?string
    {
        return $this->temps;
    }

    public function setTemps(string $temps): self
    {
        $this->temps = $temps;

        return $this;
    }

    public function getTransport(): ?string
    {
        return $this->transport;
    }

    public function setTransport(string $transport): self
    {
        $this->transport = $transport;

        return $this;
    }
}
