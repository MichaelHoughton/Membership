<?php

namespace Tests\Unit;

use App\Event;
use Tests\TestCase;

class EventTest extends TestCase
{
    public function testScopeFuture()
    {
        $this->markTestIncomplete();
    }

    public function testTotalPrice()
    {
        $event = factory(Event::class)->create();

        // lets test the non member price with 5 guests
        $this->assertEquals($event->public_price * 5, $event->totalPrice(5));

        // lets check the member price with 3 guests
        $this->assertEquals($event->member_price * 3, $event->totalPrice(3, true));

    }
}
