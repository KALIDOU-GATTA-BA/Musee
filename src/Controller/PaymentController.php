<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;


class PaymentController extends AbstractController
{
    /**
     * @Route("payment", name="payment")
     */
    public function checkPayment(Request $request, ObjectManager $manager, \Swift_Mailer $mailer)
    {
       
    \Stripe\Stripe::setApiKey("sk_test_EgBGQdrRZj3PtAaMKLkm4uFV00i7r6061c");

        $token = $_POST['stripeToken'];

        $total=$this->get('session')->get('total');

        $charge = \Stripe\Charge::create([
            'amount' => $total * 100,
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);

            $session=$this->get('session');
            $reservation=$session->get('reservation');  
            $reservation->setPayment(true);

            $manager->persist($reservation);
            $manager->flush();

            foreach ($reservation->getTickets() as $tickets) {
                $nom=$tickets->getName();
                $birthDate=$tickets->getBirthDate()->format('Y-m-d');
                $country=$tickets->getCountry();
                $ticketType=$tickets->getTicketType();
            };

            
            
            $name ="ZhangGatta";

             $message = (new \Swift_Message('Hello Email'))
                ->setFrom('kalidougattaba@gmail.com')
                ->setTo('kalidougattaba@gmail.com')
                ->setBody(
                    $this->renderView(
                        'emails/registration.html.twig',
                        ['name' => $name]
                    ),
                    'text/html'
                );
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'emails/registration.txt.twig',
                ['name' => $name]
            ),
            'text/plain'
        )
        */
    

            $mailer->send($message);

                return $this->render('payment/payment.html.twig', [
                    'total'=>$total
                ]);
            }
} 
