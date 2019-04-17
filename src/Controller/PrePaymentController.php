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
        $session=$this->get('session'); 
        $total=$session->get('total');

        return $this->render('pre_payment/pre_payment.html.twig', [
            'cost' => $total
        ]);
    }
}