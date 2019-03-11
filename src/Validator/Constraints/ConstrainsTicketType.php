<?php 
namespace App\Validator\Constraints;
use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class ConstrainsTicketType extends Constraint
{
	   public $message="ceci est une erreur !"  ;
	   public function getTargets()
		{
		    return self::CLASS_CONSTRAINT;
		}
}
