<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ORM\EntityManagerInterface;

class GeneralConstraintsValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($reservation, Constraint $constraint)
    {
        foreach ($reservation->getTickets() as $ticket) {
            $ticketType = $ticket->getTicketType();
        }

        $res = $this->entityManager->createQuery('SELECT r FROM App\Entity\Reservation r ')->getResult();

        $chosenDay = $reservation->getVisitDate();
        $i = 0;
        $buffer = 0;
        foreach ($res as $_res) {
            if ($chosenDay->format('Y-m-d') == $_res->getVisitDate()->format('Y-m-d')) {
                foreach ($reservation->getTickets() as $key) {
                    ++$i;
                }
                $_res->setCount($_res->getCount() + $i);
                if ($_res->getCount() > 1000) {
                    $buffer = 1;
                }
            }
        }
        if (1 == $buffer) {
            $this->context->buildViolation($constraint->message_3)
                                   ->addViolation();
        }
        $visitDay = $reservation->getVisitDate();
        $visitDay = $visitDay->format('Y-m-d');
        $_visitDay = $reservation->getVisitDate();
        $_visitDay = $_visitDay->format('D');
        $_visitDay_ = $reservation->getVisitDate();
        $_visitDay_ = $_visitDay_->format('Y-m-d');
        $_0501 = $_visitDay_[5].$_visitDay_[6].$_visitDay_[8].$_visitDay_[9];
        $_1101 = $_visitDay_[5].$_visitDay_[6].$_visitDay_[8].$_visitDay_[9];
        $_1225 = $_visitDay_[5].$_visitDay_[6].$_visitDay_[8].$_visitDay_[9];
        $_0101 = $_visitDay_[5].$_visitDay_[6].$_visitDay_[8].$_visitDay_[9];
        $_0508 = $_visitDay_[5].$_visitDay_[6].$_visitDay_[8].$_visitDay_[9];
        $_0714 = $_visitDay_[5].$_visitDay_[6].$_visitDay_[8].$_visitDay_[9];
        $_0815 = $_visitDay_[5].$_visitDay_[6].$_visitDay_[8].$_visitDay_[9];
        $_1111 = $_visitDay_[5].$_visitDay_[6].$_visitDay_[8].$_visitDay_[9];
        $curentDate = date('Y-m-d');

        if (($visitDay == $curentDate) && ('Billet journée' == $ticketType)) {
            $curentHour = date('H');
            $curentHour = $curentHour[0].$curentHour[1];
            if ((int) $curentHour >= 14) {
                $this->context->buildViolation($constraint->message)
                                             ->addViolation();
            }
        }
        if (('Tue' == $_visitDay) || ('Sun' == $_visitDay) || ('0501' == $_0501) || ('1101' == $_1101) || ('1225' == $_1225) || ('0101' == $_0101) || ('0508' == $_0508) || ('0714' == $_0714) || ('0815' == $_0815) || ('1111' == $_1111)) {
            $this->context->buildViolation($constraint->message_2)
                                             ->addViolation();
        }
        //Easter off day, Pentecost off day, Ascent off day
        $A = intval((intval($reservation->getVisitDate()->format('Y')) % 19) + 1);
        $B = intval((intval($reservation->getVisitDate()->format('Y')) / 100 + 1));
        $C = intval((3 * $B) / 4 - 12);
        $D = intval((8 * $B + 5) / 25 - 5);
        $E = intval((intval($reservation->getVisitDate()->format('Y')) * 5) / 4 - 10 - $C);
        $F = intval(((11 * $A + 20 + $D - $C) % 30 + 30) % 30);

        if ((24 == $F) || ((25 == $F) && $A > 11)) {
            $F = $F + 1;
        }
        $G = 44 - $F;
        if (($G < 21)) {
            $G = $G + 30;
        }
        $res = $G + 7 - ($E + $G) % 7 + 1;

        if ($res > 31) {
            $count = $res - 31;
            if ((intval($reservation->getVisitDate()->format('d')) == $count) && ('04' == $reservation->getVisitDate()->format('m'))) {
                $this->context->buildViolation($constraint->message_2)
                                                  ->addViolation();
            }
            $pent = $count + 49;
            $asc = $count + 38;
            if ($count > 11) {
                if ($count >= 13) {
                    $_30 = 0;

                    if (22 == $count && ('05:30' == $reservation->getVisitDate()->format('m:d'))) {
                        $_30 = -1;
                    }

                    $asc %= 30;
                    --$pent;
                    $pent %= 30;
                    $t = 0;
                    if (('06' == $reservation->getVisitDate()->format('m')) && intval($reservation->getVisitDate()->format('d')) == $pent) {
                        $t = -2;
                    }
                    if (-2 == $t or (intval($reservation->getVisitDate()->format('d')) == $asc) or -1 == $_30) {
                        $this->context->buildViolation($constraint->message_2)
                                                           ->addViolation();
                    }
                }
                if ($count < 13) {
                    $asc %= 30;
                    --$pent;
                    $pent %= 30;
                    $v = 0;
                    if (0 == $pent) {
                        $v = 1;
                    }
                    $t = 0;
                    if (('05' == $reservation->getVisitDate()->format('m')) && intval($reservation->getVisitDate()->format('d')) == $pent) {
                        $t = -2;
                    }
                    if (-2 == $t or 1 == $v or (intval($reservation->getVisitDate()->format('d')) == $asc)) {
                        $this->context->buildViolation($constraint->message_2)
                                                           ->addViolation();
                    }
                }
            }
            if ($count <= 11) {
                $_30 = 0;
                $r = 0;
                if (11 == $count && ('05:30' == $reservation->getVisitDate()->format('m:d'))) {
                    $_30 = -1;
                }
                $asc %= 30;
                $pent %= 30;
                if ('05' == $reservation->getVisitDate()->format('m') && (intval($reservation->getVisitDate()->format('d')) == $pent)) {
                    $r = -2;
                }
                if (-2 == $r or (intval($reservation->getVisitDate()->format('d')) == $asc) or -1 == $_30) {
                    $this->context->buildViolation($constraint->message_2)
                                                  ->addViolation();
                }
            }
        }
        if ($res <= 31) {
            $pent = $res + 48;
            $pent %= 30;
            $asc = $res + 37;
            $asc %= 30;
            if ((intval($reservation->getVisitDate()->format('d')) == $res) || (intval($reservation->getVisitDate()->format('d')) == $asc)) {
                $this->context->buildViolation($constraint->message_2)
                                                  ->addViolation();
            }
            if (intval($reservation->getVisitDate()->format('d')) == $pent) {
                $this->context->buildViolation($constraint->message_2)
                                                     ->addViolation();
            }
        }
    }
}
