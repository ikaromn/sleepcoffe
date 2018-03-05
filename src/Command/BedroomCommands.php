<?php

namespace App\Command;

use App\Entity\Bedroom;

class BedroomCommands
{
    private $bedroom;

    public function createNewBedroom(Bedroom $bedroom, $entityManager)
    {
        $this->bedroom = $bedroom;
        $entityManager->persist($this->bedroom);
        $entityManager->flush();
    }

    /**
     * @param $repository
     * @param $roomNumber
     * @return mixed
     */
    public function getBedroom($repository, $roomNumber)
    {
        return $repository->findOneBy(
            ['roomNumber' => $roomNumber]
        );
    }

    /**
     * @param $repository
     * @return array
     */
    public function getBedroomList($repository)
    {
        $bedroomsList = $repository->findAll();
        $bedroomArray = array();
        $count = 0;

        foreach ($bedroomsList as $bedroom) {
            $bedroomArray[$count] = [
                'name' => $bedroom->getName(),
                'price' => $bedroom->getPrice(),
                'capacity' => $bedroom->getCapacity(),
                'diponible' => $bedroom->getDisponible(),
                'roomNumber' => $bedroom->getRoomNumber()
            ];

            $count++;
        }

        return $bedroomArray;
    }
}