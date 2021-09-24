<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomNewController extends AbstractController
{
    /**
     * @Route("/room/new", name="room_new")
     */
    public function index(): Response
    {
        return $this->render('room_new/index.html.twig', [
            'controller_name' => 'RoomNewController',
        ]);
    }
}
