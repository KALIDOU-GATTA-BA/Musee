<?php
namespace App\Controller;
use App\Form\AddReservationType;
use App\Handlers\Form\AddReservationFormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddReservationController extends AbstractController
{
    /**
     * @var AddReservationFormHandler
     */
    private $formHandler;

    public function __construct(AddReservationFormHandler $formHandler)
    {
        $this->formHandler = $formHandler;
    }

    /**
     * @Route(path="/add/reservation", name="add_reservation")
     * @param Request $request
     * @return Response
     */
    public function addReservation(Request $request){

                    $form = $this->createForm(AddReservationType::class)->handleRequest($request);

                    if ($this->formHandler->handle($form)) {
                        return $this->redirectToRoute('list_reservations');
                    }

                return $this->render('reservation/add_reservation.html.twig', [
                    'form_add_reservation' => $form->createView(),    
                ]);
    }
}