<?php
 namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
    	$red='red';
    	$session=$this->get('session');
    	$session->set('couleur', $red);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController'

        ]);
    }
}

/*
reservation.publishDate|date('Y-m-d')
*/