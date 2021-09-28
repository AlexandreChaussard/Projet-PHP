<?php

namespace App\Controller;

use App\Entity\Region;
use App\Entity\Room;
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
     * @Route("/{roomid}", name="room_ad", requirements={ "roomid": "\d+"}, methods="GET")
     */
    public function showRoom(Room $room): Response
    {
        return $this->render('room/room_ad.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @Route("/filter/{regionid}", name="room_filtered", requirements={ "regionid": "\d+"}, methods="GET")
     */
    public function filteredRegion(Region $region): Response
    {
        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository(Room::class)->findBy(['region' => $region]);

        return $this->render('room/filter.html.twig', [
            'rooms' => $rooms,
        ]);
    }
}
