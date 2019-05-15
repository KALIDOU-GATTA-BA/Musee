<?php

namespace App\Handlers\Form;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AddReservationFormHandler
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation = $form->getData();
            $this->session->set('reservation', $reservation);

            return true;
        }

        return false;
    }
}