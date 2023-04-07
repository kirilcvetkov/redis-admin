<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
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
    public function testDashboards(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('home'));

        $response
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Dashboard')
                ->has('connections')
                ->has('selectedConnection')
                ->has('tree')
            );
    }
}
