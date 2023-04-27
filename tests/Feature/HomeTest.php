<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Home test.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get(route('home'));

        $response
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /**
     * Dashboard test.
     */
    public function testDashboard(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('home'))
            ->assertStatus(200)
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Dashboard')
                ->has('connections')
                ->has('selectedConnection')
                ->has('tree')
            );
    }
}
