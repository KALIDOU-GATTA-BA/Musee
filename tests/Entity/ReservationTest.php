<?php
namespace App\tests\Entity;

use App\Entity\Reservation;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    public function testGetCount(){
        //return $this->count; 
        $t=new Reservation();
        $t->setCount(1);
        $this->assertEquals(1, $t->getCount());
    }      
    public function testGetVisitDate(){
        //return $this->count;
        $t=new Reservation();
        $t->setVisitDate(new \DateTime());
        $this->assertEquals('2019-05-24', $t->getVisitDate()->format('Y-m-d'));
    }
    public function testGetPayement(){
        //return $this->count;
        $t=new Reservation();
        $t->setPayment(true);
        $this->assertEquals(true, $t->getPayment());
    }
}