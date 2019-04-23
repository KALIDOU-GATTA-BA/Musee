<?php
namespace App\Validator\Constraints;
use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class GeneralConstraints extends Constraint
{
	public $message="Vous ne pouvez pas réserver un billet journée pour aujourd'hui parce qu'il est 14 h passé!"  ;
	public $message_2="Vous ne pouvez pas réserver un billet pour les mardis, dimanches, et les jours férié!"  ;
	public function getTargets()
		{
		    return self::CLASS_CONSTRAINT;
		}
}