<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function __construct(public ?string $selectedConnection = null)
    {
        if (
            ! is_null($this->selectedConnection)
            && array_key_exists($this->selectedConnection, $this->getConnections())
        ) {
            return;
        }

        $this->selectedConnection ??= array_key_first($this->getConnections());
    }

    public function getSelectedConnection()
    {
        return $this->selectedConnection;
    }

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
     * Display a listing of the resource.
     */
    public function index()
    {
        $redis = $this->getRedis();

        $foundKeys = [];
        $page = 100;

        foreach ([...range('A', 'Z'), ...range('a', 'z'), ...range(0, 9)] as $filter) {
            $it = null;

            foreach ($redis->command('scan', [$it, $filter . '*', $page]) ?: [] as $key) {
                $foundKeys = $this->fill(explode(':', $key), $foundKeys);
            }
        }

        return $foundKeys;
    }

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

        return $parent;
    }

    public function getCount(string $key): int|null
    {
        // return $this->show($key)['size'] ?? null;
        return match($this->getRedis()->type($key)) {
            \Redis::REDIS_STRING => null,
            \Redis::REDIS_LIST => $this->getRedis()->lLen($key),
            default => $this->getRedis()->object('refcount', $key),
        };
    }

    public function getConnections()
    {
        $connections = config('database.redis');
        unset($connections['client'], $connections['options']);

        return $connections;
    }

    public function getRedis()
    {
        $redis = Redis::connection($this->selectedConnection);
        $redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY);

        return $redis;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $key)
    {
        $redis = $this->getRedis();

        $ttl = $redis->ttl($key);
        $encoding = $redis->object('encoding', $key);
        $refcount = $redis->object('refcount', $key);

        switch ($redis->type($key)) {
            case \Redis::REDIS_STRING:
                $type = 'String';
                $value = $redis->get($key);
                $size = strlen($value);
                break;

            case \Redis::REDIS_SET:
                $type = 'Set';
                $value = $redis->sMembers($key);
                sort($value);
                $size = count($value);
                break;

            case \Redis::REDIS_LIST:
                $type = 'List';
                $value = $redis->lRange($key, 0, -1);
                $size = $redis->lLen($key);
                break;

            case \Redis::REDIS_ZSET:
                $type = 'ZSet';
                $value = array_map(function($value) use ($redis, $key) {
                    return [
                        'score' => $redis->zScore($key, $value),
                        'value' => $value,
                    ];
                }, $redis->zRange($key, 0, -1));
                $size = count($value);
                break;

            case \Redis::REDIS_HASH:
                $type = 'Hash';
                $value = $redis->hGetAll($key);
                ksort($value);
                $size = count($value);
                break;

            case \Redis::REDIS_NOT_FOUND:
                $type = 'Not found';
                $value = $redis->get($key);
                $size = null;
                break;
        }

        return [
            'key' => $key,
            'type' => $type,
            'value' => $value,
            'size' => $size,
            'ttl' => $ttl,
            'encoding' => $encoding,
            'refcount' => $refcount,
        ];
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
