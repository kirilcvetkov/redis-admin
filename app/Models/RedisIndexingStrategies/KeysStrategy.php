<?php

namespace App\Models\RedisIndexingStrategies;

use Illuminate\Redis\Connections\PhpRedisConnection;

class KeysStrategy extends AbstractStrategy
{
    public function keys(PhpRedisConnection &$redis, string $filter): array
    {
        return $redis->command('keys', [$filter . '*']) ?: [];
    }
}
