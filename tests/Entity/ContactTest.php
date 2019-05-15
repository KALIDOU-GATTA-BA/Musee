<?php
namespace App\tests\Entity;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testGetEmail(){
        $t=new Contact();
        $t->setEmail('kalidougattaba@gmail.com');
        $this->assertEquals('kalidougattaba@gmail.com', $t->getEmail());
    }      
    public function testGetPhoneNumber(){
        //return $this->count;
        $t=new Contact();
        $t->setPhoneNumber(12340378);
        $this->assertEquals(12340378, $t->getPhoneNumber());
    }
}