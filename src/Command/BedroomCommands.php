<?php

namespace App\Command;

use App\Entity\Bedroom;

class BedroomCommands
{
    private $bedroom;

    private $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public function createNewBedroom(Bedroom $bedroom)
    {
        $this->bedroom = $bedroom;
        $this->manager->persist($this->bedroom);
        $this->manager->flush();
    }

    /**
     * @param $roomNumber
     * @return mixed
     */
    public function getBedroom($roomNumber)
    {
        return $this->manager->getRepository(Bedroom::class)->findOneBy(
            ['roomNumber' => $roomNumber]
        );
    }

    /**
     * @return array
     */
    public function getBedroomList()
    {
        $bedroomsList = $this->manager->getRepository(Bedroom::class)->findAll();
        $bedroomArray = array();

        foreach ($bedroomsList as $bedroom) {
            $bedroomArray[] = [
                'id' => $bedroom->getId(),
                'name' => $bedroom->getName(),
                'price' => $bedroom->getPrice(),
                'capacity' => $bedroom->getCapacity(),
                'diponible' => $bedroom->getDisponible(),
                'roomNumber' => $bedroom->getRoomNumber(),
            ];
        }

        return $bedroomArray;
    }

    /**
     * @param Bedroom $bedroom
     */
    public function updateBedroom(Bedroom $bedroom)
    {
        $bedroomObject = $this->manager->getRepository(Bedroom::class)->find($bedroom->getId());
        $bedroomObject->setName($bedroom->getName());
        $bedroomObject->setPrice($bedroom->getPrice());
        $bedroomObject->setCapacity($bedroom->getCapacity());
        $bedroomObject->setDisponible($bedroom->getDisponible());
        $bedroomObject->setRoomNumber($bedroom->getRoomNumber());

        $this->manager->flush();
    }

    /**
     * @param $bedroomId
     */
    public function deleteBedroom($bedroomId)
    {
        $product = $this->manager->getRepository(Bedroom::class)->find($bedroomId);
        $this->manager->remove($product);
        $this->manager->flush();
    }
}