<?php

namespace App\Controller;

use App\Repository\OwnerRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 */
class GlobalController extends AbstractController
{
    /*
    **
    * @Route("/", name="index", methods={"GET"})
    */
    public function index(): Response
    {
        return $this->redirectToRoute('room_index', [], Response::HTTP_SEE_OTHER);
    }
}