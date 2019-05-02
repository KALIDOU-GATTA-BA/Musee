<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Ticket;

class PaymentController extends AbstractController
{
    /**
     * @Route("payment", name="payment")
     */
    public function checkPayment(Request $request, ObjectManager $manager, ObjectManager $entityManager, \Swift_Mailer $mailer)
    {    
      \Stripe\Stripe::setApiKey("sk_test_EgBGQdrRZj3PtAaMKLkm4uFV00i7r6061c");

        $token=$request->request->get('stripeToken');
    
        $total=$this->get('session')->get('total');
  
        $charge = \Stripe\Charge::create([
            'amount' => $total * 100,
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);

        $reservation_num=$charge['id'];
       
        if($charge['status']=='succeeded'){ 
              $session=$this->get('session');

              $reservation=$session->get('reservation'); 
              
              $reservation->setPayment(true);
              $reservation_date=$reservation->getVisitDate();
              
              $i=0;
              $j=array();
              foreach ($reservation->getTickets() as $tickets) {
                  $nom=$tickets->getName();
                  $birthDate=$tickets->getBirthDate()->format('Y-m-d');
                  $country=$tickets->getCountry();
                  $ticketType=$tickets->getTicketType();
                  $i++;
                  $j[$i]=$nom;
              };

              $reservation->setCount($i);
              $manager->persist($reservation);
              $manager->flush();

              $session=$this->get('session');
              $reservation=$session->get('reservation');  
              $email=$reservation->getEmail();
              $message = (new \Swift_Message('Hello Email'))
                ->setFrom('johanneskep824@gmail.com')
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'emails/registration.html.twig',
                        ['reservation_num' => $reservation_num,
                        'reservation_date'=>$reservation_date,
                        'reservation_cost'=>$total,
                        'reservation_names'=>$j]
                    ),
                    'text/html'
          );
                                                              
            $mailer->send($message);
        }
          
        else{
            $session=$this->get('session');
            $reservation=$session->get('reservation');  
            $reservation->setPayment(false); 
            return $this->redirectToRoute('payment_error');        
        }


                return $this->render('payment/payment.html.twig', [
                    'total'=>$total
                ]);
    }
} 