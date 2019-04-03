<?php
namespace App\Controller;
use App\Entity\Reservation;
use App\Entity\Ticket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class ListReservationsController extends AbstractController
{
    /**
     * @Route(path="recapitulation", name="list_reservations")
     */
    public function listReservationsController()
    {
       // $reservationRepository=$this->getDoctrine()->getRepository(Reservation::class);
        //$reservations= $reservationRepository->find($resa_id);
       // $ticketRepository=$this ->getDoctrine()->getRepository(Ticket::class);
        //$tickets= $ticketRepository->find($ticket_id);
      //  $tickets=2;
        $session=$this->get('session');
        $reservation=$session->get('reservation');  
        foreach ($reservation->getTickets() as $tickets ) {

                    $ticketType=$tickets->getTicketType();
                    $reducedPrice=$tickets->getReducedPrice();
                    $birthDate=$tickets->getBirthDate()->format('Y-m-d');
                    $curentDate = date("Y-m-d");
                    $yearOfBirth=$birthDate[0].$birthDate[1].$birthDate[2].$birthDate[3];
                    $yearOfCurentDate=$curentDate[0].$curentDate[1].$curentDate[2].$curentDate[3];
                    $age =(int)$yearOfCurentDate-(int)$yearOfBirth;  
                    $cost=0;
                
                    if($age>=4 && $age<=12){
                        $cost=8;
                        $session=$this->get('session');
                        $session->set('cost', $cost);
                        $total=$session->get('cost');
                    }
                    if($age>12 && $age<60){
                        $cost=16;
                        $session=$this->get('session');
                        $session->set('cost', $cost);
                        $total=$session->get('cost');
                    }
                    if($age>=60){
                        $cost=12;
                        $session=$this->get('session');
                        $session->set('cost', $cost);
                        $total=$session->get('cost');
                    }
                    if($reducedPrice){
                        $cost=10;
                        $session=$this->get('session');
                        $session->set('cost', $cost);
                        $total=$session->get('cost');
                    }   
        }             
        
        return $this->render('reservation/list_reservation.html.twig', [
           'reservation'=>$reservation,   
        ]);
    }
}