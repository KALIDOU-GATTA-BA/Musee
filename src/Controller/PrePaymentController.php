<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;

class PrePaymentController extends AbstractController
{
    /**          
     * @Route("/pre_payment", name="pre_payment")
     */       
    public function index(ObjectManager $manager, \Swift_Mailer $mailer, Request $request)
    {  
          $session=$this->get('session');
          $total=$session->get('total');
          if ($total==0) {

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

             
              
              $reservation_num='CY98-42ML';
              $reservation->setCount($i);
              $manager->persist($reservation);
              $manager->flush();

              $session=$this->get('session');
              $reservation=$session->get('reservation');  
              $email=$reservation->getEmail();

              $message = (new \Swift_Message('Musée du Louvre'))
                ->setFrom('baniabina.ba@gmail.com')
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
            return $this->redirectToRoute('payment');
          }
          return $this->render('pre_payment/pre_payment.html.twig', [
            'cost' => $total
        ]);
    }
}                            