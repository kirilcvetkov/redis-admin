<?php

namespace Tests\Feature;

use App\Models\User;
use App\Http\Controllers\RedisController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Get test.
     */
    public function test_showing_a_random_key(): void
    {
        $this->actingAs(User::factory()->create());

        $redis = new RedisController();
        $defaultConnection = $redis->getSelectedConnection();
        $randomeKey = Redis::randomKey();

        $this->get(route('show', [$defaultConnection, $randomeKey]))
            ->assertStatus(200)
            ->assertInertia(fn (AssertableInertia $page) => $page
                ->component('Show')
                ->has('connections')
                ->has('selectedConnection')
                ->has('tree')
                ->has('item', fn (AssertableInertia $page) => $page
                    ->has('key')
                    ->has('type')
                    ->has('value')
                    ->has('size')
                    ->has('ttl')
                    ->has('encoding')
                    ->has('refcount')
                )
            );
    }
}
