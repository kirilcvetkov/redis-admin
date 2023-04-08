<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\Redis as RedisFacade;
use Redis;

class RedisController extends Controller
{
    public function __construct(private ?string $selectedConnection = null)
    {
        if (
            ! is_null($this->selectedConnection)
            && array_key_exists($this->selectedConnection, $this->getConnections())
        ) {
            return;
        }

        $this->selectedConnection ??= array_key_first($this->getConnections());
    }

    /**
     * TODO: Get the list of letter index of item's keys.
     */
    // public function alphabet()
    // {
    //     $redis = $this->getRedis();

    //     $letters = [];
    //     $page = 100;

    //     foreach ([...range('A', 'Z'), ...range(0, 9)] as $filter) {
    //         $cursor = null;

    //         foreach ($redis->command('scan', [$cursor, $filter . '*', $page]) as $key) {
    //             $letters[$filter] = ($letters[$filter] ?? 0) + 1;
    //         }

    //         if ($filter != strtolower($filter)) {
    //             foreach ($redis->command('scan', [$cursor, strtolower($filter) . '*', $page]) as $key) {
    //                 $letters[$filter] = ($letters[$filter] ?? 0) + 1;
    //             }
    //         }
    //     }

    //     return $letters;
    // }

    /**
     * Get list of all keys by using KEYS command.
     */
    public function index()
    {
        $foundKeys = [];
        $page = 100;

        foreach ([...range('A', 'Z'), ...range('a', 'z'), ...range(0, 9)] as $filter) {
            foreach ($this->getRedis()->command('keys', [$filter . '*']) ?: [] as $key) {
                $foundKeys = $this->fill(explode(':', $key), $foundKeys);
            }
        }

        return $foundKeys;
    }

    /**
     * Get list of all keys by using SCAN command.
     */
    public function indexUsingScan()
    {
        $foundKeys = [];
        $page = 100;

        foreach ([...range('A', 'Z'), ...range('a', 'z'), ...range(0, 9)] as $filter) {
            $it = null;

            foreach ($this->getRedis()->command('scan', [$it, $filter . '*', $page]) ?: [] as $key) {
                $foundKeys = $this->fill(explode(':', $key), $foundKeys);
            }
        }

        return $foundKeys;
    }

    /**
     * Fill in the tree of keys.
     */
    private function fill($tree, $parent, $key = null)
    {
        if (empty($tree)) {
            return null;
        }

        $name = array_shift($tree);
        $key .= $name . ($tree ? ':' : null);

        $parent[$name]['name'] = $name;
        $parent[$name]['key'] = $key;
        $parent[$name]['children'] = $this->fill($tree, $parent[$name]['children'] ?? [], $key);
        if (is_null($parent[$name]['children']) && $count = $this->getCount($key)) {
            $parent[$name]['count'] = $count;
        }

        if (! empty($parent[$name]['children'])) {
            ksort($parent[$name]['children']);
        }

        return $parent;
    }

    /**
     * Display individual item from the Redis database.
     */
    public function get(string $key)
    {
        $redis = $this->getRedis();

        $ttl = $redis->ttl($key);
        $encoding = $redis->object('encoding', $key);
        $refcount = $redis->object('refcount', $key);
        $typeId = $redis->type($key);

        switch ($typeId) {
            case Redis::REDIS_STRING:
                $type = 'String';
                $value = $redis->get($key);
                break;

            case Redis::REDIS_SET:
                $type = 'Set';
                $value = $redis->sMembers($key);
                sort($value);
                break;

            case Redis::REDIS_LIST:
                $type = 'List';
                $value = $redis->lRange($key, 0, -1);
                break;

            case Redis::REDIS_ZSET:
                $type = 'ZSet';
                $value = array_map(function ($value) use ($redis, $key) {
                    return [
                        'score' => $redis->zScore($key, $value),
                        'value' => $value,
                    ];
                }, $redis->zRange($key, 0, -1));
                break;

            case Redis::REDIS_HASH:
                $type = 'Hash';
                $value = $redis->hGetAll($key);
                ksort($value);
                break;

            case Redis::REDIS_NOT_FOUND:
                $type = 'Not found';
                $value = $redis->get($key);
                break;
        }

        return [
            'key' => $key,
            'type' => $type,
            'value' => $value,
            'size' => $this->getCount($key, $typeId, $value),
            'ttl' => $ttl,
            'encoding' => $encoding,
            'refcount' => $refcount,
        ];
    }

    public function getCount(string $key, ?int $type = null, $value = null): int|null
    {
        return match ($type ?? $this->getRedis()->type($key)) {
            Redis::REDIS_STRING => is_string($value) ? strlen($value) : 0,
            Redis::REDIS_SET => $this->getRedis()->sCard($key) ?: 0,
            Redis::REDIS_LIST => $this->getRedis()->lLen($key) ?: 0,
            Redis::REDIS_ZSET => $this->getRedis()->zCard($key) ?: 0,
            Redis::REDIS_HASH => $this->getRedis()->hLen($key) ?: 0,
            default => is_array($value) ? count($value) : (is_string($value) ? strlen($value) : 0),
        };
    }

    public function getConnections()
    {
        return array_filter(
            config('database.redis'),
            fn ($key) => ! in_array($key, ['client', 'options']),
            ARRAY_FILTER_USE_KEY
        );
    }

    public function getRedis(): PhpRedisConnection
    {
        static $redis;

        if (! isset($redis) || ! $redis instanceof RedisFacade) {
            $redis = RedisFacade::connection($this->selectedConnection);
            $redis->client('setname', env('APP_NAME'));
            $redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
        }

        return $redis;
    }

    public function getSelectedConnection(): string|null
    {
        return $this->selectedConnection;
    }

    public function getStats()
    {
        $info = collect($this->getRedis()->info());

        return [[
                'name' => 'Number of keys',
                'value' => $this->getRedis()->dbSize(),
            ], [
                'name' => 'Redis Version',
                'value' => $info->get('redis_version'),
            ], [
                'name' => 'Redis Mode',
                'value' => $info->get('redis_mode'),
            ], [
                'name' => 'Uptime',
                'value' =>
                    Carbon::createFromTimestamp(time() - $info->get('uptime_in_seconds'))
                        ->longAbsoluteDiffForHumans()
            ], [
                'name' => 'Used Memory',
                'value' => $info->get('used_memory_human'),
            ], [
                'name' => 'Last disk save',
                'value' => (new Carbon($this->getRedis()->lastSave()))->diffForHumans()
        ]];
    }

    public function getSlowLog()
    {
        return [
            'len' => $this->getRedis()->slowLog('len'),
            'list' => array_map(function ($row) {
                $miuntes = floor($row['2'] / (60 * 1000));
                $seconds = floor(($row['2'] - ($miuntes * 60 * 1000)) / 1000);
                $milliseconds = $row['2'] - ($miuntes * 60 * 1000 + $seconds * 1000);

                return array_merge($row, [
                    'execTime' => sprintf('%02dm %02ds %03dms', $miuntes, $seconds, $milliseconds),
                    'humanTs' => Carbon::createFromTimestamp($row[1])->diffForHumans(),
                ]);
            }, $this->getRedis()->slowLog('get', 100))
        ];
    }

    public function destroy(string $key)
    {
        return $this->getRedis()->delete($key);
    }
}
