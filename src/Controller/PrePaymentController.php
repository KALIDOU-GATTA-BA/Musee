<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PrePaymentController extends AbstractController
{
    /**
     * @Route("/pre_payment", name="pre_payment")
     */    
    public function index()
    {    
        $res = $this->getDoctrine()
        ->getManager()
        ->createQuery('SELECT r FROM App\Entity\Reservation r ')
        ->getResult();
        $session=$this->get('session');
        $reservation=$session->get('reservation');  
        $chosenDay=$reservation->getVisitDate();
        $i=0;
       foreach ($res as $_res ) { 
          if($chosenDay->format('Y-m-d')==$_res->getVisitDate()->format('Y-m-d')){
              foreach ($reservation->getTickets() as $key ) {
                $i++;
              }
              $_res->setCount($_res->getCount()+$i);
              $nbr=$_res->getCount();
          
              if($nbr>1000){
                echo "La capacité du museéé ne peut pas dépasser 1000";
                return $this->redirectToRoute('home');
              }
          }    
       } 
          $total=$session->get('total');
          return $this->render('pre_payment/pre_payment.html.twig', [
            'cost' => $total
        ]);
    }
}