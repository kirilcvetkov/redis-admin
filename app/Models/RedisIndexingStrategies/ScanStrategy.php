<?php

namespace App\Models\RedisIndexingStrategies;

use Illuminate\Redis\Connections\PhpRedisConnection;

class ScanStrategy implements Strategy
{
    private $it = null;

    public function __construct(public readonly int $page = 1000)
    {
    }

    public function keys(PhpRedisConnection &$redis, string $filter): array
    {
        return $redis->command('scan', [$this->it, $filter . '*', $this->page]) ?: [];
    }
}
