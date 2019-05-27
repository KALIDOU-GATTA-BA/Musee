<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ReservationProcess;
use App\Services\Payment;

class PaymentController extends AbstractController
{
    /**
     * @Route("payment", name="payment")
     */
    public function index(Payment $p, \Swift_Mailer $mailer, ReservationProcess $rp)
    {
        if( $p->checkDateAvailabilityB4payment()==0) {
            return $this->redirectToRoute('home');
            
            exit();
        }
        $arrayCheckPayment = $p->checkPayment();
        if (-1 == $arrayCheckPayment[0]) {
            return $this->redirectToRoute('payment_error');
        } else {
            $mailer->send(
                $p->sendEmail()[0]->setBody(
                    $this->renderView(
                  'emails/registration.html.twig',
                  ['reservation_num' => $arrayCheckPayment[1],
                                        'reservation_date' => $p->sendEmail()[1],
                                        'reservation_cost' => $rp->getTotal(),
                                        'reservation_names' => $p->sendEmail()[2], ]
                                    ),
                    'text/html'
          )
            );
        }

        return $this->render('payment/payment.html.twig', [
                    'total' => $rp->getTotal(),
                ]);
    }
}
