<?php
/**
 * Created by PhpStorm.
 * User: saysa
 * Date: 2019-05-15
 * Time: 22:28
 */

namespace App\Mailer;


use App\Services\Payment;
use App\Services\ReservationProcess;
use Twig\Environment;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $swiftMailer, Environment $twig)
    {
        $this->swiftMailer = $swiftMailer;
        $this->twig = $twig;
    }

    public function send(Payment $p, ReservationProcess $rp)
    {
        $this->swiftMailer->send(
            $p->sendEmail()[0]->setBody(
                $this->twig->render(
                    'emails/registration.html.twig',
                    ['reservation_num' => 'CY98-42ML',
                     'reservation_date'=>$p->sendEmail()[1],
                     'reservation_cost'=>$rp->getTotal(),
                     'reservation_names'=>$p->sendEmail()[2]]
                ),
                'text/html'
            )
        );
    }
}