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
    public function checkPayment(Request $request, ObjectManager $manager)
    {
       
          // Set your secret key: remember to change this to your live secret key in production
       // See your keys here: https://dashboard.stripe.com/account/apikeys
    \Stripe\Stripe::setApiKey("sk_test_EgBGQdrRZj3PtAaMKLkm4uFV00i7r6061c");

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];

        $total=$this->get('session')->get('cost');

        $charge = \Stripe\Charge::create([
            'amount' => $total * 100,
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);

            $session=$this->get('session');
            $reservation=$session->get('reservation');  

            //Comment insérer les données de la réservation en base et comment mettre le payment à true ?

          /*  $manager->persist($reservation);
            $manager->flush();*/

            foreach ($reservation->getTickets() as $tickets) {
                $nom=$tickets->getName();
                $birthDate=$tickets->getBirthDate()->format('Y-m-d');
                $country=$tickets->getCountry();
                $ticketType=$tickets->getTicketType();
            };
            //$to = $reservation->getEmail();
            //'Email associé à la réservation:'.$reservation->getEmail().'<br>'.
            //'Date de la visite:'.$reservation->getVisitDate().'<br>'.
            $to='kalidougattaba@gmail.com';
            $subject = 'Musée du Louvre';
            $message = nl2br ("Madame, Monsieur,\nMerci d'avoir choisit le Musée du Louvre comme votre lieu de visite.\nVous trouverez ci-joint le récapitulatif de votre réservation faisant office de billet.\nIl est donc obligatoire de présenter ce mail pour pouvoir entrer au le Musée.\n
            Bonne visite.\n", false);
            //Les Tickets:".$nom.'\n'.$birthDate.'\n'.$country.'\n'.$ticketType"); 
            
            mail($to, $subject, $message);

        return $this->render('payment/payment.html.twig', [
            'total'=>$total
        ]);
    }
} 
