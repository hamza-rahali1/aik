<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 * @UniqueEntity(
 *   fields={"title"},
 *   message="An other property is already registred with this title, please choose an other title.")
 */
class Property
{

    const SITUATION = 
    [
        1 => 'VENTA',
        2 => 'RENTA',
        3 => 'VENDIDO',
    ];

    const TYPE = 
    [
        1 => 'DEPARTAMENTOS',
        2 => 'CASA',
        3 => 'CASA DE DESCANSO',
        4 => 'TERRENO',
        5 => 'LOFT',
        6 => 'OFICINAS',
        7 => 'BODEGAS', 
        8 => 'LUXURY / RESIDENCIAL', 
        9 => 'OTROS'
    ];

    const STATES =
    [
        0 => 'México',
        1 => 'Mexico City',
        2 => 'Oaxaca',
        3 => 'Puebla',
        4 => 'Michoacán',
        5 => 'San Luis Potosí',
        6 => 'Veracruz',
        7 =>'Yucatán',
        8 =>'Jalisco',
        9 =>'Zacatecas',
        10 =>'Querétaro',
        11 =>'Sonora',
        12 =>'Tabasco',
        13 =>'Tamaulipas',
        14 =>'Nuevo León',
        15 =>'Guanajuato',
        16 =>'Coahuila',
        17 =>'Durango',
        18 =>'Chihuahua',
        19 =>'Chiapas',
        20 =>'Sinaloa',
        21 =>'Guerrero',
        22 =>'Tlaxcala',
        23 =>'Colima',
        24 =>'Aguascalientes',
        25 =>'Campeche',
        26 =>'Hidalgo',
        27 =>'Nayarit',
        28 =>'Baja California',
        29 =>'Quintana Roo',
        30 =>'Baja California Sur',
        31 =>'Morelos',

    ];




    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $rooms;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\PositiveOrZero
     *
     * @Assert\LessThanOrEqual(propertyPath="rooms", message="Bedrooms number should be less than the rooms number!")
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\PositiveOrZero
     * 
     * @Assert\LessThanOrEqual(propertyPath="rooms", message="Bathrooms number should be less than the rooms number!")
     */
    private $bathrooms;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\PositiveOrZero
     */
    private $parking;

    /**
     * @ORM\Column(type="float")
     * 
     * @Assert\PositiveOrZero
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\PositiveOrZero
     */
    private $space;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cooling;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $heating;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $situation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="integer")
     * 
     * @Assert\PositiveOrZero
     */
    private $floors;

    /**
     * @ORM\Column(type="float", scale=4 ,precision=6)
     */
    private $lat;

    /**
     * @ORM\Column(type="float", scale=4 ,precision=7)
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255 ,nullable=true)
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Images", mappedBy="Property", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="favories")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="property")
     */
    private $applications;


    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->images = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getSlug(): ?string 
    {
        return  (new slugify()) ->slugify($this->title);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getBathrooms(): ?int
    {
        return $this->bathrooms;
    }

    public function setBathrooms(int $bathrooms): self
    {
        $this->bathrooms = $bathrooms;

        return $this;
    }

    public function getParking(): ?int
    {
        return $this->parking;
    }

    public function setParking(int $parking): self
    {
        $this->parking = $parking;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getFormattedPrice(): ?string
    {
        return number_format($this->price, 0,'',' ');
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

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

    public function getSpace(): ?int
    {
        return $this->space;
    }

    public function setSpace(int $space): self
    {
        $this->space = $space;

        return $this;
    }

    public function getCooling(): ?string
    {
        return $this->cooling;
    }

    public function setCooling(string $cooling): self
    {
        $this->cooling = $cooling;

        return $this;
    }

    public function getHeating(): ?string
    {
        return $this->heating;
    }

    public function setHeating(string $heating): self
    {
        $this->heating = $heating;

        return $this;
    }

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation(string $situation): self
    {
        $this->situation = $situation;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getFloors(): ?int
    {
        return $this->floors;
    }

    public function setFloors(int $floors): self
    {
        $this->floors = $floors;

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

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProperty($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getProperty() === $this) {
                $image->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addFavory($this);
        }

        return $this;
    }

    public function removeClient(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeFavory($this);
        }

        return $this;
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setProperty($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getProperty() === $this) {
                $application->setProperty(null);
            }
        }

        return $this;
    }
}