<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use App\Form\AddReservationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ConstrainsTicketTypeValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {	  
		/*if (1!=0){
			   echo "Cette validation fonctionne correctement";
		       die();
   		}*/
	}
}