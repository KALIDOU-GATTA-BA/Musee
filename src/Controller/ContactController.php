<?php
 namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contactForm")
     */
   public function contact (Request $request, ObjectManager $manager){
                $contact = new Contact(); 
                $form= $this->createFormBuilder($contact)
                ->add('name')
                ->add('email')
                ->add('phoneNumber')
                ->add('subject')
                ->add('message')
                ->getForm();
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()){
                    $manager->persist($contact);
                    $manager->flush();


                    return $this->redirectToRoute('home');
                }
                    return $this->render('home/contact.html.twig', [
                        'formContact' => $form->createView()
                    ]); 
    }
}