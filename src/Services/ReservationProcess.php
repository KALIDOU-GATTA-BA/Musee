<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Session\Session;

class ReservationProcess
{
    private $cost;
    private $total;

    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setTotal($total)
    {
        $session = new Session();

        return $session->set('total', $total);
    }

    public function getTotal()
    {
        $session = new Session();

        return $session->get('total');
    }

    public function setSessionCost($cost)
    {
        $session = new Session();

        return $session->set('cost', $cost);
    }

    public function getSessionCost()
    {
        $session = new Session();

        return $session->get('cost');
    }

    public function getSessionReservation()
    {
        $session = new Session();

        return $reservation = $session->get('reservation');
    }

    public function totalCost()
    {
        $reservation = $this->getSessionReservation();
        $this->setTotal(0);
        $this->setSessionCost(0);

        foreach ($reservation->getTickets() as $ticket) {
            $ticketType = $ticket->getTicketType();
            $reducedPrice = $ticket->getReducedPrice();
            $birthDate = $ticket->getBirthDate()->format('Y-m-d');
            $curentDate = date('Y-m-d');
            $yearOfBirth = $birthDate[0].$birthDate[1].$birthDate[2].$birthDate[3];
            $yearOfCurentDate = $curentDate[0].$curentDate[1].$curentDate[2].$curentDate[3];
            $age = (int) $yearOfCurentDate - (int) $yearOfBirth;

            if ($age >= 4 && $age <= 12) {
                $this->setCost(8);
                $this->setSessionCost($this->getCost());
                $this->setTotal($this->getTotal() + $this->getSessionCost());
            }
            if ($age > 12 && $age < 60 && !$reducedPrice) {
                $this->setCost(16);
                $this->setSessionCost($this->getCost());
                $this->setTotal($this->getTotal() + $this->getSessionCost());
            }
            if ($age >= 60 && !$reducedPrice) {
                $this->setCost(12);
                $this->setSessionCost($this->getCost());
                $this->setTotal($this->getTotal() + $this->getSessionCost());
            }
            if ($reducedPrice && $age > 12) {
                $this->setCost(10);
                $this->setSessionCost($this->getCost());
                $this->setTotal($this->getTotal() + $this->getSessionCost());
            }
        }
        $this->setTotal($this->getTotal());
    }
}
