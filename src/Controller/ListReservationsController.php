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
        $session=$this->get('session');
        $reservation=$session->get('reservation');  
        $total=0;
        foreach ($reservation->getTickets() as $ticket ) {

                    $ticketType=$ticket->getTicketType();
                    $reducedPrice=$ticket->getReducedPrice();
                    $birthDate=$ticket->getBirthDate()->format('Y-m-d');
                    $curentDate = date("Y-m-d");
                    $yearOfBirth=$birthDate[0].$birthDate[1].$birthDate[2].$birthDate[3];
                    $yearOfCurentDate=$curentDate[0].$curentDate[1].$curentDate[2].$curentDate[3];
                    $age =(int)$yearOfCurentDate-(int)$yearOfBirth;  
                    
                    $cost=0 ;
                    if($age>=4 && $age<=12){
                        $cost=8;
                        $session=$this->get('session');
                        $session->set('cost', $cost);
                        $total=$total+$session->get('cost');
                    }
                    if($age>12 && $age<60){
                        $cost=16;
                        $session=$this->get('session');
                        $session->set('cost', $cost);
                        $total=$total+$session->get('cost');
                    }
                    if($age>=60){
                        $cost=12;
                        $session=$this->get('session');
                        $session->set('cost', $cost);
                        $total=$total+$session->get('cost');
                    }
                    if($reducedPrice && $age>12){
                        $cost=10;
                        $session=$this->get('session');
                        $session->set('cost', $cost);
                        $total=$total+$session->get('cost');
                    }   
        }                   
        $session->set('total', $total);       
        return $this->render('reservation/list_reservation.html.twig', [
           'reservation'=>$reservation,   
        ]);
    }
}