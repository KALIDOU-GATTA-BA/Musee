<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaymentErrorController extends AbstractController
{
    /**
     * @Route("/payment/error", name="payment_error")
     */
    public function index()
    {
        return $this->render('payment_error/index.html.twig', [
            'controller_name' => 'PaymentErrorController',
        ]);
    }
}
