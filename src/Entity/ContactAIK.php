<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactAIKRepository")
 */
class ContactAIK
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="text")
     */
    private $generalDescri;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $twitter;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $linkedin;

    /**
     * @ORM\Column(type="text")
     */
    private $sellDescri;

    /**
     * @ORM\Column(type="text")
     */
    private $gestionDescri;

    /**
     * @ORM\Column(type="text")
     */
    private $contratDescri;

    /**
     * @ORM\Column(type="text")
     */
    private $consultDescri;

    /**
     * @ORM\Column(type="float")
     */
    private $lat;

    /**
     * @ORM\Column(type="float")
     */
    private $lng;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getGeneralDescri(): ?string
    {
        return $this->generalDescri;
    }

    public function setGeneralDescri(string $generalDescri): self
    {
        $this->generalDescri = $generalDescri;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getSellDescri(): ?string
    {
        return $this->sellDescri;
    }

    public function setSellDescri(string $sellDescri): self
    {
        $this->sellDescri = $sellDescri;

        return $this;
    }

    public function getGestionDescri(): ?string
    {
        return $this->gestionDescri;
    }

    public function setGestionDescri(string $gestionDescri): self
    {
        $this->gestionDescri = $gestionDescri;

        return $this;
    }

    public function getContratDescri(): ?string
    {
        return $this->contratDescri;
    }

    public function setContratDescri(string $contratDescri): self
    {
        $this->contratDescri = $contratDescri;

        return $this;
    }

    public function getConsultDescri(): ?string
    {
        return $this->consultDescri;
    }

    public function setConsultDescri(string $consultDescri): self
    {
        $this->consultDescri = $consultDescri;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }
}
