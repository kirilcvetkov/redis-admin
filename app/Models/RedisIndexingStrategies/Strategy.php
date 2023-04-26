<?php

namespace App\Models\RedisIndexingStrategies;

use Illuminate\Redis\Connections\PhpRedisConnection;

interface Strategy
{
    public function keys(PhpRedisConnection &$redis, string $filter): array;
}
