<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("payment", name="payment")
     */
    public function index()
    {
       
        \Stripe\Stripe::setApiKey("sk_test_4eC39HqLyjWDarjtT1zdp7dc");

        $charge = \Stripe\Charge::create([
            'amount' => 999,
            'currency' => 'usd',
            'source' => 'tok_visa',
            'receipt_email' => 'kalidougattaba@gmail.com',
        ]);

        return $this->render('payment/payment.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
}
