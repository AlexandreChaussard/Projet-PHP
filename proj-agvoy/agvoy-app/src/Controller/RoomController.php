<?php

namespace App\Controller;

use App\Entity\Region;
use App\Entity\Room;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur Todo
 * @Route("/room")
 */
class RoomController extends AbstractController
{
    /**
     * @Route("/", name="room_index")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository(Room::class)->findAll();

        return $this->render('room/index.html.twig', [
            'rooms' => $rooms,
        ]);
    }

    /**
     * @Route("/{id}", name="room_ad", requirements={ "id": "\d+"}, methods="GET")
     */
    public function showRoom(Room $room): Response
    {
        return $this->render('room/room_ad.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("/filter/{id}", name="room_filtered", requirements={ "id": "\d+"}, methods="GET")
     */
    public function filteredRegion(Region $region): Response
    {
        $em = $this->getDoctrine()->getManager();
        // TODO: Demander si on peut pas faire que en SQL
        //$rooms = $em->getRepository(Room::class)->findBy(['regions' => $region]);

        $rooms = $em->getRepository(Room::class)->findAll();
        $filteredRooms = array();
        foreach($rooms as $room)
        {
            $regions = $room->getRegions();
            foreach($regions as $reg)
            {
                if($region->getId() == $reg->getId())
                {
                    array_push($filteredRooms, $room);
                    break;
                }
            }
        }

        return $this->render('room/filter.html.twig', [
            'rooms' => $filteredRooms,
            'region' => $region,
        ]);
    }
}
