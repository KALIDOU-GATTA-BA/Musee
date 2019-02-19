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
            // sauvegarde dans la base de donnée
            $reservation = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            foreach ($reservation->getTickets() as $ticket) {
                $entityManager->persist($ticket);
            }
            $entityManager->flush();
            return $this->redirectToRoute('list_reservations');
        }
        return $this->render('reservation/add_reservation.html.twig', [
            'form_add_reservation' => $form->createView(),
        ]);

    }

}