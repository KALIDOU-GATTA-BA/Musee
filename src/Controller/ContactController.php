<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Services\ContactManager;
use App\Mailer\Mailer;
use App\Handlers\Form\ContactFormHandler;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    private $formHandler;
    private $mailer;

    /**
     * @var ContactFormHandler
     */
    public function __construct(Mailer $mailer, ContactFormHandler $formHandler)
    {
        $this->mailer = $mailer;
        $this->formHandler = $formHandler;
    }

    /**
     * @Route("/contact", name="contactForm")
     */
    public function contact(Request $request, ContactRepository $manager, \Swift_Mailer $mailer, ContactManager $cm)
    {
        $form = $this->createForm(ContactType::class)->handleRequest($request);
        if ($this->formHandler->handle($form)) {
            $this->mailer->send2($cm);

            return $this->redirectToRoute('home');
        }

        return $this->render('home/contact.html.twig', [
                           'formContact' => $form->createView(),
                      ]);
    }
}
