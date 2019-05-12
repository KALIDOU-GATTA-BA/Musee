<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ReservationProcess;
use App\Services\Payment;

class PrePaymentController extends AbstractController
{
    /**          
     * @Route("/pre_payment", name="pre_payment")
     */       
    public function index(Payment $p, \Swift_Mailer $mailer, ReservationProcess $rp){  
          if ($rp->getTotal()==0) {
              $p->freeEntrance();
              $mailer->send($p->sendEmail()[0]->setBody(
                                         $this->renderView(
                                            'emails/registration.html.twig',
                                            ['reservation_num' => 'CY98-42ML',
                                            'reservation_date'=>$p->sendEmail()[1],
                                            'reservation_cost'=>$rp->getTotal(),
                                            'reservation_names'=>$p->sendEmail()[2]]
                                        ),
                                        'text/html'
              ));
            return $this->redirectToRoute('payment');
          }
          return $this->render('pre_payment/pre_payment.html.twig', [
            'cost' => $rp->getTotal()
        ]);
    }
}                            