<?php
namespace App\Controller;
use App\Services\ReservationProcess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class ListReservationsController extends AbstractController
{
    /**
     * @Route(path="recapitulation", name="list_reservations")
     */
    public function listReservationsController(ReservationProcess $rp){
        $rp->totalCost();
        return $this->render('reservation/list_reservation.html.twig', [
           'reservation'=>$rp->getSessionReservation()   
        ]);
    }
}