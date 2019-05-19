<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ReservationProcess;
use App\Services\Payment;
use App\Mailer\Mailer;

class PrePaymentController extends AbstractController
{
    private $mailer;
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    /**          
     * @Route("/pre_payment", name="pre_payment")
     */       
    public function index(Payment $p, \Swift_Mailer $mailer, ReservationProcess $rp){  
          if ($rp->getTotal()==0){
              $p->freeEntrance();
              $this->mailer->send($p, $rp); 
            return $this->redirectToRoute('payment');
          }
          return $this->render('pre_payment/pre_payment.html.twig', [
            'cost' => $rp->getTotal()
        ]);
    }
}                            