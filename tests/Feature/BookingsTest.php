<?php

namespace Tests\Feature;

use App\Event;
use App\Booking;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingsTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->event = factory(Event::class)->create([
            'date' => date('Y-m-d'),
            'start_time' => '23:23:59',
        ]);
    }

    /** @test */
    public function a_non_logged_in_user_cannot_create_a_booking()
    {
        $this->withExceptionHandling()
            ->get('/booking/create?event_id=' . $this->event->id . '&guests=5')
            ->assertStatus(302);
    }

    /** @test */
    public function a_user_can_create_a_booking()
    {
        $this->actingAs($this->user)
            ->get('/booking/create?event_id=' . $this->event->id . '&guests=5')
            ->assertStatus(200)
            ->assertSee($this->event->title);
    }

    /** @test */
    public function confirm_total_booking_amount()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function validate_a_booking()
    {
        $this->markTestIncomplete();
    }

    /** @test */
    public function a_user_submits_a_booking()
    {
        $attributes = [
            'event_id' => $this->event->id,
            'guest' => [
                1 => [
                    'name' => 'John Smith',
                    'email' => 'john@example.com'
                ],
                2 => [
                    'name' => 'Katy Smith',
                    'email' => 'katy@example.com'
                ]
            ]
        ];

        $attributes += $this->paymentAttributes;

        $this->actingAs($this->user)
            ->post('/booking', $attributes)
            ->assertStatus(302)
            ->assertSessionHas('success')
            ->assertRedirect('/home');

        $this->assertEquals(2, count($this->event->bookings));
    }
}
