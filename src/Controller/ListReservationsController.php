<?php
namespace App\Controller;
use App\Entity\Reservation;
use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class ListReservationsController extends AbstractController
{
    /**
     * @Route(path="add/reservation/{resa_id}&{ticket_id}", name="list_reservations")
     */
    public function listReservationsController($resa_id, $ticket_id)
    {

        $reservationRepository=$this->getDoctrine()->getRepository(Reservation::class);
        $reservations= $reservationRepository->find($resa_id);
        $ticketRepository=$this ->getDoctrine()->getRepository(Ticket::class);
        $tickets= $ticketRepository->find($ticket_id);
        return $this->render('reservation/list_reservation.html.twig', [
           'ticket' => $tickets,
           'reservation' => $reservations,
        ]);
    }
}