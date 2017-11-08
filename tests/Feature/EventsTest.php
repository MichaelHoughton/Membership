<?php

namespace Tests\Feature;

use App\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventsTest extends TestCase
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
    public function the_events_show_on_the_home_page()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee($this->event->title);
    }

    /** @test */
    public function a_user_sees_events_on_the_dashboard()
    {
        $this->actingAs($this->user)
            ->get('/home')
            ->assertStatus(200)
            ->assertSee($this->event->title);
    }

    /** @test */
    public function view_an_event()
    {
        $this->get('/event/' . $this->event->slug)
            ->assertStatus(200)
            ->assertSee($this->event->title);
    }

    /** @test */
    public function a_guest_cannot_book_an_event()
    {
        $this->get('/event/' . $this->event->slug)
            ->assertStatus(200)
            ->assertSee('You need to')
            ->assertSee('login')
            ->assertSee('register');
    }

    /** @test */
    public function a_user_can_book_an_event()
    {
        $this->actingAs($this->user)
            ->get('/event/' . $this->event->slug)
            ->assertStatus(200)
            ->assertSee('Please confirm the number of guests (including yourself)');
    }
}
