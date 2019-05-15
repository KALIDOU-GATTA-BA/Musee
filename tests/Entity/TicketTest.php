<?php
namespace App\tests\Entity;

use App\Entity\Ticket;
use PHPUnit\Framework\TestCase;

class TicketTest extends TestCase
{
    public function testGetName(){
        $t=new Ticket();
        $t->setName('Gatta');
        $this->assertEquals('Gatta', $t->getName());
    }      
    public function testGetCountry(){
        $t=new Ticket();
        $t->setCountry('France');
        $this->assertEquals('France', $t->getCountry());
    }
    public function testGetReducedPrice(){
        //return $this->count;
        $t=new Ticket();
        $t->setReducedPrice(false);
        $this->assertEquals(false, $t->getReducedPrice());
    }
}