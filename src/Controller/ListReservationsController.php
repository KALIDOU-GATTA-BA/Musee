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
       // $reservation=$session->get('tickets');      

        $ticketType=$reservation->getTicketType();
        $reducedPrice=$reservation->getReducedPrice();
        $birthDate=$reservation->getBirthDate()->format('Y-m-d');
        $curentDate = date("Y-m-d");
        $yearOfBirth=$birthDate[0].$birthDate[1].$birthDate[2].$birthDate[3];
        $yearOfCurentDate=$curentDate[0].$curentDate[1].$curentDate[2].$curentDate[3];
        $age =(int)$yearOfCurentDate-(int)$yearOfBirth;  

        $session_1=$this->get('session');
        $session_2=$this->get('session');
        $session_3=$this->get('session');
        $session_1->set('coste1', 0);
        $session_2->set('coste2', 0);
        $session_3->set('coste3', 0);

        if($age>=4 && $age<=12){
          $coste1=8;
          $session_1=$this->get('session');
          $session_1->set('coste1', $coste1);
          $totalCoste=$session_1->get('coste1')+$session_2->get('coste2')+$session_3->get('coste3');
        }
        elseif($age>12 && $age<60){
          if($reducedPrice){
            $session_2=$this->get('session');
            $session_2->set('coste2', 10);
            $totalCoste=$session_1->get('coste1')+$session_2->get('coste2')+$session_3->get('coste3');
          }else{ 
              $coste2=16;
              $session_2=$this->get('session');
              $session_2->set('coste2', $coste2);
              $totalCoste=$session_1->get('coste1')+$session_2->get('coste2')+$session_3->get('coste3');
            }
        }
        elseif ($age>=60) {   
            if($reducedPrice){
              $session_3=$this->get('session');
              $session_3->set('coste3', 10);
              $totalCoste=$session_1->get('coste1')+$session_2->get('coste2')+$session_3->get('coste3');
            }else{
                $coste3=12;
                $session_3=$this->get('session');
                $session_3->set('coste3', $coste3);
                $totalCoste=$session_1->get('coste1')+$session_2->get('coste2')+$session_3->get('coste3')+$session_4->get('coste4');
            }
          }
        else{
            $totalCoste=0;
        }
        
        $sessionTotalCoste=$this->get('session');
        $sessionTotalCoste->set('sessionTotalCoste', $totalCoste);
        
        $reservation=$session->get('reservation');
        return $this->render('reservation/list_reservation.html.twig', [
           'reservation'=>$reservation      
        ]);
    }
}