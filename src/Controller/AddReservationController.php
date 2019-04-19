<?php
//pw: TrTr@d_22_06_1984_FTS -- 53196x67x202 root
namespace App\Controller;
use App\Form\AddReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\Entity\Ticket;
use App\Entity\Reservation;
use Doctrine\Common\Persistence\ObjectManager;


class AddReservationController extends AbstractController
{
    /**
     * @Route(path="/add/reservation", name="add_reservation")
     * @param Request $request
     *
     * @return Response
     */
    
    public function addReservation(Request $request, ObjectManager $entityManager)
    {  

        /*$query = $entityManager->createQuery(
                'SELECT count
                 FROM App\Entity\Reservation count
                '
        );
        $query->execute();  
        $nbResaValid = $query->getResult();*/

        $repo = $this->getDoctrine()->getRepository(Reservation::class);
        $articles = $repo ->find('count') ;
        dd($articles);

    
        if (231==231) {
                    $form = $this->createForm(AddReservationType::class)->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                        $reservation = $form->getData();  
                        $session1=$this->get('session');
                        $session1->set('reservation', $reservation);
                        return $this->redirectToRoute('list_reservations');
                }               
                return $this->render('reservation/add_reservation.html.twig', [
                    'form_add_reservation' => $form->createView(),    
                ]);
        }
        else{
                echo "Le Musée est complet !";
                return $this->redirectToRoute('home');

        }
        
    }
}