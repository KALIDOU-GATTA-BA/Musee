<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ContactType;
use App\Services\ContactManager;
use Symfony\Component\HttpFoundation\Request;
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contactForm")
     */
    public function contact (Request $request, ObjectManager $manager, \Swift_Mailer $mailer, ContactManager $c){
                $form = $this->createForm(ContactType::class)->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()){
                    $form=$form->getData();
                    $manager->persist($form);
                    $manager->flush();    
                    $mailer->send($c->sendMessage()
                                    ->setBody(
                                            $this->renderView(
                                            'emails/contact.html.twig',
                                            ['contact_name' => $c->sql()[2],
                                            'contact_email'=>$c->sql()[4],
                                            'contact_phoneNumber'=>$c->sql()[0],
                                            'contact_message'=>$c->sql()[1]
                                            ]
                                        ),
                                    'text/html'
                    ));
                    return $this->redirectToRoute('home');
                }
                    return $this->render('home/contact.html.twig', [
                        'formContact' => $form->createView(),
                    ]); 
    }
}