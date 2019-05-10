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
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
class ContactController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) 
    {
         $this->entityManager = $entityManager;      
    }
    /**
     * @Route("/contact", name="contactForm")
     */
    public function contact (Request $request, ObjectManager $manager, \Swift_Mailer $mailer){
        
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
                  
                    $res=$this->entityManager->createQuery('SELECT max(id) FROM App\Entity\Contact id')->getResult();
                    
                    $res1=$this->entityManager->createQuery('SELECT email FROM App\Entity\Contact email where email.id='.$res[0][1].'')->getResult();

                    $name=$res1[0]->getName();
                    $phoneNumber=$res1[0]->getPhoneNumber();
                    $message=$res1[0]->getMessage();
                    $subject=$res1[0]->getSubject();
                    $email=$res1[0]->getEmail();
                    $message = (new \Swift_Message($subject))
                    ->setFrom($email)
                    ->setTo('baniabina.ba@gmail.com')
                    ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig',
                        ['contact_name' => $name,
                        'contact_email'=>$email,
                        'contact_phoneNumber'=>$phoneNumber,
                        'contact_message'=>$message
                        ]
                    ),
                    'text/html'
          );
                                                              
            $mailer->send($message);

                    return $this->redirectToRoute('home');
                }
                    return $this->render('home/contact.html.twig', [
                        'formContact' => $form->createView(),
                        
                    ]); 
    }
}