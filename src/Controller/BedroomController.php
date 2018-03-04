<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Command\BedroomCommands;
use App\Entity\Bedroom;

class BedroomController extends Controller
{
    /**
     * @Route("/bedroom", name="bedroom")
     * @param Request $request
     * @return JsonResponse
     */
    public function createBedroom(Request $request)
    {
        try {

            $requestContent = $request->getContent();
            $jsonResponse = New JsonResponse();
            $bedroomContext = json_decode($requestContent, true);
            $entityManager = $this->getDoctrine()->getManager();

            $bedroom = New Bedroom();
            $bedroom->setName($bedroomContext['name']);
            $bedroom->setPrice($bedroomContext['price']);
            $bedroom->setCapacity($bedroomContext['capacity']);
            $bedroom->setDisponible($bedroomContext['disponible']);
            $bedroom->setRoomNumber($bedroomContext['roomNumber']);
        } catch (\Exception $e) {
            $errorContent['summary'] = 'Invalid data';

            $jsonResponse->setData($errorContent);
            $jsonResponse->setStatusCode(422);
            return $jsonResponse;
        }

        try {
            $createBedroom = New BedroomCommands();
            $createBedroom->createNewBedroom($bedroom, $entityManager);

            $jsonResponse->setStatusCode(204);
        } catch (\Exception $e) {
            $errorContent['summary'] = 'Could not create bedroom';
            $jsonResponse->setData($errorContent);
            $jsonResponse->setStatusCode(500);
        }

        return $jsonResponse;

    }

    /**
     * @Route("/bedroom/{roomNumber}", name="bedroom")
     * @param int $roomNumber
     * @return JsonResponse
     */
    public function getBedroom($roomNumber)
    {
        $jsonResponse = New JsonResponse();
        $repository = $this->getDoctrine()->getRepository(Bedroom::class);

        $createBedroom = New BedroomCommands();
        $bedroomObject = $createBedroom->getBedroom($repository, $roomNumber);

        if (!isset($bedroomObject)) {
            $errorContent['summary'] = 'Bedroom number invalid';

            $jsonResponse->setData($errorContent);
            $jsonResponse->setStatusCode(404);

            return $jsonResponse;
        }

        $bedroomData['name'] = $bedroomObject->getName();
        $bedroomData['price'] = $bedroomObject->getPrice();
        $bedroomData['capacity'] = $bedroomObject->getCapacity();
        $bedroomData['disponible'] = $bedroomObject->getDisponible();
        $bedroomData['roomNumber'] = $bedroomObject->getRoomNumber();

        $jsonResponse->setData($bedroomData);

        return $jsonResponse;
    }
}
