<?php
namespace App\Controller;
use App\Form\AddReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AddReservationController extends AbstractController
{
    /**
     * @Route(path="/add/reservation", name="add_reservation")
     * @param Request $request
     *
     * @return Response
     */
    public function addReservation(Request $request)
    {      
        $form = $this->createForm(AddReservationType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $reservation = $form->getData();
                foreach ($reservation->getTickets() as $ticket) {
                    $ticketType=$ticket->getTicketType();                 
                }       
                $visitDay = $reservation->getVisitDate();
                $visitDay = $visitDay->format('Y-m-d');
                $_visitDay = $reservation->getVisitDate();
                $_visitDay = $_visitDay->format('D');
                $_visitDay_ = $reservation->getVisitDate();
                $_visitDay_ = $_visitDay_->format('Y-m-d');
                $_0501 = $_visitDay_[5] .$_visitDay_[6] .$_visitDay_[8] .$_visitDay_[9];
                $curentDate = date("Y-m-d");
                if (($visitDay == $curentDate)&&($ticketType=='Billet journée')){
                    $curentHour = date("H");
                    $curentHour = $curentHour[0] .$curentHour[1];
                    if ((int)$curentHour >= 14 ){
                            echo("Il n'est pas possible de réserver un billet journée après 14 h");
                    }
                    else {
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($reservation);
                        foreach ($reservation->getTickets() as $ticket) {
                            $entityManager->persist($ticket);
                        }
                        $entityManager->flush();
                        return $this->redirectToRoute('list_reservations', [
                    
                        'ticket_id'=> $ticket->getId(),
                        'resa_id' => $reservation->getId()
                        ]);
                    }
                }
                elseif (($_visitDay=='Tue')||($_visitDay=='Sun') || ($_0501=='0501') ) {
                    echo('visite impossible pour les mardis, dimanche et, les 1er mai');
                } 
                else{
                    $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($reservation);
                        foreach ($reservation->getTickets() as $ticket) {
                            $entityManager->persist($ticket);
                        }
                        $entityManager->flush();
                        return $this->redirectToRoute('list_reservations', [
                        
                        'ticket_id'=> $ticket->getId(),
                        'resa_id' => $reservation->getId()
                        ]);
                }               
        }
        return $this->render('reservation/add_reservation.html.twig', [
            'form_add_reservation' => $form->createView(),
        ]);
    }
}