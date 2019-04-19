<?php
namespace App\Validator\Constraints;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class HalfDayValidator extends ConstraintValidator
{
	public function validate($reservation, Constraint $constraint)
    {	  
		foreach ($reservation->getTickets() as $ticket) {
                    $ticketType=$ticket->getTicketType(); 
        } 
                    $visitDay = $reservation->getVisitDate();
	                $visitDay = $visitDay->format('Y-m-d');
	                $_visitDay = $reservation->getVisitDate();
	                $_visitDay = $_visitDay->format('D');
	                $_visitDay_ = $reservation->getVisitDate();
	                $_visitDay_ = $_visitDay_->format('Y-m-d');
	                $_0501 = $_visitDay_[5] .$_visitDay_[6] .$_visitDay_[8] .$_visitDay_[9];
	                $_1101 = $_visitDay_[5] .$_visitDay_[6] .$_visitDay_[8] .$_visitDay_[9];
	                $_1225 = $_visitDay_[5] .$_visitDay_[6] .$_visitDay_[8] .$_visitDay_[9];
	                $_0101 = $_visitDay_[5] .$_visitDay_[6] .$_visitDay_[8] .$_visitDay_[9];
	                $_0508 = $_visitDay_[5] .$_visitDay_[6] .$_visitDay_[8] .$_visitDay_[9];
	                $_0714 = $_visitDay_[5] .$_visitDay_[6] .$_visitDay_[8] .$_visitDay_[9];
	                $_0815 = $_visitDay_[5] .$_visitDay_[6] .$_visitDay_[8] .$_visitDay_[9];
	                $_1111 = $_visitDay_[5] .$_visitDay_[6] .$_visitDay_[8] .$_visitDay_[9];
	                $curentDate = date("Y-m-d"); 

                    if (($visitDay == $curentDate)&&($ticketType=='Billet journée')){
	                    $curentHour = date("H");
	                    $curentHour = $curentHour[0] .$curentHour[1];
	                    if ((int)$curentHour >= 14 ){
							$this->context->buildViolation($constraint->message)
	               						  ->addViolation();                    
	               		}     
                	}
                	if (($_visitDay=='Tue')||($_visitDay=='Sun') || ($_0501=='0501')|| ($_1101=='1101')|| ($_1225=='1225')|| ($_0101=='0101')|| ($_0508=='0508')|| ($_0714=='0714')| ($_0815=='0815')| ($_1111=='1111') ) {
							$this->context->buildViolation($constraint->message_2)
	               						  ->addViolation();                      
	               	}        	
	}
}