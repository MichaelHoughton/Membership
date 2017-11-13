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
        $this->withSession(['roleCodes' => ['superadmin']])
            ->get('/admin/brokers/create')
            ->assertStatus(200);
    }

    /** @test */
    public function validates_required_broker_fields()
    {
        $requiredFields = [
            'brokerName',
            'brokerAFSL'
        ];

        foreach ($requiredFields as $field) {
            $attributes = $this->attributes('Broker', [$field => null]);

            $this->withExceptionHandling()
                ->withSession(['roleCodes' => ['superadmin']])
                ->post('admin/brokers', $attributes)
                ->assertStatus(302)
                ->assertSessionHasErrors($field);
        }
    }

    /** @test */
    public function create_a_broker()
    {
        $attributes = $this->attributes('Broker');

        $this->withSession(['roleCodes' => ['superadmin']])
            ->post('admin/brokers', $attributes)
            ->assertSessionHas('success')
            ->assertRedirect('/admin/brokers');
    }

    /** @test */
    public function display_edit_a_broker_page()
    {
        $broker = $this->create('Broker');

        $this->withSession(['roleCodes' => ['superadmin']])
            ->get('/admin/brokers/' . $broker->brokerID . '/edit')
            ->assertStatus(200);
    }

    /** @test */
    public function update_a_broker()
    {
        $broker = $this->create('Broker');
        $attributes = $this->attributes('Broker');

        $this->withSession(['roleCodes' => ['superadmin']])
            ->patch('admin/brokers/' . $broker->brokerID, $attributes)
            ->assertSessionHas('success')
            ->assertRedirect('/admin/brokers');
    }
}
