<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;


class ConstrainsTicketTypeValidator extends ConstraintValidator
{

    public function validate($reservation, Constraint $constraint)
    {	  
		dd($reservation);
	}
}