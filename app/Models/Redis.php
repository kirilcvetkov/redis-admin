<?php

namespace App\Models;

use App\Models\RedisIndexingStrategies\Strategy as IndexingStrategy;
use App\Models\RedisIndexingStrategies\KeysStrategy;
use Carbon\Carbon;
use Exception;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\Redis as RedisFacade;
use Redis as Base;

class Redis
{
    private static PhpRedisConnection $redis;

    public function __construct(private ?string $selectedConnection = null)
    {
        if (
            is_null($this->selectedConnection)
            || ! array_key_exists($this->selectedConnection, $this->getConnections())
        ) {
            $this->selectedConnection ??= array_key_first($this->getConnections());
        }

        if (! isset(self::$redis) || ! self::$redis instanceof RedisFacade) {
            self::$redis = RedisFacade::connection($this->selectedConnection);
            self::$redis->client('setname', env('APP_NAME'));
            self::$redis->setOption(Base::OPT_SCAN, Base::SCAN_RETRY);
        }
    }

    /**
     * TODO: Get the list of letter index of item's keys.
     */
    // public function alphabet()
    // {
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
    public function keys(IndexingStrategy $strategy = new KeysStrategy()): array
    {
        $foundKeys = [];

        foreach ([...range('A', 'Z'), ...range('a', 'z'), ...range(0, 9)] as $filter) {
            foreach ($strategy->keys(self::$redis, $filter) as $key) {
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $selectedConnection, string $key, string $newKey)
    {
        if ($key === $newKey) {
            throw new Exception('Name is unchanged.');
        }

        if (! self::$redis->exists($key)) {
            throw new Exception('Item does not exist.');
        }

        if (! self::$redis->rename($key, $newKey)) {
            throw new Exception('Error while deleting item.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Display individual item from the Redis database.
     */
    public function get(string $key)
    {
        $ttl = self::$redis->ttl($key);
        $encoding = self::$redis->object('encoding', $key);
        $refcount = self::$redis->object('refcount', $key);
        $typeId = self::$redis->type($key);

        switch ($typeId) {
            case Base::REDIS_STRING:
                $type = 'String';
                $value = self::$redis->get($key);
                break;

            case Base::REDIS_SET:
                $type = 'Set';
                $value = self::$redis->sMembers($key);
                sort($value);
                break;

            case Base::REDIS_LIST:
                $type = 'List';
                $value = self::$redis->lRange($key, 0, -1);
                break;

            case Base::REDIS_ZSET:
                $type = 'ZSet';
                $value = array_map(function ($value) use ($key) {
                    return [
                        'score' => self::$redis->zScore($key, $value),
                        'value' => $value,
                    ];
                }, self::$redis->zRange($key, 0, -1));
                break;

            case Base::REDIS_HASH:
                $type = 'Hash';
                $value = self::$redis->hGetAll($key);
                ksort($value);
                break;

            case Base::REDIS_NOT_FOUND:
                $type = 'Not found';
                $value = self::$redis->get($key);
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
        return match ($type ?? self::$redis->type($key)) {
            Base::REDIS_STRING => is_string($value) ? strlen($value) : 0,
            Base::REDIS_SET => self::$redis->sCard($key) ?: 0,
            Base::REDIS_LIST => self::$redis->lLen($key) ?: 0,
            Base::REDIS_ZSET => self::$redis->zCard($key) ?: 0,
            Base::REDIS_HASH => self::$redis->hLen($key) ?: 0,
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

    public function getSelectedConnection(): string|null
    {
        return $this->selectedConnection;
    }

    public function getStats()
    {
        $info = collect(self::$redis->info());

        return [[
                'name' => 'Number of keys',
                'value' => self::$redis->dbSize(),
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
                'value' => (new Carbon(self::$redis->lastSave()))->diffForHumans()
        ]];
    }

    public function getSlowLog()
    {
        return [
            'len' => self::$redis->slowLog('len'),
            'list' => array_map(function ($row) {
                $seconds = floor(($row['2'] % (60 * 1000 * 1000)) / (1000 * 1000));
                $milliseconds = floor(($row['2'] % (1000 * 1000)) / 1000);
                $microseconds = $row['2'] % 1000;

                return array_merge($row, [
                    'execTime' =>
                        ($seconds ? ($seconds . 's') : null) .
                        ($milliseconds ? (' ' . $milliseconds . 'ms') : null) .
                        ($microseconds ? sprintf(' %03dus', $microseconds) : null),
                    'humanTs' => Carbon::createFromTimestamp($row[1])->diffForHumans(),
                ]);
            }, self::$redis->slowLog('get', 100))
        ];
    }

    public function destroy(string $key)
    {
        if (! self::$redis->exists($key)) {
            throw new Exception('Item does not exist.');
        }

        if (self::$redis->delete($key) === 0) {
            throw new Exception('Error while deleting item.');
        }
    }
}
