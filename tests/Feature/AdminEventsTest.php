<?php

namespace Tests\Feature;

use App\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminEventsTest extends TestCase
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
    public function a_non_user_cannot_see_the_events()
    {
        $this->withExceptionHandling()
            ->actingAs($this->user)
            ->get('/admin/events')
            ->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_view_events()
    {
        $this->actingAs($this->admin)
            ->get('/admin/events')
            ->assertStatus(200)
            ->assertSee(e($this->event->title));
    }

    /** @test */
    public function display_create_a_broker_page()
    {
        $this->actingAs($this->admin)
            ->get('/admin/events/create')
            ->assertStatus(200)
            ->assertSee('Title');
    }

    /** @test */
    public function validates_required_fields_for_event()
    {
        $fields = [
            'title',
            'slug',
            'brief',
            'description',
            'venue',
            'date',
            'start_time',
            'public_price',
        ];

        $attributes = factory(Event::class)->raw();
        foreach ($fields as $field) {
            $attributes[$field] = null;
        }

        $this->withExceptionHandling()
            ->actingAs($this->admin)
            ->post('admin/events', $attributes)
            ->assertStatus(302)
            ->assertSessionHasErrors($fields);
    }

    /** @test */
    public function create_an_event()
    {
        $attributes = factory(Event::class)->raw();

        $this->actingAs($this->admin)
            ->post('admin/events', $attributes)
            ->assertSessionHas('success')
            ->assertRedirect('/admin/events');
    }

    /** @test */
    public function display_edit_event_page()
    {
        $event = factory(Event::class)->create();

        $this->actingAs($this->admin)
            ->get('/admin/events/'.$event->id . '/edit')
            ->assertStatus(200)
            ->assertSee(e($event->title));
    }

    /** @test */
    public function update_an_event()
    {
        $event = factory(Event::class)->create();
        $attributes = factory(Event::class)->raw();

        $this->actingAs($this->admin)
            ->patch('/admin/events/'.$event->id, $attributes)
            ->assertSessionHas('success')
            ->assertRedirect('/admin/events');
    }
}
