<?php

namespace Tests\Feature;

use App\Models\Redis as RedisModel;
use App\Models\RedisIndexingStrategies\KeysStrategy;
use App\Models\RedisIndexingStrategies\ScanStrategy;
use App\Models\RedisIndexingStrategies\Strategy as IndexingStrategy;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class RedisTest extends TestCase
{
    private RedisModel $redis;

    public function setUp(): void
    {
        parent::setUp();

        $this->randomKey = Redis::randomKey();
        $this->redis = new RedisModel();
    }

    public static function provider()
    {
        return [
            'KeysStrategy' => [new KeysStrategy()],
            'ScanStrategy' => [new ScanStrategy()],
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testIndex($strategy): void
    {
        $this->assertInstanceOf(IndexingStrategy::class, $strategy);

        $keys = $this->redis->keys($strategy);

        $this->assertIsArray($keys);

        foreach (explode(':', $this->randomKey) as $part) {
            $this->assertTrue(array_key_exists($part, $keys));
            $keys = $keys[$part]['children'] ?? null;
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
