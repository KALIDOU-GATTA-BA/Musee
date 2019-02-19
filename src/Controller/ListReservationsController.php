<?php
namespace App\Controller;
use App\Entity\Reservation;
use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class ListReservationsController extends AbstractController
{
    /**
     * @Route(path="add/reservation/{id}", name="list_reservations")
     */
    public function listReservationsController($id)
    {
       /* $entityManager = $this->getDoctrine()->getManager();
        $reservationRepository = $entityManager->getRepository(Reservation::class);
        $reservations = $reservationRepository->find($id);

        $ticketRepository = $entityManager->getRepository(Ticket::class);
        $tickets = $ticketRepository->find($id);

        $repo=$this ->getDoctrine()->getRepository(Ticket::class);
        $t= $repo->find($id);

        return $this->render('reservation/list_reservation.html.twig', [
           'reservations' => $reservations,
           'tickets' => $tickets
        ]);*/
        $ticketRepository=$this ->getDoctrine()->getRepository(Ticket::class);
        $tickets= $ticketRepository->find($id);

        $reservationRepository=$this->getDoctrine()->getRepository(Reservation::class);
        $reservations= $reservationRepository->find($id);

        return $this->render('reservation/list_reservation.html.twig', [
           'ticket' => $tickets,
           'reservation' => $reservations
            
        ]);
    }
}