<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PrePaymentController extends AbstractController
{
    /**
     * @Route("/pre_payment", name="pre_payment")
     */
    
    public function index()
    {

    	$sessionTotalCoste=$this->get('session');
        $sessionTotalCoste=$sessionTotalCoste->get('sessionTotalCoste');
        
        return $this->render('pre_payment/pre_payment.html.twig', [
            'coste' => $sessionTotalCoste

        ]);
    }
}
