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
     // $reservation=$this->get('session')->get('reservations');
        $form = $this->createForm(AddReservationType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $reservation = $form->getData();  
                $session1=$this->get('session');
                $session1->set('reservation', $reservation);
                        foreach ($reservation->getTickets() as $ticket) {
                            $session2=$this->get('session');
                            $session2->set('tickets', $ticket);
                          //  $entityManager->persist($ticket);
                            }
                            
                     //   $entityManager->flush();                      
                        return $this->redirectToRoute('list_reservations');
        }               
        return $this->render('reservation/add_reservation.html.twig', [
            'form_add_reservation' => $form->createView(),    
        ]);
    }
}