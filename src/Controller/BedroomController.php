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
     * @Route("/", name="sleepcoffe_homepage")
     */
    public function index()
    {
        $responseRender = new JsonResponse();

        return $responseRender->setData(
            [
                "Its working"
            ]
        );
    }

    /**
     * @Route("/bedroom", name="bedroom_create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createBedroom(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $requestContent = $request->getContent();
        $jsonResponse = New JsonResponse();
        $bedroomContext = json_decode($requestContent, true);

        try {
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
            $createBedroom = New BedroomCommands($manager);
            $createBedroom->createNewBedroom($bedroom);

            $jsonResponse->setStatusCode(204);
        } catch (\Exception $e) {
            $errorContent['summary'] = 'Could not create bedroom';
            $jsonResponse->setData($errorContent);
            $jsonResponse->setStatusCode(500);
        }

        return $jsonResponse;

    }

    /**
     * @Route("/bedroom/{roomNumber}", name="bedroom_item", methods={"GET"})
     * @param int $roomNumber
     * @return JsonResponse
     */
    public function getBedroom($roomNumber)
    {
        $manager = $this->getDoctrine()->getManager();
        $jsonResponse = New JsonResponse();

        $createBedroom = New BedroomCommands($manager);
        $bedroomObject = $createBedroom->getBedroom($roomNumber);

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

    /**
     * @Route("/bedroom/list/", name="bedroom_list", methods={"GET"})
     */
    public function listBedrooms()
    {
        $manager = $this->getDoctrine()->getManager();
        $jsonResponse = New JsonResponse();

        $bedroomCommand = New BedroomCommands($manager);
        $jsonResponse->setData($bedroomCommand->getBedroomList());
        return $jsonResponse;
    }

    /**
     * @Route("/bedroom/{bedroomId}", name="bedroom_update", methods={"PUT"})
     * @param Request $request
     * @param int $bedroomId
     * @return mixed
     */
    public function updateBedroom(Request $request, $bedroomId)
    {
        $manager = $this->getDoctrine()->getManager();
        $jsonResponse = New JsonResponse();
        $bedroomCommand = New BedroomCommands($manager);

        $requestContent = $request->getContent();
        $bedroomContext = json_decode($requestContent, true);

        $bedroomObject = $manager->getRepository(Bedroom::class)->find($bedroomId);
        $bedroomObject->setName($bedroomContext['name']);
        $bedroomObject->setPrice($bedroomContext['price']);
        $bedroomObject->setCapacity($bedroomContext['capacity']);
        $bedroomObject->setDisponible($bedroomContext['disponible']);
        $bedroomObject->setRoomNumber($bedroomContext['roomNumber']);

        $bedroomCommand->updateBedroom($bedroomObject);

        $jsonResponse->setData("Updated");
        return $jsonResponse;
    }

    /**
     * @Route("/bedroom/{bedroomId}", name="bedroom_delete", methods={"DELETE"})
     * @param Request $request
     * @param int $bedroomId
     * @return mixed
     */
    public function deleteBedroom(Request $request, $bedroomId)
    {
        $manager = $this->getDoctrine()->getManager();
        $jsonResponse = New JsonResponse();

        $bedroomCommand = New BedroomCommands($manager);

        try{
            $bedroomCommand->deleteBedroom($bedroomId);
            $jsonResponse->setStatusCode(204);
        } catch (\Exception $e) {
            $errorContent['summary'] = 'Bedroom not found';
            $errorContent['message'] = $e->getMessage();
            $jsonResponse->setData($errorContent);
            $jsonResponse->setStatusCode(422);

            return $jsonResponse;
        }

        return $jsonResponse;
    }
}
