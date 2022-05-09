<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class PropertySearch {


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
     * @var string|null
     */
    private $situationS;

    /**
     * @var string|null
     */
    private $titleS;

     /**
     * @var string|null
     */
    private $typeS;

     /**
     * @var string|null
     */
    private $stateS; 

     /**
     * @var int|null
     * 
     * @Assert\PositiveOrZero
     */
    private $minSpace;

     /**
     * @var int|null
     */
    private $propertyId;

     /**
     * @var int|null
     * 
     * @Assert\PositiveOrZero
     */
    private $minRooms;

     /**
     * @var float|null
     * 
     * @Assert\PositiveOrZero
     */
    private $minPrice;

     /**
     * @var int|null
     * 
     * @Assert\PositiveOrZero
     */
    private $minBedrooms;

    /**
     * @var float|null
     * 
     * @Assert\PositiveOrZero
     */
    private $maxPrice;


    /**
     * @var float|null
     */
    private $lat;

    /**
     * @var float|null
     */
    private $lng;

    
    /**
     * @var int|null
     */
    private $distance;


    public function getMinSpace(): ?int
    {
        return $this->minSpace;
    }                                           

    public function setMinSpace(int $minSpace): self
    {
        $this->minSpace = $minSpace;

        return $this;
    }

    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }                                           

    public function setPropertyId(int $propertyId): self
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    public function getMinRooms(): ?int
    {
        return $this->minRooms;
    }                                           

    public function setMinRooms(int $minRooms): self
    {
        $this->minRooms = $minRooms;

        return $this;
    }

    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }                                           

    public function setMaxPrice(float $maxPrice): self
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }


    public function getMinBedrooms(): ?int
    {
        return $this->minBedrooms;
    }                                           

    public function setMinBedrooms(int $minBedrooms): self
    {
        $this->minBedrooms = $minBedrooms;

        return $this;
    }

    public function getSituationS(): ?string
    {
        return $this->situationS;
    }                                           

    public function setSituationS(string $situationS): self
    {
        $this->situationS = $situationS;

        return $this;
    }

    public function getStateS(): ?string
    {
        return $this->stateS;
    }                                           

    public function setStateS(string $stateS): self
    {
        $this->stateS = $stateS;

        return $this;
    }

    public function getTypeS(): ?string
    {
        return $this->typeS;
    }                                           

    public function setTypeS(string $typeS): self
    {
        $this->typeS = $typeS;

        return $this;
    }

    public function getTitleS(): ?string
    {
        return $this->titleS;
    }                                           

    public function setTitleS(string $titleS): self
    {
        $this->titleS = $titleS;

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

    public function getDistance(): ?int
    {
        return $this->distance;
    }                                           

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }


}