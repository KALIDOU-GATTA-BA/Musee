<?php

namespace App\Services;

use Doctrine\Common\Persistence\ObjectManager;

class ContactManager
{
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function sql()
    {
        $res = $this->entityManager->createQuery('SELECT max(id) FROM App\Entity\Contact id')->getResult();
        $res1 = $this->entityManager->createQuery('SELECT email FROM App\Entity\Contact email where email.id='.$res[0][1].'')->getResult();

        return [$res1[0]->getPhoneNumber(), $res1[0]->getMessage(), $res1[0]->getName(), $res1[0]->getSubject(), $res1[0]->getEmail()];
    }

    public function sendMessage()
    {
        $message = (new \Swift_Message($this->sql()[3]))
                    ->setFrom($this->sql()[4]);

        return $message->setTo('baniabina.ba@gmail.com');
    }
}
