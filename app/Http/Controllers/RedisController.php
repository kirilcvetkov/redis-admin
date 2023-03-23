<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function alphabet(string $name)
    {
        $redis = Redis::connection($name);
        $redis->setOption(\Redis::OPT_SCAN, \Redis::SCAN_RETRY);

        $letters = [];
        $page = 100;

        foreach ([...range('A', 'Z'), ...range(0, 9)] as $filter) {
            $cursor = null;

            foreach ($redis->command('scan', [$cursor, $filter . '*', $page]) as $key) {
                $letters[$filter] = ($letters[$filter] ?? 0) + 1;
            }

            if ($filter != strtolower($filter)) {
                foreach ($redis->command('scan', [$cursor, strtolower($filter) . '*', $page]) as $key) {
                    $letters[$filter] = ($letters[$filter] ?? 0) + 1;
                }
            }
        }

        return $letters;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $name)
    {
        $redis = Redis::connection($name);

        $foundKeys = [];
        $page = 100;

        foreach ([...range('A', 'Z'), ...range('a', 'z'), ...range(0, 9)] as $filter) {
            $it = null;

            foreach ($redis->command('scan', [$it, $filter . '*', $page]) ?: [] as $key) {
                $key = explode(':', $key);
                $foundKeys = $this->fill($key, $foundKeys);
            }
        }

        return $foundKeys;
    }

    function fill($tree, $parent, $key = null)
    {
        if (empty($tree)) {
            return null;
        }

        $name = array_shift($tree);
        $key .= $name . ($tree ? ':' : null);

        $parent[$name]['name'] = $name;
        $parent[$name]['key'] = $key;
        $parent[$name]['children'] = $this->fill($tree, $parent[$name]['children'] ?? [], $key);

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $request = $_REQUEST['key'] ?? null;

        if ($request) {
            $ttl = $redis->ttl($request);
            $encoding = $redis->object("encoding", $request);
            $refcount = $redis->object("refcount", $request);

            switch ($redis->type($request)) {
                case Redis::REDIS_STRING:
                    $type = 'String';
                    $value = $redis->get($request);
                    $size = strlen($value);
                    break;

                case Redis::REDIS_SET:
                    $type = 'Set';
                    $value = $redis->sMembers($request);
                    sort($value);
                    $size = count($value);
                    break;

                case Redis::REDIS_LIST:
                    $type = 'List';
                    $value = $redis->get($request);
                    $size = $redis->lLen($request);
                    break;

                case Redis::REDIS_ZSET:
                    $type = 'ZSet';
                    $value = array_map(function($value) use ($redis, $request) {
                        return [
                            'score' => $redis->zScore($request, $value),
                            'value' => $value,
                        ];
                    }, $redis->zRange($request, 0, -1));
                    $size = count($value);
                    break;

                case Redis::REDIS_HASH:
                    $type = 'Hash';
                    $value = $redis->hGetAll($request);
                    ksort($value);
                    $size = count($value);
                    break;

                case Redis::REDIS_NOT_FOUND:
                    $type = 'Not found';
                    $value = $redis->get($request);
                    break;
            }

            exit(json_encode(compact([
                'type',
                'ttl',
                'encoding',
                'refcount',
                'value',
            ]), JSON_PRETTY_PRINT));
        }

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
