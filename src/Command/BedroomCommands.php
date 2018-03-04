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

    public function getBedroom($repository, $roomNumber)
    {
        return $repository->findOneBy(
            ['roomNumber' => $roomNumber]
        );
    }
}