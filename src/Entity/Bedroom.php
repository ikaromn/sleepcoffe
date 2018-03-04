<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BedroomRepository")
 */
class Bedroom
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponible;

    /**
     * @ORM\Column(type="integer")
     */
    private $roomNumber;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {;
        $this->name = $name;
    }
    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return bool
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;
    }

    /**
     * @return int
     */
    public function getRoomNumber()
    {
        return $this->roomNumber;
    }

    public function setRoomNumber($roomNumber)
    {
        $this->roomNumber = $roomNumber;
    }
}
