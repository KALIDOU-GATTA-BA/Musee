<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Tests\Fixtures\Validation;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'content1' => 'kjil',
            'content2' => 133892,
            'content3' => 133892,
            'content4' => 133892,
            'content5' => 133892,
            'content6' => 133892,
            'content7' => 133892

        ]);
    }
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
    /**
     * @Route("/exposures", name="exposures")
     */
    public function exposures(){
        return $this->render('home/exposures.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/news", name="news")
     */
    public function news(){
        return $this->render('home/news.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/practicalsInformations", name="practicalsInformations")
     */
    public function practicalsInformations(){
        return $this->render('home/practicalsInformations.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    
    /**
     * @Route("/tickets", name="tickets")
     */
    public function tickets()
    {
        return $this->render('home/tickets.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}