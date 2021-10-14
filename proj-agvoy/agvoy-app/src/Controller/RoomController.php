<?php

namespace App\Controller;

use App\Entity\OwnerWrapper;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\User;
use App\Form\RoomType;
use PhpParser\Node\Expr\Array_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controleur Room
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
        $filteredRooms = array();
        foreach($room->getRegions() as $region)
        {

            $filteredRoomsInRegion = $this->getRegionRooms($region, 6, $room);
            foreach($filteredRoomsInRegion as $relatedRoom)
            {
                if(count($filteredRooms) >= 6)
                    break;

                array_push($filteredRooms, $relatedRoom);
            }
        }

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getUsername()]);
        $owner = $user->getOwner();
        $ownerWrapper = new OwnerWrapper();
        $ownerWrapper->setOwnsRoom(in_array('ROLE_ADMIN', $user->getRoles()));

        if(!$ownerWrapper->isOwnsRoom() && $owner != null)
        {
            if($owner->getRooms()->contains($room))
            {
                $ownerWrapper->setOwnsRoom(true);
            }
        }

        return $this->render('room/room_ad.html.twig', [
            'room' => $room,
            'relatedRooms' => $filteredRooms,
            'ownerWrapper' => $ownerWrapper,
        ]);
    }

    /**
     * Ajoute au panier l'annonce donnée
     *
     * @Route("/shop/{id}", name="room_shop", requirements={ "id": "\d+"}, methods="GET")
     */
    public function shopRoom(Room $room): Response
    {
        $shop = $this->get('session')->get('shop');
        if( ! is_array($shop) )
        {
            $shop = array();
            array_push($shop, $room->getId());
        }
        else
        {
            if(in_array($room->getId(), $shop))
            {
                if (($key = array_search($room->getId(), $shop)) !== false) {
                    unset($shop[$key]);
                }
            }
            else
            {
                array_push($shop, $room->getId());
            }
        }

        $this->get('session')->set('shop', $shop);

        return $this->redirectToRoute('room_ad',
            ['id' => $room->getId()]);
    }

    /**
     * @Route("/new", name="room_new", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_OWNER')")
     */
    public function new(Request $request): Response
    {
        $room = new Room();

        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
        {
            $form = $this->createForm(RoomType::class, $room, ['chose_owner' => true]);
        }
        else
        {
            $form = $this->createForm(RoomType::class, $room, ['chose_owner' => false]);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if(!in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
            {
                $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $this->getUser()->getUsername()]);
                $room->setOwner($user->getOwner());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('room/new.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="room_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_OWNER')")
     */
    public function edit(Request $request, Room $room): Response
    {
        if($this->getUser()->getUsername() != $room->getOwner()->getUser()->getUsername())
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }

        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles()))
        {
            $form = $this->createForm(RoomType::class, $room, ['chose_owner' => true]);
        }
        else
        {
            $form = $this->createForm(RoomType::class, $room, ['chose_owner' => false]);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="room_delete", methods={"POST"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_OWNER')")
     */
    public function delete(Request $request, Room $room): Response
    {
        if($this->getUser()->getUsername() != $room->getOwner()->getUser()->getUsername())
        {
            $this->denyAccessUnlessGranted('ROLE_ADMIN');
        }
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirectToRoute('room_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/filter/{id}", name="room_filter", requirements={ "id": "\d+"}, methods="GET")
     */
    public function filteredRegion(Region $region): Response
    {
        $filteredRooms = $this->getRegionRooms($region, -1, new Room());

        return $this->render('room/filter.html.twig', [
            'rooms' => $filteredRooms,
            'region' => $region,
        ]);
    }

    /**
     * Récupère une liste de taille 'amount' de couettes et cafés dans la région donné hors 'except'
     * Si amount < 0 alors on récupère toutes les chambres de la région
     * @param Region $from
     * @param int $amount
     * @return array
     */
    private function getRegionRooms(Region $from, int $amount, Room $except)
    {
        $em = $this->getDoctrine()->getManager();

        $rooms = $em->getRepository(Room::class)->findAll();
        $filteredRooms = array();

        $i = 0;

        foreach($rooms as $room)
        {
            if($amount > 0 &&
                $i >= $amount)
                break;
            if($except != null &&
                $room->getId() == $except->getId())
                continue;

            $regions = $room->getRegions();
            foreach($regions as $reg)
            {
                if($from->getId() == $reg->getId())
                {
                    array_push($filteredRooms, $room);
                    $i = $i + 1;
                    break;
                }
            }
        }

        return $filteredRooms;
    }

}
