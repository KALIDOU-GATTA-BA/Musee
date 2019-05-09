<?php
namespace App\Tests\Entity;

use App\Entity\Reservation;
use PHPUnit\Framework\TestCase;

class ReservationTest extends TestCase
{
    /*public function testAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->add(30, 12);

        // assert that your calculator added the numbers correctly!
        $this->assertEquals(42, $result);
    }*/
     public function testGetCount()
    {
        //return $this->count;
        $t=new Reservation();
        $t->setCount(1);
        $this->assertEquals(1, $t->getCount());
    }
}