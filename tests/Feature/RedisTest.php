<?php

namespace Tests\Feature;

use App\Models\User;
use App\Http\Controllers\RedisController;
use Illuminate\Support\Facades\Redis;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class RedisTest extends TestCase
{
    private RedisController $redis;

    public function setUp(): void
    {
        parent::setUp();

        $this->randomKey = Redis::randomKey();
        $this->redis = new RedisController();
        // $defaultConnection = $this->redis->getSelectedConnection();
    }

    public function testIndex(): void
    {
        $index = $this->redis->index();

        $this->assertIsArray($index);

        foreach (explode(':', $this->randomKey) as $part) {
            $this->assertTrue(array_key_exists($part, $index));
            $index = $index[$part]['children'] ?? null;
        }
    }

    public function testGet(): void
    {
        $item = $this->redis->get($this->randomKey);

        $this->assertIsArray($item);
        $this->assertArrayHasKey('key', $item);
        $this->assertArrayHasKey('type', $item);
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('size', $item);
        $this->assertArrayHasKey('ttl', $item);
        $this->assertArrayHasKey('encoding', $item);
        $this->assertArrayHasKey('refcount', $item);
    }
}
