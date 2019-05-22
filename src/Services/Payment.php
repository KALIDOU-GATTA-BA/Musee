<?php

namespace App\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class Payment
{
    private $request;
    private $mailer;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
