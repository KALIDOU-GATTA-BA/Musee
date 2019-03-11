<?php
namespace App\Controller;
use App\Entity\Reservation;
use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class ListReservationsController extends AbstractController
{
    /**
     * @Route(path="add/reservation", name="list_reservations")
     */
    public function listReservationsController()
    {

       // $reservationRepository=$this->getDoctrine()->getRepository(Reservation::class);
        //$reservations= $reservationRepository->find($resa_id);
       // $ticketRepository=$this ->getDoctrine()->getRepository(Ticket::class);
        //$tickets= $ticketRepository->find($ticket_id);
        $tickets=2;
       // $session=$this->get('session');
       // $tickets=$session->get('tickets');
        return $this->render('reservation/list_reservation.html.twig', [
           'tickets'=>$tickets
        ]);
    }
}