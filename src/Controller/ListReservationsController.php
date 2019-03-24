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
        $reservation=$session->get('tickets');      

        $ticketType=$reservation->getTicketType();
        $reducedPrice=$reservation->getReducedPrice();
        $birthDate=$reservation->getBirthDate()->format('Y-m-d');
        $curentDate = date("Y-m-d");
        $yearOfBirth=$birthDate[0].$birthDate[1].$birthDate[2].$birthDate[3];
        $yearOfCurentDate=$curentDate[0].$curentDate[1].$curentDate[2].$curentDate[3];
        $age =(int)$yearOfCurentDate-(int)$yearOfBirth;

        if($age>=4 && $age<=12){
          $coste1=8;
          $session_1=$this->get('session');
          $session_1->set('coste1', $coste1);
        }
        elseif($age>12 && $age<60){
          $coste2=16;
          $session_2=$this->get('session');
          $session_2->set('coste2', $coste2);
        }
        elseif ($age>=60) {
          $coste3=12;
          $session_3=$this->get('session');
          $session_3->set('coste3', $coste3);
        }
        elseif ($reducedPrice) {
          $session_4=$this->get('session');
          $session_4->set('coste4', $coste4);
        }
        else{
          $session_1=$this->get('session');
          $session_1->set('coste1', 0);
          $session_2=$this->get('session');
          $session_2->set('coste2', 0);
          $session_3=$this->get('session');
          $session_3->set('coste3', 0);
          $session_4=$this->get('session');
          $session_4->set('coste4', 0);
        }
        $session_1=$this->get('session');
        $session_2=$this->get('session');
        $session_3=$this->get('session');
        $session_4=$this->get('session');

        $totalCoste=$session_1->get('coste1')+$session_2->get('coste2')+$session_3->get('coste3')+$session_4->get('coste4');
        
        $sessionTotalCoste=$this->get('session');
        $sessionTotalCoste->set('sessionTotalCoste', $totalCoste);
        
        $reservation=$session->get('reservation');
        return $this->render('reservation/list_reservation.html.twig', [
           'reservation'=>$reservation      
        ]);
    }
}