<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testIsMember()
    {
        // our non subscribed user isn't a member
        $this->assertFalse($this->user->isMember());

        $subscribed = $this->subscribedUser();

        // our subscribed user is a member
        $this->assertTrue($subscribed->isMember());
    }

    public function testSubscriptionExpiry()
    {
        $this->markTestIncomplete();
    }
}
