<?php

namespace App\Models\RedisIndexingStrategies;

use Illuminate\Redis\Connections\PhpRedisConnection;

abstract class AbstractStrategy
{
    abstract public function keys(PhpRedisConnection &$redis, string $filter): array;
}
