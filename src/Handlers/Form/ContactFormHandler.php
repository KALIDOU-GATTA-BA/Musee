<?php
namespace App\Handlers\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class ContactFormHandler
{
	private $entityManager;
	public function __construct(EntityManagerInterface $entityManager) 
	{
    	 $this->entityManager = $entityManager;		 
	}
    public function handle(FormInterface $form)
    {
        if ($form->isSubmitted() && $form->isValid()) {
        	$form=$form->getData();
        	$this->entityManager->persist($form);
            $this->entityManager->flush();
            return true;
        }
    }
} 