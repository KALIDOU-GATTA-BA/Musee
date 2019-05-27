<?php

namespace App\Services;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class Payment
{
    private $request;
    private $mailer;

    public function __construct(ObjectManager $entityManager, ReservationProcess $t)
    {
        $this->entityManager = $entityManager;
        $this->t=$t->getSessionReservation();
    }

    public function checkDateAvailabilityB4payment()
    {
        $res = $this->entityManager->createQuery('SELECT r FROM App\Entity\Reservation r ')->getResult();
        $chosenDay=$this->t->getVisitDate();
        $buffer=1;
        $i=0;
        foreach ($res as $_res) {
            if ($chosenDay->format('Y-m-d') == $_res->getVisitDate()->format('Y-m-d')) {
                foreach ($this->t->getTickets() as $key) {
                    ++$i;
                }
                $_res->setCount($_res->getCount() + $i);
                if ($_res->getCount() > 3) {
                    $buffer=0;
                }
            }
        }
        return $buffer;
    }

    public function checkPayment()
    {
        \Stripe\Stripe::setApiKey('sk_test_EgBGQdrRZj3PtAaMKLkm4uFV00i7r6061c');
        $request = new Request(
            $_GET,
            $_POST
                    );
        $token = $request->request->get('stripeToken');
        $buffer = 0;
        $reservation_num = null;
        $rp = new ReservationProcess();
        if (0 != $rp->getTotal()) {
            $charge = \Stripe\Charge::create([
            'amount' => $rp->getTotal() * 100,
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);

            $reservation_num = $charge['id'];
            $reservation = $rp->getSessionReservation();

            if ('succeeded' == $charge['status']) {
                $reservation->setPayment(true);
                $i = 0;
                foreach ($reservation->getTickets() as $ticket) {
                    $nom = $ticket->getName();
                    $birthDate = $ticket->getBirthDate()->format('Y-m-d');
                    $country = $ticket->getCountry();
                    $ticketType = $ticket->getTicketType();
                    ++$i;
                }
                $reservation->setCount($i);
                $this->entityManager->persist($reservation);
                $this->entityManager->flush();
                $buffer = 1;
            } else {
                $reservation->setPayment(false);
                $buffer = -1;
            }
        }

        return [$buffer, $reservation_num];
    }

    public function freeEntrance()
    {
        $rp = new ReservationProcess();
        $reservation = $rp->getSessionReservation();
        $i = 0;
        foreach ($reservation->getTickets() as $ticket) {
            ++$i;
        }
        $reservation->setPayment(true);
        $reservation->setCount($i);
        $this->entityManager->persist($reservation);
        $this->entityManager->flush();
    }

    public function sendEmail()
    {
        $rp = new ReservationProcess();
        $reservation = $rp->getSessionReservation();
        $i = 0;
        $j = [];
        foreach ($reservation->getTickets() as $ticket) {
            $nom = $ticket->getName();
            ++$i;
            $j[$i] = $nom;
        }
        $reservation_date = $reservation->getVisitDate();
        $email = $reservation->getEmail();
        $message = (new \Swift_Message('Musée du Louvre'))
                ->setFrom('baniabina.ba@gmail.com');

        return [$message->setTo($email), $reservation_date, $j];
    }
}